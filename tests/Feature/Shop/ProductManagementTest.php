<?php

namespace Tests\Feature\Shop;

use App\Models\goods;
use App\Models\report_detial;
use App\Models\warehouse_goods;
use App\myappenv;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ProductManagementTest extends TestCase
{

    public function test_add_product_get()
    {
        $this->login_with_role(myappenv::role_SuperAdmin);
        $response = $this->get(route("AddProduct"));
        $response->assertStatus(200);
    }
    public function test_add_product_post()
    {
        $this->login_with_role(myappenv::role_SuperAdmin); // login with super admin role
        $Product_id = $this->add_single_product(); 
        $this->add_product_warehouse_qty($Product_id);  // check show view
        $this->add_product_warehouse_qty_post($Product_id); // check add product to warehouse 

        $this->remove_test_data($Product_id);

    }
    public function add_product_warehouse_qty_post($Product_id)
    {
        $post_data = [
            "GoodID" => $Product_id,
            "UserName" => null,
            "WarehouseID" => "1",
            "QTY" => "10",
            "Remian" => null,
            "AlertLimit" => null,
            "SaleLimit" => null,
            "Price" => "200000",
            "BuyPrice" => "100000",
            "MainPrice" => "300000",
            "BasePrice" => "400000",
            "DeviceType" => "0",
            "InputDate" => "2000-06-27",
            "ActiveTime" => null,
            "DeactiveTime" => null,
            "MadeDate" => "2024-06-27",
            "ExpireDate" => "2024-06-27",
            "submit" => "online",
        ];
        $response = $this->post(route("AddGoodToWarehouse", $post_data));
        $response->assertRedirect();
    }
    public function add_single_product()
    {
        $NameEn = fake()->lastName();
        $NameFa = fake()->lastName();
        $SKU = fake()->text(10);

        $post_data = [
            "NameFa" => $NameFa,
            "NameEn" => $NameEn,
            "MainUnit" => 1,
            "weight" => fake()->numberBetween(0, 100),
            "IRID" => fake()->text(10),
            "IntID" => fake()->text(10),
            "Description" => fake()->text(200),
            "ce" => fake()->text(200),
            "ce1" => fake()->text(200),
            "SKU" => $SKU,
        ];
        $response = $this->post(route("AddProduct", $post_data));
        $response->assertRedirect();
        $inserted_product = goods::where("NameFa", $NameFa)->where("NameEn", $NameEn)->where("SKU", $SKU)->first();
        if ($inserted_product == null) {
            return $this->fail('can not find inserted product');
        }
        $Product_id = $inserted_product->id;
        echo 'product add successfully by id = ' . $Product_id;

        return $Product_id;
    }

    public function add_product_warehouse_qty($product_id)
    {
        $response = $this->get(route("EditProduct", ['id' => $product_id, 'page' => 'EditGood']));
        $response->assertStatus(200);

    }
    private function remove_test_data($product_id)
    {
        report_detial::where('ProductID', $product_id)->delete();
        warehouse_goods::where('GoodID', $product_id)->delete();
        goods::where('id', $product_id)->delete();



    }



}
