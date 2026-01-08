<?php

namespace Tests\Unit\shop;

use App\Models\goods;
use App\Models\UserInfo;
use App\myappenv;
use App\Shop\ProductAlert;
use Tests\TestCase;
class ProductAlertTest extends TestCase
{
    public function test_my_example(){
        
        $as = 12;
        $as ++;

    }


    public function test_customer_add_and_remove_alert_on_product(){
        
        $sample_user = UserInfo::first();
        $sample_product = goods::first();

        $this->assertNotNull($sample_user,'The database has not users');
        $this->assertNotNull($sample_product,'The database has not product');
        $this->customer_add_alert_on_product($sample_user->UserName,$sample_product->id); 
        $this->customer_remove_alert_on_product($sample_user->UserName,$sample_product->id); 

    }
    private function customer_add_alert_on_product($username,$product_id){
        $my_alert = new ProductAlert();
        $function_result = $my_alert->add_customer_alert($product_id,$username);
        $this->assertTrue($function_result , 'The function has error to add product alert');  
    }

    private function customer_remove_alert_on_product($username,$product_id){
        $my_alert = new ProductAlert();
        $function_result = $my_alert->remove_customer_alert($product_id,$username);
        $this->assertTrue($function_result , 'The function has error to remove product alert');  
    }


}
