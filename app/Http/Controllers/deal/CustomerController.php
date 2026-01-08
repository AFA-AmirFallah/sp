<?php

namespace App\Http\Controllers\deal;

use App\Deal\DealBase;
use App\Http\Controllers\Controller;
use App\Models\deal_file;
use App\Models\deal_file_dealers;
use App\Models\deal_file_pic;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class CustomerController extends Controller
{
    public function contact()
    {
        return view("Layouts.Theme6.contact");
    }
    public function Docontact() {}

    public function deals(Request $request, $cat = null)
    {
        $branch = env('Branch') ?? myappenv::Branch;
        $search = $request->input('q');
        $cat_id = $request->input('cat_id');

        switch ($cat) {
            case "1":
                $page_title = 'فروش انواع کامیون';
                $product_filter = "and product_type = 1";
                break;
            case "2":
                $page_title = 'فروش انواع کامیونت';
                $product_filter = "and product_type = 2";
                break;
            case "3":
                $page_title = 'فروش انواع کشنده';
                $product_filter = "and product_type = 3";
                break;
            case "4":
                $page_title = 'فروش انواع خودروی اقساطی';
                $product_filter = "and product_type = 1";
                break;
            default:
                $page_title = 'فروش انواع خودرو';
                $product_filter = "";
        }

        $search_filter = '';
        if ($search) {
            $search = trim(addslashes($search));
            $search_filter .= " AND (df.title LIKE '%{$search}%' OR df.description LIKE '%{$search}%')";
        }

        $cat_filter = '';
        if ($cat_id) {
            $cat_filter = " AND df.post_cat = '{$cat_id}'";
        }

        $query = "
            SELECT df.*, dfp.pic
            FROM deal_file df
            INNER JOIN deal_file_pic dfp ON df.id = dfp.deal_file
            WHERE df.status > 100
                AND df.branch = {$branch}
                {$product_filter}
                {$search_filter}
                {$cat_filter}
            ORDER BY df.id DESC
        ";

        $file_src = DB::select($query);
        $deal_functions = new DealBase;

        return view("Layouts.Theme6.deals", [
            'file_src' => $file_src,
            'page_title' => $page_title,
            'deal_functions' => $deal_functions,
            'search' => $search,
            'cat_id' => $cat_id,
        ]);
    }

    public function Dodeals($cat = null, Request $request) {}
    public function files($file_id, $file_name = null)
    {
        $deal_function = new DealBase();
        if (Auth::check()) {
            if (Auth::user()->Role > myappenv::role_admin) {
                $file_src = deal_file::where('id', $file_id)->first();
            } else {
                // $file_src = deal_file::where('id', $file_id)->where('status', '>', 100)->where('branch',env('Branch'))->first();
                $file_src = deal_file::where('id', $file_id)->where('status', '>', 100)->first();
            }
        } else {
            // $file_src = deal_file::where('id', $file_id)->where('status', '>', 100)->where('branch',env('Branch'))->first();
            $file_src = deal_file::where('id', $file_id)->where('status', '>', 100)->first();
        }

        if ($file_src == null) {
            return abort('404');
        }
        $properties = $file_src->properties;
        if ($properties == null) {
            $properties = [];
        } else {
            $properties = json_decode($properties, true);
        }
        $dealers = $deal_function->get_file_dealers($file_id);
        $product_type = $deal_function->get_product_type_by_id($file_src->product_type);

        $img_src = deal_file_pic::where('deal_file', $file_id)->get();
        return view("Layouts.Theme6.files", ['deal_function' => $deal_function, 'file_src' => $file_src, 'img_src' => $img_src, 'properties' => $properties, 'dealers' => $dealers, 'product_type' => $product_type]);
    }
    public function Dofiles() {}
}
