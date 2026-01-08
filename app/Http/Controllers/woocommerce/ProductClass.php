<?php

namespace App\Http\Controllers\woocommerce;

use App\Http\Controllers\Controller;
use App\Models\goods;
use App\Models\product_order;
use App\Models\store;
use App\Models\UserInfo;
use App\Models\warehouse;
use App\Models\warehouse_goods;
use Illuminate\Http\Request;
use App\myappenv;
use Carbon\Carbon;
use DB;


class ProductClass extends Controller
{
    public $ShopID;
    public $GoodID = null;
    public function  GoodIDSetter($GoodID)
    {
        $this->GoodID = $GoodID;
    }

    public function get_good_warehouse()
    {
        $Query = "SELECT warehouse_goods.*,warehouses.Name FROM warehouse_goods INNER JOIN warehouses on warehouse_goods.WarehouseID = warehouses.id where warehouse_goods.GoodID =  $this->GoodID";
        return  DB::select($Query);
    }


    public static function GetTargetPrice($InputPrice, $TaxStatus)
    {
        //return price with tax
        if ($TaxStatus == 0) {
            return $InputPrice;
        }
        if ($TaxStatus == 10) {
            $TaxPercent = myappenv::TaxPercent;
            return $InputPrice + ($InputPrice * $TaxPercent / 100);
        }
    }
    public static function GetTargetTax($InputPrice, $TaxStatus)
    {
        //return price with tax
        if ($TaxStatus == 0) {
            return 0;
        }
        if ($TaxStatus == 10) {
            $TaxPercent = myappenv::TaxPercent;
            return $InputPrice * $TaxPercent / 100;
        }
    }


    public function SetShopID($ShopID)
    {
        $this->ShopID = $ShopID;
    }
    public function GetProductShop($ProductID)
    {
        $WarehouseItem = warehouse_goods::where('GoodID', $ProductID)->first();
        $TargetWarehouse = warehouse::where('id', $WarehouseItem->WarehouseID)->first();
        $this->ShopID = $TargetWarehouse->StoreID;
        return  store::where('id', $TargetWarehouse->StoreID)->first();
    }
    public function GetProductIndexes($ProductID)
    {

        $Query = "SELECT
        lw.Name as l3name , lw2.Name as l2name
    from
        goodindices g
    inner join L3Work lw on
        g.IndexID = lw.UID
    INNER JOIN L2Work lw2 on
        lw2.WorkCat = lw.WorkCat AND
        lw2.L1ID =lw.L1ID AND
        lw2.L2ID =lw.L2ID
        WHERE g.GoodID  = $ProductID and lw.WorkCat > 1000  ";
        return DB::select($Query);
    }
    public function GetMoreProductOfSeller($TargetProduct, $Limit)
    {
        $ShopID = $this->ShopID;
        $Query = "SELECT
        g.id ,g.SKU , g.NameFa ,g.ImgURL ,wg.QTY ,wg.MaxPrice ,wg.Price ,wg.MinPrice ,wg.Remian ,wg.BasePrice
    from
        stores s
    inner join warehouses w on
        s.id = w.StoreID
    INNER JOIN warehouse_goods wg on
        wg.WarehouseID = w.id
    INNER JOIN goods g on
        g.id = wg.GoodID
        WHERE  s.id = $ShopID and wg.Remian > 0 LIMIT $Limit";
        return DB::select($Query);
    }
    public function GetMoreProduct($TargetProduct, $Limit)
    {
        $ShopID = $this->ShopID;
        $Query = "SELECT
        g.id ,g.SKU , g.NameFa ,g.ImgURL ,wg.QTY ,wg.MaxPrice ,wg.Price ,wg.MinPrice ,wg.Remian ,wg.BasePrice
    from
        stores s
    inner join warehouses w on
        s.id = w.StoreID
    INNER JOIN warehouse_goods wg on
        wg.WarehouseID = w.id
    INNER JOIN goods g on
        g.id = wg.GoodID
        WHERE  s.id = $ShopID and wg.Remian >0 LIMIT $Limit";
        return DB::select($Query);
    }
    public function GetfinishProductcount()
    {
        return warehouse_goods::where('Remian', 0)->count();
    }
    public function GetCountProduct()
    {
        return goods::where('onsale', 0)->count();
    }
    public function GetOrderProductcount()
    {
        return product_order::whereDate('created_at', Carbon::today())->where('status', 1)->count();
    }
    public function UnsuccessBuy()
    {
        return product_order::whereDate('created_at', Carbon::today())->where('status', 0)->count();
    }
    public function GetShopcount()
    {
        return store::where('Status', 1)->count();
    }
    public function TodayOrder()
    {
        return product_order::whereDate('created_at', Carbon::today())->where('Status', '>', 0)->count();
    }
    /**
     * This function use to return TodaySale to show in AccountingDashboard
     *
     *
     */
    public function TodaySale()
    {

        $TodaySale = product_order::whereDate('created_at', Carbon::today())->where('Status', '>', 0)->where('status', '<>', 60)->whereRaw('product_orders.id = product_orders.DeviceContract')
        ->sum('total_sales');
        return $TodaySale;
    }
    /**
     * This function use to return LastWeekSale to show in AccountingDashboard
     *
     *
     */
    public function LastWeekSale()
    {
        $lastWeekSale = product_order::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->where('Status', '>', 0)->where('status', '<>', 60)->whereRaw('product_orders.id = product_orders.DeviceContract')
        ->sum('total_sales');
        return $lastWeekSale;
    }
    public function TodayUser()
    {
        return UserInfo::whereDate('created_at', Carbon::today())->count();
    }
    public function GetMyStoreProductCount()
    {
        $ShopID = $this->ShopID;
        $Query = "SELECT
        count(*) as rowscount
    from
        stores s
    inner join warehouses w on
        s.id = w.StoreID
    INNER JOIN warehouse_goods wg on
        wg.WarehouseID = w.id
    INNER JOIN goods g on
        g.id = wg.GoodID
        WHERE  s.id = $ShopID";
        $result =  DB::select($Query);
        return ($result[0]->rowscount);
    }
    public function GetMyStoreProductfnish()
    {
        $ShopID = $this->ShopID;
        $Query = "SELECT count(*) as fishcount
    from
        stores s
    inner join warehouses w on
        s.id = w.StoreID
    INNER JOIN warehouse_goods wg on
        wg.WarehouseID = w.id
    INNER JOIN goods g on
        g.id = wg.GoodID
        WHERE  s.id = $ShopID and wg.Remian = 0";
        $result = DB::select($Query);
        return ($result[0]->fishcount);
    }
    public function GetMyStoreProduct($Limit)
    {
        $ShopID = $this->ShopID;
        $Query = "SELECT
        g.id ,g.SKU , g.NameFa ,g.ImgURL ,wg.QTY ,wg.MaxPrice ,wg.Price ,wg.view, wg.MinPrice ,wg.Remian ,wg.BasePrice
    from
        stores s
    inner join warehouses w on
        s.id = w.StoreID
    INNER JOIN warehouse_goods wg on
        wg.WarehouseID = w.id
    INNER JOIN goods g on
        g.id = wg.GoodID
        WHERE  s.id = $ShopID and wg.Remian > 0 order by wg.view DESC LIMIT $Limit";
        return DB::select($Query);
    }
    public function GetMyStoreProductFinishList($Limit)
    {
        $ShopID = $this->ShopID;
        $Query = "SELECT
        g.id ,g.SKU , g.NameFa ,g.ImgURL ,wg.QTY ,wg.MaxPrice ,wg.Price ,wg.MinPrice ,wg.Remian ,wg.BasePrice ,wg.view
    from
        stores s
    inner join warehouses w on
        s.id = w.StoreID
    INNER JOIN warehouse_goods wg on
        wg.WarehouseID = w.id
    INNER JOIN goods g on
        g.id = wg.GoodID
        WHERE  s.id = $ShopID and wg.Remian = 0 order by wg.view DESC LIMIT $Limit";
        return DB::select($Query);
    }
}
