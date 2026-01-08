<?php

namespace App\Crypto\Brokers;

class Bingx
{
    private $API_KEY = "Kv32nI1pmUPTo3cG95KxjlclujnKDU4ihAKGVwfNGcpR4AAxp4xwXHxlyGyn95GJpwTptNr2RczbYHFg";
    private $API_SECRET = "pug9Qig0OsPXB6CkDMHE6wBGWfToHF1EEWLDlUS7JndsuhUgQVlziYuQfcUnQoAPPw05D06BY81TA42ZBgQ";
    private $HOST = "open-api.bingx.com";
    public function get_all_tickers()
    {
        $api = [
            "uri" => "/openApi/swap/v2/quote/ticker",
            "method" => "GET",
            "payload" => [],
            "protocol" => "https"
        ];
    
        $result = $this->doRequest($api["protocol"], $this->HOST, $api["uri"], $api["method"], $this->API_KEY, $this->API_SECRET, $api["payload"]);
        $result = json_decode($result);
        return $result;
    }
    function main1()
    {
        $API_KEY = $this->API_KEY;
        $API_SECRET = $this->API_SECRET;
        $HOST = "open-api.bingx.com";
        $api = [
            "uri" => "/openApi/swap/v2/quote/contracts",
            "method" => "GET",
            // "payload" => [
            //     "symbol" => "BTC-USDT"
            // ],
            "payload" => [
                "example_parameter" => ""
            ],
            "protocol" => "https"
        ];

        $result = $this->doRequest($api["protocol"], $HOST, $api["uri"], $api["method"], $API_KEY, $API_SECRET, $api["payload"]);
        $result = json_decode($result);
        return $result;
    }
    public function main()
    {
    }

    private function doRequest($protocol, $host, $api, $method, $API_KEY, $API_SECRET, $payload)
    {
        $timestamp = round(microtime(true) * 1000);
        $parameters = "timestamp=" . $timestamp;

        if ($payload != null) {
            foreach ($payload as $key => $value) {
                $parameters .= "&$key=$value";
            }
        }

        $sign =  $this->calculateHmacSha256($parameters, $API_SECRET);
        $url = "{$protocol}://{$host}{$api}?{$parameters}&signature={$sign}";
        $options = [
            "http" => [
                "header" => "X-BX-APIKEY: {$API_KEY}
",
                "method" => $method
            ],
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        return $response;
    }

    private function  calculateHmacSha256($input, $key)
    {
        $hash = hash_hmac("sha256", $input, $key, true);
        $hashHex = bin2hex($hash);
        return strtolower($hashHex);
    }
}
