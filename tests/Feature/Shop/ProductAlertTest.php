<?php

namespace Tests\Feature\Shop;

use App\Models\goods;
use App\myappenv;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductAlertTest extends TestCase
{

    public function test_customer_add_product_alert()
    {
        $this->login_with_role(myappenv::role_customer);
        $sample_product = goods::first();
        $this->assertNotNull($sample_product,'The database has not product');
        $data = [
            'AjaxType' => 'AddProductAlert',
            'ProductID' => $sample_product->id
        ];
        $response = $this->post(route('ajax', $data));
        $response->assertStatus(200);
    }


}
