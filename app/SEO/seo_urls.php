<?php

namespace App\SEO;

use App\Functions\NewsClass;
use App\Functions\OrderRequestClass;
use App\Http\Controllers\Order\OrderRequest;
use App\Models\metadata;
use App\myappenv;
use Illuminate\Support\Facades\Auth;

class seo_urls
{
    /**
     * seo metadata structure:
     * tt -> seo_url (Table name)
     * fgint -> post_is or good_id 
     * fgstr -> username for family 
     * meta_key -> main table src
     * meta_value -> input address
     * status -> upper than 100 is active 
     */
    private $input_address;
    private $input_address_src;


    private function get_address_type()
    {
        /**
         * this function return type of address:
         * user -> for family link
         * good -> for product show
         * post -> for news
         */
        return $this->input_address_src->meta_key;
    }
    private function is_address_valid()
    {
        $input_address_src = metadata::where('tt', 'seo_url')->where('meta_value', $this->input_address)->where('status', '>', 100)->first();
        $this->input_address_src = $input_address_src;
        if ($input_address_src == null) {
            return false;
        }
        return true;
    }
    private function get_user_family_view()
    {
        if (Auth::check()) {
            $AdminLogin = false;
            if (Auth::user()->Role == myappenv::role_SuperAdmin) {
                $AdminLogin = true;
            }
        } else {
            $AdminLogin = false;
        }
        $DataSource = new NewsClass('newscat', $AdminLogin);
        $MyOrder = new OrderRequestClass($this->input_address_src->fgstr);
        return  view('news.SingleFamily', ['DataSource' => $DataSource, 'Order' => $MyOrder, 'AdminLogin' => $AdminLogin, 'input_address_src' => $this->input_address_src]);
    }
    public function get_address_view($input_address)
    {
        $this->input_address = $input_address;
        $validity = $this->is_address_valid();
        if (!$validity) {
            return abort('404', 'صفحه درخواست شده وجود ندارد');
        }
        $address_type = $this->get_address_type();
        switch ($address_type) {
            case 'user':
                return $this->get_user_family_view();
        }
    }
}
