<?php

namespace App\Http\Controllers\hiring;

use App\Functions\TextClassMain;
use App\hiring\hiring_comments;
use App\hiring\hiring_reporting;
use App\hiring\hiring_worker_insertion;
use App\hiring\hiring_workers;
use App\Http\Controllers\Controller;
use App\Models\product_order;
use App\Models\UserCredit;
use App\myappenv;
use App\zarinpal\zarinpal;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class reporting extends Controller
{
    private function show_report_staff($worker_username, $user_src)
    {
        $comment_class = new hiring_comments;
        $worker = new hiring_workers;
        $comment_src = $comment_class->get_worker_comments($worker_username);
        $worker_skills = $comment_class->get_worker_hiring_skills($worker_username);
        return view('Layouts.Theme7.report_staff', ['type' => 'show_info', 'worker' => $worker, 'user_src' => $user_src, 'comment_src' => $comment_src, 'worker_skills' => $worker_skills]);

    }
    private function finalize_order_by_zar($code, $ref)
    {
        $order_src = product_order::where('id', $ref)->where('status', 0)->where('CustomerId', Auth::id())->first();
        if ($order_src == null) {
            return abort('404');
        }
        $price = $order_src->total_sales / 10;
        $zarinpal = new zarinpal;
        $veryfy_result = $zarinpal->verification($price);
        if ($veryfy_result['result']) { //direct pay charge account
            $price *= 10; //convert to rial
            $text = 'هزینه استعلام توسط: ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' شماره فاکتور: ' . $ref;

            $veryfy_data = $veryfy_result['data'];
            $TransactionData = [
                'UserName' => Auth::id(),
                'Mony' => $price,
                'Type' => 66,
                'Date' => now(),
                'Note' => $text,
                'TransferBy' => Auth::id(),
                'CreditMod' => myappenv::CachCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $ref,
                'PaymentId' => $veryfy_data['RefID'],
                'SpecialPaymentId' => $veryfy_data['RefID'],
                'GateWay' => 'ZAR',
                'Confirmdate' => now(),
                'branch' => Auth::user()->branch,
            ];
            $insertResult = UserCredit::create($TransactionData);
            $credit_id = $insertResult->id;
            product_order::where('id', $ref)->update(['status' =>100]);
            $TransactionData = [
                'UserName' => Auth::id(),
                'Mony' => -1 * $price ,
                'Type' => 66,
                'Date' => now(),
                'Note' => $text . 'تسویه',
                'TransferBy' => Auth::id(),
                'CreditMod' => myappenv::CachCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $ref,
                'ReferenceId'=>$credit_id,
                'Confirmdate' => now(),
                'branch' => Auth::user()->branch,
            ];
            $insertResult = UserCredit::create($TransactionData);
            $TransactionData = [
                'UserName' => myappenv::StackHolder,
                'Mony' => $price ,
                'Type' => 66,
                'Date' => now(),
                'Note' => $text,
                'TransferBy' => Auth::id(),
                'CreditMod' => myappenv::CachCredit,
                'ConfirmBy' => 'system',
                'InvoiceNo' => $ref,
                'ReferenceId'=>$credit_id,
                'Confirmdate' => now(),
                'branch' => Auth::user()->branch,
            ];
            $insertResult = UserCredit::create($TransactionData);
            UserCredit::where('ID',$credit_id)->update(['ReferenceId'=>$credit_id]);

        }
        return true;
    }

    public function report_staff($code, $gateway = null, $ref = null)
    {
        if ($gateway == 'zar' && $ref != null) {
            $buy_result = $this->finalize_order_by_zar($code, $ref);
            if($buy_result == true){
                return redirect()->route('report_staff',['code'=>$code]);
            }
        }

        $reporting = new hiring_reporting;
        $user_src = $reporting->find_worker_by_code($code, true);
        if ($user_src == null) {
            return abort('404', 'صفحه درخواست شده موجود نیست');
        }
        $worker_username = $user_src->UserName;
        if ($worker_username == Auth::id()) { // self view profile


        }
        if (Auth::user()->Role == myappenv::role_customer) { // coustomer view profile
            $reporting = new hiring_reporting;
            if ($reporting->check_customer_buy_worker_profile_before($code, Auth::id())) {
                return $this->show_report_staff($worker_username, $user_src);
            }
            //TODO: check worker create by customer
            $comment_class = new hiring_comments;
            $worker = new hiring_workers;
            return view('Layouts.Theme7.report_staff', ['type' => 'buy_page', 'worker' => $worker, 'user_src' => $user_src]);
        }
        if (Auth::user()->Role >= myappenv::role_admin) {
            return $this->show_report_staff($worker_username, $user_src);
        }
        return abort('404');

    }
    private function buy_profile($order_id, $code)
    {
        $zarinpal = new zarinpal;
        $order_src = product_order::find($order_id);
        $price = $order_src->total_sales / 10;
        $text = 'هزینه استعلام توسط: ' . Auth::user()->Name . ' ' . Auth::user()->Family . ' شماره فاکتور: ' . $order_id;
        return $zarinpal->payment($price, $text, Auth::user()->MobileNo, $order_id, route('report_staff', ['code' => $code, 'gateway' => 'zar', 'ref' => $order_id]));
    }
    public function Doreport_staff(Request $request, $code)
    {
        if ($request->has('submit')) {
            if ($request->submit == 'show_profile') {
                $reporting = new hiring_reporting;
                $order_id = $reporting->buy_profile($code, Auth::id(), 30);
                return $this->buy_profile($order_id, $code);
            }

        }
        dd($request->input(), $code);

    }
    public function search_staff()
    {
        return view('Layouts.Theme7.search_staff', ['type' => 'page']);
    }
    private function find_by_code($code)
    {
        if (!is_numeric($code)) { //code validation 
            return redirect()->back()->with('error', 'کد پرستاربانک می باید رشته عددی باشد');
        }
        $reporting = new hiring_reporting;
        $search_result = $reporting->find_worker_by_code($code);
        return view('Layouts.Theme7.search_staff', ['type' => 'result', 'code' => $code, 'search_result' => $search_result]);
    }
    private function find_by_mobile_number($mobile_no)
    {
        if (!is_numeric($mobile_no)) { //code validation 
            return redirect()->route('search_staff')->with('error', 'شماره موبایل می باید رشته عددی باشد');
        }
        if (strlen($mobile_no) != 11) {
            return redirect()->route('search_staff')->with('error', 'شماره موبایل وارد شده صحیح نیست!');
        }
        $reporting = new hiring_reporting;
        $search_result = $reporting->find_worker_by_mobile_no($mobile_no);
        return view('Layouts.Theme7.search_staff', ['type' => 'result', 'mobile' => $mobile_no, 'search_result' => $search_result]);

    }
    public function Dosearch_staff(Request $request)
    {
        if ($request->has('add_user')) {
            $my_text = new TextClassMain;
            $staff_name = $my_text->StripText($request->staff_name);
            $user_mobile = $request->add_user;
            $add_worker = new hiring_worker_insertion;
            $add_worker = $add_worker->insertion_worker_by_customer(Auth::id(), $staff_name, $user_mobile);
            if (!$add_worker['result']) {
                return redirect()->back()->with('error', $add_worker['msg']);
            }
            return view('Layouts.Theme7.search_staff', ['type' => 'add_success']);
        }
        if ($request->has('submit')) {
            if ($request->submit == 'search') {
                if ($request->code != null) {
                    return $this->find_by_code($request->code);
                }
                if ($request->mobile != null) {
                    return $this->find_by_mobile_number($request->mobile);

                }
                if ($request->center != null) {

                }
                return redirect()->back()->with('error', 'جهت استعلام می باید یکی از فیلدهای جستجو وارد شود.');

            }
        }

    }
}
