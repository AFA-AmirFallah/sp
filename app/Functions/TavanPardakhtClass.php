<?php

namespace App\Functions;

use App\APIS\SmsCenter;
use App\Functions\periodicCreditClass;
use App\Functions\persian;
use App\Http\Controllers\Credit\Reports;
use App\Models\UserInfo;
use App\Models\periodicUserCredit;
use stdClass;

class TavanPardakhtClass
{
    private function SpecialUserPerWorks($UserTarget, $TavanPardakht, $SycleCount = null)
    {
        $myclass = new periodicCreditClass();
        $MyPersian = new persian();
        $CreditAtt['CreditMod'] = 3;

        $CreditAtt['EndTMonth'] = null;
        if ($SycleCount != null) {
            $CreditAtt['SycleCount'] = $SycleCount;
            $periodicUserCredits = periodicUserCredit::where('UserName', $UserTarget)->where('Type', 1)->latest('StartDate')->first();
            $MiladiDate =  $periodicUserCredits->StartDate;
            $ShamsiDate = $MyPersian->GetShasmiDate($MiladiDate);
            $CreditAtt['StarTMonth'] = $ShamsiDate[1] + 1;
            $CreditAtt['StarTYear'] = $ShamsiDate[0];
        } else {
            $CreditAtt['StarTMonth'] = $MyPersian->GetCurentShamsiMonth();
            $CreditAtt['SycleCount'] = 18;
            $CreditAtt['StarTYear'] = null;
        }

        $CreditAtt['PeriodTarget'] = 29;
        $CreditAtt['Mony'] = $TavanPardakht;
        $UserAtt['UserName'] = $UserTarget;
        $UserAtt['Confirmer'] = 'system';

        $myclass->AddPeriodicalPrice($CreditAtt, $UserAtt);
        /*
        $TransactionData = [  //Add Tavan Pardakht To customer
        'UserName' => $UserTarget->UserName,
        'Mony' => $TavanPardakht,
        'Type' => 23,
        'Date' => now(),
        'Note' => 'توان پرداخت محاسبه شده توسط مرکز',
        'TransferBy' => 'system',
        'CreditMod' => 3,
        'ConfirmBy' => 'system',
        'GateWay' => 'STA',
        'Confirmdate' => now(),
        'branch' => 0
        ];
        UserCredit::create($TransactionData);*/
        return true;
    }
    public function tavanpardakhtAdminfn($UserAttr, $Periodcredit = null)
    {
        $TargetMelliID = $UserAttr['TargetMelliID'];
        $TargetMobileNumber = $UserAttr['TargetMobileNumber'];



        if ($TargetMelliID == '' || $TargetMelliID == null) {
            return 'کد ملی برای کاربر تعریف نشده است!';
        }
        $UsersSrc = UserInfo::where('MelliID', $TargetMelliID)->where('MobileNo', $TargetMobileNumber)->first();

        if ($UsersSrc == null) {
            return 'کاربر با کد ملی وارد شده وجود ندارد';
        } else {
            /*  $Conter = 0;
            foreach ($UsersSrc as $UsersSrcItem) {
                $Conter++;

            } */
            /*  if ($Conter > 1) {
                return 'از کد ملی وارد شده بیشتر از یک کاربر وجود دارد';
            } */
            $UserTarget = $UsersSrc;
            $targetMobile = $UsersSrc->MobileNo;
            $targetUerName = $UsersSrc->UserName;
        }
        $Tavan = new Reports();

        if ($TargetMelliID == '0123456789') { // just for test
            $TavanSrc = [
                "personType" => "RETIRED",
                "identificationCode" => "00000011111",
                "hogs" => "118669650",
                "pard" => "80010273",
                "tavg" => "9522255",
                "hogm" => "122743545",
                "fullName" => "حمید شجاع الدینی",
                "tham" => $targetMobile,
            ];
            $TavanSrc = json_decode(json_encode($TavanSrc));
        } else {
            $TavanSrc = $Tavan->Estelam($TargetMelliID);
        }

        /*
        +"personType": "RETIRED"
        +"identificationCode": "2225303512200"
        +"hogs": "118669650"
        +"pard": "102739074"
        +"tavg": "65916011"
        +"hogm": "122743545"
        +"fullName": "حمید شجاع الدینی"
        +"tham": "09121302234"
         */
        // todo tavan pardakht
        if (isset($TavanSrc->tham)) {
            $tham = $TavanSrc->tham;

            if ($UserTarget->MobileNo == $tham) {
                $identificationCode = $TavanSrc->identificationCode;
                $tavg = $TavanSrc->tavg;
                $hogm = $TavanSrc->hogm;
                $UserFullName = $TavanSrc->fullName;
                $TargetUser = UserInfo::where('UserName', $UserTarget->UserName)->first();
                $myclass = new periodicCreditClass();
                if ($myclass->HavePeriodicalPrice($UserTarget->UserName)) {

                    if ($Periodcredit != null) {
                        $this->SpecialUserPerWorks($UserTarget->UserName, $TavanSrc->tavg, $Periodcredit);
                        $Message =  '<p style="color: red;">  دوره اضافه گردید  </p>';
                        $Message .= "
                        <p style='color: red;' >لطفا اطلاعات کاربر را با اطلاعات دریافتی از سازمان مجددا تطبیق دهید </p>
                        <p> نام ثبت شده :  $UserFullName </p>
                        <p> کد بازنشستگی:  $identificationCode </p>
                        <p> توان پرداخت : $tavg  ریال </p>
                        <p>حقوق و مزایا:   $hogm  ریال </p>
                        <p> شماره موبایل: $tham </p>
                       ";
                    } else {
                        $myclass->UpdatePeriodicalPrice($tavg, $UserTarget->UserName);
                        $Message =  '<p style="color: red;"> توان پرداخت به روزرسانی شد </p>';
                        $Message .= "
                        <p style='color: red;' >لطفا اطلاعات کاربر را با اطلاعات دریافتی از سازمان مجددا تطبیق دهید </p>
                        <p> نام ثبت شده :  $UserFullName </p>
                        <p> کد بازنشستگی:  $identificationCode </p>
                        <p> توان پرداخت : $tavg  ریال </p>
                        <p>حقوق و مزایا:   $hogm  ریال </p>
                        <p> شماره موبایل: $tham </p>
                       ";
                    }
                } else {
                    $extradata = $TargetUser->extradata;
                    if ($extradata == null || $extradata == '') {
                    } else {
                    }
                    if ($UserTarget->CreditePlan != 1) {
                        $Modyfy = [ // Todo: zahra add other information
                            'CreditePlan' => 1,
                        ];
                        UserInfo::where('UserName', $UserTarget->UserName)->update($Modyfy);
                    }

                    $extradata = new stdClass();
                    $extradata->BazCode = $identificationCode;
                    $extradata->tavg = $TavanSrc->tavg;
                    $myUser = new UserClass();
                    $myUser->AddExtraData($UserTarget->UserName, $extradata);
                    $this->SpecialUserPerWorks($UserTarget->UserName, $TavanSrc->tavg);
                    $MessageText = $UserFullName . ' عزیز وضیعت کاربری شما در سامانه کوک باز به کاربر ویژه تغییر پیدا کرد ';
                    $Mysms = new SmsCenter();
                    $Mysms->OndemandSMS($MessageText, $tham, 'SystemUA', $UserTarget->UserName);
                    $Message = 'کاربر به کاربر ویژه تغییر وضعیت داد!';
                    $Message .= "<br>
                    <p style:'color:red' >لطفااطاعات هویتی کاربر را با اطلاعات سازمان تطبیق دهید </p>
                    <p> نام ثبت شده :  $UserFullName </p>
                    <p> کد بازنشستگی:  $identificationCode </p>
                    <p> شماره موبایل: $tham </p>
                    <p> توان پرداخت : $tavg  ریال </p>
                    <p>حقوق و مزایا:   $hogm  ریال </p>
                    ";
                }




                $result = true;
                return array("message" => $Message, "result" => $result);

            } else {
                $Message  = "شماره موبایل ثبت شده در مرکز با شماره سیستم تطابق ندارد لطفا با شماره موبایل ثبت شده در مرکز کاربری جدید ایجاد کنید. <br> $tham";
                $result = 0;
                return array("message" => $Message, "result" => $result, "mobile_number" => $tham);
            }
        } else {
            $Message  = "کد ملی شناسایی نشد!";
            $result = 1;
            return array("message" => $Message, "result" => $result);

        }
    }
}
