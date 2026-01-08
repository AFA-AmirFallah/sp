<?php

/***
 //@version=4
strategy("Green Flag Strategy", shorttitle="Green Flag", overlay=true)

// Calculate EMAs

ema60 = ema(close, 26)

last price opper than ema 26 
ship more than 10 degree

 */

namespace App\Crypto\Strategy;

use App\Crypto\TradersFunctions;
use App\Functions\DateTimeClass;
use App\Models\CoinBackTest;
use App\Models\crypto_price_1m;
use App\Models\Currency;
use DB;
use Illuminate\Support\Facades\Log;

class kv_2 extends TradersFunctions
{
    private $BaseCoins;
    private $PriceArrRes_60;
    private $PriceArrRes_10;
    private function ema_1($coin_name, $timeframe, $period)
    {
        $target_period = $period + 1;
        if ($timeframe == 60) {
            $Query = "SELECT * FROM crypto_price_1hs WHERE curency = '$coin_name' ORDER BY candate  DESC  , canh DESC  LIMIT $target_period";
        }
        if ($timeframe == 15) {
            $Query = "SELECT * FROM crypto_price_15ms WHERE curency = '$coin_name' ORDER BY candate  DESC LIMIT $target_period";
        }
        $candles_src = DB::select($Query);
        $PriceArrRes_60 = [];
        $last_price = 0;
        $totallCount = 0;
        $multiple_position = null;
        foreach ($candles_src as $PriceArrItem) {
            $totallCount++;
            if ($multiple_position == null) {
                $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice);
                $Price = $PriceArr['result'];
                $last_price = $Price;
                $multiple_position = $PriceArr['position'];
            } else {
                $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice, $multiple_position);
                $Price = $PriceArr['result'];
            }

            array_push($PriceArrRes_60, $Price);
        }
        try {
            if ($totallCount > $period) {
                $Priod_60 = $period;
            } else {
                $Priod_60 = $totallCount;
            }
            $this->PriceArrRes_60 = $PriceArrRes_60;
            $ema60 = trader_ema($PriceArrRes_60, $Priod_60);
            return [
                'result' => true,
                'ema' . $period => $ema60,
                'last_price' => $last_price

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
            $Emas = $this->ema_1($BaseCoins->name, 60, 26);
            if ($Emas['result']) {

                if (!isset($Emas['ema26']['26'])) {
                    continue;
                }
                if (!isset($Emas['ema26']['25'])) {
                    continue;
                }

                if ($Emas['ema26']['26'] < $Emas['last_price']) {

                   // $deg = $Emas['ema26']['25'] + ($Emas['ema26']['25'] * 2 / 100);
                    if ($Emas['ema26']['26'] > $Emas['ema26']['25']) {
                        $Emas = $this->ema_1($BaseCoins->name, 15, 26);
                        if ($Emas['result']) {
                            if (!isset($Emas['ema26']['26'])) {
                                continue;
                            }
                            if (!isset($Emas['ema26']['25'])) {
                                continue;
                            }
                            if ($Emas['ema26']['26'] < $Emas['last_price']) {
                              //  $deg = $Emas['ema26']['25'] + ($Emas['ema26']['25'] * 2 / 100);
                                if ($Emas['ema26']['26'] > $Emas['ema26']['25']) {
                                    if (!$sample) {
                                        Log::channel('slack')->info($BaseCoins->MainName . ' Run Robot KV_2');
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
                                                'OfferType' => 3,
                                                'OpenPrice' => $CoinInfo->price
                                            ];
                                            CoinBackTest::create($NewData);
                                        }
                                    } else {
                                        echo ('<br> ' . $Counter . ': is success on : ' . $BaseCoins->MainName . ' <br> ');
                                        print_r($Emas);
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
}
