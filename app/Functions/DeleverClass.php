<?php
namespace App\Functions;

use App\Http\Controllers\APIS\wordpress;

class DeleverClass
{

    public function GetDeleverPriceTopin($rate_type,$price,$weight,$pay_type,$to_province,$from_province,$to_city,$from_city){
        $MyDelever = new wordpress();
        $SendPrice = $MyDelever->Topin_check_price($rate_type,$price,$weight,$pay_type,$to_province,$from_province,$to_city,$from_city);
        return $SendPrice;

    }


}