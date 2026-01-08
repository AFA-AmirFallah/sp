<?php

namespace App\Report;

class reporting
{
    public function create_report()
    {
        $SaveData = [
            'ProductID' => $request->input('GoodID'),
            'WGID' => $request->input('WarehouseID'),
            'UserID' => $UserID,
            'ReportType' => 5, //add product
            'ReportVal' => $reportData,
        ];
        report_detial::create($SaveData);
    }
}