<?php

namespace App\Deal;

use App\Models\deal_file;
use App\Models\deal_file_pic;
use App\Models\L3Work;
use Illuminate\Support\Facades\Auth;

class DealFiles extends DealBase
{


    public static function get_post_cats_deatil($cat_id)
    {
        if ($cat_id == 0) {
            return 'بدون دسته بندی';
        }
        $Cats = L3Work::where('UID', $cat_id)->first();
        return $Cats->Name;
    }
    public static function get_product_cat($cat)
    {
        switch ($cat) {
            case "1":
                $page_title = 'کامیون';
                break;
            case "2":
                $page_title = 'کامیونت';
                break;
            case "3":
                $page_title = 'کشنده';
                break;
            case "4":
                $page_title = 'خودروی اقساطی';
                break;
            default:
                $page_title = 'خودرو';
                break;
        }

        return $page_title;
    }
    public static function get_deal_info($show_count, $oder_by)
    {
        $branch = env('Branch');
        $deal_src = deal_file::where('status', 101)->where('branch', $branch)->orderBy('id', $oder_by)->take($show_count)->get();
        return $deal_src;
    }
    public static function get_deal_file_min_pic($deal_id)
    {
        $img_src = deal_file_pic::where('deal_file', $deal_id)->first();
        return $img_src;
    }


    public function edit_file($file_id, $input)
    {
        $file_data = [
            "product_type" => $input['product_type'],
            "deal_type" => $input['deal_type'],
            'post_cat' => $input['post_cat'],
            "title" => $input['title'],
            "show_price" => $input['show_price'],
            "description" => $input['description'],
            "min_price" => $input['min_price'],
            "max_price" => $input['max_price'],
            "owner" => $input['owner'],
            "pelak" => $input['pelak'],
            "vin" => $input['vin'],
            "dealer_note" => $input['dealer_note'],
            "branch" => $input['branch'],
        ];
        $insert_result = deal_file::where('id', $file_id)->update($file_data);
        return true;
    }
    public function add_file($input)
    {
        $file_data = [
            "creator" => Auth::id(),
            "product_type" => $input['product_type'],
            "deal_type" => $input['deal_type'],
            'post_cat' => $input['post_cat'],
            "title" => $input['title'],
            "show_price" => $input['show_price'],
            "description" => $input['description'],
            "min_price" => $input['min_price'],
            "max_price" => $input['max_price'],
            "owner" => $input['owner'],
            "pelak" => $input['pelak'],
            "vin" => $input['vin'],
            "branch" => $input['branch'],
            'status' => 0,
            'properties' => '',
            'actions' => '',
            "dealer_note" => $input['dealer_note'],
        ];
        $insert_result = deal_file::create($file_data);
        return $insert_result->id;
    }
}
