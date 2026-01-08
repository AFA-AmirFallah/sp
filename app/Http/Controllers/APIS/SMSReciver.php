<?php

namespace App\Http\Controllers\APIS;

use App\APIS\bale;
use App\APIS\SmsCenter;
use App\Functions\persian;
use App\Users\UserClass;
use App\Http\Controllers\Controller;
use App\Http\Controllers\notification\notification_main;
use App\Http\Controllers\Point\Points;
use App\Models\SMS;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Log;

class SMSReciver extends Controller
{
    /**
     *  Define Input SMS Type
     * @param [type] $SnderNumber
     *  @param [type] $SMSText
     *  @param [type] $SMSText
     */

    public function CheckTypeOfInputSMS($SMSAttr)
    {
        $MessageText = $SMSAttr['MessageText'];
        if ($MessageText == '۰' || $MessageText == '۱' || $MessageText == '۲' || $MessageText == '۳' || $MessageText == '۴' || $MessageText == '۵') {
            $English_Number = str_replace(

                array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'),
                array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
                $MessageText
            );
            if (is_numeric($English_Number)) {

                $TyepOFSMS = 'Poining';
                return $TyepOFSMS;
            }
        } elseif (is_numeric($MessageText)) {

            $TyepOFSMS = 'Poining';
            return $TyepOFSMS;
        } else {
            $TyepOFSMS = 'Request';
            return $TyepOFSMS;
        }
    }

    private function GiveRequest($SMSAttr)
    {
        $MessageText = $SMSAttr['MessageText'];
        $MobileNumber = $SMSAttr['MobileNumber'];
        $to = $SMSAttr['To'];
        if ($SMSAttr['To'] == '$TO' || $MessageText == 'ping from magfa' || $MobileNumber == '983000') {
            return false;
        }
        $UserResult = UserInfo::where('MobileNo', $MobileNumber)->orWhere('Phone1', $MobileNumber)->orWhere('UserName', $MobileNumber)->orWhere('Phone2', $MobileNumber)->first();
        if ($UserResult == null) {
            $SmsUser = new UserClass();
            $UserPassword = $SmsUser->GetRandomPassword(4);
            $TargetExt = $SmsUser->GetNewExtension();
            $Result = $SmsUser->AddUserBase($MobileNumber, $UserPassword, myappenv::DefaultSMSUser_Name, myappenv::DefaultSMSUser_Family, $MobileNumber, "$MobileNumber@nomail.com", myappenv::role_customer, myappenv::Default_customer_Status, $TargetExt);
            $owner = myappenv::CenterName;
            $site_address = myappenv::SiteAddress;

            $SenderSmsUser = $MobileNumber;
        } else {
            $SenderSmsUser = $UserResult->UserName;
        }
        $SmsData = [
            'Sender' => $SenderSmsUser,
            'SenderPhone' => $MobileNumber,
            'Reciver' => 'System',
            'ReciverPhone' => $to,
            'SMSTime' => now(),
            'isSend' => 0,
            'Status' => 10,
            'Message' => $MessageText,
            'Result' => ''
        ];

        SMS::create($SmsData);
        $MySMS = new SmsCenter();
        $FooterText = myappenv::CenterName;
        if (myappenv::MainOwner == 'Ohp') {
            $owner = myappenv::CenterName;
            $site_address = myappenv::SiteAddress;
            $smstext = " بیمارستان مجازی 
            مشتری گرامی ثبت نام شما همزمان با ارسال پیامک شما در بیمارستان مجازی انجام شد.
            نام کاربری شما :  $MobileNumber 
            میباشد برای ورود به پنل خود و یا تکمیل اطلاعات خود از لینک زیر اقدام نمایید.
             ضمنا جهت دریافت هر گونه راهنمایی از واحد پشتیبانی سامانه با تلفن 1508 ( بدون کد )  تماس حاصل نمایید .
            $site_address";
        } else {
            $smstext = "با تشکر پیامک شما دریافت شد
            $FooterText ";
        }


        $MySMS->OndemandSMS($smstext, $MobileNumber, 'SMS Reciver', $SenderSmsUser);
        //   echo "The example from: $MobileNumber and to: $to and body: $MessageText ";


    }
    private function NumberFormating($InputNumer)
    {
        $Len = strlen($InputNumer);

        if ($Len > 11) {

            if (substr($InputNumer, 0, 2) == '98') {

                $InputNumer = str_replace(substr($InputNumer, 0, 2), '0', $InputNumer);
            }
        }

        return $InputNumer;
    }
    private function GetSMSAttr($request, $State)
    {
        if ($State = 'magfa') {
            /**
             * $TEXT = متن پیامک
             * $KEYWORD = کلمات کلیدی
             * $FROM = شماره فرستنده
             * $TO = شماره گیرنده
             * $ENTERED_DATE = تاریخ دریافت در مگفا
             * $CHARSET = تعداد کاراکتر
             * $UDH = سرآیند پیامک
             * $STATUS = وضعیت
             * $CHK_MSG_ID = شناسه پیامک در سمت مشتری
             * $COUNt = شماره بخش پیامک
             *
             */
            $SenderNumber = $request->input('from');
            $to = $request->input('TO');

            $SenderNumber = $this->NumberFormating($SenderNumber);

            $SMSText = $request->input('message');
            $SMSAttr = [
                'MobileNumber' => $SenderNumber,
                'MessageText' => $SMSText,
                'State' => $State,
                'To' => $to,

            ];
        }

        return $SMSAttr;
    }
    public function ReturnResponse($SMSAttr)
    {
        $MobileNumber = $SMSAttr['MobileNumber'];

        $State = $SMSAttr['State'];
        if ($State = 'magfa') {
            return response('HTTP Response Code 200', 200);
        }
    }

    public function GetSMS(Request $request)
    {

        /** check type of input sms
         * * do related function
         *   if URL = https://yourDomain/SMSReciver/GetSMS?message=$TEXT&from=$FROM
         *  */
        $State = myappenv::SMSCenter;
        $SMSAttr = $this->GetSMSAttr($request, $State);
        $SMSType = $this->CheckTypeOfInputSMS($SMSAttr);

        switch ($SMSType) {
            case 'Poining':
                $Point = new Points();
                $OutPut = $Point->SetPoint($SMSAttr);
                break;
            case 'Request':
                $OutPut = $this->GiveRequest($SMSAttr);
                break;
            default:
                $OutPut = false;
        }
        return $this->ReturnResponse($SMSAttr);
    }
    private function InputProcess(string $input)
    {
        $string = $input;
        $str_arr = preg_split("/\,,,/", $string);
        $Result = [
            'apiKey' => $str_arr[0],
            'ReceiverNumber' => $str_arr[1],
            'SenderNumber' => $str_arr[2],
            'Msg' => $str_arr[3],
        ];
        return $Result;
    }

    public function MainSMSReciver(request $request)
    {
        $Destination = $request->input('Destination'); // &Source=$Source&ReceiveTime=$ReceiveTime&MsgBody=$MsgBody
        $Source = $request->input('Source');
        $body = $request->input('MsgBody');
        $ReciveSmsKey = $request->input('ReciveSmsKey');
        //Log::info('success  ' . " Destination = $Destination" . " Source = $Source" . " MsgBody = $body and ReciveSmsKey= $ReciveSmsKey");
        if ($ReciveSmsKey == myappenv::ReciveSmsKey) {
            $my_voip = new VOIP;
            $from = $my_voip->NumberFormater($Source);
            $from = $from['OutputNumber'];
            $UserResult = UserInfo::where('MobileNo', $from)->orWhere('Phone1', $from)->orWhere('Phone2', $from)->first();
            if ($UserResult == null) {
                $SmsUser = new UserClass();
                $UserPassword = $SmsUser->GetRandomPassword(4);
                $TargetExt = $SmsUser->GetNewExtension();
                $Result = $SmsUser->AddUserBase($from, $UserPassword, myappenv::DefaultSMSUser_Name, myappenv::DefaultSMSUser_Family, $from, "$from@nomail.com", myappenv::role_customer, myappenv::Default_customer_Status, $TargetExt);
                $SenderSmsUser = $from;
            } else {
                $SenderSmsUser = $UserResult->UserName;
            }
            $SmsData = [
                'Sender' => $SenderSmsUser,
                'SenderPhone' => $from,
                'Reciver' => 'System',
                'ReciverPhone' => 'main',
                'SMSTime' => now(),
                'isSend' => 0,
                'Status' => 10,
                'Message' => $body,
                'Result' => ''
            ];
            SMS::create($SmsData);
            $sender_info = UserInfo::where('UserName',$SenderSmsUser)->first();
            $sender_name = 'نا مشخص';
            if($sender_info != null){
                $sender_name = 'ارسال کننده: ' . $sender_info->Name .' '. $sender_info->Family ."
                شماره تلفن: ";
                $sender_name .= $sender_info->MobileNo; 
            }
            $bale = new bale;
            $send_description = " *پیامک دریافت شد*  
" . $body . " 
$sender_name";
            $bale->send_message($send_description);
            $my_notification = new notification_main;
            if ($my_notification->check_sms_is_notification_response($from, $body)) {
                $MySMS = new SmsCenter();
                $FooterText = myappenv::CenterName;
                $smstext = "با تشکر پاسخ شما به درخواست ارسالی ثبت گردید 
                $FooterText ";
                $MySMS->OndemandSMS($smstext, $from, 'SMS Reciver', $SenderSmsUser);
            } else {
                $MySMS = new SmsCenter();
                $FooterText = myappenv::CenterName;
                if (myappenv::MainOwner == 'Ohp') {
                    $MySMS = new SmsCenter();
                    $FooterText = myappenv::CenterName;
                    /* $smstext = " $owner 
                     مشتری گرامی ثبت نام شما همزمان با ارسال پیامک شما در بیمارستان مجازی انجام شد. نام کاربری شما :  $MobileNumber میباشد برای ورود به پنل خود و یا تکمیل اطلاعات خود از لینک زیر اقدام نمایید. ضمنا جهت دریافت هر گونه راهنمایی از واحد پشتیبانی سامانه با تلفن 1508 ( بدون کد )  تماس حاصل نمایید .
                     $site_address";*/
                    $smstext = "$FooterText 
با تشکر پیامک شما دریافت شد
                     ";
                } else {
                    $smstext = "با تشکر پیامک شما دریافت شد
                    $FooterText ";
                }

                $MySMS->OndemandSMS($smstext, $from, 'SMS Reciver', $SenderSmsUser);
            }
        } else {
            return abort('404');
        }
    }
    public function GetInputSMS()
    {
        $Query = "SELECT * from SMS s inner join UserInfo ui  on s.Sender = ui.UserName WHERE s.isSend = 0 and s.Status < 100";
        return DB::select($Query);
    }
}
