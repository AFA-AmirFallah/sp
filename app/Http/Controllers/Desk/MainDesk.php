<?php

namespace App\Http\Controllers\Desk;

use App\Http\Controllers\Controller;
use App\Models\metadesk;
use Illuminate\Http\Request;
use App\Models\UserRole;
use App\Functions\Indexes;
use App\Models\L3Work;
use DB;
use Session;
use Auth;
use App\Models\UserInfo;
use App\myappenv;
use App\APIS\SmsCenter;
use App\Functions\ConsultClass;
use App\Models\TicketMain;

use PhpParser\Node\Stmt\Return_;

use function Psy\info;

class MainDesk extends Controller
{
    public function get_sessions()
    {
        $Output = [];
        if (Session::has('tempuserlist')) {
            array_push($Output, ['لیست کاربران موقت', 'tempuserlist']);
        }
        return $Output;
    }
    public function get_notifications()
    {
        $Query = "SELECT n.*,ui.Name , ui.Family from notifications n inner join UserInfo ui on n.TargetUser  = ui.UserName  WHERE  n.status < 100";
        $Notificaions = DB::select($Query);
        return $Notificaions;
    }
    public function getIndexTree()
    {
        $MyIndex = new Indexes();
        $IndexTree = $MyIndex->HTMLTreeIndex();
        return $IndexTree;
    }
    public function DeskMain()
    {
        //  dd( $this->get_my_projects());
        if (Auth::user()->Role == myappenv::role_callcenter) {
            return view('Desk.DeskCallCenter', ['Desk' => $this]);
        } else {
            return view('Desk.DeskAdmin', ['Desk' => $this]);
        }
    }
    public function get_projects($ProjectID = null)
    {
        if ($ProjectID == null) {
            return metadesk::where('tt', 'project')->where('meta_key', 'project')->get();
        } else {
            return metadesk::where('tt', 'project')->where('meta_key', 'project')->where('id', $ProjectID)->first();
        }
    }
    public function get_project_Info($ProjectID, $MetaKey)
    {
        $result = metadesk::where('tt', 'ProjectInfo')->where('meta_key', $MetaKey)->where('fgint', $ProjectID)->get();
        return $result;
    }
    public function MakeProject(Request $request)
    {
        $meta_value = [
            "subject" => $request->subject,
            "desc" => $request->desc,
            "data" => $request->ce,
        ];
        $meta_value = json_encode($meta_value);
        $history = [
            'UserName' => Auth::id(),
            'activity' => 'create',
            'date' => date('Y-m-d H:i:s'),
        ];
        $history = json_encode($history);
        $ProjectData = [
            'desk' => 1,
            'UserName' => Auth::id(),
            'tt' => 'project',
            'meta_key' => 'project',
            'meta_value' => $meta_value,
            'history' => $history,
            'status' => 1
        ];
        metadesk::create($ProjectData);
        return redirect()->back()->with('success', 'پروژه تولید شد!');
    }
    private function SubmitIndex(Request $request)
    {
        $indexId =  $request->indexId;
        $meta_key = $request->target;
        $ProjectID = $request->ProjectID;
        $IndexSrc = L3Work::where('UID', $indexId)->first();

        $meta_value = [
            'valtype' => 'index',
            'UID' => $IndexSrc->UID,
            'WorkCat' => $IndexSrc->WorkCat,
            'L1ID' => $IndexSrc->L1ID,
            'L2ID' => $IndexSrc->L2ID,
            'L3ID' => $IndexSrc->L3ID,
            'Name' => $IndexSrc->Name
        ];

        $meta_value = json_encode($meta_value);

        $history = [
            'UserName' => Auth::id(),
            'activity' => 'create',
            'date' => date('Y-m-d H:i:s'),
        ];
        $history = json_encode($history);
        $MetaTableData = [
            'tt' => 'ProjectInfo',
            'desk' => 1,
            'UserName' => Auth::id(),
            'meta_key' => $meta_key,
            'fgint' => $ProjectID,
            'history' => $history,
            'meta_value' => $meta_value,
            'status' => 1
        ];
        metadesk::create($MetaTableData);
        $this->MakeIndexListUsers($indexId, $meta_key, $ProjectID);
        return $IndexSrc->Name;
    }
    /**
     * Undocumented function
     *
     * @param integer $ProjectID
     * @param integer $TeamID   0 = Target Team  and 1 = Project_Team
     * @return Array
     */
    public function get_Project_team_UserList($ProjectID, int $TeamID)
    {
        if ($TeamID == 0) {
            $meta_key = 'TargetTeamUserList';
        } else {
            $meta_key = 'ProjectTeamUserList';
        }

        $Result = metadesk::where('tt', 'ProjectInfo')->where('fgint', $ProjectID)->where('meta_key', $meta_key)->first();
        if ($Result == null) {
            return [];
        } else {
            return json_decode($Result->meta_value);
        }
    }

    public function MakeIndexListUsers($UID, $meta_key, $ProjectID)
    {
        $Query = "SELECT ui.UserName ,ui.Name ,ui.Family ,ui.Ext ,NULL as ActionHistory ,null as ActionOwner,0 as Fstatus FROM WorkerSkils as ws INNER JOIN UserInfo as ui on ws.UserName = ui.UserName where ws.SkilID = $UID";
        $ResultSrc = DB::select($Query);
        $history = [
            'UserName' => Auth::id(),
            'activity' => 'create',
            'date' => date('Y-m-d H:i:s'),
        ];
        $history = json_encode($history);
        $meta_value = json_encode($ResultSrc);
        $MetaTableData = [
            'tt' => 'ProjectInfo',
            'desk' => 1,
            'UserName' => Auth::id(),
            'meta_key' => $meta_key . 'UserList',
            'fgint' => $ProjectID,
            'history' => $history,
            'meta_value' => $meta_value,
            'status' => 1
        ];
        metadesk::create($MetaTableData);
        return true;
    }
    private function UpdateTargetTeamUserList($OwnerID, $TargetUserId, $ProjectID)
    {
        $OwnerSrc = UserInfo::where('UserName', $OwnerID)->first();

        $Result = metadesk::where('tt', 'ProjectInfo')->where('fgint', $ProjectID)->get();
        foreach ($Result as $ResultItem) {
            if ($ResultItem->meta_key == 'TargetTeamUserList') {
                $TargetTeamUserList = $ResultItem->meta_value;
                $TargetTeamUserList = json_decode($TargetTeamUserList);
            }
            if ($ResultItem->meta_key == 'ProjectTeamUserList') {
                $ProjectTeamUserList = $ResultItem->meta_value;
                $ProjectTeamUserList = json_decode($ProjectTeamUserList);
            }
        }
        foreach ($TargetTeamUserList as $Aindex => $ArrItem) {
            if ($ArrItem->UserName == $TargetUserId) {
                $TargetTeamUserList[$Aindex]->ActionOwner = $OwnerID;
                $TargetTeamUserList[$Aindex]->ActionOwnerName = $OwnerSrc->Name;
                $TargetTeamUserList[$Aindex]->ActionOwnerFamily = $OwnerSrc->Family;
                $TargetTeamUserList[$Aindex]->Fstatus = 1;
                if ($TargetTeamUserList[$Aindex]->ActionHistory == null) {
                    $OldVal = '';
                } else {
                    $OldVal = $TargetTeamUserList[$Aindex]->ActionHistory;
                }
                $TargetTeamUserList[$Aindex]->ActionHistory = $OldVal . '<br> add owner : ' . $OwnerID . ' ' . $OwnerSrc->Name . ' ' . $OwnerSrc->Family;
            }
        }
        $meta_value = json_encode($TargetTeamUserList);

        metadesk::where('tt', 'ProjectInfo')->where('fgint', $ProjectID)->where('meta_key', 'TargetTeamUserList')->update(['meta_value' => $meta_value]);


        return  $OwnerSrc->Name . ' ' . $OwnerSrc->Family;;
    }
    private function AddProjectToOwner($OwnerID, $TargetUserId, $ProjectID, $OwnerName)
    {
        $TargetUserSrc = UserInfo::where('UserName', $TargetUserId)->first();
        $meta_value = [
            'OwnerName' => $OwnerName,
            'TargetName' => $TargetUserSrc->Name . ' ' . $TargetUserSrc->Family
        ];
        $meta_value = json_encode($meta_value);
        $history = [
            'UserName' => Auth::id(),
            'activity' => 'create',
            'date' => date('Y-m-d H:i:s'),
        ];
        $history = json_encode($history);
        $ProjectData = [
            'desk' => 1,
            'UserName' => $OwnerID,
            'fgstr' => $TargetUserId,
            'fgint' => $ProjectID,
            'tt' => 'ProjectInfo',
            'meta_key' => 'Assignment',
            'meta_value' => $meta_value,
            'history' => $history,
            'status' => 1
        ];
        metadesk::create($ProjectData);
    }
    private function AssignJobToPerson($OwnerID, $TargetUserId, $ProjectID)
    {
        $result = $this->UpdateTargetTeamUserList($OwnerID, $TargetUserId, $ProjectID);
        $this->AddProjectToOwner($OwnerID, $TargetUserId, $ProjectID, $result);
        return $result;
    }
    private function get_my_order()
    {
        $MyId = Auth::id();
        $Query = "SELECT po.*, ui.Name  as customername , ui.Family as customerfamily 
        from product_orders po inner join UserInfo ui on po.CustomerId  = ui.UserName
         WHERE po.status > 0 AND po.status  < 100  and po.Operator = '$MyId' ORDER BY po.id DESC";


        return DB::select($Query);
    }
    public function get_my_projects()
    {
        $UserName = Auth::id();
        if (Auth::user()->Role == myappenv::role_callcenter) {
            $Query = " SELECT * from metadesks as metamain where metamain.id =  (SELECT fgint from metadesks as md where md.id = (SELECT
            mp.id
        FROM metadesks as mp
            INNER JOIN metadesks as mm on mp.fgint = mm.id and mp.tt = 'ProjectInfo' and mp.meta_key = 'Assignment' and mp.UserName = '$UserName' GROUP by mp.fgint));
        ";
        } else {
            $Query = "SELECT mp.* , mm.meta_value as projectinfo FROM metadesks as mp INNER JOIN metadesks as mm on mp.fgint = mm.id and mp.tt= 'ProjectInfo' and mp.meta_key =  'Assignment' and mp.UserName = '$UserName'";
        }
        $result = DB::select($Query);
        return $result;
    }
    private function getmymarkinglink()
    {
        $EXT = Auth::user()->Ext;
        $LinkAddress = route('home') . "?MC=$EXT";
        return $LinkAddress;
    }
    private function get_my_users()
    {
        //todo: marketer
        $MyUserName = Auth::id();
        $Query = "SELECT ui.UserName , ui.Name , ui.Family ,ui.MobileNo , ui.CreateDate
        ,sum( IFNULL(po.num_items_sold,0)) as totallitems , sum(IFNULL(po.total_sales,0)) as totallbuy,count(po.id) as invoices
         from UserInfo as ui left JOIN product_orders as po 
        on ui.UserName = po.CustomerId and po.status > 0  AND po.status != 60  and po.id = po.DeviceContract where ui.MarketingCode = '$MyUserName'   
GROUP BY ui.UserName , ui.Name , ui.Family ,ui.MobileNo ,ui.CreateDate ";
        return DB::select($Query);
    }
    private function LoadAssingenment($TargetUserExt, $OwnerUserName, $ProjectID)
    {
        $UserInfo = UserInfo::where('Ext', $TargetUserExt)->first();
        $TargetUserName = $UserInfo->UserName;
        $metadesk = metadesk::where('tt', 'ProjectInfo')->where('fgint', $ProjectID)->where('meta_key', 'Assignment')->where('UserName', $OwnerUserName)->where('fgstr', $TargetUserName)->first();
        if ($metadesk != null) {
            $result = json_decode($metadesk->meta_value);
            $result->KeyId = $metadesk->id;
        }
        return $result;
    }

    private function update_meta_value($FildName, $FildValue, $MeataValue)
    {
        $meta_value = json_decode($MeataValue);
        if (!property_exists($meta_value, $FildName)) {
            $smsdata = [];
        } else {
            $smsdata = json_decode($meta_value->$FildName);
        }
        array_push($smsdata, $FildValue);
        $smsdata = json_encode($smsdata);
        $meta_value->$FildName = $smsdata;
        $meta_value = json_encode($meta_value);
        return $meta_value;
    }
    public function SendSMS($TargetUserExt, $DeskId, $SMStext)
    {
        $MySMS = new SmsCenter();
        $UserInfo = UserInfo::where('Ext', $TargetUserExt)->first();
        $MySMS->OndemandSMS($SMStext, $UserInfo->MobileNo, '', Auth::id());
        $metadesk = metadesk::where('id', $DeskId)->first();
        $SMStext = [
            'SMSDate' => date('Y-m-d  H:i:s'),
            'SendBy' => Auth::user()->Name . ' ' . Auth::user()->Family,
            'Text' => $SMStext
        ];
        $meta_value = $metadesk->meta_value;
        $meta_value = $this->update_meta_value("sms", $SMStext, $meta_value);
        $metadesk = metadesk::where('id', $DeskId)->update(['meta_value' => $meta_value]);
        return 'پیامک ارسال گردید!';
    }
    public function DoCall($TargetUserExt, $DeskId, $device)
    {
        $Call = new ConsultClass();
        $UserInfo = UserInfo::where('Ext', $TargetUserExt)->first();
        $Call->BothSideCall($device, $UserInfo->MobileNo);
        $CallInfo = [
            'CallDate' => date('Y-m-d  H:i:s'),
            'CallBy' => Auth::user()->Name . ' ' . Auth::user()->Family,
            'CallerPhone' => $device,
        ];
        $metadesk = metadesk::where('id', $DeskId)->first();
        $meta_value = $metadesk->meta_value;
        $meta_value = $this->update_meta_value("call", $CallInfo, $meta_value);
        $metadesk = metadesk::where('id', $DeskId)->update(['meta_value' => $meta_value]);
        return 'درخواست تماس ارسال شد!';
    }
    private function savereport($reportSubject, $reporttext, $DeskId)
    {
        $Report = [
            'ReportDate' => date('Y-m-d  H:i:s'),
            'Createby' => Auth::user()->Name . ' ' . Auth::user()->Family,
            'reportSubject' => $reportSubject,
            'ReportText' => $reporttext,
        ];
        $metadesk = metadesk::where('id', $DeskId)->first();
        $meta_value = $metadesk->meta_value;
        $meta_value = $this->update_meta_value("report", $Report, $meta_value);
        $metadesk = metadesk::where('id', $DeskId)->update(['meta_value' => $meta_value]);
        return 'گزارش ثبت شد!';
    }
    private function EditUser($TargetUserExt,$UserAttr)
    {
        $UserInfo = UserInfo::where('Ext', $TargetUserExt)->update($UserAttr);
        return 'اطلاعات کاربر با موفقیت ویرایش شد';
    }
    private function ShowMessage($TargetUserExt)
    {

        $UserInfo = UserInfo::where('Ext', $TargetUserExt)->first();
        $metadesk = metadesk::where('fgstr', $UserInfo->UserName)->first();
        if ($metadesk != null) {
            $result = json_decode($metadesk->meta_value);
            return json_decode($result->sms);
        }
    }
    private function ShowCall($TargetUserExt)
    {

        $UserInfo = UserInfo::where('Ext', $TargetUserExt)->first();
        $metadesk = metadesk::where('fgstr', $UserInfo->UserName)->first();
        if ($metadesk != null) {
            $result = json_decode($metadesk->meta_value);
            return json_decode($result->call);
        }
    }
    private function ShowReport($TargetUserExt)
    {

        $UserInfo = UserInfo::where('Ext', $TargetUserExt)->first();
        $metadesk = metadesk::where('fgstr', $UserInfo->UserName)->first();
        if ($metadesk != null) {
            $result = json_decode($metadesk->meta_value);
            return json_decode($result->report);
        }
    }
    private function ShowTicket()
    {
        $UserName = Auth::id();
        $Tickets = TicketMain::where('FromUser', $UserName)->orwhere('UserName', $UserName)->get();
        return $Tickets;
        
    }


    public function DoDeskMain(Request $request)
    {
        if ($request->ajax()) {
            if ($request->func == 'ShowTicket') {
                return $this->ShowTicket();
            }
            if ($request->func == 'MessageLoad') {
                $GoTargetUserExt = $request->GolTargetUserExt;
                return $this->ShowMessage($GoTargetUserExt);
            }
            if ($request->func == 'CallLoad') {
                $GoTargetUserExt = $request->GolTargetUserExt;
                return $this->ShowCall($GoTargetUserExt);
            }
            if ($request->func == 'ReportLoad') {
                $GoTargetUserExt = $request->GolTargetUserExt;
                return $this->ShowReport($GoTargetUserExt);
            }
            if ($request->func == 'UserEdit') {
                $GoTargetUserExt = $request->GolTargetUserExt;
                $UserAttr = [
                    'Name' => $request->Name,
                    'Family' => $request->Family,
                    'Email' => $request->Email,
                    'Birthday' => $request->Birthday,
                    'Address' => $request->Address,
                    'Address2' => $request->Address2,
                    'fathername' => $request->fathername,
                    'MelliID' => $request->MelliID,
                    

                ];
                return $this->EditUser($GoTargetUserExt ,$UserAttr);
            }
            if ($request->func == 'UserLoad') {
                $GolTargetUserExt = $request->GolTargetUserExt;
                $UserInfo = UserInfo::where('Ext', $GolTargetUserExt)->first();
                return $UserInfo;
            }
            if ($request->func == 'savereport') {
                $reporttext = $request->reporttext;
                $ProjectID = $request->ProjectID;
                $GolFeildID = $request->GolFeildID;
                $reportSubject = 'گزارش کار';
                return $this->savereport($reportSubject, $reporttext, $GolFeildID);
            }
            if ($request->func == 'DoCall') {
                $TargetUserExt = $request->TargetUserExt;
                $device = $request->device;
                $ProjectID = $request->ProjectID;
                $GolFeildID = $request->GolFeildID;
                return $this->DoCall($TargetUserExt, $GolFeildID, $device);
            }
            if ($request->func == 'SendSMS') {
                $TargetUserExt = $request->TargetUserExt;
                $SMStext = $request->SMStext;
                $ProjectID = $request->ProjectID;
                $GolFeildID = $request->GolFeildID;
                return $this->sendSMS($TargetUserExt, $GolFeildID, $SMStext);
            }
            if ($request->func == 'loadtarget') {
                $TargetUserExt = $request->TargetUserExt;
                $OwnerUserName = $request->OwnerUserName;
                $ProjectID = $request->ProjectID;
                return $this->LoadAssingenment($TargetUserExt, $OwnerUserName, $ProjectID);
            }
            if ($request->func == 'loadRoles') {
                return UserRole::all();
            }
            if ($request->func == 'getmymarkinglink') {
                return $this->getmymarkinglink();
            }
            if ($request->func == 'get_my_users') {
                return $this->get_my_users();
            }
            if ($request->func == 'sumitIndex') {
                return $this->SubmitIndex($request);
            }
            if ($request->func == 'workassign') {
                $ProjectID = $request->ProjectID;
                return view('Desk.Objects.ProjectAssign', ['Desk' => $this, 'ProjectID' => $ProjectID])->render();
            }
            if ($request->func == 'assignwork') {
                $ProjectID = $request->ProjectID;
                return $this->AssignJobToPerson($request->Owner, $request->UserName, $ProjectID);
            }
            if ($request->func == 'get_notifications') {
                return $this->get_notifications();
            }
            if ($request->func == 'get_project') {
                return $this->get_projects();
            }
            if ($request->func == 'get_my_order') {
                return $this->get_my_order();
            }
            if ($request->func == 'get_my_projects') {
                return $this->get_my_projects();
            }
            if ($request->func == 'my_project') {
                $ProjectID = $request->ProjectID;
                return $this->get_my_project($ProjectID);
            }
            if ($request->func == 'loadproject') {
                $ProjectID = $request->ProjectID;
                if (Auth::user()->Role == myappenv::role_callcenter) {
                    return view('Desk.Objects.ProjectDetialShow', ['Desk' => $this, 'ProjectID' => $ProjectID])->render();
                } else {
                    return view('Desk.Objects.ProjectDetial', ['Desk' => $this, 'ProjectID' => $ProjectID])->render();
                }
            }
        }
        if ($request->has('DeleteList')) {
            Session::forget($request->DeleteList);
            return redirect()->back()->with('success', 'لیست موقت مورد نظر حذف گردید!');
        }
        if ($request->has('submit')) {
            if ($request->submit == 'makeProject') {
                //TODO: user role validation
                return $this->MakeProject($request);
            }
        }
    }
    private function get_my_project($ProjectID)
    {
        return view('Desk.Objects.MyProject', ['Desk' => $this, 'ProjectID' => $ProjectID])->render();
    }
}
