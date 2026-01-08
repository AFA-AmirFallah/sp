<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Reporter extends Controller
{
    public function ReportHandeller(Request $request ,$ReportType = null){
        return view('Reports.ReporterMain');
    }
    public function DoReportHandeller(Request $request ,$ReportType = null){
        
    }
}
