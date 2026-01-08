<?php

namespace App\Functions;

use App\APIS\bale;
use App\Http\Controllers\APIS\VOIP;
use App\Models\Calls;
use App\Models\cdr;
use App\Models\UserInfo;
use App\myappenv;
use App\voip\Voip_sync;
use DB;
use Illuminate\Http\Request;

class CallCenterClass
{
    public $UserName;

    public function UserSetter($UserName)
    {
        $this->UserName = $UserName;
    }
    public function get_user_calls_history($UserName = null)
    {
        if ($UserName == null) {
            $UserName = $this->UserName;
        }
        $Query = "SELECT
        C.CallID,
        C.CallerUser,
        C.AnswerUser,
        C.StartTime,
        C.EndTime,
        C.CallDuration,
        C.ExtraInfo,
        C.recloc,
        cUser.Name as CName,
        cUser.Family as CFamily,
        aUser.Name as AName,
        aUser.Family as AFamily
    FROM Calls as C
        left join UserInfo as cUser on cUser.UserName = C.CallerUser
        left join UserInfo as aUser on aUser.UserName = C.AnswerUser
    where
        C.AnswerUser = '$UserName'
        or C.CallerUser = '$UserName'";
        return DB::select($Query);
    }
    private function get_last_sync_date()
    {
        $Query = "SELECT UNIX_TIMESTAMP(MAX(StartTime))  AS max_value FROM Calls";
        $result = DB::select($Query);
        if (!isset($result[0]->max_value)) {
            return '1719526828';
        }
        $max_time = $result[0]->max_value;
        echo (date("Y-m-d H:i:s", $max_time));
        echo '<br>';
        return $max_time;
    }
    private function add_input_call($cdr_item)
    {
        // echo $alert_item->src;
        $sync = new Voip_sync;
        $voip_functions = new VOIP;
        $new_src = $voip_functions->NumberFormater($cdr_item['src']);
        $new_src = $new_src['OutputNumber'];
        $new_dst = $voip_functions->NumberFormater($cdr_item['dst']);
        $new_dst = $new_dst['OutputNumber'];
        $import_data = [
            "calldate" => $cdr_item['calldate'],
            "clid" => $cdr_item['clid'],
            "src" => $new_src,
            "dst" => $new_dst,
            "dcontext" => $cdr_item['dcontext'],
            "channel" => $cdr_item['channel'],
            "dstchannel" => $cdr_item['dstchannel'],
            "lastapp" => $cdr_item['lastapp'],
            "lastdata" => $cdr_item['lastdata'],
            "duration" => $cdr_item['duration'],
            "billsec" => $cdr_item['billsec'],
            "disposition" => $cdr_item['disposition'],
            "amaflags" => $cdr_item['amaflags'],
            "accountcode" => $cdr_item['accountcode'],
            "uniqueid" => $cdr_item['uniqueid'],
            "userfield" => $cdr_item['userfield'],
            "recordingfile" => $sync->record_file_fixer($cdr_item['recordingfile']),
            "cnum" => $cdr_item['cnum'],
            "cnam" => $cdr_item['cnam'],
            "outbound_cnum" => $cdr_item['outbound_cnum'],
            "outbound_cnam" => $cdr_item['outbound_cnam'],
            "dst_cnam" => $cdr_item['dst_cnam'],
            "did" => $cdr_item['did'],
        ];
        $import_src = cdr::create($import_data);
        $bale = new bale;
        $sec = $cdr_item['billsec'];
        $send_description = " *تماس*
        تماس گیرنده: $new_src
        پاسخگو: $new_dst
        مدت تماس: $sec

        ";

        $bale->send_message($send_description);
        return [
            'server_id' => $import_src->id,
            'local_id' => $cdr_item['uniqueid']
        ];
    }
    public function alert_platform(Request $request)
    {
        $response = $request->input('alert', 'null');
        if ($response == 'null') {
            echo json_encode([]);

        }
        $alert_arr = json_decode($response,1);
        $ids_arr = array();
        foreach ($alert_arr as $alert_item) {
            $unique_id = $this->add_input_call($alert_item);
            array_push($ids_arr, $unique_id);

        }
        echo json_encode($ids_arr);
    }
    public function synccalls()
    {
        $TargrtArray = array(
            'func' => 'completecall',
        );

        $last_time = $this->get_last_sync_date();
        echo "last_time = $last_time";
        $CURLOPT_POSTFIELDS = json_encode($TargrtArray);
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://37.156.8.92:6070/cdr.php?start_date=' . $last_time,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 20,
                CURLOPT_TIMEOUT => 10,

                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'get',
                CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Nn6-4itd93jx1kUZobLhqXGUZjMStJXi',
                    'Content-Type: application/json'
                ),
            )
        );
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);
        $OutPut = array();
        $voip = new VOIP;
        $counter = 0;
        if (!empty($response) || is_array($response) || is_object($response)) {
            foreach ($response as $responseItem) {
                $counter++;
                $uniqueid = $responseItem->uniqueid;
                $CallerNumber = $voip->NumberFormater($responseItem->src);
                $CallerNumber = $CallerNumber['OutputNumber'];
                $AnsweredNumber = substr($responseItem->dst, 1);
                $StartTime = $responseItem->calldate;
                $diff_minutes = $responseItem->duration;
                $CallerUser = $voip->who_is_call_username($CallerNumber);
                if ($CallerUser == null) {
                    $CallerUser = 'tofo';
                }
                $AnswerUser = $voip->who_is_call_username($AnsweredNumber);
                if ($AnswerUser == null) {
                    $AnswerUser = 'tofo';
                }
                $CallData = [
                    'CallID' => $uniqueid,
                    'CallerNumber' => $CallerNumber,
                    'AnsweredNumber' => $AnsweredNumber,
                    'CallerUser' => $CallerUser,
                    'AnswerUser' => $AnswerUser,
                    'StartTime' => $StartTime,
                    'EndTime' => $StartTime,
                    'CallType' => 1,
                    'CallPoint' => 0,
                    'CallDuration' => $diff_minutes,
                    'ChannelID' => $uniqueid,
                    'Status' => 1,
                    'recloc' => $uniqueid

                ];
                Calls::create($CallData);
            }

        }
        echo " sync counter => $counter <br>";
        return $counter;
    }
    public function confirmsync($SendArray)
    {
        $Confirmarray = [
            'func' => 'confirmsync',
            'send' => $SendArray
        ];
        $CURLOPT_POSTFIELDS = json_encode($Confirmarray);
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'http://gitlab.kookbaz.ir:1460/api/sync',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Nn6-4itd93jx1kUZobLhqXGUZjMStJXi',
                    'Content-Type: application/json'
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        return ($response);
    }
    public function SyncPhoneNumbers()
    {
        $CallsData = Calls::where('status', 1)->get();
        foreach ($CallsData as $CallDataItem) {
            $CallerNumber = $CallDataItem->CallerNumber;
            $AnsweredNumber = $CallDataItem->AnsweredNumber;
            $CallID = $CallDataItem->CallID;
            $CallerSrc = $this->get_user_by_number($CallerNumber);
            $AnswerSrc = $this->get_user_by_number($AnsweredNumber);
            if (isset($CallerSrc->UserName)) {
                $CallerId = $CallerSrc->UserName;
            } else {
                $CallerId = $CallerSrc;
            }
            if (isset($AnswerSrc->UserName)) {
                $AnswerId = $AnswerSrc->UserName;
            } else {
                $AnswerId = $AnswerSrc;
            }
            $Status = 5;
            if ($AnswerId != '<unkonwn>' && $CallerId != '<unkonwn>') {
                $Status = 100; //complitely find
            } elseif ($AnswerId == '<unkonwn>' && $CallerId != '<unkonwn>') {
                $Status = 2; //answeruser not find
            } elseif ($AnswerId != '<unkonwn>' && $CallerId == '<unkonwn>') {
                $Status = 3; //caller user not find
            } elseif ($AnswerId == '<unkonwn>' && $CallerId == '<unkonwn>') {
                $Status = 4; //complitely not find
            }
            $UpdateData = [
                'CallerUser' => $CallerId,
                'AnswerUser' => $AnswerId,
                'Status' => $Status
            ];
            Calls::where('CallID', $CallID)->update($UpdateData);
        }
    }
    public function get_user_by_number($PhoneNumber)
    {
        $TargetUser = UserInfo::where('MobileNo', $PhoneNumber)->orWhere('Phone1', $PhoneNumber)->orWhere('Phone2', $PhoneNumber)->orWhere('Ext', $PhoneNumber)->first();
        if ($TargetUser != null) {
            return $TargetUser;
        } else {
            return '<unkonwn>';
        }
    }
}
