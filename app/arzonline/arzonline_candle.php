<?php

namespace App\arzonline;

use App\Functions\DateTimeClass;
use App\Functions\persian;
use App\Models\crypto_price_15ms;
use App\Models\crypto_price_1hs;
use App\Models\crypto_price_1m;
use App\Models\crypto_price_24hs;
use App\Models\crypto_price_30ms;
use App\Models\crypto_price_5ms;
use App\Models\Currency;
use App\Models\metadata;
use Carbon\Carbon;

class arzonline_candle
{
    public function update_candles($currency_attr, $currency_name)
    {
        $Mydate = new DateTimeClass;
        $MainDate = date("Y-m-d");
        $Rtime = date("H");
        $Hour = intval($Rtime);
        $candate = $Mydate->get_now_int();
        $Max5Min = $Mydate->get_now_defrence(-5);
        $Max15Min = $Mydate->get_now_defrence(-15);
        $Max30Min = $Mydate->get_now_defrence(-30);
        $Source5Mins = crypto_price_5ms::where('candate', '>', $Max5Min)->where('curency', $currency_name)->first(); // last id from famus coin 
        $Source15Mins = crypto_price_15ms::where('candate', '>', $Max15Min)->where('curency', $currency_name)->first(); // last id from famus coin 
        $Source30Mins = crypto_price_30ms::where('candate', '>', $Max30Min)->where('curency', $currency_name)->first(); // last id from famus coin 
        $Source5Mins == null  ? $Id5Min = null : $Id5Min = $Source5Mins->candate;
        $Source15Mins == null  ? $Id15Min = null : $Id15Min = $Source15Mins->candate;
        $Source30Mins == null  ? $Id30Min = null : $Id30Min = $Source30Mins->candate;
        $this->Candle1HWorks($MainDate, $Hour, $currency_attr, $currency_name);
        $this->Candle24HWorks($MainDate,$currency_attr, $currency_name);
        $this->Candle5MWorks($Id5Min, $currency_attr, $candate, $currency_name);
        $this->Candle15MWorks($Id15Min, $currency_attr, $candate, $currency_name);
        $this->Candle30MWorks($Id30Min, $currency_attr, $candate, $currency_name);
        $this->add_1_minute_candle($currency_attr, $currency_name, $candate);
        $this->freeDB();
    }
    public function freeDB()
    {
        $Today = date('Y-m-d', strtotime(' -5 day'));
        crypto_price_1hs::where('candate', $Today)->delete();
        $mydate = new DateTimeClass;
        $Expire5M = $mydate->get_now_defrence(-300); // 60 candle
        crypto_price_5ms::where('candate', '<', $Expire5M)->delete();
        $Expire15M = $mydate->get_now_defrence(-900); // 60 candle
        crypto_price_15ms::where('candate', '<', $Expire15M)->delete();
        $Expire30M = $mydate->get_now_defrence(-1800); // 60 candle
        crypto_price_30ms::where('candate', '<', $Expire30M)->delete();
        return true;
    }
    private function add_1_minute_candle($market_attr, $currency_name, $candate)
    {
        $PriceData = [
            'timestamp' => $candate,
            'curency' => $currency_name,
            'price' => $market_attr->price
        ];
        crypto_price_1m::create($PriceData);
    }
    private function Candle5MWorks($Id5Min, $MarketItem, $candate, $currency_name)
    {
        if ($Id5Min == null) {
            $AddNew = true;
        } else {
            $Source5Mins = crypto_price_5ms::where('candate', $Id5Min)->where('curency', $currency_name)->first();
            if ($Source5Mins == null) {
                $AddNew = true;
            } else {
                $AddNew = false;
            }
        }

        if ($AddNew) { // no field find and should add new feild
            $CandleData = [
                'candate' => $candate,
                'curency' => $currency_name,
                'OpenPrice' => $MarketItem->price,
                'ClosePrice' => $MarketItem->price,
                'HighPrice' => $MarketItem->price,
                'Percent' => 0,
                'LowPrice' => $MarketItem->price
            ];
            crypto_price_5ms::create($CandleData);
        } else { // the feild exsit and should to update
            $changeFlag = false;
            $HighPrice = $Source5Mins->HighPrice;
            $LowPrice = $Source5Mins->LowPrice;
            $OpenPrice = $Source5Mins->OpenPrice;
            if ($MarketItem->price > $HighPrice) {
                $HighPrice = $MarketItem->price;
                $changeFlag = true;
            }
            if ($MarketItem->price < $LowPrice) {
                $LowPrice = $MarketItem->price;
                $changeFlag = true;
            }
            if ($changeFlag) {
                $Percent = ($MarketItem->price - $OpenPrice) * 100 / $OpenPrice;
                $CandleData = [
                    'ClosePrice' => $MarketItem->price,
                    'HighPrice' => $HighPrice,
                    'Percent' => $Percent,
                    'LowPrice' => $LowPrice
                ];
                crypto_price_5ms::where('candate', $Id5Min)->where('curency', $currency_name)->update($CandleData);
            }
        }
    }
    private function Candle15MWorks($Id15Min, $MarketItem, $candate, $currency_name)
    {
        if ($Id15Min == null) {
            $AddNew = true;
        } else {
            $Source15Mins = crypto_price_15ms::where('candate', $Id15Min)->where('curency', $currency_name)->first();
            if ($Source15Mins == null) {
                $AddNew = true;
            } else {
                $AddNew = false;
            }
        }

        if ($AddNew) { // no field find and should add new feild
            $CandleData = [
                'candate' => $candate,
                'curency' => $currency_name,
                'OpenPrice' => $MarketItem->price,
                'ClosePrice' => $MarketItem->price,
                'HighPrice' => $MarketItem->price,
                'Percent' => 0,
                'LowPrice' => $MarketItem->price
            ];
            crypto_price_15ms::create($CandleData);
        } else { // the feild exsit and should to update
            $changeFlag = false;
            $HighPrice = $Source15Mins->HighPrice;
            $LowPrice = $Source15Mins->LowPrice;
            $OpenPrice = $Source15Mins->OpenPrice;

            if ($MarketItem->price > $HighPrice) {
                $HighPrice = $MarketItem->price;
                $changeFlag = true;
            }
            if ($MarketItem->price < $LowPrice) {
                $LowPrice = $MarketItem->price;
                $changeFlag = true;
            }
            if ($changeFlag) {
                $Percent = ($MarketItem->price - $OpenPrice) * 100 / $OpenPrice;
                $CandleData = [
                    'ClosePrice' => $MarketItem->price,
                    'HighPrice' => $HighPrice,
                    'Percent' => $Percent,
                    'LowPrice' => $LowPrice
                ];
                crypto_price_15ms::where('candate', $Id15Min)->where('curency', $currency_name)->update($CandleData);
            }
        }
    }
    private function Candle30MWorks($Id30Min, $MarketItem, $candate, $currency_name)
    {

        if ($Id30Min == null) {
            $AddNew = true;
        } else {
            $Source30Mins = crypto_price_30ms::where('candate', $Id30Min)->where('curency', $currency_name)->first();
            if ($Source30Mins == null) {
                $AddNew = true;
            } else {
                $AddNew = false;
            }
        }

        if ($AddNew) { // no field find and should add new feild
            $CandleData = [
                'candate' => $candate,
                'curency' => $currency_name,
                'OpenPrice' => $MarketItem->price,
                'ClosePrice' => $MarketItem->price,
                'HighPrice' => $MarketItem->price,
                'Percent' => 0,
                'LowPrice' => $MarketItem->price
            ];
            crypto_price_30ms::create($CandleData);
            // info('add new :' . $currency_name . ' '.$candate );
        } else { // the feild exsit and should to update
            $changeFlag = false;
            $HighPrice = $Source30Mins->HighPrice;
            $LowPrice = $Source30Mins->LowPrice;
            $OpenPrice = $Source30Mins->OpenPrice;

            if ($MarketItem->price > $HighPrice) {
                $HighPrice = $MarketItem->price;
                $changeFlag = true;
            }
            if ($MarketItem->price < $LowPrice) {
                $LowPrice = $MarketItem->price;
                $changeFlag = true;
            }
            if ($changeFlag) {
                $Percent = ($MarketItem->price - $OpenPrice) * 100 / $OpenPrice;
                $CandleData = [
                    'ClosePrice' => $MarketItem->price,
                    'HighPrice' => $HighPrice,
                    'Percent' => $Percent,
                    'LowPrice' => $LowPrice
                ];
                crypto_price_30ms::where('candate', $Id30Min)->where('curency', $currency_name)->update($CandleData);
            }
        }
    }
    private function Candle24HWorks($MainDate, $MarketItem, $currency_name)
    {
        $persian = new persian;
        $CandleSrc = crypto_price_24hs::where('candate', $MainDate)->where('curency', $currency_name)->first();
        if ($CandleSrc == null) { // no field find and should add new feild
            $MainDate_p = $persian->MyPersianDate($MainDate);
            $CandleData = [
                'candate' => $MainDate,
                'candate_p' => $MainDate_p,
                'curency' => $currency_name,
                'OpenPrice' => $MarketItem->price,
                'ClosePrice' => $MarketItem->price,
                'HighPrice' => $MarketItem->price,
                'Percent' => 0,
                'LowPrice' => $MarketItem->price
            ];
            crypto_price_24hs::create($CandleData);
        } else { // the feild exsit and should to update
            $changeFlag = false;
            $HighPrice = $CandleSrc->HighPrice;
            $LowPrice = $CandleSrc->LowPrice;
            $OpenPrice = $CandleSrc->OpenPrice;

            if ($MarketItem->price > $HighPrice) {
                $HighPrice = $MarketItem->price;
                $changeFlag = true;
            }
            if ($MarketItem->price < $LowPrice) {
                $LowPrice = $MarketItem->price;
                $changeFlag = true;
            }
            if ($changeFlag) {
                $Percent = ($MarketItem->price - $OpenPrice) * 100 / $OpenPrice;
                $CandleData = [
                    'ClosePrice' => $MarketItem->price,
                    'HighPrice' => $HighPrice,
                    'Percent' => $Percent,
                    'LowPrice' => $LowPrice
                ];
                crypto_price_24hs::where('candate', $MainDate)->where('curency', $currency_name)->update($CandleData);
            }
        }
    }
    private function Candle1HWorks($MainDate, $Hour, $MarketItem, $currency_name)
    {
        $CandleSrc = crypto_price_1hs::where('candate', $MainDate)->where('canh', $Hour)->where('curency', $currency_name)->first();
        if ($CandleSrc == null) { // no field find and should add new feild
            $CandleData = [
                'candate' => $MainDate,
                'canh' => $Hour,
                'curency' => $currency_name,
                'OpenPrice' => $MarketItem->price,
                'ClosePrice' => $MarketItem->price,
                'HighPrice' => $MarketItem->price,
                'Percent' => 0,
                'LowPrice' => $MarketItem->price
            ];
            crypto_price_1hs::create($CandleData);
        } else { // the feild exsit and should to update
            $changeFlag = false;
            $HighPrice = $CandleSrc->HighPrice;
            $LowPrice = $CandleSrc->LowPrice;
            $OpenPrice = $CandleSrc->OpenPrice;

            if ($MarketItem->price > $HighPrice) {
                $HighPrice = $MarketItem->price;
                $changeFlag = true;
            }
            if ($MarketItem->price < $LowPrice) {
                $LowPrice = $MarketItem->price;
                $changeFlag = true;
            }
            if ($changeFlag) {
                $Percent = ($MarketItem->price - $OpenPrice) * 100 / $OpenPrice;
                $CandleData = [
                    'ClosePrice' => $MarketItem->price,
                    'HighPrice' => $HighPrice,
                    'Percent' => $Percent,
                    'LowPrice' => $LowPrice
                ];
                crypto_price_1hs::where('candate', $MainDate)->where('canh', $Hour)->where('curency', $currency_name)->update($CandleData);
            }
        }
    }

}
