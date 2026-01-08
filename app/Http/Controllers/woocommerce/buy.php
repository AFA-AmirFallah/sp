<?php

namespace App\Http\Controllers\woocommerce;

use App\Functions\Images;
use App\Functions\Orders;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Credit\currency;
use App\Models\branchs_order;
use App\Models\citys;
use App\Models\goods;
use App\Models\locations;
use App\Models\product_order;
use App\Models\product_order_items;
use App\Models\provinces;
use App\Models\warehouse_goods;
use App\myappenv;
use App\PEP\RSAKeyType;
use App\PEP\RSAProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class buy extends Controller
{
    public static function get_user_buy_history($username)
    {
        $Query = "SELECT po.*,ui.Name as customername, ui.Family as customerfamily from product_orders po inner join UserInfo ui on po.CustomerId = ui.UserName
        INNER JOIN branchs_orders AS bo ON bo.order_id = po.id  WHERE ui.UserName = '$username' and  po.status > 0 AND po.status < 100 ORDER BY po.id DESC";
        return DB::select($Query);
    }
    public static function get_user_buy_address($username)
    {
        $user_locations = locations::where('Owner', $username)->get();
        return $user_locations;
    }
    public function SpecialAccount()
    {
        $Carrency = new currency();
        $MyProduct = new product();
        $Goods = $MyProduct->GetProducts(null, null, true, null, 'SpecialAccount');
        return view('Users.BuyAccount', ['Carrency' => $Carrency, 'Goods' => $Goods]);
    }
    public function IsValidProduct($pw_id)
    {
        /**
         * check new pwid is same buy type by other basket items or not
         */
        $BasketItem = Session::get('basket');
        if ($BasketItem == null) { // basket is empty
            return true;
        } else { // basket already has product
            $SessionArray = json_decode($BasketItem);
            $BasketType = 'normal';
            foreach ($SessionArray as $SessionArrayItem) {
                $PWID = $SessionArrayItem[2];
                //todo: change procedure to store type of order in session
                $ProductTargetInWarehouse = warehouse_goods::where('id', $PWID)->first();
                if ($ProductTargetInWarehouse->MinPrice > 0) {
                    $BasketType = 'Estelam';
                    break;
                } else {
                    $BasketType = 'normal';
                    break;
                }
            }
        }

        $ProductTargetInWarehouse = warehouse_goods::where('id', $pw_id)->first();
        if ($ProductTargetInWarehouse->MinPrice > 0) {
            if ($BasketType == 'Estelam') {
                return true;
            } else {
                return false;
            }
        } else {
            if ($BasketType == 'normal') {
                return true;
            } else {
                return false;
            }
        }
    }
    public function GetPEPHTML($Price)
    {
        $ResNum = 1;             // Invoice Number
        $Certificate = myappenv::PEPPrivate;
        $processor = new RSAProcessor($Certificate, RSAKeyType::XMLString);
        $merchantCode = myappenv::PEPMerchantCode; // كد پذيرنده
        $terminalCode = myappenv::PEPTerminalCode; // كد ترمينال
        $amount = $Price; // مبلغ فاكتور
        $redirectAddress = route('peppay');
        $invoiceNumber = 0; //شماره فاكتور
        $redirectAddress = route('checkout', ['pay' => 'pep', 'ref' => $invoiceNumber]);
        $timeStamp = date("Y/m/d H:i:s");
        $invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
        $action = "1003";    // 1003 : براي درخواست خريد
        $Mobile = Auth::user()->MobileNo;
        $data = "#" . $merchantCode . "#" . $terminalCode . "#" . $invoiceNumber . "#" . $invoiceDate . "#" . $amount . "#" . $redirectAddress . "#" . $action . "#" . $timeStamp . "#";
        $data = sha1($data, true);
        $data = $processor->sign($data); // امضاي ديجيتال
        $result = base64_encode($data); // base64_encode
        $Output = "<input class='nested' type='text' name='invoiceNumber' value='1' />
        <input class='nested' type='text' name='invoiceDate' value='$invoiceDate' />
        <input class='nested' type='text' name='amount' value='$Price' />
        <input class='nested' type='text' name='terminalCode' value='$terminalCode' />
        <input class='nested' type='text' name='merchantCode' value='$merchantCode' />
        <input class='nested' type='text' name='redirectAddress' value='$redirectAddress' />
        <input class='nested' type='text' name='timeStamp' value='$timeStamp' />
        <input class='nested' name='mobile' value='$Mobile' />
        <input class='nested' type='text' name='action' value='$action' />
        <input class='nested' type='text' name='sign' value='$result' />";
        return $Output;
    }
    public function DoSpecialAccount(Request $request)
    {
        $OrderPreData = [
            'status' => 0,
            'ReturnCustomerId' => Auth::id(),
            'CustomerId' => Auth::id(),
            'SendLocation' => 0,
            'ReturnLocation' => 0,
        ];
        $ProductOrderInsertResult = product_order::create($OrderPreData);
        $ProductOrderInsertResult = product_order::create($OrderPreData);
        $ProductOrderId = $ProductOrderInsertResult->id;
        $num_items_sold = 0;
        $total_sales_G = 0;
        $tax_total_G = 0;
        $customer_benefit_total_G = 0;
        $shipping_total_G = 0;
        $net_total_G = 0;
        $TotallWeight = 0;
        $branches = array();
        $num_items_sold++;
        $product_id = $request->input('pay');
        $product_qty = 1;
        $ProductTarget = warehouse_goods::where('GoodID', $product_id)->where('OnSale', 1)->first();
        $pw_id = $ProductTarget->id;
        $ProductSourceTarget = goods::where('id', $product_id)->first();
        $ItemWeight = $ProductSourceTarget->weight * $product_qty;
        $TotallWeight += $ItemWeight;
        if ($ProductTarget == null) {
            return abort('404');
        }
        if ($ProductTarget->BasePrice == 0) {
            $unit_Price = $ProductTarget->Price; // without sale
        } else {
            $unit_Price = $ProductTarget->BasePrice;
        }
        $unit_sales = $ProductTarget->Price;
        $TargetBranch = myappenv::Branch;
        $total_sales = $unit_sales * $product_qty;
        $total_sales_G += $total_sales;
        $tax_total = 0; //todo fill when tax added
        $tax_total_G += $tax_total;
        $customer_benefit_total = ($unit_Price * $product_qty) - $total_sales;
        $customer_benefit_total_G += $customer_benefit_total;
        $shipping_amount = 0;
        $shipping_total_G += $shipping_amount;
        $net_total = ($ProductTarget->Price - $ProductTarget->BuyPrice) * $product_qty;
        $net_total_G += $net_total;
        $ProductItemData = [
            'order_id' => $ProductOrderId,
            'product_id' => $product_id,
            'product_qty' => $product_qty,
            'customer_id' => Auth::id(),
            'unit_Price' => $unit_Price,
            'unit_sales' => $unit_sales,
            'total_sales' => $total_sales,
            'tax_total' => $tax_total,
            'customer_benefit_total' => $customer_benefit_total,
            'shipping_amount' => $shipping_amount,
            'weight' => $ItemWeight,
            'net_total' => $net_total,
            'pw_id' => $pw_id,
            'branch' => $TargetBranch
        ];
        product_order_items::create($ProductItemData);
        $OrderPostData = [
            'num_items_sold' => $num_items_sold,
            'total_sales' => $total_sales_G,
            'tax_total' => $tax_total_G,
            'customer_benefit_total' => $customer_benefit_total_G,
            'shipping_total' => $shipping_total_G,
            'net_total' => $net_total_G,
            'TotallWeight' => $TotallWeight,
        ];
        $InsertResult = product_order::where('id', $ProductOrderId)->update($OrderPostData);
        $TargetBranch = myappenv::Branch;
        if (!in_array($TargetBranch, $branches)) {
            array_push($branches, $TargetBranch);
            $BranchData = [
                'branch' => $TargetBranch,
                'order_status' => 0,
                'order_id' => $ProductOrderId
            ];
            branchs_order::create($BranchData);
        }

        $price = $request->input('price');         // Price Rial
        $ResNum = $ProductOrderId;
        // Invoice Number
        Session::put('price', $price);
        Session::put('ResNum', $ResNum);
        $Certificate = myappenv::PEPPrivate;
        $processor = new RSAProcessor($Certificate, RSAKeyType::XMLString);
        $merchantCode = myappenv::PEPMerchantCode; // كد پذيرنده
        $terminalCode = myappenv::PEPTerminalCode; // كد ترمينال
        $amount = $price; // مبلغ فاكتور
        $redirectAddress = route('peppay');
        $invoiceNumber = $ResNum; //شماره فاكتور
        $redirectAddress = route('checkout', ['pay' => 'pep', 'ref' => $invoiceNumber]);
        $timeStamp = date("Y/m/d H:i:s");
        $invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
        $action = "1003";    // 1003 : براي درخواست خريد
        $Mobile = Auth::user()->MobileNo;
        $data = "#" . $merchantCode . "#" . $terminalCode . "#" . $invoiceNumber . "#" . $invoiceDate . "#" . $amount . "#" . $redirectAddress . "#" . $action . "#" . $timeStamp . "#";
        $data = sha1($data, true);
        $data = $processor->sign($data); // امضاي ديجيتال
        $result = base64_encode($data); // base64_encode
        echo "<form id='peppeyment' action='https://pep.shaparak.ir/gateway.aspx' method='post'>
        <input  type='text' name='invoiceNumber' value='$invoiceNumber' /><br />
        <input  type='text' name='invoiceDate' value='$invoiceDate' /><br />
        <input  type='text' name='amount' value='$amount' /><br />
        <input  type='text' name='terminalCode' value='$terminalCode' /><br />
        <input  type='text' name='merchantCode' value='$merchantCode' /><br />
        <input  type='text' name='redirectAddress' value='$redirectAddress' /><br />
        <input  type='text' name='timeStamp' value='$timeStamp' /><br />
        <input  name='mobile' value='$Mobile' /><br />
        <input  type='text' name='action' value='$action' /><br />
        <input  type='text' name='sign' value='$result' /><br />
        </form><script>document.forms['peppeyment'].submit()</script>";
    }
    public function addlocation()
    {
        $Provinces = provinces::all();
        $UserLocations = null;
        $UserLocations = locations::all()->where("Owner", Auth::id())->where('Status', 1);
        return view('Site.wolmart.AddLocation', ['page' => 'ProductList', 'Provinces' => $Provinces, 'UserLocations' => $UserLocations]);
    }
    public function Doaddlocation(Request $request)
    {
        if ($request->input('submit') == 'addaddress') {
            $CityName = citys::where('id', $request->input('Saharestan'))->first();
            $CityName = $CityName->CityName;
            $ProvinceName = provinces::where('id', $request->input('Province'))->first();
            $ProvinceName = $ProvinceName->ProvinceName;
            $LocationData = [
                'Owner' => Auth::id(),
                'name' => $request->input('LocationName'),
                'Province' => $ProvinceName,
                'ProvinceID' => $request->input('Province'),
                'recivername' => $request->input('Province'),
                'reciverphone' => $request->input('reciverphone'),
                'City' => $CityName,
                'CityID' => $request->input('Saharestan'),
                'Street' => $request->input('Street'),
                'OthersAddress' => $request->input('OthersAddress'),
                'Pelak' => $request->input('Pelak'),
                'PostalCode' => $request->input('PostalCode'),
                'ExtraNote' => $request->input('ExtraNote'),
            ];
            $Result = locations::create($LocationData);
            return redirect()->route('checkout')->with('success', 'آدرس جدید به سیستم افزوده شد!');
        } elseif ($request->input('submit') == 'deleteaddress') {
            locations::where("Owner", Auth::id())->where('id', $request->input('locationid'))->delete();
            return redirect()->back()->with('success', 'آدرس مورد نظر حذف گردید!');
        }
    }
    public static function BuyBenefit()
    { // use in app to dipaly buy benefit to users
        $benefit = Session::get('benefit');
        if ($benefit == null) {
            Session::put('benefit', 0);
            return 0;
        } else {
            return $benefit;
        }
    }
    public static function BasketItems()
    {
        $BasketItem = Session::get('basket');
        if ($BasketItem == null) {
            return $BasketItem;
        } else {
            $SessionArray = json_decode(Session::get('basket'));
            $RowCount = count($SessionArray);
            return $RowCount;
        }
    }
    public static function BasketItemsStepper()
    {
        $BasketItem = Session::get('basket');
        if ($BasketItem == null) {
            return $BasketItem;
        } else {
            $SessionArray = json_decode(Session::get('basket'));
            $Count = 0;
            foreach ($SessionArray as $SessionItem) {
                $Count += $SessionItem[1];
            }
            return $Count;
        }
    }
    public static function IsProductInBasket($ProductId)
    {
        $MyOrder = json_decode(Session::get('basket'));
        if ($MyOrder == null) {
            return null;
        }
        foreach ($MyOrder as $MyOrderTarget) {

            if ($MyOrderTarget[0] == $ProductId) {
                return true;
            }
        }
        return false;
    }
    public static function BasketItemsDetails()
    {
        $MyOrder = json_decode(Session::get('basket'));
        if (empty($MyOrder)) {
            return null;
        }
        $TotalPrice = 0;
        $TotalWight = 0;
        $OrderDetials = array();
        foreach ($MyOrder as $MyOrderTarget) {
            $Product = goods::where('id', $MyOrderTarget[0])->first();
            $ProductQty = $MyOrderTarget[1];
            $ProductInWarehouse = warehouse_goods::where('GoodID', $MyOrderTarget[0])->first();
            $TotalPrice += intval($ProductInWarehouse->Price) * intval($ProductQty);
            $TotalWight += intval($Product->weight) * intval($ProductQty);
            array_push($OrderDetials, ['TotalWight' => $TotalWight, 'Product' => $Product, 'ProductQty' => $ProductQty, 'ProductInWarehouse' => $ProductInWarehouse]);
        }
        return $OrderDetials;
    }
    public static function GetBasketItemsBrif($retun_type = 'php')
    {

        $MYProduct = new ProductClass();
        $MyOrder = json_decode(Session::get('basket'));
        if (empty($MyOrder)) {
            return [];
        }
        $OrderDetials = array();
        $myproduct = new product;
        foreach ($MyOrder as $MyOrderTarget) {

            $Product = goods::where('id', $MyOrderTarget[0])->first();
            $ProductQty = $MyOrderTarget[1];

            $ProductInWarehouse = warehouse_goods::where('GoodID', $MyOrderTarget[0])->first();
            $Remian = $ProductInWarehouse->Remian;

            $tax_status = $Product->tax_status ?? 0;
            if ($ProductInWarehouse->PricePlan != null) {
                $product_price = $myproduct->GetTargetPriceFromPricePlanJson($ProductInWarehouse->PricePlan, $ProductQty);
                //$TotallBasePrice = $ProductInWarehouse->BasePrice * $ProductQty;

            } else {
                $product_price = $ProductInWarehouse->Price;
            }
            $Price = ProductClass::GetTargetPrice($product_price, $tax_status);
            $BasePrice = ProductClass::GetTargetPrice($ProductInWarehouse->BasePrice, $tax_status);

            $MyProduct = new Orders;

            $TashimRes = $MyProduct->TashimBlade($MyOrderTarget[0], $Price, $tax_status);



            array_push($OrderDetials, ['TashimRes' => $TashimRes, 'id' => $Product->id, 'Name' => $Product->NameFa, 'tax_status' => $tax_status, 'Qty' => $ProductQty, 'Remian' => $Remian, 'Pic' => Images::GetPicture($Product->ImgURL, 1), 'Price' => $Price, 'BasePrice' => $BasePrice, 'MYProduct' => $MYProduct, 'weight' => $Product->weight ?? 0]);
        }
        $site_theme = myappenv::ShopTheme;
        if ($site_theme == 'Theme5') {
            return $OrderDetials;
        }

        return view("Layouts.$site_theme.objects.RightCheckout", ['OrderDetials' => $OrderDetials])->render();
        return response()->json($OrderDetials);
    }
    public function RemoveAllFromBasket()
    {

        Session::put('basket', null);
        return true;
    }
    public function RemoveOldGoodFromBasket($ProductID)
    {

        $BasketItem = Session::get('basket');
        $SessionArray = json_decode($BasketItem);
        if ($SessionArray == null) {
            $SessionArray = [];
        }
        $ProductClass = new product();
        $NewArray = array();
        foreach ($SessionArray as $SessionArrayItem) {
            if ($SessionArrayItem[0] != $ProductID) {
                array_push($NewArray, [$SessionArrayItem[0], $SessionArrayItem[1], $SessionArrayItem[2]]);
            } else {
                $Benefit = $ProductClass->GetBenefitOfBuyItem($SessionArrayItem[0], $SessionArrayItem[1], $SessionArrayItem[2]);
                $OldBenefit = Session::get('benefit');
                Session::put('benefit', $OldBenefit - $Benefit);
            }
        }
        Session::put('basket', json_encode($NewArray));
        $Output = [
            'result' => true,
            'data' => count($NewArray)
        ];
        return $Output;
    }
    public function RemoveGoodFromBasket($ProductID)
    {

        $BasketItem = Session::get('basket');
        $SessionArray = json_decode($BasketItem);
        if ($SessionArray == null) {
            $SessionArray = [];
        }
        $ProductClass = new product();
        $NewArray = array();

        if (sizeof($SessionArray) == 1 || sizeof($SessionArray) == 0) {
            Session::put('basket', null);

            $Output = [
                'result' => false
            ];
            return $Output;
        } else {
            foreach ($SessionArray as $SessionArrayItem) {
                if ($SessionArrayItem[0] != $ProductID) {
                    array_push($NewArray, [$SessionArrayItem[0], $SessionArrayItem[1], $SessionArrayItem[2]]);
                } else {
                    $Benefit = $ProductClass->GetBenefitOfBuyItem($SessionArrayItem[0], $SessionArrayItem[1], $SessionArrayItem[2]);
                    $OldBenefit = Session::get('benefit');
                    Session::put('benefit', $OldBenefit - $Benefit);
                }
            }
            Session::put('basket', json_encode($NewArray));
            $Output = [
                'result' => true,
                'data' => count($NewArray)
            ];
            return $Output;
        }
    }
    public function AddToBasket($ProductID, $Qty, $pw_id)
    {
        $BasketItem = Session::get('basket');
        if ($BasketItem == null) {
            $SessionArray = array();
            array_push($SessionArray, [$ProductID, $Qty, $pw_id]);
            Session::put('basket', json_encode($SessionArray));
            return 1;
        } else {
            $SessionArray = json_decode($BasketItem);
            array_push($SessionArray, [$ProductID, $Qty, $pw_id]);
            Session::put('basket', json_encode($SessionArray));
            $RowCount = count($SessionArray);
            return $RowCount;
        }
    }
    public function AddToBasketStepper($ProductID, $Qty, $pw_id)
    {
        $BasketItem = Session::get('basket');
        if ($BasketItem == null) {
            $SessionArray = array();
            array_push($SessionArray, [$ProductID, $Qty, $pw_id]);
            Session::put('basket', json_encode($SessionArray));
            return 1;
        } else {
            $SessionArray = json_decode($BasketItem);
            $HelperArray = array();
            $IsUpdate = false;
            $TotalQty = 0;
            foreach ($SessionArray as $SessionArrayItem) {
                $SessionProductID = $SessionArrayItem[0];
                $SessionProductQty = $SessionArrayItem[1];
                $SessionWarehouseId = $SessionArrayItem[2];
                if ($SessionProductID == $ProductID && $SessionWarehouseId == $pw_id) { // find product in basket
                    $SessionArrayItem[1] = $Qty;
                    $IsUpdate = true;
                }
                if ($Qty != 0) {
                    $TotalQty += $SessionArrayItem[1];
                    array_push($HelperArray, $SessionArrayItem);
                }
            }
            if ($IsUpdate) {
                $SessionArray = $HelperArray;
            } else {
                array_push($SessionArray, [$ProductID, $Qty, $pw_id]);
            }
            Session::put('basket', json_encode($SessionArray));
            $RowCount = $TotalQty;
            return $RowCount;
        }
    }
}
