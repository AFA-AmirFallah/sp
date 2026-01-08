<?php

/***
 //@version=4
strategy("Green Flag Strategy", shorttitle="Green Flag", overlay=true)

// Calculate EMAs
ema10 = ema(close, 10)
ema60 = ema(close, 60)

// Calculate Stochastic oscillator
stochK = sma(stoch(close, high, low, 5), 3)

// Calculate MACD Histogram
[_, _, macdHist] = macd(close, 10, 60, 9)

// Calculate RSI
rsi = rsi(close, 10)

// Calculate RSI Base MA
rsiBaseMA = sma(rsi, 10)

// Define the conditions for entering a long position
longCondition = ema10 > ema60 and stochK < 20 and macdHist > 0 and rsi < 70 

// Plot the green flag on the main plot when the long condition is met
plotshape(series=longCondition, title="Green Flag", location=location.belowbar, color=color.green, style=shape.triangleup, size=size.small)

// Submit long order when the long condition is met
strategy.entry("Long", strategy.long, when=longCondition)

// Exit long position when the opposite conditions occur
strategy.close("Long", when=not longCondition)
 */

namespace App\Crypto\Strategy;

use App\Crypto\TradersFunctions;
use App\Functions\DateTimeClass;
use App\Models\CoinBackTest;
use App\Models\crypto_price_1m;
use App\Models\Currency;
use DB;
use Illuminate\Support\Facades\Log;

class kv_1 extends TradersFunctions
{
    private $BaseCoins;
    private $PriceArrRes_60;
    private $PriceArrRes_10;
    private function ema_1($coin_name, $timeframe)
    {
        if ($timeframe == 60) {
            $Query = "SELECT * FROM crypto_price_1hs WHERE curency = '$coin_name' ORDER BY candate  DESC  , canh DESC  LIMIT 61";
        }
        if ($timeframe == 15) {
            $Query = "SELECT * FROM crypto_price_15ms WHERE curency = '$coin_name' ORDER BY candate  DESC LIMIT 61";
        }
        $candles_src = DB::select($Query);
        $PriceArrRes_10 = [];
        $PriceArrRes_60 = [];
        $PriceArrRes_5_h = [];
        $PriceArrRes_5_l = [];
        $PriceArrRes_5_c = [];
        $totallCount = 0;
        $multiple_position = null;
        foreach ($candles_src as $PriceArrItem) {
            $totallCount++;
            if ($totallCount <= 61) {
                if ($multiple_position == null) {
                    $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice);
                    $Price = $PriceArr['result'];
                    $multiple_position = $PriceArr['position'];
                } else {
                    $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice, $multiple_position);
                    $Price = $PriceArr['result'];
                }

                array_push($PriceArrRes_60, $Price);
                if ($totallCount <= 11) {
                    array_push($PriceArrRes_10, $Price);
                }
                if ($totallCount <= 5) {
                    array_push($PriceArrRes_5_c, $Price);
                    $PriceArr_h =  $this->price_scaling($PriceArrItem->HighPrice, $multiple_position);
                    $Price_h = $PriceArr_h['result'];
                    array_push($PriceArrRes_5_h, $Price_h);
                    $PriceArr_l =  $this->price_scaling($PriceArrItem->LowPrice, $multiple_position);
                    $Price_l = $PriceArr_l['result'];
                    array_push($PriceArrRes_5_l, $Price_l);
                }
            }
        }
        try {
            if ($totallCount > 60) {
                $Priod_60 = 60;
                $Priod_10 = 10;
                $Priod_5 = 5;
            } else {
                $Priod_60 = $totallCount;
                if ($totallCount > 10) {
                    $Priod_10 = 10;
                    $Priod_5 = 5;
                } else {
                    $Priod_10 = $totallCount;
                }
                if ($totallCount > 5) {
                    $Priod_5 = 5;
                } else {
                    $Priod_5 = $totallCount;
                }
            }
            $this->PriceArrRes_60 = $PriceArrRes_60;
            $ema60 = trader_ema($PriceArrRes_60, $Priod_60);
            $this->PriceArrRes_10 = $PriceArrRes_10;
            $ema10 = trader_ema($PriceArrRes_10, $Priod_10);
            return [
                'result' => true,
                'ema60' => $ema60,
                'ema10' => $ema10

            ];
            $rsi = trader_rsi($PriceArrRes_10, $Priod_10 - 1);
            foreach ($rsi as $rsi_item) {
                $rsi = $rsi_item;
            }
            $stochK =  trader_stoch($PriceArrRes_5_h, $PriceArrRes_5_l, $PriceArrRes_5_c, 3);
            $stochK = trader_sma($stochK[0], 3);
            foreach ($stochK as $stochK_item) {
                $stochK = $stochK_item;
            }

            return [
                'result' => true,
                'ema60' => $ema60,
                'ema10' => $ema10,
                'rsi' => $rsi,
                'stochK' => $stochK
            ];
        } catch (\Exception $e) {

            return [
                'result' => false
            ];
        }
    }
    private function ema($coin_name)
    {
        $Query = "SELECT * FROM crypto_price_1hs WHERE curency = '$coin_name' ORDER BY candate  DESC  , canh DESC  LIMIT 60";
        $candles_src = DB::select($Query);
        $PriceArrRes_10 = [];
        $PriceArrRes_60 = [];
        $PriceArrRes_5_h = [];
        $PriceArrRes_5_l = [];
        $PriceArrRes_5_c = [];
        $totallCount = 0;

        foreach ($candles_src as $PriceArrItem) {
            $totallCount++;
            if ($totallCount <= 60) {
                $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice);
                $Price = $PriceArr['result'];
                array_push($PriceArrRes_60, $Price);
                if ($totallCount <= 10) {
                    array_push($PriceArrRes_10, $Price);
                }
                if ($totallCount <= 5) {
                    array_push($PriceArrRes_5_c, $Price);
                    $PriceArr_h =  $this->price_scaling($PriceArrItem->HighPrice);
                    $Price_h = $PriceArr_h['result'];
                    array_push($PriceArrRes_5_h, $Price_h);
                    $PriceArr_l =  $this->price_scaling($PriceArrItem->LowPrice);
                    $Price_l = $PriceArr_l['result'];
                    array_push($PriceArrRes_5_l, $Price_l);
                }
            }
        }
        try {
            if ($totallCount > 60) {
                $Priod_60 = 60;
                $Priod_10 = 10;
                $Priod_5 = 5;
            } else {
                $Priod_60 = $totallCount;
                if ($totallCount > 10) {
                    $Priod_10 = 10;
                    $Priod_5 = 5;
                } else {
                    $Priod_10 = $totallCount;
                }
                if ($totallCount > 5) {
                    $Priod_5 = 5;
                } else {
                    $Priod_5 = $totallCount;
                }
            }
            $this->PriceArrRes_60 = $PriceArrRes_60;
            $ema60 = trader_ema($PriceArrRes_60, $Priod_60);
            foreach ($ema60 as $ema60_item) {
                $ema60 = $ema60_item;
            }
            $this->PriceArrRes_10 = $PriceArrRes_10;
            $ema10 = trader_ema($PriceArrRes_10, $Priod_10);
            foreach ($ema10 as $ema10_item) {
                $ema10 = $ema10_item;
            }
            $rsi = trader_rsi($PriceArrRes_10, $Priod_10 - 1);
            foreach ($rsi as $rsi_item) {
                $rsi = $rsi_item;
            }
            $stochK =  trader_stoch($PriceArrRes_5_h, $PriceArrRes_5_l, $PriceArrRes_5_c, 3);
            $stochK = trader_sma($stochK[0], 3);
            foreach ($stochK as $stochK_item) {
                $stochK = $stochK_item;
            }

            return [
                'result' => true,
                'ema60' => $ema60,
                'ema10' => $ema10,
                'rsi' => $rsi,
                'stochK' => $stochK
            ];
        } catch (\Exception $e) {

            return [
                'result' => false
            ];
        }
    }

    public function run($sample = false)
    {
        $this->BaseCoins = Currency::where('status', 10)->get();
        $Counter = 0;
        foreach ($this->BaseCoins as $BaseCoins) {
            $Counter++;
            $Emas = $this->ema_1($BaseCoins->name, 60);
            if ($Emas['result']) {
                if ($Emas['ema60']['60'] < $Emas['ema10']['10']) {
                    $difrence_previus = $Emas['ema10']['9'] - $Emas['ema60']['59'];
                    $difrence_curent = $Emas['ema10']['10'] - $Emas['ema60']['60'];
                    if ($difrence_curent > $difrence_previus) {
                        $Emas = $this->ema_1($BaseCoins->name, 15);
                        if ($Emas['result']) {
                            if (!isset($Emas['ema60']['60'])) {
                                continue;
                            }
                            if ($Emas['ema60']['60'] > $Emas['ema10']['10']) {
                                $difrence_previus = $Emas['ema10']['9'] - $Emas['ema60']['59'];
                                $difrence_curent = $Emas['ema10']['10'] - $Emas['ema60']['60'];
                                if ($difrence_curent > $difrence_previus) {
                                    if (!$sample) {
                                        Log::channel('slack')->info($BaseCoins->MainName . ' Run Robot KV_1');
                                        echo ('<br> ' . $Counter . ': success on : ' . $BaseCoins->MainName);
                                        print_r($Emas);
                                        $OldBacktest = CoinBackTest::where('curency', $BaseCoins->MainName)->where('owner', 'system')->where('status', '<', 100)->first();
                                        if ($OldBacktest == null) { // the coin is not in backtest list
                                            $CoinInfo =  crypto_price_1m::where('curency', $BaseCoins->name)->first();
                                            $MyDate = new DateTimeClass;
                                            $nowdate =  $MyDate->get_now_int();
                                            $NewData = [
                                                'candate' => $nowdate,
                                                'curency' => $BaseCoins->MainName,
                                                'owner' => 'system',
                                                'OfferType' => 2,
                                                'OpenPrice' => $CoinInfo->price
                                            ];
                                            CoinBackTest::create($NewData);
                                        }
                                    } else {
                                        echo ('<br> ' . $Counter . ': is success on : ' . $BaseCoins->MainName . ' <br> ');
                                        print_r($Emas);
                                        echo ('<br>  PriceArrRes_10 : ');
                                        print_r($this->PriceArrRes_10);
                                        echo ('<br>  PriceArrRes_60 : ');
                                        print_r($this->PriceArrRes_60);
                                    }
                                }
                            }
                        } else {
                        }
                    }
                }
            } else {
            }
        }
    }
    public function run_bck($sample = false)
    {
        $this->BaseCoins = Currency::where('status', 10)->get();
        $Counter = 0;
        foreach ($this->BaseCoins as $BaseCoins) {
            $Counter++;
            $Emas = $this->ema($BaseCoins->name);
            if ($Emas['result']) {
                $ema60 = $Emas['ema60'];
                $ema10 = $Emas['ema10'];
                $rsi = $Emas['rsi'];
                $stochK = $Emas['stochK'];
                //ema10 > ema60 and stochK < 20 and macdHist > 0 and rsi < 70 
                if ($ema10 > $ema60 && $stochK < 20 && $rsi < 70) {
                    if (!$sample) {
                        Log::channel('slack')->info($BaseCoins->MainName . ' Run Robot KV_1');
                        echo ('<br> ' . $Counter . ': success on : ' . $BaseCoins->MainName);
                        print_r($Emas);
                        $OldBacktest = CoinBackTest::where('curency', $BaseCoins->MainName)->where('owner', 'system')->where('status', '<', 100)->first();
                        if ($OldBacktest == null) { // the coin is not in backtest list
                            $CoinInfo =  crypto_price_1m::where('curency', $BaseCoins->name)->first();
                            $MyDate = new DateTimeClass;
                            $nowdate =  $MyDate->get_now_int();
                            $NewData = [
                                'candate' => $nowdate,
                                'curency' => $BaseCoins->MainName,
                                'owner' => 'system',
                                'OfferType' => 2,
                                'OpenPrice' => $CoinInfo->price
                            ];
                            CoinBackTest::create($NewData);
                        }
                    } else {
                        echo ('<br> ' . $Counter . ': is success on : ' . $BaseCoins->MainName . ' <br> ');
                        print_r($Emas);
                        echo ('<br>  PriceArrRes_10 : ');
                        print_r($this->PriceArrRes_10);
                        echo ('<br>  PriceArrRes_60 : ');
                        print_r($this->PriceArrRes_60);
                    }
                } else {
                    /*
                    echo ('<br> '.$Counter.': not success on : ' . $BaseCoins->MainName);
                    print_r($Emas);*/
                }
            } else {
                echo ('<br> error on : ' . $BaseCoins->name);
            }
        }
    }
}
