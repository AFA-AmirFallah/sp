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
use App\Models\metadata;
use Cache;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Auth;

class hansel_gretel extends CryptoFormola_1
{
    private $ChannelsQty = 7;

    private function HenselTriger($OpenOrdersItem)
    {
        $OrderID = $OpenOrdersItem->meta_value;
        $UserName = $OpenOrdersItem->fgstr;
        $CoinID = $OpenOrdersItem->fgint;
        $KuCoin = new kucoin($UserName);
        $OrderSrc = $KuCoin->get_order($OrderID);
        $CoinSrc = coins::where('id', $CoinID)->first();
        metadata::where('fgint', $OpenOrdersItem->fgint)->where('fgstr', $OpenOrdersItem->fgstr)->where('tt', 'HG')->where('meta_key', '!=', 'ts')->update(['status' => 1]);
        $result =  $this->NewPositon($UserName, $CoinSrc, $OrderSrc, $OrderID);
        $dealFunds = $OrderSrc['dealFunds'];
        $this->SaveDeal($CoinID, $CoinSrc->UserName, 'Buy', $dealFunds);
        if ($result) {
            $HGSRC =  metadata::where('fgint', $OpenOrdersItem->fgint)->where('fgstr', $OpenOrdersItem->fgstr)->where('tt', 'HG')->where('status', '1')->get();
            metadata::where('fgint', $OpenOrdersItem->fgint)->where('fgstr', $OpenOrdersItem->fgstr)->where('tt', 'HG')->where('status', '1')->delete();
        } else {
            echo 'error';
            return false;
        }
        // $this->SaveDeal($CoinID, $CoinSrc->UserName, 'Buy', $dealFunds);
    }
    private function GretelTriger($OpenOrdersItem)
    {
        $OrderID = $OpenOrdersItem->meta_value;
        $UserName = $OpenOrdersItem->fgstr;
        $KuCoin = new kucoin($UserName);
        $OrderSrc = $KuCoin->get_order($OrderID);
        $CoinSrc = coins::where('id', $OpenOrdersItem->fgint)->first();
        metadata::where('fgint', $OpenOrdersItem->fgint)->where('fgstr', $OpenOrdersItem->fgstr)->where('tt', 'HG')->where('meta_key', '!=', 'ts')->update(['status' => 1]);
        $result =  $this->NewPositon($UserName, $CoinSrc, $OrderSrc, $OrderID);
        if ($result) {
            $HGSRC =  metadata::where('fgint', $OpenOrdersItem->fgint)->where('fgstr', $OpenOrdersItem->fgstr)->where('tt', 'HG')->where('status', '1')->get();
            foreach ($HGSRC as $HGItem) {
                if ($HGItem->meta_key == 'hb') {
                    $result =  $KuCoin->delete_order($HGItem->meta_value);
                    if ($result) {
                    } else {
                        echo 'error';
                    }
                }
            }
            metadata::where('fgint', $OpenOrdersItem->fgint)->where('fgstr', $OpenOrdersItem->fgstr)->where('tt', 'HG')->where('status', '1')->delete();
        } else {
            echo 'error';
            return false;
        }
    }
    private function TargetTriger($OpenOrdersItem)
    {
        $OrderID = $OpenOrdersItem->meta_value;
        $UserName = $OpenOrdersItem->fgstr;
        $KuCoin = new kucoin($UserName);
        metadata::where('id', $OpenOrdersItem->id)->delete();
        // $this->SaveDeal($CoinID, $CoinSrc->UserName, 'Buy', $dealFunds);
        return  true;
    }
    public function StartGretel($CoinID, $CoinSrc, $OpenBuysItem, $ExtraInfo)
    {
        $KuCoin = new kucoin($OpenBuysItem->fgstr);
        $OrderSrc = $KuCoin->get_order($OpenBuysItem->meta_value);
        $dealFunds = $OrderSrc['dealFunds'];
        $this->SaveDeal($CoinID, $CoinSrc->UserName, 'Buy', $dealFunds);
        $size = $OrderSrc['size'];
        $UnitPrice = $dealFunds / $size;
        $InputBaget = $ExtraInfo['InputBaget'] / $this->ChannelsQty;
        $benefit = $ExtraInfo['benefit'];
        $stop = $ExtraInfo['stop'];
        $start = $ExtraInfo['start'];
        $HanselPrice =  $UnitPrice - ($UnitPrice * $stop / 100);
        $CoinData = json_decode($CoinSrc->ExtraInfo, 1);
        $size = $OrderSrc['size'];
        $size = $this->numbervalidation($CoinData['baseMinSize'], $size);
        $HanselPrice = number_format($HanselPrice, 10);
        $HanselPrice = $this->numbervalidation($CoinData['priceIncrement'], $HanselPrice);
        $gretelPrice =  $UnitPrice + ($UnitPrice * $start / 100);
        $gretelPrice = number_format($gretelPrice, 10);
        $gretelPrice = $this->numbervalidation($CoinData['priceIncrement'], $gretelPrice);
        $Gretelamount = $InputBaget / $gretelPrice;
        $Gretelamount = $this->numbervalidation($CoinData['baseMinSize'], $Gretelamount);
        $Henselamount = $InputBaget / $HanselPrice;
        $Henselamount = $this->numbervalidation($CoinData['baseMinSize'], $Henselamount);
        $UpPrice =  $UnitPrice + ($UnitPrice * $benefit / 100);
        $UpPrice = number_format($UpPrice, 10);
        $UpPrice = $this->numbervalidation($CoinData['priceIncrement'], $UpPrice);
        $TotalResult = true;
        $multiOrder = [];
        $clientOid = microtime(true);
        $multiOrder[] = [
            "side" => 'sell',
            "type" => "limit",
            "price" => $UpPrice,
            "size" => $size,
            "clientOid" => $clientOid . 'ts'
        ];
        $multiOrder[]  = [
            "side" => 'buy',
            "type" => "limit",
            "price" => $HanselPrice,
            "size" => $Henselamount,
            "clientOid" => $clientOid . 'hb'
        ];
        $Orders = [
            "symbol" => $CoinSrc->CoinName . '-USDT',
            "orderList" => $multiOrder
        ];
        $multiOrder = json_encode($Orders);
        $result =  $KuCoin->make_multi_Order($multiOrder);
        if ($result) {
            $result = $result['data'];
            foreach ($result as $resultItem) {
                $orderId = $resultItem['id'];

                $OrderType = substr($resultItem['clientOid'], -2);

                $BuyOrder = [
                    'tt' => 'HG',
                    'fgstr' => $CoinSrc->UserName,
                    'meta_key' => $OrderType,
                    'fgint' => $CoinSrc->id,
                    'meta_value' => $orderId
                ];
                metadata::create($BuyOrder);
            }
            metadata::where('tt', 'HG')->where('fgstr', $CoinSrc->UserName)->where('meta_key', 'GBR')->where('fgint', $CoinSrc->id)->delete();
            $BuyOrder = [
                'tt' => 'HG',
                'fgstr' => $CoinSrc->UserName,
                'meta_key' => 'GBR', //Gretel Buy Reserve
                'fgint' => $CoinSrc->id,
                'meta_value' => $gretelPrice
            ];
            metadata::create($BuyOrder);
        }
        if ($TotalResult) {

            metadata::where('id', $OpenBuysItem->id)->delete();
            $CoinRobotData = [
                'Robot' => 501,
                'TMNDownLimit' => $HanselPrice,
                'TMNUpLimit' => $UpPrice,
                'Status' => 100
            ];
            coins::where('id', $CoinSrc->id)->update($CoinRobotData); // save stop price

        } else {
        }
        return true;
    }
    private function SetUpGretel()
    {
        $GretelTemp = metadata::where('tt', 'TmpSync')->orderBy('fgstr')->get();
        foreach ($GretelTemp as $GretelTempItem) {
            $CoinID = $GretelTempItem->fgint;
            $CoinSrc = coins::where('id', $CoinID)->first();
            $SymbolInfo = json_decode($CoinSrc->ExtraInfo, 1);
            $ExtraInfo = $SymbolInfo['RobotAtt'];
            metadata::where('fgint', $GretelTempItem->fgint)->where('fgstr', $GretelTempItem->fgstr)->where('tt', 'HG')->where('meta_key', '!=', 'ts')->update(['status' => 1]);
            $result = $this->StartGretel($CoinID, $CoinSrc, $GretelTempItem, $ExtraInfo);
            if ($result) {
                $HGSRC =  metadata::where('fgint', $GretelTempItem->fgint)->where('fgstr', $GretelTempItem->fgstr)->where('tt', 'HG')->where('status', '1')->get();
                $KuCoin = new kucoin($GretelTempItem->fgstr);
                foreach ($HGSRC as $HGItem) {
                    if ($HGItem->meta_key == 'hb') {
                        $result =  $KuCoin->delete_order($HGItem->meta_value);
                        metadata::where('id', $GretelTempItem->id)->delete();
                        if ($result) {
                        } else {
                            echo 'error';
                        }
                    }
                }
            } else {
                echo 'error';
                return false;
            }
        }
    }

    private function NewGretelPositon($UserName, $CoinSrc, $Symboldata)
    {
        $SymbolInfo = json_decode($CoinSrc->ExtraInfo, 1);
        $ExtraInfo = $SymbolInfo['RobotAtt'];
        $KuCoin = new kucoin($UserName);
        $InputBaget = $ExtraInfo['InputBaget'] / $this->ChannelsQty;
        $price = $Symboldata['last'];
        $amount = $InputBaget / $price;
        $amount = $this->numbervalidation($SymbolInfo['baseMinSize'], $amount);
        $result = $KuCoin->make_market_Order('buy', $CoinSrc->CoinName . '-USDT', $amount);
        if ($result) {
            $orderId = $result['orderId'];
            $BuyOrder = [
                'tt' => 'TmpSync',
                'fgstr' => $CoinSrc->UserName,
                'meta_key' => '',
                'fgint' => $CoinSrc->id,
                'meta_value' => $orderId
            ];
            metadata::create($BuyOrder);
        } else {
        }

        return true;
    }
    private function NewPositon($UserName, $CoinSrc, $OrderSrc, $OrderID)
    {
        $CoinData = json_decode($CoinSrc->ExtraInfo, 1);
        $ExtraInfo = $CoinData['RobotAtt'];
        $KuCoin = new kucoin($UserName);
        $dealFunds = $OrderSrc['dealFunds'];
        $size = $OrderSrc['size'];
        if($OrderSrc['type']=='market'){
            $UnitPrice = $dealFunds / $size;
        }else{
            $UnitPrice = $OrderSrc['price'];
        }

        $InputBaget = $ExtraInfo['InputBaget'] / $this->ChannelsQty;
        $benefit = $ExtraInfo['benefit'];
        $stop = $ExtraInfo['stop'];
        $start = $ExtraInfo['start'];
        $decrate = $ExtraInfo['decrate'];
        $timelimit = $ExtraInfo['timelimit'];
        $behav = $ExtraInfo['behav'];
        $khatere = $ExtraInfo['khatere'];
        $RobotstopDown = $ExtraInfo['RobotstopDown'];
        $RobotstopUp = $ExtraInfo['RobotstopUp'];
        $HanselPrice =  $UnitPrice - ($UnitPrice * $stop / 100);
        $size = $OrderSrc['size'];
        $size = $this->numbervalidation($CoinData['baseMinSize'], $size);
        $HanselPrice = number_format($HanselPrice, 10);
        $HanselPrice = $this->numbervalidation($CoinData['priceIncrement'], $HanselPrice);
        $gretelPrice =  $UnitPrice + ($UnitPrice * $start / 100);
        $gretelPrice = number_format($gretelPrice, 10);
        $gretelPrice = $this->numbervalidation($CoinData['priceIncrement'], $gretelPrice);
        $Gretelamount = $InputBaget / $gretelPrice;
        $Gretelamount = $this->numbervalidation($CoinData['baseMinSize'], $Gretelamount);
        $Henselamount = $InputBaget / $HanselPrice;
        $Henselamount = $this->numbervalidation($CoinData['baseMinSize'], $Henselamount);
        $UpPrice =  $UnitPrice + ($UnitPrice * $benefit / 100);
        $UpPrice = number_format($UpPrice, 10);
        $UpPrice = $this->numbervalidation($CoinData['priceIncrement'], $UpPrice);
        $TotalResult = true;
        $multiOrder = [];
        $clientOid = microtime(true);
        $multiOrder[] = [
            "side" => 'sell',
            "type" => "limit",
            "price" => $UpPrice,
            "size" => $size,
            "clientOid" => $clientOid . 'ts'
        ];
        $multiOrder[]  = [
            "side" => 'buy',
            "type" => "limit",
            "price" => $HanselPrice,
            "size" => $Henselamount,
            "clientOid" => $clientOid . 'hb'
        ];
        $Orders = [
            "symbol" => $CoinSrc->CoinName . '-USDT',
            "orderList" => $multiOrder
        ];
        $multiOrder = json_encode($Orders);
        $result =  $KuCoin->make_multi_Order($multiOrder);
        if ($result) {
            $result = $result['data'];
            foreach ($result as $resultItem) {
                $orderId = $resultItem['id'];

                $OrderType = substr($resultItem['clientOid'], -2);

                $BuyOrder = [
                    'tt' => 'HG',
                    'fgstr' => $CoinSrc->UserName,
                    'meta_key' => $OrderType,
                    'fgint' => $CoinSrc->id,
                    'meta_value' => $orderId
                ];
                metadata::create($BuyOrder);
            }
            $BuyOrder = [
                'tt' => 'HG',
                'fgstr' => $CoinSrc->UserName,
                'meta_key' => 'GBR', //Gretel Buy Reserve
                'fgint' => $CoinSrc->id,
                'meta_value' => $gretelPrice
            ];
            metadata::create($BuyOrder);
        }
        if ($TotalResult) {
            metadata::where('id', $OrderID)->delete();
        } else {
        }
        return true;
    }
    private function GratelCheck($Market)
    {
        $this->SetUpGretel(); // finalyze buy gretels
        $GretelSrc = metadata::where('meta_key', 'GBR')->get();
        foreach ($GretelSrc as $GretelItem) {
            $CoinSrc = coins::where('id', $GretelItem->fgint)->first();
            $Symbol = $CoinSrc->CoinName . '-USDT';
            foreach ($Market as $MarketItem) {
                if ($MarketItem['symbol'] == $Symbol) {
                    break;
                }
            }
            if ($GretelItem->meta_value <= $MarketItem['last']) { // goal
                //set new Position based on over gretel
                $this->NewGretelPositon($CoinSrc->UserName, $CoinSrc, $MarketItem);
            }
        }
    }
    private function OrdersWatchDog($MarketInfo)
    {
        $Query = "SELECT * FROM metadata WHERE status = 0 and ( meta_key = 'gb' or meta_key = 'ts' or meta_key = 'hb' ) ORDER BY fgstr";
        $OpenOrdersSrc = DB::select($Query);
        $targetUser = '';
        $KuCoin = new kucoin();
        foreach ($OpenOrdersSrc as $OpenOrdersItem) {
            if ($OpenOrdersItem->fgstr != $targetUser) {
                $targetUser = $OpenOrdersItem->fgstr;
                $KuCoin->SetSecrets($targetUser);
                $UserOrders = $KuCoin->get_my_orders();
            }
            $Active = false;
            foreach ($UserOrders as $OrderItem) {
                if ($OpenOrdersItem->meta_value == $OrderItem['id']) {
                    if ($OrderItem['isActive']) {
                        $Active = true;
                    }
                }
            }
            if (!$Active) {
                switch ($OpenOrdersItem->meta_key) {
                    case 'hb':
                        $this->HenselTriger($OpenOrdersItem);
                        break;
                    case 'gb':
                        $this->GretelTriger($OpenOrdersItem);
                        break;
                    case 'ts':
                        $this->TargetTriger($OpenOrdersItem);
                        break;
                }
            }
        }
    }


    public function HGwatchDog($MarketInfo)
    {
        $this->GratelCheck($MarketInfo);
        $this->OrdersWatchDog($MarketInfo);
        return true;
    }
    private function SaveDeal($CoinId, $UserName, $Side, $Price)
    {

        $BuyOrder = [
            'tt' => 'HGOverView',
            'fgstr' => $UserName,
            'meta_key' => $Side,
            'fgint' => $CoinId,
            'meta_value' => $Price
        ];
        metadata::create($BuyOrder);
    }

    public function StartHG($CoinID, $CoinSrc, $OpenBuysItem, $ExtraInfo)
    {
        $type = $ExtraInfo['type'];
        $KuCoin = new kucoin($OpenBuysItem->fgstr);
        $OrderSrc = $KuCoin->get_order($OpenBuysItem->meta_value);
        $dealFunds = $OrderSrc['dealFunds'];
        $this->SaveDeal($CoinID, $CoinSrc->UserName, 'Buy', $dealFunds);
        $size = $OrderSrc['size'];
        $UnitPrice = $dealFunds / $size;
        $InputBaget = $ExtraInfo['InputBaget'] / $this->ChannelsQty;
        $benefit = $ExtraInfo['benefit'];
        $stop = $ExtraInfo['stop'];
        $start = $ExtraInfo['start'];
        $decrate = $ExtraInfo['decrate'];
        $timelimit = $ExtraInfo['timelimit'];
        $behav = $ExtraInfo['behav'];
        $khatere = $ExtraInfo['khatere'];
        $RobotstopDown = $ExtraInfo['RobotstopDown'];
        $RobotstopUp = $ExtraInfo['RobotstopUp'];
        $HanselPrice =  $UnitPrice - ($UnitPrice * $stop / 100);
        $CoinData = json_decode($CoinSrc->ExtraInfo, 1);
        $size = $OrderSrc['size'];
        $size = $this->numbervalidation($CoinData['baseMinSize'], $size);
        $HanselPrice = number_format($HanselPrice, 10);
        $HanselPrice = $this->numbervalidation($CoinData['priceIncrement'], $HanselPrice);
        $gretelPrice =  $UnitPrice + ($UnitPrice * $start / 100);
        $gretelPrice = number_format($gretelPrice, 10);
        $gretelPrice = $this->numbervalidation($CoinData['priceIncrement'], $gretelPrice);
        $Gretelamount = $InputBaget / $gretelPrice;
        $Gretelamount = $this->numbervalidation($CoinData['baseMinSize'], $Gretelamount);
        $Henselamount = $InputBaget / $HanselPrice;
        $Henselamount = $this->numbervalidation($CoinData['baseMinSize'], $Henselamount);
        $UpPrice =  $UnitPrice + ($UnitPrice * $benefit / 100);
        $UpPrice = number_format($UpPrice, 10);
        $UpPrice = $this->numbervalidation($CoinData['priceIncrement'], $UpPrice);
        $TotalResult = true;
        $multiOrder = [];
        $clientOid = microtime(true);
        $multiOrder[] = [
            "side" => 'sell',
            "type" => "limit",
            "price" => $UpPrice,
            "size" => $size,
            "clientOid" => $clientOid . 'ts'
        ];
        $multiOrder[]  = [
            "side" => 'buy',
            "type" => "limit",
            "price" => $HanselPrice,
            "size" => $Henselamount,
            "clientOid" => $clientOid . 'hb'
        ];

        $Orders = [
            "symbol" => $CoinSrc->CoinName . '-USDT',
            "orderList" => $multiOrder
        ];
        $multiOrder = json_encode($Orders);
        $result =  $KuCoin->make_multi_Order($multiOrder);
        if ($result) {
            $result = $result['data'];
            foreach ($result as $resultItem) {
                $orderId = $resultItem['id'];

                $OrderType = substr($resultItem['clientOid'], -2);

                $BuyOrder = [
                    'tt' => 'HG',
                    'fgstr' => $CoinSrc->UserName,
                    'meta_key' => $OrderType,
                    'fgint' => $CoinSrc->id,
                    'meta_value' => $orderId
                ];
                metadata::create($BuyOrder);
            }
            $BuyOrder = [
                'tt' => 'HG',
                'fgstr' => $CoinSrc->UserName,
                'meta_key' => 'GBR', //Gretel Buy Reserve
                'fgint' => $CoinSrc->id,
                'meta_value' => $gretelPrice
            ];
            metadata::create($BuyOrder);
        }
        if ($TotalResult) {

            metadata::where('id', $OpenBuysItem->id)->delete();
            $CoinRobotData = [
                'Robot' => 501,
                'TMNDownLimit' => $HanselPrice,
                'TMNUpLimit' => $UpPrice,
                'Status' => 100
            ];
            coins::where('id', $CoinSrc->id)->update($CoinRobotData); // save stop price

        } else {
        }
        return true;
    }
    public function BuyCoinHG($CoinID, $ChanellItem, $ExtraInfo)
    {
        $Kocoin = new kucoin($ChanellItem->UserName);
        $SymbolInfo = $ChanellItem->ExtraInfo;
        $SymbolInfo = json_decode($SymbolInfo, true);
        $InputBaget = $ExtraInfo['InputBaget'] / $this->ChannelsQty;
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
}
