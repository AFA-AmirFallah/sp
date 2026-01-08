<?php

namespace App\Http\Controllers\spa;

use App\Http\Controllers\Controller;
use App\Models\catorder;
use App\Models\goods;
use Illuminate\Http\Request;

class main_spa extends Controller
{
    private function get_service_list(Request $request)
    {
        $service_index = $request->service_index;
        $cat_order_src = catorder::where('CatType', $service_index)->get();
        return $cat_order_src;
    }
    private function customer_first_page_init(Request $request)
    {
    }
    private function get_shop_first_page(Request $request)
    {
        $swiper = [
            'https://sepehrmall.com/images/thumbs/0004193_homepage_maincover_932.jpeg',
            'https://sepehrmall.com/images/thumbs/0004141_homepage_maincover_932.jpeg',
            'https://sepehrmall.com/images/thumbs/0004273_homepage_maincover_932.jpeg'
        ];
        $swiper_goods =  goods::where('id', '<', 30)->get();
        $first_page = [
            'main_swiper' => $swiper,
            'swiper_goods'=>$swiper_goods

        ];
        return $first_page;
       
    }
    private function get_product_info(Request $request){
        $product_id = $request->product_id;
        $product_src = goods::where('id',$product_id)->first();
        $product_data =[
            'product_src'=>$product_src,
            'warehouse_src'=>null //TODO: send warehouse data
        ];
        return $product_data;
    }
    private function customer_controller(Request $request)
    {
        switch ($request->function) {
            case 'get_first_page_init':
                return $this->customer_first_page_init($request);
            case 'get_service_list':
                return $this->get_service_list($request);
            case 'get_shop_first_page':
                return $this->get_shop_first_page($request);
            case 'get_shop_first_page':
                return $this->get_shop_first_page($request);
            case 'get_product_info':
                return $this->get_product_info($request);
            default:
                return false;
        }
    }
    public function handler(Request $request)
    {
        if ($request->axios) { // send by vuejs
            if ($request->type == 'customer') {
                return $this->customer_controller($request);
            }
        }
    }
}
