<?php

namespace App\Http\Controllers\woocommerce;

use App\Http\Controllers\Controller;
use App\Models\branches;
use App\Models\store as ModelsStore;
use App\Models\StoreField;
use App\Models\StoreType;
use App\Models\UserInfo;
use App\Models\warehouse;
use App\myappenv;
use DB;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class store extends Controller
{

    public function WarehouseReport($warehouseid)
    {





        $Query = "SELECT
            count(*) as countitems ,
            product_orders.status,
            product_orders.id,
            product_orders.created_at as CreateDate,
            UserInfo.Name,
            UserInfo.Family,
            sum(
                product_order_items.net_total
            ) as nettotall ,
            sum(
                product_order_items.total_sales
            ) as total_sales,
            sum(
                product_order_items.net_total
            )  - sum(
                product_order_items.total_sales
            ) as BuyPrice
            
        FROM product_order_items
            INNER JOIN product_orders on product_order_items.order_id = product_orders.id
            INNER JOIN warehouse_goods on product_order_items.pw_id = warehouse_goods.id
            INNER JOIN UserInfo on product_order_items.customer_id = UserInfo.UserName
        where
            warehouse_goods.WarehouseID = $warehouseid
            and product_orders.status > 0
        group by
            product_orders.id,
            product_orders.created_at,
            UserInfo.Name,
            UserInfo.Family";
        $Orders = DB::select($Query);



        return view("woocommerce.admin.WarehouseReport", ['Orders' => $Orders]);
    }
    public function DoWarehouseReport($StoreID)
    {
    }
    public function CurentUserHasAutorizeToAccessStore($StoreID)
    {
        $TargetStore = ModelsStore::where('id', $StoreID)->first();
        if ($TargetStore->branch != Auth::user()->Branch and Auth::user()->Role != myappenv::role_SuperAdmin and Auth::user()->Role != myappenv::role_ShopAdmin) {
            return false;
        } else {
            return $TargetStore;
        }
    }
    public function WarehouseManagement($StoreID)
    {
        //store id is warehousseid
        $TargetWarehouse = warehouse::where('id', $StoreID)->first();
        if ($TargetWarehouse == null) {
            abort('404', 'انبار درخواست شده موجود نمی باشد!');
        }
        $TargetStore = $this->CurentUserHasAutorizeToAccessStore($TargetWarehouse->StoreID);
        if ($TargetStore == false) {
            abort('404', 'شما مجوز دسترسی به این انبار را ندارید!');
        }
        $Query = "SELECT g.* , wg.QTY ,wg.id as wgid , w.Name  ,wg.Remian  ,wg.QTY  ,wg.InputDate FROM goods g left join warehouse_goods wg on g.id = wg.GoodID LEFT join warehouses w on wg.WarehouseID  = w.id where w.id = $StoreID order by g.id ";
        $goods = DB::select($Query);
        //$goods = goods::all()->where('Status', '<', '1000');
        return view("woocommerce.admin.WarehouseProductLsit", ['goods' => $goods, 'TargetWarehouse' => $TargetWarehouse, 'TargetStore' => $TargetStore]);
    }
    public function DoWarehouseManagement(Request $request, $StoreID)
    {
    }
    public function EditWarehouse($StoreID, $Warehousid)
    {

        $Store = ModelsStore::where('id', $StoreID)->first();
        $warehouse = warehouse::where('id', $Warehousid)->first();
        return view("woocommerce.admin.Editwarehouse", ['Store' => $Store, 'warehouse' => $warehouse]);
    }
    public function DoEditWarehouse($StoreID, $Warehousid, Request $request)
    {
        $warehousedata = [
            'Name' => $request->input('Name'),
            'status' => $request->input('Status'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'Postalcode' => $request->input('Postalcode'),
        ];
        warehouse::where('id', $Warehousid)->update($warehousedata);
        $targetStore = ModelsStore::where('id', $StoreID)->first();
        $SuccessText = " انبار " . $request->input('Name') . "  فروشگاه " . $targetStore->Name . " به روز رسانی شد ";
        return redirect()->route('StoreList')->with('success', $SuccessText);
    }
    public function Warehouse($StoreID)
    {
        $UserBranch = Auth::user()->branch;
        $TargetStore = ModelsStore::where('id', $StoreID)->first();
        if ($TargetStore == null) {
            return abort(404, 'فروشگاه مورد نظر وجود ندارد');
        }
        if ($TargetStore->branch != $UserBranch && $UserBranch != myappenv::Branch) {
            return abort(404, 'شما مجوز دسترسی به این فروشگاه را ندارید');
        }

        $warehouses = warehouse::all()->where('StoreID', $StoreID);

        $Store = ModelsStore::where('id', $StoreID)->first();
        return view('woocommerce.admin.warehouse', ['warehouses' => $warehouses, 'Store' => $Store]);
    }
    public function DoWarehouse($StoreID, Request $request)
    {
    }
    public function AddWarehouse($StoreID)
    {
        $Store = ModelsStore::where('id', $StoreID)->first();
        return view("woocommerce.admin.Addwarehouse", ['Store' => $Store]);
    }
    public function DoAddWarehouse($StoreID, Request $request)
    {
        $warehousedata = [
            'Name' => $request->input('Name'),
            'StoreID' => $StoreID,
            'status' => $request->input('Status'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'Postalcode' => $request->input('Postalcode'),
        ];
        warehouse::create($warehousedata);
        $targetStore = ModelsStore::where('id', $StoreID)->first();
        $SuccessText = " انبار " . $request->input('Name') . " به فروشگاه " . $targetStore->Name . " اضافه شد ";
        return redirect()->route('Warehouse', [$StoreID])->with('success', $SuccessText);
    }
    public function StoreAdd()
    {
        if (Gate::allows('shopadmin_') || Gate::allows('root_')) {
        } else {
            return abort('404', 'این امکان برای شما وجود ندارد!');
        }
        $Store = null;
        $StoreFields = StoreField::all();
        $StoreTypes = StoreType::all();
        $Branchs = branches::all();
        $picrefrence = [];
        return view("woocommerce.admin.StoreAdd", [
            'Branchs' => $Branchs, 'Store' => $Store, 'StoreFields' => $StoreFields, 'StoreTypes' => $StoreTypes, 'picrefrence' => $picrefrence,
        ]);
    }
    public function DoStoreAdd(Request $request)
    {
        $request->validate([
            'Mobile' => 'required|min:11|max:11|regex:/(0)[0-9]{9}/',
            'Type' => 'required',
            'License' => 'required',
        ], [
            'Name.required' => 'مشخص سازی نام فروشگاه الزامی است!',
            'Address.required' => 'مشخص سازی آدرس فروشگاه الزامی است!',
            'Phone.required' => 'مشخص سازی تلفن ثابت فروشگاه الزامی است!',
            'Phone.max' => 'شماره تلفن نامعتبر است!',
            'Phone.min' => 'شماره تلفن نامعتبر است!',
            'Mobile.required' => 'مشخص سازی شماره همراه فروشگاه الزامی است!',
            'Mobile.max' => 'شماره موبایل حداکثر 11 رقم میباشد!',
            'Mobile.min' => 'شماره موبایل حداقل 11 رقم میباشد!',
            'Mobile.regex' => 'شماره موبایل صحیح نمیباشد! ()شماره موبایل صحیح: 09128765432',
            'Type.required' => 'مشخص سازی تلفن ثابت فروشگاه الزامی است!',
            'License.required' => 'مشخص سازی مجوز فروشگاه الزامی است!',
        ]);
        $TargetOwner = UserInfo::where('UserName', $request->input('owner'))->first();
        if ($TargetOwner == null) {
            return redirect()->route('StoreList')->with('error', "مالک فروشگاه وجود ندارد!!");
        }

        $BranchID = $request->input('Branch');
        if ($BranchID == 0) { // not select branch
            $SearchBranch = branches::where('name', $request->input('Name'))->first();
            if ($SearchBranch != null) {
                return redirect()->back()->with('error', "شعبه ای با این نام وجود دارد!");
            }
            $BranchData = [
                'Name' => $request->input('Name'),
                'UserName' => $request->input('owner'),
                'Phone' => $request->input('Mobile'),
                'license' => $request->input('License') ?? '',
                'api' => $request->input('API') ?? '',
                'avatar' => $request->input('pic'),
                'BranchType' => 2,
                'Description' => '',
            ];
            $result = branches::create($BranchData);
            $BranchID = $result->id;
        }

        $UserData = [
            'branch' => $BranchID,
            'Role' => myappenv::role_ShopOwner,
        ];
        UserInfo::where('UserName', $request->input('owner'))->update($UserData);
        if ($request->input('submit') == 'AddStore') {
            $StoreData = [
                'Name' => $request->input('Name'),
                'Address' => $request->input('Address'),
                'Phone' => $request->input('Phone'),
                'Mobile' => $request->input('Mobile'),
                'Owner' => $request->input('owner'),
                'Status' => 0,
                'Type' => $request->input('Type'),
                'Field' => $request->input('Field'),
                'License' => $request->input('License'),
                'branch' => $BranchID,
                'Pic' => $request->input('pic'),
                'CreateDate' => now(),
                'Description' => $request->input('ce'),
                'Malek' => $request->input('ownername'),
            ];
            $result = ModelsStore::create($StoreData);
            return redirect()->route('StoreList')->with('success', __("success alert"));
        }
    }
    public function StoreList()
    {
        $UserBranch = Auth::user()->branch;
        if ($UserBranch != myappenv::Branch) {
            $BranchQuery = "where  st.branch = $UserBranch ";
        } else {
            $BranchQuery = "";
        }
        $Query = "SELECT
        st.id ,
        st.Mobile ,
        st.Name as storename ,
        st.created_at as CreateTime,
        stt.Name as typename ,
        ui.Name as OwnerName,
        ui.Family as OwnerFamily
    from
        stores as st
    inner join store_types stt on
        st.`Type` = stt.id
    INNER JOIN UserInfo ui on
        st.Owner = ui.UserName $BranchQuery ORDER by st.id DESC ";

        $Stores = DB::select($Query);
        if (Session::has('MyStore')) {
            $AdminStore = Session::get('MyStore');
        } else {
            $AdminStore = null;
        }
        return view('woocommerce.admin.StoreList', ['Stores' => $Stores, 'AdminStore' => $AdminStore]);
    }
    public function DoStoreList(Request $request)
    {
        if ($request->has('selectStore')) {
            $StoreId = $request->input('selectStore');
            Session::put('MyStore', $StoreId);
            return redirect()->back()->with('success', "انتخاب فروشگاه برای نام کاربری شما انجام شد!");
        }
    }
    public function StoreManageitems($id)
    {
        $Store = ModelsStore::where('id', $id)->first();
        $StoreFields = StoreField::all();
        $StoreTypes = StoreType::all();
        $picrefrence = [];
        $Owner = UserInfo::where('UserName', $Store->Owner)->first();
        return view("woocommerce.admin.StoreManage", [
            'Owner' => $Owner, 'Store' => $Store, 'StoreFields' => $StoreFields, 'StoreTypes' => $StoreTypes, 'picrefrence' => $picrefrence,
        ]);
    }
    public function DoStoreManageitems($id = null, Request $request)
    {
        $request->validate([
            'Name' => 'required',
            'Address' => 'required',
            'Phone' => 'required|min:5|max:11',
            'Mobile' => 'required|min:11|max:11|regex:/(0)[0-9]{9}/',
            'Type' => 'required',
            'License' => 'required',
        ], [
            'Name.required' => 'مشخص سازی نام فروشگاه الزامی است!',
            'Address.required' => 'مشخص سازی آدرس فروشگاه الزامی است!',
            'Phone.required' => 'مشخص سازی تلفن ثابت فروشگاه الزامی است!',
            'Phone.max' => 'شماره تلفن نامعتبر است!',
            'Phone.min' => 'شماره تلفن نامعتبر است!',
            'Mobile.required' => 'مشخص سازی شماره همراه فروشگاه الزامی است!',
            'Mobile.max' => 'شماره موبایل حداکثر 11 رقم میباشد!',
            'Mobile.min' => 'شماره موبایل حداقل 11 رقم میباشد!',
            'Mobile.regex' => 'شماره موبایل صحیح نمیباشد! ()شماره موبایل صحیح: 09128765432',
            'Type.required' => 'مشخص سازی تلفن ثابت فروشگاه الزامی است!',
            'License.required' => 'مشخص سازی مجوز فروشگاه الزامی است!',
        ]);

        if ($request->input('submit') == 'AddStore') {
            $StoreData = [
                'Name' => $request->input('Name'),
                'Address' => $request->input('Address'),
                'Phone' => $request->input('Phone'),
                'Mobile' => $request->input('Mobile'),
                'Owner' => $request->input('owner'),
                'Type' => $request->input('Type'),
                'Field' => $request->input('Field'),
                'License' => $request->input('License'),
                'Pic' => $request->input('pic'),
                'Description' => $request->input('ce'),
                'Malek' => $request->input('ownername'),
            ];
            $result = ModelsStore::where('id', $id)->update($StoreData);
            return redirect()->back()->with('success', __("success alert"));
        }
    }
}
