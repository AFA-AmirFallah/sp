<?php

namespace App\Functions;

use App\Models\branches;
use App\myappenv;
use Auth;

class TextClassMain
{
    public static function JsonComposer($Oldjson, $AddedArray)
    {

        if ($Oldjson == null) {
            $Oldjson = $AddedArray;
        } else {
            $Oldjson = json_decode($Oldjson);
            foreach ($AddedArray as $indexname => $extradataItem) {
                $Oldjson->$indexname = $extradataItem;
            }
        }
        $Oldjson = json_encode($Oldjson);
        return $Oldjson;
    }
    public static function StripText($InputText)
    {
        $OutPutText = strip_tags($InputText);
        $OutPutText = str_replace('&nbsp;', ' ', $OutPutText);
        $OutPutText = str_replace('&zwnj', ' ', $OutPutText);
        $OutPutText = str_replace('/', ' ', $OutPutText);
        $OutPutText = str_replace('\\', ' ', $OutPutText);
        $OutPutText = str_replace('"', ' ', $OutPutText);
        $OutPutText = str_replace("'", ' ', $OutPutText);
        return $OutPutText;
    }
    public function InvoiceGenerate($Name, $Price, $Center, $BilNumber, $link)
    {
        $user_branch = auth::user()->branch;
        $branch_src = branches::where('id', $user_branch)->first();
        $MyText = $branch_src->Name;

        $MyText .= " کاربر گرامی " . $Name . ' صورت حساب شماره  ' . $BilNumber . " به مبلغ " . $Price . ' ریال ' . " از طرف " . $Center . " برای شما صادر شده است ";
        $MyText .= " جهت پرداخت از لینک زیر استفاده فرمایید " . $link;


        return $MyText;
    }
    public function persian_number_to_en($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        return  $convertedPersianNums;
    }
    public function PaymentfromipgRequest($Name, $Price, $Center, $link)
    {
        $user_branch = auth::user()->branch;
        $branch_src = branches::where('id', $user_branch)->first();
        $MyText = $branch_src->Name;
        $MyText .= " کاربر گرامی " . $Name . ' درخواست پرداختی به مبلغ ' . $Price . ' ریال ' . " از طرف " . $Center . " برای شما صادر شده است ";
        $MyText .= " جهت پرداخت از لینک زیر استفاده فرمایید " . $link;
        return $MyText;
    }
    public function StrRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
    public function ResetPassword($NewPass)
    {
        $SMSText = myappenv::CenterName;
        $SMSText .= '  ' . "کد یکبار مصرف شما:
                $NewPass
                ";
        //$user_branch = auth::user()->branch;
        // $branch_src = branches::where('id',$user_branch)->first();

        return $SMSText;
    }

    public function TransferMonySMS($TransferDate, $Price, $SumPrice, $Username)
    {
        $user_branch = auth::user()->branch;
        $branch_src = branches::where('id', $user_branch)->first();
        $text = $branch_src->Name;
        $centerName = myappenv::CenterName;
        $text .= "
        ";
        if ($Price > 0) {
            $text .= "افزایش اعتبار";
        } else {
            $Price *= -1;
            $text .= "کاهش اعتبار";
        }
        $text .= "مبلغ " . number_format($Price) . " ریال ";
        $text .= "مانده اعتبار شما " . number_format($SumPrice) . " ریال ";
        // $text .= "  نام کاربری  " . $Username;
        $text .= "
        تاریخ" . $TransferDate . "
        ";
        $text .= myappenv::CenterEndSmsTxt;
        return $text;
    }

    public function SetShiftResponserSMS($Position, $Qwnername, $CenterPhone, $CenterEndSmsTxt, $extra_info = null)
    {
        $user_branch = auth::user()->branch;
        $branch_src = branches::where('id', $user_branch)->first();
        $responserText = $branch_src->Name;
        if (myappenv::MainOwner == 'Ohp') {
            /*  $extra_info = [
                'responserName' => $this->service_attr_general['responserName'],
                'Ownername' => $this->service_attr_general['Qwnername'],
                'Position' => $this->service_attr_general['Position'],
                'StartDateShamsi' => $this->service_attr_general['StartDateShamsi'],
                'EndDateShamsi' => $this->service_attr_general['EndDateShamsi']
            ]; */
            $responserName = $extra_info['responserName'];
            $StartDateShamsi = $extra_info['StartDateShamsi'];
            $EndDateShamsi = $extra_info['EndDateShamsi'];
            $Position = $extra_info['Position'];
            $responserText = "بیمارستان مجازی
            همکار گرامی آقای/ خانم   $responserName  با سلام خدمت $Position از $StartDateShamsi تا $EndDateShamsi برای شما در سامانه به ثبت رسید در خدمات بالینی و پزشکی و پرستاری درصورت عدم رضایت برای ارائه خدمت ، حداکثر تا10 دقیقه با کارشناس خود در مرکز با شماره 1508 تماس حاصل فرمایید. در نظر داشته باشید پس از ثبت خدمت توسط کارشناسان امکان کنسل کردن شیفت وجود ندارد و در صورت عدم حضور یا غیبت در شیفت طبق قرارداد عمل خواهد شد.";
        } else {
            $responserText .= "
            همکار گرامی با سلام مسئولیت $Position برای  درمان بیمار $Qwnername  برای شما در طول ادامه درمان به ثبت رسید.  در صورت عدم رضایت برای ارائه خدمت، سریعا با کارشناس خود در مرکز با شماره $CenterPhone تماس حاصل فرمایید.
            $CenterEndSmsTxt";
        }
        return $responserText;
    }

    public function PayLink($Name, $amount, $note, $Centername, $TransferID)
    {
        $SmsText = $Name . " عزیز ";
        $SmsText .= "مبلغ" . $amount . " ریال" . " ";
        $SmsText .= " " . $note . " ";
        $SmsText .= " از سوی " . $Centername . " صادر گردید
        ";
        $SmsText .= ' ' . "جهت پرداخت از لینک زیر استفاده فرمایید" . '  ';
        $SmsText .= "https://shafatel.com/pep/?payment=$TransferID";
        return $SmsText;
    }
    public function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
    public function SetShiftResponserSMSPartTime($Position, $Qwnername, $StartDateShamsi, $EndDateShamsi, $CenterPhone, $CenterEndSmsTxt)
    {
        $user_branch = auth::user()->branch;
        $branch_src = branches::where('id', $user_branch)->first();
        $responserText = $branch_src->Name;

        $responserText .= "
					همکار گرامی با سلام شیفت $Position برای بیمار $Qwnername از $StartDateShamsi تا $EndDateShamsi  برای شما ثبت شد در صورت عدم رضایت برای ارائه خدمت، سریعا با کارشناس خود در مرکز با شماره $CenterPhone تماس حاصل فرمایید.
					$CenterEndSmsTxt";
        return $responserText;
    }

    public function SetShiftOwnerSMS($responserName, $Position, $CenterEndSmsTxt,$extra_info = null)
    {
        $user_branch = auth::user()->branch;
        $branch_src = branches::where('id', $user_branch)->first();
        $ownerText = $branch_src->Name;
        if (myappenv::MainOwner == 'Ohp') {
                        /*  $extra_info = [
                'responserName' => $this->service_attr_general['responserName'],
                'Ownername' => $this->service_attr_general['Qwnername'],
                'Position' => $this->service_attr_general['Position'],
                'StartDateShamsi' => $this->service_attr_general['StartDateShamsi'],
                'EndDateShamsi' => $this->service_attr_general['EndDateShamsi']
            ]; */
            $responserName = $extra_info['responserName'];
            $StartDateShamsi = $extra_info['StartDateShamsi'];
            $EndDateShamsi = $extra_info['EndDateShamsi'];
            $Position = $extra_info['Position'];
            $responserExt =  $extra_info['responserExt'];
            $card = route('PersonelCard',['RequestUser'=>$responserExt]);
            $Position = str_replace("*", "", $Position);
            $ownerText = "بیمارستان مجازی
            مشتری گرامی برنامه خدمات $Position از $StartDateShamsi تا $EndDateShamsi  توسط  $responserName از طرف کارشناسان تعیین گردید،ارائه کارت      پر سنلی در زمان شروع خدمت برای تمامی پرسنل بیمارستان مجازی الزامی می باشد. برای مشاهده کارت پرسنل مورد نظر روی لینک زیرکلیک نمایید.
             $card";
        } else {
            $Position = str_replace("*", "", $Position);
            $ownerText .= "
            مشترک گرامی  در ادامه روند درمان و مراقبت از بیمار شما  آقا/خانم $responserName به عنوان  $Position    تعیین گردید ارائه کارت پرسنلی در صورت مراجعه حضوری الزامی است.
            $CenterEndSmsTxt ";
        }

        return $ownerText;
    }

    public function SetShiftOwnerSMSPartTime($responserName, $Position, $StartDateShamsi, $EndDateShamsi, $ResponserID, $CenterEndSmsTxt)
    {
        $user_branch = auth::user()->branch;
        $branch_src = branches::where('id', $user_branch)->first();
        $ownerText = $branch_src->Name;

        $ownerText = "
        کاربر گرامی برنامه شیفت $Position از $StartDateShamsi تا $EndDateShamsi تنظیم گردید و آقا/ خانم $responserName جهت انجام برنامه شیفت مراجعه خواهند نمود.
        کارت ویزیت الکترونیک متخصص مراجعه کننده از طریق لینک زیر در دسترس شما قرار دارد
         " . myappenv::SiteAddress . "/PersonelCard/$ResponserID
         $CenterEndSmsTxt";

        return $ownerText;
    }

    public function UserAddSMS($ADDRole, $ADDUserName, $ADDPassword, $CenterName, $CenterEndSmsTxt)
    {
        if ($ADDRole == myappenv::role_customer) {
            $user_branch = auth::user()->branch;
            $branch_src = branches::where('id', $user_branch)->first();
            $MessageText = $branch_src->Name;

            $MessageText = "
                پرونده پذیرش شما در $CenterName  ثبت شد نام کاربری شما $ADDUserName و گذرواژه شما  $ADDPassword  می باشد. جهت دسترسی به پنل خود به آدرس " . myappenv::SiteAddress . "/login/   مراجعه فرمایید.
                از اینکه ما  مشاور سلامتی شما هستیم بسی خرسندیم ";
        } else {
            $user_branch = auth::user()->branch;
            $branch_src = branches::where('id', $user_branch)->first();
            $MessageText = $branch_src->Name;
            if (myappenv::MainOwner == 'Ohp') {
                $MessageText = "بیمارستان مجازی 
                ثبت نام شما توسط کارشناسان در بیمارستان مجازی انجام شد. نام کاربری شما :  $ADDUserName میباشد  فرایند فعال سازی شما در سامانه توسط مدیران بعد از ارائه و تکمیل مدارک هویتی و تخصصی شما انجام می شود. برای ورود به پنل خود و یا تکمیل اطلاعات خود از لینک زیر اقدام نمایید.
                 https://novin.hospital";
            } else {
                $MessageText .= "
                پرونده پرسنلی شما در $CenterName  ثبت شد نام کاربری شما $ADDUserName و گذرواژه شما $ADDPassword می باشد. جهت دسترسی به پنل خود به آدرس " . myappenv::SiteAddress . "/login  مراجعه فرمایید.
                $CenterEndSmsTxt";
            }
        }
        return $MessageText;
    }
}
