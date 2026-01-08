<?php

namespace App\APIS;

use App\myappenv;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Tapin
{
    public $ShopID = myappenv::TopenShopID;
    public $Token = myappenv::TopenToken;
    public function SendToTopin($TargetAddress, $JsonData)
    {
        $url = 'https://api.tapin.ir' . $TargetAddress;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $JsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $header = array('authorization:' . $this->Token, 'Content-Type: application/json;charset=utf-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        $res = json_decode($result);
        curl_close($ch);
      //  Log::channel('local')->info($result);
        return ($res);
    }
    public function get_packing_box()
    {
        $req = [
            'shop_id' => myappenv::TopenShopID
        ];
        $jsonDataEncoded = json_encode($req);
        return $this->SendToTopin('/api/v2/public/order/post/packing-box/', $jsonDataEncoded);
    }
    public function get_state_list()
    {
        $req = [
            'count'=>100,
            'page'=>1
        ];
        $jsonDataEncoded = json_encode($req);
        return $this->SendToTopin('/api/v2/public/state/list/', $jsonDataEncoded);
    }
    public function GetShopInfo()
    {
        $req = [
            'shop_id' => myappenv::TopenShopID
        ];
        $jsonDataEncoded = json_encode($req);
        return $this->SendToTopin('/api/v2/public/shop/detail/', $jsonDataEncoded);
    }
    public function GetShopCredit()
    {
        $req = [
            'shop_id' => myappenv::TopenShopID
        ];
        $jsonDataEncoded = json_encode($req);
        return $this->SendToTopin('/api/v2/public/transaction/credit/', $jsonDataEncoded);
    }
    public function check_price($JsonData)
    {

        return $this->SendToTopin('/api/v2/public/order/post/check-price/', $JsonData);
    }
    public function SendOrderToTapin($price, $weight, $address, $city_code, $province_code, $first_name, $last_name, $mobile, $postal_code, $package_weight, $OrderID, $box_id)
    {

        $Product = array(
            [
                'count' => 1,
                'discount' => 0,
                'price' => $price,
                'title' => 'سفارش  شماره: ' . $OrderID,
                'weight' => 0,
                'product_id' => null
            ]
        );
        /*
        $query = "SELECT po.id, g.NameFa ,poi.product_qty from product_orders po  inner join product_order_items poi  on po.id = poi.order_id  INNER  join goods g  on g.id  = poi.product_id where po.id =  $OrderID ";
        $order_detail_src = DB::select($query);
        $Product = [];
        foreach ($order_detail_src as $order_detail) {
            $item = [
                'count' => $order_detail->product_qty,
                'discount' => 0,
                'price' => $price,
                'title' => $order_detail->NameFa,
                'weight' => 0,
                'product_id' => null
            ];
            array_push($Product, $item);
        }*/

        $Order = [
            "register_type" => 1,
            'shop_id' => myappenv::TopenShopID,
            'address' => $address,
            'city_code' => $city_code,
            'province_code' => $province_code,
            'description' => 'سفارش شماره: ' . $OrderID,
            'email' => null,
            'employee_code' => -1,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'mobile' => $mobile,
            'phone' => null,
            'postal_code' => $postal_code,
            'pay_type' => 1,
            'order_type' => 1,
            'package_weight' => $weight,
            "box_id" => $box_id,
            'products' => $Product
        ];
        $JasonData = json_encode($Order);
        Log::channel('local')->info($JasonData);


        return $this->SendToTopin('/api/v2/public/order/post/register/', $JasonData);
    }
    public function change_status($order_id, $status)
    {
        $req = [
            'shop_id' => myappenv::TopenShopID,
            'order_id' => $order_id,
            'status' => $status
        ];
        $jsonDataEncoded = json_encode($req);
        return $this->SendToTopin('/api/v2/public/order/post/change-status/', $jsonDataEncoded);
    }
    public function get_box_size()
    {
        return [
            "pk" => 5,
            "length" => 30,
            "width" => 20,
            "height" => 20,
            "title" => "30*20*20 cm"
        ];


    }
    public function GetTapinPrice($price, $weight, $address, $city_code, $province_code, $first_name, $last_name, $mobile, $postal_code, $package_weight)
    {
        if (strlen($postal_code) < 10) {
            $postal_code = '1313131313';
        }
        $Product = array(
            [
                'count' => 1,
                'discount' => 0,
                'price' => $price,
                'title' => 'product',
                'weight' => $weight,
                'product_id' => null
            ]
        );
        $Order = [
            'shop_id' => myappenv::TopenShopID,
            'address' => $address,
            'city_code' => $city_code,
            'province_code' => $province_code,
            'description' => null,
            'email' => null,
            'employee_code' => -1,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'mobile' => $mobile,
            'phone' => null,
            'postal_code' => $postal_code,
            'pay_type' => '1',
            'order_type' => '1',
            "box_id" => 2,
            'package_weight' => 0, // package weight
            'products' => $Product
        ];
        $JasonData = json_encode($Order);
        $tapinResult = $this->check_price($JasonData);
        if (isset($tapinResult->entries->total_price)) {
            return array(true, $tapinResult->entries->total_price);
        } else {
            // Log::channel('local')->info($tapinResult->returns);
            return array(false, 'خطای: ' . $tapinResult->returns->status . ' : ' . $tapinResult->returns->message);
        }
    }
}
