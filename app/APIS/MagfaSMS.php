<?php

namespace App\APIS;

use App\myappenv;
use Exception;
use SoapClient;
use Throwable;

class MagfaSMS
{
    public function SendSMS($TextArr, $PhoneArr)
    {
        try{
            $username = myappenv::SMSusername;
            $password = myappenv::SMSapiKey;
            $domain = 'magfa';
    
            // url
            $url = 'https://webservice.magfa.com/api/soap/sms/v2/server?wsdl';
            // soap options
            $options = [
                'login' => "$username/$domain", 'password' => $password, // -Credientials
                'cache_wsdl' => WSDL_CACHE_NONE, // -No WSDL Cache
                'compression' => (SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | 5), // -Compression *
                'trace' => false // -Optional (debug)
            ];
            // * Accept response compression and compress requests using gzip with compression level 5
    
            // soap client
            $client = new SoapClient($url, $options);
            // send
            $result['send'] = $client->send(
                $TextArr, // messages
                [myappenv::SMSLine], // short numbers can be 1 or same count as recipients (mobiles)
                $PhoneArr, // recipients
                [198981], // client-side unique IDs.
                [], // Encodings are optional, The system will guess it, itself ;)
                [], // UDHs, Please read Magfa UDH Documnet
                [] // Message priorities (unused).
            );
      
            $result = $result['send']->messages;
            
            return $result;
            
        }catch (Throwable $e) {
        
            return false;
        }

    }
}
