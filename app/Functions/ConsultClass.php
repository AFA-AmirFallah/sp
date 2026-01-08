<?php

namespace App\Functions;

use App\consulting\consulting_info;
use App\Models\L1Work;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\my_calls;
use App\Models\UserInfo;
use App\Models\UserWithSkillsView;
use App\Models\WorkerSkils;
use App\myappenv;
use Illuminate\Support\Facades\DB;
use Throwable;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * ConsultClass
 *
 * این کلاس برای عملیات کلی مشاوره استفاده می شود
 *
 *
 *
 * workcat => consult Workcat
 *
 * L1 =>connsult cats => پرشکی - روانشناسی - حقوقی
 *
 *
 * L2 =>counsult Zone => پرشکان متخصص
 *
 *
 * L3 =>counsult Aria =>  متخصص گوش و حلق و بینی
 *
 *
 */

class ConsultClass
{
    private function add_call_log($DistinationPhone, $extra_info)
    {
        $answer_src = UserInfo::where('MobileNo', $DistinationPhone)->orWhere('Phone1', $DistinationPhone)->orWhere('Phone2', $DistinationPhone)->orWhere('Ext', $DistinationPhone)->first();
        if ($answer_src != null) {
            $answer_src = $answer_src->UserName;
        }
        $log_data = [
            'caller' => Auth::id(),
            'call_number' => $DistinationPhone,
            'answer_username' => $answer_src,
            'deal' => $extra_info['deal'] ?? null,
            'sms_text' => $extra_info['sms_text'] ?? null
        ];
        my_calls::create($log_data);
        return true;
    }
    public function BothSideCall($SourcePhone, $DistinationPhone, $extra_info = [])
    {
        $this->add_call_log($DistinationPhone, $extra_info);
        if (myappenv::MainOwner == 'Ohp') {
            // $url = 'https://192.168.147.5/autodial.php?type=mobileToMobile&phone1=09123936105&phone2=09192228284';
            $url = "https://93.118.112.174:1360/autodial.php?type=mobileToMobile&phone1=$SourcePhone&phone2=$DistinationPhone";
            $url = "http://94.182.192.240:60660/automobile.php?phone1=$SourcePhone&phone2=$DistinationPhone";
            //   $url = "http://79.127.58.250:60660/automobile.php?phone1=$SourcePhone&phone2=$DistinationPhone";
        } else {
            $url = myappenv::voip_sever . "/automobile.php?phone1=$SourcePhone&phone2=$DistinationPhone";
        }


        try {
            $ch = curl_init();
            // Check if initialization had gone wrong*
            if ($ch === false) {
                throw new Exception('failed to initialize');
            }
            // Better to explicitly set URL
            curl_setopt($ch, CURLOPT_URL, $url);
            // That needs to be set; content will spill to STDOUT otherwise
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // Set more options
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $content = curl_exec($ch);
            // Check the return value of curl_exec(), too
            if ($content === false) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
            // Check HTTP return code, too; might be something else than 200
            $httpReturnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


            return ($httpReturnCode);

            /* Process $content here */
        } catch (Exception $e) {
            trigger_error(
                sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(),
                    $e->getMessage()
                ),
                E_USER_ERROR
            );
        } finally {
            // Close curl handle unless it failed to initialize
            if (is_resource($ch)) {
                curl_close($ch);
            }
        }
    }

    public $ConsultIndex = myappenv::ConsultIndex;

    /**
     * Undocumented function
     *
     * @param [type] $WorkerUserName
     * @param [type] $WorkerExt
     * @return void
     */
    public function get_worker_working_cats($WorkerUserName, $WorkerExt)
    {
        if ($WorkerUserName == null) {
            $UserInfo = UserInfo::where('Ext', $WorkerExt)->first();
            if ($UserInfo == null) {
                return false;
            }
            $WorkerUserName = $UserInfo->UserName;
        }
        $Query = "SELECT WorkerSkils.UserName,WorkerSkils.SkilID,WorkerSkils.Status,L3Work.Name,RespnsType.* FROM WorkerSkils 
        INNER JOIN L3Work  on WorkerSkils.SkilID = L3Work.UID 
        INNER JOIN RespnsType on WorkerSkils.SkilID = RespnsType.MainIndex where  WorkerSkils.UserName =  '$WorkerUserName'";
        return DB::select($Query);
    }

    public function get_type_of_indexing()
    {
        if ($this->ConsultIndex['L1Work'] == 0) {
            return 'WC';
        }
        if ($this->ConsultIndex['L2Work'] == 0) {
            return 'L1';
        }
        if ($this->ConsultIndex['L3Work'] == 0) {
            return 'L2';
        }
    }


    /**
     * this function for use all index layers
     *
     * @return void
     */
    private function get_consult_cat_from_workcat()
    {
        $consult_info = new consulting_info;
        $key_arr = [
            'WorkCat' => $this->ConsultIndex['WorkCat']
        ];
        $consult_info->update_index_extra_data('WorkCat', $key_arr);
        $L1_src = L1Work::where('WorkCat', $this->ConsultIndex['WorkCat'])->get();
        return $L1_src;
    }
    private function get_consult_cat_from_L1()
    {
        $consult_info = new consulting_info;
        $key_arr = [
            'WorkCat' => $this->ConsultIndex['WorkCat'],
            'L1ID' => $this->ConsultIndex['L1Work']
        ];
        $consult_info->update_index_extra_data('L2Work', $key_arr);
        return L2Work::where('WorkCat', $this->ConsultIndex['WorkCat'])->where('L1ID', $this->ConsultIndex['L1Work'])->get();
    }
    private function get_consult_cat_from_L2()
    {
        $consult_info = new consulting_info;
        $key_arr = [
            'WorkCat' => $this->ConsultIndex['WorkCat'],
            'L1ID' => $this->ConsultIndex['L1Work'],
            'L2ID' => $this->ConsultIndex['L2Work']
        ];
        $consult_info->update_index_extra_data('L3Work', $key_arr);
        return L3Work::where('WorkCat', $this->ConsultIndex['WorkCat'])->where('L1ID', $this->ConsultIndex['L1Work'])->where('L2ID', $this->ConsultIndex['L2Work'])->get();
    }


    /**
     * This function use to return all counsult category
     *
     * @return void
     */
    public function get_consulting_cats()
    {
        $type_of_indexing = $this->get_type_of_indexing();
        if ($type_of_indexing == 'WC') {
            return $this->get_consult_cat_from_workcat();
        } elseif ($type_of_indexing == 'L1') {
            return $this->get_consult_cat_from_L1();
        } elseif ($type_of_indexing == 'L2') {
            return $this->get_consult_cat_from_L2();
        }
    }

    /**
     * This functtion return all Zones Info
     *
     * @param [type] $CatID
     * @return void
     */
    public function get_consulting_Zone($CatID)
    {
        $consult_info = new consulting_info;
        $key_arr = [
            'WorkCat' => $this->ConsultIndex['WorkCat'],
            'L1ID' => $CatID
        ];
        $consult_info->update_index_extra_data('L2Work', $key_arr);
        return L2Work::where('WorkCat', $this->ConsultIndex['WorkCat'])->where('L1ID', $CatID)->get();
    }

    /**
     * this function return aria Info
     *
     * number of users
     * Some users Info
     *
     * @param [type] $CatID
     * @param [type] $ZoneID
     * @return void
     */
    public function get_consulting_Aria($CatID, $ZoneID)
    {
        $consult_info = new consulting_info;
        $key_arr = [
            'WorkCat' => $this->ConsultIndex['WorkCat'],
            'L1ID' => $CatID,
            'L2ID' => $ZoneID
        ];
        $consult_info->update_index_extra_data('L3Work', $key_arr);
        $Output = array();
        $MainL3 = L3Work::where('WorkCat', $this->ConsultIndex['WorkCat'])->where('L1ID', $CatID)->where('L2ID', $ZoneID)->get();
        return $MainL3;
        foreach ($MainL3 as $L3Item) {
            $TargetUID = $L3Item->UID;
            $WorkerSkill = WorkerSkils::where('SkilID', $TargetUID)->get();
            $ArrItem = [
                'L3' => $L3Item,
                'WorkerSkill' => $WorkerSkill
            ];
            array_push($Output, $ArrItem);
        }
        return ($Output);
    }
    public function get_consulter_info($ConsulterId)
    {
        $UserInfo = UserInfo::where('Ext', $ConsulterId)->first();
        if ($UserInfo == null) {
            return false;
        }

        return $UserInfo;
    }
    public function get_extra_Fild($ExtraData, $FildName)
    {
        try {
            $ExtraData = json_decode($ExtraData);
            return $ExtraData->$FildName;
        } catch (Throwable $e) {
            return false;
        }
    }
    public function is_user_active($UserName)
    {
        $Entrance = new Entrance();
        return $Entrance->isuseronline($UserName);
    }
    public function get_l3_info($UID)
    {
        return L3Work::where('UID', $UID)->first();
    }
    public function get_cunsultent_in_one_aria($UID)
    {
        return UserWithSkillsView::whereNotNull('Ext')->where('SkilID', $UID)->get();
    }
    public function get_serach_consult($ConsulterName)
    {
        $query = "SELECT  Ext , Name , Family ,UserName ,Address , avatar from user_with_skills_view    WHERE   CONCAT(Name, ' ', Family) like '%$ConsulterName%' group by Ext , Name , Family ,UserName ,Address , avatar ";
        return DB::select($query);
        //return UserWithSkillsView::whereNotNull('Ext')->where('Name', 'LIKE', "%{$ConsulterName}%")->orwhere('Family', 'LIKE', "%{$ConsulterName}%")->get();
    }
    public function get_up_layers_form_l3($UID, $TargetLayerName)
    {
        $TargetL3Src = L3Work::where('UID', $UID)->first();
        if ($TargetL3Src == null) {
            return false;
        }
        if ($TargetLayerName == 'L2') {
            return L2Work::where('WorkCat', $TargetL3Src->WorkCat)->where('L1ID', $TargetL3Src->L1ID)->where('L2ID', $TargetL3Src->L2ID)->get();
        }
        if ($TargetLayerName == 'L3') {
            return L3Work::where('WorkCat', $TargetL3Src->WorkCat)->where('L1ID', $TargetL3Src->L1ID)->where('L2ID', $TargetL3Src->L2ID)->get();
        }
    }
}
