<?php

namespace App\Shop;

use App\Models\product_marked;
use Illuminate\Support\Facades\DB;

class ProductMark
{
    public function remove_mark(string $username, int $product_id, int $markType)
    {
        product_marked::where("UserName", $username)->where("product_id", $product_id)->where('mark_type', $markType)->delete();
        return true;
    }
    public function is_marked_before(string $username, int $product_id, int $markType)
    {
        $result = product_marked::where("UserName", $username)->where("product_id", $product_id)->where('mark_type', $markType)->first();
        if ($result == null) {
            return false;
        }
        return true;
    }

    public function mark_a_product(string $username, int $product_id, int $markType)
    {
        if ($this->is_marked_before($username, $product_id, $markType)) {
            return [
                'result' => false,
                'msg' => 'The product marked before by user'
            ];
        }
        $insert_data = [
            'UserName' => $username,
            'product_id' => $product_id,
            'mark_type' => $markType
        ];
        $result = product_marked::create($insert_data);
        return [
            'result' => true,
            'data' => $result
        ];

    }

    public function get_my_marked_products(string $username, int $markType)
    {

        $query = "SELECT g.NameFa , g.id , g.ImgURL from goods g  inner join product_markeds pm  on g.id  = pm.product_id WHERE pm.UserName = '$username' and pm.mark_type = $markType";
        $result = DB::select($query);
        return $result;
    }


}