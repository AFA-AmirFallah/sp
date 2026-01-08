<?php

namespace App\Http\Controllers\Credit;

use App\AzkiVam\azkivam;
use App\Functions\TextClassMain;
use App\Http\Controllers\APIS\poolkhord;
use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\UserCredit;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Http\Request;
use App\Models\branches;
use App\Models\DeviceContract;
use App\Models\DeviceItemExternal;
use App\Models\product_order;
use App\Models\transactionstemp;
use Illuminate\Support\Facades\Auth;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use SoapClient;
use Session;
use DateTime;
use App\PEP\RSAProcessor;
use App\PEP\RSAKeyType;
use App\zarinpal\zarinpal;
use Hamcrest\Type\IsNumeric;

class DirectPayment extends Controller
{

    public function nextpay()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://nextpay.org/nx/gateway/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'api_key=2cd63c82-025f-4f9d-8626-57b031ca1bd2&amount=200000&order_id=85NX85s47&customer_phone=09123936105&custom_json_fields={ "productName":"Shoes752" , "id":52 }&callback_uri=https://yourWebsite.com/callback',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        return true;

        $price = Session::get('price');
        $finoward_token = Session::get('finoward_token');
        $Note = Session::get('Note') ?? '';
        if (Session::has('finoward_token')) {
            $url = 'http://wdb24.com/curl-post-test.php';
            $cURL = curl_init();
            $postDataArray = [
                "confirm" => $finoward_token
            ];
            $data = http_build_query($postDataArray);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://finoward.ir/ipg.php');
            curl_setopt($cURL, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($cURL, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            if ($response == 'yes') {

                $CrediteData = [
                    'UserName' => Auth::id(),
                    'Mony' => $price,
                    'Type' => 15,
                    'Date' => now(),
                    'Note' => $Note,
                    'SpecialPaymentId' => $finoward_token,
                    'PaymentId' => $finoward_token,
                    'TransferBy' => 'DirectPay',
                    'bill' => 0,
                    'ConfirmBy' => 'fin',
                    'Confirmdate' => now(),
                    'GateWay' => "fin",
                    'CreditMod' => myappenv::CachCredit,
                    'branch' => Auth::user()->branch
                ];
                $Result = UserCredit::create($CrediteData);

                $UserInfo = UserInfo::where('UserName', auth::id())->first();
                $ResNum = Session::get('ResNum');
                if ($ResNum == 40) {
                    return $this->post_buy($Result, $UserInfo);
                }
                if ($ResNum == 41) {
                    return $this->signal_buy($Result, $UserInfo);
                } else {
                    return view("Credit.ConfirmPay", ['Result' => $Result, 'UserInfo' => $UserInfo]);
                }
            } else {
                return  abort(404, 'مشکلی در انجام تراکنش به وجود آمده است در صورتی که مبلغی از حساب شما کم شده است کارشناسان ما را مطلع فرمایید!');
            }
        } else {
            return abort('404', 'لینک درخواست شده وجود ندارد!');
        }
    }
    public function finpay()
    {
        $price = Session::get('price');
        $finoward_token = Session::get('finoward_token');
        $Note = Session::get('Note') ?? '';
        if (Session::has('finoward_token')) {
            $url = 'http://wdb24.com/curl-post-test.php';
            $cURL = curl_init();
            $postDataArray = [
                "confirm" => $finoward_token
            ];
            $data = http_build_query($postDataArray);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://finoward.ir/ipg.php');
            curl_setopt($cURL, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($cURL, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            if ($response == 'yes') {

                $CrediteData = [
                    'UserName' => Auth::id(),
                    'Mony' => $price,
                    'Type' => 15,
                    'Date' => now(),
                    'Note' => $Note,
                    'SpecialPaymentId' => $finoward_token,
                    'PaymentId' => $finoward_token,
                    'TransferBy' => 'DirectPay',
                    'bill' => 0,
                    'ConfirmBy' => 'fin',
                    'Confirmdate' => now(),
                    'GateWay' => "fin",
                    'CreditMod' => myappenv::CachCredit,
                    'branch' => Auth::user()->branch
                ];
                $Result = UserCredit::create($CrediteData);

                $UserInfo = UserInfo::where('UserName', auth::id())->first();
                $ResNum = Session::get('ResNum');
                if ($ResNum == 40) {
                    return $this->post_buy($Result, $UserInfo);
                }
                if ($ResNum == 41) {
                    return $this->signal_buy($Result, $UserInfo);
                }
                if ($ResNum == 42) {
                    return $this->exam_buy($Result, $UserInfo);
                } else {
                    return view("Credit.ConfirmPay", ['Result' => $Result, 'UserInfo' => $UserInfo]);
                }
            } else {
                return  abort(404, 'مشکلی در انجام تراکنش به وجود آمده است در صورتی که مبلغی از حساب شما کم شده است کارشناسان ما را مطلع فرمایید!');
            }
        } else {
            return abort('404', 'لینک درخواست شده وجود ندارد!');
        }
    }
    private function signal_buy($pay_src, $UserInfo)
    {
        $CrediteData = [
            'UserName' => $UserInfo->UserName,
            'Mony' => -1 * $pay_src->Mony,
            'Type' => 15,
            'Date' => now(),
            'Note' => $pay_src->Note,
            'TransferBy' => 'system',
            'bill' => 0,
            'ConfirmBy' => 'fin',
            'Confirmdate' => now(),
            'ReferenceId' => $pay_src->id,
            'CreditMod' => myappenv::CachCredit,
            'branch' => Auth::user()->branch
        ];
        $Result = UserCredit::create($CrediteData);
        UserCredit::where('id', $pay_src->id)->update(['ReferenceId' => $pay_src->id]);
        Session::forget('price');
        Session::forget('ResNum');
        Session::forget('target_post');
        Session::forget('finoward_token');
        Session::forget('Note');
        $OrderPreData = [
            'status' => 1,
            'ReturnCustomerId' => $UserInfo->UserName,
            'CustomerId' => $UserInfo->UserName,
            'SendLocation' => 0,
            'ReturnLocation' => 0,
            'num_items_sold' => 1,
            'total_sales' => $pay_src->Mony,
            'status_history' => '',
            'VirtualContract' => 0
        ];
        product_order::create($OrderPreData);
        return redirect()->route('analyzer', ['type' => 'spot']);
    }
    private function exam_buy($pay_src, $UserInfo)
    {
        $PayId = $pay_src->id;
        $target_post = Session::get('target_exam');
        $CrediteData = [
            'UserName' => $UserInfo->UserName,
            'Mony' => -1 * $pay_src->Mony,
            'Type' => 15,
            'Date' => now(),
            'Note' => $pay_src->Note,
            'TransferBy' => 'system',
            'bill' => 0,
            'ConfirmBy' => 'fin',
            'Confirmdate' => now(),
            'ReferenceId' => $pay_src->id,
            'CreditMod' => myappenv::CachCredit,
            'branch' => Auth::user()->branch
        ];
        $Result = UserCredit::create($CrediteData);
        UserCredit::where('id', $pay_src->id)->update(['ReferenceId' => $pay_src->id]);
        Session::forget('price');
        Session::forget('ResNum');
        Session::forget('target_exam');
        Session::forget('finoward_token');
        Session::forget('Note');
        $OrderPreData = [
            'status' => 1,
            'ReturnCustomerId' => $UserInfo->UserName,
            'CustomerId' => $UserInfo->UserName,
            'SendLocation' => 0,
            'ReturnLocation' => 0,
            'num_items_sold' => 1,
            'total_sales' => $pay_src->Mony,
            'status_history' => '',
            'VirtualContract' => $target_post,
            'extra' => 'exam'
        ];
        product_order::create($OrderPreData);
        return redirect()->route('SingleExam', ['ExamID' => $target_post]);
    }
    private function post_buy($pay_src, $UserInfo)
    {
        $PayId = $pay_src->id;
        $target_post = Session::get('target_post');
        $CrediteData = [
            'UserName' => $UserInfo->UserName,
            'Mony' => -1 * $pay_src->Mony,
            'Type' => 15,
            'Date' => now(),
            'Note' => $pay_src->Note,
            'TransferBy' => 'system',
            'bill' => 0,
            'ConfirmBy' => 'fin',
            'Confirmdate' => now(),
            'ReferenceId' => $pay_src->id,
            'CreditMod' => myappenv::CachCredit,
            'branch' => Auth::user()->branch
        ];
        $Result = UserCredit::create($CrediteData);
        UserCredit::where('id', $pay_src->id)->update(['ReferenceId' => $pay_src->id]);
        Session::forget('price');
        Session::forget('ResNum');
        Session::forget('target_post');
        Session::forget('finoward_token');
        Session::forget('Note');
        $OrderPreData = [
            'status' => 1,
            'ReturnCustomerId' => $UserInfo->UserName,
            'CustomerId' => $UserInfo->UserName,
            'SendLocation' => 0,
            'ReturnLocation' => 0,
            'num_items_sold' => 1,
            'total_sales' => $pay_src->Mony,
            'status_history' => '',
            'VirtualContract' => $target_post
        ];
        product_order::create($OrderPreData);
        return redirect()->route('ShowNewsItem', ['NewsId' => $target_post]);
    }

    public function selfpay($id)
    {
        if (!is_numeric($id)) {
            return abort('404', 'لینک درخواست شده وجود ندارد!');
        }
        $CreditSrc = UserCredit::where('ID', $id)->where('CreditMod', myappenv::ToPayCredit)->where('ConfirmBy', null)->first();
        if ($CreditSrc == null) {
            return abort('404', 'لینک درخواست شده وجود ندارد!');
        }
        $branch = branches::where('id', $CreditSrc->branch)->first();
        if ($branch == null) {
            return abort('404', ' شعبه درخواست دهنده معتبر نیست!');
        }
        if (myappenv::MainOwner == 'shafatel') {
            $loan = 'azki';
        } else {
            $loan = false;
        }

        return view('Credit.selfpay', ['branch' => $branch, 'CreditSrc' => $CreditSrc, 'loan' => $loan]);
    }
    public function Doselfpay(Request $request, $id)
    {
        if ($request->has('submit')) {
            $CreditSrc = UserCredit::where('ID', $id)->where('CreditMod', myappenv::ToPayCredit)->where('ConfirmBy', null)->first();
            $UserInfo_src = UserInfo::where('UserName', $CreditSrc->UserName)->first();
            if ($UserInfo_src == null || $CreditSrc == null) {
                return abort('404', 'لینک درخواست شده وجود ندارد!');
            }
            Session::put('price', $CreditSrc->Mony);
            Session::put('ResNum', 0);
            Session::put('uc', $id);
            Session::put('note', $CreditSrc->Note);
            Session::save();
            if ($request->radio == 'azki') {
                $azki = new azkivam;
                $items = [];
                $item = [
                    'name' => $CreditSrc->Note,
                    'count' => 1,
                    'amount' => $CreditSrc->Mony
                ];
                array_push($items, $item);
                $json_items = json_encode($items);
                $payment = $azki->pay($CreditSrc->Mony, $UserInfo_src->MobileNo, $json_items);
                if($payment['result']){
                    return redirect($payment['data']);
                }else{
                    return aboart('404',$payment['msg']);
                }
            }
            if (myappenv::Bank == 'pol') {
                $pool = new poolkhord();
                return $pool->pay_ipg($CreditSrc->Mony, $CreditSrc->Note);
            }
            if (myappenv::Bank == 'ZAR') {
                $zarinpal = new zarinpal;
                $zarinpal->payment($CreditSrc->Mony, $CreditSrc->Note, $UserInfo_src->MobileNo);
            }
            return abort('404', 'این قابلیت برای درگاه بانکی شما تعریف نشده است!');
        }
    }

    public function seppay()
    {
        $Amount = 100;
        $RefNum = 'ddddf4w43err';
        $Paydata = [
            'refnumber' => $RefNum,
            'gateway' => 'sep',
            'Amount' => $Amount
        ];
        transactionstemp::create($Paydata);
        return redirect()->route('checkout', ['pay' => 'sep', 'ref' => $RefNum]);
    }
    public function Doseppay(Request $request)
    {
        $MerchantCode = "12155575";
        if ($request->has('State')  && $request->input('State') == "OK") {
            $soapclient = new SoapClient('https://verify.sep.ir/Payments/ReferencePayment.asmx?WSDL');
            $res = $soapclient->VerifyTransaction($request->input('RefNum'), $MerchantCode);
            if ($res <= 0) {
                return false;
            } else {
                $Amount = $request->input('Amount');
                $RefNum = $request->input('RefNum');
                $targetid = rand(10, 1000000);
                $Paydata = [
                    'id' => $targetid,
                    'refnumber' => $RefNum,
                    'gateway' => 'sep',
                    'Amount' => $Amount
                ];
                transactionstemp::create($Paydata);
                return redirect()->route('ConfirmPayment', ['pay' => 'sep', 'ref' => $targetid]);
            }
        } else {
            // Transaction Failed
            return redirect()->route('checkout', ['pay' => 'sep', 'ref' => 'Faild']);
        }
    }
    public function makeXMLTree($data)
    {
        $ret = array();
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $data, $values, $tags);
        xml_parser_free($parser);
        $hash_stack = array();

        foreach ($values as $key => $val) {
            switch ($val['type']) {
                case 'open':
                    // array_push($hash_stack, [$val['tag']=>$val['value']]);
                    break;
                case 'close':
                    array_pop($hash_stack);
                    break;
                case 'complete':
                    array_push($hash_stack, [$val['tag'] => $val['value']]);
                    // uncomment to see what this function is doing
                    //echo("\$ret[" . implode($hash_stack, "][") . "] = '{$val[value]}';\n");
                    //eval("\$ret[" . implode($hash_stack, "][") . "] = '{$val[value]}';");
                    //array_pop($hash_stack);
                    break;
            }
        }
        return $hash_stack;
    }

    public function post2https($fields_arr, $url)
    {
        $fields_string = '';
        foreach ($fields_arr as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        $fields_string = substr($fields_string, 0, -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields_arr));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    public function peppay(Request $request)
    {
        $fields = array('invoiceUID' => $request->input('tref'));
        $result = $this->post2https($fields, 'https://pep.shaparak.ir/CheckTransactionResult.aspx');
        $array = $this->makeXMLTree($result);
        foreach ($array as $ietm) {
            if (isset($ietm['result'])) {
                $PayResult = $ietm["result"];
            } elseif (isset($ietm['transactionReferenceID'])) {
                $transactionReferenceID = $ietm["transactionReferenceID"];
            } elseif (isset($ietm['invoiceNumber'])) {
                $invoiceNumber = $ietm["invoiceNumber"];
            } elseif (isset($ietm['amount'])) {
                $amount = $ietm["amount"];
            } elseif (isset($ietm['traceNumber'])) {
                $traceNumber = $ietm["traceNumber"];
            } elseif (isset($ietm['referenceNumber'])) {
                $referenceNumber = $ietm["referenceNumber"];
            } elseif (isset($ietm['invoiceDate'])) {
                $InvoiceDate = $ietm["invoiceDate"];
            }
        }
        $MerchantCode = myappenv::PEPMerchantCode;
        $TerminalCode = myappenv::PEPTerminalCode;
        $TimeStamp = date("Y/m/d H:i:s");
        $fields = array(
            'MerchantCode' => $MerchantCode,            //shomare ye moshtari e shoma.
            'TerminalCode' => $TerminalCode,            //shomare ye terminal e shoma.
            'InvoiceNumber' => $invoiceNumber,            //shomare ye factor tarakonesh.
            'InvoiceDate' => $InvoiceDate, //tarikh e tarakonesh.
            'amount' => $amount,                    //mablagh e tarakonesh. faghat adad.
            'TimeStamp' => date("Y/m/d H:i:s"),    //zamane jari ye system.
            'sign' => ''                            //reshte ye ersali ye code shode. in mored automatic por mishavad.
        );
        $data = "#$MerchantCode#$TerminalCode#$invoiceNumber#$InvoiceDate#$amount#$TimeStamp#";
        $data = sha1($data, true);
        $Certificate = myappenv::PEPPrivate;
        $processor =  new PEPRSAProcessor($Certificate, PEPRSAKeyType::XMLString);
        $data = $processor->sign($data);
        $fields['sign'] = base64_encode($data); // base64_encode
        $sendingData = "MerchantCode=" . $MerchantCode . "&TerminalCode=" . $TerminalCode . "&InvoiceNumber=" . $invoiceNumber . "&InvoiceDate=" . $InvoiceDate . "&amount=" . $amount . "&TimeStamp=" . $TimeStamp . "&sign=" . $fields['sign'];
        $verifyresult = $this->post2https($fields, 'https://pep.shaparak.ir/VerifyPayment.aspx');
        $array = $this->makeXMLTree($verifyresult);
        foreach ($array as $ietm) {
            if (isset($ietm['result'])) {
                $ConfirmResult = $ietm["result"];
            }
        }

        dd($ConfirmResult);
    }
    public function Dopeppay(Request $request)
    {
        dd($request->input());
    }
    private function SmartInvoiceFinalPayProcess($InvoiceNumber)
    {
        $InvoiceTarget = DeviceContract::where('ContractID', $InvoiceNumber)->first();
        /**
         * Transfer Mony To Providers and Daramad
         */
        $ItemsTopay = DeviceItemExternal::all()->where('ContractNumber', $InvoiceNumber);
        foreach ($ItemsTopay as $ItemTopay) {
            $OwnerPrice = $ItemTopay->OwnerPrice;
            $DaramadPrice = $ItemTopay->Price - $ItemTopay->OwnerPrice;
            $Note = $ItemTopay->Note . " صورت حساب هوشمند شماره : " . $InvoiceNumber;
            $OwnerIdSource = branches::where('id', $ItemTopay->Owner)->first();
            $OwnerId = $OwnerIdSource->UserName;
            $CrediteData = [
                'UserName' => $OwnerId,
                'Mony' => $OwnerPrice,
                'Type' => 14,
                'Date' => now(),
                'Note' => $Note,
                'TransferBy' => 'DirectPay',
                'bill' => $InvoiceNumber,
                'ConfirmBy' => 'pep',
                'Confirmdate' => now(),
                'GateWay' => "pep",
                'CreditMod' => myappenv::UnaccessCredit,
                'TransfreRefrenceID' => $InvoiceTarget->CreditRefrence,
                'branch' => $ItemTopay->Owner
            ];
            UserCredit::create($CrediteData);
            $CrediteData1 = [
                'UserName' => myappenv::StackHolder,
                'Mony' => $DaramadPrice,
                'Type' => 14,
                'Date' => now(),
                'Note' => $Note,
                'TransferBy' => 'DirectPay',
                'bill' => $InvoiceNumber,
                'ConfirmBy' => 'pep',
                'Confirmdate' => now(),
                'GateWay' => "pep",
                'CreditMod' => myappenv::CachCredit,
                'TransfreRefrenceID' => $InvoiceTarget->CreditRefrence,
                'branch' => myappenv::Branch
            ];
            UserCredit::create($CrediteData1);
        }
    }

    private function SmartInvoicePayment($InvoiceNumber, $result)
    {
        /**
         *  find the Device Contract as invoice target
         */
        $invoicetarget = DeviceContract::where('ContractID', $InvoiceNumber)->first();
        if ($invoicetarget == null) {
            return abort('404');
        }
        /** Smart invoice Step 1
         * Add Price To customer Walet
         * Pay Type 14 is Smart Invice
         */
        if ($invoicetarget->CreditRefrence == null) { // first Time to pay
            $CrediteData = [
                'UserName' => $result['payername'],
                'Mony' => $result['amount'],
                'Type' => 14,
                'Date' => now(),
                'Note' => $result['note'],
                'SpecialPaymentId' => $result['transactionReferenceID'],
                'PaymentId' => $result['traceNumber'],
                'TransferBy' => 'DirectPay',
                'bill' => $InvoiceNumber,
                'ConfirmBy' => 'pep',
                'Confirmdate' => now(),
                'GateWay' => "pep",
                'CreditMod' => myappenv::CachCredit,
                'branch' => myappenv::Branch
            ];
            $Result = UserCredit::create($CrediteData);
            $RResult = $Result;
            $RefrenceId = $RResult->id;
            UserCredit::where('ID', $RResult->id)->update(['ReferenceId' => $RefrenceId]);
            DeviceContract::where('ContractID', $InvoiceNumber)->update(['CreditRefrence' => $RefrenceId]);
        } else {
            $RefrenceId = $invoicetarget->CreditRefrence;
            $CrediteData = [
                'UserName' => $result['payername'],
                'Mony' => $result['amount'],
                'Type' => 14,
                'Date' => now(),
                'Note' => $result['note'],
                'SpecialPaymentId' => $result['transactionReferenceID'],
                'PaymentId' => $result['traceNumber'],
                'TransferBy' => 'DirectPay',
                'bill' => $InvoiceNumber,
                'ConfirmBy' => 'pep',
                'Confirmdate' => now(),
                'ReferenceId' => $RefrenceId,
                'GateWay' => "pep",
                'CreditMod' => myappenv::CachCredit,
                'branch' => myappenv::Branch
            ];
            $Result = UserCredit::create($CrediteData);
            $RResult = $Result;
        }
        if ($invoicetarget->Status == 1) {
            if ($result['amount'] == $invoicetarget->TotalPrice) { // tasviye kamel
                $invoicestate = [
                    'Status' => 100
                ];
                DeviceContract::where('ContractID', $InvoiceNumber)->update($invoicestate);
                $MyTrasnfer = new CreditTransfer();
                $MyTrasnfer->SmartInvoice_TasviyehPay($InvoiceNumber);
            } elseif ($result['amount'] == $invoicetarget->BeyanehPrice) { //beyaneh
                $invoicestate = [
                    'Status' => 50
                ];
                DeviceContract::where('ContractID', $InvoiceNumber)->update($invoicestate);
                $MyTrasnfer = new CreditTransfer();
                $MyTrasnfer->SmartInvoice_BeyanehPay($InvoiceNumber);
            } else {
                return abort('404');
            }
        } elseif ($invoicetarget->Status == 50) {
            if ($result['amount'] == $invoicetarget->TotalPrice - $invoicetarget->BeyanehPrice) { // tasviye kamel
                $invoicestate = [
                    'Status' => 100
                ];
                DeviceContract::where('ContractID', $InvoiceNumber)->update($invoicestate);
                $MyTrasnfer = new CreditTransfer();
                $MyTrasnfer->SmartInvoice_TasviyehPay($InvoiceNumber);
            } else {
                return abort('404');
            }
        }
        $CrediteData = [
            'UserName' => $result['payername'],
            'Mony' => $result['amount'] * -1,
            'Type' => 14,
            'Date' => now(),
            'Note' => $result['note'],
            'SpecialPaymentId' => $result['transactionReferenceID'],
            'PaymentId' => $result['traceNumber'],
            'TransferBy' => 'DirectPay',
            'bill' => $InvoiceNumber,
            'ConfirmBy' => 'pep',
            'Confirmdate' => now(),
            'GateWay' => "pep",
            'ReferenceId' => $RefrenceId,
            'CreditMod' => myappenv::CachCredit,
            'branch' => myappenv::Branch
        ];
        UserCredit::create($CrediteData);
        return $RResult;
    }

    public function ConfirmIPG($InvoiceNumber, $result, $type = null)
    {

        $Mytext = new TextClassMain();
        if ($Mytext->startsWith($InvoiceNumber, '99000') || $type = 'normalinvoice') {
            $InvoiceNumber =  str_replace("99000", "", $InvoiceNumber);
            $CrediteData = [
                'UserName' => $result['payername'],
                'Mony' => $result['amount'],
                'Type' => 14,
                'Date' => now(),
                'Note' => $result['note'],
                'SpecialPaymentId' => $result['transactionReferenceID'],
                'PaymentId' => $result['traceNumber'],
                'TransferBy' => 'DirectPay',
                'bill' => $InvoiceNumber,
                'ConfirmBy' => 'pep',
                'Confirmdate' => now(),
                'GateWay' => "pep",
                'CreditMod' => myappenv::CachCredit,
                'branch' => myappenv::Branch
            ];
            $Result = UserCredit::create($CrediteData);
            $CrediteData = [
                'UserName' => $result['payername'],
                'Mony' => $result['amount'] * -1,
                'Type' => 14,
                'Date' => now(),
                'Note' => $result['note'],
                'SpecialPaymentId' => $result['transactionReferenceID'],
                'PaymentId' => $result['traceNumber'],
                'TransferBy' => 'DirectPay',
                'bill' => $InvoiceNumber,
                'ConfirmBy' => 'pep',
                'Confirmdate' => now(),
                'GateWay' => "pep",
                'CreditMod' => myappenv::CachCredit,
                'branch' => myappenv::Branch
            ];
            $Result = UserCredit::create($CrediteData);

            $invoicestate = [
                'Status' => 100
            ];
            $invoicetarget = Invoices::where('id', $InvoiceNumber)->update($invoicestate);
            return $invoicetarget;
        } elseif ($Mytext->startsWith($InvoiceNumber, '93000')) { //Product Market Place
            $InvoiceNumber =  str_replace("93000", "", $InvoiceNumber);
            $Amount = $result['amount'];
            $RefNum = $InvoiceNumber;
            $targetid = rand(10, 1000000);
            $Paydata = [
                'id' => $targetid,
                'refnumber' => $RefNum,
                'gateway' => 'pep',
                'Amount' => $Amount
            ];
            transactionstemp::create($Paydata);
            return redirect()->route('checkout', ['pay' => 'pep', 'ref' => $targetid]);
        } else {
            $CrediteData = [
                'UserName' => $result['payername'],
                'Mony' => $result['amount'],
                'Type' => 14,
                'Date' => now(),
                'Note' => $result['note'],
                'SpecialPaymentId' => $result['transactionReferenceID'],
                'PaymentId' => $result['traceNumber'],
                'TransferBy' => 'DirectPay',
                'bill' => 0,
                'ConfirmBy' => 'pep',
                'Confirmdate' => now(),
                'GateWay' => "pep",
                'CreditMod' => myappenv::CachCredit,
                'branch' => myappenv::Branch
            ];
            $Result = UserCredit::create($CrediteData);
            $RResult = $Result;
        }
        $UserInfo = UserInfo::where('UserName', $result['payername'])->first();
        if ($RResult->id != null) {
            return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
        } else {
            return abort('404');
        }
    }
    public function ConfirmIPG_shfafatel($Token)
    {
        $Params = "transactionReferenceID=$Token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.shafatel.com/pep/?request=2');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $Params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        if ($result != null) {
            $InvoiceNumber = $result['invoiceNumber'];
            $Mytext = new TextClassMain();
            if ($Mytext->startsWith($InvoiceNumber, '99000')) {
                $InvoiceNumber =  str_replace("99000", "", $InvoiceNumber);
                $CrediteData = [
                    'UserName' => $result['payername'],
                    'Mony' => $result['amount'],
                    'Type' => 14,
                    'Date' => now(),
                    'Note' => $result['note'],
                    'SpecialPaymentId' => $result['transactionReferenceID'],
                    'PaymentId' => $result['traceNumber'],
                    'TransferBy' => 'DirectPay',
                    'bill' => $InvoiceNumber,
                    'ConfirmBy' => 'pep',
                    'Confirmdate' => now(),
                    'GateWay' => "pep",
                    'CreditMod' => myappenv::CachCredit,
                    'branch' => myappenv::Branch
                ];
                $Result = UserCredit::create($CrediteData);
                $CrediteData = [
                    'UserName' => $result['payername'],
                    'Mony' => $result['amount'] * -1,
                    'Type' => 14,
                    'Date' => now(),
                    'Note' => $result['note'],
                    'SpecialPaymentId' => $result['transactionReferenceID'],
                    'PaymentId' => $result['traceNumber'],
                    'TransferBy' => 'DirectPay',
                    'bill' => $InvoiceNumber,
                    'ConfirmBy' => 'pep',
                    'Confirmdate' => now(),
                    'GateWay' => "pep",
                    'CreditMod' => myappenv::CachCredit,
                    'branch' => myappenv::Branch
                ];
                $Result = UserCredit::create($CrediteData);

                $invoicestate = [
                    'Status' => 100
                ];
                $invoicetarget = Invoices::where('id', $InvoiceNumber)->update($invoicestate);
            } elseif ($Mytext->startsWith($InvoiceNumber, '99000')) { //smart Invoice
                $InvoiceNumber =  str_replace("99000", "", $InvoiceNumber);
                $RResult = $this->SmartInvoicePayment($InvoiceNumber, $result);
            } elseif ($Mytext->startsWith($InvoiceNumber, '93000')) { //Product Market Place
                $InvoiceNumber =  str_replace("93000", "", $InvoiceNumber);
                $Amount = $result['amount'];
                $RefNum = $InvoiceNumber;
                $targetid = rand(10, 1000000);
                $Paydata = [
                    'id' => $targetid,
                    'refnumber' => $RefNum,
                    'gateway' => 'pep',
                    'Amount' => $Amount
                ];
                transactionstemp::create($Paydata);
                return redirect()->route('checkout', ['pay' => 'pep', 'ref' => $targetid]);
            } else {
                $CrediteData = [
                    'UserName' => $result['payername'],
                    'Mony' => $result['amount'],
                    'Type' => 14,
                    'Date' => now(),
                    'Note' => $result['note'],
                    'SpecialPaymentId' => $result['transactionReferenceID'],
                    'PaymentId' => $result['traceNumber'],
                    'TransferBy' => 'DirectPay',
                    'bill' => 0,
                    'ConfirmBy' => 'pep',
                    'Confirmdate' => now(),
                    'GateWay' => "pep",
                    'CreditMod' => myappenv::CachCredit,
                    'branch' => myappenv::Branch
                ];
                $Result = UserCredit::create($CrediteData);
                $RResult = $Result;
            }
            $UserInfo = UserInfo::where('UserName', $result['payername'])->first();
            if ($RResult->id != null) {
                return view("Credit.ConfirmPay", ['Result' => $RResult, 'UserInfo' => $UserInfo]);
            } else {
                return abort('404');
            }
        } else {
            return abort('404');
        }
    }

    public function ConfirmPay($Token)
    {
        $CrediteResult = UserCredit::where('UserName', $Token)->where('Note', $Token)->where('TransferBy', $Token)->where('Type', 0)->first();
        if ($CrediteResult == [] || $CrediteResult == null) {
            return abort('404');
        } else {
            $CrediteData = [
                'UserName' => Auth::id(),
                'Mony' => Session::get('amount'),
                'Type' => 12,
                'Note' => Session::get('PayNote'),
                'TransferBy' => Auth::id(),
                'bill' => Session::get('invoiceid'),
            ];
            $CrediteResult = UserCredit::where('UserName', $Token)->where('Note', $Token)->where('TransferBy', $Token)->where('Type', 0)->update($CrediteData);
            return view("Credit.DirectPay")->with('success', __("success alert"));
        }
    }

    public function curl($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    public function DirectPay()
    {
        if (Auth::user()->Role == myappenv::role_customer) {
            return view("Credit.DirectPay");
            if (myappenv::Lic['wpa']) {
                $Credites = UserCredit::all()->where('UserName', Auth::id());
                return view("Credit.DirectPayWPA", ['Credites' => $Credites]);
            } else {
                return view("Credit.DirectPay");
            }
        } else {
            return view("Credit.DirectPay");
        }
    }

    public function PepDirectPayAdd($Amount, $invoiceid, $UserName, $payername, $Mobile, $Note)
    {
        $redirectaddress = url('ConfirmIPG');
        $datetime = new DateTime('tomorrow');
        $expire =  $datetime->format('Y-m-d');
        $CenterName = myappenv::CenterName;
        $Params = "UserName=$UserName&payername=$payername&amont=$Amount&redirectaddress=$redirectaddress&centername=$CenterName&invoiceNumber=$invoiceid&Mobile=$Mobile&expire=$expire&note=$Note";
        Session::put('amount', $Amount);
        Session::put('invoiceid', $invoiceid);
        Session::put('PayNote', $Note);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.shafatel.com/pep/?request=1');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $Params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        preg_match_all('!\d+\.*\d*!', $response, $matches);
        $matche = $matches[0];
        curl_close($ch);
        return $matche[0];
        //redirect()->to('https://shafatel.com/pep/?payment=' . $matche[0])->send();
    }
    public function DoDirectPay(Request $request)
    {


        if ($request->has('submit')) {
            if ($request->has('radio')) {
                if ($request->input('radio') == 'ZAR') {
                    if ($request->has('Note')) {
                        $Note = $request->input('Note');
                        $Note .= ' -  افزایش مستقیم';
                    } else {
                        $Note = 'بدون توضیح';
                        $Note .= ' -  افزایش مستقیم';
                    }
                    $price = $request->input('Amount');         // Price Rial
                    $ResNum = 0;             // Invoice Number
                    Session::put('price', $price);
                    Session::put('ResNum', $ResNum);
                    Session::put('note', $Note);
                    Session::put('NormalInvoice', true);
                    Session::save();
                    $refnumber = rand(10, 1000000);
                    $refnumber = $refnumber . Auth::id();
                    $Paydata = [
                        'refnumber' => $refnumber,
                        'gateway' => 'ZAR',
                        'Amount' => $price
                    ];
                    transactionstemp::create($Paydata);
                    $pool = new zarinpal();
                    return $pool->payment($price, $Note, Auth::user()->MobileNo, $refnumber);
                }
                if ($request->input('radio') == 'pol') {
                    if ($request->has('Note')) {
                        $Note = $request->input('Note');
                        $Note .= ' -  افزایش مستقیم';
                    } else {
                        $Note = 'بدون توضیح';
                        $Note .= ' -  افزایش مستقیم';
                    }
                    $price = $request->input('Amount');         // Price Rial
                    $ResNum = 0;             // Invoice Number

                    Session::put('price', $price);
                    Session::put('ResNum', $ResNum);
                    Session::put('note', $Note);
                    $pool = new poolkhord();
                    return $pool->pay_ipg($price, $Note);
                }
                if ($request->input('radio') == 'ic') {
                    $Amount = $request->input('Amount');
                    $callbackurl = 'https://my.shafatel.com/api/DirectPay';
                    $invoiceid = '10';
                    $Params = "terminalid=2005872&amount=$Amount&payload=&callbackurl=$callbackurl&invoiceid=$invoiceid";
                    Session::put('amount', $Amount);
                    Session::put('invoiceid', $invoiceid);
                    Session::put('PayNote', $request->input('Note'));
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://service.iccard.ir');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $Params);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $result = json_decode($response, true);
                    if ($result['status']) {
                        //header('https://service.iccard.ir/pay/'.$result['invoiceid']);
                        redirect()->to('https://service.iccard.ir/pay/' . $result['invoiceid'])->send();
                        return true;
                    } else {
                        return false;
                    }
                } elseif ($request->input('radio') == 'pep' || $request->input('submit') == 'pep') {
                    $price = $request->input('Amount');         // Price Rial
                    $ResNum = 1;             // Invoice Number
                    Session::put('price', $price);
                    Session::put('ResNum', $ResNum);
                    $Note = $request->input('Note');
                    $Certificate = myappenv::PEPPrivate;
                    $processor =  new RSAProcessor($Certificate, RSAKeyType::XMLString);
                    $merchantCode = myappenv::PEPMerchantCode; // كد پذيرنده
                    $terminalCode = myappenv::PEPTerminalCode; // كد ترمينال
                    $amount = $price; // مبلغ فاكتور
                    $redirectAddress = route('peppay');
                    $invoiceNumber = $ResNum; //شماره فاكتور
                    $redirectAddress = route('checkout', ['pay' => 'pep', 'ref' => $invoiceNumber]);
                    $timeStamp = date("Y/m/d H:i:s");
                    $invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
                    $action = "1003";    // 1003 : براي درخواست خريد
                    $Mobile = Auth::user()->MobileNo;
                    $data = "#" . $merchantCode . "#" . $terminalCode . "#" . $invoiceNumber . "#" . $invoiceDate . "#" . $amount . "#" . $redirectAddress . "#" . $action . "#" . $timeStamp . "#";
                    $data = sha1($data, true);
                    $data = $processor->sign($data); // امضاي ديجيتال
                    $result = base64_encode($data); // base64_encode
                    $SendData = [
                        'invoiceNumber' => $invoiceNumber,
                        'invoiceDate' => $invoiceDate,
                        'amount' => $amount,
                        'terminalCode' => $terminalCode,
                        'merchantCode' => $merchantCode,
                        'redirectAddress' => $redirectAddress,
                        'timeStamp' => $timeStamp,
                        'mobile' => $Mobile,
                        'action' => $action,
                        'sign' => $result
                    ];
                    echo "<form id='peppeyment' action='https://pep.shaparak.ir/gateway.aspx' method='post'>
                    <input  type='text' name='invoiceNumber' value='$invoiceNumber' /><br />
                    <input  type='text' name='invoiceDate' value='$invoiceDate' /><br />
                    <input  type='text' name='amount' value='$amount' /><br />
                    <input  type='text' name='terminalCode' value='$terminalCode' /><br />
                    <input  type='text' name='merchantCode' value='$merchantCode' /><br />
                    <input  type='text' name='redirectAddress' value='$redirectAddress' /><br />
                    <input  type='text' name='timeStamp' value='$timeStamp' /><br />
                    <input  name='mobile' value='$Mobile' /><br />
                    <input  type='text' name='action' value='$action' /><br />
                    <input  type='text' name='sign' value='$result' /><br />
                    </form><script>document.forms['peppeyment'].submit()</script>";
                } elseif ($request->input('radio') == 'fin' || $request->input('submit') == 'fin') {
                    $price = $request->input('Amount');         // Price Rial
                    $ResNum = 1;             // Invoice Number
                    $token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10);
                    $Note = $request->input('Note');
                    Session::put('price', $price);
                    Session::put('ResNum', $ResNum);
                    Session::put('finoward_token', $token);
                    Session::put('Note', $Note);
                    $amount = $price; // مبلغ فاكتور
                    $redirectAddress = route('finpay');
                    $invoiceNumber = $ResNum; //شماره فاكتور
                    $timeStamp = date("Y/m/d H:i:s");
                    $invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
                    $action = "1003";    // 1003 : براي درخواست خريد
                    $Mobile = Auth::user()->MobileNo;
                    echo "<form id='peppeyment' action='https://finoward.ir/ipg.php' method='post'>
                    <input  type='text' name='token' value='$token' /><br />
                    <input  type='text' name='amount' value='$amount' /><br />
                    <input  type='text' name='redirectAddress' value='$redirectAddress' /><br />
                    <input  name='mobile' value='$Mobile' /><br />
                    <input  type='text' name='Note' value='$Note' /><br />
                    <button type='submit'>انتقال به درگاه  </button>
                    </form><script>document.forms['peppeyment'].submit()</script>";
                } elseif ($request->input('radio') == 'PNA' || $request->input('submit') == 'PNA') {
                    $price = $request->input('Amount');         // Price Rial
                    $ResNum = 1;             // Invoice Number
                    Session::put('price', $price);
                    Session::put('ResNum', $ResNum);
                    $amount = $price; // مبلغ فاكتور
                    $Order_id    = $ResNum;
                    $CallbackURL = route('checkout', ['pay' => 'pna', 'ref' => $Order_id]);
                    $Email       = Auth::user()->Email;
                    $Mobile      = Auth::user()->MobileNo;
                    $Username     = '011578717';
                    $Password     = '9915758808';
                    $Terminal     = '11584036';

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://pna.shaparak.ir/ref-payment2/RestServices/mts/generateTokenWithNoSign/',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '{
                  "WSContext":{"UserId":"' . $Username . '","Password":"' . $Password . '"},
                  "TransType":"EN_GOODS",
                  "ReserveNum":"' . $ResNum . '",
                  "TerminalId":"' . $Terminal . '",
                  "Amount":"' . $price . '",
                  "GoodsReferenceID":"' . $Order_id . '",
                  "MobileNo":"' . $Mobile . '",
                  "Email":"' . $Email . '",
                  "RedirectUrl":"' . $CallbackURL . '"
              }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json',
                        ),
                    ));

                    $Login = curl_exec($curl);
                    $Login = json_decode($Login);

                    curl_close($curl);
                    $Result = !empty($Login->Result) ? $Login->Result : 'erMts_UnknownError';

                    if ($Result != 'erSucceed') {
                        return $this->errors($Result);
                    }

                    echo '<form id="pnaform" method="post" action="https://pna.shaparak.ir/_ipgw_/payment/"  >
                        <input type="hidden" id="token" name="token" value="' . $Login->Token . '" />
                        <input type="hidden" id="TerminalId" name="TerminalId" value="' . $Terminal . '" />
                        <input type="hidden" id="language" name="language" value="fa">
                        <button type="submit" name="submit" value="startcall"
                        class="btn btn-success px-4 text-white rad25  ml-3 "> انتفال به درگاه بانکی</button>
                      </form><script>document.forms["pnaform"].submit()</script>';
                    return true;
                }
            } else { // pay from defualt ipc
                if ($request->input('submit') == 'Trnsfer') {
                    $price = $request->input('Amount');         // Price Rial
                    $note = $request->input('Note');         // Price Rial
                    Session::put('price', $price);
                    Session::put('note', $note);
                    Session::put('ResNum', 0);
                    return redirect()->route('ikc');
                } elseif ($request->input('submit') == 'Decrease_free') {
                    $CrediteData = [
                        'UserName' => Auth::id(),
                        'Mony' => -1 * $request->input('Amount'),
                        'Type' => 0,
                        'Date' => now(),
                        'Note' => 'چهارشنبه بی کارمزد: ' . $request->input('Note'),
                        'TransferBy' => Auth::id(),
                        'CreditMod' => myappenv::CachCredit,
                        'branch' => Auth::user()->branch
                    ];
                    UserCredit::create($CrediteData);
                    return redirect()->back()->with('success', 'درخواست برداشت شما در سیستم ثبت گردید!');
                } elseif ($request->input('submit') == 'Decrease_fast') {
                    $CrediteData = [
                        'UserName' => Auth::id(),
                        'Mony' => -1 * $request->input('Amount'),
                        'Type' => 0,
                        'Date' => now(),
                        'Note' => 'پرداخت اسرع وقت: ' . $request->input('Note'),
                        'TransferBy' => Auth::id(),
                        'CreditMod' => myappenv::CachCredit,
                        'branch' => Auth::user()->branch
                    ];
                    UserCredit::create($CrediteData);
                    return redirect()->back()->with('success', 'درخواست برداشت شما در سیستم ثبت گردید!');
                }
            }
        } else {
            $Params = "terminalid=2005872&ref=" . $request->input('ref');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://service.iccard.ir/pay/status');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $Params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            //{"status":0,"success":true,"message":"عملیات با موفقیت انجام شد","rrn":116110757621,"cardnumber":"621986********1800"}
            $response = json_decode($response);
            $mytext = new TextClassMain();
            $Randomtext = $mytext->StrRandom(20);
            if ($response->status == 0) {
                $CrediteData = [
                    'UserName' => $Randomtext,
                    'Mony' => 0,
                    'Type' => 0,
                    'Date' => now(),
                    'Note' => $Randomtext,
                    'SpecialPaymentId' => $response->cardnumber,
                    'PaymentId' => $response->rrn,
                    'TransferBy' => $Randomtext,
                    'bill' => 0,
                    'ConfirmBy' => 'ICC',
                    'Confirmdate' => now(),
                    'GateWay' => "ICC",
                    'CreditMod' => myappenv::CachCredit,
                    'branch' => myappenv::Branch
                ];
                UserCredit::create($CrediteData);
                return redirect()->route('ConfirmPay', ['Token' => $Randomtext]);
            } else {
                return view("Credit.DirectPay")->with('error', '$response->message');
            }
        }
    }
}
