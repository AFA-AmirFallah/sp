<?php

namespace App\hiring;

use App\Functions\TextClassMain;
use App\Models\transactionstemp;
use App\Models\user_license;
use App\zarinpal\zarinpal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\select;

class hiring_package_manager extends hiring_main
{
    private function add_pay_temp($price)
    {
        $mytext = new TextClassMain;
        $strid = $mytext->StrRandom(30);
        Session::put('price', $price);
        Session::save('price', $price);
        Session::put('strid', $strid);
        Session::save('strid', $strid);
        $DBData = [
            'refnumber' => 1,
            'Amount' => $price,
            'gateway' => 'ZAR',
            'strid' => $strid
        ];
        $insert_result = transactionstemp::create($DBData);
        $ResNum = $insert_result->id;
        transactionstemp::where('id', $ResNum)->update(['refnumber' => $ResNum]);
        Session::put('ResNum', $ResNum);
        Session::save('ResNum', $ResNum);
        return $ResNum;
        //$redirectAddress = route('ConfirmPayment', ['pay' => 'ZAR', 'ref' => $ResNum]);

    }
    private function worker_base_package($type, $credit_reference = null)
    {
        if ($type == 'send') {
            Session::put('package', 1);
            Session::save('package', 1);
            $package_price = 100000;
            $reference_id = $this->add_pay_temp($package_price);
            return [
                'price' => $package_price,
                'Description' => 'خرید اشتراک نیروی عملیاتی پایه یک ماهه ' . Auth::user()->Name . ' ' . Auth::user()->Family,
                'MobileNo' => Auth::user()->MobileNo,
                'CallbackURL' => route('ConfirmPayment', ['pay' => 'ZAR', 'ref' => $reference_id]),
                'ref' => $reference_id
            ];
        }
        $lic_data = [
            'UserName' => Auth::id(),
            'name' => 'اشتراک 1 ماهه درمانگر-پرستار',
            'license' => 'lic_staff_standard',
            'credit_reference' => $credit_reference,
            'expire' => now()->addDays(30),
        ];
        user_license::create($lic_data);
        return [
            'result' => true
        ];
    }
    private function worker_base_packageX3($type, $credit_reference = null)
    {
        if ($type == 'send') {
            Session::put('package', 1);
            Session::save('package', 1);
            $package_price = 200000;
            $reference_id = $this->add_pay_temp($package_price);
            return [
                'price' => $package_price,
                'Description' => 'خرید اشتراک نیروی عملیاتی پایه سه ماهه ' . Auth::user()->Name . ' ' . Auth::user()->Family,
                'MobileNo' => Auth::user()->MobileNo,
                'CallbackURL' => route('ConfirmPayment', ['pay' => 'ZAR', 'ref' => $reference_id]),
                'ref' => $reference_id
            ];
        }
        $lic_data = [
            'UserName' => Auth::id(),
            'name' => 'اشتراک ۳ ماهه درمانگر-پرستار',
            'license' => 'lic_staff_standard',
            'credit_reference' => $credit_reference,
            'expire' => now()->addDays(90),
        ];
        user_license::create($lic_data);
        return [
            'result' => true
        ];
    }
    private function worker_base_packageX12($type, $credit_reference = null)
    {
        if ($type == 'send') {
            Session::put('package', 1);
            Session::save('package', 1);
            $package_price = 700000;
            $reference_id = $this->add_pay_temp($package_price);
            return [
                'price' => $package_price,
                'Description' => 'خرید اشتراک نیروی عملیاتی پایه یک ساله ' . Auth::user()->Name . ' ' . Auth::user()->Family,
                'MobileNo' => Auth::user()->MobileNo,
                'CallbackURL' => route('ConfirmPayment', ['pay' => 'ZAR', 'ref' => $reference_id]),
                'ref' => $reference_id
            ];
        }
        $lic_data = [
            'UserName' => Auth::id(),
            'name' => 'اشتراک 1 ساله درمانگر-پرستار',
            'license' => 'lic_staff_standard',
            'credit_reference' => $credit_reference,
            'expire' => now()->addDays(365),
        ];
        user_license::create($lic_data);
        return [
            'result' => true
        ];
    }
    public function get_user_active_license($username)
    {
        $license_src = user_license::where('UserName', $username)->where('expire', '>', now())->get();
        return $license_src;
    }
    public function confirm_payment($result, $credit_reference)
    {
        if ($result) {
            switch (Session::get('package')) {
                case 1:
                    $buy_result = $this->worker_base_package('get', $credit_reference);
                    break;

                default:
                    # code...
                    break;
            }

            return true;
        }
    }
    public function buy_package(Request $request)
    {
        switch ($request->buy_package) {
            case '1':
                $buy_result = $this->worker_base_package('send');
                break;
            case '2':
                $buy_result = $this->worker_base_packageX3('send');
                break;
            case '3':
                $buy_result = $this->worker_base_packageX12('send');
                break;

            default:
                # code...
                break;
        }

        $zarinpal = new zarinpal;
        return $zarinpal->payment($buy_result['price'], $buy_result['Description'], $buy_result['MobileNo'], $buy_result['ref'], $buy_result['CallbackURL']);
        return $this->main_pay();


    }
    private function main_pay()
    {
        $url = 'https://bitpay.ir/payment/gateway-send';
        $api = 'b494f-53a5c-9c9a9-2b33f-f4694cb87a4ebfb962115a05ad1e';
        $amount = 10000;
        $redirect = 'https://parastarbank/result';
        $name = '';//ekhtiari
        $email = '';//ekhtiari
        $description = '';//ekhtiari
        $factorId = 1;//ekhtiari

        $result = $this->send($url, $api, $amount, $redirect, $factorId, $name, $email, $description);

        if ($result > 0 && is_numeric($result)) {
            $go = "https://bitpay.ir/payment/gateway-$result-get";
            return redirect()->to($go);
        }
    }
    private function pay($trans_id, $id_get)
    {
        $url = 'https://bitpay.ir/payment/gateway-result-second';
        $api = 'Your-API';
        $result = $this->get($url, $api, $trans_id, $id_get);

        $parseDecode = json_decode($result);

        if ($parseDecode->status == 1) {
            //true

            //mablagh ersali
            echo $parseDecode->amount;

            //factore ersali (ekhtiari)
            echo $parseDecode->factorId;

            //shomare kart pardakht konanade
            echo $parseDecode->cardNum;

        } else {
            //false
        }

    }
    private function send($url, $api, $amount, $redirect, $factorId, $name, $email, $description)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&amount=$amount&redirect=$redirect&factorId=$factorId&name=$name&email=$email&description=$description");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    private function get($url, $api, $trans_id, $id_get)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&id_get=$id_get&trans_id=$trans_id&json=1");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

}