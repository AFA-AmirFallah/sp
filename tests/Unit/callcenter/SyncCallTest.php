<?php

namespace Tests\Unit\callcenter;

use App\Functions\CallCenterClass;
use App\Functions\ConsultClass;
use Tests\TestCase;

class SyncCallTest extends TestCase
{
    public function test_main_sync(){
        $call_center = new CallCenterClass();
        $result = $call_center->synccalls();
        $this->assertIsNumeric($result);
    }
    public function test_call(){
        $call_center = new ConsultClass();
        $result = $call_center->BothSideCall('09123936105','09357974553',[]);
        $this->assertIsNumeric($result);
    }

}
