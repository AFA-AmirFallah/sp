<?php

namespace App\Functions;

use App\Models\anlytics;
use App\Models\UserInfo;
use App\Models\warehouse;
use DB;

class Statistics
{

    public function GetVitualSold(string $startDate, string $endDate, $username)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }
        $Query = "SELECT sum(product_order_items.product_qty)*12 as Productsold FROM product_orders
        INNER JOIN product_order_items on product_order_items.order_id = product_orders.id
        INNER JOIN goods on product_order_items.product_id = goods.id
        where goods.Virtual = 1 and product_orders.status !=60 and product_orders.status !=0
        and product_orders.id = product_orders.DeviceContract
        and product_orders.created_at >= '$startDate'
        and product_orders.created_at <= '$endDate'
        $Condition";
        $Result = DB::Select($Query);
        return $Result[0]->Productsold;
    }
    public function GetVitualSoldDetail(string $startDate, string $endDate, $username)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }
        $Query = "SELECT  product_order_items.customer_id as customer ,goods.NameFa as Name  FROM product_orders
        INNER JOIN product_order_items on product_order_items.order_id = product_orders.id
        INNER JOIN goods on product_order_items.product_id = goods.id
        where goods.Virtual = 1 and product_orders.status !=60 and product_orders.status !=0
        and product_orders.id = product_orders.DeviceContract
        and product_orders.created_at >= '$startDate'
        and product_orders.created_at <= '$endDate'
        $Condition";
        $Result = DB::Select($Query);
        return $Result;
    }


    public function GetCounsoult($startDate, $endDate, $username)
    {
        if ($username != null) {
            return 0;
        }
        $Query = "SELECT sum(CallDuration)/3600 as sum  , COUNT(*) as count FROM `Calls` where (CallerNumber != 101 or CallerNumber != 107 or CallerNumber !=105
       or CallerNumber != 103 or CallerNumber != 104 ) and
        (StartTime >= '$startDate' and EndTime <='$endDate') ";
        $Result = DB::select($Query);
        $Result = [
            'sum' => $Result[0]->sum,
            'count' => $Result[0]->count,

        ];
        return $Result;
    }
    public function GetCounsoultDetail($startDate, $endDate, $username)
    {
        if ($username != null) {
            return 0;
        }
        $Query = "SELECT CallDuration , CallerNumber  FROM `Calls` where (CallerNumber != 101 or CallerNumber != 107 or CallerNumber !=105 or
        CallerNumber != 103 or CallerNumber != 104 ) and

         (StartTime >= '$startDate' and EndTime <='$endDate') ";
        $Result = DB::select($Query);

        return $Result;
    }

    public function GetOrdersTotall($startDate, $endDate, $username)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }
        $Query = "SELECT
        COUNT(*) as count
    from
        product_orders

    WHERE
        product_orders.status != 0
        and product_orders.created_at >= '$startDate'
        and product_orders.created_at <= '$endDate' $Condition";
        $Result = DB::select($Query);
        return $Result[0]->count;
    }
    public function GetOrdersTotallDetail($startDate, $endDate, $username)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }
        $Query = "SELECT
        product_orders.id,product_orders.CustomerId
    from
        product_orders

    WHERE
        product_orders.status != 0
        and product_orders.created_at >= '$startDate'
        and product_orders.created_at <= '$endDate' $Condition";
        $Result = DB::select($Query);
        return $Result;
    }
    public function SalesTotallStatistics($startDate, $endDate, $username)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }
        $Query = "SELECT sum(product_orders.total_sales) as total_sales , sum(product_orders.net_total) as net_total ,
        sum(product_orders.num_items_sold) as num_items_sold , sum(product_orders.tax_total) as tax_total ,
        sum(product_orders.shipping_total) as shipping_total from product_orders
         WHERE product_orders.status != 60 and product_orders.status != 0 and product_orders.id = product_orders.DeviceContract
         and product_orders.created_at >= '$startDate' and product_orders.created_at <= '$endDate' $Condition";
        $Result = DB::select($Query);
        return $Result[0];
    }
    public function UserPointStatistics($startDate, $endDate, $username)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }
        $Query = " SELECT UserPoint.Point , COUNT(*) as count FROM `UserPoint` INNER JOIN product_orders on UserPoint.order = product_orders.id WHERE product_orders.created_at >= '$startDate' and product_orders.created_at <= '$endDate'  $Condition and Point != 0 GROUP by Point";
        $Result = DB::select($Query);
        $Total = 0;
        foreach ($Result as $ResultItem) {
            $Total += $ResultItem->count;
            $resArr[$ResultItem->Point] = $ResultItem->count;
        }
        for ($i = 1; $i <= 5; $i++) {

            if (isset($resArr[$i])) {
                $Target = $resArr[$i];
            } else {
                $Target = 0;
            }
            if ($Total != 0) {
                $OutPutArr[$i]['percent'] = intval($Target / $Total * 100);
            } else {
                $OutPutArr[$i]['percent'] = 0;
            }
            $OutPutArr[$i]['count'] = intval($Target);
            $OutPutArr[$i]['Total'] = intval($Total);
            $OutPutArr[$i]['wight'] = intval($Target * $i * 20);
        }

        return ($OutPutArr);
    }
    public function UserPointStatisticsDetail($startDate, $endDate, $username)
    {
        if ($username != null) {
            return 0;
        }
        $Query = " SELECT UserPoint.Point , UserPoint.UserName , UserPoint.order FROM `UserPoint` INNER JOIN product_orders on UserPoint.order = product_orders.id WHERE product_orders.created_at >= '$startDate' and product_orders.created_at <= '$endDate' and Point != 0 ";
        $Result = DB::select($Query);
        return $Result;
    }

    public function getSpecificIndexProductSold($startDate, $endDate, $username, $WorkCat = 1, $L1ID = 4, $L2ID = 32)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }
        $Query = "SELECT
        sum(product_order_items.product_qty) as count
        from
            product_orders
            INNER JOIN product_order_items on product_order_items.order_id = product_orders.id
            INNER JOIN goodindices as gi on product_order_items.product_id = gi.GoodID
            INNER JOIN L3Work on L3Work.UID = gi.IndexID

        WHERE
            L3Work.WorkCat = $WorkCat
            and L3Work.L1ID = $L1ID
            and L3Work.L2ID = $L2ID
            and product_orders.status != 60
            and product_orders.status != 0
            and product_orders.id = product_orders.DeviceContract
            and product_orders.created_at >= '$startDate'
            and product_orders.created_at <= '$endDate'
            $Condition";

        $Result = DB::select($Query);

        return $Result[0]->count;
    }
    public function getSpecificIndexProductSoldDetail($startDate, $endDate, $username, $WorkCat = 1, $L1ID = 4, $L2ID = 32)
    {

        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }

        $Query = "SELECT
         product_order_items.order_id,  product_order_items.product_id,product_order_items.product_qty
        from
            product_orders
            INNER JOIN product_order_items on product_order_items.order_id = product_orders.id
            INNER JOIN goodindices as gi on product_order_items.product_id = gi.GoodID
            INNER JOIN L3Work on L3Work.UID = gi.IndexID

        WHERE
            L3Work.WorkCat = $WorkCat
            and L3Work.L1ID = $L1ID
            and L3Work.L2ID = $L2ID
            and product_orders.status != 60
            and product_orders.status != 0
            and product_orders.id = product_orders.DeviceContract
            and product_orders.created_at >= '$startDate'
            and product_orders.created_at <= '$endDate'
            $Condition";

        $Result = DB::Select($Query);
        return $Result;
    }
    public function getSpecificIndexProduct($startDate, $endDate, $username, $WorkCat = 1, $L1ID = 4, $L2ID = 32)
    {
        if ($username != null) {

            $Query = "select COUNT(*) as count, wg.GoodID , sum(wg.QTY) as Qty , sum(wg.Remian) as Remian from
            warehouse_goods as wg  INNER JOIN report_detials on report_detials.ProductID = wg.GoodID INNER JOIN goodindices as gi on wg.GoodID = gi.GoodID
            INNER JOIN L3Work on L3Work.UID = gi.IndexID  WHERE L3Work.WorkCat = $WorkCat and L3Work.L1ID = $L1ID and L3Work.L2ID = $L2ID
            and wg.created_at >= '$startDate'
         and wg.created_at <= '$endDate'
        and report_detials.ReportType = '5' and report_detials.UserID = '$username'
            GROUP by wg.GoodID";
        }

        $Query = "select
        COUNT(*) as count, wg.GoodID , sum(wg.QTY) as Qty , sum(wg.Remian) as Remian
       from
           warehouse_goods as wg INNER JOIN goodindices as gi on wg.GoodID = gi.GoodID
           INNER JOIN L3Work on L3Work.UID = gi.IndexID  WHERE L3Work.WorkCat = $WorkCat and L3Work.L1ID = $L1ID and L3Work.L2ID = $L2ID
           and wg.created_at >= '$startDate'
        and wg.created_at <= '$endDate'
           GROUP by wg.GoodID";
        $Result = DB::select($Query);
        $Result = [
            'SrcTbl' => $Result,
            'Count' => count($Result),

        ];
        return $Result;
    }


    public function GetSoldProducts(string $startDate, string $endDate, $username)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }
        $Query = "SELECT
        sum(product_order_items.product_qty) as ProductSoldCount
    from
        product_orders
        INNER JOIN product_order_items on product_order_items.order_id = product_orders.id
    WHERE
        product_orders.status != 60
        and product_orders.status != 0
        and product_orders.id = product_orders.DeviceContract
        and product_orders.created_at >= '$startDate'
        and product_orders.created_at <= '$endDate'
        $Condition";

        $Result = DB::Select($Query);
        return $Result[0]->ProductSoldCount;
    }

    public function GetSoldProductsDetail(string $startDate, string $endDate, $username)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }
        $Query = "SELECT
       product_order_items.order_id,  product_order_items.product_id,product_order_items.product_qty,UserInfo.Name,UserInfo.Family,UserInfo.MobileNo,product_order_items.total_sales
    from
        product_orders
        INNER JOIN product_order_items on product_order_items.order_id = product_orders.id
        INNER JOIN UserInfo on UserInfo.UserName = product_orders.CustomerId
    WHERE
        product_orders.status != 60
        and product_orders.status != 0
        and product_orders.id = product_orders.DeviceContract
        and product_orders.created_at >= '$startDate'
        and product_orders.created_at <= '$endDate'
        $Condition";

        $Result = DB::Select($Query);
        return $Result;
    }

    public function GetReadyToSalesProducts(string $startDate, string $endDate, $username)
    {

        if ($username != null) {
            $Query = "SELECT warehouse_goods.GoodID , sum(warehouse_goods.QTY) as Qty , sum(warehouse_goods.Remian) as Remian , COUNT(*) as count  FROM `report_detials` INNER JOIN warehouse_goods on report_detials.ProductID = warehouse_goods.GoodID where report_detials.ReportType = '5' and report_detials.UserID = '$username' and warehouse_goods.created_at >= '$startDate' and warehouse_goods.created_at <= '$endDate' GROUP by warehouse_goods.GoodID ";
        } else {
            $Query = "SELECT GoodID , sum(QTY) as Qty , sum(Remian) as Remian , COUNT(*) as count from warehouse_goods  WHERE
            created_at >= '$startDate'
           and created_at <= '$endDate'
           GROUP by GoodID";
        }

        $Result = DB::Select($Query);
        $Result = [
            'SrcTbl' => $Result,
            'Count' => count($Result),

        ];
        return $Result;
    }

    public function GetCountOfWarehouse(string $startDate, string $endDate, $username)
    {
        if ($username != null) {
            return 0;
        }
        $Query = "SELECT  COUNT(*) as COUNT from warehouses WHERE created_at >= '$startDate' and created_at <= '$endDate'";
        $Result = DB::select($Query);
        return $Result[0]->COUNT;
    }
    public function GetDetailOfWarehouse(string $startDate, string $endDate, $username)
    {
        $array = [];
        if ($username != null) {
            return $array;
        }
        $Query = "SELECT  Name,phone,created_at from warehouses WHERE created_at >= '$startDate' and created_at <= '$endDate'";
        $Result = DB::select($Query);
        return $Result;
    }

    public function GetActiveWarehouse(string $startDate, string $endDate, $username)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and Operator = '$username'";
        }
        $Query = "SELECT
      COUNT(*) as count , warehouses.Name as WName , UserInfo.Name, UserInfo.Family, product_orders.id
 from
     product_orders
     inner join UserInfo on product_orders.CustomerId = UserInfo.UserName
     INNER JOIN product_order_items on product_order_items.order_id = product_orders.id
     INNER JOIN warehouse_goods on   product_order_items.pw_id = warehouse_goods.id
     INNER JOIN warehouses on  warehouses.id = warehouse_goods.WarehouseID
 WHERE
     product_orders.status != 60
     and product_orders.status != 0
     and product_orders.id = product_orders.DeviceContract
     and product_orders.created_at >= '$startDate'
     and product_orders.created_at <= '$endDate'
     $Condition
     GROUP BY warehouse_goods.WarehouseID";
        $Result = DB::Select($Query);
        $Result = [
            'SrcTbl' => $Result,
            'Count' => count($Result),

        ];
        return $Result;
    }

    /**
     * This function return users who has buy in defind date durations.
     *
     * @param string $startDate Example '2022-04-01'
     * @param string $endDate Example '2022-04-01'
     * @return array  Users with BuyNumer as SrcTbl and Count of  Active Users
     */
    public function GetActiveUsers(string $startDate, string $endDate, $username)
    {
        $Condition = '';
        if ($username != null) {
            $Condition .= "and product_orders.Operator = '$username'";
        }
        $Query = "SELECT UserInfo.Name,UserInfo.Family, product_orders.CustomerId ,product_orders.id, COUNT(*) as count,product_orders.total_sales
        from product_orders inner JOIN UserInfo on product_orders.CustomerId = UserInfo.UserName
        WHERE product_orders.status != 60 and product_orders.status != 0 and id = DeviceContract
        and product_orders.created_at >= '$startDate' and product_orders.created_at <= '$endDate'  $Condition GROUP by product_orders.CustomerId ";

        $Result = DB::Select($Query);

        $Result = [
            'SrcTbl' => $Result,
            'Count' => count($Result),

        ];

        return $Result;
    }

    /**
     * This function return count of users in specific date
     * @param string $startDate Example '2022-04-01'
     * @param string $endDate Example '2022-04-01'
     * @param integer $Role
     * @return void
     */
    public function GetCountOfUsers(string $startDate, string $endDate, $username, int $Role = null)
    {

        if ($username != null) {
            return 0;
        }
        $Query = "SELECT COUNT(*) as Count from UserInfo WHERE CreateDate >= '$startDate' and CreateDate <= '$endDate' ";
        $Resutl = DB::select($Query);
        return $Resutl[0]->Count;
    }
    public function GetDetailOfUsers(string $startDate, string $endDate, $username, int $Role = null)
    {
        $array = [];
        if ($username != null) {
            return $array;
        }
        $Query = "SELECT UserName,MobileNo,Name,Family,CreateDate from UserInfo WHERE CreateDate >= '$startDate' and CreateDate <= '$endDate' ";
        $Result = DB::Select($Query);
        return $Result;
    }

    // $MyPersian->MyPersianDate($Mydate,false,'m')
    //
    /**
     * Undocumented function
     * اول و آخر ماه میلادی وارد شده را به شمسی حساب می کند و خروجی را به میلادی تحویل می دهر
     * @param [type] $FirstFeildDate
     * @return array
     */
    private function get_first_end_date($FirstFeildDate)
    {
        $MyPersian = new persian;
        $year = date_format($FirstFeildDate, 'Y');
        $month = date_format($FirstFeildDate, 'm');
        $day = date_format($FirstFeildDate, 'd');
        $FirstFeildDate = $MyPersian->gregorian_to_jalali($year, $month, $day);
        $StartYear = $FirstFeildDate[0];
        $StartMonth = $FirstFeildDate[1];
        if ($StartMonth > 11) {
            $EndYear = $StartYear + 1;
            $EndMonth = 1;
        } else {
            $EndYear = $StartYear;
            $EndMonth = $StartMonth + 1;
        }
        $GrogorainStartDate = $MyPersian->jalali_to_gregorian($StartYear, $StartMonth, 1);
        $GrogorainStartDate = $GrogorainStartDate[0] . '-' . $GrogorainStartDate[1] . '-' . $GrogorainStartDate[2];
        $GrogorainEndDate = $MyPersian->jalali_to_gregorian($EndYear, $EndMonth, 1);
        $GrogorainEndDate = $GrogorainEndDate[0] . '-' . $GrogorainEndDate[1] . '-' . $GrogorainEndDate[2];
        $Output = [
            'Start' => $GrogorainStartDate,
            'End' => $GrogorainEndDate,
            'TY' => $StartYear, // persin Target Start Month
            'TM' => $StartMonth, // persin Target Start Month
        ];
        return $Output;
    }
    /**
     * get persian month start and end to gogorian date
     *
     * @param [type] $StartYear
     * @param [type] $StartMonth
     * @return array
     */
    private function get_first_end_Numberic($StartYear, $StartMonth)
    {
        $MyPersian = new persian;
        $day = 1;
        if ($StartMonth > 11) {
            $EndYear = $StartYear + 1;
            $EndMonth = 1;
        } else {
            $EndYear = $StartYear;
            $EndMonth = $StartMonth + 1;
        }
        $GrogorainStartDate = $MyPersian->jalali_to_gregorian($StartYear, $StartMonth, 1);
        $GrogorainStartDate = $GrogorainStartDate[0] . '-' . $GrogorainStartDate[1] . '-' . $GrogorainStartDate[2];
        $GrogorainEndDate = $MyPersian->jalali_to_gregorian($EndYear, $EndMonth, 1);
        $GrogorainEndDate = $GrogorainEndDate[0] . '-' . $GrogorainEndDate[1] . '-' . $GrogorainEndDate[2];
        $Output = [
            'Start' => $GrogorainStartDate,
            'End' => $GrogorainEndDate,
            'TY' => $StartYear, // persin Target Start Month
            'TM' => $StartMonth, // persin Target Start Month

        ];
        return $Output;
    }
    private function crete_user_statistic_table()
    {
        $MyPersian = new persian;
        $firstUser = UserInfo::orderBy('CreateDate')->first();
        $FirstFeildDate = $firstUser->CreateDate;
        $FirstFeildDate = $this->get_first_end_date($FirstFeildDate);
        $StartI = $FirstFeildDate['TM'] + 1 - 1;
        for ($i = $StartI; $i <= 12; $i++) {
            $FirstFeildDate = $this->get_first_end_Numberic($FirstFeildDate['TY'], $i);
            $UserCount = UserInfo::whereDate('CreateDate', '>=', $FirstFeildDate['Start'])->whereDate('CreateDate', '<', $FirstFeildDate['End'])->count();
            $XAxis = $MyPersian->PersianMonthToText($i) . '- ' . $FirstFeildDate['TY'];
            $YAxis = $UserCount;
            $StaticData = [
                'metakey' => 1,
                'axis_x' => $XAxis,
                'axis_y' => $YAxis,
                'extradata' => $FirstFeildDate['End'],
            ];

            anlytics::create($StaticData);
        }
    }
    private function make_user_statistic_table()
    {
        $lastAnalyticRow = anlytics::where('metakey', 1)->orderBy('id', 'DESC')->first();
        if ($lastAnalyticRow == null) { // hase not table yet
            $this->crete_user_statistic_table();
            return true;
        } else {
            //todo: update statistic table
            return true;
        }
    }

    public function get_user_statistic()
    {
        $this->make_user_statistic_table();
        return anlytics::where('metakey', 1)->orderBy('id', 'ASC')->get();
    }

    public function Product_Statistic($WorkCat = 1, $L1ID = 4, $L2ID = 32)
    {
        $Query = "SELECT  L3Work.Name , COUNT(*) as cc FROM product_view_with_indices
        INNER JOIN L3Work on product_view_with_indices.IndexID = L3Work.UID
        where product_view_with_indices.WorkCat = $WorkCat and product_view_with_indices.L1ID = $L1ID
        and product_view_with_indices.L2ID = $L2ID GROUP by L3Work.Name";
        return DB::select($Query);
    }
    public function create_store_statistic_table()
    {

        $MyPersian = new persian;
        $firstStore = warehouse::orderBy('created_at')->first();
        $FirstFeildDate = $firstStore->created_at;
        $FirstFeildDate = $this->get_first_end_date($FirstFeildDate);
        $StartI = $FirstFeildDate['TM'] + 1 - 1;
        for ($i = $StartI; $i <= 12; $i++) {
            $FirstFeildDate = $this->get_first_end_Numberic($FirstFeildDate['TY'], $i);
            $FirstFeildDateStart = $FirstFeildDate["Start"];
            $FirstFeildDateEnd = $FirstFeildDate["End"];

            $Storecount = DB::table('stores')->join('warehouses', 'stores.id', '=', 'warehouses.StoreID')->whereDate('CreateDate', '>=', $FirstFeildDate['Start'])->whereDate('CreateDate', '<', $FirstFeildDate['End'])->count();
            $XAxis = $MyPersian->PersianMonthToText($i) . '- ' . $FirstFeildDate['TY'];

            $YAxis = $Storecount;

            $StaticData = [
                'metakey' => 2,
                'axis_x' => $XAxis,
                'axis_y' => $YAxis,
                'extradata' => $FirstFeildDate['End'],
            ];

            anlytics::create($StaticData);
        }
    }

    public function get_store_statistics()
    {

        $this->create_store_statistic_table();
        return anlytics::where('metakey', 2)->orderBy('id', 'ASC')->get();
    }
}
