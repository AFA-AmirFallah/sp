<?php

namespace App\Crypto;

use App\Http\Controllers\Crypto\kucoin;
use App\Models\CryptoOrders;
use Auth;
use App\Models\coins;
use App\Models\crypto_price_1m;
use App\Models\metadata;
use App\Models\UserInfo;
use DB;

class CryptoFormola_1 extends CryptoFunctions
{
    private $MarketName;
    private $StepPercent = 1;
    private $BadgetPack = 5;
    private $UserName;
    private $BuyData;

    public function StartRobot($CoinID)
    {


        $OpenBuysItem = metadata::where('fgint', $CoinID)->where('tt', 'buyorder')->first();
        if ($OpenBuysItem == null) {
            return false;
        }
        $CoinSrc = coins::where('id', $OpenBuysItem->fgint)->first();
        $ExtraInfo = $this->get_robot_attr($CoinSrc->ExtraInfo);
        $type = $ExtraInfo['type'];
        if ($type == 5) {
            $Hansel_gretel = new hansel_gretel();
            return $Hansel_gretel->StartHG($CoinID, $CoinSrc, $OpenBuysItem, $ExtraInfo);
        }
        $KuCoin = new kucoin($OpenBuysItem->fgstr);
        $OrderSrc = $KuCoin->get_order($OpenBuysItem->meta_value);
        $dealFunds = $OrderSrc['dealFunds'];
        $size = $OrderSrc['size'];
        $UnitPrice = $dealFunds / $size;
        $InputBaget = $ExtraInfo['InputBaget'];
        $benefit = $ExtraInfo['benefit'];
        $stop = $ExtraInfo['stop'];
        $start = $ExtraInfo['start'];
        $decrate = $ExtraInfo['decrate'];
        $timelimit = $ExtraInfo['timelimit'];

        $behav = $ExtraInfo['behav'];
        $khatere = $ExtraInfo['khatere'];
        $RobotstopDown = $ExtraInfo['RobotstopDown'];
        $RobotstopUp = $ExtraInfo['RobotstopUp'];

        $stopPrice =  $UnitPrice - ($UnitPrice * $stop / 100);
        $CoinData = json_decode($CoinSrc->ExtraInfo, 1);
        $stopPrice = number_format($stopPrice, 10);
        $stopPrice = $this->numbervalidation($CoinData['priceIncrement'], $stopPrice);
        $UpPrice =  $UnitPrice + ($UnitPrice * $benefit / 100);
        $UpPrice = number_format($UpPrice, 10);
        $UpPrice = $this->numbervalidation($CoinData['priceIncrement'], $UpPrice);
        $size += $CoinSrc->QTY;
        $result =  $KuCoin->make_stop_Order('sell', $CoinSrc->CoinName . '-USDT', $stopPrice, $size);
        if ($result) {
            $orderId = $result['orderId'];
            $BuyOrder = [
                'tt' => 'limitorder',
                'fgstr' => $CoinSrc->UserName,
                'meta_key' => $CoinSrc->id,
                'fgint' => $CoinSrc->id,
                'meta_value' => $orderId
            ];
            metadata::create($BuyOrder);
            metadata::where('id', $OpenBuysItem->id)->delete();
            $CoinRobotData = [
                'Robot' => 101,
                'TMNDownLimit' => $stopPrice,
                'TMNUpLimit' => $UpPrice,
                'Status' => 100
            ];
            coins::where('id', $CoinSrc->id)->update($CoinRobotData); // save stop price
            if ($type == 2) { // sell limit
                $KuCoin->make_limit_Order('sell', $CoinSrc->CoinName . '-USDT', $UpPrice, $size);
                $BuyOrder = [
                    'tt' => 'limitorder',
                    'fgstr' => $CoinSrc->UserName,
                    'meta_key' => $CoinSrc->id,
                    'fgint' => $CoinSrc->id,
                    'meta_value' => $orderId
                ];
                metadata::create($BuyOrder);
            }
        } else {
        }
        return true;
    }
    public function BuyCoin($CoinID)
    {

        $ChanellItem = coins::where('id', $CoinID)->first();
        $ExtraInfo = $this->get_robot_attr($ChanellItem->ExtraInfo);
        $type = $ExtraInfo['type'];
        if ($type == 5) {
            $Hansel_gretel = new hansel_gretel();
            return $Hansel_gretel->BuyCoinHG($CoinID, $ChanellItem, $ExtraInfo);
        }
        $Kocoin = new kucoin($ChanellItem->UserName);
        $SymbolInfo = $ChanellItem->ExtraInfo;
        $SymbolInfo = json_decode($SymbolInfo, true);

        $InputBaget = $ExtraInfo['InputBaget'];
        $benefit = $ExtraInfo['benefit'];
        $stop = $ExtraInfo['stop'];
        $start = $ExtraInfo['start'];
        $decrate = $ExtraInfo['decrate'];
        $timelimit = $ExtraInfo['timelimit'];

        $behav = $ExtraInfo['behav'];
        $khatere = $ExtraInfo['khatere'];
        $RobotstopDown = $ExtraInfo['RobotstopDown'];
        $RobotstopUp = $ExtraInfo['RobotstopUp'];
        $Symboldata = $Kocoin->get_ticker($ChanellItem->CoinName . '-USDT');
        $price = $Symboldata['price'];
        $amount = $InputBaget / $price;
        $amount = $this->numbervalidation($SymbolInfo['baseMinSize'], $amount);
        $result = $Kocoin->make_market_Order('buy', $ChanellItem->CoinName . '-USDT', $amount);
        if ($result) {
            $orderId = $result['orderId'];
            $BuyOrder = [
                'tt' => 'buyorder',
                'fgstr' => $ChanellItem->UserName,
                'meta_key' => $ChanellItem->id,
                'fgint' => $ChanellItem->id,
                'meta_value' => $orderId
            ];
            metadata::create($BuyOrder);
            $CoinRobotData = [
                'Robot' => 100,
                'Tmn' => $price,
                'Status' => 100
            ];
            coins::where('id', $CoinID)->update($CoinRobotData);
        } else {
        }

        return true;
    }
    private function BuyFreeChannel()
    {

        $FreeChanells = coins::where('Status', 100)->where('Robot', 0)->get(); // new define coins 
        $UserName = null;
        foreach ($FreeChanells as $ChanellItem) {
            //TODO: multi user set key
            if ($ChanellItem->UserName != $UserName) {
                if ($UserName == null) {
                    $Kocoin = new kucoin($ChanellItem->UserName);
                    $UserName = $ChanellItem->UserName;
                } else {
                    $UserName = $ChanellItem->UserName;
                    $Kocoin->SetSecrets($UserName);
                }
            }
            $SymbolInfo = $ChanellItem->ExtraInfo;
            $SymbolInfo = json_decode($SymbolInfo, true);
            $ExtraInfo = $SymbolInfo;
            $ExtraInfo = $this->get_robot_attr($ExtraInfo);
            $InputBaget = $ExtraInfo['InputBaget'];
            $benefit = $ExtraInfo['benefit'];
            $stop = $ExtraInfo['stop'];
            $start = $ExtraInfo['start'];
            $decrate = $ExtraInfo['decrate'];
            $timelimit = $ExtraInfo['timelimit'];
            $type = $ExtraInfo['type'];
            $behav = $ExtraInfo['behav'];
            $khatere = $ExtraInfo['khatere'];
            $RobotstopDown = $ExtraInfo['RobotstopDown'];
            $RobotstopUp = $ExtraInfo['RobotstopUp'];

            $Symboldata = $Kocoin->get_ticker($ChanellItem->CoinName . '-USDT');
            $price = $Symboldata['price'];
            $amount = $InputBaget / $price;
            $amount = $this->numbervalidation($SymbolInfo['baseMinSize'], $amount);
            $result = $Kocoin->make_market_Order('buy', $ChanellItem->CoinName . '-USDT', $amount);
            if ($result) {
                $orderId = $result['orderId'];
                $BuyOrder = [
                    'tt' => 'buyorder',
                    'fgstr' => $ChanellItem->UserName,
                    'meta_key' => $ChanellItem->id,
                    'fgint' => $ChanellItem->id,
                    'meta_value' => $orderId
                ];
                metadata::create($BuyOrder);
                $FreeChanells = coins::where('id', $ChanellItem->id)->update(['Robot' => 100]); // SetActiveRobot
            } else {
            }
        }
        return true;
    }
    private function UpdateLimits($CoinSrc, $CurentPrice)
    {

        $SymbolInfo = $CoinSrc->ExtraInfo;
        $SymbolInfo = json_decode($SymbolInfo, true);
        $ExtraInfo = $this->get_robot_attr($CoinSrc->ExtraInfo);
        $InputBaget = $ExtraInfo['InputBaget'];
        $benefit = $ExtraInfo['benefit'];
        $stop = $ExtraInfo['stop'];
        $start = $ExtraInfo['start'];
        $decrate = $ExtraInfo['decrate'];
        $timelimit = $ExtraInfo['timelimit'];
        $type = $ExtraInfo['type'];
        $behav = $ExtraInfo['behav'];
        $khatere = $ExtraInfo['khatere'];
        $RobotstopDown = $ExtraInfo['RobotstopDown'];
        $RobotstopUp = $ExtraInfo['RobotstopUp'];
        if ($behav == 1) {
            $OldLimitSrc =  metadata::where('tt', 'limitorder')->where('fgint', $CoinSrc->id)->get();
            $LimitUpdate =  $CurentPrice - ($CurentPrice * $stop / 100);
            $CoinData = json_decode($CoinSrc->ExtraInfo, 1);
            $LimitUpdate = number_format($LimitUpdate, 10);
            $LimitUpdate = $this->numbervalidation($CoinData['priceIncrement'], $LimitUpdate);
            echo "newlimit  : $LimitUpdate  - oldlimit = $CoinSrc->TMNDownLimit";
            if ($LimitUpdate >  $CoinSrc->TMNDownLimit) {
                $KuCoin = new kucoin($CoinSrc->UserName);
                $KuCoin->delete_stop_order($CoinSrc->CoinName . '-USDT');
                $stopPrice = $LimitUpdate;
                $size = $CoinSrc->QTY;
                $result =  $KuCoin->make_stop_Order('sell', $CoinSrc->CoinName . '-USDT', $stopPrice, $size);
                if ($result) {
                    $orderId = $result['orderId'];
                    $BuyOrder = [
                        'tt' => 'limitorder',
                        'fgstr' => $CoinSrc->UserName,
                        'meta_key' => $CoinSrc->id,
                        'fgint' => $CoinSrc->id,
                        'meta_value' => $orderId
                    ];
                    metadata::create($BuyOrder);
                    foreach ($OldLimitSrc as $OldLimitItem) {

                        metadata::where('id', $OldLimitItem->id)->delete();
                    }
                    coins::where('id', $CoinSrc->id)->update(['TMNDownLimit' => $stopPrice]); // save stop price
                } else {
                }
            }
        }
    }
    /**
     * macd on price action 
     */
    public function macd_PA($RecentQty, $TotallQty)
    {
        $SimboleSrc = DB::select("SELECT curency FROM crypto_price_1ms GROUP by curency ");
        foreach ($SimboleSrc as $SimboleItem) {
            $Symbol = $SimboleItem->curency;
            $PriceSrc = crypto_price_1m::where('curency', $Symbol)->orderBy('timestamp', 'DESC')->get();
            $TotallSum = 0;
            $loopCount = 1;
            foreach ($PriceSrc as $PriceItem) {
                if ($loopCount == $TotallQty) {
                    break;
                } else {
                    $loopCount++;
                }
                $TotallSum += $PriceItem->price;
                echo $PriceItem->price . '<br>';
            }
            echo "TotallSum =  $TotallSum" . '<br>';
            $TotallSum /= $TotallQty;
            echo "TotallSum avr =  $TotallSum" . '<br>';
            $loopCount = 1;
            $RecentSum = 0;
            foreach ($PriceSrc as $PriceItem) {
                if ($loopCount == $RecentQty) {
                    break;
                } else {
                    $loopCount++;
                }
                $RecentSum += $PriceItem->price;
            }
            foreach($PriceSrc as $PriceItem){
                $LastPrice = $PriceItem->price;
                break;
            }
            echo "RecentSum =  $RecentSum" . '<br>';
            $RecentSum /= $RecentQty;
            echo "RecentSum avr =  $RecentSum" . '<br>';
            $MACD = $RecentSum - $TotallSum;
            $MACPercent = $MACD * 100 / $LastPrice;
            $MACPercent = round($MACPercent,2);
            echo "MACD = " . $MACD  .'<br>';
            echo "MACDPercent = " . $MACPercent  .'<br>';
            

            dd($SimboleItem,$PriceSrc,$LastPrice);
        }
    }
    public function watchDog()
    {
        $Coins = coins::where('Robot', '>=', 100)->get();
        if (count($Coins) == 0) {
            return true;
        }
        $KuCoin = new kucoin();
        $Market = $KuCoin->get_all_tickers();
        $Market = $Market['ticker'];
        $HG = new hansel_gretel();
        $HG->HGwatchDog($Market);

        /*
        foreach ($Coins as $CoinItem) {
            $Symbol = $CoinItem->CoinName . '-USDT';
            foreach ($Market as $MarketItem) {
                if ($MarketItem['symbol'] == $Symbol) {
                    break;
                }
            }
            if ($CoinItem->TMNUpLimit <= $MarketItem['last']) { // goal
                //set new limit 
                $ExtraInfo = json_decode($CoinItem->ExtraInfo, true);
                if (isset($ExtraInfo['RobotAtt'])) {
                    $ExtraInfo = $ExtraInfo['RobotAtt'];
                    $InputBaget = $ExtraInfo['InputBaget'];
                    $benefit = $ExtraInfo['benefit'];
                    $stop = $ExtraInfo['stop'];
                    $start = $ExtraInfo['start'];
                    $decrate = $ExtraInfo['decrate'];
                    $timelimit = $ExtraInfo['timelimit'];
                } else { //defult value
                    $benefit = 1;
                    $stop = 0.5;
                }

                $OldLimitSrc = metadata::where('fgint', $CoinItem->id)->where('tt', 'limitorder')->first();
                $stopPrice = $MarketItem['last'] - ($MarketItem['last'] * $stop / 100);
                $UpPrice = $MarketItem['last'] + ($MarketItem['last'] * $benefit / 100);
                $CoinData = json_decode($CoinItem->ExtraInfo, 1);
                $stopPrice = number_format($stopPrice, 10);
                $stopPrice = $this->numbervalidation($CoinData['priceIncrement'], $stopPrice);
                $size = $CoinItem->QTY;
                $result =  $KuCoin->make_stop_Order('sell', $CoinItem->CoinName . '-USDT', $stopPrice, $size);
                if ($result) {
                    $orderId = $result['orderId'];
                    $BuyOrder = [
                        'tt' => 'limitorder',
                        'fgstr' => $CoinItem->UserName,
                        'meta_key' => $CoinItem->id,
                        'fgint' => $CoinItem->id,
                        'meta_value' => $orderId
                    ];
                    metadata::create($BuyOrder);
                    metadata::where('id', $OldLimitSrc->id)->delete();
                    //delete old order id
                    coins::where('id', $CoinItem->id)->update(['TMNDownLimit' => $stopPrice, 'TMN' => $MarketItem['last'], 'TMNUpLimit' => $UpPrice, 'Robot' => $CoinItem->Robot + 1]); // save stop price
                } else {
                }




                // Delete Old Limit


            } else {
                $this->UpdateLimits($CoinItem, $MarketItem['last']);
                coins::where('id', $CoinItem->id)->update(['TMN' => $MarketItem['last']]);
            }
            
        }*/
    }
    public function numbervalidation($Source, $destination)
    {
        if (str_contains($Source, '.')) {
            $whatIWant = substr($Source, strpos($Source, ".") + 1);
        } else {
            $whatIWant = '';
        }
        if ($whatIWant == '') { // not have dot
            $whatIWant = 0;
            if (str_contains($destination, '.')) {
                $Point = substr($destination, 0, strpos($destination, ".") + 1);
            } else {
                $Point = '';
            }

            if ($Point == '') {
                return  $destination;
            }
            $LenD = strlen($Point);
            $result = substr($destination, 0,  $LenD - 1);
            return $result;
        } else {
            $whatIWant = strlen($whatIWant);
            $Point = substr($destination, 0, strpos($destination, ".") + 1);
            $LenD = strlen($Point);
            $result = substr($destination, 0,  $whatIWant + $LenD);
            return $result;
        }
    }
    private function TraceOpenOrders()
    {
        $Kocoin = new kucoin();
        $FreeChanells = metadata::where('tt', 'MarketRobot')->where('status', 0)->whereNotNull('meta_value')->orderBy('fgstr')->get();
        foreach ($FreeChanells as $ChanellItem) {
            $Kocoin->SetSecrets($ChanellItem->fgstr);
            $OrderInfo = $Kocoin->get_order($ChanellItem->meta_value);
            if ($OrderInfo['dealFunds'] == 0) { // Order not Done
                $Kocoin->delete_order($ChanellItem->meta_value);
                metadata::where('id', $ChanellItem->id)->update(['meta_value' => null]);
            } else { // order done or parcialy done
                // $Kocoin->delete_order($ChanellItem->meta_value);
                $symbol = $OrderInfo['symbol'];
                $Symbol = $symbol;
                $symbol = substr($symbol, 0, strlen($symbol) - 5);
                $stopPrice = $OrderInfo['price'] - ($OrderInfo['price'] * $this->StepPercent / 100);
                $stopPrice = $this->numbervalidation($OrderInfo['price'], $stopPrice);
                $this->RenewWalet($ChanellItem->fgstr);
                $CreditInfo = coins::where('UserName', $ChanellItem->fgstr)->where('CoinName', $symbol)->first();
                $CoinData = json_decode($CreditInfo->ExtraInfo, 1);
                $stopPrice = number_format($stopPrice, 10);
                $stopPrice = $this->numbervalidation($CoinData['priceIncrement'], $stopPrice);
                $size = $CreditInfo->QTY;
                $Kocoin->make_stop_Order('sell', $Symbol, $stopPrice, $size);
                metadata::where('id', $ChanellItem->id)->update(['status' => 1]);
            }
            dd($OrderInfo);
        }
        return true;
    }
    public function buy_coins()
    {
        $this->BuyFreeChannel();
    }
    private function get_robot_attr($ExtraInfo, $key = null)
    {
        $ExtraInfo = json_decode($ExtraInfo, true);
        if (isset($ExtraInfo['RobotAtt'])) {

            $ExtraInfo = $ExtraInfo['RobotAtt'];
            if ($key == null) {
                return $ExtraInfo;
            } else {
                if (isset($ExtraInfo[$key])) {
                    return $ExtraInfo[$key];
                } else {
                    return false;
                }
            }

            /*
            $InputBaget = $ExtraInfo['InputBaget'];
            $benefit = $ExtraInfo['benefit'];
            $stop = $ExtraInfo['stop'];
            $start = $ExtraInfo['start'];
            $decrate = $ExtraInfo['decrate'];
            $timelimit = $ExtraInfo['timelimit'];
            $type = $ExtraInfo['type'];
            $behav = $ExtraInfo['behav'];
            $khatere = $ExtraInfo['khatere'];
            $RobotstopDown = $ExtraInfo['RobotstopDown'];
            $RobotstopUp = $ExtraInfo['RobotstopUp'];
            */
        } else {
            return false;
        }
    }
    public function set_Coins_market_limit()
    {
        $KuCoin = new kucoin();
        $OpenBuys = metadata::where('tt', 'buyorder')->get();
        foreach ($OpenBuys as $OpenBuysItem) {
            $KuCoin->SetSecrets($OpenBuys->fgstr);
            $OrderSrc = $KuCoin->get_order($OpenBuysItem->meta_value);
            $dealFunds = $OrderSrc['dealFunds'];
            $size = $OrderSrc['size'];
            $UnitPrice = $dealFunds / $size;
            $CoinSrc = coins::where('id', $OpenBuysItem->fgint)->first();
            $ExtraInfo = json_decode($CoinSrc->ExtraInfo, true);
            if (isset($ExtraInfo['RobotAtt'])) {
                $ExtraInfo = $ExtraInfo['RobotAtt'];
                $InputBaget = $ExtraInfo['InputBaget'];
                $benefit = $ExtraInfo['benefit'];
                $stop = $ExtraInfo['stop'];
                $start = $ExtraInfo['start'];
                $decrate = $ExtraInfo['decrate'];
                $timelimit = $ExtraInfo['timelimit'];
                $type = $ExtraInfo['type'];
                $behav = $ExtraInfo['behav'];
                $khatere = $ExtraInfo['khatere'];
                $RobotstopDown = $ExtraInfo['RobotstopDown'];
                $RobotstopUp = $ExtraInfo['RobotstopUp'];
            } else {
                return false;
            }
            $stopPrice =  $UnitPrice - ($UnitPrice * $stop / 100);
            $CoinData = json_decode($CoinSrc->ExtraInfo, 1);
            $stopPrice = number_format($stopPrice, 10);
            $stopPrice = $this->numbervalidation($CoinData['priceIncrement'], $stopPrice);
            $UpPrice =  $UnitPrice + ($UnitPrice * $benefit / 100);
            $UpPrice = number_format($UpPrice, 10);
            $UpPrice = $this->numbervalidation($CoinData['priceIncrement'], $UpPrice);
            $size += $CoinSrc->QTY;
            $result =  $KuCoin->make_stop_Order('sell', $CoinSrc->CoinName . '-USDT', $stopPrice, $size);
            if ($result) {
                $orderId = $result['orderId'];
                $BuyOrder = [
                    'tt' => 'limitorder',
                    'fgstr' => $CoinSrc->UserName,
                    'meta_key' => $CoinSrc->id,
                    'fgint' => $CoinSrc->id,
                    'meta_value' => $orderId
                ];
                metadata::create($BuyOrder);
                metadata::where('id', $OpenBuysItem->id)->delete();
                coins::where('id', $CoinSrc->id)->update(['TMNDownLimit' => $stopPrice, 'TMNUpLimit' => $UpPrice]); // save stop price
            } else {
            }
        }
    }
    public function updateOrders()
    {
        $this->TraceOpenOrders();
    }
    public function MarketName_setter($MarketName)
    {
        $this->MarketName = $MarketName;
    }
    private function SaveOrderData(array $result)
    {
        $symbol = $result['symbol']; //SHIBTMN
        $type = $result['type']; //LIMIT
        $side = $result['side']; //BUY
        $clientOrderId = $result['clientOrderId'];  //LIMIT-98612759-f277-40c4-ae40-6c3f368ae0bf
        $price = $result['price'];
        $origQty = $result['origQty'];
        $executedSum = $result['executedSum'];
        $executedQty = $result['executedQty'];
        $executedPrice = $result['executedPrice'];
        $sum = $result['sum'];
        $executedPercent = $result['executedPercent'];
        $status = $result['status'];
        $active = $result['active'];
        $OrderData = [
            'UserName' => $this->UserName,
            'formola' => 1,
            'symbol' => $symbol,
            'type' => $type,
            'side' => $side,
            'price' => $price,
            'origQty' => $origQty,
            'origSum' => $sum,
            'executedPrice' => $executedPercent,
            'executedQty' => $executedQty,
            'executedSum' => $executedSum,
            'executedPercent' => $executedPercent,
            'status' => $status,
            'active' => $active,
            'clientOrderId' => $clientOrderId
        ];
        $result = CryptoOrders::create($OrderData);
        return $result;
    }
    private function Sell_Steper($TargetPrice)
    {
        $MarketInfo = $this->GetMarketInfo($this->MarketName);
        $ConStat = $MarketInfo['stats'];
        $TargetPrice += ($TargetPrice *  $this->StepPercent / 100);
        $tickSize = $MarketInfo['tickSize'];
        $TargetPrice = round($TargetPrice, $tickSize);
        $Tobuy = $this->BuyData['executedQty'];
        $tickSize = $MarketInfo['tickSize'];
        $quotePrecision = $MarketInfo['quotePrecision'];
        $TargetQty = round($Tobuy, $quotePrecision);
        $result =  $this->Orders($this->MarketName, 'SELL', $TargetPrice, $TargetQty);
        if ($result['success'] == 'true') {
            $result = $result['result'];
            $OrderID  = $this->SaveOrderData($result);
            return true;
        } else {
            return $result['message'];
        }
    }
    private function BuySteper()
    {
        $MarketInfo = $this->GetMarketInfo($this->MarketName);
        $ConStat = $MarketInfo['stats'];
        $TargetPrice = $ConStat['lastPrice'];
        $tickSize = $MarketInfo['tickSize'];
        // $TargetPrice = round($TargetPrice, $tickSize);
        $Tobuy = $this->BadgetPack / $TargetPrice;
        $tickSize = $MarketInfo['tickSize'];
        $quotePrecision = $MarketInfo['quotePrecision'];
        $stepSize = $MarketInfo['stepSize'];
        $TargetQty = round($Tobuy, $stepSize);
        $result =  $this->Orders($this->MarketName, 'BUY', $TargetPrice, $TargetQty);
        if ($result['success'] == 'true') {
            $result = $result['result'];
            $this->BuyData = $result;
            $OrderID  = $this->SaveOrderData($result);
            return $result['price'];
        } else {
            return $result['message'];
        }
    }
    public function Execute()
    {
        $this->TokenSetter(Auth::user()->remember_token);
        $TargetPrice =  $this->BuySteper();
        $this->Sell_Steper($TargetPrice);
    }
}
