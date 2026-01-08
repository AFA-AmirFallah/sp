<?php

namespace App\Http\Controllers\deal;

use App\Deal\DealBase;
use App\Deal\DealCalls;
use App\Deal\DealWorkflow;
use App\Functions\ConsultClass;
use App\Users\UserClass;
use App\Http\Controllers\APIS\VOIP;
use App\Http\Controllers\Controller;
use App\Models\deal_file;
use App\Models\deal_file_pic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    public function file_workflow($file_id)
    {
        $deal_functions = new DealBase();
        $calls_func = new DealCalls();
        if (!$deal_functions->is_file_related_to_dealer(Auth::id(), $file_id)) {
            return abort(404);
        }
        $deal_src = deal_file::find($file_id);
        $report_src = $deal_src->actions;
        if ($report_src == null || $report_src == '') {
            $report_src = [];
        } else {
            $report_src = json_decode($report_src);
        }

        return view("deal.report_deal_worker", ['deal_functions' => $deal_functions, 'file_id' => $file_id, 'report_src' => $report_src]);

    }
    public function Dofile_workflow($file_id, Request $request)
    {
        if ($request->has('add_report')) {
            $report_type = $request->add_report;
            $reporter_username = Auth::id();
            $reporter_Name = Auth::user()->Name;
            $reporter_family = Auth::user()->Family;
            $report_time = time();
            $report_text = $request->report;
            $report_data = [
                'report_type' => $report_type,
                'reporter_username' => $reporter_username,
                'reporter_Name' => $reporter_Name,
                'reporter_family' => $reporter_family,
                'report_time' => $report_time,
                'report_text' => $report_text
            ];
            $workflow = new DealWorkflow;
            $workflow->add_report_to_deal_file($file_id, $report_data);
            return redirect()->back()->with('success', 'گزارش ثبت شد!');

        }

    }
    public function output_calls($file_id)
    {
        $deal_functions = new DealBase();
        $calls_func = new DealCalls();
        if (!$deal_functions->is_file_related_to_dealer(Auth::id(), $file_id)) {
            return abort(404);
        }
        $calls_src = $calls_func->get_file_output_calls($file_id);
        return view("deal.output_calls_deal_worker", ['deal_functions' => $deal_functions, 'file_id' => $file_id, 'calls_src' => $calls_src]);
    }
    public function Dooutput_calls($file_id, Request $request)
    {
        if ($request->ajax()) {
            if ($request->function == 'bothsidecall') {
                $BothSide = new ConsultClass();
                $target_mobile = $request->target;
                $extra = [
                    'deal'=>$file_id
                ];
                $BothSide->BothSideCall(Auth::user()->MobileNo, $target_mobile,$extra);
                return 'درخواست تماس ثبت گردید!';
            }
            if ($request->function == 'bothsidecall_with_add') {
                $users = new UserClass;
                $users->add_user_form_calls($request->Name,$request->Family,$request->MobileNo,$request->Sex);
                $BothSide = new ConsultClass();

                $target_mobile = $request->MobileNo;
                $extra = [
                    'deal'=>$file_id
                ];
                $BothSide->BothSideCall(Auth::user()->MobileNo, $target_mobile,$extra);
                return 'درخواست تماس ثبت گردید!';
            }
        }

    }
    public function input_calls($file_id)
    {
        $deal_functions = new DealBase();
        $calls_func = new DealCalls();
        if (!$deal_functions->is_file_related_to_dealer(Auth::id(), $file_id)) {
            return abort(404);
        }
        $calls_src = $calls_func->get_file_input_calls($file_id);
        return view("deal.input_calls_deal_worker", ['deal_functions' => $deal_functions, 'file_id' => $file_id, 'calls_src' => $calls_src]);

    }
    public function Doinput_calls($file_id, Request $request)
    {
        if ($request->ajax()) {
            if ($request->function == 'bothsidecall') {
                $BothSide = new ConsultClass();
                $target_mobile = $request->target;
                $extra = [
                    'deal'=>$file_id
                ];
                $BothSide->BothSideCall(Auth::user()->MobileNo, $target_mobile,$extra);
                return 'درخواست تماس ثبت گردید!';
            }
        }


    }
    public function working_file($file_id)
    {
        $deal_functions = new DealBase();

        if (!$deal_functions->is_file_related_to_dealer(Auth::id(), $file_id)) {
            return abort(404);
        }
        $deal_src = deal_file::where('id', $file_id)->first();
        if ($deal_src == null) {
            return abort(404, 'فایل درخواست شده وجود ندارد');
        }
        $operator_src = $deal_functions->get_all_oprators();
        $img_src = deal_file_pic::where('deal_file', $file_id)->get();
        $dealers = $deal_functions->get_file_dealers($file_id);
        $properties = $deal_src->properties;
        if ($properties == null) {
            $properties = [];
        } else {
            $properties = json_decode($properties, true);
        }

        return view("deal.main_deal_worker", ['properties' => $properties, 'img_src' => $img_src, 'deal_functions' => $deal_functions, 'deal_src' => $deal_src, 'file_id' => $file_id, 'operator_src' => $operator_src, 'dealers' => $dealers]);

    }
    public function Doworking_file($file_id, Request $request)
    {
        if ($request->ajax()) {
            if ($request->function == 'bothsidecall') {
                $BothSide = new ConsultClass();
                $target_mobile = $request->target;
                $extra = [
                    'deal'=>$file_id
                ];
                $BothSide->BothSideCall(Auth::user()->MobileNo, $target_mobile,$extra);
                return 'درخواست تماس ثبت گردید!';
            }
        }
    }
}
