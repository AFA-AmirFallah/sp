<?php

namespace App\Http\Controllers\Patients;

use AllShiftsTotall;
use App\Functions\AppSetting;
use App\Functions\JobsDone;
use App\Http\Controllers\Controller;
use App\Models\RelatedStaff;
use App\Models\requests;
use App\myappenv;
use App\Functions\TextClass;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Functions\persian;
use App\Functions\TextClassMain;
use App\Models\RespnsType;
use App\Models\UserInfo;
use App\Functions\Transfer;
use DateTime;
use App\APIS\SmsCenter;
use App\Models\AllShiftsTotall as ModelsAllShiftsTotall;
use App\Models\tashim;
use App\Models\UserCredit;
use App\Models\usercreditsummery;
use App\Patient\PatiantServices;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Redirect;

class PatShift extends Controller
{
    public function ShiftOfPat($RequestUser)
    {
        $user_branch = Auth::user()->branch;
        if ($user_branch == myappenv::Branch) {
            $condition = " ";
        } else {
            $condition = " and branch = $user_branch ";
        }
        $customer_role = myappenv::role_customer;
        $Query = "SELECT UserName,Name,Family,MobileNo,Email,Phone1,Phone2,Address,Birthday,CreateDate,Status,UserPass,(SELECT COALESCE(sum(Point),0) as point 
        FROM UserPoint WHERE UserName = '$RequestUser' and ConfirmUser is not null ) FROM UserInfo 
        WHERE Role = $customer_role and UserName = '$RequestUser' $condition";

        $PatInfos = DB::select($Query);
        $PatInfo = null;
        foreach ($PatInfos as $PatInfoIns) {
            $PatInfo = $PatInfoIns;
        }
        if ($PatInfo == null) { // can not find the user
            return abort('404', 'کاربر مورد نظر یافت نشد!');
        }
        $Query = "SELECT UserInfo.Name,UserInfo.Family,RespnsType.RespnsTypeName,COUNT(*) as rowcount FROM UserInfo INNER JOIN RelatedStaff INNER JOIN RespnsType WHERE RespnsType.ID = RelatedStaff.RespnsType and RelatedStaff.DeletedBy is null and  RelatedStaff.ResponserID = UserInfo.UserName and OwnerUserID = '$RequestUser' GROUP BY UserInfo.UserName,UserInfo.Name,UserInfo.Family,RespnsType.RespnsTypeName ORDER BY RelatedStaff.RespnsType";
        $WorkersInfo = DB::select($Query);
        $RespnsTypes = RespnsType::where('branch', $user_branch)->get();
        $Query = "SELECT RelatedStaff.id,RelatedStaff.OwnerUserID, RelatedStaff.ResponserID,UserInfo.Name , UserInfo.Family, RelatedStaff.ContractID, RelatedStaff.CreateDate, RelatedStaff.CreateBy, RelatedStaff.StartRespns, RelatedStaff.EndRespns, RelatedStaff.RespnsType,RespnsType.RespnsTypeName, RelatedStaff.DeletedBy, RelatedStaff.DeletedTime, RelatedStaff.Note ,RelatedStaff.Point,RelatedStaff.Confirmer , (select COUNT(*) from UserCredit
WHERE UserCredit.ReferenceId = RelatedStaff.RelatedCredite and UserCredit.ConfirmBy != '' ) as confirmcredits , RelatedStaff.RelatedCredite  ,RelatedStaff.StartRespns - now() as datedif FROM RelatedStaff INNER JOIN UserInfo on  UserInfo.UserName = RelatedStaff.ResponserID   INNER JOIN RespnsType on  RespnsType.ID = RelatedStaff.RespnsType  where RelatedStaff.OwnerUserID = '$RequestUser' and RelatedStaff.DeletedBy is null
GROUP BY RelatedStaff.id,RelatedStaff.OwnerUserID, RelatedStaff.ResponserID,UserInfo.Name , UserInfo.Family, RelatedStaff.ContractID, RelatedStaff.CreateDate, RelatedStaff.CreateBy, RelatedStaff.StartRespns, RelatedStaff.EndRespns, RelatedStaff.RespnsType,RespnsType.RespnsTypeName, RelatedStaff.DeletedBy, RelatedStaff.DeletedTime, RelatedStaff.Note ,RelatedStaff.Point,RelatedStaff.Confirmer,RelatedStaff.RelatedCredite ORDER BY `RelatedStaff`.`CreateDate` DESC";
        $WorkersListInfo = DB::select($Query);
        $Queryt1 = "SELECT  RelatedStaff.ResponserID,RelatedStaff.RespnsType,RespnsType.RespnsTypeName FROM RelatedStaff INNER JOIN UserInfo INNER JOIN RespnsType where RelatedStaff.OwnerUserID = '$RequestUser' and UserInfo.UserName = RelatedStaff.ResponserID and RespnsType.ID = RelatedStaff.RespnsType and RelatedStaff.DeletedBy is null and RelatedStaff.RespnsType >10000 and EndRespns > now() ";
        $stackHolders = DB::select($Queryt1);
        return view("Patients/PatShift", ['PatInfo' => $PatInfo, 'WorkersInfo' => $WorkersInfo, 'RespnsTypes' => $RespnsTypes, 'WorkersListInfo' => $WorkersListInfo, 'stackHolders' => $stackHolders]);
    }
    private function delete_shift($shift_id)
    {
        $siftSrc = RelatedStaff::where('id', $shift_id)->first();
        if ($siftSrc == null) {
            return abort('404', 'حذف شیفت با خطا مواجه شد');
        }
        $related_credit = $siftSrc->RelatedCredite;

        $Shift_data = [
            'DeletedBy' => Auth::id(),
            'DeletedTime' => now(),
        ];
        RelatedStaff::where('id', $shift_id)->update($Shift_data); //Delete shift
        $confirm_credit = false;
        UserCredit::where('ReferenceId', $related_credit)->delete(); //HACK:UserCredit 
        return redirect()->back()->with("success", __('data has modify'));
    }
    private function get_service_tashim_arr($Service_id)
    {
        $service_src = RespnsType::where('id', $Service_id)->first();
        if ($service_src == null) {
            return [
                'status' => false,
                'msg' => 'سرویس مورد نظر یافت نشد!'
            ];
        }
        $extra = $service_src->extra;
        if ($extra == null) {
            $extra = [];
        } else {
            $extra = json_decode($extra);
        }
        if (isset($extra->tashim)) {
            $tashim_arr = $extra->tashim;
            $data = [];
            $tashim_src = tashim::where('ItemOrder', 0)->get();
            foreach ($tashim_arr as $tashim_arr_item) {
                $target_id = $tashim_arr_item;
                foreach ($tashim_src as $tashim_src_item) {
                    if ($tashim_src_item->id == $target_id) {
                        array_push($data, [
                            'id' => $target_id,
                            'name' => $tashim_src_item->Name
                        ]);
                    }
                }
            }
            return [
                'result' => true,
                'data' => $data
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'تسیهم تعریف نشده!'
            ];
        }
    }

    public function DoShiftOfPat(Request $request, $RequestUser)
    {
        if ($request->ajax()) {
            if ($request->function == 'get_service_tashim') {
                return $this->get_service_tashim_arr($request->service_id);
            }
        }
        $MyPersian = new persian();
        $Holders = null;
        if ($request->input('submit') == 'AddnewStaff') {
            $pat_shift = new PatiantServices;
            return $pat_shift->add_service_to_patient($request, $RequestUser);
        } else {
            if ($request->has('delete_shift')) {
                $Branch = Auth::user()->branch;
                $UserName = Auth::id();
                $nowdate = date('Y-m-d H:i:s');
                if (Auth::user()->Role == myappenv::role_Accounting || Auth::user()->Role == myappenv::role_SuperAdmin) {
                    return  $this->delete_shift($request->delete_shift);
                }
                if (Auth::user()->Role == myappenv::role_admin) {
                    if ($MyArr2[3] != 0 && $MyArr2[3] != null) {
                        $Query = "INSERT INTO UserCreditDelete( UserName, Mony, Type, Date, Note, InvoiceNo, PaymentId, SpecialPaymentId, GateWay, ReferenceId, TransferBy, ConfirmBy,Confirmdate, RealMony, CreditMod,IDcreadit)  SELECT  UserName, Mony, Type, now(), Note, InvoiceNo, PaymentId, SpecialPaymentId, GateWay, '$MyArr2[3]', '$UserName','$UserName',now(), RealMony,CreditMod,ID FROM UserCredit where ConfirmBy is null and  UserCredit.ReferenceId='$MyArr2[3]'   ";
                        DB::insert($Query);
                        $Query2 = "delete from UserCredit WHERE ConfirmBy is null and  UserCredit.ReferenceId='$MyArr2[3]' ";
                        DB::delete($Query2);
                    }
                    $Query1 = "UPDATE RelatedStaff SET DeletedBy='$UserName',DeletedTime='$nowdate' WHERE RelatedStaff.OwnerUserID= '$MyArr2[0]' and RelatedStaff.ResponserID = '$MyArr2[1]' and RelatedStaff.CreateDate = '$MyArr2[2]' ";
                    DB::update($Query1);
                    return redirect()->back()->with("success", __('data has modify'));
                }
            }
            return redirect()->back()->with('error', __("the user name dos not exist"));
        }
    }

    public function PatShiftDone()
    {
        if (Auth::user()->Role >= myappenv::role_admin) {
            $user_branch = Auth::user()->branch;
            if (myappenv::Branch == $user_branch) {
                $query_condition = '';
            } else {
                $query_condition = " and UserInfo.branch = $user_branch ";
            }
            $Role = 'Admin';
            $Query = "SELECT 
SiftwithTransfer.EndNote, 
SiftwithTransfer.service_id, 
SiftwithTransfer.OwnerUserID, 
SiftwithTransfer.OwnerName, 
SiftwithTransfer.OwnerFamily, 
SiftwithTransfer.ResponserID, 
SiftwithTransfer.ResponserName, 
SiftwithTransfer.ResponserFamily, 
SiftwithTransfer.ContractID, 
SiftwithTransfer.CreateDate, 
SiftwithTransfer.CreateBy, 
UserInfo.Name as UserInfoName, 
UserInfo.Family as UserInfoFamily, 
SiftwithTransfer.StartRespns, 
SiftwithTransfer.EndRespns, 
SiftwithTransfer.RespnsType, 
SiftwithTransfer.RespnsTypeName, 
SiftwithTransfer.DeletedBy, 
SiftwithTransfer.DeletedTime, 
SiftwithTransfer.Note, 
sum(SiftwithTransfer.Mony) as Mony, 
SiftwithTransfer.CrediteDate, 
SiftwithTransfer.RelatedCredite 
FROM 
SiftwithTransfer 
inner join UserInfo on SiftwithTransfer.CreateBy = UserInfo.UserName 
inner join RelatedStaff on SiftwithTransfer.service_id = RelatedStaff.id 
$query_condition
WHERE 
SiftwithTransfer.EndRespns < now() 
and SiftwithTransfer.DeletedBy is null 
and SiftwithTransfer.Mony < 0 
GROUP BY 
SiftwithTransfer.EndNote, 
SiftwithTransfer.service_id, 
SiftwithTransfer.OwnerUserID, 
SiftwithTransfer.OwnerName, 
SiftwithTransfer.OwnerFamily, 
SiftwithTransfer.ResponserID, 
SiftwithTransfer.ResponserName, 
SiftwithTransfer.ResponserFamily, 
SiftwithTransfer.ContractID, 
SiftwithTransfer.CreateDate, 
SiftwithTransfer.CreateBy, 
UserInfo.Name, 
UserInfo.Family, 
SiftwithTransfer.StartRespns, 
SiftwithTransfer.EndRespns, 
SiftwithTransfer.RespnsType, 
SiftwithTransfer.RespnsTypeName, 
SiftwithTransfer.DeletedBy, 
SiftwithTransfer.DeletedTime, 
SiftwithTransfer.Note, 
SiftwithTransfer.CrediteDate, 
SiftwithTransfer.RelatedCredite 
ORDER BY 
StartRespns desc";

            $TodoShifts = DB::select($Query);
        } elseif (Auth::user()->Role == myappenv::role_worker) {
            $Role = 'Worker';
            $UserName = Auth::id();
            $TodoShifts = ModelsAllShiftsTotall::all()->where('ResponserID', $UserName);
        } elseif (Auth::user()->Role == myappenv::role_customer) {
            $user_branch = Auth::user()->branch;
            if (myappenv::Branch == $user_branch) {
                $query_condition = '';
            } else {
                $query_condition = " and UserInfo.branch = $user_branch ";
            }
            $Role = 'Customer';
            $Query = "SELECT SiftwithTransfer.OwnerUserID, SiftwithTransfer.OwnerName, SiftwithTransfer.OwnerFamily, SiftwithTransfer.ResponserID, 
            SiftwithTransfer.ResponserName, SiftwithTransfer.ResponserFamily, SiftwithTransfer.ContractID, SiftwithTransfer.CreateDate, SiftwithTransfer.CreateBy,UserInfo.Name as UserInfoName , UserInfo.Family as UserInfoFamily, SiftwithTransfer.StartRespns, SiftwithTransfer.EndRespns, SiftwithTransfer.RespnsType, SiftwithTransfer.RespnsTypeName, SiftwithTransfer.DeletedBy, SiftwithTransfer.DeletedTime, SiftwithTransfer.Note, sum(SiftwithTransfer.Mony) as Mony , SiftwithTransfer.CreditNote, SiftwithTransfer.CrediteDate, SiftwithTransfer.RelatedCredite
            FROM SiftwithTransfer inner join  UserInfo 
            on SiftwithTransfer.CreateBy = UserInfo.UserName $query_condition
            WHERE EndRespns < now() and DeletedBy is null
            GROUP BY SiftwithTransfer.OwnerUserID, SiftwithTransfer.OwnerName, SiftwithTransfer.OwnerFamily, SiftwithTransfer.ResponserID, SiftwithTransfer.ResponserName, SiftwithTransfer.ResponserFamily, SiftwithTransfer.ContractID, SiftwithTransfer.CreateDate, SiftwithTransfer.CreateBy,UserInfo.Name  , UserInfo.Family , SiftwithTransfer.StartRespns, SiftwithTransfer.EndRespns, SiftwithTransfer.RespnsType, SiftwithTransfer.RespnsTypeName, SiftwithTransfer.DeletedBy, SiftwithTransfer.DeletedTime, SiftwithTransfer.Note,  SiftwithTransfer.CreditNote, SiftwithTransfer.CrediteDate ORDER BY StartRespns desc ";
            $UserName = Auth::id();
            $Query = "SELECT RelatedStaff.* ,RespnsType.RespnsTypeName , worker.Name as ResponserName , worker.Family as ResponserFamily , 
            worker.avatar as workeravatar FROM RelatedStaff INNER JOIN RespnsType on RelatedStaff.RespnsType = RespnsType.id INNER JOIN UserInfo as worker on worker.UserName = RelatedStaff.ResponserID WHERE RelatedStaff.OwnerUserID = '$UserName'";

            $TodoShifts = DB::select($Query);
        } else {
            return abort('403', 'دسترسی غیر مجاز');
        }

        return view("Patients.PatShiftDone", ['Role' => $Role, 'TodoShifts' => $TodoShifts]);
    }

    private function ShiftDoneWithoutPrice($UserMony, $WorkPoint, $RequestUser, $ResponserID, $nowdate)
    {
        $UpdateData = [
            'Confirmer' => Auth::id(),
            'Price' => $UserMony,
            'Point' => $WorkPoint
        ];
        $result = RelatedStaff::where('OwnerUserID', $RequestUser)->where('ResponserID', $ResponserID)->where('CreateDate', $nowdate)->update($UpdateData);
        return $result;
    }

    public function DoPatShiftDone(Request $request)
    {
        if ($request->has('submit')) {
            if (Auth::user()->Role == myappenv::role_customer) {
                $Service_id = $request->serviceid;
                $OwnerUserID = Auth::id();
                $service_src = RelatedStaff::where('id', $Service_id)->where('OwnerUserID', $OwnerUserID)->first();
                if ($service_src == null) {
                    return abort('404', 'خدمت درخواست شده در سامانه موجود نیست!');
                }
                if ($service_src->EndNote != '') {
                    return abort('404', 'خدمت درخواست شده قابل ویرایش نیست!');
                }
                $EndNote['customer_note'] = [
                    'result' => $request->submit,
                    'MessageText' => $request->MessageText
                ];
                $EndNote = json_encode($EndNote);
                RelatedStaff::where('id', $Service_id)->where('OwnerUserID', $OwnerUserID)->update(['EndNote' => $EndNote]);
                return Redirect()->back()->with('success', 'نظر شما در سامانه ثبت شد. با تشکر از همکاری شما');
            }
            $OwnerUserID = $request->input('OwnerUserID');
            $ResponserID = $request->input('ResponserID');
            $CreateDate = $request->input('CreateDate');
            $Query = "SELECT OwnerUserID,  ResponserID,  CreateDate, UserCreditID,Mony FROM SiftwithTransfer
WHERE OwnerUserID = '$OwnerUserID' and  ResponserID = '$ResponserID' and CreateDate = '$CreateDate' ";
            $result = DB::select($Query);
            foreach ($result as $ResultItem) {
                $WorkInfo = $ResultItem;
            }
            $RequestUser = $WorkInfo->OwnerUserID;
            $ResponserID = $WorkInfo->ResponserID;
            $nowdate = $WorkInfo->CreateDate;
            $UserCreditID = $WorkInfo->UserCreditID;
            $UserMony = $WorkInfo->Mony;
            $UserName = Auth::id();
            $WorkPoint = $request->input('submit');
            if (\App\myappenv::Lic['HCIS_Workflow']) {
                $MyWorkFlow = new Workflow();
                $WorkFlowText = 'انجام شیفت<br>';
                $Responder = UserInfo::where('UserName', $ResponserID)->first();
                $WorkFlowText .= '<h6> توسط: ' . $Responder->Name . ' ' . $Responder->Family . '</h6>';
                $MyDate = new persian();
                $WorkFlowText .= 'تاریخ ثبت: ' .  $MyDate->MyPersianDate($CreateDate, true);
                $MyWorkFlow->AddWorkFlow($OwnerUserID, Auth::id(), $WorkFlowText);
            }

            if ($request->input('submit') == '100') {
                $this->ShiftDoneWithoutPrice($UserMony, $WorkPoint, $RequestUser, $ResponserID, $nowdate);
            } else {
                $WorksFinish = new JobsDone($RequestUser, $ResponserID, $nowdate, $UserName, $UserMony);
                if ($WorksFinish->DoFinshWorks($WorkPoint)) {
                    return redirect()->back()->with('success', __("success alert"));
                }
            }
        }
    }
}
