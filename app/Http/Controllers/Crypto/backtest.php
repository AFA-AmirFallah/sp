<?php

namespace App\Http\Controllers\Crypto;

use App\Crypto\CryptoAlerts;
use App\Crypto\CryptoFunctions;
use App\Crypto\CryptoRobots;
use App\Crypto\Strategy\kv_1;
use App\Crypto\Strategy\kv_2;
use App\Crypto\Strategy\kv_3;
use App\Functions\CacheData;
use App\Functions\DateTimeClass;
use App\Http\Controllers\Controller;
use App\Models\CoinBackTest;
use App\Models\crypto_price_1hs;
use App\Models\crypto_price_1m;
use App\Models\metadata;
use App\myappenv;
use Illuminate\Http\Request;
use DB;
use Setting;
use Auth;
use Illuminate\Support\Arr;

class backtest extends Controller
{
    /**
     * Crypto Backtest:
     * Crypto Backtest test selected coins winrate in direrent time frame
     * desigend 2 type of Backtest:
     *  1: System Signal Backtest 
     *          This type active if admins activate Backtest analyzer  
     *  2: User Coins Define Backtest
     * 
     * 
     */
    private $extrainfo;
    private $nowdate;
    public function AddUserBacktest($Owner, $NewSignal)
    {
        $MyDate = new DateTimeClass;
        $nowdate =  $MyDate->get_now_int();
        $OldBacktest = CoinBackTest::where('curency', $NewSignal)->where('owner', $Owner)->where('status', '<', 100)->first();
        if ($OldBacktest == null) { // the coin is not in backtest list
            $CoinInfo =  crypto_price_1m::where('curency', $NewSignal . '-USDT')->first();
            $NewData = [
                'candate' => $nowdate,
                'curency' => $NewSignal,
                'owner' => $Owner,
                'OfferType' => 1,
                'OpenPrice' => $CoinInfo->price
            ];
            CoinBackTest::create($NewData);
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function adds new backtest items for a cryptocurrency trading system and alerts registered
     * users of the new signals.
     * 
     * @return a boolean value. If backtest is enabled, it adds new items to the CoinBackTest table and
     * sends alerts to registered users. If backtest is disabled, it simply returns true.
     */

    //TODO: Currently send alert bind to backtest for future should divide this 2 items
    public function AddNewBackTestItems()
    {
        $Setting = CacheData::GetSetting('Crypto_Back_test');

        if ($Setting == '1') { // backtest enable
            $CryptoFunction = new CryptoFunctions;
            $NewSignalArr = $CryptoFunction->SystemSignal_v3_1();
            $MyDate = new DateTimeClass;
            $nowdate =  $MyDate->get_now_int();
            $AddItems = [];
            foreach ($NewSignalArr as $NewSignal) {
                $OldBacktest = CoinBackTest::where('curency', $NewSignal)->where('owner', 'system')->where('status', '<', 100)->first();
                if ($OldBacktest == null) { // the coin is not in backtest list
                    $CoinInfo =  crypto_price_1m::where('curency', $NewSignal . '-USDT')->first();
                    $NewData = [
                        'candate' => $nowdate,
                        'curency' => $NewSignal,
                        'owner' => 'system',
                        'OfferType' => 1,
                        'OpenPrice' => $CoinInfo->price
                    ];
                    CoinBackTest::create($NewData);
                    array_push($AddItems, $NewSignal);
                }
            }
            /*
            $mykv = new kv_1;
            $mykv->run();
            $mykv = new kv_2;
            $mykv->run();
            $mykv = new kv_3;
            $mykv->run();*/
            $Alerts = new CryptoAlerts;
            $Alerts->alert_registered_user_generated_signal($AddItems);
            $CryptoRobots = new CryptoRobots;
            $Result = $CryptoRobots->run_users_robots($AddItems);
            return true;
        } else { //backtest disable
            return true;
        }
    }
    private function PercentCalc($OpenPrice, $ClosePrice)
    {
        if ($OpenPrice == 0) {
            return false;
        }
        $Percent = ($ClosePrice - $OpenPrice) * 100 / $OpenPrice;

        return round($Percent, 2);
    }
    private function Process24Hour($BacktetItem, $CurentPrice, $nowdate)
    {
        $TimeDifrence = $nowdate - $BacktetItem->candate;
        if ($TimeDifrence > 86400) { // should terminate 24 Hour and close BT
            if ($CurentPrice > $BacktetItem['4HourPrice']) {
                $UpdateData = [
                    'status' => 100
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            }
        } else {

            if ($CurentPrice > $BacktetItem['C24HourPrice']) {
                $UpdateData = [
                    'C24HourPrice' => $CurentPrice,
                    'C24HourPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            } else {
                $UpdateData = [
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            }
        }
    }
    private function Init24Hour($BacktetItem, $CurentPrice)
    {
        $UpdateData = [
            'C24HourPrice' => $CurentPrice,
            'C24HourPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
            'extrainfo' => $this->get_extrainfo($CurentPrice),
            'status' => 7
        ];
        CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
    }
    private function Process4Hour($BacktetItem, $CurentPrice, $nowdate)
    {
        $TimeDifrence = $nowdate - $BacktetItem->candate;
        if ($TimeDifrence > 14400) { // should terminate 4 Hour and goto 24 Hour BT
            $this->Init24Hour($BacktetItem, $CurentPrice);
        } else {

            if ($CurentPrice > $BacktetItem['C4HourPrice']) {
                $UpdateData = [
                    'C4HourPrice' => $CurentPrice,
                    'C4HourPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            } else {
                $UpdateData = [
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            }
        }
    }
    private function Init4Hour($BacktetItem, $CurentPrice)
    {
        $UpdateData = [
            'C4HourPrice' => $CurentPrice,
            'C4HourPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
            'extrainfo' => $this->get_extrainfo($CurentPrice),
            'status' => 6
        ];
        CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
    }
    private function Process2Hour($BacktetItem, $CurentPrice, $nowdate)
    {
        $TimeDifrence = $nowdate - $BacktetItem->candate;
        if ($TimeDifrence > 7200) { // should terminate 2 Hour and goto 4 Hour BT
            $this->Init4Hour($BacktetItem, $CurentPrice);
        } else {

            if ($CurentPrice > $BacktetItem['C2HourPrice']) {
                $UpdateData = [
                    'C2HourPrice' => $CurentPrice,
                    'C2HourPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            } else {
                $UpdateData = [
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            }
        }
    }
    private function Init2Hour($BacktetItem, $CurentPrice)
    {
        $UpdateData = [
            'C2HourPrice' => $CurentPrice,
            'C2HourPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
            'extrainfo' => $this->get_extrainfo($CurentPrice),
            'status' => 5
        ];
        CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
    }
    private function Process1Hour($BacktetItem, $CurentPrice, $nowdate)
    {
        $TimeDifrence = $nowdate - $BacktetItem->candate;
        if ($TimeDifrence > 3600) { // should terminate 1 hour and goto 2 Hour BT
            $this->Init2Hour($BacktetItem, $CurentPrice);
        } else {

            if ($CurentPrice > $BacktetItem['C1HourPrice']) {
                $UpdateData = [
                    'C1HourPrice' => $CurentPrice,
                    'C1HourPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            } else {
                $UpdateData = [
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            }
        }
    }
    private function Init1Hour($BacktetItem, $CurentPrice)
    {
        $UpdateData = [
            'C1HourPrice' => $CurentPrice,
            'C1HourPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
            'extrainfo' => $this->get_extrainfo($CurentPrice),
            'status' => 4
        ];
        CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
    }
    private function Process30Min($BacktetItem, $CurentPrice, $nowdate)
    {
        $TimeDifrence = $nowdate - $BacktetItem->candate;
        if ($TimeDifrence > 1800) { // should terminate 30 min and goto 30 min BT
            $this->Init1Hour($BacktetItem, $CurentPrice);
        } else {

            if ($CurentPrice > $BacktetItem['C30MuinPrice']) {
                $UpdateData = [
                    'C30MuinPrice' => $CurentPrice,
                    'C30MuinPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            } else {
                $UpdateData = [
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            }
        }
    }
    private function Init30Min($BacktetItem, $CurentPrice)
    {
        $UpdateData = [
            'C30MuinPrice' => $CurentPrice,
            'C30MuinPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
            'extrainfo' => $this->get_extrainfo($CurentPrice),
            'status' => 3
        ];
        CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
    }
    private function Process15Min($BacktetItem, $CurentPrice, $nowdate)
    {
        $TimeDifrence = $nowdate - $BacktetItem->candate;
        if ($TimeDifrence > 900) { // should terminate 5 + 15 min and goto 30 min BT
            $this->Init30Min($BacktetItem, $CurentPrice);
        } else {

            if ($CurentPrice > $BacktetItem['C15MuinPrice']) {
                $UpdateData = [
                    'C15MuinPrice' => $CurentPrice,
                    'C15MuinPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            } else {
                $UpdateData = [
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            }
        }
    }
    private function Init15Min($BacktetItem, $CurentPrice)
    {
        $UpdateData = [
            'C15MuinPrice' => $CurentPrice,
            'C15MuinPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
            'extrainfo' => $this->get_extrainfo($CurentPrice),
            'status' => 2
        ];
        CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
    }
    private function Process5Min($BacktetItem, $CurentPrice, $nowdate)
    {
        $TimeDifrence = $nowdate - $BacktetItem->candate;
        if ($TimeDifrence > 300) { // should terminate 5 min and goto 15 min BT
            $this->Init15Min($BacktetItem, $CurentPrice);
        } else {

            if ($CurentPrice > $BacktetItem['C5MuinPrice']) {
                $UpdateData = [
                    'C5MuinPrice' => $CurentPrice,
                    'C5MuinPercent' => $this->PercentCalc($BacktetItem->OpenPrice, $CurentPrice),
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            } else {
                $UpdateData = [
                    'extrainfo' => $this->get_extrainfo($CurentPrice)
                ];
                CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
            }
        }
    }

    private function Init5Min($BacktetItem, $CurentPrice)
    {
        $UpdateData = [
            'OpenPrice' => $CurentPrice,
            'C5MuinPrice' => $CurentPrice,
            'C5MuinPercent' => 0,
            'status' => 1,
            'extrainfo' => $this->get_extrainfo($CurentPrice)
        ];
        CoinBackTest::where('candate', $BacktetItem->candate)->where('curency', $BacktetItem->curency)->where('owner', $BacktetItem->owner)->update($UpdateData);
    }
    private function get_extrainfo($CurentPrice)
    {
        if ($this->extrainfo == null) {
            $temp = array();
            array_push($temp, array($this->nowdate => $CurentPrice));
            $extrainfo['price'] = $temp;
        } else {
            $extrainfo = json_decode($this->extrainfo, true);
            $temp = array();
            foreach ($extrainfo['price'] as $targetindex => $targetData) {
                foreach($targetData as $targettime => $targetPrice){
                    array_push($temp, array($targettime => $targetPrice));
                }
            }
            array_push($temp, array($this->nowdate => $CurentPrice));
            $extrainfo['price'] = $temp;
        }

        return json_encode($extrainfo);
    }
    public function Run_test()
    {
        $Setting = '1';
        $MyDate = new DateTimeClass;
        $nowdate =  $MyDate->get_now_int();
        $this->nowdate = $nowdate; //add
        if ($Setting == '1') { // backtest enable
            $Backtets = CoinBackTest::where('status', '<', 100)->get();
            foreach ($Backtets as $BacktetItem) {
                $this->extrainfo = $BacktetItem->extrainfo; //Add

                $CoinInfo =  crypto_price_1m::where('curency', $BacktetItem->curency . '-USDT')->orderBy('timestamp', 'DESC')->first();

                if ($CoinInfo != null) {
                    $CurentPrice = $CoinInfo->price ?? 0;
                    if ($BacktetItem->status == 0) { //Start Test Define 5 Min BT and change Status to 1
                        $this->Init5Min($BacktetItem, $CurentPrice);
                    } elseif ($BacktetItem->status == 1) { // Runing 5 Min BT 
                        $this->Process5Min($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 2) { // Runing 15 Min BT
                        $this->Process15Min($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 3) { // Runing 30 Min BT 
                        $this->Process30Min($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 4) { // Runing 1 Hour BT 
                        $this->Process1Hour($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 5) { // Runing 2 Hour BT 
                        $this->Process2Hour($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 6) { // Runing 4 Hour BT 
                        $this->Process4Hour($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 7) { // Runing 24 Hour BT 
                        $this->Process24Hour($BacktetItem, $CurentPrice, $nowdate);
                    }
                }
            }
        } else { //backtest disable
            return true;
        }
    }
    public function Run()
    {
        $Setting = CacheData::GetSetting('Crypto_Back_test');
        $MyDate = new DateTimeClass;
        $nowdate =  $MyDate->get_now_int();
        $this->nowdate = $nowdate; //add
        if ($Setting == '1') { // backtest enable
            $Backtets = CoinBackTest::where('status', '<', 100)->get();
            foreach ($Backtets as $BacktetItem) {
                $this->extrainfo = $BacktetItem->extrainfo; //Add

                $CoinInfo =  crypto_price_1m::where('curency', $BacktetItem->curency . '-USDT')->orderBy('timestamp', 'DESC')->first();

                if ($CoinInfo != null) {
                    $CurentPrice = $CoinInfo->price ?? 0;
                    if ($BacktetItem->status == 0) { //Start Test Define 5 Min BT and change Status to 1
                        $this->Init5Min($BacktetItem, $CurentPrice);
                    } elseif ($BacktetItem->status == 1) { // Runing 5 Min BT 
                        $this->Process5Min($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 2) { // Runing 15 Min BT
                        $this->Process15Min($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 3) { // Runing 30 Min BT 
                        $this->Process30Min($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 4) { // Runing 1 Hour BT 
                        $this->Process1Hour($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 5) { // Runing 2 Hour BT 
                        $this->Process2Hour($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 6) { // Runing 4 Hour BT 
                        $this->Process4Hour($BacktetItem, $CurentPrice, $nowdate);
                    } elseif ($BacktetItem->status == 7) { // Runing 24 Hour BT 
                        $this->Process24Hour($BacktetItem, $CurentPrice, $nowdate);
                    }
                }
            }
        } else { //backtest disable
            return true;
        }
    }

    public function BTMGT($type)
    {
        if ($type == 'system') {
            if (Auth::user()->Role == myappenv::role_SuperAdmin) {
                $Query = "SELECT bt.* ,c.pic FROM coin_back_tests as bt INNER JOIN currencies as c on bt.curency = c.MainName WHERE bt.status < 100 and bt.owner = 'system' ";
                $Curencys = DB::select($Query);
                $pageType = 'بک تست های سامانه';
                return view('Crypto/Admin/BTList', ['Curencys' => $Curencys, 'pageType' => $pageType]);
            } else {
                return abort('404', 'دسترسی غیر مجاز!');
            }
        }
        if ($type == 'my') {
            $Owner = Auth::id();
            $Query = "SELECT bt.* ,c.pic FROM coin_back_tests as bt INNER JOIN currencies as c on bt.curency = c.MainName WHERE bt.status < 100 and bt.owner = '$Owner' ";
            $Curencys = DB::select($Query);
            $pageType = 'بک تست های من';
            return view('Crypto/Admin/BTList', ['Curencys' => $Curencys, 'pageType' => $pageType]);
        }
        return abort('404', 'دسترسی غیر مجاز!');
    }
    public function DoBTMGT($type, Request $request)
    {
        if ($request->ajax()) {
            if ($request->AjaxType == 'get_crypto_graph') {
                $candate = $request->candate;
                $curency = $request->curency;
                $backtest_src = CoinBackTest::where('curency', $curency)->where('candate', $candate)->first();
                if ($backtest_src == null) {
                    return false;
                }
                $price_history = $backtest_src->extrainfo;
                if ($price_history == null) {
                    return [];
                }
                $price_history = json_decode($price_history);
                return $price_history->price;
            }
        }
    }
}
