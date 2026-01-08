<?php

namespace App\APIS;

use App\myappenv;
use App\APIS\AsanakSMS;
use Illuminate\Support\Facades\Log;

class SmsCenter{
    public function OndemandSMS($ownerText, $OwnerMobile, $SMSType, $RequestUser,$OtpContent = null){
        if(13 == 12 ){ // send sms to slack
            if($SMSType == 'otp'){
                Log::channel('slack')->info($OtpContent . ' otp on : ' . $OwnerMobile . ' ' . \Request::ip());
            }else{
                Log::channel('slack')->info($ownerText . ' sms on: '.$OwnerMobile . ' ' . \Request::ip());
   
            }
            
        }
        elseif(myappenv::SMSCenter == 'ParsGreen'){
            if($SMSType == 'otp'){
                $MyParsgreen = new ParsGreen();
                $MyParsgreen->SendOtp($OwnerMobile,$OtpContent,4);
            }else{
                $MyCenter = new ParsGreen();
                $MyCenter->OndemandSMS($ownerText, $OwnerMobile, $SMSType, $RequestUser);
    
            }
    
        }elseif(myappenv::SMSCenter == 'Magfa'){
            $MyCenter = new MagfaSMS();
            $MyCenter->SendSMS([$ownerText],[$OwnerMobile]);
        }elseif(myappenv::SMSCenter == 'AsanakSMS'){
            $MyCenter = new AsanakSMS();
            return $MyCenter->SendSMS($ownerText,$OwnerMobile);
        }elseif(myappenv::SMSCenter == 'sms.ir'){
                if($SMSType == 'otp'){
                $MyCenter = new SMSDotIR();
                $MyCenter->send_code($OtpContent,$OwnerMobile);
                return true;
            }
            $MyCenter = new SMSDotIR();
            return $MyCenter->SendSMS($ownerText,$OwnerMobile);
        }
    }

}