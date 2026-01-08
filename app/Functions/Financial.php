<?php


namespace App\Functions;

use App\APIS\SmsCenter;
use App\APIS\SMSDotIR;
use App\Models\UserCredit;
use App\Models\UserInfo;
use App\myappenv;
use App\Functions\TextClassMain;
use App\Functions\persian;
use Auth;
use DB;

class Financial
{
    public function IsValidTransfer($UserName, $CreditMod, $Amount)
    {
        if ($CreditMod == 3) {
            return true; //periodical credit
        }
        $Result = UserCredit::where('UserName', $UserName)->where('CreditMod', $CreditMod)->sum('Mony');
        if ($Result + $Amount > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function UserFinalState($UserName)
    {
        /*    $Query = "SELECT sum( UserCredit.Mony) as Mony ,
        sum( if( UserCredit.RealMony is null or UserCredit.RealMony = 0 , 0 ,UserCredit.Mony - UserCredit.RealMony )) as RealMony ,
        UserCreditModMeta.ModName ,
        UserCredit.CreditMod
        FROM UserCredit INNER JOIN UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID 
        WHERE   UserCredit.ZeroRefrenceID is null and  UserCredit.Confirmdate is not null and UserCredit.UserName = '$UserName' and UserCredit.Type != 100 GROUP by UserCreditModMeta.ModName ,UserCredit.CreditMod";
        */
        $Query = "SELECT sum( UserCredit.Mony) as Mony ,
        sum( if( UserCredit.RealMony is null or UserCredit.RealMony = 0 , 0 ,UserCredit.Mony - UserCredit.RealMony )) as RealMony ,
        UserCreditModMeta.ModName ,
        UserCredit.CreditMod
        FROM UserCredit INNER JOIN UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID 
        WHERE  UserCredit.Confirmdate is not null 
        and UserCredit.UserName = '$UserName' and UserCredit.Type != 100 
        GROUP by UserCreditModMeta.ModName ,UserCredit.CreditMod";
        $result = DB::select($Query);
        return $result;
    }
    private function sms_dot_ir_TransactionReminders($UserName, $Mony, $CreditMod)
    {
        $MyPersian = new persian();
        $SumMony = $this->UserHasCredite($UserName, $CreditMod);
        $TargetUser = UserInfo::where('UserName', $UserName)->first();
        $my_sms = new SMSDotIR;
        $code = [
            [
                "name" => "NAME",
                "value" => $TargetUser->Name
            ],
            [
                "name" => "MONY",
                "value" => number_format($SumMony)
            ],
            [
                "name" => "DATE",
                "value" => $MyPersian->MyPersianNow()
            ],
            [
                "name" => "PRICE",
                "value" => number_format($Mony)
            ]
        ];
        $my_sms->TransactionReminders($code, $TargetUser->MobileNo);
        return true;
    }
    public function TransactionReminders($UserName, $Mony, $CreditMod)
    {

        $mytext = new TextClassMain();
        $MyPersian = new persian();
        $MySMS = new SmsCenter();
        if ($CreditMod == myappenv::CachCredit) {
            if (myappenv::SMSCenter == 'sms.ir') {
                return $this->sms_dot_ir_TransactionReminders($UserName, $Mony, $CreditMod);
            }
            $SumMony = $this->UserHasCredite($UserName, $CreditMod);
            $smstext = $mytext->TransferMonySMS($MyPersian->MyPersianNow(), $Mony, $SumMony, $UserName);
            $TargetUser = UserInfo::where('UserName', $UserName)->first();
            $MySMS->OndemandSMS($smstext, $TargetUser->MobileNo, 'Credit Transfer', $UserName);
        }
        return true;
    }

    public function UserHasCredite($UserName, $CreditMod)
    {
        $res = UserCredit::where('UserName', $UserName)->where('CreditMod', $CreditMod)->where('Confirmdate', '!=', null)->sum('Mony');
        return $res;
    }
    public static function get_user_debit($Reference_transaction)
    {
        $user_branch = Auth::user()->branch;
        $Credit_reference = UserCredit::where('id', $Reference_transaction)->where('branch', $user_branch)->first();
        if ($Credit_reference == null) {
            return [
                'result' => false,
                'msg' => 'تراکنش درخواست شده در سامانه وجود ندارد'
            ];
        }
        $UserName = $Credit_reference->UserName;
        $Query = "SELECT UserCredit.Mony,UserCredit.Prebill, UserCredit.Type, UserCredit.Date, UserCredit.Note, UserCreditModMeta.ModName, UserCredit.ID, UserCredit.RealMony, UserCredit.InvoiceNo, UserCredit.ZeroRefrenceID, UserCredit.CreditMod, UserCredit.Confirmdate, DATEDIFF(UserCredit.Confirmdate, UserCredit.Date) AS dif, UserCredit.bill
        FROM UserCredit
        INNER JOIN UserCreditModMeta ON UserCredit.CreditMod = UserCreditModMeta.ID
        WHERE UserCredit.ZeroRefrenceID is null and  UserCredit.Mony < 0 and  UserCredit.UserName = '$UserName'
          AND UserCredit.ConfirmBy != ''
        ORDER BY UserCredit.ID ASC";
        $result = DB::select($Query);
        return [
            'result' => true,
            'data' => $result
        ];
    }
    public function checkout_process_after_pay($credit_reference_id)
    {
        $checkout_src = UserCredit::where('ReferenceId', $credit_reference_id)->get();
        foreach ($checkout_src as $checkout_item) {
            if ($checkout_item->CreditMod != myappenv::CachCredit) {
                UserCredit::where('ID', $checkout_item->ID)->update(['CreditMod' => myappenv::CachCredit]);
            }
            if ($checkout_item->Prebill != null) {
                $temp_data = [
                    'Prebill' => null,
                    'ZeroRefrenceID' => $checkout_item->Prebill
                ];
                UserCredit::where('ID', $checkout_item->ID)->update($temp_data);
            }
        }
        return true;
    }
    public function credit_checkout($Credit_reference, $credit_id)
    {
        $user_branch = Auth::user()->branch;
        $credit_src = UserCredit::where('ID', $credit_id)->where('branch', $user_branch)->first();
        if ($credit_src == null) {
            return [
                'result' => false,
                'msg' => 'تراکنش مورد نظر موجود نمی باشد!'
            ];
        }
        $credit_ref_src = UserCredit::where('ID', $Credit_reference)->where('branch', $user_branch)->first();
        if ($credit_ref_src == null) {
            return [
                'result' => false,
                'msg' => 'تراکنش مرچع مورد نظر موجود نمی باشد!'
            ];
        }
        $TargetUser = $credit_src->UserName;
        $Mony = -1 * $credit_src->Mony;
        $Note = 'تسویه: ' . $credit_src->Note;
        $CreditMod = $credit_src->CreditMod;
        $CreditType = $credit_src->Type;
        $RealAmount = -1 * $credit_src->RealAmount;
        $CrediteIndex = $credit_src->CreditIndex;
        $jsonData = [];
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
            'ReferenceId' => $Credit_reference,
            'ExtraInfo' => $ExtraNote,
            'Prebill' => $credit_id
        ];
        $Result = UserCredit::create($CrediteData);
        $inserted_transaction = $Result->id;
        UserCredit::where('ID', $credit_id)->update(['Prebill' => $inserted_transaction]);
        return [
            'result' => true,
            'data' => $Result
        ];
    }

    public function AccountHistory($UserName, $Limit, $bill = null)
    {
        if ($bill == null) {

            $Query = "SELECT UserCredit.Mony, UserCredit.Type, UserCredit.Date, UserCredit.Note, UserCreditModMeta.ModName, UserCredit.ID, UserCredit.RealMony, UserCredit.InvoiceNo, UserCredit.ZeroRefrenceID, UserCredit.CreditMod, UserCredit.Confirmdate, DATEDIFF(UserCredit.Confirmdate, UserCredit.Date) AS dif, UserCredit.bill
            FROM UserCredit
            INNER JOIN UserCreditModMeta ON UserCredit.CreditMod = UserCreditModMeta.ID
            WHERE UserCredit.UserName = '$UserName' and UserCredit.ZeroRefrenceID is null
              AND UserCredit.ConfirmBy != ''
            ORDER BY UserCredit.ID ASC";
        } else {
            $Query = "SELECT UserCredit.Mony, UserCredit.Type,UserCredit.Date,UserCredit.Note,UserCreditModMeta.ModName ,UserCredit.ID, UserCredit.RealMony , UserCredit.InvoiceNo,UserCredit.ZeroRefrenceID,UserCredit.CreditMod ,UserCredit.Confirmdate , DATEDIFF(UserCredit.Confirmdate ,UserCredit.Date ) as dif ,UserCredit.bill  FROM UserCredit INNER JOIN UserCreditModMeta WHERE  UserCredit.bill = $bill and  UserCredit.CreditMod = UserCreditModMeta.ID and UserCredit.UserName = '$UserName' and UserCredit.ConfirmBy != '' ORDER BY UserCredit.ID asc
";
        }
        $result = DB::select($Query);
        return $result;
        $OutPut = '<table class="font-tbody table table-striped table-bordered table-hover" >
	<thead>
	<tr>
	<th>شماره تراکنش</th>
	<th>تاریخ تراکنش</th>
	<th>تاریخ تایید تراکنش</th>
	<th>مبلغ</th>
	<th>مانده حساب</th>
	<th>صورتحساب</th>
	<th>توضیحات</th>
	</tr>
	</thead>
	<tbody>';
        $Conter = 1;
        foreach ($result as $row) {
            if ($row[1] == 92) {
                $EditCredit = " <span style='color:Green;'>تراکنش اصلاحیه</span>   ";
            } else {
                $EditCredit = '';
            }

            if ($row[1] == 100) {
                $LimitCredit = " *تعیین سقف اعتبار*  ";
            } else {
                $LimitCredit = '';
            }
            if ($row[8] != '2') {
                $OutPut .= '<tr class="odd gradeX" >';
            } else {
                $OutPut .= '<tr class="odd gradeX" style="color: red;">';
            }
            $transactioncode = PersianNumber($row[5]);
            if ($row[7] != 0) {
                $transactioncode .= '<br>مرجع <br>' . PersianNumber($row[7]);
            }
            if ($row[6] != null) {
                $tafavot = $row[0] - $row[6];
                $RealMony = '<br> مبلغ حقیقی: ' . PersianPrice($row[0]) . '<br> واریزی: ' . PersianPrice($row[6]) . '<br> تخفیف: ' . PersianPrice($tafavot);
            } else {
                $RealMony = PersianPrice($row[0]);
            }
            if ($row[2] != 0) {
                $Datecredit = MyPersianDateSQL($row[2]);
                $DatecreditConfirm = MyPersianDateSQL($row[9]);
            } else {
                $Datecredit = $row[2];
            }

            $OutPut .= "<td>$transactioncode</td><td>" . $Datecredit . "</td><td>" . $DatecreditConfirm . "</td><td>" . $RealMony . $LimitCredit;
            if ($row[0] < 0) {
                $OutPut .= '<i class="fa fa-arrow-circle-o-down" style="color:red;"></i>' . "<br> $row[4]     <br> $EditCredit" . '</td>';
            } elseif ($row[0] >= 0) {
                $OutPut .= '<i class="fa fa-arrow-circle-o-up" style="color:Green;"></i><br>' . "<br> $row[4] <br> $EditCredit";
            } elseif ($row[1] == '4') {
                $OutPut .= '<i class="fa fa-exchange" style="color:Green;"></i></td>';
            }
            $Notes = $row[3];
            if ($GLOBALS['UserRole'] == '2') {
                $Notes = str_replace("*", "", $Notes);
            }
            $Query1 = "SELECT sum(UserCredit.Mony) FROM UserCredit WHERE UserCredit.ConfirmBy != '' and  UserCredit.UserName = '$UserName' and UserCredit.ID<='$row[5]'    and CreditMod!=9";
            $result1 = SelectQuery($Query1);
            $row1 = mysqli_fetch_row($result1);
            $AccountBalance = PersianPrice($row1[0]);
            $OutPut .= "<td>$AccountBalance</td>";
            $Bill = $row[11];
            if ($Bill == null) {
                if ($GLOBALS['UserRole'] == '5') {
                    $myid = $row[5];
                    $OutPut .= "<td><input type='checkbox' name='billarr[]' value='$myid'><br></td>";
                } else {
                    $OutPut .= "<td>-</td>";
                }
            } else {
                $OutPut .= "<td>$Bill</td>";
            }
            $OutPut .= "<td>$Notes</td>";
            $Conter++;
        }
        if ($Conter == 1) {
            $OutPut .= $GLOBALS['$NoCreditHistory'];
        }
        $OutPut .= '</tbody>
	</table>';
        return $OutPut;
    }
    public function AccountCreditHistory($UserName, $Limit)
    {
        $Query = "SELECT UserCredit.Mony, UserCredit.Date, UserCredit.ID, UserCredit.RealMony, UserCredit.InvoiceNo, UserCredit.ZeroRefrenceID
        FROM UserCredit
        WHERE UserCredit.UserName = '$UserName'
          AND UserCredit.Mony > 0
          AND NOT EXISTS (
            SELECT 1
            FROM UserCredit uc
            WHERE uc.InvoiceNo = UserCredit.InvoiceNo
            AND uc.`Mony` + UserCredit.`Mony` = 0


          )
        ORDER BY UserCredit.InvoiceNo ASC";
        $result = DB::select($Query);

        return $result;
    }
}
