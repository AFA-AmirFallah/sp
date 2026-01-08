<?php

namespace App\Http\Controllers\Credit;

use App\APIS\SmsCenter;
use App\Functions\AppSetting;
use App\Functions\persian;
use App\Functions\TextClassMain;
use App\Http\Controllers\Controller;
use App\Models\UserCredit;
use App\Models\UserCreditModMeta;
use App\Models\UserInfo;
use App\myappenv;
use Auth;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class Reports extends Controller
{



    public function TavanPardakht()
    {
        if (Gate::allows('shopadmin_') || Gate::allows('root_')) {
        } else {
            return abort('404', 'دسترسی غیر مجاز!');
        }
        return view('Credit.TavanPardakht', ['response' => null]);
    }
    public function Estelam($CodeMelli)
    {
        $NationalCode_Base64 = base64_encode($CodeMelli);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://saba.esata.ir:7091/gateway/api/token/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'username=a29va2Jheg%3D%3D&password=S0BAa2JhejEyMzQ1',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response);
        $response = $response->message;
        $response = $response->data;
        $AccessToken = $response->access_token;
        /*
        execute after Access Token
         */

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://saba.esata.ir:7091/gateway/api/common/searchPersonByModel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
          "nationalCode":"' . $NationalCode_Base64 . '"
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $AccessToken,
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        $response = $response->message;
        $response = $response->data;
        if (isset($response[0])) {
            $response = $response[0];
        } else {
            $response = 'notvalid';
        }
        return $response;
    }
    public function DoTavanPardakht(Request $request)
    {
        if (Auth::user()->Role == myappenv::role_SuperAdmin || Auth::user()->Role == myappenv::role_ShopAdmin) {
        } else {
            return abort('404', 'دسترسی غیر مجاز!');
        }
        if ($request->has('submit')) {
            $CodeMelli = $request->input('CodeMelli');
            $response = $this->Estelam($CodeMelli);
            return view('Credit.TavanPardakht', ['response' => $response]);
        } else {
            return abort('درخواست نا معتبر!');
        }
    }

    public function FinancialTotalReport()
    {
        $UserCreditModMeta = UserCreditModMeta::all();
        $GraphData = null;
        $Description = null;
        $FinancialIndex = null;
        return view("Credit.FinancialTotalReport", ['UserCreditModMeta' => $UserCreditModMeta, 'DaramadGraph' => $GraphData, 'Description' => $Description, 'FinancialIndex' => $FinancialIndex]);
    }

    public function DoFinancialTotalReport(Request $request)
    {
        $MyPersian = new persian();
        $FinancialIndex = null;
        $GraphData = ' ';
        $DateList = ' ';

        if ($request->input('StartDate') != null) {
            $StartDate = $MyPersian->MiladiDate($request->input('StartDate'));
        } else {
            return redirect()->back()->with('error', __("The date of report is not set"));
        }
        if ($request->input('EndDate') != null) {
            $EndDate = $MyPersian->MiladiDate($request->input('EndDate'));
        } else {
            $EndDate = $StartDate;
        }
        $showtype = $request->input('Showtype');
        $CreditMod = $request->input('CreditMod');
        $QueryCondition = "WHERE date(UserCredit.Confirmdate) >= '$StartDate' ";
        if ($CreditMod != 0) {
            $QueryCondition .= " and UserCredit.CreditMod = $CreditMod";
        }
        if ($EndDate != null) {
            $QueryCondition .= " and  date(UserCredit.Confirmdate) <=  '$EndDate' ";
        }
        if ($showtype == 2) {
            $Query = "SELECT COUNT(*), DATE(UserCredit.Confirmdate) as Confirmdate, SUM(CASE WHEN Mony > 0 THEN Mony END) AS input, SUM(CASE WHEN Mony < 0 THEN -1 * Mony END) AS output, SUM(CASE WHEN UserCredit.UserName = 'daramad1' THEN Mony END) AS daramad, UserCredit.CreditMod, UserCreditIndex.IndexName, UserCreditModMeta.ModName FROM UserCredit INNER JOIN UserCreditIndex ON UserCredit.CreditIndex = UserCreditIndex.IndexID INNER JOIN UserCreditModMeta ON UserCredit.CreditMod = UserCreditModMeta.ID $QueryCondition GROUP BY DATE(UserCredit.Confirmdate), UserCreditIndex.IndexName, UserCredit.CreditMod, UserCreditModMeta.ModName";
        } elseif ($showtype == 1) {
            $MStartDate = new DateTime($StartDate);
            $DateStartTime = new DateTime($StartDate);
            $IndexQuery = "SELECT UserCreditIndex.IndexName  FROM `UserCredit`
INNER JOIN UserCreditIndex on UserCredit.UserCreditIndex = UserCreditIndex.IndexID INNER JOIN UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID $QueryCondition
GROUP BY UserCreditIndex.IndexName ";
            $FinancialIndex = DB::select($IndexQuery);
            $Query = "SELECT UserCredit.Confirmdate,SUM(UserCredit.input) as input ,SUM(UserCredit.output) as output ,SUM(UserCredit.daramad) as daramad ,UserCreditIndex.IndexName  FROM `UserCredit`
INNER JOIN UserCreditIndex on UserCredit.UserCreditIndex = UserCreditIndex.IndexID INNER JOIN UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID $QueryCondition
GROUP BY Confirmdate , UserCreditIndex.IndexName ";
            $GraphData = '';
            $Init = true;
            $DateListTarget = new DateTime($StartDate);
            $DateListFinish = new DateTime($EndDate);

            $initDateList = true;
            while ($DateListTarget <= $DateListFinish) {
                if ($initDateList) {
                    $initDateList = false;
                    $DateListTargetStr = $DateListTarget->format("yy-m-d");
                    $DateList .= '"' . $MyPersian->MyPersianDate($DateListTargetStr) . '"';
                } else {
                    $DateList .= ' ,';
                    $DateListTargetStr = $DateListTarget->format("yy-m-d");
                    $DateList .= '"' . $MyPersian->MyPersianDate($DateListTargetStr) . '"';
                }

                $DateListTarget = $DateListTarget->modify('+1 day');
            }
            foreach ($FinancialIndex as $FinancialIndexItem) {
                $StartDate = $MyPersian->MiladiDate($request->input('StartDate'));
                new DateTime($StartDate);
                $DateStartTime = new DateTime($StartDate);
                if (!$Init) {
                    $GraphData .= ',{';
                    $SetDateList = false;
                } else {
                    $GraphData .= '{';
                    $Init = false;
                    $SetDateList = true;
                }
                $GraphData .= 'name: "' . $FinancialIndexItem->IndexName . '", data: [';
                $Query = "SELECT UserCredit.Confirmdate,SUM(UserCredit.daramad) as daramad ,UserCreditIndex.IndexName  FROM `UserCredit`
INNER JOIN UserCreditIndex on UserCredit.UserCreditIndex = UserCreditIndex.IndexID INNER JOIN UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID $QueryCondition
and UserCreditIndex.IndexName = '$FinancialIndexItem->IndexName' GROUP BY Confirmdate , UserCreditIndex.IndexName  ";

                $Result = DB::select($Query);
                $ResultInt = true;
                foreach ($Result as $ResualtItem) {
                    $StringDate = $DateStartTime->format("yy-m-d");
                    while ($StringDate != $ResualtItem->Confirmdate) {
                        $StringDate = $DateStartTime->modify('+1 day')->format("yy-m-d");
                        if ($ResultInt) {
                            $ResultInt = false;
                        } else {
                            $GraphData .= ', ';
                        }
                        $GraphData .= '0';
                    }
                    if ($ResultInt) {
                        $ResultInt = false;
                    } else {
                        $GraphData .= ', ';
                    }
                    //$GraphData .= number_format($ResualtItem->daramad) ;
                    $GraphData .= $ResualtItem->daramad;
                    $StringDate = $DateStartTime->modify('+1 day')->format("yy-m-d");
                }
                $DateEndDate = new DateTime($EndDate);
                $EndWithFormat = $DateEndDate->format('yy-m-d');
                while ($StringDate != $EndWithFormat) {
                    $StringDate = $DateStartTime->modify('+1 day')->format("yy-m-d");
                    if ($ResultInt) {
                        $ResultInt = false;
                    } else {
                        $GraphData .= ', ';
                    }
                    $GraphData .= '0';
                }

                $GraphData .= ']}';
            }
        }
        $Report = DB::select($Query);
        $Description = "گزارش کل ";
        if ($request->input('EndDate') != null) {
            $Description .= "از تاریخ " . $request->input('StartDate') . " تا تاریخ " . $request->input('EndDate');
        } else {
            $Description .= "در تاریخ " . $request->input('StartDate');
        }
        if ($CreditMod != 0) {
            $UserCreditModMeta = UserCreditModMeta::where('ID', $CreditMod)->first();
            $Description .= " -  سر فصل مالی : " . $UserCreditModMeta->ModName;
        } else {
            $Description .= ' - ' . " سر فصل مالی : کل سرفصل ها   ";
        }
        return view("Credit.FinancialTotalReport", ['Report' => $Report, 'showtype' => $showtype, 'DaramadGraph' => $GraphData, 'Description' => $Description, 'FinancialIndex' => $FinancialIndex, 'DateList' => $DateList]);
    }

    public function CreditIndexReport()
    {
        return view("Credit.Report_CreditIndexReport");
    }

    public function DoCreditIndexReport(Request $request)
    {
    }

    public function DaramadReport()
    {
        return view("Credit.Report_Daramad");
    }
    private function show_sell_report($StartDate,$EndDate){
        $Query = "SELECT  uc.ID, uc.Confirmdate, ui.Name , ui.Family , uc.Mony , uc.`Date` , uc.InvoiceNo  from UserCredit uc  inner join UserInfo ui on uc.UserName = ui.UserName WHERE uc.ReferenceId  = uc.ID  and uc.ConfirmBy  is not NULL  and  Date(Confirmdate) >= '$StartDate' and Date(Confirmdate) <= '$EndDate'";
        $DaramadDetail = DB::select($Query);
        return view("Credit.Report_sell", ['title' => 'گزارش فروش', 'StartDate' => $StartDate, 'EndDate' => $EndDate,  'DaramadDetail' => $DaramadDetail]);

    }

    public function DoDaramadReport(Request $request)
    {
        $title = null;
        $request->validate([
            'StartDate' => 'required|max:10|min:10',
            'EndDate' => 'required|max:10|min:10',
        ], [
            'StartDate.required' => 'پر کردن فیلد تاریخ شروع الزامی میباشد!',
            'StartDate.max' => 'تاریخ شروع وارد شده اشتباه است!',
            'StartDate.min' => 'تاریخ شروع وارد شده اشتباه است!',
            'EndDate.required' => 'پر کردن فیلد تاریخ پایان الزامی میباشد!',
            'EndDate.max' => 'تاریخ پایان وارد شده اشتباه است!',
            'EndDate.min' => 'تاریخ پایان وارد شده اشتباه است!',
        ]);
        $user_branch = Auth::user()->branch;
        
        $daramad = myappenv::StackHolder ;
        $Taxer = myappenv::TaxHolder ;
        if(myappenv::Lic['MultiBranch']){
            $daramad = $daramad . $user_branch;
            $Taxer = $Taxer . $user_branch;
        }
        $MyPersian = new persian();
        $StartDate = $MyPersian->MiladiDate($request->input('StartDate'));
        $EndDate = $MyPersian->MiladiDate($request->input('EndDate'));
        if($request->ReportType == 'sell'){
            return $this->show_sell_report($StartDate,$EndDate);
        }
        if ($request->input('ReportType') == 'Benefit') {
            $Query = "SELECT sum(Mony) as mony, date(Confirmdate) as confirmdate  FROM UserCredit  WHERE UserName = '$daramad' and Date(Confirmdate) >= '$StartDate' and Date(Confirmdate) <= '$EndDate' GROUP by Date(Confirmdate)  ORDER BY Date(Confirmdate) ASC  ";
            $DaramadGraph = DB::select($Query);
            $Query = "SELECT * , Date(Confirmdate) as ConfirmdateD FROM UserCredit  WHERE UserName = '$daramad' and Date(Confirmdate) >= '$StartDate' and Date(Confirmdate) <= '$EndDate'";
            $DaramadDetail = DB::select($Query);
            return view("Credit.Report_Daramad", ['title' => $title, 'DaramadGraph' => $DaramadGraph, 'StartDate' => $StartDate, 'EndDate' => $EndDate, 'showtype' => $request->input('submit'), 'DaramadDetail' => $DaramadDetail]);
        } elseif ($request->input('ReportType') == 'tax') {
            $Query = "SELECT sum(Mony) as mony, date(Confirmdate) as confirmdate  FROM UserCredit  WHERE UserName = '$Taxer' and (Confirmdate) >= '$StartDate' and (Confirmdate) <= '$EndDate' GROUP by Date(Confirmdate)  ORDER BY Date(Confirmdate) ASC  ";
            $DaramadGraph = DB::select($Query);
            $Query = "SELECT * , Date(Confirmdate) as ConfirmdateD ,(SELECT COUNT(*) from periodic_user_credits WHERE periodic_user_credits.InvoiceNo = UserCredit.InvoiceNo ) as Aghsat  FROM UserCredit  WHERE UserName = '$Taxer' and (Confirmdate) >= '$StartDate' and (Confirmdate) <= '$EndDate'";

            $DaramadDetail = DB::select($Query);
            $title = 'tax';
            return view("Credit.Report_Daramad", ['title' => $title, 'DaramadGraph' => $DaramadGraph, 'StartDate' => $StartDate, 'EndDate' => $EndDate, 'showtype' => $request->input('submit'), 'DaramadDetail' => $DaramadDetail]);
        } elseif ($request->input('ReportType') == 'Moein') {
            $Query = "select * from MoeinCreditReports where ReportConfirmdate >= '$StartDate' and ReportConfirmdate <= '$EndDate'";
            $MoeinCreditReport = DB::select($Query);
            return view('Credit.Report_Moein', ['title' => $title, 'MoeinCreditReport' => $MoeinCreditReport, 'StartDate' => $StartDate, 'EndDate' => $EndDate]);
        } elseif ($request->input('ReportType') == 'tafzili') {
            $Query = "select * from tafzili_reports where ReportConfirmdate >= '$StartDate' and ReportConfirmdate <= '$EndDate' ORDER BY tafzili_reports.ReportConfirmdate ASC";
            $MoeinCreditReport = DB::select($Query);
            return view('Credit.Report_Tafzili', ['title' => $title, 'MoeinCreditReport' => $MoeinCreditReport, 'StartDate' => $StartDate, 'EndDate' => $EndDate]);
        } elseif ($request->input('ReportType') == 'NonRef') {
            $Query = "SELECT ui.Name ,
            ui.Family ,
            ucmm.ModName as ModName,
            uc.*
            from
            UserCredit uc
            inner join UserInfo ui on
            uc.UserName = ui.UserName
            INNER JOIN UserCreditModMeta ucmm
            on ucmm.ID =uc.CreditMod
WHERE
uc.bill is null
and uc.TransfreRefrenceID is NULL
and uc.ReferenceId is null
and Date(uc.Confirmdate) >= '$StartDate'
and Date(uc.Confirmdate) <= '$EndDate' ";
            $NorefrenceCreditReport = DB::select($Query);
            return view('Credit.Report_NonRefrence', ['NorefrenceCreditReport' => $NorefrenceCreditReport, 'StartDate' => $StartDate, 'EndDate' => $EndDate]);
        }
    }

    private function DeleteExpireTransations()
    {
        $expire = myappenv::Shafatel_expireation_durtion_day;
        $CreditMod = myappenv::shafatel_payment_id;
        $Query = "DELETE from UserCredit WHERE DATEDIFF( now(),UserCredit.Date) > $expire and UserCredit.CreditMod = $CreditMod";
        DB::delete($Query);
    }

    public function IPGReport()
    {
        //$this->DeleteExpireTransations();
        $mySetting = new AppSetting();
        $sort = $mySetting->GetSettingValue('MaliSort');
        $IPGId = myappenv::shafatel_payment_id;
        $CommisionType = myappenv::CommisionCreditNumber;
        $Query = "SELECT UserCredit.UserName,UserCredit.PaymentId, UserCredit.Mony,UserCredit.Note,UserCredit.TransferBy,UserCredit.Date,UserCreditModMeta.ModName ,CONCAT(UserInfo.name,' ',UserInfo.Family ) as name ,UserCredit.ID ,UserCredit.RealMony,UserCredit.Type,UserCredit.ReferenceId FROM UserCredit join UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID join UserInfo
WHERE UserCredit.UserName = UserInfo.UserName and UserCredit.Type != $CommisionType and UserCredit.CreditMod = $IPGId  ORDER BY UserCredit.ID  $sort";
        $Query = "SELECT UserCredit.UserName,UserCredit.PaymentId, UserCredit.Mony,UserCredit.Note,UserCredit.TransferBy,UserCredit.Date,UserCreditModMeta.ModName ,CONCAT(UserInfo.name,' ',UserInfo.Family ) as name ,UserCredit.ID ,UserCredit.RealMony,UserCredit.Type,UserCredit.ReferenceId FROM UserCredit join UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID join UserInfo
WHERE UserCredit.UserName = UserInfo.UserName and UserCredit.Type != $CommisionType and UserCredit.GateWay is not null and UserCredit.GateWay != ''  ORDER BY UserCredit.ID  $sort";
        $Credites = DB::select($Query);
        return view('Credit.Report_IPG', ['Credites' => $Credites]);
    }

    public function
    DoIPGReport(Request $request)
    {
        $UserCredit = UserCredit::where('ID', $request->input('Confirm'))->first();
        $UserInfo = UserInfo::where('UserName', $UserCredit->UserName)->first();
        $payername = $UserInfo->Name . ' ' . $UserInfo->Family;
        $Mony = $UserCredit->Mony;
        $Note = $UserCredit->Note;
        $MobileNo = $UserInfo->MobileNo;
        $IPGResult = $UserCredit->PaymentId;
        $Mytext = new TextClassMain();
        $SMStext = $Mytext->PayLink($payername, $Mony, $Note, myappenv::CenterName, $IPGResult);
        $MySMS = new SmsCenter();
        $MySMS->OndemandSMS($SMStext, $MobileNo, 'IPG Requst', Auth::id());
    }
}
