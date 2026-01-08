<?php

namespace App\Shop;

use App\APIS\SMSDotIR;
use App\Models\goods;
use App\Models\product_alert;
use App\Models\UserInfo;
use Illuminate\Support\Facades\DB;

class ProductAlert
{
    public function alert_user_on_existing($product_id)
    {
        $query = "SELECT
	ui.MobileNo ,
	ui.Name ,
	ui.Family,
	g.NameEn
from
	product_alerts pa
inner join UserInfo ui on
	pa.UserName = ui.UserName
	and pa.product_id = $product_id
	INNER  JOIN goods g  on g.id  = pa.product_id 
GROUP by
	ui.MobileNo ,
	ui.Name ,
	ui.Family,
	g.NameEn ";

        $request_src = DB::select($query);
        $sms_center = new SMSDotIR;

        $AllUser = UserInfo::where('Role', 40)->get();
        $target_good = goods::where('id', $product_id)->first();
        /*
                foreach ($AllUser as $single_user) {
                    $arr = [
                        [
                            "name" => "NAME",
                            "value" => $single_user->Name
                        ],
                        [
                            "name" => "PRODUCT",
                            "value" => substr($target_good->NameEn, 0, 24)
                        ]
                    ];
                    if (str_starts_with($single_user->MobileNo, '09')) {
                    if(!is_numeric($single_user->Name)){
                        echo $single_user->MobileNo . ' ' . $single_user->Name . '<br>';
                        $sms_center->exist_alert($arr, $single_user->MobileNo);
                    }

                    }
                } 
                    */


        foreach ($request_src as $request_item) {
            $arr = [
                [
                    "name" => "NAME",
                    "value" => $request_item->Name
                ],
                [
                    "name" => "PRODUCT",
                    "value" => substr($request_item->NameEn, 0, 24)
                ]
            ];
            $sms_center->exist_alert($arr, $request_item->MobileNo);
        }


        product_alert::where('product_id', $product_id)->delete();
        return true;
    }

    public function add_customer_alert($product_id, $customer_id)
    {
        $data = [
            'UserName' => $customer_id,
            'product_id' => $product_id
        ];
        product_alert::create($data);
        return true;
    }
    public function remove_customer_alert($product_id, $customer_id)
    {
        product_alert::where('UserName', $customer_id)->where('product_id', $product_id)->delete();
        return true;
    }
    public static function is_user_alerted_to_product($product_id, $customer_id)
    {
        $result = product_alert::where('UserName', $customer_id)->where('product_id', $product_id)->first();
        if ($result == null) {
            return false;
        }
        return true;
    }
    public static function get_product_alert($product_id)
    {
        $query = "select u.Name , u.Family , p.created_at from product_alerts as p inner join UserInfo as u  on p.UserName = u.UserName  where p.product_id = $product_id";
        $Product_alert_src = DB::select($query);
        return $Product_alert_src;

    }
    public static function get_alert_product_all()
    {
        $query = "SELECT COUNT(*) as row_count, g.id, g.NameFa , g.ImgURL from product_alerts pa  inner join goods g  on pa.product_id = g.id  GROUP  by g.id ,g.NameFa , g.ImgURL order by row_count DESC";
        $all_alerts = DB::select($query);
        return $all_alerts;
    }
    public static function most_sell_30_days()
    {
        $query = "SELECT
	g.id ,
	g.NameFa ,
	g.ImgURL ,
	SUM(poi.product_qty) as product_qty
from
	product_orders po
inner join product_order_items poi on
	po.id = poi.order_id
	and po.status >= 90
INNER JOIN goods g on
	g.id = poi.product_id
WHERE
	po.status = 90 and DATE(po.created_at) > CURDATE() - INTERVAL 30 DAY 
GROUP by
	g.id ,
	g.NameFa ,
	g.ImgURL
ORDER BY
	product_qty DESC
limit 10";
        $most_sell = DB::select($query);
        return $most_sell;

    }
}