<?php

namespace App\APIS;

use App\myappenv;
use Illuminate\Support\Facades\Log;

class SMSDotIR
{
    private function fast_send($array, $temp_id, $phone)
    {

        $parameter = json_encode($array);
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.sms.ir/v1/send/verify',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
        "mobile": "' . $phone . '",
        "templateId": ' . $temp_id . ',
        "parameters":  ' . $parameter . '
      }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: text/plain',
                    'x-api-key: DgbmpeZvrxfGtVD0TwAryWolFTYNAYOoKn1jQKBc3aD6lJUZhzthudjq8HbUeZLe'
                ),
            )
        );

        $response = curl_exec($curl);
        /*       if ($response === false) {
                   echo "Curl error: " . curl_error($curl);
               } else {
                   echo 'log => ' . $response;
               } */
        curl_close($curl);
        return true;
    }
    public function send_order_final($CODE, $PhoneNumber)
    {
        return $this->fast_send($CODE, 525271, $PhoneNumber);
    }
    public function send_manager_alert($CODE, $PhoneNumber)
    {
        return $this->fast_send($CODE, 530094, $PhoneNumber);
    }
    public function system_line_alert($CODE, $PhoneNumber)
    {
        return $this->fast_send($CODE, 630517, $PhoneNumber);
    }
    public function TransactionReminders($CODE, $PhoneNumber) // add credit 
    {
        return $this->fast_send($CODE, 462115, $PhoneNumber);
    }
    public function exist_alert($CODE, $PhoneNumber)
    {
        return $this->fast_send($CODE, 860522, $PhoneNumber);
    }
    public function manual_sms($CODE, $PhoneNumber, $fastID)
    {
        return $this->fast_send($CODE, $fastID, $PhoneNumber);
    }

    public function send_manager_statistic($CODE, $PhoneNumber)
    {
        return $this->fast_send($CODE, 312383, $PhoneNumber);
    }
    public function send_code($CODE, $PhoneNumber)
    {
        $arr = [
            [
                "name" => "CODE",
                "value" => $CODE
            ]
        ];


        return $this->fast_send($arr, 973663, $PhoneNumber);
    }

    public function send_code_bck($CODE, $PhoneNumber)
    {
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.sms.ir/v1/send/verify',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
        "mobile": "' . $PhoneNumber . '",
        "templateId": 973663,
        "parameters": [
          {
            "name": "CODE",
            "value": "' . $CODE . '"
          }
        ]
      }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: text/plain',
                    'x-api-key: DgbmpeZvrxfGtVD0TwAryWolFTYNAYOoKn1jQKBc3aD6lJUZhzthudjq8HbUeZLe'
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        return true;
    }

    /**
     * This is a test for github
     */
    public function SendSMS($Message, $PhoneNumber)
    {
        $username = myappenv::SMSusername;
        $password = myappenv::SMSapiKey;
        $smsLine = myappenv::SMSLine;
        $curl = curl_init();
        if (is_array($PhoneNumber)) {
            $temp = '';
            foreach ($PhoneNumber as $PhoneNumber_target) {
                if ($temp == '') { //first insert
                    $temp .= "$PhoneNumber_target";
                } else {
                    $temp .= ", $PhoneNumber_target";
                }
            }
            $PhoneNumber = $temp;
        }
        curl_setopt_array(
            $curl,
            array(
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
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;




    }
}
