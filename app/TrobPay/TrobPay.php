<?php

namespace App\TrobPay;

use Illuminate\Support\Facades\Http;

class TrobPay
{
    private $client_id = "19370196";
    private $Client_secret = "4JgbZt6KbYd0B2abECZl9zVNa2IKVCWLDL9FRlJj0L1Txubhs46MZbzzGCSXzcC5";
    private $username = "sepehrmall.com";
    private $password = "BaQZpAuHz3MRLxsW";
    public function getTrobpayTokenWithCurl()
    {
        $url = 'https://cpg.torobpay.com/api/online/payment/v1/token';
        $payload = json_encode([
            'username' => $this->username,
            'password' => $this->password,
        ]);
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode($this->client_id . ':' . $this->Client_secret),
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => $payload,
        ]);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error) {
            return ['error' => $error];
        }
        $result = json_decode($response, true);
        return $result;
        if (!isset($result['access_token'])) {
            return [
                'result' => false,
                'msg' => $result['error_description'] ?? 'خطا در دریافت توکن'
            ];
        }

        $token = $result['access_token'];
        $url = 'https://cpg.torobpay.com/api/online/offer/v1/eligible?amount=12000000';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($url);
        if ($response->successful()) {
            return $response->json();
        }
        return [
            'error' => true,
            'status' => $response->status(),
            'body' => $response->body(),
        ];

    }
    public function validate_pay()
    {
        $url = 'https://cpg.torobpay.com/api/online/v1/oauth/token';
        $payload = json_encode([
            'username' => $this->username,
            'password' => $this->password,
        ]);
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode($this->client_id . ':' . $this->Client_secret),
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => $payload,
        ]);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error) {
            return ['error' => $error];
        }
        $result = json_decode($response, true);
        if (!isset($result['access_token'])) {
            return [
                'result' => false,
                'msg' => $result['error_description'] ?? 'خطا در دریافت توکن'
            ];
        }

        $token = $result['access_token'];
        $url = 'https://cpg.torobpay.com/api/online/offer/v1/eligible?amount=12000000';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($url);
        if ($response->successful()) {
            return $response->json();
        }
        return [
            'error' => true,
            'status' => $response->status(),
            'body' => $response->body(),
        ];

    }



}