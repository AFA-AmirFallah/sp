<?php

namespace Tests\Unit\hiring;

use App\hiring\hiring_main;
use PHPUnit\Framework\TestCase;

class hiring_main_class_Test extends TestCase
{
    public function test_is_mobile_number()
    {
        $hiring = new hiring_main;
        $mobile_no = '09123936105';
        $result = $hiring->is_mobile_number($mobile_no);
        $this->assertTrue($result['result'], 'the function is not detect mobile number');
        $mobile_no = '0912393610';
        $result = $hiring->is_mobile_number($mobile_no);
        $this->assertTrue(!$result['result'], $result['msg']);
        $mobile_no = '99123936105';
        $result = $hiring->is_mobile_number($mobile_no);
        $this->assertTrue(!$result['result'], $result['msg']);
    }
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
}
