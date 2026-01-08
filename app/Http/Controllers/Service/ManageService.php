<?php

namespace App\Http\Controllers\Service;

use App\Functions\TashimClass;
use App\Functions\TextClassMain;
use App\Http\Controllers\Controller;
use App\Models\branch_cat_orders;
use App\Models\catorder;
use App\Models\RespnsType;
use Illuminate\Http\Request;
use App\Models\UserCreditIndex;
use App\Models\WorkCat;
use App\Models\L1Work;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\tashim;
use App\myappenv;
use DB;
use Illuminate\Support\Facades\Log;
use Auth;
use stdClass;

class ManageService extends Controller
{
    public function branch_order_req()
    {
        $Query = "SELECT branch_cat_orders.* , catorder.TitleDescription ,catorder.Pic ,branches.Name as branch_name FROM branch_cat_orders INNER JOIN catorder on branch_cat_orders.catorder = catorder.id and branch_cat_orders.Status = 50 INNER JOIN branches on branch_cat_orders.branch = branches.id";
        $pending_request = DB::select($Query);
        return view('Service.CatOrder_request', ['pending_request' => $pending_request]);
    }
    public function do_branch_order_req(Request $request)
    {
        if ($request->has('confirm_cat_to_branch')) {
            $confirm_cat_to_branch = $request->confirm_cat_to_branch;
            branch_cat_orders::where('id', $confirm_cat_to_branch)->update(['Status' => 100]);
            return redirect()->back()->with('success', 'عملیات موفق');
        }
    }
    private function edit_instance_cat_order($id)
    {
        $user_branch = Auth::user()->branch;

        $order_src = branch_cat_orders::where('id', $id)->where('branch', $user_branch)->first();
        if ($order_src == null) {
            return abort('404');
        }
        $order_meta_src  = catorder::where('id', $order_src->catorder)->first();
        return view('Service.EditCatOrder_instance', ['order_src' => $order_src, 'order_meta_src' => $order_meta_src]);
    }
    private function do_edit_instance_cat_order($id, Request $request)
    {
        if ($request->has('submit')) {
            if ($request->submit == 'delete') {
                $user_branch = Auth::user()->branch;
                $order_src = branch_cat_orders::where('id', $id)->where('branch', $user_branch)->first();
                if ($order_src == null) {
                    return abort('404');
                }
                branch_cat_orders::where('id', $id)->where('branch', $user_branch)->delete();

                return redirect()->route('CatOrderList')->with('success', 'عملیات موفقیت آمیز');
            }
        }
        $user_branch = Auth::user()->branch;
        $max_price = $request->max_price ?? 0;
        $min_price = $request->min_price ?? 0;
        if ($min_price > $max_price) {
            return redirect()->back()->with('error', 'مبلغ حذاکثر می باید از مبلغ حد اقل بزرگتر باشد!');
        }
        $MainDescription = $request->MainDescription ?? '';
        $OnSale = $request->OnSale ?? 0;
        $show_global = $request->show_global ?? 0;
        if ($show_global == 1) {

            $show_global = 50;
        }
        $show_global =  TextClassMain::StripText($show_global);
        $order_src = branch_cat_orders::where('id', $id)->where('branch', $user_branch)->first();
        if ($show_global == 50) {
            if ($order_src->MainDescription == $MainDescription  && $order_src->Status == 100) {
                $show_global = 100;
            }
        }
        if ($order_src == null) {
            return abort('404');
        }
        $edit_data = [
            'MainDescription' => $MainDescription,
            'max_price' => $max_price,
            'min_price' => $min_price,
            'Status' => $show_global,
            'OnSale' => $OnSale
        ];
        branch_cat_orders::where('id', $id)->where('branch', $user_branch)->update($edit_data);
        if ($show_global == 50) {
            $text_msg = 'درخواست افزودن خدمت توسط مرکز صادر شد  ';
            $text_msg .= json_encode($edit_data);
            Log::channel('slack')->info($text_msg);
        }
        return redirect()->route('CatOrderList')->with('success', 'عملیات موفقیت آمیز');
    }
    public function EditCatOrder($ID)
    {
        $user_branch = Auth::user()->branch;
        if (myappenv::version >= 3 && $user_branch != myappenv::Branch) {
            return $this->edit_instance_cat_order($ID);
        }

        if ($user_branch == myappenv::Branch) {
            $CatOrder = catorder::where('id', $ID)->first();
        } else {
            $CatOrder = catorder::where('id', $ID)->where('branch', $user_branch)->first();
        }
        if ($CatOrder == null) {
            return abort('404', 'درخواست مورد نظر در سامانه وجود ندارد!');
        }
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();

        return view('Service.EditCatOrder', ['RespnsType'=>$CatOrder, 'CatOrder' => $CatOrder ,'WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works]);
    }
    public function DoEditCatOrder($ID, Request $request)
    {
        $user_branch = Auth::user()->branch;
        if (myappenv::version >= 3 && $user_branch != myappenv::Branch) {
            return $this->do_edit_instance_cat_order($ID, $request);
        }

        $UpdateDate = [
            'Cat' => $request->input('RespnsTypeName'),
            'TitleDescription' => $request->input('MainDescription'),
            'MainDescription' => $request->input('ce'),
            'MainIndex' => $request->input('L3Work') ,
            'customer_index' => $request->customer_index ,
            'worker_index' => $request->worker_index ,
            'Pic' => $request->input('pic'),
        ];
        catorder::where('id', $ID)->update($UpdateDate);
        return redirect()->back()->with('success', 'عملیات موفقیت آمیز!');
    }
    private function cloud_order_list()
    {
        $user_branch = Auth::user()->branch;
        $Query = "SELECT branch_cat_orders.id, branch_cat_orders.Status, branch_cat_orders.OnSale,branch_cat_orders.max_price,branch_cat_orders.min_price, catorder.TitleDescription, catorder.Pic  FROM catorder INNER JOIN branch_cat_orders on catorder.id = branch_cat_orders.catorder and branch_cat_orders.branch = $user_branch";
        $order_src = DB::select($Query);
        return view('Service.CatOrderList_instance', ['order_src' => $order_src]);
    }
    public function CatOrderList()
    {
        $user_branch = Auth::user()->branch;
        if (myappenv::version >= 3 && $user_branch != myappenv::Branch) {
            return $this->cloud_order_list();
        }

        if ($user_branch == myappenv::Branch) {
            $Query = "SELECT catorder.*,branches.Name as BranchName from catorder INNER JOIN branches on catorder.branch = branches.id";
            $accesstype = 'center';
            $Catorders = DB::select($Query);
        } else {
            $accesstype = 'branch';
            $Catorders = catorder::where('branch', $user_branch)->get();
        }

        return view('Service.CatOrderList', ['accesstype' => $accesstype, 'Catorders' => $Catorders]);
    }
    private function cloud_cat_order()
    {
        $mian_branch = myappenv::Branch;
        $user_branch = Auth::user()->branch;
        $Query = "SELECT catorder.*,branches.Name as BranchName ,branch_cat_orders.id as branch_cat_orders_id
        from catorder INNER JOIN branches on catorder.branch = branches.id and  branches.id = $mian_branch
        left join branch_cat_orders on branch_cat_orders.catorder = catorder.id and branch_cat_orders.branch = $user_branch ";
        $accesstype = 'center';
        $Catorders = DB::select($Query);
        return view('Service.CatOrderList_main', ['accesstype' => $accesstype, 'Catorders' => $Catorders]);
    }
    public function AddCatOrder()
    {
        if (myappenv::version < 3) {
            return view('Service.AddCatOrder');
        } else { // cloud version
            if (Auth::user()->branch == myappenv::Branch) {
                return view('Service.AddCatOrder');
            } else { //order main
                return $this->cloud_cat_order();
            }
        }
    }
    /**
     * This function related to cloud version of HCIS for make instance of catorder to branch
     */
    private function add_cat_order_to_branch(Request $request)
    {
        $main_catorder = $request->add_cat_to_branch;
        $insert_data = [
            'catorder' => $main_catorder,
            'branch' => Auth::user()->branch,
            'Status' => 0,
            'OnSale' => 0,
        ];
        $insert_src =  branch_cat_orders::create($insert_data);
        return redirect()->route('EditCatOrder', ['ID' => $insert_src->id]);
    }

    public function DoAddCatOrder(Request $request)
    {
        if (Auth::user()->branch == myappenv::Branch) {
            $CatType = 1;
        } else {
            $CatType = 2;
        }
        if ($request->input('submit') == 'AddService') {
            $DataToSave = [
                'Cat' => $request->input('RespnsTypeName'),
                'Pic' => $request->input('pic'),
                'TitleDescription' => $request->input('MainDescription'),
                'MainDescription' => $request->input('ce'),
                'Branch' => Auth::user()->branch,
                'center_id' => Auth::user()->branch,
                'CatType' => $CatType,
                'Status' => 1
            ];
            catorder::create($DataToSave);
            return redirect()->route('CatOrderList')->with('success', 'نوع درخواست با موفقیت اضافه گردید!');
        }
        if ($request->has('add_cat_to_branch')) {
            return $this->add_cat_order_to_branch($request);
        }
    }


    public function Editservice($ServiceID)
    {
        $user_branch = Auth::user()->branch;
        if (myappenv::version < 3) {
            $usercreditindexs = UserCreditIndex::all()->where('IndexType', 1);
        } else {
            $usercreditindexs = UserCreditIndex::where('IndexType', 1)->where('branch', $user_branch)->get();
        }
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();
        $QeryRespons = "SELECT RespnsType.id,RespnsType.price_type, RespnsType.RespnsTypeName,RespnsType.ImgURL, RespnsType.hPrice, RespnsType.fixPrice, RespnsType.CustomerhPrice, RespnsType.CustomerfixPrice , RespnsType.UserCreditIndex , UserCreditIndex.IndexName FROM RespnsType LEFT JOIN UserCreditIndex on RespnsType.UserCreditIndex = UserCreditIndex.IndexID";
        $Services = DB::select($QeryRespons);

        if (myappenv::Branch == $user_branch) {
            $RespnsType = RespnsType::where('id', $ServiceID)->first();
        } else {
            $RespnsType = RespnsType::where('id', $ServiceID)->where('branch', $user_branch)->first();
        }
        if ($RespnsType == null) {
            return abort('404', 'خدمت درخواست شده در سامانه وجود ندارد!');
        }
        $Tashim = new TashimClass();
        $TashimSrc = $Tashim->get_all_tashims();
        return view('Service.EditService', ['TashimSrc' => $TashimSrc, 'usercreditindexs' => $usercreditindexs, 'Services' => $Services, 'WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works, 'RespnsType' => $RespnsType]);
    }
    private function Edit_service(Request $request, int $TargetID)
    {
        $OldSrc =  RespnsType::where('id', $TargetID)->first();
        $ServiceType = $this->define_service_type($request->input('ServiceType'));
        if ($request->has('center_id')) {
            $center_id = $request->center_id;
            $duplicate_row = RespnsType::where('center_id', $center_id)->where('branch', Auth::user()->branch)->get();
            foreach ($duplicate_row as $duplicate_row_item) {
                if ($duplicate_row_item->id != $TargetID) {
                    return redirect()->back()->with('error', 'کد خدمت وارد شده در سامانه وجود دارد');
                }
            }
        } else {
            $center_id = $TargetID;
        }
        if ($request->tashim == null || $request->tashim == 0) {
            $defult_tashim = tashim::where('extra', 'defualt')->first();

            $tashim = $defult_tashim->id ?? 0;
        } else {
            $tashim = $request->tashim;
        }
        $serviceData = [
            'center_id' => $center_id,
            'branch' => Auth::user()->branch,
            'price_type' => $request->price_type,
            'ServiceType' => $ServiceType,
            'customer_index' => $request->customer_index ?? $OldSrc->customer_index,
            'worker_index' => $request->worker_index ?? $OldSrc->worker_index,
            'RespnsTypeName' => $request->input('RespnsTypeName'),
            'Description' => $request->input('MainDescription'),
            'CustomerhPrice' => $request->input('CustomerhPrice') ?? 0,
            'CustomerfixPrice' => $request->input('CustomerfixPrice') ?? 0,
            'fixPrice' => $request->input('fixPrice') ?? 0,
            'hPrice' => $request->input('hPrice') ?? 0,
            'UserCreditIndex' => $request->input('UserCreditIndex'),
            'Status' => $request->input('Status'),
            'MainIndex' => $request->input('L3Work') ?? $OldSrc->MainIndex,
            'MainDescription' => $request->input('ce'),
            'tashim' => $tashim,
            'ImgURL' => $request->input('pic')
        ];


        $resultID = RespnsType::where('id', $TargetID)->update($serviceData);
        return redirect()->back()->with('success', __("success alert"));
    }
    public function DoEditservice(Request $request, $ServiceID)
    {
        if ($request->input('submit') == 'EditeService') {
            return $this->Edit_service($request, $ServiceID);
        }
        if ($request->input('submit') == 'submit_tashim') {
            return $this->service_edit_tashim($request, $ServiceID);
        }
    }
    private function service_edit_tashim(Request $request, int $TargetID)
    {
        if (isset($request->tashim)) {
            $tashim_arr = $request->tashim;
        } else {
            $tashim_arr = [];
        }
        $user_branch = Auth::user()->branch;
        $main_service_src  = RespnsType::where('id', $TargetID)->where('branch', $user_branch)->first();
        if ($main_service_src == null) {
            return abort('404', 'خدمت درخواست شده وجود ندارد!');
        }
        $extra = $main_service_src->extra;
        if ($extra == null) {
            $extra = new  stdClass;
        } else {
            $extra = json_decode($extra);
        }
        $extra->tashim = $tashim_arr;
        $extra = json_encode($extra);
        RespnsType::where('id', $TargetID)->where('branch', $user_branch)->update(['extra'=>$extra]);
        return redirect()->back()->with('success','عملیات با موفقیت انجام شد!');
    }
    public function ServiceList()
    {
        $user_branch = Auth::user()->branch;
        if (myappenv::Branch == $user_branch) {
            $QeryRespons = "SELECT RespnsType.center_id , RespnsType.customer_index , RespnsType.worker_index ,RespnsType.id as RespnsTypeID, RespnsType.RespnsTypeName,RespnsType.ImgURL, RespnsType.hPrice, RespnsType.fixPrice, RespnsType.CustomerhPrice, RespnsType.CustomerfixPrice , RespnsType.UserCreditIndex , UserCreditIndex.IndexName , L3Work.Name as Minindexname FROM RespnsType LEFT JOIN L3Work on L3Work.UID = RespnsType.MainIndex  LEFT JOIN UserCreditIndex on RespnsType.UserCreditIndex = UserCreditIndex.IndexID  ";
        } else {
            $QeryRespons = "SELECT RespnsType.center_id , RespnsType.customer_index , RespnsType.worker_index ,RespnsType.id as RespnsTypeID, RespnsType.RespnsTypeName,RespnsType.ImgURL, RespnsType.hPrice, RespnsType.fixPrice, RespnsType.CustomerhPrice, RespnsType.CustomerfixPrice , RespnsType.UserCreditIndex , UserCreditIndex.IndexName , L3Work.Name as Minindexname FROM RespnsType LEFT JOIN L3Work on L3Work.UID = RespnsType.MainIndex  LEFT JOIN UserCreditIndex on RespnsType.UserCreditIndex = UserCreditIndex.IndexID  where RespnsType.branch =  $user_branch";
        }
        $Services = DB::select($QeryRespons);
        return view("Service.ServiceList", ['Services' => $Services]);
    }
    public function Addservice()
    {
        $user_branch = Auth::user()->branch;
        if (myappenv::version < 3) {
            $usercreditindexs = UserCreditIndex::all()->where('IndexType', 1);
        } else {
            $usercreditindexs = UserCreditIndex::where('IndexType', 1)->where('branch', $user_branch)->get();
        }

        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();
        $Tashim = new TashimClass();
        $TashimSrc = $Tashim->get_all_tashims();
        $QeryRespons = "SELECT RespnsType.id,RespnsType.price_type, RespnsType.RespnsTypeName,RespnsType.ImgURL, RespnsType.hPrice, RespnsType.fixPrice, RespnsType.CustomerhPrice, RespnsType.CustomerfixPrice , RespnsType.UserCreditIndex , UserCreditIndex.IndexName FROM RespnsType LEFT JOIN UserCreditIndex on RespnsType.UserCreditIndex = UserCreditIndex.IndexID";
        $Services = DB::select($QeryRespons);
        return view('Service.AddService', ['TashimSrc' => $TashimSrc, 'usercreditindexs' => $usercreditindexs, 'Services' => $Services, 'WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works]);
    }
    private function define_service_type($ServiceType)
    {
        switch ($ServiceType) {
            case 'nomony':
                $price_type = 1;
                break;
            case 'withmony':
                $price_type = 2;
                break;
            case 'sharik':
                $price_type = 3;
                break;

            default:
                $price_type = 2;
                break;
        }
        return $price_type;
    }
    private function add_service(Request $request)
    {

        $resultID = RespnsType::max('id');
        if ($resultID != null) {
            $TargetID = $resultID + 1;
        } else {
            $TargetID = 1;
        }
        $ServiceType = $this->define_service_type($request->input('ServiceType'));
        if ($request->has('center_id') && $request->center_id != null) {
            $center_id = $request->center_id;
            $duplicate_row = RespnsType::where('center_id', $center_id)->where('branch', Auth::user()->branch)->first();
            if ($duplicate_row != null) {
                return redirect()->back()->with('error', 'کد خدمت وارد شده در سامانه وجود دارد');
            }
        } else {
            $center_id = $TargetID;
        }
        if ($request->tashim == null || $request->tashim == 0) {
            $defult_tashim = tashim::where('extra', 'defualt')->first();
            $tashim = $defult_tashim->id ?? 0;
        } else {
            $tashim = $request->tashim;
        }
        $serviceData = [
            'id' => $TargetID,
            'center_id' => $center_id,
            'OnSale' => true,
            'branch' => Auth::user()->branch,
            'used' => 0,
            'price_type' => $request->price_type,
            'ServiceType' => $ServiceType,
            'customer_index' => $request->customer_index,
            'worker_index' => $request->worker_index,
            'RespnsTypeName' => $request->input('RespnsTypeName'),
            'Description' => $request->input('MainDescription'),
            'CustomerhPrice' => $request->input('CustomerhPrice') ?? 0,
            'CustomerfixPrice' => $request->input('CustomerfixPrice') ?? 0,
            'fixPrice' => $request->input('fixPrice') ?? 0,
            'hPrice' => $request->input('hPrice') ?? 0,
            'UserCreditIndex' => $request->input('UserCreditIndex'),
            'Status' => $request->input('Status'),
            'MainIndex' => $request->input('L3Work'),
            'MainDescription' => $request->input('ce'),
            'tashim' => $tashim,
            'ImgURL' => $request->input('pic')
        ];


        $resultID = RespnsType::create($serviceData);
        return redirect()->back()->with('success', __("success alert"));
    }
    public function DoAddservice(Request $request)
    {

        if ($request->input('submit') == 'AddService') {
            return  $this->add_service($request);
        }
    }
}
