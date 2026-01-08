<?php

namespace App\Http\Controllers\Device;

use App\Functions\persian;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Credit\Invoice;
use App\Models\DeviceContract;
use App\Models\DeviceContractType;
use App\Models\DeviceItemExternal;
use App\Models\DeviceMeta;
use App\Models\DeviceType;
use App\myappenv;
use App\Shop\rent;
use DB;
use Illuminate\Http\Request;
use Auth;

class RentProces extends Controller
{
    private function rent_customer_pannel()
    {
        $RequestUser = Auth::id();
        $Query = "SELECT UserName,Name,Family,MobileNo,Email,Phone1,Phone2,Address,Birthday,CreateDate,Status,UserPass,(SELECT COALESCE(sum(Point),0) as point FROM UserPoint WHERE UserName = '$RequestUser' and ConfirmUser is not null ) FROM UserInfo WHERE Role < 100 and UserName = '$RequestUser'";
        $PatInfos = DB::select($Query);
        foreach ($PatInfos as $PatInfoIns) {
            $PatInfo = $PatInfoIns;
        }
        $DeviceContracts = DeviceContract::all()->where('Owner', $RequestUser)->where('DeletedDate', null);
        $DeviceContractTypes = DeviceContractType::all()->where('IsShow', 1);
        $DeviceMetas = DeviceMeta::all();
        $DeviceTypes = DeviceType::all();

        return view("Devices.RentDevice", ['PatInfo' => $PatInfo, 'DeviceContracts' => $DeviceContracts, 'DeviceContractTypes' => $DeviceContractTypes, 'DeviceMetas' => $DeviceMetas, 'DeviceTypes' => $DeviceTypes]);
    }
    public function RentDevice($RequestUser =  null)
    {
        if (Auth::user()->Role == myappenv::role_customer) {
            return  $this->rent_customer_pannel();
        }
        if ($RequestUser == null) {
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

        return view("Devices.RentDevice", ['PatInfo' => $PatInfo, 'DeviceContracts' => $DeviceContracts, 'DeviceContractTypes' => $DeviceContractTypes, 'DeviceMetas' => $DeviceMetas, 'DeviceTypes' => $DeviceTypes]);
    }

    public function DoRentDevice($RequestUser, Request $request)
    {
        if ($request->ajax()) {
            $function = $request->function;
            if ($function == 'load_rent_contract') {
                $contract_id = $request->contract_id;
                $Query = "SELECT goods.NameFa,warehouse_goods.id , DeviceItemExternal.Price ,DeviceItemExternal.OwnerPrice , DeviceItemExternal.Note ,warehouses.Name as WarehouseName FROM DeviceContract INNER JOIN DeviceItemExternal on DeviceContract.ContractID = DeviceItemExternal.ContractNumber INNER JOIN warehouse_goods on DeviceItemExternal.pwid = warehouse_goods.id INNER JOIN goods on warehouse_goods.GoodID = goods.id INNER JOIN warehouses on warehouses.id = warehouse_goods.WarehouseID  WHERE DeviceContract.ContractID = $contract_id ";
                $rent_list = DB::select($Query);
                $output = '                                        <div class="table-responsive">
                <table class="table" id="basic-1" style="width: 100%">
                    <thead>
                        <tr>
                            <th>کد کالا</th>
                            <th>نام کالا</th>
                            <th> مبلغ اجاره </th>
                            <th> مبلغ تامین کننده</th>
                            <th> انبار </th>
                            <th>  توضیحات</th>
                        </tr>
                    </thead>
                    <tbody>';
                foreach ($rent_list as $rent_item) {
                    $id = $rent_item->id;
                    $NameFa = $rent_item->NameFa;
                    $OwnerPrice = number_format($rent_item->OwnerPrice);
                    $Price = number_format($rent_item->Price);
                    $WarehouseName = $rent_item->WarehouseName;
                    $Note = $rent_item->Note;
                    $output .= " <tr>
                    <td>$id </td>
                    <td>$NameFa </td>
                    <td>$Price </td>
                    <td>$OwnerPrice </td>
                    <td>$WarehouseName </td>
                    <td>$Note </td>
                    </tr> ";
                } 
                $output .= '</tbody>';
                return $output;
            }
            return 'درخواست نا مشخص';
        }
        if ($request->has('payment')) {
            $renting = new rent;
            $renting->rent_checkout($RequestUser, $request);
            return redirect()->back()->with('success', 'عملیات موفقیت آمیز!');
        }
        if ($request->has('delete')) {
            DeviceContract::where('ContractID', $request->delete)->update(['Status' => 0]);
            return redirect()->back()->with('success', 'عملیات موفقیت آمیز!');
        }
        if ($request->has('recover')) {
            DeviceContract::where('ContractID', $request->recover)->update(['Status' => 1]);
            return redirect()->back()->with('success', 'عملیات موفقیت آمیز!');
        }
        if ($request->has('delete_permanent')) {
            DeviceContract::where('ContractID', $request->delete_permanent)->delete();
            DeviceItemExternal::where('ContractNumber', $request->delete_permanent)->delete();
            return redirect()->back()->with('success', 'عملیات موفقیت آمیز!');
        }
        //dd($request->input(), $RequestUser);
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
            'ContractType' => $RentType
        ];
        $DeviceContract = DeviceContract::create($ContractData);
        $DeviceContractId = $DeviceContract->id;
        $DeviceMetas = $request->input('DeviceMeta');
        $DeviceType = $request->input('DeviceType');
        $RentPrice = $request->input('RentPrice');
        $DiscountPrice = $request->input('DiscountPrice');
        $Total = $request->input('Total');
        $DeviceTypeCounter = 0;
        $DeviceitemCounter = 1;
        foreach ($DeviceMetas as $DeviceMeta) {
            if ($DeviceMeta != 0) {
                $DeviceTypeTarget = $DeviceType[$DeviceTypeCounter];
                $RentPriceTarget = $RentPrice[$DeviceTypeCounter];
                $DiscountPriceTarget = $DiscountPrice[$DeviceTypeCounter];
                $Price = $RentPriceTarget - $DiscountPriceTarget;
                $ItemsToSave = [
                    'ContractNumber' => $DeviceContractId,
                    'SubItem' => $DeviceitemCounter,
                    'Owner' => Auth::id(),
                    'DeviceMeta' => $DeviceMeta,
                    'DeviceModel' => $DeviceTypeTarget,
                    'AmvalNumber' => '0',
                    'SerialNumber' => '0',
                    'Price' => $Price,
                    'Note' => ''
                ];
                $UnitPrice[$DeviceitemCounter] = $Price;
                $Unit[$DeviceitemCounter] = 'عدد';
                $Qty[$DeviceitemCounter] = 1;
                $Discount[$DeviceitemCounter] = 0;
                $DeviceMetaN = DeviceMeta::where('ID', $DeviceMeta)->first();
                $DeviceTypeN =  DeviceType::where('ID', $DeviceTypeTarget)->first();
                $ItemName[$DeviceitemCounter] = $DeviceMetaN->DeviceName . ' ' .  $DeviceTypeN->DeviceName;
                DeviceItemExternal::create($ItemsToSave);
                $DeviceitemCounter++;
            }
            $DeviceTypeCounter++;
        }
        $MyInvoice = new Invoice();
        //dd($UnitPrice);
        $Result = $MyInvoice->MakeInvoiceFunction($RequestUser, $Note, $UnitPrice, $Unit, $Qty, $Discount, $ItemName, $request->input('StartDate'));
        if ($Result) {
            return  redirect()->back()->with('success', 'درخواست شما ثبت و فاکتور برای بیمار ارسال شد!');
        } else {
            return  redirect()->back()->with('error', 'مشکل در ثبت اطلاعات به وجود آمده است!');
        }
    }
}
