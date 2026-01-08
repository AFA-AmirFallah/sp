<?php

namespace App\Http\Controllers\APIS;

use App\AzkiVam\azkivam;
use App\Functions\TextClassMain;
use App\Models\transactionstemp;
use App\myappenv;
use Illuminate\Http\Request;
use mysqli;
use Ramsey\Uuid\Type\Integer;

class azki
{

    public function pay_ipg(int $Amount, string $Description, $branch = myappenv::Branch)
    {
        $mytest = new TextClassMain;
        $ClientUniqueId = $mytest->StrRandom();
        $WalletNumber = myappenv::ipg_info['WalletNumber'];
        $RedirectUrl = route('poolkhord_Reciver');
        if (myappenv::httpsforce) {
            $RedirectUrl = preg_replace("/^http:/i", "https:", $RedirectUrl);
        }
        $fields = array(
            'WalletNumber' => $WalletNumber,
            'Amount' => $Amount,
            'ClientUniqueId' => $ClientUniqueId,
            'RedirectUrl' => $RedirectUrl,
            'RedirectType' => 2,
            'Description' => $Description,
            'Currency' => 'IRR'
        );
        $params = http_build_query($fields);
        $api_secret = myappenv::ipg_info['api_secret'];
        $signature = hash_hmac('sha256', urldecode($params), $api_secret);
        $ch = curl_init('https://api.poolkhord.com/v1/epay/ipg');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'X-MBX-APIKEY:' . myappenv::ipg_info['APIKEY'],
            'Signature: ' . $signature,
            'Content-Length' . strlen($params)
        ));

        $result = curl_exec($ch);
        if (!$result) {
            die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }
        $result = json_decode($result, true);
        curl_close($ch);
        $Token = $result['token'];
        $paymentLink = $result['paymentLink'];
        $DBData = [
            'strid' => $ClientUniqueId,
            'Amount' => $Amount,
            'refnumber' => '',
            'gateway' => 'pol'
        ];
        transactionstemp::create($DBData);
        return redirect()->to($paymentLink);
    }
    public function receiver(Request $request)
    {
        $vam = new azkivam;
        $Signature = $vam->signature('/payment/verify');
        $curl = curl_init();
        $ticketId = $request->ticketId;
        $data = array( 'ticket_id' => $ticketId );
        $data['merchant_id'] = $vam->merchant_id;
        $data = json_encode($data);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.azkiloan.com/payment/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Signature: ' . $Signature,
                'MerchantId:'. $vam->merchant_id ,
                'Content-Type: application/json',
                'Content-Length: ' . strlen( $data )
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response,1);
        if($response['rsCode'] == 0){
            // success
            dd('success', $response ,$response['result']['ticket_id'],$response['result']['status']) ;
        }
        dd('error', $response) ;
        return 'مشکلی در پرداخت به وجود آمده است!';
       

        dd($request);
        $ReferenceId = $request->ReferenceId;
        $Amount = $request->Amount;
        $fields = array(
            'ReferenceId' => $ReferenceId
        );
        $params = http_build_query($fields);
        $api_secret = myappenv::ipg_info['api_secret'];
        $signature = hash_hmac('sha256', urldecode($params), $api_secret);
        $ch = curl_init('https://api.poolkhord.com/v1/epay/verify');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'X-MBX-APIKEY: ' . myappenv::ipg_info['APIKEY'],
            'Signature: ' . $signature,
            'Content-Length' . strlen($params)
        ));

        $result = curl_exec($ch);
        if (!$result) {
            return abort('404', 'Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }
        $result = json_decode($result, true);
        curl_close($ch);
        if (isset($result['status'])) {
            if ($result['status'] == "Paid") {
                $bankReferenceId = $result['bankReferenceId']; //"bankReferenceId" => "GmshtyjwKSslcdiKj7zVUjcR9cwxYRZ9qu+CCYVwmr"
                $securePan = $result['securePan']; // "securePan" => "622106******1237"
                $clientUniqueId = $result['clientUniqueId']; // "clientUniqueId" => "err3443"
                $amount = $result['amount']; // "amount" => 20000.0
                transactionstemp::where('strid', $clientUniqueId)->where('Amount', $amount)->update(['refnumber' => $bankReferenceId]);
                return redirect()->route('checkout', ['pay' => 'pol', 'ref' => $bankReferenceId]);
            }
        }

        /*
        "token" => "mzP8FOge2jn"
        "status" => "Paid"
        "amount" => 20000.0
        "message" => "تراکنش موفق"
        "bankReferenceId" => "GmshtyjwKSslcdiKj7zVUjcR9cwxYRZ9qu+CCYVwmr"
        "rrn" => "22560922880"
        "securePan" => "622106******1237"
        "cid" => "5C7ACA063C34D50037459E1271E79B840C89BA1D67161C505D5A52FAE124DF05"
        "clientUniqueId" => "err3443"
        "createdDateTime" => 1691930199800
        "paidDateTime" => 1691930200020
        "verifiedDateTime" => 1691931049862 */


        return abort('404', 'مشکلی در پرداخت بوجود آمده است لطفا در صورت کسر مبلغ با پشتیبانی تماس بگیرید!');
    }
}
