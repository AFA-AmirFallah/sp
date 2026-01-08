<?php

namespace App\AzkiVam;

use Illuminate\Support\Facades\Redirect;

class azkivam
{
    public $provider_id = '2204420';
    public $merchant_id = '980334';
    private $api_key = '4565175b030b173ec1398366150ab0b7cb5d973023b1eb90abbdc435b987ff85';
    public function signature($sub_url): string
    {
        $request_method = 'POST';
        $api_key = $this->api_key;
        $plain  = $sub_url . '#' . time() . '#' . $request_method . '#' . $api_key;
        $key    = hex2bin($api_key);
        $iv = str_repeat("\0", 16);
        $digest = openssl_encrypt($plain, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

        return bin2hex($digest);
    }
    private function create_ticket($amount, $mobile_number, $json_items)
    {


        $curl = curl_init();
        $Signature = $this->signature('/payment/purchase');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.azkiloan.com/payment/purchase',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "amount": ' . $amount . ',
            "redirect_uri": "https://shafatel.com/api/azki",
            "fallback_uri": "https://shafatel.com/api/azki",
            "provider_id": ' . $this->provider_id . ',
            "mobile_number": "' . $mobile_number . '",
            "merchant_id": ' . $this->merchant_id . ',
            "items": ' . $json_items . '  
        }',
            CURLOPT_HTTPHEADER => array(
                'Signature: ' . $Signature,
                'MerchantId: ' . $this->merchant_id,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        if ($response->rsCode == 0) { //success 
            return [
                'result' => true,
                'data' => $response->result
            ];
        }
        return $response;





        $redirect_uri = str_replace('http://', 'https://', route('azki_Reciver'));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.azkiloan.com/payment/purchase',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "amount": ' . $amount . ',
    "redirect_uri": ' . $redirect_uri  . ' ,
    "fallback_uri":  ' . $redirect_uri  . ',
    "provider_id": ' . $this->provider_id . ',
    "mobile_number": "' . $mobile_number . '",
    "merchant_id": ' . $this->merchant_id . ',
    "items": ' . $json_items . '  
}',
            CURLOPT_HTTPHEADER => array(
                'Signature: d06b88edbdc684db8467c1661ddf08f2e97d39123020418a362f63622105c3f38a5be1c2d1f3a66940cdf22d71b9c7c434fe950ed88a8c84a703a40cf16a68ff11a33bcb15f2e344fcebdf3a04012deb76991791e9fbe4c360c123ef8125c820',
                'MerchantId: ' . $this->merchant_id,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        if ($response->rsCode == 0) { //success 
            return [
                'result' => true,
                'data' => $response->result
            ];
        }
        return $response;
    }
    private function redirect_user_to_azki($uri)
    {
        redirect($uri);
        return Redirect::away($uri);
    }
    public function pay($amount, $mobile_number, $json_items)
    {
        /*    $items = [];

        $item = [
            'name' => 'وصل سرم',
            'count' => 1,
            'amount' => 100000
        ];
        array_push($items, $item);
        $item = [
            'name' => 'ویزیت پزشک سرم',
            'count' => 1,
            'amount' => 100000
        ];
        array_push($items, $item);
        $json_items = json_encode($items);*/
        $azki_ticket = $this->create_ticket($amount, $mobile_number, $json_items);
        if (!$azki_ticket['result']) { // create ticket failed 
            return [
                'result' => false,
                'msg' => 'failed from server'
            ];
        }

        $azki_ticket = $azki_ticket['data'];
        $payment_uri = $azki_ticket->payment_uri;
        $ticket_id = $azki_ticket->ticket_id;
        return [
            'result' => true,
            'data' => $payment_uri
        ];
    }
}
