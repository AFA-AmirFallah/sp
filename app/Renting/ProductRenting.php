<?php

namespace App\Renting;

use App\Models\DeviceMeta;
use App\Models\DeviceType;
use App\Models\goods;
use App\Models\warehouse_goods;
use DB;

class ProductRenting
{
    public function change_product_to_rating_mode($WGID, $DeviceType)
    {
        $warehouse_goods = warehouse_goods::where('id', $WGID)->first();
        if ($warehouse_goods == null) {
            return [
                'result' => false,
                'msg' => 'کالا در انبار موجود نیست!'
            ];
        }
        $produt_id = $warehouse_goods->GoodID;
        $rent_data = [
            'onrent' => 1,
            'DeviceType' => $DeviceType
        ];
        $result = goods::where('id', $produt_id)->update($rent_data);
        return [
            'result' => true,
            'data' => $result
        ];
    }
    public static function get_DeviceMeta_list()
    {
        return DeviceMeta::all();
    }
    public static function get_DeviceTypes()
    {
        return DeviceType::all();
    }
    public function get_rent_product_by_type($product_type, $available)
    {
        $Query = "SELECT goods.* , warehouse_goods.id as wgid FROM goods INNER JOIN warehouse_goods on goods.id = warehouse_goods.GoodID where goods.onrent = 1 and goods.DeviceType = $product_type ";
        $rent_product_src = DB::select($Query);
        return $rent_product_src;
    }
    public function get_rent_device_info($selected_product, $WarehouseID , $pwid = null)
    {
        if($pwid != null){
            $Query = "SELECT warehouse_goods.* FROM warehouse_goods where warehouse_goods.id = $pwid ";

        }else{
            $Query = "SELECT warehouse_goods.* FROM warehouse_goods INNER JOIN warehouses on warehouse_goods.WarehouseID = warehouses.id INNER JOIN stores on warehouses.StoreID = stores.id WHERE stores.branch = $WarehouseID and warehouse_goods.GoodID = $selected_product";

        }
        $product_in_warehouse_src = DB::select($Query);
        $product_in_warehouse = null;
        foreach ($product_in_warehouse_src as $product_in_warehouse_item){
            $product_in_warehouse = $product_in_warehouse_item;
        }
        if ($product_in_warehouse == null) {
            return [
                'result' => false,
                'msg' => 'Target Device is not in warehouse'
            ];
        }
        $data = [
            'RentPrice' => $product_in_warehouse->Price,
            'Discount' => $product_in_warehouse->BasePrice,
            'ProviderPrice' => $product_in_warehouse->BuyPrice
        ];
        return [
            'result' => true,
            'data' => $data
        ];
    }
}
