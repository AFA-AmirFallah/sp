<?php

namespace App\Functions;

use App\Models\UserCredit;
use App\Models\UserCreditReport;
use DateInterval;
use DatePeriod;
use DB;

class ScheduleFunctions
{

    public function UserCrediteReportUpdate()
    {

        $MaxRow = UserCreditReport::orderBy('Confirmdate', 'desc')->first();
        if ($MaxRow == null) { // the table not create yet
            $MinCreditRow = UserCredit::orderBy('Date', 'asc')->first();
            $StartDate = date('Y-m-d', strtotime($MinCreditRow->Date));
        } else {
            $Lastupdate = $MaxRow->Confirmdate;
            $StartDate = date('Y-m-d', strtotime($Lastupdate . ' +1 day'));
        }
        $begin = $StartDate;
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime($today . ' -1 day'));
        $end = $yesterday;
        $TargetDate = '';
        for ($i = 0; $TargetDate != $end;$TargetDate =  date('Y-m-d', strtotime($today . ' -1 day'))) {
            echo  $i;
        }

        dd('fnish');
    }
}
