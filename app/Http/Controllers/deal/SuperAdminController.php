<?php

namespace App\Http\Controllers\deal;

use App\Deal\DealBase;
use App\Deal\DealFiles;
use App\Functions\TextClassMain;
use App\Http\Controllers\Controller;
use App\Models\branches;
use App\Models\deal_file;
use App\Models\deal_file_dealers;
use App\Models\deal_file_pic;
use App\Models\provinces;
use App\myappenv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function deal_search()
    {

        if (Auth::user()->role == myappenv::role_SuperAdmin) {
            $deal_functions = new DealBase();
            $branches = branches::all();
            return view('deal.deal_search', ['deal_functions' => $deal_functions, 'branches' => $branches]);
        } else {
            $deals = deal_file::where('owner', Auth::id())->get();
            return view('Layouts.Theme9.my_deal', ['deals' => $deals]);
        }

    }
    public function Dodeal_search(Request $request)
    {
        $condition = "where 12 = 12 ";
        if ($request->branch != null) {
            $branch = $request->branch;
            $condition .= "and df.branch = $branch ";
        }
        $Query = "SELECT
	df.id,
	df.title,
	df.created_at,
	df.status,
    b.Name as branch_name,
	GROUP_CONCAT(CONCAT(ui.Name,' ',ui.Family) ) as  operator
from
	deal_file df
    inner join branches as b on b.id = df.branch
left join deal_file_dealers dfd on
	df.id = dfd.deal_file
LEFT JOIN UserInfo ui on
	ui.UserName = dfd.UserName
$condition
GROUP  BY 	df.id,b.Name,
	df.title,
	df.created_at,
	df.status";
        $deals_src = DB::select($Query);
        return view('deal.deal_list', ['deals_src' => $deals_src]);
    }
    public function setting_admins($file_id)
    {
        $deal_functions = new DealBase();
        $deal_src = deal_file::where('id', $file_id)->first();
        $operator_src = $deal_functions->get_all_oprators();
        $dealers = $deal_functions->get_file_dealers($file_id);
        if ($deal_src == null) {
            return abort(404, 'فایل درخواست شده وجود ندارد');
        }
        return view("deal.setting_admins", ['deal_functions' => $deal_functions, 'deal_src' => $deal_src, 'file_id' => $file_id, 'operator_src' => $operator_src, 'dealers' => $dealers]);

    }
    public function Dosetting_admins($file_id, Request $request)
    {
        if ($request->has('submit')) {
            deal_file::where('id', $file_id)->update(['status' => $request->submit]);
            return redirect()->back()->with('success', 'تغییر وضعیت انجام شد!');
        }
    }
    public function edit_admins($file_id)
    {
        $deal_functions = new DealBase();
        $deal_src = deal_file::where('id', $file_id)->first();
        $operator_src = $deal_functions->get_all_oprators();
        $dealers = $deal_functions->get_file_dealers($file_id);
        if ($deal_src == null) {
            return abort(404, 'فایل درخواست شده وجود ندارد');
        }
        return view("deal.edit_admins", ['deal_functions' => $deal_functions, 'deal_src' => $deal_src, 'file_id' => $file_id, 'operator_src' => $operator_src, 'dealers' => $dealers]);
    }
    public function Doedit_admins($file_id, Request $request)
    {
        if ($request->has('delete')) {
            $UserName = $request->delete;
            deal_file_dealers::where('deal_file', $file_id)->where('UserName', $UserName)->delete();
            return redirect()->back()->with('success', 'کارشناس حذف شد');
        }
        if ($request->submit == 'add_operator') {
            $UserName = $request->oprator;
            $dealer_old = deal_file_dealers::where('deal_file', $file_id)->where('UserName', $UserName)->first();
            if ($dealer_old != null) {
                return redirect()->back()->with('error', 'کارشناس از قبل وجود داشته است!');
            }
            $dealer = [
                'deal_file' => $file_id,
                'UserName' => $UserName
            ];
            deal_file_dealers::create($dealer);
            return redirect()->back()->with('success', 'کارشناس به فایل اضافه شد!');
        }

    }
    public function edit_properties($file_id)
    {
        $deal_functions = new DealBase();
        $deal_src = deal_file::where('id', $file_id)->first();
        $properties = $deal_src->properties;
        if ($properties == null) {
            $properties = [];
        } else {
            $properties = json_decode($properties, true);
        }
        if ($deal_src == null) {
            return abort(404, 'فایل درخواست شده وجود ندارد');
        }

        return view("deal.edit_properties", ['deal_functions' => $deal_functions, 'deal_src' => $deal_src, 'file_id' => $file_id, 'properties' => $properties]);
    }
    public function Doedit_properties($file_id, Request $request)
    {
        $item_name = $request->item_name;
        $item_value = $request->item_value;
        $specs = [];
        foreach ($item_name as $key => $value) {
            if ($value != null) {
                $spec = [
                    'name' => $value,
                    'value' => $item_value[$key]
                ];
                array_push($specs, $spec);
            }
        }
        deal_file::where('id', $file_id)->update(['properties' => $specs]);
        return redirect()->back()->with('success', 'مشخصات به روز شد!');
    }

    public function edit_pic($file_id)
    {
        $deal_functions = new DealBase();
        $img_src = deal_file_pic::where('deal_file', $file_id)->get();
        $deal_src = deal_file::where('id', $file_id)->first();
        if ($deal_src == null) {
            return abort(404, 'فایل درخواست شده وجود ندارد');
        }

        return view("deal.edit_pic", ['deal_functions' => $deal_functions, 'deal_src' => $deal_src, 'file_id' => $file_id, 'img_src' => $img_src]);
    }
    public function Doedit_pic($file_id, Request $request)
    {
        if ($request->has('delete')) {
            $img_src = deal_file_pic::where('id', $request->delete)->first();
            $file = substr($img_src->pic, strlen(url('/')) + 1);
            if (file_exists($file)) {
                if (unlink($file)) {
                    deal_file_pic::where('id', $request->delete)->delete();
                    return redirect()->back()->with('success', 'حذف انجام شد');
                } else {
                    return redirect()->back()->with('error', 'حذف نا موفق ');
                }
            } else {
                return redirect()->back()->with('error', 'فایل درخواستی وجود ندارد!');
            }


        }

        if ($request->input('submit') == 'UpdateIMG') {
            if ($request->file('avatar')) {
                $request->validate([
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
                ]);
                $Mytext = new TextClassMain();
                $avatarName = $Mytext->StrRandom() . '.' . request()->avatar->getClientOriginalExtension();
                $request->avatar->storeAs('public/avatar', $avatarName);
                $pic_src = url('/') . '/storage/avatar/' . $avatarName;
                $img_src = [
                    'deal_file' => $file_id,
                    'pic' => $pic_src,
                ];
                deal_file_pic::create($img_src);
                return back()->with('success', __('You have successfully upload image.'));
            }
        }
    }
    private function coustomer_add_file()
    {
        $deal_functions = new DealBase();
        $Provinces = provinces::all();
        return view('Layouts.Theme9.add_deal', ['Provinces' => $Provinces, 'deal_functions' => $deal_functions]);
    }
    public function add_file()
    {
        if (Auth::user()->Role < myappenv::role_customer) {
            return abort('404', 'شما دسترسی به این قابلیت ندارید');

        }
        if (Auth::user()->Role == myappenv::role_customer) {
            return $this->coustomer_add_file();
        }
        $deal_functions = new DealBase();
        $branches = branches::all();
        return view("deal.Deal", ['deal_functions' => $deal_functions, 'deal_src' => null, 'file_id' => null, 'branches' => $branches]);
    }
    public function Doadd_file(Request $request)
    {
        if ($request->ajax()) {
            $deal_functions = new DealFiles();
            $add_result = $deal_functions->add_file($request->input());


        }
        if ($request->hasFile('files')) {
            $file_data = [
                "creator" => Auth::id(),
                "product_type" => $request->product_type,
                "deal_type" => $request->deal_type,
                'post_cat' => $request->post_cat,
                "title" => $request->title,
                "show_price" => $request->show_price,
                "description" => $request->description,
                "min_price" => 0,
                "max_price" => 0,
                "owner" => Auth::id(),
                "pelak" => '',
                "vin" => '',
                "branch" => 1,
                'status' => 0,
                'properties' => '',
                'actions' => '',
                "dealer_note" => '',
            ];
            $insert_result = deal_file::create($file_data);
            $uploadedFiles = $request->file('files');
            $paths = [];

            foreach ($uploadedFiles as $file) {
                $mytext = new TextClassMain();
                $RequestUser = Auth::id();
                $file_name = $mytext->StrRandom() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("public/document/$RequestUser/", $file_name);
                $img_src = [
                    //https://rayandiesel.co/storage/document/7v6o3leqzzkg03v7/6mysfckj1g6g8qe2.png
                    'deal_file' => $insert_result->id,
                    'pic' => 'https://rayandiesel.co/storage/document/' . $RequestUser . '/' . $file_name,
                ];
                deal_file_pic::create($img_src);
                $paths[] = $path;
            }

            return response()->json([
                'message' => 'آپلود موفقیت‌آمیز بود!',
                'files' => $paths
            ]);
        }
        if ($request->submit == 'add_file') {
            $deal_functions = new DealFiles();
            $add_result = $deal_functions->add_file($request->input());
            return redirect()->route('edit_file', ['file_id' => $add_result]);
        }
    }
    public function edit_file($file_id)
    {
        $deal_functions = new DealBase();
        $branches = branches::all();
        $deal_src = deal_file::where('id', $file_id)->first();
        if ($deal_src == null) {
            return abort(404, 'فایل درخواست شده وجود ندارد');
        }

        return view("deal.Deal", ['branches' => $branches, 'deal_functions' => $deal_functions, 'deal_src' => $deal_src, 'file_id' => $file_id]);
    }
    public function Doedit_file($file_id, Request $request)
    {
        $deal_functions = new DealFiles();
        $add_result = $deal_functions->edit_file($file_id, $request->input());
        return redirect()->back()->with('success', 'عملیات موفق');

    }

}
