<?php

namespace Tests\Unit\shop;

use PHPUnit\Framework\TestCase;

class TapinTest extends TestCase
{
    public function test_GetTapinPrice(){
        $tapin = new \App\APIS\Tapin;
        $price = 100000;
        $weight = 4000;
        $address = 'ستارخان حبیب الهی';
        $city_code = 1;
        $province_code = 1;
        $first_name = 'امیر';
        $last_name = 'فلاح';
        $mobile = '09123936105';
        $postal_code = '1444423432';
        $package_weight = 12;
        $result = $tapin->GetTapinPrice($price, $weight, $address, $city_code, $province_code, $first_name, $last_name, $mobile, $postal_code, $package_weight);
        $my_result = $result;
        $this->assertTrue($result[0],$result[1]);
    }
    public function test_GetTapinlist(){
        $tapin = new \App\APIS\Tapin;
        $result = $tapin->get_state_list();
        $entries = $result->entries->list;
        foreach($entries as $entry){

        }

        $this->assertTrue(true);

    }


    public function test_packing_box(){
        $tapin = new \App\APIS\Tapin;
        $result = $tapin->get_packing_box();
        $this->assertEquals($result->returns->status,200);


    }

}
