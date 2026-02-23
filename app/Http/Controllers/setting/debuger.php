<?php

namespace App\Http\Controllers\setting;

use App\Functions\Indexes;
use App\Http\Controllers\Controller;
use App\Http\Controllers\crawler\CrawlerMain;
use App\Models\goodindex;
use App\Models\L3Work;
use App\Models\warehouse_goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Functions\CallCenterClass;

class debuger extends Controller
{
    public static function DebugEnable()
    {
        if ((session()->has('testdebug'))) {
            if (Session::get('testdebug')) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function Dodebugger(Request $request)
    {
        dd('ddd');
    }
    public function signature($sub_url, $request_method, $api_key): string
    {
        $plain  = $sub_url . '#' . time() . '#' . $request_method . '#' . $api_key;
        $key    = hex2bin($api_key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $digest = openssl_encrypt($plain, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        return bin2hex($digest);
    }
    public function send_sms()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sms.ir/v1/send/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
        "mobile": "09123936105",
        "templateId": 770112,
        "parameters": [
          {
            "name": "CODE",
            "value": "000000"
          }
        ]
      }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: text/plain',
                'x-api-key: DgbmpeZvrxfGtVD0TwAryWolFTYNAYOoKn1jQKBc3aD6lJUZhzthudjq8HbUeZLe'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function debugger(Request $request, $State = null)
    {
        $trobpay = new \App\TrobPay\TrobPay();
        $response = $trobpay->getTrobpayTokenWithCurl();
        dd($response);
        dd('hi');

    }
}
