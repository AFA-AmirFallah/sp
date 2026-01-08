<?php

namespace App\Report;

use App\Models\report_detial;

class ProductReport{
    public $product_id;
    public $WGID;

    public function __construct($product_id,$WGID){
        $this->product_id = $product_id;
        $this->WGID = $WGID;
    }

    

    public function create_report($UserID, $reportData )
    {
        $SaveData = [
            'ProductID' =>$this->product_id ,
            'WGID' => $this->WGID,
            'UserID' => $UserID,
            'ReportType' => 5, //add product
            'ReportVal' => $reportData,
        ];
        $result = report_detial::create($SaveData);
        return $result->id;
    }

}