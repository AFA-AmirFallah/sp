<?php

namespace Tests\Feature\Shop;

use App\Models\product_order;
use App\myappenv;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerProfileTest extends TestCase
{
    public function test_profile_page_is_alive()
    {
        $this->login_with_role(myappenv::role_customer);
        $response = $this->get(route("UserProfile"));
        $response->assertStatus(200);
    }
    public function test_profile_main_page_is_alive()
    {
        $this->login_with_role(myappenv::role_customer);
        $header = [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ];
        $post_data = [

            'ajax' => true,
            'function' => 'profile_main'
        ];
        $response = $this->post(route("UserProfile"), $post_data, $header);
        $response->assertStatus(200);
    }
    public function test_profile_orders_is_alive()
    {
        $this->login_with_role(myappenv::role_customer);
        $header = [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ];
        $post_data = [

            'ajax' => true,
            'function' => 'profile_order'
        ];
        $response = $this->post(route("UserProfile"), $post_data, $header);
        $response->assertStatus(200);
    }
    public function test_profile_customer_view_an_oder()
    {
        $this->login_with_role(myappenv::role_customer);
        $order_src = product_order::where('total_sales', '>', 0)->where('num_items_sold', '>', 0)->first();
        $this->assertNotNull($order_src, 'The product order is empty');


        $header = [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ];
        $post_data = [
            'ajax' => true,
            'function' => 'load_order',
            'order_id' => $order_src->id
        ];
        $response = $this->post(route("UserProfile"), $post_data, $header);
        $response->assertStatus(200);
    }

}
