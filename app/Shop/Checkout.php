<?php

namespace App\Shop;

use App\Functions\CacheData;
use App\Functions\Orders;
use App\Functions\TashimClass;
use App\Http\Controllers\Credit\Tashim;
use App\Http\Controllers\woocommerce\ProductClass;
use App\Models\branchs_order;
use App\Models\citys;
use App\Models\goods;
use App\Models\locations;
use App\Models\product_order;
use App\Models\product_order_items;
use App\Models\provinces;
use App\Models\UserInfo;
use App\Models\warehouse_goods;
use App\myappenv;
use Illuminate\Support\Arr;
use Auth;
use Session;
use DB;

class Checkout
{
    private $UserName;
    private $UserInfoSrc = null;
    private $ProductOrderId;
    private $order_attr;
    private $tashim_arr = [];
    private $wallet_arr = [];
    private $buyer;
    private $Seller;
    private $Owner;
    private $Marketer;
    public function __construct(array $constract_attr)
    {
        if (isset($constract_attr['UserName'])) {
            $this->UserName = $constract_attr['UserName'];
        } else {
            $this->UserName = Auth::id();
        }
    }
    private function get_user_info()
    {
        if ($this->UserInfoSrc == null) {
            $this->UserInfoSrc = UserInfo::where('UserName', $this->UserName)->first();
        }
        return $this->UserInfoSrc;
    }
    private function product_order_id_setter($ProductOrderId)
    {
        $this->ProductOrderId = $ProductOrderId;
    }
    private function product_order_id_getter()
    {
        return $this->ProductOrderId;
    }
    public function AddWallet($ProductAttr, $TashimTarget)
    {
        $tashim = new Tashim;
        $TargetWarehouse = $ProductAttr['TargetWarehouse'];
        $SaleMony = $ProductAttr['SaleMony'];
        $BuyMony = $ProductAttr['BuyMony'];
        $ProductId = $ProductAttr['ProductId'];
        $PwID = $ProductAttr['PwID'];
        $TaxMony = $ProductAttr['TaxMony'];
        if ($TashimTarget == null) {
            $hasTashim = false;
        } else {
            $hasTashim = true;
        }
        $Query = "SELECT s.Owner FROM warehouses as w INNER JOIN stores as s ON w.StoreID = s.id WHERE w.id = $TargetWarehouse ";
        $Result = DB::select($Query);
        foreach ($Result as $ResultItem) {
            $Seller = $ResultItem->Owner;
        }
        $ProductSrc = warehouse_goods::where('id', $PwID)->first();
        if ($ProductSrc->owner == null) {
            $Owner = $Seller;
        } else {
            $Owner = $ProductSrc->owner;
        }
        $DeleverMony = 0; //TODO: handle delivery function

        $buyer = $this->UserName;
        $this->buyer = $buyer;

        $Daramad = myappenv::StackHolder;
        $Marketer = 'marketer';
        if ($hasTashim) {
            $ProductAttr = [
                'ProductId' => $ProductId,
                'PwID' => $PwID,
                'TashimID' => $TashimTarget,
            ];
            $MonyAttr = [
                'SaleMony' => $SaleMony,
                'BuyMony' => $BuyMony,
                'DeleverMony' => $DeleverMony,
                'TaxMony' => $TaxMony,
            ];
            $this->Seller = $Seller;
            $this->Owner = $Owner;
            $this->Marketer = '';
            $Result = $tashim->ExecTashim($ProductAttr, $MonyAttr);
            foreach ($Result as $ResultItem) {
                array_push($this->wallet_arr, $ResultItem);
            }
        } else { // فروش نقدی
            $Result = $tashim->ExecNaghd($ProductId, $PwID, $SaleMony, $BuyMony, $DeleverMony, $buyer, $Seller, $Daramad, $Marketer);

            foreach ($Result as $ResultItem) {
                array_push($this->wallet_arr, $ResultItem);
            }
        }
    }
    private function get_order_item_tashim($ProductId)
    {
        if ($this->tashim_arr == []) {
            // if  tashim not exist
            if (myappenv::tashim == 'main') {
                return CacheData::GetSetting('DefultTashim');
            } else {
                return null;
            }
        }

        foreach ($this->tashim_arr as $ProductTashimItem) {
            if ($ProductId == $ProductTashimItem->ProductId) {
                return $ProductTashimItem->Tashim;
            }
        }
        return null;
    }

    private function add_new_user_location(array $location_attr)
    {
        $SaharestanID = $location_attr['Shahrestan'];
        $ProvinceID = $location_attr['Province'];
        $recivername = $location_attr['recivername'];
        $reciverphone = $location_attr['reciverphone'];
        $LocationName = $location_attr['LocationName'];
        $OthersAddress = $location_attr['OthersAddress'];
        $PostalCode = $location_attr['PostalCode'];
        $ExtraNote = $location_attr['ExtraNote'];
        $Street = $location_attr['Street'];
        $Pelak = $location_attr['Pelak'];


        $CityName = citys::where('id', $SaharestanID)->first();
        if ($CityName == null) {
            $CityName = 'شهر یافت نشد';
        } else {
            $CityName = $CityName->CityName;
        }
        $ProvinceName = provinces::where('id', $ProvinceID)->first();
        if ($ProvinceName == null) {
            $ProvinceName = 'استان یافت نشد';
        } else {
            $ProvinceName = $ProvinceName->ProvinceName;
        }

        $UserInfoSrc = $this->get_user_info();
        if ($recivername == null) { //not define reciver name
            $recivername = $UserInfoSrc->Name . ' ' . $UserInfoSrc->Family;
        }
        if ($reciverphone == null) {
            $reciverphone = $UserInfoSrc->MobileNo;
        }
        $LocationData = [
            'Owner' => $this->UserName,
            'name' => $LocationName,
            'Province' => $ProvinceName,
            'ProvinceID' => $ProvinceID,
            'City' => $CityName,
            'CityID' => $SaharestanID,
            'Street' => $Street,
            'OthersAddress' => $OthersAddress,
            'Pelak' => $Pelak,
            'PostalCode' => $PostalCode,
            'ExtraNote' => $ExtraNote,
            'recivername' => $recivername,
            'reciverphone' => $reciverphone,
        ];

        $Result = locations::create($LocationData);
        return $Result->id;
    }
    private function set_user_location(array $location_attr, int $location_type)
    {

        if ($location_type == 0) {
            // Add new location on finalize Order
            return  $this->add_new_user_location($location_attr);
        } else {
            return $location_type;
        }
    }
    private function create_product_order_base($target_location)
    {
        $OrderPreData = [
            'status' => 0,
            'ReturnCustomerId' => $this->UserName,
            'CustomerId' => $this->UserName,
            'SendLocation' => $target_location,
            'ReturnLocation' => $target_location,
            'status_history' => ''
        ];
        try {

            $ProductOrderInsertResult = product_order::create($OrderPreData);
            $this->product_order_id_setter($ProductOrderInsertResult->id);
            return [
                'result' => true
            ];
        } catch (\Exception $e) {

            return [
                'result' => false,
                'msg' => 'cannot create order base'
            ];
        }
    }
    private function GetProductBranch($ProductId, $withBranchOwner)
    {

        $Query = "SELECT b.id as BrachID, b.UserName as UserName from branches as b INNER JOIN stores as s on b.id = s.branch INNER JOIN warehouses as w on w.StoreID = s.id INNER JOIN warehouse_goods wg on wg.WarehouseID = w.id WHERE wg.GoodID = $ProductId";
        $Result = DB::select($Query);
        if ($withBranchOwner == true) {
            return $Result;
        } else {
            foreach ($Result as $ResultItem) {
                return $ResultItem->BrachID;
            }
        }
    }
    private function add_product_order_items($ProductOrderArr)
    {
        $num_items_sold = 0;
        $total_sales_G = 0;
        $tax_total_G = 0;
        $customer_benefit_total_G = 0;
        $SubItem = 0;
        $net_total_G = 0;
        $TotallWeight = 0;
        $topay = 0;
        $tax_total = 0;
        $branches = array();
        foreach ($ProductOrderArr as $ProductOrderItem) {
            $num_items_sold++;
            $product_id = $ProductOrderItem['product_id'];
            $product_qty = $ProductOrderItem['product_qty'];
            $ProductWarehouseID = $ProductOrderItem['warehouse_id'];
            $ProductTarget = warehouse_goods::where('id', $ProductWarehouseID)->where('OnSale', 1)->first(); // product in warehouse
            $ProductSourceTarget = goods::where('id', $product_id)->first(); // Main Product
            $ItemWeight = $ProductSourceTarget->weight * $product_qty;
            $TotallWeight += $ItemWeight;
            if ($ProductTarget == null) {
                return [
                    'result' => false,
                    'msg' => 'product is no in target warehouse'
                ];
            }
            if ($ProductTarget->BasePrice == 0) {
                $unit_Price = $ProductTarget->Price; // without sale
            } else {
                $unit_Price = $ProductTarget->BasePrice;
            }
            $ProductOrderId = $this->product_order_id_getter();
            if (myappenv::Lic['MultiBranch']) {
                $TargetBranch = $this->GetProductBranch($product_id, false);
                if (!in_array($TargetBranch, $branches)) {
                    array_push($branches, $TargetBranch);
                    $BranchData = [
                        'branch' => $TargetBranch,
                        'order_status' => 0,
                        'order_id' => $ProductOrderId,
                    ];
                    branchs_order::create($BranchData);
                }
            } else {
                $TargetBranch = myappenv::Branch;
                if (!in_array($TargetBranch, $branches)) {
                    array_push($branches, $TargetBranch);
                    $BranchData = [
                        'branch' => $TargetBranch,
                        'order_status' => 0,
                        'order_id' => $ProductOrderId,
                    ];
                    branchs_order::create($BranchData);
                }
            }
            if (myappenv::tashim == 'main') {
                $tashim = new TashimClass;
                $TashimId = $this->get_order_item_tashim($product_id);
                if ($TashimId == null) {
                    $TashimId = CacheData::GetSetting('DefultTashim');
                }
                $ProductPriceAttr = [
                    'ProductPrice' => $ProductTarget->Price,
                    'tax_status' => $ProductSourceTarget->tax_status,
                ];
                $ProductPriceArr = $tashim->get_sale_price_with_tashim($ProductPriceAttr, $TashimId);
                $ProductPrice = abs($ProductPriceArr['PriceWithTax']) - abs($ProductPriceArr['TaxPrice']);
                $total_sales = $ProductPrice * $product_qty;
                $With_tax = $ProductPriceArr['PriceWithTax'] * $product_qty;
                $tax_total = $ProductPriceArr['TaxPrice'] * $product_qty;
                $total_sales_G += abs($total_sales);
                $tax_total_G += abs($tax_total);
                $topay += abs($total_sales);
                $customer_benefit_total = ($unit_Price * $product_qty) - ($ProductPrice * $product_qty);
                $customer_benefit_total_G += $customer_benefit_total;
            } else {
                $ProductPrice = $ProductTarget->Price;
                $total_sales = $ProductPrice * $product_qty;
                $With_tax = ProductClass::GetTargetPrice($total_sales, $ProductSourceTarget->tax_status);
                $tax_total = $With_tax - $total_sales; //todo fill when tax added
                $total_sales_G += abs($total_sales);
                $tax_total_G += abs($tax_total);
                $topay += abs($total_sales);
                $customer_benefit_total = ($unit_Price * $product_qty) - ($ProductPrice * $product_qty);
                $customer_benefit_total_G += $customer_benefit_total;
            }

            if (!is_int((int) $product_qty)) {
                return abort('404', 'مشکل امنیتی کد : ۱۴۸۳ ');
            }
            if ($product_qty < 1) {
                return abort('404', 'مشکل امنیتی کد : ۱۴۸۴ ');
            }
            $net_total = ($ProductTarget->Price - $ProductTarget->BuyPrice) * $product_qty;
            $net_total_G += $net_total;
            $MainDeviceOrderID = null;
            if ($ProductTarget->MinPrice != 0) { // Estelam
                $MainDeviceOrderID = $this->GetDeviceOrder();
                $TargetBranchsrc = branches::where('id', $TargetBranch)->first();
                $DataToSave = [
                    'ContractNumber' => $MainDeviceOrderID,
                    'SubItem' => $SubItem++,
                    'Device' => $ProductWarehouseID,
                    'product_qty' => $product_qty,
                    'product_id' => $product_id,
                    'customer_id' => $this->UserName,
                    'Ownerbranch' => $TargetBranch,
                    'Owner' => $TargetBranchsrc->UserName,
                ];
                DeviceItemInternal::create($DataToSave);
            } else {
                if (!is_int((int) $product_qty)) {
                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۵ ');
                }
                if ($product_qty < 1) {
                    return abort('404', 'مشکل امنیتی کد : ۱۴۸۶ ');
                }
                if (myappenv::tashim == '') {
                    $TashimId = 0;
                }
                $ProductItemData = [
                    'order_id' => $ProductOrderId,
                    'product_id' => $product_id,
                    'pw_id' => $ProductWarehouseID,
                    'product_qty' => $product_qty,
                    'Tashim' => $TashimId,
                    'customer_id' => $this->UserName,
                    'unit_Price' => $ProductTarget->Price,
                    'main_unit_price' => $ProductTarget->BasePrice,
                    'unit_sales' => $ProductPrice,
                    'total_sales' => $total_sales,
                    'tax_total' => $tax_total,
                    'customer_benefit_total' => $customer_benefit_total,
                    'shipping_amount' => 0,
                    'weight' => $ItemWeight,
                    'net_total' => $net_total,
                    'branch' => $TargetBranch,
                ];
                product_order_items::create($ProductItemData);
                $total_sales = $ProductTarget->Price * $product_qty;
                $totall_buy = $ProductTarget->BuyPrice * $product_qty;
                $ProductAttr = [
                    'TargetWarehouse' => $ProductTarget->WarehouseID,
                    'SaleMony' => $total_sales,
                    'BuyMony' => $totall_buy,
                    'TaxMony' => $tax_total,
                    'ProductId' => $product_id,
                    'PwID' => $ProductWarehouseID,
                ];
                $this->AddWallet($ProductAttr, $TashimId);
            }
        }
        $this->order_attr =  [
            'num_items_sold' => $num_items_sold,
            'total_sales' => $total_sales_G,
            'tax_total' => $tax_total_G,
            'customer_benefit_total' => $customer_benefit_total_G,
            'shipping_total' => 0,
            'net_total' => $net_total_G,
            'TotallWeight' => $TotallWeight,
            'DeviceContract' => $MainDeviceOrderID,
        ];
    }

    private function set_product_order_Shipping_type()
    {
    }

    private function order_logging_base()
    {
    }

    private function order_payment()
    {
    }

    private function order_finalize()
    {
        $product_order_id = $this->product_order_id_getter();
        try {
            product_order::where('id', $product_order_id)->update($this->order_attr);
            return [
                'result' => true
            ];
        } catch (\Exception $e) {

            return [
                'result' => false,
                'msg' => 'error in finalize order'
            ];
        }
    }

    public function main($request)
    {

        /* The above code is declaring a variable named  in PHP. However, it is not
        assigning any value to the variable. 
        if $location_type = 0 new location added by user
        else send product to old registered location
        */
        $location_type = $request['Location'];
        if ($location_type == 0) {
            $location_attr = [
                'Shahrestan' => $request['Shahrestan'],
                'Province' => $request['Province'],
                'recivername' => $request['recivername'],
                'reciverphone' => $request['reciverphone'],
                'LocationName' => $request['LocationName'],
                'Street' => $request['Street'],
                'OthersAddress' => $request['OthersAddress'],
                'Pelak' => $request['Pelak'],
                'PostalCode' => $request['PostalCode'],
                'ExtraNote' => $request['ExtraNote'],
            ];
        } else {
            $location_attr = [];
        }

        $target_location = $this->set_user_location($location_attr, $location_type);
        $Result =  $this->create_product_order_base($target_location);
        if ($Result['result']) {
            $this->add_product_order_items($request['basket']);
            $finalize = $this->order_finalize();
            if ($finalize['result']) {
                $tashim_class = new TashimClass;
                if ($tashim_class->IsValidTashim($this->UserName, $this->wallet_arr,$this->tashim_arr)) {
                    $payType = 1;
                    if ($payType == 'bank') {
                        echo '1' . PHP_EOL;
                    } elseif ($payType == 2) {
                        return '2'. PHP_EOL;
                    } elseif ($payType == 1) {
                        return '3'. PHP_EOL;
                    }
                }
            } else {
                return $Result;
            }
        } else {
            return $Result;
        }
    }
}
