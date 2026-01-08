<?php

namespace App\Http\Controllers\APIS;

use App\APIS\SmsCenter;
use App\Users\UserClass;
use App\Http\Controllers\Controller;
use App\Models\UserInfo;
use App\myappenv;
use App\Models\metadata;

class SMSSender extends Controller
{
    private function NumberFormating($InputNumer)
    {
        /* $voip = new VOIP();
        $NumberFomater = $voip->NumberFormater($InputNumer);
        $Type = $NumberFomater['inputType'];
        $NumberFomater = $NumberFomater['OutputNumber'];

        echo $InputNumer . " : ali$NumberFomater - hasan$Type : "; */
        $Len = strlen($InputNumer);
        if ($Len < 11) {
            $InputNumer = '0' . $InputNumer;
            $Len = strlen($InputNumer);
            if ($Len == 11) {
                return $InputNumer;
            } else {
                return false;
            }
        }
        if ($Len > 11) {
            if (substr($InputNumer, 0, 2) == '98') {
                $InputNumer = str_replace(substr($InputNumer, 0, 2), '0', $InputNumer);
            }
            return $InputNumer;
        }
        if ($Len = 11) {
            return $InputNumer;
        }
    }

    private function validateMeliIDid($MeliID)
    {
        if (!preg_match('/^[0-9]{10}$/', $MeliID)) {
            return false;
        }

        for ($i = 0; $i < 10; $i++) {
            if (preg_match('/^' . $i . '{10}$/', $MeliID)) {
                return false;
            }
        }

        for ($i = 0, $sum = 0; $i < 9; $i++) {
            $sum += ((10 - $i) * intval(substr($MeliID, $i, 1)));
        }

        $ret = $sum % 11;
        $parity = intval(substr($MeliID, 9, 1));
        if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity)) {
            return $MeliID;
        }

        return false;
    }
    private function CheckUser($UserData)
    {
        $MobileNo = $UserData['MobileNo'];
        $MeliID = $UserData['MeliID'];
        $UserResult = UserInfo::where('MobileNo', $MobileNo)->orWhere('UserName', $MobileNo)->get();

        if ($UserResult->count() > 0) {
            $UserResult = $UserResult[0];

            if ($UserResult->MelliID == null) {
                $UserResult = UserInfo::where('MobileNo', $MobileNo)->orWhere('UserName', $MobileNo)->update(['MelliID' => $MeliID]);
                $CenterName = myappenv::CenterName;
                $MessageText = " از تماس شما متشکریم،اطلاعات درخواست شما با موفقیت ثبت شد
                ";
                $MessageText .= "طرح اقساطی: https://kookbaz.ir/RegisterForm/12";
            } else {
                $CenterName = myappenv::CenterName;
                //Todo: کد ملی شما از قبل در سامانه ثبت شده است از تماس شما متشکریم
                $MessageText = "  .از تماس شما متشکریم،کد ملی شما از قبل در سامانه ثبت شده است";
                $MessageText .= " طرح اقساطی:https://kookbaz.ir/RegisterForm/12 ";
            }
        } else {
            $MyUser = new UserClass();
            $Result = $MyUser->AddUserwithmelliid($MobileNo, $MobileNo, myappenv::DefaultVoipUser_Name, myappenv::DefaultVoipUser_Family, $MeliID, $MobileNo, $MobileNo . "@nomail.com", myappenv::role_customer, myappenv::Default_customer_Status);
            $CenterName = myappenv::CenterName;
            $MessageText = "
            از تماس شما متشکریم، ثبت نام شما در سایت انجام شد لطفا برای تکمیل اطلاعات خود به سامانه کوکباز مراجعه کنید
        ";

            $MessageText .= "طرح اقساطی: https://kookbaz.ir/RegisterForm/12";
        }
        $MySMS = new SmsCenter();
        $MySMS->OndemandSMS($MessageText, $MobileNo, 'tnks', $MobileNo);
    }
    public function MainSend()
    {
        $UserResult = $this->othersidecall();
        $CehckedID = array();
        if (!empty($UserResult) || is_array($UserResult) || is_object($UserResult)) {
            foreach ($UserResult as $UserResultItem) {
                $MeliID = $UserResultItem->CodeMelli;
                $MobileNo = $UserResultItem->Mobile;
                $MobileNo = $this->NumberFormating($MobileNo);
                $ValidMeliID = $this->validateMeliIDid($MeliID);

                if ($MobileNo && $ValidMeliID) {
                    $UserData = [
                        'MobileNo' => $MobileNo,
                        'MeliID' => $ValidMeliID,
                    ];
                    $checkuser = $this->CheckUser($UserData);
                } else {
                    $InvalidData = [
                        'MobileNo' => $MobileNo,
                        'MeliID' => $MeliID,
                    ];
                    $meta_value = json_encode($InvalidData);
                    $InvalidData = [
                        'tt' => 'UserInfo',
                        'meta_key' => 'RejectUser',
                        'meta_value' => $meta_value
                    ];
                    metadata::create($InvalidData);
                }
                array_push($CehckedID, $UserResultItem->Id);
            }
            $this->SyncOtherSide($CehckedID);

            dd('stop');
        }
    }

    private function othersidecall()
    {
        $TargrtArray = array(
            'func' => 'codemellitbl',
        );

        $CURLOPT_POSTFIELDS = json_encode($TargrtArray);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://gitlab.kookbaz.ir:1460/api/sync?func=codemellitbl',
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
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        return $response;
    }
    private function SyncOtherSide(array $IDArr)
    {
        $IDJson = json_encode($IDArr);
        $TargrtArray = array(
            'func' => 'syncmelliid',
            'IDJson' => $IDJson,
        );

        $CURLOPT_POSTFIELDS = json_encode($TargrtArray);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://gitlab.kookbaz.ir:1460/api/sync',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 20,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'post',
            CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Nn6-4itd93jx1kUZobLhqXGUZjMStJXi',
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        dd($response);
        $response = json_decode($response);
        dd($IDArr);
    }
}
