<?php

namespace App\Deal;

use App\Models\deal_file_dealers;
use App\Models\deal_file_pic;
use App\Models\deal_product_type;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Support\Facades\DB;

class DealBase
{
    public static function get_deals_with_cat($catid){
        $query = "SELECT df.* ,dfp.pic from deal_file df left join deal_file_pic dfp on df.id  = dfp.deal_file  where df.status > 100 and df.post_cat = $catid ";
        return DB::select($query);

    }
    public function get_product_type()
    {
        $product_type = deal_product_type::all();
        return $product_type;
    }
    public function get_post_cats(){
        $WorkCat = myappenv::PostIndexWorkCat;
        $L1IDCat = myappenv::NewsCatL1;
        $L2IDCat = myappenv::NewsCatL2;
        $Query = "SELECT * FROM L3Work LEFT JOIN item_index  on item_index.IndexID = L3Work.UID WHERE WorkCat = $WorkCat and L1ID = $L1IDCat and L2ID = $L2IDCat ";
        $cats = DB::select($Query);
        return $cats;
    }
    public function get_all_oprators()
    {
        $operator_role = myappenv::role_worker;
        $operator_src = UserInfo::where('Role', $operator_role)->where('status', '>', 100)->get();
        return $operator_src;
    }
    public function get_file_dealers($file_id)
    {
        $query = "SELECT ui.* FROM  deal_file_dealers dfd inner join UserInfo ui on ui.UserName = dfd.UserName  WHERE  dfd.deal_file  = $file_id";
        $result = DB::select($query);
        return $result;
    }
    public function get_product_type_by_id($product_type_id)
    {
        $type_src = deal_product_type::find($product_type_id);
        return $type_src->Name;
    }
    public function deal_type()
    {
        return array(
            '1' => 'فروش نقدی',
            '2' => 'فروش اقساطی'
        );

    }
    public function call_subject()
    {
        return array(
            '1' => 'استعلام قیمت',
            '2' => 'مشتاق خرید',
            '3' => 'مایل به همکاری',
            '90' => 'سرکاری',
        );

    }
    public function get_call_subject($subject_id)
    {
        $call_subject = $this->call_subject();
        foreach ($call_subject as $key => $value) {
            if ($subject_id == $key) {
                return $value;
            }
        }
    }
    public function call_type()
    {
        return array(
            '1' => 'یک ستاره',
            '2' => 'دو ستاره',
            '3' => 'سه ستاره',
            '4' => 'چهار ستاره',
            '5' => 'پنج ستاره',
        );

    }
    public function get_call_type($type_id)
    {
        $call_type = $this->call_type();
        foreach ($call_type as $key => $value) {
            if ($type_id == $key) {
                return $value;
            }
        }
    }

    public function get_deal_type($deal_type_id)
    {
        $deal_type = $this->deal_type();
        foreach ($deal_type as $key => $value) {
            if ($deal_type_id == $key) {
                return $value;
            }
        }
    }
    public function get_dealer_files($username)
    {
        $query = "SELECT df.*,dfd.created_at as assign_date from deal_file_dealers dfd inner join deal_file df on dfd.deal_file = df.id WHERE dfd.UserName = '$username'";
        return DB::select($query);
    }
    public function get_deal_file_pics($deal_id)
    {
        $img_src = deal_file_pic::where('deal_file', $deal_id)->get()->toArray();
        return $img_src;

    }
    public function is_file_related_to_dealer($dealer_id, $file_id)
    {
        $worker_src = deal_file_dealers::where('deal_file', $file_id)->where('UserName', $dealer_id);
        if ($worker_src == null) {
            return false;
        }
        return true;

    }
    public function my_un_defined_calls($username)
    {
        $query = "SELECT c.* , ui.Name,ui.Family from Calls c left join UserInfo ui on c.CallerUser = ui.UserName where AnswerUser = '$username' and deal is null ";
        return DB::select($query);
    }

}