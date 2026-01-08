<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\reports;
use App\Models\UserCreditMod;
use App\Models\UserCreditModMeta;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportMain extends Controller
{

    public function reports()
    {
        $UserCreditModMeta = UserCreditModMeta::all();
        $GraphData = null;
        $Description = null;
        $FinancialIndex = null;
        $report_src = reports::where('Role','<=',Auth::user()->Role)->get();
        return view("report.ReportMain", ['UserCreditModMeta' => $UserCreditModMeta, 'DaramadGraph' => $GraphData, 'Description' => $Description, 'FinancialIndex' => $FinancialIndex , 'report_src' =>$report_src  ]);


    }
    public function Doreports(Request $request)
    {
        $request->validate([
            'StartDate' => 'required|max:10|min:10',
            'EndDate' => 'required|max:10|min:10',
        ], [
            'StartDate.required' => 'پر کردن فیلد تاریخ شروع الزامی میباشد!',
            'StartDate.max' => 'تاریخ شروع وارد شده اشتباه است!',
            'StartDate.min' => 'تاریخ شروع وارد شده اشتباه است!',
            'EndDate.required' => 'پر کردن فیلد تاریخ پایان الزامی میباشد!',
            'EndDate.max' => 'تاریخ پایان وارد شده اشتباه است!',
            'EndDate.min' => 'تاریخ پایان وارد شده اشتباه است!',
        ]);
        $report_type = $request->report_type;
        $StartDate = date('Y-m-d H:i:s'); 
        $EndDate =  date('Y-m-d H:i:s'); 
        $report_src = reports::where('table_src',$report_type)->first();
        $query = "select * from $report_type where record_date >= '$StartDate' and  record_date <= '$EndDate' ";
        $data_src = DB::select($query) ;
        return view('report.ReportResult',['StartDate'=>$StartDate,'EndDate'=>$EndDate , 'report_src'=>$report_src ,'data_src'=>$data_src  ]);

    }
}
