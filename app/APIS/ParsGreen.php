<?php

namespace App\APIS;


use App\Models\SMS;
use App\myappenv;

class ConnectToApi
{
    var $url;
    var $apikey;

    function __construct($MainUrl, $apikey)
    {
        $this->url = $MainUrl;
        $this->apikey = $apikey;
    }

    function Exec($urlpath, $req)
    {
        try {
            $this->url = $this->url . '/Apiv2/' . $urlpath;
            $ch = curl_init($this->url);
            $jsonDataEncoded = json_encode($req);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $header = array('authorization: BASIC APIKEY:' . $this->apikey, 'Content-Type: application/json;charset=utf-8');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);
            $res = json_decode($result);
            curl_close($ch);
            return $res;
        } catch (Exception $ex) {
            return '';
        }
    }
}

class SendSms_Req
{
    public $SmsBody;
    public $Mobiles;
    public $SmsNumber;
}
class SendOtp_Req
{
    public   $Mobile;
    public   $SmsCode ;
    public   $TemplateId ;
    public   $AddName;
}

class ParsGreen
{

    public function SendOtp($Mobile,$SmsCode , $TemplateId = 0)
    {
        $req = new SendOtp_Req();
        $req->Mobile  = $Mobile;
        $req->SmsCode = $SmsCode;     // otp code
        $req->TemplateId = $TemplateId; //0-6   activeating code , verify code , login code
        $req->AddName = true;      // append company name end of sms
        $apiMainurl = 'http://sms.parsgreen.ir';
        $apiKey = myappenv::SMSapiKey;
        $myApi = new ConnectToApi($apiMainurl, $apiKey);
        $res =  $myApi->Exec("Message/SendOtp", $req);

        // print json echo json_encode($res);

        // وضعیت عملیات
        $Result = $res->R_Success;
        // کد خروجی در صورتی که عملیات موفق نباشد
        $Result .= $res->R_Code;
        // توضیحی در مورد عملیات
        $Result .= $res->R_Message;
        return $Result;
    }


    public function SendSMS($MobilesArr, $SMSText)
    {
        $apiMainurl = 'http://sms.parsgreen.ir';
        $apiKey = myappenv::SMSapiKey;
        $myApi = new ConnectToApi($apiMainurl, $apiKey);
        $req = new SendSms_Req();
        $req->SmsBody = $SMSText;
        //$req->Mobiles = array('09357974553');
        $req->Mobiles = $MobilesArr;

        //اختیاری
        $req->SmsNumber = "09981801953";

        $res = $myApi->Exec("Message/SendSms", $req);

        // وضعیت عملیات
        // echo $res->R_Success;
        // کد خروجی در صورتی که عملیات موفق نباشد
        //  echo $res->R_Code;

        // توضیحی در مورد عملیات
        //  echo $res->R_Message;

        // خروجی های اختصاصی هر عملیاتمتد
        if ($res->R_Success) {
            // پیام ارسال شد
            //echo $res->R_Message;

            // در صورت نیاز به خروجی هر ارسال گروهی
            foreach ($res->DataList as $item) {
                // وضعیت ارسال
                $result = $item->SendStatus;
                // شماره موبایل
                $result .= $item->Mobile;
                // شناسه ارسال
                $result .= $item->ReqID;
            }
            $inputsms = [
                'Sender' => 'system',
                'SenderPhone' => '4148',
                'Reciver' => $MobilesArr[0],
                'ReciverPhone' => $MobilesArr[0],
                'isSend' => 1,
                'SMSTime' => now(),
                'Status' => 1,
                'Message' => $SMSText,
                'Result' => $result
            ];
            sms::create($inputsms);
        } else {
            // علت عدم ارسال پیام
            //echo $res->R_Message;
        }
        // print json echo jso
    }

    public function OndemandSMS($ownerText, $OwnerMobile, $SMSType, $RequestUser)
    {
        $ownerText = str_replace("| زنجیره تامین سلامت", " ", $ownerText);
        $Mobiles = array($OwnerMobile);
        $this->SendSMS($Mobiles, $ownerText);
        //todo: add Sms to database
    }
}
