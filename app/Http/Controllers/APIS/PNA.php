<?php

namespace App\Http\Controllers\APIS;

use App\Http\Controllers\Controller;
use App\Models\transactionstemp;
use Illuminate\Http\Request;

class PNA extends Controller
{
    public function revicer(Request $request)
    {

        if ($request->has('token') && $request->input('token') != "") {


            if ($request->input('State') != "OK") {
                echo "failed: code " . $request->input('State');
                return false;
            }

            $Username     = '011578717';
            $Password     = '9915758808';
            $Token =  $request->input('token');
            $RefNum =  $request->input('RefNum');
            $ResNum =  $request->input('ResNum');
            $amount = $request->input('transactionAmount');
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://pna.shaparak.ir/ref-payment2/RestServices/mts/verifyMerchantTrans/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                "WSContext":{"UserId":"' . $Username . '","Password":"' . $Password . '"},
                "Token":"' . $Token . '",
                "RefNum":"' . $RefNum . '"
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $Verification = curl_exec($curl);
            curl_close($curl);
            $Verification = json_decode($Verification);
            $Result = !empty($Verification->Result) ? $Verification->Result : 'erMts_UnknownError';
            if ($Result == 'erSucceed') {
                if (!empty($Verification->Amount)) {
                    transactionstemp::where('strid', $ResNum)->where('Amount', $amount)->update(['refnumber' => $RefNum]);
                    return redirect()->route('ConfirmPayment', ['pay' => 'PNA', 'ref' => $RefNum]);
                } else {
                    $Result = 'erScm_AmountNotEqualWithOrgTransAmount';
                }
            } else {
                return false;
            }
        }
    }
}
