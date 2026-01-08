<?php

namespace App\Http\Controllers\APIS;

use App\Http\Controllers\Controller;
use App\myappenv;
use Illuminate\Http\Request;

class MgtCenter extends Controller
{
    private function App_key(){
        return getenv('APP_KEY');
    }   

    public function test_get_form_mgt_center($RequestName, $RequestData = null)
    {
        $Customer = 'test';
        $PASSPHRASE = 'test';
        $API = 'test';
        $timestamp = intval(microtime(true) * 1000);
        $RequestData = is_array($RequestData) ? json_encode($RequestData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $RequestData;
        $headers = [];
        $headers[] = "Content-Type:application/json";
        $headers[] = "DGKAR-API-KEY: " . $API;
        $headers[] = "DGKAR-API-TIMESTAMP: ".$timestamp;
        $headers[] = "DGKAR-API-Customer: ".$Customer  ;
        $headers[] = "DGKAR-API-PASSPHRASE: " . $PASSPHRASE ;
       // $requestPath = 'https://api.dgkar.com/api/' . $RequestName;
        $requestPath = 'http://localhost:8000/api/webservice/' . $RequestName;
        $response = $this->http_request($requestPath, $headers, $RequestData);
       // $response = json_decode($response, true);
      // 'http://localhost:8000/api/webservice/voip'
        return $response;
    }






    public function get_form_mgt_center($RequestName, $RequestData = null)
    {
        $Customer = getenv('APP_NAME');
        $PASSPHRASE = getenv('PASSPHRASE');
        $timestamp = intval(microtime(true) * 1000);
        $RequestData = is_array($RequestData) ? json_encode($RequestData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $RequestData;
        $SignData = $this->signature($RequestData,$timestamp);
        $headers = [];
        $headers[] = "Content-Type:application/json";
        $headers[] = "DGKAR-API-KEY: " . $this->App_key();
        $headers[] = "DGKAR-API-TIMESTAMP: ".$timestamp;
        $headers[] = "DGKAR-API-Customer: ".$Customer  ;
        $headers[] = "DGKAR-API-PASSPHRASE: " . $PASSPHRASE ;
        $headers[] = "DGKAR-API-SIGN: ".$SignData;

        $requestPath = 'https://api.dgkar.com/api/' . $RequestName;

        $response = $this->http_request($requestPath, $headers, $RequestData);
        $response = json_decode($response, true);
        return $response;
    }
    private function http_request($url, $headers = [], $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }
    private function signature( $body = '', $timestamp = false)
    {
        $secret = 'sfdfs';

        
        $timestamp = $timestamp ? $timestamp : time();

        $what = $timestamp  . $body;

        return base64_encode(hash_hmac("sha256", $what, $secret, true));
    }

}
