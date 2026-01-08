<?php

namespace App\Shop;

use App\Report\ProductReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\myappenv;
use App\Models\store;
use App\Models\warehouse_goods;

class warehouse
{
    private function price_array($Price, $ToNumber)
    {
        $PriceFormula = array();
        $counter = 1;
        for ($counter; $counter < 14; $counter++) {
            if ($ToNumber[$counter] == null || $Price[$counter] == null) {
                break;
            }
            array_push($PriceFormula, ['ToNumber' => $ToNumber[$counter], 'Price' => $Price[$counter]]);
        }
        $PriceFormula = json_encode($PriceFormula);
        return $PriceFormula;
    }



    public function add_product_to_warehouse_online(Request $request)
    {
        $PriceFormula = null;
        $AlertFinish = 1;
        if ($request->has('MadeDate') && $request->input('MadeDate') != null) {
            $MadeDate = $request->input('MadeDate');
        } else {
            $MadeDate = '0001-01-01 00:00:00';
        }
        $Price = $request->input('Price');
        if (is_array($Price)) {
            if ($Price[1] != null) {
                $PriceFormula = $this->price_array($Price, $request->input('ToNumber'));
                $Price = 0;
            } else {
                $Price = $request->MainPrice;
            }
        } else {
            $Price = $request->MainPrice;
        }
        if (Auth::user()->Role == myappenv::role_SuperAdmin || Auth::user()->Role == myappenv::role_ShopAdmin) {
            $OnSale = 1;
            $Owner = $request->input('UserName');
        } else {
            $OnSale = 10;
            $TargetStore = store::where('branch', Auth::user()->branch)->first();
            $Owner = $TargetStore->Owner;
        }

        $Data = [
            'WarehouseID' => $request->input('WarehouseID'),
            'GoodID' => $request->input('GoodID'),
            'QTY' => $request->input('QTY'),
            'Remian' => $request->input('QTY'),
            'BuyPrice' => $request->input('BuyPrice'),
            'Price' => $Price,
            'PricePlan' => $PriceFormula,
            'OnSale' => $OnSale,
            'SaleLimit' => $request->input('QTY'),
            'AlertLimit' => $request->input('AlertLimit'),
            'AlertFinish' => $AlertFinish,
            'InputDate' => $request->input('InputDate'),
            'MadeDate' => $MadeDate,
            'ExpireDate' => $request->input('ExpireDate'),
            'ActiveTime' => now(),
            'BasePrice' => $request->input('BasePrice'),
            'DeactiveTime' => now(),
            'MaxPrice' => 0,
            'MinPrice' => 0,
            'owner' => $Owner,
        ];
        $UserID = Auth::id();
        $reportData = json_encode($Data);
        $reporting = new ProductReport($request->input('GoodID'), $request->input('WarehouseID'));
        $reporting->create_report($UserID, $reportData);
        $insert_data = warehouse_goods::create($Data);
        return $insert_data;
    }
    public function add_product_to_warehouse_offline(Request $request)
    {
        dd($request->input(), 'yes');
        if ($request->has('ProductType')) {
            $ProductType = $request->input('ProductType');
        } else {
            $ProductType = 'good';
        }
        if ($request->input('AlertFinish') == 'on') {
            $AlertFinish = 1;
        } else {
            $AlertFinish = 0;
        }

        if ($request->has('MadeDate') && $request->input('MadeDate') != null) {
            $MadeDate = $request->input('MadeDate');
        } else {
            $MadeDate = '0001-01-01 00:00:00';
        }

        $MaxPrice = $request->input('MaxPrice');
        $MinPrice = $request->input('MinPrice');
        $Note = $request->input('Note');
        $Price = 0;

        $PriceUniqu = true;
        if (is_array($Price)) {
            $PriceFormula = array();
            $PriceUniqu = false;
            $ToNumber = $request->input('ToNumber');
            $counter = 1;
            for ($counter; $counter < 14; $counter++) {
                if ($ToNumber[$counter] == null || $Price[$counter] == null) {
                    break;
                }

                array_push($PriceFormula, ['ToNumber' => $ToNumber[$counter], 'Price' => $Price[$counter]]);
            }
            $PriceFormula = json_encode($PriceFormula);
        }
        if (Auth::user()->Role == myappenv::role_SuperAdmin || Auth::user()->Role == myappenv::role_ShopAdmin) {
            $OnSale = 1;
            $Owner = $request->input('UserName');
        } else {
            $OnSale = 10;
            $TargetStore = store::where('branch', Auth::user()->branch)->first();
            $Owner = $TargetStore->Owner;
        }

        $Data = [
            'WarehouseID' => $request->input('WarehouseID'),
            'GoodID' => $request->input('GoodID'),
            'QTY' => 1,
            'Remian' => 1,
            'BuyPrice' => $request->input('BuyPrice'),
            'Price' => 0,
            'OnSale' => $OnSale,
            'SaleLimit' => 1,
            'AlertLimit' => 1,
            'AlertFinish' => 1,
            'InputDate' => now(),
            'MadeDate' => now(),
            'ExpireDate' => now(),
            'ActiveTime' => now(),
            'BasePrice' => 0,
            'DeactiveTime' => now(),
            'MaxPrice' => $MaxPrice,
            'MinPrice' => $MinPrice,
            'extra' => $Note,
            'owner' => $Owner,

        ];

        $UserID = Auth::id();
        $ArryData = [
            'BuyPrice' => $request->input('BuyPrice'),

        ];
        $reportData = json_encode($ArryData);
        $reporting = new ProductReport($request->input('GoodID'), $request->input('WarehouseID'));
        $reporting->create_report($UserID, $reportData);
        $Result = warehouse_goods::create($Data);
        return redirect()->back()->with('success', __("success alert"));
    }

}