<?php

namespace App\Http\Controllers\Credit;

use App\APIS\SmsCenter;
use App\Functions\AppSetting;
use App\Functions\Financial;
use App\Functions\persian;
use App\Functions\ShafatelPayClass;
use App\Functions\TextClassMain;
use App\Users\UserClass;
use App\Http\Controllers\Controller;
use App\Models\DeviceContract;
use App\Models\UserCredit;
use App\Models\UserCreditIndex;
use App\Models\UserCreditModMeta;
use App\Models\UserInfo;
use App\myappenv;
use App\Shop\rent;
use DB;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Predis\Command\Redis\DBSIZE;

class CreditTransfer extends Controller
{
    public function AsnadMali()
    {
        return view('Credit.AsnadMali', ['Result' => null]);
    }
    public function DoAsnadMali(Request $request)
    {
        $MyPersian = new persian();
        $Condition = '';
        if ($request->input('SanadID') != null) {
            $Condition .= ' and  uc.Id = ' . $request->input('SanadID');
        }
        if ($request->input('StartDate') != null) {
            $TargetDate = $MyPersian->MiladiDate($request->input('StartDate'));
            $Condition .= " and  uc.Date >=  '$TargetDate' ";
        }
        if ($request->input('EndDate') != null) {
            $TargetDate = $MyPersian->MiladiDate($request->input('EndDate'));
            $Condition .= " and  uc.Date <=  '$TargetDate' ";
        }
        $Query = "SELECT * FROM UserCredit as uc WHERE uc.ID = uc.ReferenceId $Condition";
        $Result = DB::select($Query);
        return view('Credit.AsnadMali', ['Result' => $Result]);
    }

    /**
     * CahngeTransaction
     * this function use to change transaction 
     *
     * @param  mixed $request
     * @return void
     */
    public function CahngeTransaction(Request $request)
    {
        $user_barnch = Auth::user()->branch;
        if ($user_barnch == myappenv::Branch) {
            $query_condition = '';
        } else {
            $query_condition = " and ui.branch = $user_barnch";
        }

        if ($request->ajax()) {
            $CreditId = $request->input('ConfirmId');
            $result =  $this->settleCDP($CreditId, Auth::id());
            if ($result) {
                return 'عملیات انجام شد';
            } else {
                return 'عملیات با مشکل مواجه شد';
            }
        }
        $Query = "SELECT uc.UserName,ui.Name,ui.Family,SUM(uc.Mony) as sum 
        FROM `UserCredit` as uc left JOIN UserInfo as ui on uc.UserName = ui.UserName
        where Type = 36  $query_condition
        GROUP by uc.UserName,ui.Name,ui.Family";
        $creditRefrnce = DB::select($Query);
        return view('Credit.ChangeTransaction', ['creditRefrnce' => $creditRefrnce, 'Type' => 'search', 'SourceCredits' => null]);
    }
    private function settleCDP($CreditId, $Confirmer)
    {


        $creditRefrnceCDP = UserCredit::where('type', myappenv::casheirCredittype)->where('ID', $CreditId)->first();
        if ($creditRefrnceCDP == null) {
            return false; // not found credit
        }
        if ($creditRefrnceCDP->ZeroRefrenceID != null) {
            return false; // already has zero refrence
        }
        $UpdateData = [
            'UserName' => $creditRefrnceCDP->UserName,
            'Mony' => $creditRefrnceCDP->Money * -1,
            'Type' => $creditRefrnceCDP->Type,
            'Date' => now(),
            'Note' => $creditRefrnceCDP->Note . 'تسویه ',
            'TransferBy' =>  $Confirmer,
            'ConfirmBy' => $Confirmer,
            'InvoiceNo' => $creditRefrnceCDP->InvoiceNo,
            'GateWay' => $creditRefrnceCDP->GateWay,
            'Confirmdate' => now(),
            'branch' => $creditRefrnceCDP->branch,
            'ZeroRefrenceID' => $creditRefrnceCDP->ID,
            'ReferenceId' => $creditRefrnceCDP->ReferenceId,

        ];
        UserCredit::create($UpdateData);
        UserCredit::where('ID', $creditRefrnceCDP->ID)->update(['ZeroRefrenceID' => $creditRefrnceCDP->ID]);
        return true;
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function DoCahngeTransaction(Request $request)
    {
        $user_barnch = Auth::user()->branch;
        if ($user_barnch == myappenv::Branch) {
            $query_condition = '';
        } else {
            $query_condition = " and UI.branch = $user_barnch";
        }

        if ($request->has('submit')) {
            $condition = false;
            if ($request->input('submit') == 'single') {
                $SingleTransactionCode = $request->input('SingleTransactionCode');
                if (is_numeric($SingleTransactionCode)) {
                    if ($SingleTransactionCode > 0) {
                        $condition = true;
                    }
                }
                if ($condition) {
                    $CredeteMods = UserCreditModMeta::all();
                    $Query = "SELECT
                    UC.ID,
                    UC.Mony,
                    UC.ReferenceId,
                    UC.Note , UI.Name ,UI.Family ,CM.ModName , UC.Confirmdate
                  from
                    `UserCredit` as UC
                    INNER JOIN `UserCreditModMeta` as CM on UC.CreditMod = CM.ID
                    INNER JOIN `UserInfo` as UI on UC.UserName = UI.UserName
                    WHERE
                    UC.ConfirmBy is not NULL  and  UC.ID = $SingleTransactionCode $query_condition";
                    $SourceCredits = DB::select($Query);
                    if ($SourceCredits != []) {
                        return view('Credit.ChangeTransaction', ['Type' => 'single', 'CredeteMods' => $CredeteMods, 'SourceCredits' => $SourceCredits]);
                    } else {
                        return redirect()->back()->with('error', 'کد تراکنش موجود نمی باشد!');
                    }
                } else {
                    return redirect()->back()->with('error', 'کد تراکنش صحیح نمی باشد!');
                }
            } elseif ($request->input('submit') == 'refrence') {
                $RefrenceTransactionCode = $request->input('RefrenceTransactionCode');
                if (is_numeric($RefrenceTransactionCode)) {
                    if ($RefrenceTransactionCode > 0) {
                        $condition = true;
                    }
                }
                if ($condition) {
                    $CredeteMods = UserCreditModMeta::all();
                    $Query = "SELECT
                    UC.ID,
                    UC.Mony,
                    UC.ReferenceId,
                    UC.Note , UI.Name ,UI.Family ,CM.ModName , UC.Confirmdate
                  from
                    `UserCredit` as UC
                    INNER JOIN `UserCreditModMeta` as CM on UC.CreditMod = CM.ID
                    INNER JOIN `UserInfo` as UI on UC.UserName = UI.UserName
                    WHERE
                    UC.ConfirmBy is not NULL  and  UC.ReferenceId = $RefrenceTransactionCode $query_condition";
                    $SourceCredits = DB::select($Query);
                    if ($SourceCredits != []) {
                        return view('Credit.ChangeTransaction', ['RefrenceTransactionCode' => $RefrenceTransactionCode, 'Type' => 'refrence', 'CredeteMods' => $CredeteMods, 'SourceCredits' => $SourceCredits]);
                    } else {
                        return redirect()->back()->with('error', 'کد تراکنش موجود نمی باشد!');
                    }
                } else {
                    return redirect()->back()->with('error', 'کد مرجع تراکنش صحیح نمی باشد!');
                }
            } elseif ($request->input('submit') == 'SingleChange') { //single transaction change
                $Persian = new persian();
                $NowDate = $Persian->MyPersianNow();
                $ToChange = $request->input('CrediteCahngeMode');
                $Mods = UserCreditModMeta::where('ID', $ToChange)->first();
                $notesAdd = '  در تاریخ ' . $NowDate . ' تغییر تراکنش توسط:  ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' به وضعیت:  ' . $Mods->ModName . ' ' . $request->input('ChangeNote');
                $UpdateData = [
                    'CreditMod' => $ToChange,
                    'Note' => DB::raw("CONCAT(Note, '" . $notesAdd . "')"),
                ];
                UserCredit::where('ID', $request->input('TransactionID'))->update($UpdateData);
                return redirect()->back()->with('success', 'تراکنش شماره :' . $request->input('TransactionID') . ' به تراکنش ' . $Mods->ModName . ' تغییر وضعیت پیدا کرد ');
            } elseif ($request->input('submit') == 'RefrenceChange') {
                $Persian = new persian();
                $NowDate = $Persian->MyPersianNow();
                $ToChange = $request->input('CrediteCahngeMode');
                $Mods = UserCreditModMeta::where('ID', $ToChange)->first();
                $notesAdd = '  در تاریخ ' . $NowDate . ' تغییر تراکنش توسط:  ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' به وضعیت:  ' . $Mods->ModName . ' ' . $request->input('ChangeNote');
                $UpdateData = [
                    'CreditMod' => $ToChange,
                    'Note' => DB::raw("CONCAT(Note, '" . $notesAdd . "')"),
                ];
                UserCredit::where('ReferenceId', $request->input('TransactionID'))->update($UpdateData);
                return redirect()->back()->with('success', 'تراکنش با کد مرجع شماره :' . $request->input('TransactionID') . ' به تراکنش ' . $Mods->ModName . ' تغییر وضعیت پیدا کرد ');
            } elseif ($request->input('submit') == 'CDP') {
                $Query = "SELECT uc.UserName,ui.Name,ui.Family,SUM(uc.Mony) as sum FROM `UserCredit` as uc left JOIN UserInfo as ui on uc.UserName = ui.UserName where Type = 36 GROUP by uc.UserName";
                $creditRefrnce = DB::select($Query);

                return view('Credit.ChangeTransaction', ['Type' => 'CDP', 'creditRefrnce' => $creditRefrnce]);
            } elseif ($request->input('submit') == 'ConfirmCDP') {
                $creditRefrnceCDP = UserCredit::where('type', myappenv::casheirCredittype)->where('ZeroRefrenceID', null)->get();

                return view('Credit.ChangeTransaction', ['Type' => 'confirmList', 'creditRefrnce' => $creditRefrnceCDP]);
            }
        }
        if ($request->has('Confirm')) {
            $creditRefrnceCDP = UserCredit::where('type', myappenv::casheirCredittype)->where('ZeroRefrenceID', null)->where('UserName', $request->input('Confirm'))->get();
            return view('Credit.ChangeTransaction', ['Type' => 'confirmList', 'creditRefrnceCDP' => $creditRefrnceCDP]);
        }
        if ($request->has('ConfirmCDP')) {
            $result =  $this->settleCDP($request->input('ConfirmCDP'), Auth::id());
            if ($result) {
                return redirect()->back()->with('success', 'عملیات انجام گرفت');
            } else {
                return redirect()->back()->with('error', 'عملیات انجام نگرفت');
            }
        }
        if ($request->has('deleteCDP')) {
        }
    }



    public function SmartInvoice_BeyanehPay($InvoiceNumber)
    {
        // sms to customer to pay other part of invoice
        $DeviceContract = DeviceContract::where('ContractID', $InvoiceNumber)->first();
        $UserInfo = UserInfo::where('UserName', $DeviceContract->Owner)->first();
        $Name = $UserInfo->Name;
        $Familly = $UserInfo->Family;
        $Subject = $DeviceContract->Note;
        $link = url('/') . '/Invoice/' . $InvoiceNumber . 'SI';
        $SMStext = "شفاتل زنجیره تامین سلامت ";
        $SMStext .= "مشتری گرامی $Name $Familly بیعانه صورت حساب شماره $InvoiceNumber با موضوع $Subject با موفقیت پرداخت گردید جهت تسویه حساب از لینک زیر استفاده نمایید. " . $link . " با تشکر از اعتماد شما. ";
        $MySMS = new SmsCenter();
        $MySMS->OndemandSMS($SMStext, $UserInfo->MobileNo, 'Credit Transfer', $DeviceContract->Owner);
        // sms to provider to alert job is active
        //TODO: handle this part
        return true;
    }
    public function SmartInvoice_TasviyehPay($InvoiceNumber)
    {

        //sms to customer to tanks

        // sms to povider to jobs done

        // transfer mony to provider uncache
        $Query = "SELECT DeviceContract.CreditRefrence , branches.UserName , DeviceItemExternal.OwnerPrice , branches.id as branchesid ,	DeviceMeta.DeviceName as metaname,
        DeviceType.DeviceName as typename ,DeviceItemExternal.Price - DeviceItemExternal.OwnerPrice as DaramadPrice from DeviceItemExternal inner join branches  on DeviceItemExternal.Owner =  branches.id INNER JOIN DeviceContract on DeviceContract.ContractID  = DeviceItemExternal.ContractNumber INNER JOIN
DeviceMeta on
	DeviceMeta.ID = DeviceItemExternal.DeviceMeta
inner join DeviceType on
	DeviceType.TypeID = DeviceItemExternal.DeviceModel
	and DeviceType.MetaID = DeviceItemExternal.DeviceMeta
WHERE DeviceItemExternal.ContractNumber = $InvoiceNumber";
        $Items = DB::select($Query);
        foreach ($Items as $Item) {
            $CreditRefrence = $Item->CreditRefrence;
            $CrediteData = [ //owner
                'UserName' => $Item->UserName,
                'Mony' => $Item->OwnerPrice,
                'Type' => 7,
                'Date' => now(),
                'Note' => 'قرارداد شماره: ' . $InvoiceNumber . ' بابت آیتم: ' . $Item->metaname . ' ' . $Item->typename,
                'ReferenceId' => $CreditRefrence,
                'TransferBy' => 'system',
                'ConfirmBy' => 'system',
                'Confirmdate' => now(),
                'GateWay' => "pay",
                'InvoiceNo' => $InvoiceNumber,
                'CreditMod' => myappenv::UnaccessCredit,
                'branch' => $Item->branchesid,
            ];
            UserCredit::create($CrediteData);
            $CrediteData = [ //Dranad
                'UserName' => myappenv::StackHolder,
                'Mony' => $Item->DaramadPrice,
                'Type' => 7,
                'Date' => now(),
                'Note' => 'قرارداد شماره: ' . $InvoiceNumber . ' بابت آیتم: ' . $Item->metaname . ' ' . $Item->typename,
                'ReferenceId' => $CreditRefrence,
                'TransferBy' => 'system',
                'ConfirmBy' => 'system',
                'Confirmdate' => now(),
                'GateWay' => "pay",
                'InvoiceNo' => $InvoiceNumber,
                'CreditMod' => myappenv::CachCredit,
                'branch' => myappenv::Branch,
            ];
            UserCredit::create($CrediteData);
        }

        // sms to provider to transfer done and wating to approve
    }
    public function MyTransfersReport()
    {

        
  /*      if (Auth::user()->Role >= myappenv::role_SuperAdmin) {
            $Query = "SELECT * FROM un_ziro_credits";
            $zero_ref_src = DB::select($Query);
            return view("Credit.zeroTransfers", ["zero_ref_src" => $zero_ref_src]);
        }*/



        $UserName = Auth::id();
        $user_branch = Auth::user()->branch;
        $Query = "SELECT  UserCredit.ID,UserCredit.Note as Note,RespnsType.RespnsTypeName,RelatedStaff.OwnerUserID ,OwnerUserInfo.Name as OwnerUserInfoName,OwnerUserInfo.Family as OwnerUserInfoFamily,RelatedStaff.ResponserID ,ResponserUserInfo.Name as ResponserUserInfoName,ResponserUserInfo.Family as ResponserUserInfoFamily,RelatedStaff.StartRespns,RelatedStaff.EndRespns, UserCredit.ReferenceId,UserCredit.UserName,RelatedStaff.CreateBy,byUserInfo.Name as byUserInfoName,byUserInfo.Family as byUserInfoFamily, (UserCredit.Mony)*-1 as Mony
FROM  RelatedStaff  inner JOIN UserCredit on UserCredit.ReferenceId=RelatedStaff.RelatedCredite
INNER JOIN RespnsType on RespnsType.ID=RelatedStaff.RespnsType
INNER JOIN UserInfo as OwnerUserInfo on OwnerUserInfo.UserName=RelatedStaff.OwnerUserID
INNER JOIN UserInfo as ResponserUserInfo on ResponserUserInfo.UserName=RelatedStaff.ResponserID
INNER JOIN UserInfo as byUserInfo on byUserInfo.UserName=RelatedStaff.CreateBy
WHERE TransferBy = '$UserName'
GROUP BY UserCredit.ID,UserCredit.Note, UserCredit.ID,byUserInfo.Name,byUserInfo.Family,RespnsType.RespnsTypeName,RelatedStaff.OwnerUserID ,OwnerUserInfo.Name,OwnerUserInfo.Family,RelatedStaff.ResponserID ,RelatedStaff.StartRespns,RelatedStaff.EndRespns,ResponserUserInfo.Name,ResponserUserInfo.Family, UserCredit.ReferenceId,UserCredit.UserName,RelatedStaff.CreateBy,UserCredit.Mony ORDER BY UserCredit.Date  DESC";
        $ServiceCredits = DB::select($Query);
        if (Auth::user()->Role >= myappenv::role_Accounting) {
            $condition = "UserCredit.UserName is not null ";
            $showOperation = true;
        } else {
            $condition = "(TransferBy = '$UserName' or UserCredit.UserName = '$UserName' )   ";
            $showOperation = false;
            if (Auth::user()->Role == myappenv::role_customer) {
                $condition .= " and ConfirmBy is not null";
            }
        }
        if ($user_branch != myappenv::Branch) {
            $condition .= " and UserCredit.branch = $user_branch";
        }
        $Query = "SELECT UserCredit.UserName, UserCredit.Mony,UserCredit.Note,UserCredit.TransferBy,byUserInfo.Name as byUserInfoName , byUserInfo.Family as byUserInfoFamily, UserCredit.Date as UserCreditDate ,UserCreditModMeta.ModName ,CONCAT(UserInfo.name,' ',UserInfo.Family ) as name ,UserCredit.ID ,UserCredit.RealMony,UserCredit.Type,UserCredit.ReferenceId ,UserCredit.ConfirmBy
FROM UserCredit inner join UserCreditModMeta  on  UserCredit.CreditMod = UserCreditModMeta.ID inner join UserInfo on UserCredit.UserName = UserInfo.UserName
INNER JOIN UserInfo as byUserInfo on byUserInfo.UserName=UserCredit.TransferBy
WHERE $condition
GROUP by UserCredit.ConfirmBy,UserCredit.UserName,byUserInfo.Family,byUserInfo.Name, UserCredit.Mony,UserCredit.Note,UserCredit.TransferBy,UserCredit.Date,UserCreditModMeta.ModName ,UserInfo.name,UserInfo.Family ,UserCredit.ID ,UserCredit.RealMony,UserCredit.Type,UserCredit.ReferenceId ORDER BY UserCredit.Date  DESC";
        $RequestedCredits = DB::select($Query);
        return view("Credit.MyTransfersReport", ["ServiceCredits" => $ServiceCredits, 'RequestedCredits' => $RequestedCredits, 'showOperation' => $showOperation]);
    }

    public function DoMyTransfersReport(Request $request)
    {
        if ($request->has('DeleteTransaction')) {
            $targetTransaction = $request->input('DeleteTransaction');
            $TargetTransactionSorce = UserCredit::where('ID', $request->input('DeleteTransaction'))->first();
            if ($TargetTransactionSorce->ConfirmBy == null || $TargetTransactionSorce->ConfirmBy == '') {
                UserCredit::where('ID', $request->input('DeleteTransaction'))->delete(); //HACK:UserCredit 
                return redirect()->back()->with('success', __("success alert"));
            } else {
                return redirect()->back()->with('error', __('The transaction is not permition to delete'));
            }
        }
    }

    public function CrediteTransferConfirm()
    {
        $user_barnch = Auth::user()->branch;
        $UserName = Auth::id();
        if (Auth::user()->Role < myappenv::role_Accounting) {
            $extra_query = " and  UserCredit.TransferBy = '$UserName'";
        } else {
            $extra_query = '';
        }

        $mySetting = new AppSetting();
        $sort = $mySetting->GetSettingValue('MaliSort');
        $Query = "SELECT
    UserCredit.UserName, UserCredit.CreditMod,
    UserCredit.Mony,
    UserCredit.RealMony,
    UserCredit.Note,
    CONCAT(requestuser.name,' ',requestuser.Family) AS TransferBy,
    UserCredit.Date,
    UserCreditModMeta.ModName,
    CONCAT(UserInfo.name,' ',UserInfo.Family) AS name,
    UserCredit.ID,
    UserCredit.RealMony,
    UserCreditIndex.IndexName as indexname,
    UserCredit.Type,
    UserCredit.ReferenceId
FROM UserCredit
JOIN UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID
JOIN UserInfo on UserCredit.UserName = UserInfo.UserName
JOIN UserInfo as requestuser on UserCredit.TransferBy = requestuser.UserName
left join UserCreditIndex on UserCreditIndex.IndexID = UserCredit.CreditIndex
WHERE (ConfirmBy = '' or ConfirmBy is null) AND  UserCredit.ReferenceId IS NULL and UserCredit.branch = $user_barnch $extra_query
ORDER BY  UserCredit.ID  $sort";
        $Credites = DB::select($Query);
        $bill_query = "SELECT 
        UserCredit.UserName, 
        UserCredit.CreditMod,UserCredit.bill,
        UserCredit.Mony, 
        UserCredit.RealMony, 
        UserCredit.Note, 
        CONCAT(
            requestuser.name, ' ', requestuser.Family
        ) AS TransferBy, 
        UserCredit.Date, 
        UserCreditModMeta.ModName, 
        CONCAT(
            UserInfo.name, ' ', UserInfo.Family
        ) AS name, 
        UserCredit.ID, 
        UserCredit.RealMony, 
        UserCreditIndex.IndexName as indexname, 
        UserCredit.Type, 
        UserCredit.ReferenceId 
    FROM 
        UserCredit 
        JOIN UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID 
        JOIN UserInfo on UserCredit.UserName = UserInfo.UserName 
        JOIN UserInfo as requestuser on UserCredit.TransferBy = requestuser.UserName 
        left join UserCreditIndex on UserCreditIndex.IndexID = UserCredit.CreditIndex 
    WHERE 
        (
            UserCredit.ConfirmBy = '' 
            or UserCredit.ConfirmBy IS null
        ) 
        and UserCredit.branch = 1 and UserCredit.bill is not null and UserCredit.ReferenceId = UserCredit.ID
    ORDER BY 
        UserCredit.ID";
        $bill_src = DB::select($bill_query);
        return view('Credit.RequestList', ['Credites' => $Credites, 'bill_src' => $bill_src]);
    }

    public function DoCrediteTransferConfirm(Request $request)
    {
        if ($request->has('delete_rent')) {
            $my_rent = new rent;
            $delete_result = $my_rent->delete_rent_permanent(Auth::id(), $request->delete_rent);
            if ($delete_result['result']) {
                return redirect()->back()->with('suceess', 'عملیات موفق');
            } else {
                return redirect()->back()->with('error', $delete_result['msg']);
            }
        }
        if ($request->has('Confirm')) {
            if (Auth::user()->Role < myappenv::role_Accounting) {
                return redirect()->back()->with('error', 'شما مجوز تایید تراکنش را ندارید!');
            }

            $UpdateData = [
                'ConfirmBy' => Auth::id(),
                'Confirmdate' => now(),
            ];
            $Result = UserCredit::where('ID', $request->input('Confirm'))->where('Confirmdate', null)->update($UpdateData);
            if ($Result == 1) {
                $mycredit = new Financial();
                $TargetTransaction = UserCredit::where('ID', $request->input('Confirm'))->first();
                $mySetting = new AppSetting();
                $TransactionSendSMS = $mySetting->GetSettingValue('TransactionSendSMS');
                if ($TransactionSendSMS == 'true') {
                    $mycredit->TransactionReminders($TargetTransaction->UserName, $TargetTransaction->Mony, $TargetTransaction->CreditMod);
                }
                return redirect()->back()->with('success', __("Transaction done!"));
            } else {
                return redirect()->back()->with('error', __("The error has accure in your requsest please try again or call to callcenter!"));
            }
        }
        if ($request->has('delete')) {
            $Result = UserCredit::where('ID', $request->input('delete'))->where('Confirmdate', null)->delete(); //HACK:UserCredit 
            if ($Result == 1) {
                return redirect()->back()->with('success', __("Transaction done!"));
            } else {
                return redirect()->back()->with('error', __("The error has accure in your requsest please try again or call to callcenter!"));
            }
        }
    }

    public function CrediteTransferConfirmsrv(bool $unconfirm = true, array $user_attr = [])
    {
        $branch = Auth::user()->branch;
        if ($unconfirm) {
            $unconfirm_query = 'and UserCredit.ConfirmBy is null';
            $Condition_query = "RespnsType.branch = $branch";
        } else {
            $target_user = $user_attr['target_user'];
            $unconfirm_query = " and UserCredit.UserName = '$target_user' ";
            $Condition_query = $user_attr['user_type'] . ".UserName = '$target_user' ";
        }

        $mySetting = new AppSetting();
        $sort = $mySetting->GetSettingValue('MaliSort');
        $Query1 = "SELECT
	UserCredit.ID,
	RespnsType.RespnsTypeName,
	RelatedStaff.OwnerUserID,
	RelatedStaff.ResponserID,
	RelatedStaff.StartRespns,
	RelatedStaff.EndRespns,
	UserCredit.ReferenceId,
	UserCredit.UserName,
	RelatedStaff.CreateBy,
	UserCredit.Mony,
	UserCredit.Note,
    UserCreditModMeta.ModName,
	userinfoowner.Name as userinfoownerName,
	userinfoowner.Family as userinfoownerFamily,
	userinforesponder.Name as userinforesponderName,
	userinforesponder.Family as userinforesponderFamily,
	userinfocredit.Name as userinfocreditName,
	userinfocredit.Family as userinfocreditFamily,
	creator.Name as creatorName,
	creator.Family as creatorFamily
FROM
	RelatedStaff
	inner JOIN UserCredit on UserCredit.ReferenceId = RelatedStaff.RelatedCredite $unconfirm_query
	INNER JOIN RespnsType on RespnsType.ID = RelatedStaff.RespnsType
	INNER JOIN UserInfo as userinfoowner on userinfoowner.UserName = RelatedStaff.OwnerUserID
	INNER JOIN UserInfo as userinfocredit on userinfocredit.UserName = UserCredit.UserName
	INNER JOIN UserInfo as userinforesponder on userinforesponder.UserName = RelatedStaff.ResponserID
	INNER JOIN UserInfo as creator on creator.UserName = RelatedStaff.CreateBy
	INNER JOIN UserCreditModMeta on UserCreditModMeta.ID = UserCredit.CreditMod
    where $Condition_query
ORDER BY
	UserCredit.ID $sort";

        $Query1 = "SELECT
	UserCredit.ID,
	RespnsType.RespnsTypeName,
	RelatedStaff.OwnerUserID,
	RelatedStaff.ResponserID,
	RelatedStaff.StartRespns,
	RelatedStaff.EndRespns,
	UserCredit.ReferenceId,
	UserCredit.UserName,
	RelatedStaff.CreateBy,
	UserCredit.Mony,
	UserCredit.Note,
    UserCredit.CreditMod as ModName,
	userinfoowner.Name as userinfoownerName,
	userinfoowner.Family as userinfoownerFamily,
	userinforesponder.Name as userinforesponderName,
	userinforesponder.Family as userinforesponderFamily,
	userinfocredit.Name as userinfocreditName,
	userinfocredit.Family as userinfocreditFamily,
	RelatedStaff.CreateBy as creatorName,
	'' as creatorFamily
FROM
	RelatedStaff
	inner JOIN UserCredit on UserCredit.ReferenceId = RelatedStaff.RelatedCredite  $unconfirm_query
	INNER JOIN RespnsType on RespnsType.ID = RelatedStaff.RespnsType
	INNER JOIN UserInfo as userinfoowner on userinfoowner.UserName = RelatedStaff.OwnerUserID
	INNER JOIN UserInfo as userinfocredit on userinfocredit.UserName = UserCredit.UserName
	INNER JOIN UserInfo as userinforesponder on userinforesponder.UserName = RelatedStaff.ResponserID
where $Condition_query
ORDER BY
	UserCredit.ID $sort";

        $CreditRows = DB::Select($Query1);
        if ($unconfirm) {
            return view("Credit.RequestListService", ['CreditRows' => $CreditRows]);
        } else {
            return [
                'result' => true,
                'data' => $CreditRows
            ];
        }
    }

    public function DoCrediteTransferConfirmsrv(Request $request)
    {
        if (Auth::user()->Role < myappenv::role_Accounting) {
            return redirect()->back()->with('error', "برای شما مجوزی در خصوص این درخواست صادر نشده است!");
        }
        $MyPersian = new persian();
        if ($request->has('ConfirmRefrence')) {
            $TargetTransactions = UserCredit::where('ReferenceId', $request->input('ConfirmRefrence'))->orWhere('ZeroRefrenceID', $request->input('ConfirmRefrence'))->get();
            $UpdateData = [
                'ConfirmBy' => Auth::id(),
                'Confirmdate' => now(),
            ];
            $mycredit = new Financial();

            foreach ($TargetTransactions as $TargetTransaction) {
                if ($TargetTransaction->Confirmdate == null) {

                    UserCredit::where('ID', $TargetTransaction->ID)->update($UpdateData);
                    $mySetting = new AppSetting();
                    $TransactionSendSMS = $mySetting->GetSettingValue('TransactionSendSMS');
                    if ($TransactionSendSMS == 'true') {
                        $mycredit->TransactionReminders($TargetTransaction->UserName, $TargetTransaction->Mony, $TargetTransaction->CreditMod);
                    }
                }
            }
            return redirect()->back()->with('success', __("Transaction done!"));
        }
    }

    public function CrediteTransferRequest($ReferenceId = null)
    {

        $UserCreditModMetas = UserCreditModMeta::all();
        $CreditIndex = UserCreditIndex::all();
        $RefrenceSrc = null;
        $user_branch = Auth::user()->branch;
        if ($ReferenceId != null) {
            $Query = "SELECT  uc.ID,uc.Mony,uc.branch,uc.Date,uc.Confirmdate,uc.Note,uc.ReferenceId,ui.Name,ui.Family,ucm.ModName FROM UserCredit as uc INNER JOIN UserInfo as ui on uc.UserName = ui.UserName INNER JOIN UserCreditModMeta as ucm on uc.CreditMod = ucm.ID
             WHERE uc.branch = $user_branch and (uc.ID =$ReferenceId OR uc.ReferenceId = $ReferenceId)";
            $RefrenceSrc = DB::select($Query);
            if ($RefrenceSrc == []) {
                abort(404, 'درخواست شما قابل پردازش نیست!');
            }
        }
        return view('Credit.CreditTransfer', ['ReferenceId' => $ReferenceId, 'RefrenceSrc' => $RefrenceSrc, 'CreditIndex' => $CreditIndex, 'UserCreditModMetas' => $UserCreditModMetas]);
    }
    private function check_valid_transfer($targetUser)
    {
        $request_user_branch = Auth::user()->branch;
        if ($request_user_branch == myappenv::Branch) {
            return true;
        }
        $target_user_src = UserInfo::where('UserName', $targetUser)->first();
        if ($target_user_src == null) {
            return false;
        }
        if ($target_user_src->branch != $request_user_branch) {
            return false;
        }
        if ($target_user_src->Role == myappenv::role_ShopOwner) {
            return false;
        }
        return true;
    }

    public function DoCrediteTransferRequest(Request $request, $ReferenceId = null)
    {
        if ($request->has('confirm_service')) {
            $financial = new Financial;
            $result = $financial->credit_checkout($ReferenceId, $request->confirm_service);
            if ($result['result']) {
                return redirect()->back()->with('success', 'تسویه اضافه شد!');
            } else {
                return redirect()->back()->with('error', $result['msg']);
            }
        }
        $Link = "";
        $ShafatelGateway = false;
        if ($request->has('ConfirmRefrence')) {
            if ($request->input('ConfirmRefrence') == 'all') {
                $AppSeting = new AppSetting;
                $DoubleConfirm = $AppSeting->GetSettingValue('DoubleConfirm');
                $UserCredit = UserCredit::where('ReferenceId', $ReferenceId)->get();
                $Efected = [];
                $financial = new Financial;
                foreach ($UserCredit as $UserCreditItem) {
                    if ($UserCreditItem->ConfirmBy == null) {
                        if ($DoubleConfirm == 'true') {
                            $UdateData = [
                                'ConfirmBy' => Auth::id(),
                                'Confirmdate' => now()
                            ];
                            if ($UserCreditItem->TransferBy != Auth::id()) {
                                $UdateData = [
                                    'ConfirmBy' => Auth::id(),
                                    'Confirmdate' => now()
                                ];
                                UserCredit::where('ID', $UserCreditItem->ID)->update($UdateData);
                                $SubEfect = [
                                    'id' => $UserCreditItem->ID,
                                    'status' => true
                                ];
                                array_push($Efected, $SubEfect);
                            } else {
                                $SubEfect = [
                                    'id' => $UserCreditItem->ID,
                                    'status' => false,
                                    'msg' => 'کاربر تایید کننده با کاربر تولید کننده سند یکی است!'
                                ];
                                array_push($Efected, $SubEfect);
                            }
                        } else {
                            $checkout_ref = null;
                            if ($UserCreditItem->Prebill != null) {
                                $checkout_ref = $UserCreditItem->Prebill;
                                $main_cahckout_data = [
                                    'Prebill' => null,
                                    'ZeroRefrenceID' => $checkout_ref
                                ];
                                UserCredit::where('ID', $UserCreditItem->ID)->update($main_cahckout_data);
                            }
                            $UdateData = [
                                'ConfirmBy' => Auth::id(),
                                'Confirmdate' => now()
                            ];
                            UserCredit::where('ID', $UserCreditItem->ID)->update($UdateData);
                            if ($checkout_ref != null) {
                                $financial->checkout_process_after_pay($checkout_ref);
                            }
                            $SubEfect = [
                                'id' => $UserCreditItem->ID,
                                'status' => true
                            ];
                            array_push($Efected, $SubEfect);
                        }
                    }
                }
                if ($Efected == []) {
                    return redirect()->back()->with('warning', 'عملیاتی انجام نشد!');
                } else {
                    $Msg = 'عملیات موفقیت آمیز!';
                    $Msg .= '<br>';
                    foreach ($Efected as $EfectedItem) {
                        if ($EfectedItem['status']) {
                            $Msg .= 'تراکنش شماره: ' . $EfectedItem['id'] . 'ثبت شد!' . '<br>';
                        } else {
                            $Msg .= 'تراکنش شماره: ' . $EfectedItem['id'] . 'ثبت نشد!' . $EfectedItem['msg'] .  '<br>';
                        }
                    }
                    UserCredit::where('ID', $ReferenceId)->update(['ReferenceId' => $ReferenceId]);
                    return redirect()->back()->with('success', $Msg);
                }
            }
        }
        if ($request->has('deleteTranscation')) {
            $TargetId = $request->input('deleteTranscation');
            UserCredit::where('ID', $TargetId)->delete(); //HACK:UserCredit 
            UserCredit::where('Prebill', $TargetId)->update(['Prebill' => null]);
            return redirect()->back()->with('success', "تراکنش شماره $TargetId  حذف گردید !");
        }
        if ($request->input('submit') == 'Trnsfer' || $request->input('submit') == 'TrnsferSnad') {
            $request->validate([
                'UserName' => 'required',
                'CreditMod' => 'required',
                'Amount' => 'required',
            ], [
                'UserName.required' => __("Enter") . __("Target username") . __(" Is required!!"),
                'CreditMod.required' => __("Enter") . __("Credit Type") . __(" Is required!!"),
                'Amount.required' => __("Enter") . __("Credite mony real") . __(" Is required!!"),
            ]);

            $TargetUser = $request->input('UserName');
            if (!$this->check_valid_transfer($TargetUser)) {
                return redirect()->back()->with('error', 'شما مجوز افزایش اعتبار به کاربر مورد نظر را ندارید!');
            }
            $Mony = $request->input('Amount');
            $Note = $request->input('Note');
            $CreditMod = $request->input('CreditMod');
            $MyUser = new UserClass();
            if ($MyUser->IsUserExist($TargetUser)) {
                if ($request->input('Limit') == 'on') {
                    $CreditType = myappenv::LimitCreditNumber;
                } else {
                    $CreditType = myappenv::NormalCreditNumber;
                }
                if ($request->has('RealAmount')) {
                    $RealAmount = $request->input('RealAmount');
                } else {
                    $RealAmount = 0;
                }
                if ($request->input('CreditIndex') == 0) {
                    $CrediteIndex = null;
                } else {
                    $CrediteIndex = $request->input('CreditIndex');
                }
                if ($ReferenceId == null) {
                    $CrediteData = [
                        'UserName' => $TargetUser,
                        'Mony' => $Mony,
                        'Type' => $CreditType,
                        'Date' => now(),
                        'Note' => $Note,
                        'TransferBy' => Auth::ID(),
                        'RealMony' => $RealAmount,
                        'CreditMod' => $CreditMod,
                        'branch' => Auth::user()->branch,
                        'CreditIndex' => $CrediteIndex,
                    ];
                    $Result = UserCredit::create($CrediteData);
                } else {
                    $Ce = $request->input('CE');
                    if ($Ce != null) {
                        $jsonData = [
                            'Note' => $Ce,
                        ];
                    } else {
                        $jsonData = [
                            'Note' => '',
                        ];
                    }
                    $ExtraNote = json_encode($jsonData);
                    $CrediteData = [
                        'UserName' => $TargetUser,
                        'Mony' => $Mony,
                        'Type' => $CreditType,
                        'Date' => now(),
                        'Note' => $Note,
                        'TransferBy' => Auth::ID(),
                        'RealMony' => $RealAmount,
                        'CreditMod' => $CreditMod,
                        'branch' => auth::user()->branch,
                        'CreditIndex' => $CrediteIndex,
                        'ReferenceId' => $ReferenceId,
                        'ExtraInfo' => $ExtraNote,
                    ];
                    $Result = UserCredit::create($CrediteData);
                    UserCredit::where('ID', $ReferenceId)->where('ReferenceId', null)->update(['ReferenceId' => $ReferenceId]);
                }

                if ($CreditMod == myappenv::ToPayCredit) { // to user pay form ipg
                    $MyDirectPay = new DirectPayment();
                    $TargetUserInfo = UserInfo::where('UserName', $TargetUser)->first();
                    $payername = $TargetUserInfo->Name . ' ' . $TargetUserInfo->Family;
                    $Mobile = $TargetUserInfo->MobileNo;
                    //$Result = $MyDirectPay->PepDirectPayAdd($Mony, $Result->id, $TargetUser, $payername, $Mobile, $Note);
                    $MySMS = new SmsCenter();
                    $mytext = new TextClassMain();
                    $Link =  route('selfpay', ['id' => $Result->id]);
                    $smstext = $mytext->PaymentfromipgRequest($payername, number_format($Mony), myappenv::CenterName, $Link);
                    $MySMS->OndemandSMS($smstext, $Mobile, 'IPGReq', Auth::id());
                }

                if ($CreditMod == myappenv::shafatel_payment_id) {
                    $ShafatelPayClass = new ShafatelPayClass();
                    $UserInfo = UserInfo::where('UserName', $TargetUser)->first();
                    $payername = $UserInfo->Name . ' ' . $UserInfo->Family;
                    $mydate = date('Y-m-d');
                    $mydate = date('Y-m-d', strtotime($mydate . myappenv::Shafatel_expireation_durtion));
                    $mobile = $UserInfo->MobileNo;
                    $MobileNo = $UserInfo->MobileNo;
                    $commision = $ShafatelPayClass->GetCommission($Mony);
                    $iban = myappenv::iban;
                    if (myappenv::CommissionAdd) {
                        $multipaymentdata = "<item><iban>$iban</iban><type>0</type><value>$Mony</value></item>";
                        $Mony += $commision;
                        $UpdateData = [
                            'ConfirmBy' => 'system',
                            'GateWay' => "sht",
                            'Confirmdate' => now(),
                        ];
                        UserCredit::where('ID', $Result->id)->update($UpdateData);
                    } else {
                        $targetMony = $Mony - $commision;
                        $multipaymentdata = "<item><iban>$iban</iban><type>0</type><value>$targetMony</value></item>";
                        $UpdateData = [
                            'ConfirmBy' => 'system',
                            'GateWay' => "sht",
                            'ReferenceId' => $Result->id,
                            'Confirmdate' => now(),
                        ];
                        UserCredit::where('ID', $Result->id)->update($UpdateData);
                        $CrediteData = [ //commision
                            'UserName' => $TargetUser,
                            'Mony' => -1 * $commision,
                            'Type' => myappenv::CommisionCreditNumber,
                            'Date' => now(),
                            'Note' => __('Commision'),
                            'ReferenceId' => $Result->id,
                            'TransferBy' => Auth::ID(),
                            'ConfirmBy' => 'system',
                            'Confirmdate' => now(),
                            'GateWay' => "sht",
                            'RealMony' => $RealAmount,
                            'CreditMod' => $CreditMod,
                            'branch' => '1',
                        ];
                        UserCredit::create($CrediteData);
                    }

                    $PostData = [
                        'payername' => $payername,
                        'amont' => $Mony,
                        'redirectaddress' => url('/'),
                        'centername' => myappenv::CenterName,
                        'multipaymentdata' => $multipaymentdata,
                        'invoiceNumber' => $Result->id,
                        'Mobile' => $mobile,
                        'expire' => $mydate,
                        'note' => $Note,
                    ];
                    $IPGResult = $ShafatelPayClass->ShafatelIPG($PostData);
                    if ($IPGResult == 0) {
                        $IPGDone = false;
                    } else {
                        $IPGDone = true;
                        $updatedata = [
                            'PaymentId' => $IPGResult,
                        ];
                        UserCredit::where('ID', $Result->id)->update($updatedata);
                        $Mytext = new TextClassMain();
                        $SMStext = $Mytext->PayLink($payername, $Mony, $Note, myappenv::CenterName, $IPGResult);
                        $MySMS = new SmsCenter();
                        $MySMS->OndemandSMS($SMStext, $MobileNo, 'IPG Requst', Auth::id());
                    }
                    $ShafatelGateway = true;
                }
                if ($ShafatelGateway) {
                    if ($IPGDone) {
                        return redirect()->back()->with('success', __("Requst of Pay save on Shafatel ") . ' <br> ' . $Link);
                    } else {
                        return redirect()->back()->with('error', __("Error has accure in save pay in shafatel system!"));
                    }
                } else {
                    if ($request->input('submit') == 'TrnsferSnad') {
                        return redirect()->route('CrediteTransfer', ['ReferenceId' => $Result->id]);
                    } else {
                        return redirect()->back()->with('success', 'درخواست انتقال به صورت موفقیت آمیز ثبت گردید!' . "<br> کد سند : " . $Result->id);
                    }
                }
            } else {
                return redirect()->back()->with('error', __("please recheck input data"));
            }
        }
    }
}
