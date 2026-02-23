<?php

namespace App\TrobPay;
class TrobPay
{
    private $client_id = "19370196";
    private $Client_secret = "4JgbZt6KbYd0B2abECZl9zVNa2IKVCWLDL9FRlJj0L1Txubhs46MZbzzGCSXzcC5";
    private  $username = "sepehrmall.com";
    private  $password = "BaQZpAuHz3MRLxsW";
    public function getTrobpayTokenWithCurl()
    {
        $url = 'https://{url}/api/online/v1/oauth/token';
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
        return json_decode($response, true);
    }


}