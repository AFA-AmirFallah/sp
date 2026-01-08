<?php

namespace Tests\Unit\shop;

use App\Shop\ProductManagement;
use Tests\TestCase;

class ProductDuplicationTest extends TestCase
{
    /**
     * test product duplication 
     *  
     * 
     */

    public function test_product_duplication()
    {
        $pm = new ProductManagement;
        $result = $pm->make_double(1);
        $this->assertTrue($result['result']);
    }

}
