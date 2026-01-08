<?php

namespace App\APIS;

use App\myappenv;
use Illuminate\Support\Facades\Log;

class AsanakSMS
{

    /**
     * This is a test for github
     */
    public function SendSMS($Message,$PhoneNumber)
    {
        $username = myappenv::SMSusername;
        $password = myappenv::SMSapiKey;
        $smsLine = myappenv::SMSLine;
        $curl = curl_init();
        if(is_array($PhoneNumber) ){
            $temp = '';
            foreach($PhoneNumber as $PhoneNumber_target){
                if($temp == ''){ //first insert
                    $temp .= "$PhoneNumber_target";
                }else{
                    $temp .= ", $PhoneNumber_target";
                }
            }
            $PhoneNumber = $temp;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://panel.asanak.com/webservice/v1rest/sendsms",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'username' => $username,
                'password' => $password,
                'Source' => $smsLine,
                'Message' => $Message,
                'destination' => $PhoneNumber
            ),
        ));

        $response = curl_exec($curl);
        Log::channel('local')->info($response);
        curl_close($curl);
        return $response;
    }
}
