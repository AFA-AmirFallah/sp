<?php


namespace App\Functions;


use App\myappenv;

class ShafatelPayClass
{
    public function ShafatelIPG($PostData)
    {
        /*
         * $PostData = [
         *   'payername' => 'امیر فلاح',
         *   'amont' => 10000,
         *   'redirectaddress' => url('/'),
         *   'centername' => myappenv::CenterName,
         *   'multipaymentdata' => '<item><iban>IR500560083580003132940001</iban><type>0</type><value>5000</value></item>',
         *   'invoiceNumber' => '13900',
         *   'Mobile' => '9123936105',
         *   'expire' => '2021-05-07',
         *   'note' => 'بابت شارژ حساب'
         * ];
         *
         */

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://shafatel.com/pep/?request=yes");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $PostData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $outputString = preg_replace('/[^0-9]/', '', $server_output);
        return $outputString;

    }

    public function GetCommission($Price){
        if($Price < 10000000){
            $commission = $Price / 100;
        }else{
            $commission = 100000;
        }
        return $commission;


    }

}
