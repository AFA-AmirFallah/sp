<?php

namespace Tests\Unit;

use App\APIS\SMSDotIR;
use PHPUnit\Framework\TestCase;

class sms_irTest extends TestCase
{
    public function test_send_code()
    {
        $sms_center = new SMSDotIR;
        $result = $sms_center->send_code('1222', '09357974553');
        $this->assertTrue($result);
    }
    public function test_order_final()
    {
        $sms_center = new SMSDotIR;
        $arr = [
            [
                "name" => "NAME",
                "value" => 'امیر فلاح'
            ],
            [
                "name" => "CODE",
                "value" => '۱۲۳'
            ]

        ];
        $result = $sms_center->send_order_final($arr, '09357974553');
        $this->assertTrue($result);
    }
    public function test_manager_alert()
    {
        $sms_center = new SMSDotIR;
        $arr = [
            [
                "name" => "ID",
                "value" => '1222'
            ],
            [
                "name" => "PRICE",
                "value" => '2200000 تومان'
            ]

        ];
        $result = $sms_center->send_manager_alert($arr, '09357974553');
        $this->assertTrue($result);
    }
    public function test_manager_statistic()
    {
        $sms_center = new SMSDotIR;
        $arr = [
            [
                "name" => "USER_COUNT",
                "value" => '10'
            ],
            [
                "name" => "SELL",
                "value" => '2200000 تومان'
            ],
            [
                "name" => "STATE",
                "value" => 'نیاز به تلاش بیشتر'
            ]

        ];
        $result = $sms_center->send_manager_statistic($arr, '09357974553');
        $this->assertTrue($result);
    }


}
