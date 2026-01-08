<?php

namespace App\Http\Controllers\Crypto;

use App\Crypto\CryptoFunctions;
use App\Functions\DateTimeClass;
use App\Models\Candeles;
use App\Models\crypto_price_15ms;
use App\Models\crypto_price_1hs;
use App\Models\crypto_price_1m;
use App\Models\crypto_price_30ms;
use App\Models\crypto_price_5ms;
use App\Models\Currency;
use App\Models\metadata;
use App\Models\UserInfo;
use Carbon\Carbon;

class kucoin
{
    public $host = 'https://api.kucoin.com'; //production
    public $futurehost = 'https://api-futures.kucoin.com'; //production
    public $key;
    public $secret;
    public $passphrase;
    public $UserName;
    public $symbols = null;

    public function __construct($UserName = null)
    {
        if ($UserName == null) {
            $this->key = '63d558a2f651540001e316d0';
            $this->secret = '6ad7a10d-6c40-4e14-9470-6790162dbbab';
            $this->passphrase = 'Ava13940916';
            $this->UserName = $UserName;
        } else {
            return $this->SetSecrets($UserName);
        }
    }
    public function UsersHasWalet()
    {
        $userlist = [];
        $Users =  UserInfo::whereNotNull('extradata')->get();
        foreach ($Users  as $UserItem) {
            $extradata = $UserItem->extradata;
            $extradata = json_decode($extradata);
            if (isset($extradata->KC_key)) {
                array_push($userlist, $UserItem);
            }
        }
        return $userlist;
    }
    public function CheckUserHasWalet($UserName)
    {
        $UserAccounts = [];
        $UserItem = UserInfo::where('UserName', $UserName)->first();
        if ($UserItem == null) {
            return [];
        }
        $extradata = $UserItem->extradata;
        $extradata = json_decode($extradata);
        if (isset($extradata->KC_key)) {
            array_push($UserAccounts, 'Kocoin');
        }
        return $UserAccounts;
    }
    public function SetSecrets($UserName)
    {
        if ($UserName == $this->UserName) {
            return true;
        } else {
            $UserInfo = UserInfo::where('UserName', $UserName)->first();
            if ($UserInfo == null) {
                return false;
            }
            $extradata = json_decode($UserInfo->extradata, true);

            $this->key = $extradata['KC_key'] ?? null;
            $this->secret = $extradata['KC_secret'] ?? null;
            $this->passphrase = $extradata['KC_passphrase'] ?? null;
            $this->UserName = $UserName;
            if ($this->key == null) {
                return false;
            }
            return true;
        }
        return false;
    }
    public function testGetDepositAddress()
    {
        $host = $this->host;
        $key = $this->key;
        $passphrase = $this->passphrase;

        $endpoint = '/api/v1/deposit-addresses?currency=BTC';
        $body = '';
        $timestamp = intval(microtime(true) * 1000);

        $headers = [];
        $headers[] = "Content-Type:application/json";
        $headers[] = "KC-API-KEY:" . $key;
        $headers[] = "KC-API-TIMESTAMP:" . $timestamp;
        $headers[] = "KC-API-PASSPHRASE:" . $passphrase;
        $headers[] = "KC-API-SIGN:" . $this->signature($endpoint, $body, $timestamp, 'GET');

        $requestPath = $host . $endpoint;

        $response = $this->http_request('GET', $requestPath, $headers, $body);

        var_dump($response);
    }
    public function save_candels($Currency, $CurencyID, $Period)
    {
        $CandeleSrc = $this->get_candel($Currency, $Period);
        foreach ($CandeleSrc as $CandelItem) {
            $Date = date('Y-m-d', $CandelItem[0]);
            $OpenPrice = $CandelItem[1];
            $ClosePrice = $CandelItem[2];
            $HighPrice = $CandelItem[3];
            $LowPrice = $CandelItem[4];
            $TransVol = $CandelItem[5];
            $TransAmo = $CandelItem[6];
            $Percent = ($ClosePrice - $OpenPrice) * 100 / $OpenPrice;
            $Percent = round($Percent, 2);
            $Avreage = ($HighPrice + $LowPrice) / 2;
            $CandeleData = [
                'candate' => $Date,
                'curency' => $CurencyID,
                'OpenPrice' => $OpenPrice,
                'ClosePrice' => $ClosePrice,
                'HighPrice' => $HighPrice,
                'LowPrice' => $LowPrice,
                'TransVol' => $TransVol,
                'TransAmo' => $TransAmo,
                'Percent' => $Percent,
                'Avreage' => $Avreage
            ];
            Candeles::create($CandeleData);
        }
        return true;
    }
    private function Candle1HWorks($MainDate, $Hour, $MarketItem)
    {
        $CandleSrc = crypto_price_1hs::where('candate', $MainDate)->where('canh', $Hour)->where('curency', $MarketItem['symbol'])->first();
        if ($CandleSrc == null) { // no field find and should add new feild
            $CandleData = [
                'candate' => $MainDate,
                'canh' => $Hour,
                'curency' => $MarketItem['symbol'],
                'OpenPrice' => $MarketItem['last'],
                'ClosePrice' => $MarketItem['last'],
                'HighPrice' => $MarketItem['last'],
                'Percent' => 0,
                'LowPrice' => $MarketItem['last']
            ];
            crypto_price_1hs::create($CandleData);
        } else { // the feild exsit and should to update
            $changeFlag = false;
            $HighPrice = $CandleSrc->HighPrice;
            $LowPrice = $CandleSrc->LowPrice;
            $OpenPrice = $CandleSrc->OpenPrice;

            if ($MarketItem['last'] > $HighPrice) {
                $HighPrice = $MarketItem['last'];
                $changeFlag = true;
            }
            if ($MarketItem['last'] < $LowPrice) {
                $LowPrice = $MarketItem['last'];
                $changeFlag = true;
            }
            if ($changeFlag) {
                $Percent = ($MarketItem['last'] - $OpenPrice) * 100 / $OpenPrice;
                $CandleData = [
                    'ClosePrice' => $MarketItem['last'],
                    'HighPrice' => $HighPrice,
                    'Percent' => $Percent,
                    'LowPrice' => $LowPrice
                ];
                crypto_price_1hs::where('candate', $MainDate)->where('canh', $Hour)->where('curency', $MarketItem['symbol'])->update($CandleData);
            }
        }
    }
    private function Candle5MWorks($Id5Min, $MarketItem, $candate)
    {
        if ($Id5Min == null) {
            $AddNew = true;
        } else {
            $Source5Mins = crypto_price_5ms::where('candate', $Id5Min)->where('curency', $MarketItem['symbol'])->first();
            if ($Source5Mins == null) {
                $AddNew = true;
            } else {
                $AddNew = false;
            }
        }

        if ($AddNew) { // no field find and should add new feild
            $CandleData = [
                'candate' => $candate,
                'curency' => $MarketItem['symbol'],
                'OpenPrice' => $MarketItem['last'],
                'ClosePrice' => $MarketItem['last'],
                'HighPrice' => $MarketItem['last'],
                'Percent' => 0,
                'LowPrice' => $MarketItem['last']
            ];
            crypto_price_5ms::create($CandleData);
        } else { // the feild exsit and should to update
            $changeFlag = false;
            $HighPrice = $Source5Mins->HighPrice;
            $LowPrice = $Source5Mins->LowPrice;
            $OpenPrice = $Source5Mins->OpenPrice;
            if ($MarketItem['last'] > $HighPrice) {
                $HighPrice = $MarketItem['last'];
                $changeFlag = true;
            }
            if ($MarketItem['last'] < $LowPrice) {
                $LowPrice = $MarketItem['last'];
                $changeFlag = true;
            }
            if ($changeFlag) {
                $Percent = ($MarketItem['last'] - $OpenPrice) * 100 / $OpenPrice;
                $CandleData = [
                    'ClosePrice' => $MarketItem['last'],
                    'HighPrice' => $HighPrice,
                    'Percent' => $Percent,
                    'LowPrice' => $LowPrice
                ];
                crypto_price_5ms::where('candate', $Id5Min)->where('curency', $MarketItem['symbol'])->update($CandleData);
            }
        }
    }
    private function Candle15MWorks($Id15Min, $MarketItem, $candate)
    {
        if ($Id15Min == null) {
            $AddNew = true;
        } else {
            $Source15Mins = crypto_price_15ms::where('candate', $Id15Min)->where('curency', $MarketItem['symbol'])->first();
            if ($Source15Mins == null) {
                $AddNew = true;
            } else {
                $AddNew = false;
            }
        }

        if ($AddNew) { // no field find and should add new feild
            $CandleData = [
                'candate' => $candate,
                'curency' => $MarketItem['symbol'],
                'OpenPrice' => $MarketItem['last'],
                'ClosePrice' => $MarketItem['last'],
                'HighPrice' => $MarketItem['last'],
                'Percent' => 0,
                'LowPrice' => $MarketItem['last']
            ];
            crypto_price_15ms::create($CandleData);
        } else { // the feild exsit and should to update
            $changeFlag = false;
            $HighPrice = $Source15Mins->HighPrice;
            $LowPrice = $Source15Mins->LowPrice;
            $OpenPrice = $Source15Mins->OpenPrice;

            if ($MarketItem['last'] > $HighPrice) {
                $HighPrice = $MarketItem['last'];
                $changeFlag = true;
            }
            if ($MarketItem['last'] < $LowPrice) {
                $LowPrice = $MarketItem['last'];
                $changeFlag = true;
            }
            if ($changeFlag) {
                $Percent = ($MarketItem['last'] - $OpenPrice) * 100 / $OpenPrice;
                $CandleData = [
                    'ClosePrice' => $MarketItem['last'],
                    'HighPrice' => $HighPrice,
                    'Percent' => $Percent,
                    'LowPrice' => $LowPrice
                ];
                crypto_price_15ms::where('candate', $Id15Min)->where('curency', $MarketItem['symbol'])->update($CandleData);
            }
        }
    }
    private function Candle30MWorks($Id30Min, $MarketItem, $candate)
    {

        if ($Id30Min == null) {
            $AddNew = true;
        } else {
            $Source30Mins = crypto_price_30ms::where('candate', $Id30Min)->where('curency', $MarketItem['symbol'])->first();
            if ($Source30Mins == null) {
                $AddNew = true;
            } else {
                $AddNew = false;
            }
        }

        if ($AddNew) { // no field find and should add new feild
            $CandleData = [
                'candate' => $candate,
                'curency' => $MarketItem['symbol'],
                'OpenPrice' => $MarketItem['last'],
                'ClosePrice' => $MarketItem['last'],
                'HighPrice' => $MarketItem['last'],
                'Percent' => 0,
                'LowPrice' => $MarketItem['last']
            ];
            crypto_price_30ms::create($CandleData);
            // info('add new :' . $MarketItem['symbol'] . ' '.$candate );
        } else { // the feild exsit and should to update
            $changeFlag = false;
            $HighPrice = $Source30Mins->HighPrice;
            $LowPrice = $Source30Mins->LowPrice;
            $OpenPrice = $Source30Mins->OpenPrice;

            if ($MarketItem['last'] > $HighPrice) {
                $HighPrice = $MarketItem['last'];
                $changeFlag = true;
            }
            if ($MarketItem['last'] < $LowPrice) {
                $LowPrice = $MarketItem['last'];
                $changeFlag = true;
            }
            if ($changeFlag) {
                $Percent = ($MarketItem['last'] - $OpenPrice) * 100 / $OpenPrice;
                $CandleData = [
                    'ClosePrice' => $MarketItem['last'],
                    'HighPrice' => $HighPrice,
                    'Percent' => $Percent,
                    'LowPrice' => $LowPrice
                ];
                crypto_price_30ms::where('candate', $Id30Min)->where('curency', $MarketItem['symbol'])->update($CandleData);
            }
        }
    }
    public function UpdateCandels($Market, $TargetTime)
    {
        $Time = substr($TargetTime, 0, 10);
        $MainDate = date("Y-m-d",  $Time);
        $Rtime = date("H",  $Time);
        $Hour = intval($Rtime);
        $Mydate = new DateTimeClass;
        $candate = $Mydate->get_now_int();
        $Max5Min = $Mydate->get_now_defrence(-5);
        $Max15Min = $Mydate->get_now_defrence(-15);
        $Max30Min = $Mydate->get_now_defrence(-30);
        $Source5Mins = crypto_price_5ms::where('candate', '>', $Max5Min)->where('curency', 'SHIB-USDT')->first(); // last id from famus coin 
        $Source15Mins = crypto_price_15ms::where('candate', '>', $Max15Min)->where('curency', 'SHIB-USDT')->first(); // last id from famus coin 
        $Source30Mins = crypto_price_30ms::where('candate', '>', $Max30Min)->where('curency', 'SHIB-USDT')->first(); // last id from famus coin 
        $Source5Mins == null  ? $Id5Min = null : $Id5Min = $Source5Mins->candate;
        $Source15Mins == null  ? $Id15Min = null : $Id15Min = $Source15Mins->candate;
        $Source30Mins == null  ? $Id30Min = null : $Id30Min = $Source30Mins->candate;
        // info('candleer =>'." Source30Mins -> $Id30Min , Source15Mins -> $Id15Min , Source5Mins ->$Id5Min");

        foreach ($Market as $MarketItem) {
            if (str_contains($MarketItem['symbol'], '-USDT') && $MarketItem['last'] != null) {
                $this->Candle1HWorks($MainDate, $Hour, $MarketItem);
                $this->Candle5MWorks($Id5Min, $MarketItem, $candate);
                $this->Candle15MWorks($Id15Min, $MarketItem, $candate);
                $this->Candle30MWorks($Id30Min, $MarketItem, $candate);
            }
        }
    }
    public function save_tickers()
    {
        $this->Update_symbols();
        $Market = $this->get_all_tickers();
        $TargetTime = $Market['time'];
        $Market = $Market['ticker'];
        $date  = Carbon::now()->subMinutes(100);
        crypto_price_1m::where('updated_at', '<=', $date)->delete();
        foreach ($Market as $MarketItem) {
            if (str_contains($MarketItem['symbol'], '-USDT')) {
                $Tiker = [
                    "buy" =>  $MarketItem['buy'],
                    "sell" => $MarketItem['sell'],
                    "changeRate" => $MarketItem['changeRate'],
                    "changeRateInt" => $MarketItem['changeRate'] * 100,
                    "changePrice" => $MarketItem['changePrice'],
                    "high" => $MarketItem['high'],
                    "low" => $MarketItem['low'],
                    "vol" =>    $MarketItem['vol'],
                    "volValue" =>     $MarketItem['volValue'],
                    "last" =>   $MarketItem['last'],
                    "averagePrice" =>   $MarketItem['averagePrice'],
                    "takerFeeRate" =>   $MarketItem['takerFeeRate'],
                    "makerFeeRate" =>   $MarketItem['makerFeeRate'],
                    "takerCoefficient" =>   $MarketItem['takerCoefficient'],
                    "makerCoefficient" =>   $MarketItem['makerCoefficient'],
                ];
                $UpdateResult = Currency::where('symbol', $MarketItem['symbol'])->update($Tiker);
                $PriceData = [
                    'timestamp' => $TargetTime,
                    'curency' => $MarketItem['symbol'],
                    'price' => $MarketItem['last']
                ];
                if ($MarketItem['last'] != null) {
                    crypto_price_1m::create($PriceData);
                }
            }
        }
        metadata::updateOrCreate(
            ['tt' => 'kucoin', 'meta_key' => 'Stimestamp'],
            ['meta_value' => $TargetTime]
        );

        $this->UpdateCandels($Market, $TargetTime);
        $CryptoFunction = new CryptoFunctions;
        $CryptoFunction->formola_v2_3_Update();
        return true;
    }
    public function get_contacts()
    {
        $endpoint = '/api/v1/contracts/active';
        $result = $this->BaseFutureConnect($endpoint);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    public function get_ticker($symbol)
    {
        $endpoint = '/api/v1/market/orderbook/level1?symbol=' . $symbol;
        $result = $this->BaseConnect($endpoint);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    /**
     * Add new symbol to database if not exist
     */
    public function Update_symbols()
    {
        $Symbols = $this->get_symbols();
        foreach ($Symbols as $SymbolItem) {
            $SymbolName = $SymbolItem['symbol'];
            if (str_contains($SymbolName, '-USDT')) {
                $MainName = str_replace("-USDT", "", $SymbolItem['symbol']);;
                $symbol = $SymbolItem['symbol'];
                $name = $SymbolItem['name'];
                $baseCurrency = $SymbolItem['baseCurrency'];
                $quoteCurrency = $SymbolItem['quoteCurrency'];
                $feeCurrency = $SymbolItem['feeCurrency'];
                $market = $SymbolItem['market'];
                $baseMinSize = $SymbolItem['baseMinSize'];
                $quoteMinSize = $SymbolItem['quoteMinSize'];
                $baseMaxSize = $SymbolItem['baseMaxSize'];
                $quoteMaxSize = $SymbolItem['quoteMaxSize'];
                $baseIncrement = $SymbolItem['baseIncrement'];
                $quoteIncrement = $SymbolItem['quoteIncrement'];
                $priceIncrement = $SymbolItem['priceIncrement'];
                $priceLimitRate = $SymbolItem['priceLimitRate'];
                $minFunds = $SymbolItem['minFunds'];
                $isMarginEnabled = $SymbolItem['isMarginEnabled'];
                $enableTrading = $SymbolItem['enableTrading'];
                $CurrencySrc = Currency::where('symbol', $symbol)->first();
                if ($CurrencySrc == null) { // The currency not exist yet
                    $CurrencyInfo = [
                        'MainName' => $MainName,
                        "symbol" => $symbol,
                        "name" => $name,
                        "baseCurrency" => $baseCurrency,
                        "quoteCurrency" => $quoteCurrency,
                        "feeCurrency" => $feeCurrency,
                        "market" => $market,
                        "baseMinSize" => $baseMinSize,
                        "quoteMinSize" => $quoteMinSize,
                        "baseMaxSize" => $baseMaxSize,
                        "quoteMaxSize" => $quoteMaxSize,
                        "baseIncrement" => $baseIncrement,
                        "quoteIncrement" => $quoteIncrement,
                        "priceIncrement" => $priceIncrement,
                        "priceLimitRate" => $priceLimitRate,
                        "minFunds" => $minFunds,
                        "isMarginEnabled" => $isMarginEnabled,
                        "enableTrading" => $enableTrading
                    ];
                    Currency::create($CurrencyInfo);
                }
            }
        }
    }
    public function get_symbols($symbol = null)
    {
        $endpoint = '/api/v1/symbols';
        if ($symbol == null) {
            if ($this->symbols == null) {
                $result = $this->BaseConnect($endpoint);
                if ($result['code'] == 200000) {
                    $SimbolData = $result['data'];
                    return $SimbolData;
                } else {
                    return false;
                }
            }
            return $this->symbols;
        } else {
            if ($this->symbols == null) {
                $this->symbols = $this->BaseConnect($endpoint);
            }

            $result =   $this->symbols;
            if ($result['code'] == 200000) {
                $SimbolData = $result['data'];
                foreach ($SimbolData as $SymbolItem) {
                    if ($SymbolItem['name'] == $symbol || $SymbolItem['symbol'] == $symbol) {
                        return $SymbolItem;
                    }
                }
                return false;
            }
            return false;
        }
    }
    public function get_all_tickers()
    {
        $endpoint = '/api/v1/market/allTickers';
        $result = $this->BaseConnect($endpoint);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    public function get_base_trade_fee()
    {
        $endpoint = '/api/v1/base-fee?currencyType=0';
        return $this->BaseConnect($endpoint);
    }
    public function make_stop_Order($side, $symbol, $stopPrice, $size)
    {
        $body = '{"side":"' . $side . '","symbol":"' . $symbol . '","type":"market","stopPrice":"' . $stopPrice . '","size":"' . $size . '","clientOid":"' . microtime(true) . '"}';
        $endpoint = '/api/v1/stop-order';
        $result = $this->BaseConnect($endpoint, 'POST', $body);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    public  function make_market_Order($side, $symbol, $size)
    {
        $body = '{"side":"' . $side . '","symbol":"' . $symbol . '","type":"market","size":"' . $size . '","clientOid":"' . microtime(true) . '"}';
        $endpoint = '/api/v1/orders';
        $result = $this->BaseConnect($endpoint, 'POST', $body);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    public  function make_multi_Order($body)
    {
        $endpoint = '/api/v1/orders/multi';
        $result = $this->BaseConnect($endpoint, 'POST', $body);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    public function make_order(array $OrderAttr)
    {
        $data = [
            'side' => $OrderAttr['side'], //	buy or sell
            'symbol' => $OrderAttr['symbol'], //	Trading pair, such as, ETH-BTC
            'type' => $OrderAttr['type'], //Order type limit and market
            'price' => $OrderAttr['price'], //Specify price for currency
            'size' => $OrderAttr['size'], //Specify quantity for currency
            'clientOid' => microtime(true)
        ];
        if (isset($OrderAttr['cancelAfter'])) { //[Optional] Cancel after n seconds，the order timing strategy is GTT
            $data['timeInForce'] = 'GTT';
            $data['cancelAfter'] = $OrderAttr['cancelAfter'];
        }
        $body = json_encode($data);
        $endpoint = '/api/v1/orders';
        $result = $this->BaseConnect($endpoint, 'POST', $body);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    public  function make_limit_Order($side, $symbol, $price, $size, $cancelAfter = null)
    {
        $body = '{"side":"' . $side . '","symbol":"' . $symbol . '","type":"limit","price":"' . $price . '","size":"' . $size . '","clientOid":"' . microtime(true) . '"}';
        $data = [
            'side' => $side,
            'symbol' => $symbol,
            'type' => 'limit',
            'price' => $price,
            'size' => $size,
            'clientOid' => microtime(true)
        ];


        $body = json_encode($data);
        $endpoint = '/api/v1/orders';
        $result = $this->BaseConnect($endpoint, 'POST', $body);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    public function get_my_stop_orders()
    {
        $endpoint = '/api/v1/stop-order';
        $response = $this->BaseConnect($endpoint);
        return ($response);
    }
    public function get_my_orders($Status = '?status=active')
    {
        $endpoint = '/api/v1/orders' . $Status;
        $result = $this->BaseConnect($endpoint);
        if ($result['code'] == 200000) {

            return $result['data']['items'];
        } else {


            return false;
        }

        return false;
    }
    public function get_order($orderID)
    {
        $endpoint = '/api/v1/orders/' . $orderID;
        $result = $this->BaseConnect($endpoint);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    public function delete_order($orderId)
    {
        $endpoint = "/api/v1/orders/$orderId";
        $result = $this->BaseConnect($endpoint, 'DELETE');
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    public function delete_stop_order($symbol)
    {
        $endpoint = "/api/v1/stop-order/cancel?symbol=$symbol";
        $response = $this->BaseConnect($endpoint, 'DELETE');
        return ($response);
    }
    public function get_candel($symbol, $Type = '1hour', $startAt = null, $endAt = null)
    {
        $endpoint = "/api/v1/market/candles?type=$Type&symbol=$symbol-USDT";
        if ($startAt != null) {
            $endpoint .= "&startAt=$startAt";
        }
        if ($endAt != null) {
            $endpoint .= "&endAt=$endAt";
        }
        $result = $this->BaseConnect($endpoint);
        if ($result['code'] == 200000) {
            return $result['data'];
        }
        return false;
    }
    public function get_my_walet($symbol = null)
    {
        $endpoint = '/api/v1/accounts';
        $result = $this->BaseConnect($endpoint);
        if ($result['code'] == 200000) {
            if ($symbol == null) {
                return $result['data'];
            } else {
                foreach ($result['data'] as $resultItem) {
                    if ($resultItem['currency'] == $symbol)
                        return $resultItem;
                }
                return false;
            }
        }
        return false;
    }
    private function BaseConnect($endpoint, $type = 'GET', $body = '')
    {
        $host = $this->host;
        $key = $this->key;
        $passphrase = $this->passphrase;
        $timestamp = intval(microtime(true) * 1000);
        $headers = [];
        $headers[] = "Content-Type:application/json";
        $headers[] = "KC-API-KEY:" . $key;
        $headers[] = "KC-API-TIMESTAMP:" . $timestamp;
        $headers[] = "KC-API-PASSPHRASE:" . $passphrase;
        $headers[] = "KC-API-SIGN:" . $this->signature($endpoint, $body, $timestamp, $type);

        $requestPath = $host . $endpoint;

        $response = $this->http_request($type, $requestPath, $headers, $body);
        $response = json_decode($response, true);
        return $response;
    }
    private function BaseFutureConnect($endpoint, $type = 'GET', $body = '')
    {
        $host = $this->futurehost;
        $key = '25882d6d-9d0e-4a4b-b9ae-14401da8575e';
        $passphrase = $this->passphrase;
        $timestamp = intval(microtime(true) * 1000);
        $headers = [];
        $headers[] = "Content-Type:application/json";
        $headers[] = "KC-API-KEY:" . $key;
        $headers[] = "KC-API-TIMESTAMP:" . $timestamp;
        $headers[] = "KC-API-PASSPHRASE:" . $passphrase;
        $headers[] = "KC-API-SIGN:" . $this->signature($endpoint, $body, $timestamp, $type);

        $requestPath = $host . $endpoint;

        $response = $this->http_request($type, $requestPath, $headers, $body);
        $response = json_decode($response, true);
        return $response;
    }
    private function http_request($method = 'GET', $url, $headers = [], $data = null)
    {
        //echo "send {$method} request to {$url}:\n";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, TRUE);

        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        if ($method == 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }
    private function signature($request_path = '', $body = '', $timestamp = false, $method = 'GET')
    {
        $secret = $this->secret;

        $body = is_array($body) ? json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $body;
        $timestamp = $timestamp ? $timestamp : time();

        $what = $timestamp . $method . $request_path . $body;

        return base64_encode(hash_hmac("sha256", $what, $secret, true));
    }
}
