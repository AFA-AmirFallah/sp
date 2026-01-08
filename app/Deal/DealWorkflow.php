<?php

namespace App\Deal;

use App\Models\deal_file;

class DealWorkflow extends DealBase
{
    public function add_report_to_deal_file(string $file_id, array $report_attr)
    {
        $deal_file_src = deal_file::find($file_id);
        $report_src = $deal_file_src->actions;
        if ($report_src == null || $report_src == '') {
            $report_src = [];
        } else {
            $report_src = json_decode($report_src);
        }
        array_push($report_src, $report_attr);
        $report_src = json_encode($report_src);
        $deal_file_src->actions = $report_src;
        $deal_file_src->save();
        return true;
    }

}