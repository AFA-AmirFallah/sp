<?php

namespace App\Crypto;

use App\APIS\SmsCenter;
use App\Models\coins;
use App\Models\UserInfo;
use Throwable;
use stdClass;
use App\Http\Controllers\Crypto\kucoin;
use Illuminate\Support\Facades\Storage;
use App\Crypto\CryptoFormola_1;
use App\Functions\DateTimeClass;
use App\Functions\persian;
use App\Http\Controllers\Credit\currency as CreditCurrency;
use App\Http\Controllers\Crypto\backtest;
use App\Http\Controllers\Crypto\coinex;
use App\Models\crypto_price_15ms;
use App\Models\crypto_price_1hs;
use App\Models\crypto_price_30ms;
use App\Models\crypto_price_5ms;
use App\Models\Currency;
use App\Models\metadata;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use DB;
use Auth;
use Exception;

/**
 * Coin status:
 * 0 is defult
 * 10 need to sysc
 */

class CryptoFunctions
{
    private $Token;
    private $MarketSrc = null;
    private $TargetMarket = 'TMN';
    private $MarketInfo = null;
    private $UserName = null;

    private function SetFutureCurencys()
    {
        $kuCoin = new kucoin();
        $ContractSrc = $kuCoin->get_contacts();
        if ($ContractSrc) {
            Currency::where('future', '!=', 0)->update(['future' => false]);
            foreach ($ContractSrc as $ContractItem) {
                $baseCurrency = $ContractItem['baseCurrency'];
                $quoteCurrency = $ContractItem['quoteCurrency'];
                $settleCurrency = $ContractItem['settleCurrency'];
                $makerFeeRate = $ContractItem['makerFeeRate'];
                $takerFeeRate = $ContractItem['takerFeeRate'];
                $fstatus = $ContractItem['status']; // Open
                $maxLeverage = $ContractItem['maxLeverage'];
                if ($fstatus == 'Open' && $quoteCurrency == 'USDT') {
                    $UpdateData = [
                        'future' => true,
                        'maxLeverage' => $maxLeverage,
                        'f_makerFeeRate' => $makerFeeRate,
                        'f_takerFeeRate' => $takerFeeRate
                    ];
                    Currency::where('MainName', $baseCurrency)->update($UpdateData);
                }
            }
        }
        return true;
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
        $this->SetFutureCurencys();
        return true;
    }
    public function Loop_1()
    {
        // $kuCoin = new kucoin;
        //$tickers = $kuCoin->get_all_tickers();
        // Cache::put('tickers',  $tickers);
        $Formola = new CryptoFormola_1;
        $Formola->watchDog();
        Log::info('Loop_1'); // get market update data 
    }
    public function Loop_2()
    {
        $this->RenewWalet();
        Log::info('Loop_2'); // User walet update based on loop1 info
    }
    public function Loop_3()
    {
        $Formola = new CryptoFormola_1;
        $Formola->watchDog();
        Log::info('Loop_3');  // Review Orders

    }
    public function Loop_4()
    {
        Log::info('Loop_4');;   //set stop and buy limit
        $Formola = new CryptoFormola_1;
        $Formola->buy_coins();
        $Formola->watchDog();
    }
    public function Loop_5()
    {
        $Formola = new CryptoFormola_1;
        $Formola->set_Coins_market_limit();
        $Formola->watchDog();
        Log::info('Loop_5'); // update openOrders status
    }
    public function CoinexTickers()
    {
        $Coinex = new coinex();
        $Coinex->SaveTicker();
    }
    public function ExchangeDifrence()
    {
    }

    public function RobotExecute()
    {
        $kuCoin = new kucoin();
        $kuCoin->save_tickers();
        $BT = new backtest;
        $BT->Run();

        echo 'Done';
        return true;
        return $this->Loop_1();
        //return $this->Loop_3();
        if (Storage::exists('LoopCounter.txt')) {
            $LoopCounter = Storage::get('LoopCounter.txt');
            $LoopNumber = ($LoopCounter % 5) + 1;
            $LoopCounter++;
            if ($LoopCounter > 1440) { //reset loop counter after 24 hours
                $LoopCounter = 1;
            }
            Storage::put('LoopCounter.txt', $LoopCounter);
        } else {
            $LoopCounter = 1;
            Storage::put('LoopCounter.txt', $LoopCounter);
        }

        switch ($LoopNumber) {
            case 1:
                return $this->Loop_1();
            case 2:
                return $this->Loop_2();
            case 3:
                return $this->Loop_3();
            case 4:
                return $this->Loop_4();
            case 5:
                return $this->Loop_5();
        }
    }


    public function openOrders()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wallex.ir/v1/account/openOrders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'

        ));
        $headers = [
            'x-api-key:' . $this->Token
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        try {
            if ($response['success'] == true) {
                $response = $response['result'];
                return ($response['orders']);
            } else {
                return false;
            }
        } catch (\Exception) {
            return false;
        }
    }

    public function TokenSetter($Token, $UserName = null)
    {
        $this->Token = $Token;
        $this->UserName = $UserName;
    }

    /**
     * Undocumented function
     *
     * @return market list array
     */
    public function markets($MarketName = null)
    {



        if ($this->MarketSrc == null) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.wallex.ir/v1/markets',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET'

            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response, true);
            try {
                if ($response['success'] == true) {
                    $response = $response['result']['symbols'];
                    $this->MarketSrc = $response;
                    if ($MarketName == null) {
                        return ($response);
                    } else {
                        return ($response[$MarketName]);
                    }
                } else {
                    return false;
                }
            } catch (\Exception) {
                return false;
            }
        } else {
            if ($MarketName == null) {
                return ($this->MarketSrc);
            } else {
                return ($this->MarketSrc[$MarketName]);
            }
        }
    }
    public function get_formol_1_result($MarketAnalyze)
    {
        //dd($MarketAnalyze);
        $MarketPercnet = $MarketAnalyze['MarketPercnet'];
        $PriceLocationPercnet = $MarketAnalyze['PriceLocationPercnet'];
        if ($PriceLocationPercnet >= 50) {
            $PriceLocationPercnet = 100 - (($PriceLocationPercnet - 50) * 2);
        } else {
            $PriceLocationPercnet = 100 - ((50 - $PriceLocationPercnet) * 2);
        }
        $Telorance = $MarketAnalyze['Telorance'];
        if ($Telorance < 3) { // The price tlorance not usefull
            return 0;
        }
        $BUY = $MarketAnalyze['BUY'];
        if ($BUY < 50) {
            return 0;
        }
        $BuyPercent = $MarketAnalyze['BuyPercent'];
        if ($BuyPercent < 50) {
            return 0;
        }
        $result = round(($PriceLocationPercnet + $BuyPercent) / 2, 0);


        $AmountBuyPercent = $MarketAnalyze['AmountBuyPercent'];
        $BuyPercent = $MarketAnalyze['BuyPercent'];
        // $Calc =  $PriceLocationPercnet + $AmountBuyPercent + ($AmountBuyPercent *2 /10)  + $BuyPercent;
        $Calc =  $AmountBuyPercent   + $BuyPercent;
        return  $result;
    }
    public function MarketAlyzeRaw($MarketName = null, $MarketEnds = null)
    {
        try {
            $MarketSrc = $this->markets($MarketName);
            $Output =  array();
            foreach ($MarketSrc as $MarketSrcItem) {
                $stats = $MarketSrcItem['stats'];
                $CoinData = [
                    'symbol' => $MarketSrcItem['symbol'], //نماد (انگلیسی) بازار
                    'baseAsset' => $MarketSrcItem['baseAsset'], //ارز پایه
                    'baseAssetPrecision' => $MarketSrcItem['baseAssetPrecision'], //تعداد اعشار ارز پایه
                    'quoteAsset' => $MarketSrcItem['quoteAsset'], //ارز تجاری
                    'quotePrecision' => $MarketSrcItem['quotePrecision'], //تعداد اعشار ارز تجاری
                    'faName' => $MarketSrcItem['faName'], //نام فارسی بازار
                    'faBaseAsset' => $MarketSrcItem['faBaseAsset'], //نام فارسی ارز پایه
                    'faQuoteAsset' => $MarketSrcItem['faQuoteAsset'], //نام فارسی ارز تجاری
                    'stepSize' => $MarketSrcItem['stepSize'], //تعداد اعشار افزایش/کاهش حجم تراکنش
                    'tickSize' => $MarketSrcItem['tickSize'], //تعداد اعشار افزایش/کاهش مبلغ تراکنش
                    'minQty' => $MarketSrcItem['minQty'], //حداقل حجم تراکنش
                    'minNotional' => $MarketSrcItem['minNotional'], //حداقل مبلغ تراکنش
                    'bidPrice' => $stats['bidPrice'], //بیشترین قیمت سفارش‌های خرید
                    'askPrice' => $stats['askPrice'], //کمترین قیمت سفارش‌های فروش
                    'ch_24h' => $stats['24h_ch'], //درصد تغییرات قیمت در ۲۴ ساعت گذشته
                    'ch_7d' => $stats['7d_ch'], //درصد تغییرات قیمت در ۷ روز گذشته
                    '24h_volume' => $stats['24h_volume'],
                    '7d_volume' => $stats['7d_volume'],
                    '24h_quoteVolume' => $stats['24h_quoteVolume'], //مبلغ تراکنش‌ها در ۲۴ ساعت گذشته
                    '24h_highPrice' => $stats['24h_highPrice'],
                    '24h_lowPrice' => $stats['24h_lowPrice'],
                    'lastPrice' => $stats['lastPrice'], //آخرین قیمت تراکنش
                    'lastQty' => $stats['lastQty'], //آخرین حجم تراکنش
                    'lastTradeSide' => $stats['lastTradeSide'],
                    'bidVolume' => $stats['bidVolume'], //مجموع حجم سفارش‌های خرید
                    'askVolume' => $stats['askVolume'], //مجموع حجم سفارش‌های فروش
                    'bidCount' => $stats['bidCount'], //تعداد سفارش‌های خرید
                    'askCount' => $stats['askCount'], //تعداد سفارش‌های فروش
                    'BuyContPercent' => (intval($stats['bidCount'])  * 100) / (intval($stats['askCount'])  + intval($stats['bidCount'])),
                    'SELL' => $stats['direction']['SELL'], //درصد سفارش‌های خرید به کل سفارش‌ها
                    'BUY' => $stats['direction']['BUY'], //درصد سفارش‌های خرید به کل سفارش‌ها
                ];
                $Process = false;
                if ($MarketEnds != null) {
                    if ($this->endsWith($MarketSrcItem['symbol'], $MarketEnds)) {
                        $Process = true;
                    }
                } else {
                    $Process = true;
                }
                if ($Process) {
                    //array_push($Output,$Item);
                    $Output[$MarketSrcItem['symbol']] = $CoinData;
                }
            }
            return ($Output);
        } catch (Throwable $e) {
            return false;
        }
    }
    public function get_top_Percent($limit = null)
    {
        if ($limit != null) {
            $Curencys = Currency::orderBy('changeRateInt', 'DESC')->limit($limit)->get();
        } else {
            $Curencys = Currency::orderBy('changeRateInt', 'DESC')->get();
        }
        return $Curencys;
    }
    public function get_crypto_by_rsi()
    {
        $TargetUser = Auth::id();
        $join = " left join  coin_back_tests on  coin_back_tests.curency = currencies.MainName and coin_back_tests.owner = '$TargetUser' and coin_back_tests.status < 100";
        $CryptoSrc = DB::select('SELECT currencies.* , coin_back_tests.candate  FROM currencies ' . $join . ' WHERE enableTrading =1 and currencies.status = 10 and f4 > 50 and f4 < 70  and pic is not null and takerCoefficient = 1 and makerCoefficient = 1 ');
        return $CryptoSrc;
    }
    private function get_curency(array $type_arr)
    {
        $condition = 'where enableTrading = 1 ';
        foreach ($type_arr as $type) {
            if ($type == 'active') {
                $condition .=  ' and  status  = 10';
            }
            if ($type == 'with_pic') {
                $condition .= ' and pic is not null and pic != "" ';
            }

        }
        $Query = "SELECT * FROM  currencies $condition ";
        return DB::select($Query);
    }
    public function formola_v2_3_Update()
    {
        $curency_type = ['active','with_pic'];
        $MarketAnalyze = $this->get_curency($curency_type);
        $tf = new TradersFunctions;
        foreach ($MarketAnalyze as $MarketData) {
            $MarketIndex = $MarketData->id;
            $MainName = $MarketData->MainName;
            $RSI_indicator = $tf->RSI_indicator($MainName);
            $Result = $tf->SMA_indicator($MainName, [100, 50, 5]);
            if (is_array($Result)) {
                foreach ($Result as $ResultItem) {
                    if ($ResultItem['PeriodItem'] == 100) {
                        $f6 = $ResultItem['SMA'];
                    } elseif ($ResultItem['PeriodItem'] == 50) {
                        $f7 = $ResultItem['SMA'];
                    } elseif ($ResultItem['PeriodItem'] == 5) {
                        $f8 = $ResultItem['SMA'];
                    }
                }
            }

            $high = $MarketData->high;
            $low = $MarketData->low;
            $last = $MarketData->low;
            if ($MarketData->buy + $MarketData->sell != 0) {
                $BuyPercent = ($MarketData->buy * 100) / ($MarketData->buy + $MarketData->sell);
            } else {
                $BuyPercent = 0;
            }
            $BuyPercent = round($BuyPercent, 2);
            $PriceLocation = $MarketData->last - $MarketData->low;
            $PriceVariant =  $MarketData->high - $MarketData->low;
            if ($PriceVariant != 0) {
                $PriceLocationPercnet = round($PriceLocation * 100 / $PriceVariant);
            } else {
                $PriceLocationPercnet = 0;
            }
            if ($MarketData->low != 0) {
                $Telorance = ($MarketData->high - $MarketData->low) * 100 / $MarketData->low;
            } else {
                $Telorance = 0;
            }
            $MarketPercnet = $MarketData->changeRateInt;
            if ($PriceLocationPercnet >= 50) {
                $PriceLocationPercnet = 100 - (($PriceLocationPercnet - 50) * 2);
            } else {
                $PriceLocationPercnet = 100 - ((50 - $PriceLocationPercnet) * 2);
            }
            if ($Telorance < 3) { // The price tlorance not usefull
                $result = 0;
            } else {
                $result = round(($PriceLocationPercnet + $BuyPercent) / 2, 0);
            }
            if ($result > 10) {
                $Data = [
                    'Name' => $MarketData->MainName,
                    'FaName' => $MarketData->FaName,
                    'pic' => $MarketData->pic,
                    'PriceLocation' => $PriceLocationPercnet,
                    'MarketPercnet' => $MarketPercnet,
                    'result' => $result,
                ];
                $Indicators = [
                    'f1' => $result,
                    'f4' => $RSI_indicator,
                    'f6' => $f6,
                    'f7' => $f7,
                    'f8' => $f8
                ];
                Currency::where('id', $MarketIndex)->update($Indicators);
            }
        }
    }
    private function Growth($limit, $type)
    {
        $UserName = Auth::id();
        if ($type == 'spot') {
            $Query = "SELECT sum(crypto_price_1hs.Percent) as TPercent ,currencies.name , currencies.pic, currencies.MainName, currencies.changeRateInt ,currencies.id ,currencies.like ,currencies.dislike ,m.meta_value,m.tt,m.fgstr,m.id,m.fgint,m.meta_key,m.status FROM crypto_price_1hs INNER JOIN currencies on crypto_price_1hs.curency = currencies.symbol 
            left JOIN metadata as m on currencies.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  
            WHERE currencies.status = 10 and takerCoefficient = 1 
            GROUP by m.meta_value,m.tt,m.fgstr,m.id,m.fgint,m.meta_key,m.status,
            crypto_price_1hs.curency , 
            currencies.changeRateInt ,currencies.id ,currencies.like ,currencies.dislike, currencies.MainName,currencies.name,currencies.pic 
            ORDER BY TPercent DESC";
            if ($limit != null) {
                $Query .= " LIMIT $limit";
            }
        }
        if ($type == 'long') {
            $Query = "SELECT sum(crypto_price_1hs.Percent) as TPercent ,currencies.name , currencies.pic, currencies.MainName, currencies.changeRateInt ,currencies.id ,currencies.like ,currencies.dislike ,m.meta_value,m.tt,m.fgstr,m.id,m.fgint,m.meta_key,m.status FROM crypto_price_1hs INNER JOIN currencies on crypto_price_1hs.curency = currencies.symbol 
            left JOIN metadata as m on currencies.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  
            WHERE  currencies.future =1 and currencies.status = 10 and takerCoefficient = 1 
            GROUP by m.meta_value,m.tt,m.fgstr,m.id,m.fgint,m.meta_key,m.status,
            crypto_price_1hs.curency , currencies.changeRateInt ,currencies.id ,currencies.like ,currencies.dislike, currencies.MainName,currencies.name,currencies.pic ORDER BY TPercent DESC";
            if ($limit != null) {
                $Query .= " LIMIT $limit";
            }
        }
        if ($type == 'short') {
            $Query = "SELECT sum(crypto_price_1hs.Percent) as TPercent ,currencies.name , currencies.pic, currencies.MainName, currencies.changeRateInt ,currencies.id ,currencies.like ,currencies.dislike ,m.meta_value,m.tt,m.fgstr,m.id,m.fgint,m.meta_key,m.status FROM crypto_price_1hs INNER JOIN currencies on crypto_price_1hs.curency = currencies.symbol 
            left JOIN metadata as m on currencies.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  
            WHERE currencies.future =1 and currencies.status = 10 and takerCoefficient = 1 
            GROUP by m.meta_value,m.tt,m.fgstr,m.id,m.fgint,m.meta_key,m.status,
            crypto_price_1hs.curency , currencies.changeRateInt ,currencies.id ,currencies.like ,currencies.dislike, currencies.MainName,currencies.name,currencies.pic ORDER BY TPercent ASC";
            if ($limit != null) {
                $Query .= " LIMIT $limit";
            }
        }
        return DB::select($Query);
    }
    private function cutover($limit, $type)
    {
        $UserName = Auth::id();
        if ($type == 'spot') {
            if ($limit != null) {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.status =10 and  c.f2 > 0 and c.f3 < 0 and c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 DESC LIMIT $limit";
            } else {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.status =10 and c.f2 > 0 and c.f3 < 0 and c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 DESC ";
            }
        }
        if ($type == 'long') {
            if ($limit != null) {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.status =10 and  c.f2 > 0 and c.f3 < 0 and c.future = 1 and c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 DESC LIMIT $limit";
            } else {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.status =10 and c.f2 > 0 and c.f3 < 0 and c.future = 1 and c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 DESC ";
            }
        }
        if ($type == 'short') {
            if ($limit != null) {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.status =10 and c.f2 < 0 and c.f3 > 0 and c.future = 1 and c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 DESC LIMIT $limit";
            } else {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.status =10 and  c.f2 < 0 and c.f3 > 0 and c.future = 1 and c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 DESC";
            }
        }
        return DB::select($Query);
    }
    private function SupremumIndecator($limit, $type)
    {
        $UserName = Auth::id();
        if ($type == 'spot') {
            if ($limit != null) {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 DESC LIMIT $limit";
            } else {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 DESC";
            }
        }
        if ($type == 'long') {
            if ($limit != null) {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.future = 1 and c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 DESC LIMIT $limit";
            } else {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.future = 1 and c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 DESC";
            }
        }
        if ($type == 'short') {
            if ($limit != null) {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.future = 1 and c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 ASC LIMIT $limit";
            } else {
                $Query = "SELECT c.*, m.meta_key FROM currencies as c left JOIN metadata as m on c.id = m.fgint and m.tt = 'userlike' and  m.fgstr = '$UserName'  WHERE c.future = 1 and c.status = 10 and c.takerCoefficient = 1 ORDER BY c.f2 ASC ";
            }
        }

        return DB::select($Query);
    }

    /**
     * The function generates a system signal based on the Supremum Indicator and Growth values and caches
     * the result.
     * 
     * @return a boolean value of true.
     */
    public function MakeSignal_v3_1()
    {
        $SupremumIndecator = $this->SupremumIndecator(20, 'spot');
        $Growth = $this->Growth(20, 'spot');
        $ResultArr = [];
        foreach ($SupremumIndecator as $SupremumIndecatorItem) {
            foreach ($Growth as $GrowthItem) {
                if ($SupremumIndecatorItem->MainName == $GrowthItem->MainName) {
                    array_push($ResultArr, $SupremumIndecatorItem->MainName);
                }
            }
        }
        Cache::put('SystemSignal_v3_1', $ResultArr);
        return true;
    }
    public function SystemSignal_v3_1()
    {
        if (Cache::has('SystemSignal_v3_1')) {
            return Cache::get('SystemSignal_v3_1');
        } else {
            return false;
        }
    }
    public function formola_v3_1($limit = null, $Model, $type)
    { // Ma Formola
        if ($Model == 'cutover') {
            return $this->cutover($limit, $type);
        }
        if ($Model == 'sup') {
            return $this->SupremumIndecator($limit, $type);
        }
        if ($Model == 'Growth') {
            return $this->Growth($limit, $type);
        }
    }
    public function formola_v2_3($limit = null)
    {
        $OldRecords = Currency::where('status', 10)->where('updated_at', '<', Carbon::now()->subMinutes(5)->toDateTimeString())->count();

        if ($OldRecords > 200) {
            $this->formola_v2_3_Update();
        }
        if ($limit != null) {
            $Curencys = Currency::where('status', 10)->orderBy('f1', 'DESC')->limit($limit)->get();
        } else {
            $Curencys = Currency::where('status', 10)->orderBy('f1', 'DESC')->get();
        }

        return ($Curencys);
    }

    public function MarketAlyze($MarketName = null, $MarketEnds = null, $Formola = null)
    {
        return $this->formola_v2_3();
        $MarketAnalyze = Currency::all();
        $MarketVloume = 0;
        $F1 = array();
        foreach ($MarketAnalyze as $MarketData) {
            $MarketIndex = $MarketData->id;
            if ($MarketData->buy + $MarketData->sell != 0) {
                $BuyPercent = ($MarketData->buy * 100) / ($MarketData->buy + $MarketData->sell);
            } else {
                $BuyPercent = 0;
            }
            $BuyPercent = round($BuyPercent, 2);
            $PriceLocation = $MarketData->last - $MarketData->low;
            $PriceVariant =  $MarketData->high - $MarketData->low;
            $PriceLocationPercnet = round($PriceLocation * 100 / $PriceVariant);
            $Telorance = ($MarketData->high - $MarketData->low) * 100 / $MarketData->low;
            dd($BuyPercent, $PriceLocation, $PriceLocationPercnet, $Telorance);
            $F1[$MarketIndex] = $this->get_formol_1_result($MarketAnalyze[$MarketIndex]);
        }
        if ($Formola == null) {
            return ($F1);
        } else {
            arsort($F1);
            return ($F1);
        }
    }


    public function AutoBuy()
    {
        $MySMS = new SmsCenter();
        $UpdateUsers = array();
        $CoinsSrc = coins::where('TMNUpLimit', '!=', null)->where('CoinName', $this->TargetMarket)->get();
        foreach ($CoinsSrc as $CoinItem) {
            if ((int)$CoinItem->TMNUpLimit  < (int)$CoinItem->QTY) {
                $TMN =  (int)$CoinItem->QTY;
                $BestDirectionArr = $this->BestDirections($this->TargetMarket);
                foreach ($BestDirectionArr as $CoinName => $position) {
                    if ($position > 60) {
                        $UserName = $CoinItem->UserName;
                        $UserSrc = UserInfo::where('UserName', $UserName)->first();
                        $this->BuyCoinWithToman($CoinName, $TMN, $UserName);
                        $MySMS->OndemandSMS($CoinName . ' خریداری شد', $UserSrc->MobileNo, '', $UserSrc->MobileNo);
                        array_push($UpdateUsers, $UserName);
                        break;
                    }
                }
            }
        }
        foreach ($UpdateUsers as $TargetUser) {
            $this->RenewWalet($TargetUser);
        }
        return true;
    }
    public function SetNewPrice($UserName, $CoinName, $NewPrice)
    {
        $result =  Coins::where('UserName', $UserName)->where('CoinName', $CoinName)->update(['TMN' => $NewPrice]);

        return true;
    }
    public function SetNewLimit($UserName, $CoinName, $NewPrice)
    {
        $UplimitPercent = 3;
        $DownlimitPercent = 2;
        $newUPLimit = $NewPrice + ($NewPrice * $UplimitPercent / 100);
        $newDownLimit =  $NewPrice - ($NewPrice * $DownlimitPercent / 100);
        $newLimit = [
            'TMNUpLimit' => $newUPLimit,
            'TMNDownLimit' => $newDownLimit
        ];
        $result =  Coins::where('UserName', $UserName)->where('CoinName', $CoinName)->update($newLimit);

        return true;
    }
    private function update_coin_limits($CoinInfo, $NewPrice)
    {
        $MySMS = new SmsCenter();
        $TMNDownLimit = $CoinInfo->TMNDownLimit;
        $UserName = $CoinInfo->UserName;
        $TMNUpLimit = $CoinInfo->TMNUpLimit;
        $Coinid = $CoinInfo->id;
        $CoinName = $CoinInfo->CoinName;
        $UplimitPercent = 3;
        $DownlimitPercent = 2;
        if ($TMNUpLimit == null) {
            if ($TMNDownLimit != null) {
                $UserSrc = UserInfo::where('UserName', $UserName)->first();
                $newUPLimit = $NewPrice + ($NewPrice * $UplimitPercent / 100);
                $newLimit = [
                    'TMNUpLimit' => $newUPLimit,
                ];
                Coins::where('id', $Coinid)->update($newLimit);
            }
        } else {
            if ($TMNUpLimit < $NewPrice) {
                $UserSrc = UserInfo::where('UserName', $UserName)->first();
                $this->SetNewLimit($UserName, $CoinName, $NewPrice);
                $MySMS->OndemandSMS($CoinName . ' حد بالا را رد کرد ', $UserSrc->MobileNo, '', $UserSrc->MobileNo);
            }
        }
    }

    public function CheckLimits()
    {
        $CoinsSrc = coins::where('TMNDownLimit', '!=', null)->get();
        $MySMS = new SmsCenter();
        $UpdateUsers = array();
        foreach ($CoinsSrc as $Coin) {
            $UserName = $Coin->UserName;
            $CoinName = $Coin->CoinName;
            $TMNDownLimit = $Coin->TMNDownLimit;
            $TMNUpLimit = $Coin->TMNUpLimit;
            $TMN = $Coin->TMN;
            $CoinInfo = $this->GetMarketInfo($CoinName);
            if ($CoinInfo == false) {
                continue;
            }
            $NowTMN = $CoinInfo['stats']['lastPrice'];
            if ($TMNDownLimit > $NowTMN) {
                $UserSrc = UserInfo::where('UserName', $UserName)->first();
                $this->TokenSetter($UserSrc->remember_token, $UserName);
                $this->SaleCoin($CoinName, 100);
                $newLimit = [
                    'TMNDownLimit' => null
                ];
                Coins::where('id', $Coin->id)->update($newLimit);
                if (!in_array($UserName, $UpdateUsers)) {
                    array_push($UpdateUsers, $UserName);
                }
                $MySMS->OndemandSMS($CoinName . 'فروخته شد ', $UserSrc->MobileNo, '', $UserSrc->MobileNo);
            } else {
                $this->update_coin_limits($Coin, $NowTMN);
            }
        }
        foreach ($UpdateUsers as $TargetUser) {
            $this->RenewWalet($TargetUser);
        }

        //$this->AutoBuy();

        return 'evry thing is ok!';
    }

    /**
     * This function calcute all markets direction of buy
     *
     * @return Array
     */
    public function BestDirectionsAgregation()
    {
        $MarketSrc = $this->markets();
        $this->MarketSrc = $MarketSrc;
        $Output = array();
        $ArrCount = array();
        foreach ($MarketSrc as $Market) {
            $symbol = $Market['baseAsset'];
            $Process = false;

            if (isset($Output[$symbol])) {
                $Output[$symbol] += $Market['stats']['direction']['BUY'];
                $ArrCount[$symbol]++;
            } else {
                $Output[$symbol] = $Market['stats']['direction']['BUY'];
                $ArrCount[$symbol] = 1;
            }
        }
        foreach ($Output as  $OutputIndex => $OutputValue) {
            $Output[$OutputIndex] =  round($OutputValue / $ArrCount[$OutputIndex], 0);
        }
        arsort($Output);
        return $Output;
    }
    public function BestDirections(string $MarketEnds = null)
    {
        $MarketSrc = $this->markets();
        $this->MarketSrc = $MarketSrc;
        $Output = array();
        foreach ($MarketSrc as $Market) {
            $symbol = $Market['symbol'];
            $Process = false;
            if ($MarketEnds != null) {
                if ($this->endsWith($symbol, $MarketEnds)) {
                    $Process = true;
                }
            } else {
                $Process = true;
            }
            if ($Process) {
                //array_push($Output,$Item);
                $Output[$symbol] = $Market['stats']['direction']['BUY'];
            }
        }
        arsort($Output);
        return $Output;
    }
    public function UserProfile()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wallex.ir/v1/account/profile',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'

        ));
        $headers = [
            'x-api-key:' . $this->Token
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        try {
            if ($response['success'] == true) {
                $response = $response['result'];
                return ($response);
            } else {
                return false;
            }
        } catch (\Exception) {
            return false;
        }
        return ($response);
    }
    public function FastTransaction($symbol, $side, $amount)
    {
        $symbol .= $this->TargetMarket;
        $curl = curl_init();
        $Confirmarray = array(
            "symbol" => $symbol,
            "side" => $side,
            "amount" => $amount
        );
        $CURLOPT_POSTFIELDS = json_encode($Confirmarray);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wallex.ir/v1/account/otc/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'x-api-key:' . $this->Token,
                'Content-Type: application/json'
            ),
            CURLOPT_CUSTOMREQUEST => 'POST'
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        return $response;
    }
    public function delete_orders($OrderID)
    {
        $curl = curl_init();
        $CURLOPT_POSTFIELDS = json_encode([]);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wallex.ir/v1/account/orders?clientOrderId=' . $OrderID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'x-api-key:' . $this->Token,
                'Content-Type: application/json'
            ),

            CURLOPT_CUSTOMREQUEST => 'DELETE'
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function Orders($symbol, $side, $price, $quantity)
    {
        if (strpos($symbol, $this->TargetMarket) !== false) {
        } else {
            $symbol .= $this->TargetMarket;
        }
        $curl = curl_init();
        $Confirmarray = array(
            "symbol" => $symbol,
            "type" => "LIMIT",
            "side" => $side,
            "price" => $price,
            "quantity" => $quantity
        );
        $CURLOPT_POSTFIELDS = json_encode($Confirmarray);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wallex.ir/v1/account/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'x-api-key:' . $this->Token,
                "symbol: $symbol",
                "type: LIMIT",
                "side: $side",
                "price: $price",
                "quantity: $quantity",
                'Content-Type: application/json'
            ),
            CURLOPT_CUSTOMREQUEST => 'POST'
        ));
        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);
        return $response;
    }
    public function Buy($symbol, $side, $price, $quantity)
    {
        if (strpos($symbol, $this->TargetMarket) !== false) {
        } else {
            $symbol .= $this->TargetMarket;
        }

        $curl = curl_init();
        $Confirmarray = array(
            "symbol" => $symbol,
            "type" => "MARKET",
            "side" => $side,
            "price" => $price,
            "quantity" => $quantity
        );
        $CURLOPT_POSTFIELDS = json_encode($Confirmarray);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wallex.ir/v1/account/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'x-api-key:' . $this->Token,
                "symbol: $symbol",
                "type: LIMIT",
                "side: $side",
                "price: $price",
                "quantity: $quantity",
                'Content-Type: application/json'
            ),
            CURLOPT_CUSTOMREQUEST => 'POST'
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        return $response;
    }
    public function Userbalances($UserName)
    {
        $kuCoin = new kucoin($UserName);
        return $kuCoin->get_my_walet();

        //for walex 
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wallex.ir/v1/account/balances',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'

        ));
        $headers = [
            'x-api-key:' . $this->Token
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        return ($response);
    }
    public function BuyCoinWithToman($Coin, $Toman, $UserName)
    {
        $MarketInfo = $this->GetMarketInfo($Coin);
        $ConStat = $MarketInfo['stats'];
        $TargetPrice = $ConStat['lastPrice'];
        echo "target price = $TargetPrice <br> ";
        $Tobuy = $Toman / $TargetPrice;
        $TargetQty = round($Tobuy, $MarketInfo['stepSize']);
        // $TargetQty = floor($Toman / $TargetPrice) ;
        $result =  $this->Buy($Coin, 'BUY', $TargetPrice, $TargetQty);
        $Output = array();
        $Output['BuyPrice'] = $TargetPrice;
        return ($Output);
    }
    private function get_price_stepper($Price, $stepSize)
    {
        $RoundNum = pow(10, $stepSize);
        $TargetQty = floor($Price * $RoundNum) / $RoundNum;
        return $TargetQty;
    }
    public function SaleCoin($Coin, $Percent)
    {
        $myvalet = $this->get_my_Walet_coin($Coin);
        $MarketInfo = $this->GetMarketInfo($Coin);
        $ConStat = $MarketInfo['stats'];
        $stepSize = $MarketInfo['stepSize'];
        $TargetPrice = $ConStat['lastPrice'];
        if ($Percent == 100) {
            $TargetQty = $myvalet;
        } else {
            $TargetQty = $myvalet  * $Percent / 100;
        }

        $TargetQty = $this->get_price_stepper($TargetQty, $stepSize);
        $result =  $this->Buy($Coin, 'SELL', $TargetPrice, $TargetQty);
        return $result;
    }
    public function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }
    public function get_my_Walet_coin($Coin = null)
    {
        $response = $this->Userbalances(Auth::id());
        return $response;
        $Output = array();
        try {
            if ($response['success'] == true) {
                $response = $response['result']['balances'];
                if ($Coin == null) {
                    foreach ($response as $responseItem) {
                        if ($responseItem['value'] > 0) {
                            $Output[$responseItem['asset']] = $responseItem['value'];
                        }
                    }
                    return $Output;
                } else {
                    return ($response[$Coin]['value']);
                }
            } else {
                return false;
            }
        } catch (\Exception) {
            return false;
        }
    }

    public function UserInfo()
    {
        return view('UserInfo');
    }
    public function getUSDTExcangeRate()
    {
        $MarketName = 'USDTTMN';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wallex.ir/v1/markets',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ));
        $headers = [
            'x-api-key:' . $this->Token
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        try {
            $response = json_decode($response, true);
            $response = $response['result']['symbols'];

            $this->MarketInfo = $response;
            $response = $response[$MarketName];
            $response = $response['stats'];
            $response = $response['lastPrice'];
            $response = number_format($response, 0, '', '');

            return ($response);
        } catch (Throwable $e) {
            return false;
        }
    }
    public function GetLastMaIndicator()
    {
        $MaSrc = metadata::where('tt', 'LastMaIndecator')->first();
        $Result = [
            'date' => $MaSrc->meta_key,
            'time' => $MaSrc->meta_value
        ];
        return $Result;
    }
    public function MAIndecator($MinLen = 5, $MaxLen = 10, $Source = 'ClosePrice')
    {
        $Query = "SELECT * FROM crypto_price_1hs ORDER BY crypto_price_1hs.curency ASC , created_at DESC";
        $Candeles = DB::select($Query);
        $Curency = null;
        foreach ($Candeles as $candeleItem) {
            if ($candeleItem->curency == $Curency) {
                $Conter++;
                if ($MinLen >= $Conter) {
                    $MinSum += $candeleItem->$Source;
                }
                if ($MaxLen >= $Conter) {
                    $MaxSum += $candeleItem->$Source;
                }
            } else { // new curency
                if ($Curency != null) {  // The curency is not first one
                    $MaxAv = $MaxSum / $MaxLen;
                    $MinAv = $MinSum / $MinLen;
                    $ResultAv = $MinAv - $MaxAv;
                    $SrcData = "MinSum = $MinSum <br>";
                    $SrcData .= "MinAv = $MinAv <br>";
                    $SrcData .= "MaxSum = $MaxSum <br>";
                    $SrcData .= "MaxAv = $MaxAv <br>";
                    $Percnet = $ResultAv * 100 / $MinAv;
                    $Percnet = round($Percnet, 2);
                    $SrcData .= "ResultAv = $ResultAv <br>";
                    $SrcData .= "Percent = $Percnet <br>";
                    //Currency::where('symbol', $Curency)->update(['f2' => $Percnet]);
                    $Query = "UPDATE currencies set f3 = f2 , f2 = $Percnet where symbol = '$Curency' ";
                    DB::update($Query);
                }

                $Curency = $candeleItem->curency;
                $Conter = 1;
                $MaxSum = $candeleItem->$Source;
                $MinSum = $candeleItem->$Source;
            }
        }
        $Persian = new persian;
        $PersianDate = $Persian->TodayPersian();
        $TargetTime = date("H:i");
        metadata::updateOrCreate(['tt' => 'LastMaIndecator'], ['meta_key' => $PersianDate, 'meta_value' => $TargetTime]);
        $Backtest = new backtest();
        $this->MakeSignal_v3_1();
        $Backtest->AddNewBackTestItems();
        return true;
    }
    private function IsdayHasPrice($CurrentDate, $tt)
    {
        $Result = metadata::where('tt', $tt)->where('fgstr', $CurrentDate)->first();
        if ($Result == null) {
            return false;
        } else {
            return $Result->id;
        }
    }
    private function GetLastID($tt)
    {
        $Result = metadata::where('tt', $tt)->max('fgint');
        if ($Result == null) {
            return  29; //Initiate value
        }
        return $Result;
    }
    private function MarketIndecatoer($CurrentDate)
    {
        $tt = 'MI'; // market Indecator
        $OldRecord = $this->IsdayHasPrice($CurrentDate, $tt);
        $PercentIndecator = Currency::sum('changeRate');
        if ($OldRecord == false) { // no record exist add new record
            $fgint = $this->GetLastID($tt);
            $fgint++;
            $fgstr = $CurrentDate;
            $USDTDAta = [
                'tt' => $tt,
                'fgint' => $fgint,
                'fgstr' => $fgstr,
                'meta_value' => $PercentIndecator
            ];
            metadata::create($USDTDAta);
            return true;
        } else { // update existing record
            $USDTDAta = [
                'meta_value' => $PercentIndecator
            ];
            metadata::where('id', $OldRecord)->update($USDTDAta);
            return true;
        }
    }
    public function UpdateMetaCurencys()
    {
        $Persian = new persian;
        $CurrentDate = $Persian->TodayPersian();
        $this->MarketIndecatoer($CurrentDate);
        $tt = 'USDT-TMN';
        $OldRecord = $this->IsdayHasPrice($CurrentDate, $tt);
        $USDT_TMN = $this->getUSDTExcangeRate();
        if ($USDT_TMN == 0) { // can not get price
            return false;
        }
        if ($OldRecord == false) { // no record exist add new record
            $fgint = $this->GetLastID($tt);
            $fgint++;
            $fgstr = $CurrentDate;
            $USDTDAta = [
                'tt' => $tt,
                'fgint' => $fgint,
                'fgstr' => $fgstr,
                'meta_value' => $USDT_TMN
            ];
            metadata::create($USDTDAta);
            return true;
        } else { // update existing record
            $USDTDAta = [
                'meta_value' => $USDT_TMN
            ];
            metadata::where('id', $OldRecord)->update($USDTDAta);
            return true;
        }
    }

    public function GetMarketInfo($MarketName)
    {
        if (!str_contains($MarketName, $this->TargetMarket)) {
            $MarketName .= $this->TargetMarket;
        }
        if ($this->MarketInfo != null) { // to avoid multi featch from server
            return  $this->MarketInfo[$MarketName];
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.wallex.ir/v1/markets',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'

        ));
        $headers = [
            'x-api-key:' . $this->Token
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        try {
            $response = json_decode($response, true);
            $response = $response['result']['symbols'];

            $this->MarketInfo = $response;
            $response = $response[$MarketName];
            return ($response);
        } catch (Throwable $e) {
            return false;
        }
    }
    public function UserRenewWalet($UserName, $UserInfo = null)
    {
        coins::where('UserName', $UserName)->update(['QTY' => 0]);
        if ($UserInfo ==  null) {
            $UserInfo = UserInfo::where('UserName', $UserName)->first();
        }
        $kuCoin = new kucoin($UserName);
        $Userbalances = $this->get_my_Walet_coin();
        if (!$Userbalances) {
            return false;
        }
        foreach ($Userbalances as $UserbalancesItem) {
            if ($UserbalancesItem['type'] == 'trade') {
                $CoinName = $UserbalancesItem['currency'];
                $Qty = $UserbalancesItem['balance'];
                $OldSrc = coins::where('UserName', $UserName)->where('CoinName', $CoinName)->first();
                if ($OldSrc == null) {
                    if ($CoinName != $this->TargetMarket) {
                        $TMN = 1;
                    } else {
                        $TMN = 1;
                    }
                    $CoinEXData =  $kuCoin->get_symbols($CoinName . '-USDT');
                    $CoinEXData = json_encode($CoinEXData);
                    $CoinData = [
                        'UserName' => $UserName,
                        'CoinName' => $CoinName,
                        'QTY' => $Qty,
                        'TMN' => $TMN,
                        'ExtraInfo' => $CoinEXData
                    ];
                    coins::create($CoinData);
                } else {
                    if ($OldSrc->ExtraInfo == null) {
                        $CoinEXData =  $kuCoin->get_symbols($CoinName . '-USDT');
                        $CoinEXData = json_encode($CoinEXData);
                        $CoinData = [
                            'QTY' => $Qty,
                            'ExtraInfo' => $CoinEXData
                        ];
                        coins::where('id', $OldSrc->id)->update($CoinData);
                    } else {
                        coins::where('id', $OldSrc->id)->update(['QTY' => $Qty]);
                    }
                }
            }
        }
        return true;
    }

    public function RenewWalet($UserName = null)
    {
        if ($UserName == null) { //update all users walet
            $Query = "SELECT UserName FROM coins GROUP BY UserName";
            $UserSrc =  DB::select($Query);
            foreach ($UserSrc as $UserItem) {
                $this->UserRenewWalet($UserItem->UserName);
            }
        } else {
            return $this->UserRenewWalet($UserName);
        }
    }
}
