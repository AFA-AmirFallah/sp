<?php

namespace Tests\Unit\shop;

use App\Models\goods;
use App\Models\UserInfo;
use App\myappenv;
use App\Shop\ProductMark;

use Tests\TestCase;

use function PHPUnit\Framework\assertJson;

class ProductMarkeTest extends TestCase
{


    /**
     * This test assert the customer can add like to specific product
     */

    public function test_mark_a_product_as_a_customer()
    {
        $customer_src = UserInfo::where("Role", myappenv::role_customer)->first();
        $this->assertNotNull($customer_src, 'customer not exist in database');
        $product_src = goods::first();
        $this->assertNotNull($product_src, 'product not exist in database');


        $product_mark = new ProductMark;

        $before_mark = $product_mark->is_marked_before($customer_src->UserName, $product_src->id, 1);
        $this->assertIsBool($before_mark, 'Function is_marked_before has problem');
        if ($before_mark) { // user marked before
            $remove_mark = $product_mark->remove_mark($customer_src->UserName, $product_src->id, 1);
            $this->assertTrue($remove_mark, 'Function remove_mark has problem');
        }


        $insert_result = $product_mark->mark_a_product($customer_src->UserName, $product_src->id, 1);
        $this->assertTrue($insert_result['result'], $insert_result['msg'] ?? 'Not found message on make product');
        if (!$before_mark) { // user marked before
            $remove_mark = $product_mark->remove_mark($customer_src->UserName, $product_src->id, 1);
            $this->assertTrue($remove_mark, 'Function remove_mark has problem');
        }

    }
    public function test_get_my_marked_products(){
        $customer_src = UserInfo::where("Role", myappenv::role_customer)->first();
        $this->assertNotNull($customer_src, 'customer not exist in database');
        $product_mark = new ProductMark;
        $result = $product_mark->get_my_marked_products($customer_src->UserName,1);
        $this->assertIsArray($result);
    }


}
