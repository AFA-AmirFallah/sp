<?php

namespace App\Http\Controllers\Credit;

use AllShiftsTotall;
use App\APIS\SmsCenter;
use App\Functions\persian;
use App\Functions\SmartInvoice;
use App\Functions\TashimClass;
use App\Functions\TextClassMain;
use App\Http\Controllers\Controller;
use App\Models\AllShiftsTotall as ModelsAllShiftsTotall;
use App\Models\branches;
use App\Models\DeviceContract;
use App\Models\DeviceContractType;
use App\Models\DeviceItemExternal;
use App\Models\DeviceItemInternal;
use App\Models\DeviceMeta;
use App\Models\DeviceType;
use App\Models\InvoiceItems;
use App\Models\Invoices;
use App\Models\locations;
use App\Models\product_order;
use App\Models\UserCredit;
use App\Models\UserInfo;
use App\Models\warehouse_goods;
use App\myappenv;
use App\Renting\ProductRenting;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Throwable;

class Invoice extends Controller
{
    public function EditeSmartInvoice($InvoiceID, Request $request)
    {
        if ($request->has('if')) {
            $iframeshow = true;
        } else {
            $iframeshow = false;
        }

        $Invoice = DeviceContract::where('ContractID', $InvoiceID)->first();
        $Query = "SELECT
        dc.ContractID,
        di.id as ItemID,
        dc.Status,
        dc.Owner as Owner,
        dc.RentDate,
        dc.ExpireDate,
        dc.TotalPrice,
        dc.BeyanehPrice,
        dc.OwnerPrice,
        dc.Note,
        dc.created_at,
        g.NameFa as DeviceName,
        di.Price as ItemNote,
        di.unit_Price,
        di.Price,
        di.product_qty,
        b.Name as branchname
    from
        DeviceContract as dc
        INNER JOIN DeviceItemInternal as di on di.ContractNumber = dc.ContractID
        INNER JOIN warehouse_goods as wg on wg.id = di.Device
        INNER JOIN goods as g on di.product_id = g.id
        INNER JOIN branches as b on b.id = di.Ownerbranch
    WHERE
        dc.ContractID = $InvoiceID";
        $Items = DB::select($Query);
        $Contrct = DeviceContract::where('ContractID', $InvoiceID)->first();
        if ($Contrct->status > 1) {
            return abort(404, 'صورت حساب پرداخت شده قابل ویرایش نیست!');
        }
        $PatInfo = UserInfo::where('UserName', $Invoice->Owner)->first();
        return view('Credit.EditSmartInvoice', ['iframeshow' => $iframeshow, 'Contrct' => $Contrct, 'Items' => $Items, 'PatInfo' => $PatInfo]);
    }
    public function DoEditeSmartInvoice($InvoiceID, Request $request)
    {
        if ($request->has('submit')) {
            if ($request->input('submit') == 'resendsms') {
                $Invoice = DeviceContract::where('ContractID', $InvoiceID)->first();
                $Userinfo = UserInfo::where('UserName', $Invoice->Owner)->first();
                $MySMS = new SmsCenter();
                $CustomerText = myappenv::CenterName . ' ';
                $CustomerText .= $Userinfo->Name . ' ' . $Userinfo->Family . ' عزیز صورت حساب شما صادر شد. جهت پرداخت از لینک زیر استفاده فرمایید. ' . route('Invoice', ['Invoice' => $InvoiceID . 'SD']);
                try {
                    $MySMS->OndemandSMS($CustomerText, $Userinfo->MobileNo, 'alert', $Userinfo->MobileNo);
                    return redirect()->back()->with('success', "ارسال پیامک موقیت آمیز <br>" . route('Invoice', ['Invoice' => $InvoiceID . 'SD']));
                } catch (Throwable $e) {
                    return redirect()->back()->with('error', "ارسال پیامک ناموفق  <br>" . route('Invoice', ['Invoice' => $InvoiceID . 'SD']));
                }
            }
        }
        $Items = $request->input('item');
        $RentPrice = $request->input('RentPrice');
        $DiscountPrice = $request->input('DiscountPrice');
        $Total = $request->input('Total');
        $ProviderPrice = $request->input('ProviderPrice');
        $ItemNote = $request->input('ItemNote');
        $Qty = $request->input('Qty');
        $InvoiceType = $request->input('InvoiceType');
        $Conter = 0;
        while (isset($Items[$Conter])) {
            $ItemsT = $Items[$Conter];
            $RentPriceT = $RentPrice[$Conter];
            $DiscountPriceT = $DiscountPrice[$Conter];
            $TotalT = $Total[$Conter];
            $ProviderPriceT = $ProviderPrice[$Conter];
            $QtyT = $Qty[$Conter];
            $ItemNoteT = $ItemNote[$Conter];
            $Data = [
                'unit_sales' => $TotalT,
                'unit_Price' => $RentPriceT,
                'total_sales' => $QtyT * $TotalT,
                'Price' => $QtyT * $TotalT,
                'customer_benefit_total' => $QtyT * $DiscountPriceT,
                'OwnerPrice' => $QtyT * $ProviderPriceT,
                'net_total' => ($QtyT * $TotalT) - ($QtyT * $ProviderPriceT),
                'product_qty' => $QtyT,
                'extra' => $ItemNoteT,
            ];
            DeviceItemInternal::where('id', $ItemsT)->update($Data);
            $Conter++;
        }
        $Persian = new persian();
        $RentDate = $Persian->MiladiDate($request->input('StartDate'));
        $ExpireDate = $Persian->MiladiDate($request->input('EndDate'));
        $Note = $request->input('Note');
        $Guarantee = 0;
        $Status = 1;
        $ContractData = [
            'RentDate' => $RentDate,
            'ExpireDate' => $ExpireDate,
            'Guarantee' => $Guarantee,
            'Status' => $Status,
            'TotalPrice' => $request->input('TotalPriceEnd'),
            'BeyanehPrice' => $request->input('BeyanePrice'),
            'OwnerPrice' => $request->input('OwnerPrice'),
            'Note' => $Note,
        ];
        $DeviceContract = DeviceContract::where('ContractID', $InvoiceID)->update($ContractData);
        if ($InvoiceType == 1) {
            $DeviceContract = DeviceContract::where('ContractID', $InvoiceID)->first();
            $UserInfo = UserInfo::where('UserName', $DeviceContract->Owner)->first();
            $MySMS = new SmsCenter();
            $CustomerText = myappenv::CenterName . ' ';
            $CustomerText .= $UserInfo->Name . ' ' . $UserInfo->Family . ' عزیز صورت حساب شما صادر شد. جهت پرداخت از لینک زیر استفاده فرمایید. ' . route('Invoice', ['Invoice' => $InvoiceID . 'SD']);
            try {
                $MySMS->OndemandSMS($CustomerText, $UserInfo->MobileNo, 'alert', $UserInfo->MobileNo);
            } catch (Throwable $e) {
            }
        }
        if ($request->has('if')) {
            return redirect()->back()->with('success', ' عملیات با موفقیت انجام شد.');
        } else {
            return redirect()->route('Invoice', ['Invoice' => $InvoiceID . 'SD'])->with('success', ' عملیات با موفقیت انجام شد.');
        }
    }
    public function MakeSmartInvoice($RequestUser)
    {
        if (!myappenv::Lic['SmartInvoice']) {
            return abort('404');
        }
        $Query = "SELECT UserName,Name,Family,MobileNo,Email,Phone1,Phone2,Address,Birthday,CreateDate,Status,UserPass,(SELECT COALESCE(sum(Point),0) as point FROM UserPoint WHERE UserName = '$RequestUser' and ConfirmUser is not null ) FROM UserInfo WHERE Role < 100 and UserName = '$RequestUser'";
        $PatInfos = DB::select($Query);
        foreach ($PatInfos as $PatInfoIns) {
            $PatInfo = $PatInfoIns;
        }
        $DeviceContracts = DeviceContract::all()->where('Owner', $RequestUser)->where('DeletedDate', null);
        $DeviceContractTypes = DeviceContractType::all()->where('IsShow', 1);
        $DeviceMetas = DeviceMeta::all();
        $DeviceTypes = DeviceType::all();
        $Providers = branches::all()->where('BranchType', myappenv::provider_branch_type);
        $Tashim = new TashimClass();
        $TashimSrc = $Tashim->get_all_tashims();
        return view("Credit.MakeSmartInvoice", ['TashimSrc' => $TashimSrc, 'PatInfo' => $PatInfo, 'DeviceContracts' => $DeviceContracts, 'DeviceContractTypes' => $DeviceContractTypes, 'DeviceMetas' => $DeviceMetas, 'DeviceTypes' => $DeviceTypes, 'Providers' => $Providers]);
    }

    public function DoMakeSmartInvoice(Request $request, $RequestUser)
    {
        if ($request->ajax) {
            if ($request->procedure == 'add_new_row') {
                $DeviceContracts = DeviceContract::all()->where('Owner', $RequestUser)->where('DeletedDate', null);
                $DeviceContractTypes = DeviceContractType::all()->where('IsShow', 1);
                $DeviceMetas = DeviceMeta::all();
                $DeviceTypes = DeviceType::all();
                $Providers = branches::all()->where('BranchType', myappenv::provider_branch_type);
                $Tashim = new TashimClass();
                $TashimSrc = $Tashim->get_all_tashims();
                return view("Credit.MakeSmartInvoice_table_row", ['row_number'=>$request->row_id, 'TashimSrc' => $TashimSrc, 'DeviceContracts' => $DeviceContracts, 'DeviceContractTypes' => $DeviceContractTypes, 'DeviceMetas' => $DeviceMetas, 'DeviceTypes' => $DeviceTypes, 'Providers' => $Providers])->render();
        
            }
            if ($request->procedure == 'load_rent_device') {
                $product_type = $request->SelectType1;
                $my_rent = new ProductRenting;
                $Target_product = $my_rent->get_rent_product_by_type($product_type, 1);
                $result = [];
                foreach ($Target_product as $Target_product_item) {
                    $item = [
                        'name' => $Target_product_item->NameFa,
                        'id' => $Target_product_item->wgid
                    ];
                    array_push($result, $item);
                }
                return $result;
            }
            if ($request->procedure == 'get_rent_device_info') {
                $selected_product = $request->selected_product;
                $WarehouseID = $request->WarehouseID;
                $my_rent = new ProductRenting;
                $Target_product = $my_rent->get_rent_device_info($selected_product, $WarehouseID, $selected_product);
                if ($Target_product['result']) {
                    return $Target_product['data'];
                } else {
                    return false;
                }
            }
        }
        $Persian = new persian();
        $RentDate = $Persian->MiladiDate($request->input('StartDate'));
        $ExpireDate = $Persian->MiladiDate($request->input('EndDate'));
        $RentType = $request->input('RentType');
        $Note = $request->input('Note');
        $Guarantee = 0;
        $Status = 1;
        $ContractData = [
            'Owner' => $RequestUser,
            'ContractDate' => now(),
            'RentDate' => $RentDate,
            'ExpireDate' => $ExpireDate,
            'Guarantee' => $Guarantee,
            'Status' => $Status,
            'Note' => $Note,
            'tashim' => $request->tashim,
            'ContractType' => $RentType,
        ];
        $DeviceContract = DeviceContract::create($ContractData);
        $DeviceContractId = $DeviceContract->id;
        $InvoiceCredit = new SmartInvoice();
        if ($request->has('BeyanePrice')) {
            $BeyanePrice = $request->input('BeyanePrice');
        } else {
            $BeyanePrice = 0;
        }
        $TotalPriceEnd = $request->input('TotalPriceEnd');
        $DeviceMetas = $request->input('DeviceMeta');
        $DeviceType = $request->input('DeviceType');
        $RentPrice = $request->input('RentPrice');
        $DiscountPrice = $request->input('DiscountPrice');
        $ProviderPrice = $request->input('ProviderPrice');
        $pwid = $request->input('pwid');
        $ItemNote = $request->input('ItemNote');
        $Providers = $request->input('Provider');
        $DeviceTypeCounter = 0;
        $DeviceitemCounter = 1;
        $CustomerTotalPrice = 0;
        $DatamadTotalPrice = 0;
        foreach ($DeviceMetas as $DeviceMeta) {
            if ($DeviceMeta != 0) {
                $DeviceTypeTarget = $DeviceType[$DeviceTypeCounter];
                $RentPriceTarget = $RentPrice[$DeviceTypeCounter];
                if (!isset($ItemNote[$DeviceTypeCounter]) || $ItemNote[$DeviceTypeCounter] == null) {
                    $ItemNoteTarget = 'ندارد';
                } else {
                    $ItemNoteTarget = $ItemNote[$DeviceTypeCounter];
                }
                $wgid = $pwid[$DeviceTypeCounter];
                $DiscountPriceTarget = $DiscountPrice[$DeviceTypeCounter];
                $ProviderPriceTarget = $ProviderPrice[$DeviceTypeCounter];
                $ProviderTarget = $Providers[$DeviceTypeCounter];
                $Price = $RentPriceTarget - $DiscountPriceTarget;
                $CustomerTotalPrice += $Price;
                $DatamadTotalPrice += ($Price - $ProviderTarget);
                $ItemsToSave = [
                    'ContractNumber' => $DeviceContractId,
                    'SubItem' => $DeviceitemCounter,
                    'Owner' => $ProviderTarget,
                    'DeviceMeta' => $DeviceMeta,
                    'DeviceModel' => $DeviceTypeTarget,
                    'AmvalNumber' => '0',
                    'SerialNumber' => '0',
                    'Price' => $Price,
                    'pwid' => $wgid,
                    'OwnerPrice' => $ProviderPriceTarget,
                    'Note' => $ItemNoteTarget,
                ];
                $Branchinfo = branches::where('id', $ProviderTarget)->first();
                $Query = "SELECT DeviceMeta.DeviceName as metaname , DeviceType.DeviceName as typename FROM DeviceMeta INNER JOIN DeviceType on DeviceMeta.ID = DeviceType.MetaID WHERE DeviceMeta.ID = $DeviceMeta and DeviceType.TypeID = $DeviceTypeTarget";
                $results = DB::select($Query);
                foreach ($results as $result) {
                    $TargetNote = $result;
                }
                $UnitPrice[$DeviceitemCounter] = $Price;
                $DeviceMetaN = DeviceMeta::where('ID', $DeviceMeta)->first();
                $DeviceTypeN = DeviceType::where('ID', $DeviceTypeTarget)->first();
                $ItemName[$DeviceitemCounter] = $DeviceMetaN->DeviceName . ' ' . $DeviceTypeN->DeviceName;
                DeviceItemExternal::create($ItemsToSave);
                $DeviceitemCounter++;
            }
            $DeviceTypeCounter++;
        }
        $updateData = [
            'TotalPrice' => $request->input('TotalPriceEnd'),
            'BeyanehPrice' => $request->input('BeyanePrice'),
            'OwnerPrice' => $request->input('OwnerPrice'),
        ];
        DeviceContract::where('ContractID', $DeviceContractId)->update($updateData);
        $Ownerinfo = UserInfo::where('UserName', $RequestUser)->first();
        $RentSource = DeviceContractType::where('ID', $RentType)->first();
        $smstext = "شفاتل - زنجیره تامین سلامت" . "  ";
        $smstext .= $Ownerinfo->Name . ' ' . $Ownerinfo->Family . ' عزیر صورت حساب ';
        $smstext .= $RentSource->TypeName . ' به مبلغ ';
        $smstext .= number_format($request->input('OwnerPrice')) . ' ریال  صادر گردید لطفا جهت پرداخت از لینک زیر استفاده فرمایید. با تشکر شفا تل ';
        $smstext .= route('Invoice', ['Invoice' => $DeviceContractId . 'SI']);
        //$MySMS = new SmsCenter();
        // $MySMS->OndemandSMS($smstext, $Ownerinfo->MobileNo, 'Smart Invoice', $Ownerinfo->MobileNo);
        return redirect()->back()->with('success', __("Transaction done!"));
    }
    public function GetInvoiceTransactions($InvoiceNumer)
    {
        $Query = "SELECT uc.UserName , uc.ID as TranctionID , uc.Mony, uc.Date,uc.GateWay,ui.Name,ui.Family,ucm.ModName from UserCredit as uc INNER JOIN UserInfo ui on uc.UserName = ui.UserName inner JOIN UserCreditModMeta as ucm on uc.CreditMod = ucm.ID WHERE uc.ConfirmBy is not null and uc.InvoiceNo = $InvoiceNumer  ";
        return DB::select($Query);
    }
    public function GetServiceInvoiceTransactions($InvoiceNumer)
    {
        $Query = "SELECT uc.UserName , uc.ID as TranctionID , uc.Mony, uc.Date,uc.GateWay,ui.Name,ui.Family,ucm.ModName from UserCredit as uc INNER JOIN UserInfo ui on uc.UserName = ui.UserName inner JOIN UserCreditModMeta as ucm on uc.CreditMod = ucm.ID WHERE uc.ConfirmBy is not null and uc.InvoiceNo = $InvoiceNumer  ";
        return DB::select($Query);
    }
    private function service_invoice($Invoice)
    {
        $Query = "SELECT po.ServiceContract,po.id,ui.Name,ui.Family,ui.MelliID,ui.MobileNo,ui.NationalCode,ui.extranote,po.SendLocation,po.customer_benefit_total,po.shipping_total,po.status,po.tax_total,po.total_sales,po.created_at 
        FROM product_orders as po INNER JOIN UserInfo as ui on ui.UserName = po.CustomerId WHERE po.id =$Invoice";
        $Result = DB::select($Query);
        foreach ($Result as $REsiltItem) {
            $Ordertemp = $REsiltItem;
            break;
        }
        $OrderSrc = $Ordertemp;
        if($OrderSrc->ServiceContract == null){
            return abort('صورتحساب درخواست شده از نوع خدماتی نیست!');
        }
        $service_id = $OrderSrc->ServiceContract;
        $SendLocation = [];
        $Query = "SELECT g.ImgURL ,g.NameFa,po.product_qty,po.unit_Price,po.main_unit_price,po.unit_sales,(po.main_unit_price - po.unit_Price) as unitDef,po.tax_total from product_order_items as po INNER JOIN goods as g on g.id = po.product_id WHERE po.order_id = $Invoice";
        $OrderItems = DB::select($Query);
        $Transactions = $this->GetServiceInvoiceTransactions($service_id);
        $AllShiftsTotall = ModelsAllShiftsTotall::where('service_id',$service_id)->first();

        return view('Credit.SingleInvoice', ['AllShiftsTotall'=>$AllShiftsTotall, 'invoice_type'=>'service', 'Transactions' => $Transactions, 'OrderSrc' => $OrderSrc, 'SendLocation' => $SendLocation, 'OrderItems' => $OrderItems]);
    }

    public function Invoice(Request $request, $Invoice = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if ($request->has('type')) {
            if ($request->type == 's') {
                return $this->service_invoice($Invoice);
            }
            $Query = "SELECT po.id,ui.Name,ui.Family,ui.MelliID,ui.MobileNo,ui.NationalCode,ui.extranote,po.SendLocation,po.customer_benefit_total,po.shipping_total,po.status,po.tax_total,po.total_sales,po.created_at FROM product_orders as po INNER JOIN UserInfo as ui on ui.UserName = po.CustomerId WHERE po.id =$Invoice";
            $Result = DB::select($Query);
            foreach ($Result as $REsiltItem) {
                $Ordertemp = $Result;
                break;
            }
            foreach ($Ordertemp as $OrdertempItem) {
                $OrderSrc = $OrdertempItem;
            }
            $SendLocation = locations::where('id', $OrderSrc->SendLocation)->first();
            $Query = "SELECT g.ImgURL ,g.NameFa,po.product_qty,po.unit_Price,po.main_unit_price,po.unit_sales,(po.main_unit_price - po.unit_Price) as unitDef,po.tax_total from product_order_items as po INNER JOIN goods as g on g.id = po.product_id WHERE po.order_id = $Invoice";
            $OrderItems = DB::select($Query);
            $Transactions = $this->GetInvoiceTransactions($Invoice);
            return view('Credit.SingleInvoice', ['invoice_type'=>'product','Transactions' => $Transactions, 'OrderSrc' => $OrderSrc, 'SendLocation' => $SendLocation, 'OrderItems' => $OrderItems]);
        }
        if ($request->has('case')) {

            $Query = "SELECT  poi.* , g.NameFa ,g.SKU,(poi.main_unit_price - poi.unit_price) as UniDef,g.ImgURL,tashims.Name from product_order_items poi  inner join goods g on poi.product_id  = g.id   LEFT join tashims on poi.Tashim = tashims.TashimID  and tashims.ItemOrder = 0 where poi.order_id = $Invoice";
            $TargetproductOrder = DB::select($Query);
            $Query = "SELECT po.id,ui.UserName,ui.Name,ui.Family,ui.MelliID,ui.MobileNo,ui.NationalCode,ui.fathername,ui.extradata,po.SendLocation,po.customer_benefit_total,po.shipping_total,po.status,po.tax_total,po.total_sales,po.created_at FROM product_orders as po INNER JOIN UserInfo as ui on ui.UserName = po.CustomerId WHERE po.id =$Invoice";
            $Result = DB::select($Query);
            if (Auth::user()->Role < myappenv::role_ShopOwner) {
                if (Auth::id() != $Result[0]->UserName) {
                    return abort('404', 'دسترسی غیر مجاز : کجا عمو !!');
                }
            }
            foreach ($Result as $REsiltItem) {
                $Ordertemp = $Result;
                break;
            }
            foreach ($Ordertemp as $OrdertempItem) {
                $TargetOrder = $OrdertempItem;
            }
            $SendLocation = locations::where('id', $TargetOrder->SendLocation)->first();
            $ProductOrder = product_order::where('id', $Invoice)->first();
            $TavanSrc = UserCredit::where('UserName', $ProductOrder->CustomerId)->where('CreditMod', 3)->where('InvoiceNo', $Invoice)->get();
            return view('Credit.KasrazHoghogh', ['TavanSrc' => $TavanSrc, 'SendLocation' => $SendLocation, 'TargetOrder' => $TargetOrder, 'TargetproductOrder' => $TargetproductOrder]);
        }
        if ($request->has('Receipt')) {

            $Query = "SELECT po.id,ui.UserName,ui.Name,ui.Family,ui.MelliID,ui.MobileNo,ui.NationalCode,ui.fathername,ui.extradata,ui.Address,ui.Address2,po.SendLocation,po.customer_benefit_total,po.shipping_total,po.status,po.tax_total,po.total_sales,po.created_at FROM product_orders as po INNER JOIN UserInfo as ui on ui.UserName = po.CustomerId WHERE po.id =$Invoice";
            $Result = DB::select($Query);
            if (Auth::user()->Role < myappenv::role_ShopOwner) {
                if (Auth::id() != $Result[0]->UserName) {
                    return abort('404', 'دسترسی غیر مجاز : کجا عمو !!');
                }
            }
            foreach ($Result as $REsiltItem) {
                $Ordertemp = $Result;
                break;
            }
            foreach ($Ordertemp as $OrdertempItem) {
                $TargetOrder = $OrdertempItem;
            }

            $SendLocation = locations::where('id', $TargetOrder->SendLocation)->first();
            $ProductOrder = product_order::where('id', $Invoice)->first();

            return view('Credit.PostReceipt', ['SendLocation' => $SendLocation, 'TargetOrder' => $TargetOrder]);
        }
        if ($Invoice != null) {
            $StringLen = strlen($Invoice);
            $end2chars = substr($Invoice, $StringLen - 2, 2);
            if ($end2chars == "SI") { //smart invoice
                $Invoice = substr($Invoice, 0, $StringLen - 2);
                $DeviceContract = DeviceContract::where('ContractID', $Invoice)->where('DeletedBy', null)->first();
                if ($DeviceContract != null) {
                    $Query = "SELECT DeviceContract.ContractID,DeviceContract.Status, DeviceContract.Owner as Owner ,DeviceContract.RentDate ,DeviceContract.ExpireDate,DeviceContract.TotalPrice,DeviceContract.BeyanehPrice,DeviceContract.OwnerPrice,DeviceContract.Note,DeviceContract.created_at,DeviceMeta.DeviceName as MetaName,DeviceType.DeviceName as TypeName,DeviceItemExternal.Price,DeviceItemExternal.OwnerPrice ,DeviceItemExternal.Note as ItemNote
                            FROM DeviceContract INNER JOIN DeviceItemExternal on DeviceContract.ContractID = DeviceItemExternal.ContractNumber
                            INNER JOIN DeviceMeta on DeviceMeta.ID = DeviceItemExternal.DeviceMeta
                            INNER JOIN DeviceType on DeviceType.ID = DeviceItemExternal.DeviceModel where DeviceContract.ContractID = $Invoice";
                    $InvoiceItems = DB::select($Query);
                    $InvoiceItems1 = $InvoiceItems;
                    foreach ($InvoiceItems1 as $InvoiceItem) {
                        $TargetItem = $InvoiceItem;
                    }
                    $Query = "SELECT branches.Name ,branches.Description  FROM DeviceItemExternal inner join branches on DeviceItemExternal.Owner = branches.id WHERE DeviceItemExternal.ContractNumber = $Invoice";
                    $OwnerSorce = DB::select($Query);
                    foreach ($OwnerSorce as $OwnerSorceItem) {
                        $TargetOwner = $OwnerSorceItem;
                    }
                    $Owner = UserInfo::where('UserName', $TargetItem->Owner)->first();
                    return view("Credit.InvoiceSmart", ['Owner' => $Owner, 'InvoiceTarget' => $TargetItem, 'InvoiceItems' => $InvoiceItems, 'TargetOwner' => $TargetOwner]);
                } else {
                    return abort('404');
                }
            } elseif ($end2chars == "SD") { // Smart invoice in offline order
                $Invoice = substr($Invoice, 0, $StringLen - 2);
                $DeviceContract = DeviceContract::where('ContractID', $Invoice)->where('DeletedBy', null)->first();
                if ($DeviceContract != null) {
                    $Query = "SELECT DeviceContract.ContractID,DeviceContract.Status, DeviceContract.Owner as Owner ,DeviceContract.RentDate ,DeviceContract.ExpireDate,DeviceContract.TotalPrice,DeviceContract.BeyanehPrice,DeviceContract.OwnerPrice,DeviceContract.Note,DeviceContract.created_at,DeviceMeta.DeviceName as MetaName,DeviceType.DeviceName as TypeName,DeviceItemExternal.Price,DeviceItemExternal.OwnerPrice ,DeviceItemExternal.Note as ItemNote
                            FROM DeviceContract INNER JOIN DeviceItemExternal on DeviceContract.ContractID = DeviceItemExternal.ContractNumber
                            INNER JOIN DeviceMeta on DeviceMeta.ID = DeviceItemExternal.DeviceMeta
                            INNER JOIN DeviceType on DeviceType.ID = DeviceItemExternal.DeviceModel where DeviceContract.ContractID = $Invoice";
                    $Query = "SELECT
                    dc.ContractID,
                    dc.Status,
                    dc.Owner as Owner,
                    dc.RentDate,
                    dc.ExpireDate,
                    dc.TotalPrice,
                    dc.BeyanehPrice,
                    dc.OwnerPrice,
                    dc.Note,
                    dc.created_at,
                    g.NameFa as DeviceName,
                    di.Price ,
                    di.product_qty,
                    di.unit_Price,
                    di.Price as ItemNote
                from
                    DeviceContract as dc
                    INNER JOIN DeviceItemInternal as di on di.ContractNumber = dc.ContractID
                    INNER JOIN warehouse_goods as wg on wg.id = di.Device
                    INNER JOIN goods as g on di.product_id = g.id
                WHERE
                    dc.ContractID  = $Invoice";
                    $InvoiceItems = DB::select($Query);

                    $InvoiceItems1 = $InvoiceItems;
                    foreach ($InvoiceItems1 as $InvoiceItem) {
                        $TargetItem = $InvoiceItem;
                    }
                    $Query = "SELECT branches.Name ,branches.Description  FROM DeviceItemExternal inner join branches on DeviceItemExternal.Owner = branches.id WHERE DeviceItemExternal.ContractNumber = $Invoice";
                    $OwnerSorce = DB::select($Query);
                    foreach ($OwnerSorce as $OwnerSorceItem) {
                        $TargetOwner = $OwnerSorceItem;
                    }

                    $Owner = UserInfo::where('UserName', $TargetItem->Owner)->first();
                    $SendLocation = locations::where('Owner', $TargetItem->Owner)->first();

                    return view("Credit.InvoiceSmartOffline", ['Owner' => $Owner, 'SendLocation' => $SendLocation, 'InvoiceTarget' => $TargetItem, 'InvoiceItems' => $InvoiceItems]);
                } else {
                    return abort('404');
                }
            } else {

                $InvoiceTarget = Invoices::where('id', $Invoice)->first();
                $Query = "SELECT invoices .* ,OwnerUserInfo.Name as ownername ,OwnerUserInfo.Family as ownnerfamily,OwnerUserInfo.MobileNo  as ownnerMobileNo, invoice_statuses.StatusName FROM invoices INNER JOIN UserInfo as OwnerUserInfo on invoices.Owner = OwnerUserInfo.UserName INNER JOIN invoice_statuses on invoices.Status = invoice_statuses.id where invoices.id = $Invoice";
                $results = DB::select($Query);
                foreach ($results as $result) {
                    $InvoiceTarget = $result;
                }

                $InvoiceItems = InvoiceItems::all()->where('InvoiceID', $Invoice);
                return view("Credit.Invoice", ['InvoiceTarget' => $InvoiceTarget, 'InvoiceItems' => $InvoiceItems]);
            }
        } else {
            /*   if (!Auth::check()) {
                return redirect()->route('Login');
            } */
            if (Auth::user()->Role > myappenv::role_customer) {
                $UserBranch = Auth::user()->branch;
                if ($UserBranch == myappenv::Branch) { //owner Benach
                    $Query = "SELECT UserInfo.Name as OwnerName, UserInfo.Family as OwnerFamily ,DeviceContract.Status as InvoiceStatus, DeviceContract.ContractID,DeviceContractType.TypeName
                    ,DeviceContract.created_at,DeviceContract.TotalPrice,DeviceContract.Status, branches.Name as Provider , SUM(DeviceItemExternal.OwnerPrice) as BranchPrice FROM DeviceContract
                    inner join DeviceContractType  on DeviceContractType.ID = DeviceContract.ContractType
                    inner join UserInfo  on UserInfo.UserName = DeviceContract.Owner
                    inner join DeviceItemExternal  on DeviceItemExternal.ContractNumber = DeviceContract.ContractID
                    INNER JOIN branches on branches.id = DeviceItemExternal.Owner 
                    GROUP BY  UserInfo.Family,UserInfo.Name,DeviceContract.Status, DeviceContract.ContractID,DeviceContractType.TypeName
                    ,DeviceContract.created_at,DeviceContract.TotalPrice,DeviceContract.Status, branches.Name ";
                    $SmartInvoice = DB::select($Query);
                    $ShowType = 'MainOwner';
                } else { //Providers Branchs
                    $Query = "SELECT UserInfo.Name as OwnerName, UserInfo.Family as OwnerFamily ,DeviceContract.Status as InvoiceStatus, DeviceContract.ContractID,DeviceContractType.TypeName
                    ,DeviceContract.created_at,DeviceContract.TotalPrice,DeviceContract.Status, branches.Name as Provider ,
                    SUM(DeviceItemExternal.OwnerPrice) as BranchPrice FROM DeviceContract
                    inner join DeviceContractType  on DeviceContractType.ID = DeviceContract.ContractType
                    inner join UserInfo  on UserInfo.UserName = DeviceContract.Owner
                    inner join DeviceItemExternal  on DeviceItemExternal.ContractNumber = DeviceContract.ContractID
                    INNER JOIN branches on branches.id = DeviceItemExternal.Owner where DeviceItemExternal.Owner = '$UserBranch' 
                    GROUP BY UserInfo.Family, UserInfo.Name,DeviceContract.Status, DeviceContract.ContractID,DeviceContractType.TypeName
                    ,DeviceContract.created_at,DeviceContract.TotalPrice,DeviceContract.Status, branches.Name ";
                    $SmartInvoice = DB::select($Query);
                    $ShowType = 'ProviderOwners';
                }
                $Query = "SELECT invoices .* ,OwnerUserInfo.Name as ownername ,OwnerUserInfo.Family as ownnerfamily,OwnerUserInfo.MobileNo  as ownnerMobileNo, invoice_statuses.StatusName FROM invoices INNER JOIN UserInfo as OwnerUserInfo on invoices.Owner = OwnerUserInfo.UserName INNER JOIN invoice_statuses on invoices.Status = invoice_statuses.id ";
                $Invoices = DB::select($Query);
                return view('Credit.InvoiceList', ['Invoices' => $Invoices, 'SmartInvoice' => $SmartInvoice, 'ShowType' => $ShowType]);
            } else {
                $UserName = Auth::id();
                $Query = "SELECT invoices.* ,OwnerUserInfo.Name as ownername ,OwnerUserInfo.Family as ownnerfamily,OwnerUserInfo.MobileNo  as ownnerMobileNo, invoice_statuses.StatusName FROM invoices INNER JOIN UserInfo as OwnerUserInfo on invoices.Owner = OwnerUserInfo.UserName INNER JOIN invoice_statuses on invoices.Status = invoice_statuses.id where invoices.Owner = '$UserName'";
                $Invoices = DB::select($Query);
                $Query = "SELECT DeviceContract.Status as InvoiceStatus, DeviceContract.ContractID,DeviceContractType.TypeName
                ,DeviceContract.created_at,DeviceContract.TotalPrice,DeviceContract.Status, branches.Name as Provider , SUM(DeviceItemExternal.OwnerPrice) as BranchPrice FROM DeviceContract
                inner join DeviceContractType  on DeviceContractType.ID = DeviceContract.ContractType
                inner join DeviceItemExternal  on DeviceItemExternal.ContractNumber = DeviceContract.ContractID
                INNER JOIN branches on branches.id = DeviceItemExternal.Owner  where DeviceContract.Owner = '$UserName' GROUP BY DeviceContract.Status, DeviceContract.ContractID,DeviceContractType.TypeName
                ,DeviceContract.created_at,DeviceContract.TotalPrice,DeviceContract.Status, branches.Name  ";

                $SmartInvoice = DB::select($Query);
                $ShowType = 'Cusetomer';
                return view('Credit.InvoiceList', ['Invoices' => $Invoices, 'SmartInvoice' => $SmartInvoice, 'ShowType' => $ShowType]);
            }
        }
    }


    public function DoInvoice(Request $request, $Invoice = null)
    {

        if ($request->has('submitandPay')) {
            if ($Invoice != null) {

                $StringLen = strlen($Invoice);
                $end2chars = substr($Invoice, $StringLen - 2, 2);
                if ($end2chars == "SI") { //smart invoice
                    $InvoiceNumer = $request->input('submitandPay');
                    $InvoiceTarget = DeviceContract::where('ContractID', $InvoiceNumer)->first();
                    $MyDirectPay = new DirectPayment();
                    $TargetUserInfo = UserInfo::where('UserName', $InvoiceTarget->Owner)->first();
                    $payername = $TargetUserInfo->Name . ' ' . $TargetUserInfo->Family;
                    $Mobile = $TargetUserInfo->MobileNo;
                    if ($InvoiceTarget->Status == 1) {
                        if ($InvoiceTarget->BeyanehPrice == 0 || $InvoiceTarget->BeyanehPrice == null) {
                            $Amount = $InvoiceTarget->BeyanehPrice;
                            $Note = "بیعانه صورت حساب شماره :  " . $InvoiceNumer;
                        } else {
                            $Amount = $InvoiceTarget->TotalPrice;
                            $Note = "تسویه حساب صورت حساب شماره : " . $InvoiceNumer;
                        }
                    } elseif ($InvoiceTarget->Status == 50) {
                        $Amount = $InvoiceTarget->TotalPrice - $InvoiceTarget->BeyanehPrice;
                        $Note = "تسویه حساب صورت حساب شماره : " . $InvoiceNumer;
                    }
                    $Result = $MyDirectPay->PepDirectPayAdd($Amount, '99000' . $InvoiceNumer, $InvoiceTarget->Owner, $payername, $Mobile, $Note);
                    return redirect()->to('https://shafatel.com/pep/?payment=' . $Result);
                } elseif ($end2chars == "SD") { //Offline smart invoice
                    $InvoiceNumer = $request->input('submitandPay');
                    $InvoiceTarget = DeviceContract::where('ContractID', $InvoiceNumer)->first();
                    $MyDirectPay = new DirectPayment();
                    $TargetUserInfo = UserInfo::where('UserName', $InvoiceTarget->Owner)->first();
                    $payername = $TargetUserInfo->Name . ' ' . $TargetUserInfo->Family;
                    $Mobile = $TargetUserInfo->MobileNo;
                    if ($InvoiceTarget->Status == 1) {
                        if ($InvoiceTarget->BeyanehPrice == 0 || $InvoiceTarget->BeyanehPrice == null) {
                            $Amount = $InvoiceTarget->TotalPrice;
                            $Note = "تسویه حساب صورت حساب شماره : " . $InvoiceNumer;
                        } else {
                            $Amount = $InvoiceTarget->BeyanehPrice;
                            $Note = "بیعانه صورت حساب شماره :  " . $InvoiceNumer;
                        }
                    } elseif ($InvoiceTarget->Status == 50) {
                        $Amount = $InvoiceTarget->TotalPrice - $InvoiceTarget->BeyanehPrice;
                        $Note = "تسویه حساب صورت حساب شماره : " . $InvoiceNumer;
                    }
                    $price = $request->input('Amount'); // Price Rial
                    $note = $request->input('Note'); // Price Rial
                    Session::put('price', $Amount);
                    Session::put('note', $Note);
                    Session::put('ResNum', '99000' . $InvoiceNumer);
                    return redirect()->route('ikc');
                    $Result = $MyDirectPay->PepDirectPayAdd($Amount, '99000' . $InvoiceNumer, $InvoiceTarget->Owner, $payername, $Mobile, $Note);
                    return redirect()->to('https://shafatel.com/pep/?payment=' . $Result);
                } else {
                    // dd($request->input(),$Invoice);
                    $InvoiceNumer = $request->input('submitandPay');
                    $InvoiceTarget = Invoices::where('id', $InvoiceNumer)->first();
                    $MyDirectPay = new DirectPayment();
                    $TargetUserInfo = UserInfo::where('UserName', $InvoiceTarget->Owner)->first();
                    $payername = $TargetUserInfo->Name . ' ' . $TargetUserInfo->Family;
                    $Mobile = $TargetUserInfo->MobileNo;
                    $Note = "صورت حساب شماره :" . $InvoiceNumer;
                    if (myappenv::Bank == 'IKC') {
                        Session::put('price', $InvoiceTarget->Amount);
                        Session::put('note', $Note);
                        Session::put('NormalInvoice', $InvoiceNumer);
                        Session::put('ResNum', '99000' . $InvoiceNumer);
                        return redirect()->route('ikc');
                    }

                    $Result = $MyDirectPay->PepDirectPayAdd($InvoiceTarget->Amount, '98000' . $InvoiceNumer, $InvoiceTarget->Owner, $payername, $Mobile, $Note);
                    return redirect()->to('https://shafatel.com/pep/?payment=' . $Result);
                }
            }
        } else {
            return abort('404');
        }
    }

    public function MakeInvoice()
    {
        return view("Credit.InvoiceCreate");
    }

    public function MakeInvoiceFunction($TargetUserName, $TargetNote, $UnitPrice, $Unit, $Qty, $Discount, $ItemName, $StartDate, $Tax)
    {
        $mypersian = new persian();
        $Expire = $mypersian->MiladiDate($StartDate);
        $InvoiceDate = [
            'Owner' => $TargetUserName,
            'Ceator' => Auth::id(),
            'Amount' => 0,
            'Expire' => $Expire,
            'Note' => $TargetNote,
        ];
        $result = Invoices::create($InvoiceDate);
        $TargetInvoice = $result->id;
        if ($result->id != null) {
            $counter = 1;
            $TotallSUMPrice = 0;
            while (isset($ItemName[$counter]) && $ItemName[$counter] != null) {
                $TotallPrice = $UnitPrice[$counter] * $Qty[$counter] - $Discount[$counter] + $Tax[$counter];
                $TotallSUMPrice += $TotallPrice;
                $InvoiceItemData = [
                    'InvoiceID' => $TargetInvoice,
                    'ItemID' => $counter,
                    'ItemName' => $ItemName[$counter],
                    'Unit' => $Unit[$counter],
                    'UnitPrice' => $UnitPrice[$counter],
                    'Discount' => $Discount[$counter],
                    'Qty' => $Qty[$counter],
                    'Tax' => $Tax[$counter],
                    'TotallPrice' => $TotallPrice,
                ];
                InvoiceItems::create($InvoiceItemData);
                $counter++;
            }
            $UpdateData = [
                'Amount' => $TotallSUMPrice,
            ];
            Invoices::where('id', $TargetInvoice)->update($UpdateData);
            $TargetUserInfo = UserInfo::where('UserName', $TargetUserName)->first();
            $payername = $TargetUserInfo->Name . ' ' . $TargetUserInfo->Family;
            $Mobile = $TargetUserInfo->MobileNo;
            $MySMS = new SmsCenter();
            $mytext = new TextClassMain();
            $Link = url('Invoice', ['Invoice' => $TargetInvoice]);
            $smstext = $mytext->InvoiceGenerate($payername, number_format($TotallSUMPrice), myappenv::CenterName, $TargetInvoice, $Link);
            $MySMS->OndemandSMS($smstext, $Mobile, 'IPGReq', Auth::id());

            return true;
        } else {
            return false;
        }
    }

    public function DoMakeInvoice(Request $request)
    {
        if ($request->input('submit') == 'Trnsfer') {

            $Result = $this->MakeInvoiceFunction($request->input('UserName'), $request->input('Note'), $request->input('UnitPrice'), $request->input('Unit'), $request->input('Qty'), $request->input('Discount'), $request->input('ItemName'), $request->input('StartDate'), $request->input('Tax'));
            if ($Result) {
                return redirect()->back()->with('success', __("Transaction done!"));
            } else {
                return redirect()->back()->with('error', __("The error has accure in your requsest please try again or call to callcenter!"));
            }
        }
    }
}
