<?php

namespace App\Crypto\Brokers;

use App\Models\UserInfo;

class Kucoin
{
    public $host = 'https://api.kucoin.com'; //production
    public $futurehost = 'https://api-futures.kucoin.com'; //production
    public $key;
    public $secret;
    public $passphrase;
    public $UserName;
    public $symbols = null;

    public function __construct($UserName = 'system')
    {
        if ($UserName == null) {
            $this->key = '63d558a2f651540001e316d0';
            $this->secret = '6ad7a10d-6c40-4e14-9470-6790162dbbab';
            $this->passphrase = 'Ava13940916';
            $this->UserName = $UserName;
        } else {
            return $this->SetSecrets($UserName);
        }
    }
    public function SetSecrets($UserName)
    {
        if ($UserName == $this->UserName) {
            return true;
        } else {
            $UserInfo = UserInfo::where('UserName', $UserName)->first();
            if ($UserInfo == null) {
                return false;
            }
            $extradata = json_decode($UserInfo->extradata, true);

            $this->key = $extradata['KC_key'] ?? null;
            $this->secret = $extradata['KC_secret'] ?? null;
            $this->passphrase = $extradata['KC_passphrase'] ?? null;
            $this->UserName = $UserName;
            if ($this->key == null) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function get_all_tickers()
    {
        $endpoint = '/api/v1/market/allTickers';
        $result = $this->BaseConnect($endpoint);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    private function BaseConnect($endpoint, $type = 'GET', $body = '')
    {
        $host = $this->host;
        $key = $this->key;
        $passphrase = $this->passphrase;
        $timestamp = intval(microtime(true) * 1000);
        $headers = [];
        $headers[] = "Content-Type:application/json";
        $headers[] = "KC-API-KEY:" . $key;
        $headers[] = "KC-API-TIMESTAMP:" . $timestamp;
        $headers[] = "KC-API-PASSPHRASE:" . $passphrase;
        $headers[] = "KC-API-SIGN:" . $this->signature($endpoint, $body, $timestamp, $type);

        $requestPath = $host . $endpoint;

        $response = $this->http_request($type, $requestPath, $headers, $body);
        $response = json_decode($response, true);
        return $response;
    }
    private function http_request($method = 'GET', $url, $headers = [], $data = null)
    {
        //echo "send {$method} request to {$url}:\n";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, TRUE);

        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        if ($method == 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }
    private function signature($request_path = '', $body = '', $timestamp = false, $method = 'GET')
    {
        $secret = $this->secret;

        $body = is_array($body) ? json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $body;
        $timestamp = $timestamp ? $timestamp : time();

        $what = $timestamp . $method . $request_path . $body;

        return base64_encode(hash_hmac("sha256", $what, $secret, true));
    }
}
