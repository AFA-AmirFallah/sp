<?php

namespace App\Functions;

use App\Models\periodicUserCredit;
use Illuminate\Support\Facades\Auth;

class periodicCreditClass
{

    public function IsValidWalets($UserName, $WalletArr)
    {
        if ($WalletArr == null) {
            return true;
        }
        $OutPut = true;
        $MyTashim = new TashimClass();
        $WaletSrc = $MyTashim->WaletAgregator($WalletArr);
        $TashimAgregator = $MyTashim->TashimAgregator($WaletSrc);
        $SaveData = array();
        foreach ($TashimAgregator as $WaletItem) {
            if (CacheData::GetCreditMod($WaletItem['CreditMod']) == 'Periodic') {
                $result = $MyTashim->Tasim_extar_pre_save_modify($SaveData, $WaletItem);
                try {
                    $FeildDate = $result['Date'];
                } catch (\Exception $e) {
                    return  $e->getMessage();
                }

                //  $resultdate = strtotime(date("Y-m-d", $result));
                $TargetDate = date('Y-m-d', strtotime($FeildDate));
                $TargetDate = $FeildDate;
                $Remain = $this->GetRemianLimit($UserName, $WaletItem['CreditMod'], $TargetDate);
                if ($Remain == false) {
                    $OutPut = false;
                } elseif ($Remain < abs($WaletItem['Amount'])) {
                    $OutPut = false;
                }
            }
        }
        return ($OutPut);
    }

    public function UpdatePeriodicalPrice($Mony, $UserName)
    {

        $UsedMony = periodicUserCredit::where('UserName', $UserName)->where('type', 10)->get()->last();
        $BaseMony = periodicUserCredit::where('UserName', $UserName)->where('type', 1)->get()->last();


        if ($UsedMony != null )  {
            $UsedMony = $UsedMony->Mony;

            if($UsedMony < 0){
                $BaseMony = $BaseMony->Mony;
                $Remining = $BaseMony + $UsedMony;
                $NewMoney = $Mony - $Remining;
            }
            else{
                $NewMoney = $Mony;
            }

        } else {
            $NewMoney = $Mony;
        }


        $periodicUserCredits = periodicUserCredit::where('UserName', $UserName)->where('Type', 1)->whereDate('StartDate', '>', now())->get();
        foreach ($periodicUserCredits as $periodicUserCredit) {
            $NewArray = [
                'Note' => ' تغییر وضعیت',
                'UserName' => Auth::id(),
                'OldMony' => $periodicUserCredit->Mony,

            ];

            $ExtraData = TextClassMain::JsonComposer($periodicUserCredit->ExtraData, $NewArray);
            if ($UsedMony == null || $UsedMony > 0) {

                $periodicUserCredit->Mony = 0;
            }
            $UPdateData = [
                'mony' => $NewMoney + $periodicUserCredit->Mony,
                'ExtraData' => $ExtraData,
            ];
     
            $result = periodicUserCredit::where('ID', $periodicUserCredit->ID)->update($UPdateData);
        }

        return true;
    }
    public function HavePeriodicalPrice($UserName)
    {
        $result = periodicUserCredit::where('UserName', $UserName)->where('Type', 1)->first();
        if ($result == null) {
            return false;
        }
        return true;
    }

    /**
     * Undocumented function
     * $CreditAtt['EndTMonth'] => Define End Month of periodic Credit
     * $CreditAtt['SycleCount'] => Define periodic Credit sycles
     * Note : if use  $CreditAtt['SycleCount'] you should leave $CreditAtt['EndTMonth'] in null
     * $CreditAtt['PeriodTarget'] => Define Shamsi Target Day of Periodic Credit
     * Note: if not set $CreditAtt['PeriodTarget'] then The PeriodTarget difine by defult (1th of each months)
     * Important Note : Don not user 31 or 30 for PeriodTarget
     *
     * $PeriodType = M => for EndMonths Defined
     * $PeriodType = C => for Cyclic Period Credit Type
     *
     *
     * @param [type] $CreditAtt
     * @param [type] $UserAtt
     * @return void
     */
    public function AddPeriodicalPrice($CreditAtt, $UserAtt)
    {
        $CreditMod = $CreditAtt['CreditMod'];
        $StarTMonth = $CreditAtt['StarTMonth'];
        if (!isset($CreditAtt['SycleCount']) || $CreditAtt['SycleCount'] == null) {
            $PeriodType = 'M';
            $EndMonth = $CreditAtt['EndTMonth'];
        } else {
            $PeriodType = 'C';
            $Cycles = $CreditAtt['SycleCount'];
        }
        if (isset($CreditAtt['PeriodTarget'])) {
            $PeriodTarget = $CreditAtt['PeriodTarget'];
        } else {
            $PeriodTarget = 1;
        }
        $Mony = $CreditAtt['Mony'];
        $UserName = $UserAtt['UserName'];
        $Confirmer = $UserAtt['Confirmer'];
        $MyPersian = new persian();


        if ($CreditAtt['StarTYear'] != null) {
            $Thisyear = $CreditAtt['StarTYear'];
        } else {
            $CurentJalaliArr = $MyPersian->jgetdate();
            $Thisyear = $CurentJalaliArr['year'];
        }

        if ($PeriodType == 'M') {
            for ($ThisMon = $StarTMonth; $ThisMon <= $EndMonth; $ThisMon++) {
                $targetDate = $MyPersian->jalali_to_gregorian($Thisyear, $ThisMon, $PeriodTarget);
                $T_date = $targetDate[0];
                $T_mon = $targetDate[1];
                $T_day = $targetDate[2];
                $StartDate = "$T_date-$T_mon-$T_day";
                $targetDate = $MyPersian->jalali_to_gregorian($Thisyear, $ThisMon + 1, $PeriodTarget);
                $T_date = $targetDate[0];
                $T_mon = $targetDate[1];
                $T_day = $targetDate[2];
                $EndDate = "$T_date-$T_mon-$T_day";
                $EndDate = date($EndDate);
                $CreditData = [
                    'UserName' => $UserName,
                    'Mony' => $Mony,
                    'Type' => 1,
                    'StartDate' => $StartDate,
                    'EndDate' => $EndDate,
                    'Note' => 'Initial',
                    'TransferBy' => $Confirmer,
                    'ConfirmBy' => 'System',
                    'Confirmdate' => now(),
                    'CreditMod' => $CreditMod,
                ];
                periodicUserCredit::create($CreditData);
            }
        } else {
            $SycleCont = 1;
            for ($ThisMon = $StarTMonth; $SycleCont <= $Cycles; $ThisMon++) {
                if ($ThisMon == 13) {
                    $ThisMon = 1;
                }
                $targetDate = $MyPersian->jalali_to_gregorian($Thisyear, $ThisMon, $PeriodTarget);
                $T_date = $targetDate[0];
                $T_mon = $targetDate[1];
                $T_day = $targetDate[2];
                $StartDate = "$T_date-$T_mon-$T_day";
                if ($ThisMon == 12) {
                    $NextMonth = 1;
                    $Thisyear++;
                } else {
                    $NextMonth = $ThisMon + 1;
                }
                $targetDate = $MyPersian->jalali_to_gregorian($Thisyear, $NextMonth, $PeriodTarget);
                $T_date = $targetDate[0];
                $T_mon = $targetDate[1];
                $T_day = $targetDate[2];
                $EndDate = "$T_date-$T_mon-$T_day";
                $EndDate = date($EndDate);
                $CreditData = [
                    'UserName' => $UserName,
                    'Mony' => $Mony,
                    'Type' => 1,
                    'StartDate' => $StartDate,
                    'EndDate' => $EndDate,
                    'Note' => 'Initial',
                    'TransferBy' => $Confirmer,
                    'ConfirmBy' => 'System',
                    'Confirmdate' => now(),
                    'CreditMod' => $CreditMod,
                ];
                periodicUserCredit::create($CreditData);
                $SycleCont++;
            }
        }

        return true;
    }

    private function GetMainperiodicCredit($TargetDate, $CreditMod, $UserName)
    {
        $MainCredit = periodicUserCredit::where('UserName', $UserName)->whereDate('StartDate', '<=', date($TargetDate))->whereDate('EndDate', '>', date($TargetDate))->where('type', 1)->where('CreditMod', $CreditMod)->first();
        return $MainCredit;
    }

    public function GetRemianLimit($UserName, $CreditMod, $TargetDate)
    {
        $MainCredit = $this->GetMainperiodicCredit($TargetDate, $CreditMod, $UserName);
        if ($MainCredit == null) {
            return false;
        }
        $RelatedCredit = $this->GetRemianLimitWithRefrence($MainCredit->ID);
        return $MainCredit->Mony + $RelatedCredit;
    }

    public function GetRemianLimitWithRefrence($ReferenceId)
    {
        $RelatedCredit = periodicUserCredit::where('ReferenceId', $ReferenceId)->sum('Mony');
        return $RelatedCredit;
    }

    public function AddCreditToPeriodical($CreditAtt, $UserAtt)
    {
        $TargetDate = $CreditAtt['TargetDate'];
        $Mony = $CreditAtt['TargetMony'];
        $CreditMod = $CreditAtt['CreditMod'];
        $Note = $CreditAtt['Note'];
        $InvoiceNo = $CreditAtt['InvoiceNo'];
        $UserName = $UserAtt['UserName'];
        $Confirmer = $UserAtt['Confirmer'];
        $TargetDate = date($TargetDate);
        $MainCredit = $this->GetMainperiodicCredit($TargetDate, $CreditMod, $UserName);
        if ($MainCredit == null) {
            return false;
        } else {
            $ReferenceId = $MainCredit->ID;
            $CreditData = [
                'UserName' => $UserName,
                'Mony' => $Mony,
                'Type' => 10,
                'Date' => date($TargetDate),
                'Note' => $Note,
                'TransferBy' => $Confirmer,
                'ConfirmBy' => 'System',
                'Confirmdate' => now(),
                'CreditMod' => $CreditMod,
                'ReferenceId' => $ReferenceId,
                'InvoiceNo' => $InvoiceNo,
            ];
            periodicUserCredit::create($CreditData);
            return true;
        }
    }

    public function GetUserPeriodicStatus($UserName, $CreditMod)
    {
        $MainCredits = periodicUserCredit::where('UserName', $UserName)->where('type', 1)->where('CreditMod', $CreditMod)->get();
        $MyPersian = new persian();
        $Output = array();
        foreach ($MainCredits as $MainCredit) {
            $StartDate = $MainCredit->StartDate;
            $StartDate = strtotime($StartDate);
            $day = date('d', $StartDate);
            $month = date('m', $StartDate);
            $year = date('Y', $StartDate);
            $StartDatePersiand = $MyPersian->gregorian_to_jalali($year, $month, $day);
            $Month = $MyPersian->PersianMonthToText($StartDatePersiand[1]);
            $Year = $StartDatePersiand[0];
            $DateStr = $Month . ' ' . $Year;
            $BaseMony = $MainCredit->Mony;
            $UsedMony = $this->GetRemianLimitWithRefrence($MainCredit->ID);
            $SaveData = [
                'DateStr' => $DateStr,
                'BaseMony' => $BaseMony,
                'UsedMony' => $UsedMony,
            ];
            array_push($Output, $SaveData);
        }
        return $Output;
    }

    public function UserHasPeriodicCredit($UserName)
    {
        $Result = periodicUserCredit::where('UserName', $UserName)->count();
        if ($Result > 0) {
            return true;
        } else {
            return false;
        }
    }
}
