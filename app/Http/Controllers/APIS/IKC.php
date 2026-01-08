<?php

namespace App\Http\Controllers\APIS;

use App\Http\Controllers\Controller;
use App\Models\transactionstemp;
use App\myappenv;
use Illuminate\Http\Request;
use Session;

class IKC extends Controller
{
    public $terminalID = '08129120';
    public $password = 'BACFCF62FD769985';
    public $acceptorId = "992180008129120";
    public $pub_key = myappenv::pub_key;

    function generateAuthenticationEnvelope($pub_key, $terminalID, $password, $amount)
    {
        $data = $terminalID . $password . str_pad($amount, 12, '0', STR_PAD_LEFT) . '00';
        $data = hex2bin($data);
        $AESSecretKey = openssl_random_pseudo_bytes(16);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($data, $cipher, $AESSecretKey, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash('sha256', $ciphertext_raw, true);
        $crypttext = '';
$pub_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDkZ2h5+rfmf0dojQdNS8L2+a9B
vmfk+kDacapNU9fAPqG2+9/wSBfupkLyJy3Uh8rBn9Nb0vFlOW27+K3pKn0cw22l
0sqt794LLg2+i/b5KMKVa21NLfzFp72zCY9BBNXBiBSf0gBVf4mFlPz0FNZwCB1g
exGAdYewIojCbkHiZQIDAQAB
-----END PUBLIC KEY-----';
        openssl_public_encrypt($AESSecretKey . $hmac, $crypttext, $pub_key);

        return array(
            "data" => bin2hex($crypttext),
            "iv" => bin2hex($iv),
        );
    }
    public function revicer(Request $request)
    {
        if ($request->has('token') && $request->input('token') != "") {
            if ($request->input('responseCode') != "00") {
                echo "failed: code " . $request->input('responseCode');
                exit;
            }
            $data = array(
                "terminalId" => $this->terminalID,
                "retrievalReferenceNumber" => $request->input('retrievalReferenceNumber'),
                "systemTraceAuditNumber" => $request->input('systemTraceAuditNumber'),
                "tokenIdentity" => $request->input('token'),
            );
            
            $data_string = json_encode($data);
            $ch = curl_init('https://ikc.shaparak.ir/api/v3/confirmation/purchase');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            ));

            $result = curl_exec($ch);
            curl_close($ch);
            if ($result === false) {
                if (myappenv::SiteTheme == 'Theme1') {
                    return redirect()->route('ConfirmPayment', ['pay' => 'IKC', 'ref' => null]);
                } else {
                    return redirect()->route('checkout', ['pay' => 'IKC', 'ref' => null]);
                }
                echo curl_error($ch);
                exit;
            }
            
            $response = json_decode($result, JSON_OBJECT_AS_ARRAY);
            $status = $response['status'];
            
            if ($status) {
                $result = $response['result'];
                $systemTraceAuditNumber = $result['systemTraceAuditNumber'];
                $amount = $result['amount'];
                $requestId = $result['requestId'];
                transactionstemp::where('strid', $requestId)->where('Amount', $amount)->update(['refnumber' => $systemTraceAuditNumber]);
                
                if (myappenv::SiteTheme == 'Theme1') {
                    return redirect()->route('ConfirmPayment', ['pay' => 'IKC', 'ref' => $systemTraceAuditNumber]);
                } else {
                    return redirect()->route('checkout', ['pay' => 'IKC', 'ref' => $systemTraceAuditNumber]);
                }
            } else {
                if (myappenv::SiteTheme == 'Theme1') {
                    return redirect()->route('ConfirmPayment', ['pay' => 'IKC', 'ref' => null]);
                } else {
                    return redirect()->route('checkout', ['pay' => 'IKC', 'ref' => null]);
                }
            }
        }
    }

    public function main(Request $request)
    {
        $terminalID = '08129120';
        $password = 'BACFCF62FD769985';
        $acceptorId = "992180008129120";
        $pub_key = myappenv::pub_key;
        $amount = Session::get('price');
        $ResNum = Session::get('ResNum');
        $token = $this->generateAuthenticationEnvelope($pub_key, $terminalID, $password, $amount);
        $data = [];
        $Uniqid = uniqid();
        $DBData = [
            'strid' => $Uniqid,
            'Amount' => $amount,
            'gateway' => 'ikc'
        ];
        transactionstemp::create($DBData);
        $data["request"] = [
            "acceptorId" => $acceptorId,
            "amount" =>  (int)$amount,
            "billInfo" => null,
            "paymentId" => null,
            "requestId" => $Uniqid,
            "requestTimestamp" => time(),
            "revertUri" => route('ikcReciver'),
            "terminalId" => $terminalID,
            "transactionType" => "Purchase"
        ];
        $data['authenticationEnvelope'] = $token;
        $data_string = json_encode($data);
        $ch = curl_init('https://ikc.shaparak.ir/api/v3/tokenization/make');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, JSON_OBJECT_AS_ARRAY);
        if ($response["responseCode"] != "00") {
            echo $response["description"];
            exit;
        }
        echo "<form method='post' id='mainform' action='https://ikc.shaparak.ir/iuiv3/IPG/Index/' enctype='Äā‚¬Ā«Äā‚¬Å–multipart/form-dataÄā‚¬Ā¬Äā‚¬Ā¬'>
            <input type='hidden' name='tokenIdentity' value='" . $response['result']['token'] . "'>
            <input type='submit' value='در صورت عدم انتقال خودکار این دکمه رو بفشارید'>
            <script>
                document.getElementById('mainform').submit();
            </script>
        </form>";
    }
}
