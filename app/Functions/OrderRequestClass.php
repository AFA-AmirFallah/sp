<?php


namespace App\Functions;

use App\Models\L3Work;
use App\Models\provinces;
use App\Models\UserInfo;
use App\Models\WorkerSkils;
use App\myappenv;
use DB;
use stdClass;

class OrderRequestClass
{
    private $UserName;
    private $UserInfo = null;

    function __construct($UserName)
    {
        $this->UserName = $UserName;
    }

    public function get_working_zone()
    {
        $RequestUser = $this->UserName;
        $workCat = myappenv::FamilyWorkCat;
        $L1ID = myappenv::FamilyIndexL1;
        $L2ID = myappenv::FamilyIndexL2;
        $Query = "SELECT WorkerSkils.SkilID,L3Work.Name ,L3Work.img ,L3Work.UID  from WorkerSkils INNER JOIN L3Work on WorkerSkils.SkilID = L3Work.UID 
        WHERE L3Work.WorkCat = $workCat and L3Work.L1ID = $L1ID and L3Work.L2ID = $L2ID and  WorkerSkils.UserName = '$RequestUser'";
        $UserSkills = DB::select($Query);
        return $UserSkills;
    }  
    public function GetNewMGTID(){
        if($this->get_data('mgt_1') == null){
            return 1;
        }
        if($this->get_data('mgt_2') == null){
            return 2;
        }
        if($this->get_data('mgt_3') == null){
            return 3;
        }
        if($this->get_data('mgt_4') == null){
            return 4;
        }
        if($this->get_data('mgt_5') == null){
            return 5;
        }
        return 0;
    } 
    public function UploadManagerPic($ManagerID,$PicAddress){
        $UserInfo = $this->GetUserInfo();
        if ($UserInfo->extradata == null) {
            $ExtaData = [];
        } else {
            $ExtaData = json_decode($UserInfo->extradata);
        }
        //   $ExtaData = [];
        //array_push($ExtaData,[$FildName=>$Arr_val]);
        $MgtFild = 'mgt_'.$ManagerID;
        $ExtaData->$MgtFild->mgt_pic = $PicAddress;
        $ExtaData = json_encode($ExtaData);
        $this->UpdateExtraData($ExtaData);
        return true;

    } 
    public function get_sandica_zone()
    {
        $RequestUser = $this->UserName;
        $workCat = myappenv::FamilyWorkCat;
        $L1ID = myappenv::FamilyIndexL1;
        $L2ID = myappenv::FamilySandicaIndexL2;
        $Query = "SELECT WorkerSkils.SkilID,L3Work.Name ,L3Work.img ,L3Work.UID  from WorkerSkils INNER JOIN L3Work on WorkerSkils.SkilID = L3Work.UID 
        WHERE L3Work.WorkCat = $workCat and L3Work.L1ID = $L1ID and L3Work.L2ID = $L2ID and  WorkerSkils.UserName = '$RequestUser'";
        $UserSkills = DB::select($Query);
        return $UserSkills;
    }
    public function RemoveIndex($UID)
    {
        WorkerSkils::where('UserName', $this->UserName)->where('SkilID', $UID)->delete();
        return true;
    }
    public function AddIndex($UID)
    {
        $SearchResult = WorkerSkils::where('UserName', $this->UserName)->where('SkilID', $UID)->first();
        if ($SearchResult != null) {
            return false; // already feild exist in DB
        }
        $TL3WorkSrc = L3Work::where('UID', $UID)->first();
        $TWorkCat = $TL3WorkSrc->WorkCat;
        $TL1ID = $TL3WorkSrc->L1ID;
        $TL2ID = $TL3WorkSrc->L2ID;
        $SingleData = [
            'UserName' => $this->UserName,
            'SkilID' => $UID,
            'WorkCat'=>$TWorkCat,
            'L1ID'=>$TL1ID,
            'L2ID'=>$TL2ID,
            'CreateDate' => now(),
            'Status' => 1,
            'Note' => ""
        ];

        WorkerSkils::create($SingleData);
        return true;
    }
    public function GetUserInfo()
    {
        if ($this->UserInfo == null) {
            //not define yet
            $this->UserInfo = UserInfo::where('UserName', $this->UserName)->first();
        }
        return $this->UserInfo;
    }
    public function get_UserName()
    {
        return $this->UserName;
    }
    private function UpdateExtraData($ExtaData_Json)
    {
        UserInfo::where('UserName', $this->UserName)->update(['extradata' => $ExtaData_Json]);
    }
    public function AddData($FildName, $Arr_val)
    {

        $UserInfo = $this->GetUserInfo();
        if ($UserInfo->extradata == null) {
            $ExtaData = new stdClass();
        } else {
            $ExtaData = json_decode($UserInfo->extradata);
        }
        //   $ExtaData = [];
        //array_push($ExtaData,[$FildName=>$Arr_val]);
        $ExtaData->$FildName = $Arr_val;
        $ExtaData = json_encode($ExtaData);
        $this->UpdateExtraData($ExtaData);
        return true;
    }
    public function get_data($FeildNAme)
    {
        $UserInfo = $this->GetUserInfo();
        if ($UserInfo->extradata == null) {
            $Extra = [];
        } else {
            $Extra = json_decode($UserInfo->extradata);
        }
        if (isset($Extra->$FeildNAme)) {
            $getExtra = $Extra->$FeildNAme;
        } else {
            $getExtra = null;
        }

        return $getExtra;
    }

    public function get_family_index()
    {

        $FamilyIndex = L3Work::where('WorkCat', myappenv::FamilyWorkCat)
            ->where('L1ID', myappenv::FamilyIndexL1)
            ->where('L2ID', myappenv::FamilyIndexL2)->get();
        return $FamilyIndex;
    }
    public function get_family_sandica_index()
    {

        $FamilyIndex = L3Work::where('WorkCat', myappenv::FamilyWorkCat)
            ->where('L1ID', myappenv::FamilyIndexL1)
            ->where('L2ID', myappenv::FamilySandicaIndexL2)->get();
        return $FamilyIndex;
    }
    public function get_Provinces()
    {
        return provinces::all();
    }
    public function SaveBaseInformation($request)
    {
        $DataToSave = [
            'SubTitel' => $request->input('SubTitel'),
            'Titel' => $request->input('Titel'),
            'UpTitel' => $request->input('UpTitel'),
        ];
        return UserInfo::where('UserName', $this->UserName)->update($DataToSave);
    }

}
