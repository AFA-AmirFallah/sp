<?php

namespace Tests\Unit\shop;

use App\Models\report_detial;
use App\Report\ProductReport;
use Tests\TestCase;



class ReportingTest extends TestCase
{
    public function test_can_add_product_report(){
        $product_reporting = new ProductReport(1,1);
        $result = $product_reporting->create_report('unit_test','json_data');
        $this->assertIsNumeric($result);
        $inserted_row = report_detial::find($result);
        $this->assertNotNull($inserted_row);
        $inserted_row->delete();
        
    }

    
}
