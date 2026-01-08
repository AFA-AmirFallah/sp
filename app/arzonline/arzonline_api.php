<?php

namespace App\arzonline;

use App\Functions\TextClassMain;

class arzonline_api
{
    public function get_token()
    {
        $curl = curl_init();
        $mytext = new TextClassMain;
        $token = $mytext->StrRandom(8);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://j.arzonline.info/authentication/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'username=site&password=asdfghjkl',
            CURLOPT_HTTPHEADER => array(
                'token: aaaa3333ss' ,
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        return ($response->token);
    }
    public function get_channel($token)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://j.arzonline.info/output/outputchannels',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'token: ' . $token
            ),
        ));
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, array());
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);


        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        return $response;
    }
    public function listbyid($channelid, $token)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://j.arzonline.info/output/listbyid?channelid=$channelid&limit=-1&messageid=0&offset=0&skip_self=false&startdatetime=&enddatetime=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'token: ' . $token
            ),
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, array());
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        $response = $response->list[0];
        return $response;
    }
}
