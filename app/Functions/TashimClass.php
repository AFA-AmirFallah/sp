<?php

namespace App\Functions;

use App\Http\Controllers\Credit\Tashim;
use App\Http\Controllers\woocommerce\ProductClass;
use App\Models\tashim as ModelsTashim;
use App\Models\warehouse_goods;
use App\myappenv;
use Illuminate\Support\Facades\Auth;
use Session;
use stdClass;

class TashimVars
{
    public $BuyPrice = 0;
    public $SalePrice = 0;
    public $TaxPrice = 0;
    public $shippingPrice = 0;
    public $TavanPrice = 0;
}
class TashimClass
{
    public function SumOfBuyWalet($TargetWallet, $TargetUser)
    {
        $WaletSrc = Session::get('Walets');
        $OutPut = 0;
        foreach ($WaletSrc as $WaletSrcItem) {
            if ($WaletSrcItem['CreditMod'] == $TargetWallet) {
                if ($WaletSrcItem['TargetUser'] == $TargetUser) {
                    $OutPut += $WaletSrcItem['Amount'];
                }
            }
        }
        return $OutPut;
    }
    private function get_first_next_month($addedmonth, $targetDate)
    {
        $MyPersian = new persian();
        $CurentJalaliArr = $MyPersian->jgetdate();
        $ThisMon = $CurentJalaliArr['mon'];
        $TOday = $CurentJalaliArr['mday'];
        $TOday = $TOday + 1 - 1;
        $Thisyear = $CurentJalaliArr['year'];
        if ($TOday > 15) {
            $ThisMon += intval($addedmonth) + 1;
        } else {
            $ThisMon += intval($addedmonth);
            //info('alie' . $ThisMon);
        }
        $targetDate = $MyPersian->jalali_to_gregorian($Thisyear, $ThisMon, 1);
        $T_date = $targetDate[0];
        $T_mon = $targetDate[1];
        $T_day = $targetDate[2];
        $targetDate = "$T_date-$T_mon-$T_day 00:00:00";
        return $targetDate;
    }
    public function Tasim_extar_pre_save_modify($SaveData, $TashimData)
    {
        if ($TashimData['extra'] == null || $TashimData['extra'] == '') {
            return $SaveData;
        }
        $extra = json_decode($TashimData['extra']);
        if (isset($extra->Date)) {
            if (\str_starts_with($extra->Date, 'firstmonth')) {
                $Months = substr($extra->Date, 11);
                $persian = new persian();
                $Months = $persian->EnglishNumber($Months);
                $TargetDate = $this->get_first_next_month($Months, 1);
                $SaveData['Date'] = $TargetDate;
            }
        }
        return $SaveData;
    }
    public function WaletAgregator($WaletSrc)
    {

        if ($WaletSrc == null) {
            return null;
        }
        $AgregateArr = array();
        foreach ($WaletSrc as $WaletSrcItem) {
            $find = false;
            foreach ($AgregateArr as $AggregateIndex => $AggregateValue) {
                if ($WaletSrcItem['TashimID'] == $AggregateValue['TashimID']) {
                    if ($WaletSrcItem['TargteUserID'] == $AggregateValue['TargteUserID']) {
                        if ($WaletSrcItem['extra'] == $AggregateValue['extra']) {
                            if ($WaletSrcItem['CreditIndex'] == $AggregateValue['CreditIndex']) {
                                if ($WaletSrcItem['CreditMod'] == $AggregateValue['CreditMod']) {
                                    $AgregateArr[$AggregateIndex]['Amount'] += $WaletSrcItem['Amount'];
                                    $find = true;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            if (!$find) {
                array_push($AgregateArr, $WaletSrcItem);
            }
        }
        return $AgregateArr;
    }
    public function TashimAgregator($WaletSrcAgregator)
    {
        if ($WaletSrcAgregator == null) {
            return null;
        }
        $AgregateArrTashim = array();
        foreach ($WaletSrcAgregator as $WaletSrcAgregatoItem) {
            $find = false;
            foreach ($AgregateArrTashim as $AggregateIndex => $AggregateValue) {
                if ($WaletSrcAgregatoItem['TargteUserID'] == $AggregateValue['TargteUserID']) {
                    if ($WaletSrcAgregatoItem['extra'] == $AggregateValue['extra']) {
                        if ($WaletSrcAgregatoItem['CreditIndex'] == $AggregateValue['CreditIndex']) {
                            if ($WaletSrcAgregatoItem['CreditMod'] == $AggregateValue['CreditMod']) {
                                $AgregateArrTashim[$AggregateIndex]['Amount'] += $WaletSrcAgregatoItem['Amount'];
                                $find = true;
                                break;
                            }
                        }
                    }
                }
            }
            if (!$find) {
                array_push($AgregateArrTashim, $WaletSrcAgregatoItem);
            }
        }
        return $AgregateArrTashim;
    }
    public function FormulaCalc($FormolStr, TashimVars $Vars)
    {
        $result = 0;
        $FormolStr = str_replace("purchase", $Vars->BuyPrice, $FormolStr);
        $FormolStr = str_replace("selling", $Vars->SalePrice, $FormolStr);
        $FormolStr = str_replace("shipping", $Vars->shippingPrice, $FormolStr);
        $FormolStr = str_replace("tax", $Vars->TaxPrice, $FormolStr);
        $FormolStr = str_replace("tavan", $Vars->TavanPrice, $FormolStr);
        eval('$result = (' . $FormolStr . ');');
        $result = (ceil($result / 10)) * 10;
        return $result;
    }
    public function get_wallets()
    {
        $this->Wallets(); //add if require
        $Walets = Session::get('Walets');
        if ($Walets == null) {
            return [];
        } else {
            return $Walets;
        }
    }
    public function is_use_wallet($WalletID, $Person)
    {
        // Person = buyer , Seller  or ...
        $Walltes = $this->get_wallets();
        foreach ($Walltes as $WallteItem) {
            if ($WallteItem['TargetUser'] == $Person && $WallteItem['CreditMod'] == $WalletID) {
                return true;
            }
        }
        return false;
    }
    public function Wallets()
    {

        $TashimSession = $this->get_tashim_session();
        $TashimWork = new Tashim;
        $Myorder = new Orders();
        $OrderDetials = $Myorder->get_order_detials();
        $Walets = $TashimWork->TashimPreResult($TashimSession, $OrderDetials);
        $WaletSummery = $TashimWork->WaletSummery($Walets, 'buyer');
        Session::put('Walets', $Walets);
    }
    public function get_sale_price_walet_with_tashim($ProductPriceAttr, $TashimId, $TargetWallet)
    {
        $TashimVar = new TashimVars();
        $MyTashim = new TashimClass();
        $TashimVar->SalePrice = $ProductPriceAttr['ProductPrice'];
        $TashimVar->shippingPrice = Orders::getshiping();
        $TashimVar->TaxPrice = ProductClass::GetTargetTax($ProductPriceAttr['ProductPrice'], $ProductPriceAttr['tax_status']);
        $result = 0;
        $OutPut = 0;
        $TashimSrc = ModelsTashim::where('TashimID', $TashimId)->get();
        foreach ($TashimSrc as $TashimSrcItem) {
            if ($TashimSrcItem->CreditMod == $TargetWallet) {
                if ($TashimSrcItem->TargetUser == 'buyer') {

                    $result = $MyTashim->FormulaCalc($TashimSrcItem->FormolStr, $TashimVar);
                    $OutPut += ceil($result);
                }
            }
        }
        $OutPutArr = [
            'PriceWithTax' => $OutPut,
            'TaxPrice' => $TashimVar->TaxPrice,
        ];
        return $OutPutArr;
    }
    public function get_sale_price_with_tashim_basic($SalePrice, $shippingPrice, $TaxPrice, $TashimId)
    {
        $TashimVar = new TashimVars();
        $MyTashim = new TashimClass();
        $TashimVar->SalePrice = $SalePrice;
        $TashimVar->shippingPrice = $shippingPrice;
        $TashimVar->TaxPrice = $TaxPrice;
        $result = 0;
        $OutPut = 0;
        $TashimSrc = ModelsTashim::where('TashimID', $TashimId)->get();
        foreach ($TashimSrc as $TashimSrcItem) {
            if ($TashimSrcItem->TargetUser == 'buyer') {
                $result = $MyTashim->FormulaCalc($TashimSrcItem->FormolStr, $TashimVar);
                $OutPut += ceil($result);
            }
        }
        $OutPutArr = [
            'PriceWithTax' => $OutPut,
            'TaxPrice' => $TashimVar->TaxPrice,
        ];
        return $OutPutArr;
    }
    public function get_sale_price_with_tashim($ProductPriceAttr, $TashimId)
    {
        $TashimVar = new TashimVars();
        $MyTashim = new TashimClass();
        $TashimVar->SalePrice = $ProductPriceAttr['ProductPrice'];
        $TashimVar->shippingPrice = Orders::getshiping();
        $TashimVar->TaxPrice = ProductClass::GetTargetTax($ProductPriceAttr['ProductPrice'], $ProductPriceAttr['tax_status']);
        $result = 0;
        $OutPut = 0;
        $TashimSrc = ModelsTashim::where('TashimID', $TashimId)->get();
        foreach ($TashimSrc as $TashimSrcItem) {
            if ($TashimSrcItem->TargetUser == 'buyer') {
                $result = $MyTashim->FormulaCalc($TashimSrcItem->FormolStr, $TashimVar);
                $OutPut += ceil($result);
            }
        }
        $OutPutArr = [
            'PriceWithTax' => $OutPut,
            'TaxPrice' => $TashimVar->TaxPrice,
        ];
        return $OutPutArr;
    }
    public function TashimBlade($ProductId, $SaleMony, $TaxStatus = 0)
    {
        $TashimValues = new TashimVars();
        $TashimValues->SalePrice = $SaleMony;
        $TashimValues->TaxPrice = ProductClass::GetTargetTax($SaleMony, $TaxStatus);
        $resultStr = [];
        $result = 0;
        $TashimSession = json_decode(Session::get('Tashim'));
        $TashimId = null;
        if ($TashimSession != null) {
            foreach ($TashimSession as $TashimSessionItem) {
                if ($TashimSessionItem->ProductId == $ProductId) {
                    $TashimId = $TashimSessionItem->Tashim;
                    break;
                }
            }
        }

        if ($TashimId != null) {
            $OutPutStr = '';
            $TashimSrc = ModelsTashim::where('TashimID', $TashimId)->get();
            foreach ($TashimSrc as $TashimSrcItem) {
                if ($TashimSrcItem->TargetUser == 'buyer') {
                    $OutPutStr = $TashimSrcItem->Note . ' ';
                    $FormolStr = $TashimSrcItem->FormolStr;
                    $result = $this->FormulaCalc($TashimSrcItem->FormolStr, $TashimValues);
                    $arritem = [
                        'OutPutStr' => $OutPutStr,
                        'priceStr' => ceil($result * -1),
                    ];
                    array_push($resultStr, $arritem);
                }
            }
        } else {
            $resultStr = [];
        }
        return $resultStr;
    }
    public function IsValidTashim($UserName = null, $UserWalet = null, $TashimSession = null)
    {
        if ($UserName == null) {
            $UserName = Auth::id();
        }
        if ($UserWalet == null) {
            $UserWalet =  Session::get('Walets');
        }
        $MyPeriodicCredit = new periodicCreditClass();
        if (!$MyPeriodicCredit->IsValidWalets($UserName, $UserWalet)) {
            return false;
        }
        if ($TashimSession == null) {
            $TashimSession = $this->get_tashim_session();
        }

        $TashimsArr = new stdClass;
        $MyTashim = new Tashim;
        $CreditMods = array();
        $Result = array();
        if ($TashimSession != null) {
            foreach ($TashimSession as $TashimSessionItem) {
                $ProductSrc = warehouse_goods::where('GoodID', $TashimSessionItem->ProductId)->first();
                $MonyAttr = [
                    'SaleMony' => $ProductSrc->Price,
                ];
                $Result = $MyTashim->DoTashim($TashimSessionItem->Tashim, $MonyAttr);
                foreach ($Result as $TashimSRCItem) {
                    if ($TashimSRCItem['TargetUser'] == 'buyer') {
                        if ($TashimSRCItem['CreditMod'] != myappenv::CachCredit) {
                            $ArrItem = $TashimSRCItem['CreditMod'];
                            if (!in_array($ArrItem, $CreditMods)) {
                                array_push($CreditMods, $ArrItem);
                            }
                            if (isset($TashimsArr->$ArrItem)) {
                                $TashimsArr->$ArrItem = $TashimsArr->$ArrItem + $TashimSRCItem['Amount'];
                            } else {
                                $TashimsArr->$ArrItem = $TashimSRCItem['Amount'];
                            }
                        }
                    }
                }
            }
        }
        $ValidTransfer = true;
        $Myfin = new Financial;
        foreach ($CreditMods as $CreditMod) {
            $CheckTransfer = $Myfin->IsValidTransfer($UserName, $CreditMod, $TashimsArr->$CreditMod);
            if (!$CheckTransfer) {
                $ValidTransfer = false;
            }
        }

        return $ValidTransfer;
    }
    public function get_tashim_session()
    {
        $result = json_decode(Session::get('Tashim'));
        if ($result == null) {
            return array();
        } else {
            return $result;
        }
    }
    public function put_tashim($ProductId, $PWID, $Tashim)
    {
       // info("put_tashim ProductId:$ProductId, PWID:$PWID, Tashim:$Tashim");
        $additem = false;
        $NewTashim = [
            'ProductId' => $ProductId,
            'PWID' => $PWID,
            'Tashim' => $Tashim,
        ];
        $tempTashim = array();
        foreach ($this->get_tashim_session() as $TashimSessionItem) {
            if ($TashimSessionItem->ProductId == $ProductId) {
                if ($Tashim != 0) {
                    array_push($tempTashim, $NewTashim);
                }
                $additem = true;
            } else {

                array_push($tempTashim, $TashimSessionItem);
            }
        }
        if (!$additem) {
            if ($Tashim != 0) {
                array_push($tempTashim, $NewTashim);
            }
        }
        $TashimSession = json_encode($tempTashim);
        Session::put('Tashim', $TashimSession);
        return true;
    }
    public static function get_all_tashims_static()
    {
        if (!Auth::check()) {
            return [
                'result' => false,
                'msg' => 'The user is not login!'
            ];
        }
        if (Auth::user()->branch == myappenv::Branch) {
            //TODO: The tashim has not branch feild for multibranch verison
            return [
                'result' => true,
                'data' => ModelsTashim::all()->where('ItemOrder', 0)
            ];
        } else {
            return [
                'result' => true,
                'data' => ModelsTashim::all()->where('ItemOrder', 0)
            ];
        }
    }
    public function get_all_tashims()
    {
        return ModelsTashim::all()->where('ItemOrder', 0);
    }
}
