<?php

namespace App\Http\Controllers\statistic;

use App\Http\Controllers\Controller;
use App\Models\branches;
use App\Models\statistic_main;
use App\Statistic\statistic_main as StatisticStatistic_main;
use Illuminate\Http\Request;

class statistic_mgt extends Controller
{
    public function add_statistic()
    {
        $branch_src = branches::all();
        $statistic_class = new StatisticStatistic_main;
        return view('statistic.add_statistic', ['branch_src' => $branch_src, 'statistic_class' => $statistic_class]);
    }
    public function Doadd_statistic(Request $request)
    {
        if ($request->submit == 'add_file') {
            $mgt_class = new \App\Statistic\statistic_mgt;
            $create_result = $mgt_class->add_statistic($request->input());
            if ($create_result['result']) {
                return redirect()->back()->with('success', 'آمار شماره ' . $create_result['id'] . ' به سامانه افزوده شد. ');
            }
            return redirect()->back()->with('error', $create_result['msg']);
        }
    }
    public function statistic_list()
    {
        $statistic_src = statistic_main::all();
        return view('statistic.statistic_list', ['statistic_src' => $statistic_src]);
    }
    public function Dostatistic_list(Request $request)
    {

    }
    public function edit_statistic($id)
    {

        $branch_src = branches::all();
        $statistic_class = new StatisticStatistic_main;
        $statistic_mgt = new \App\Statistic\statistic_mgt;
        $statistic_src = $statistic_mgt->get_main_statistic($id);
        if ($statistic_src == null) {
            return abort('the file is not exist');
        }
        $statistic_items_src = $statistic_mgt->get_items_statistic($id);

        return view('statistic.edit_statistic', ['branch_src' => $branch_src, 'statistic_class' => $statistic_class, 'statistic_items_src' => $statistic_items_src, 'statistic_src' => $statistic_src]);

    }
    public function Doedit_statistic($id, Request $request)
    {
        if ($request->submit == 'edit_main_file') {
            $mgt_class = new \App\Statistic\statistic_mgt;
            $create_result = $mgt_class->edit_statistic($id, $request->input());
            if ($create_result) {
                return redirect()->back()->with('success', 'آمار   به روز رسانی شد ');
            }
            return redirect()->back()->with('error', $create_result['msg']);
        }
        if ($request->submit == 'add_item') {
            $mgt_class = new \App\Statistic\statistic_mgt;
            $create_result = $mgt_class->add_item($id, $request->input());
            return redirect()->back()->with('success', 'آمار   به روز رسانی شد ');
        }
        if ($request->submit == 'edit_item') {
            $mgt_class = new \App\Statistic\statistic_mgt;
            $create_result = $mgt_class->edit_item($id, $request->input());
            return redirect()->back()->with('success', 'آمار به روز رسانی شد');
        }
        if ($request->submit == 'activate') {
            $mgt_class = new \App\Statistic\statistic_mgt;
            $create_result = $mgt_class->activate_statistic($id);
            return redirect()->back()->with('success', 'آمار به روز رسانی شد');
        }
        if ($request->submit == 'deactivate') {
            $mgt_class = new \App\Statistic\statistic_mgt;
            $create_result = $mgt_class->deactivate_statistic($id);
            return redirect()->back()->with('success', 'آمار به روز رسانی شد');
        }


    }

}
