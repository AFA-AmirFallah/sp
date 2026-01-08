<?php

namespace App\Http\Controllers\exam;

use App\Functions\examAnalyzeClass;
use App\Functions\examclass;
use App\Functions\persian;
use App\Http\Controllers\Controller;
use App\Models\exam_items;
use App\Models\exam_orders;
use App\Models\exams;
use App\Models\product_order;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use stdClass;
use PDF;

class ExamAdmin extends Controller
{
    private $PointResult;
    private $ExamOrderID;
    private function update_order_to_done($exam_id)
    {
        product_order::where('status', 1)->where('VirtualContract', $exam_id)->where('CustomerId', Auth::id())->where('extra', 'exam')->update(['status' => 100]);
    }

    public function ExamResults(Request $request, $ExamID = null)
    {
        if ($ExamID != null) {
            $ExmAnalyze = new examAnalyzeClass($ExamID);
            $ExmAnalyze->Alalyze_exam();
            $ExmAnalyze->save_exam_result();
            $this->update_order_to_done($ExamID);
        }


        $CustomerId = Auth::id();
        $Query = "SELECT exam_orders.* , exams.NameFa  from exam_orders INNER JOIN exams on exams.id = exam_orders.exam_id where exam_orders.CustomerId = '$CustomerId'";
        $MyExamsSrc = DB::select($Query);
        $MyExam = new examclass();
        return view('exams.ExamResult', ['MyExam' => $MyExam, 'MyExamsSrc' => $MyExamsSrc]);
    }
    public function DoExamResults(Request $request, $ExamID = null)
    {
        if ($request->has('Print')) { // download exam Result
            $ExamID = $request->input('Print');
            $ExmAnalyze = new examAnalyzeClass($ExamID);
            if ($ExmAnalyze->is_valid_user(Auth::id(), Auth::user()->Role)) {
                $MainExamId = $ExmAnalyze->get_exam_id();
                $pdf = PDF::loadView("Print.PrintDoc_$MainExamId", ['ExmAnalyze' => $ExmAnalyze]);
                $filename = $ExmAnalyze->get_exam_Name_en();
                return $pdf->download("$filename.pdf");
            }
        }
    }
    private function for_buy_exam($exam_id, $exam_src)
    {
        $buy_before = false;
        if ($exam_src == null) {
            $exam_src = exams::where('id', $exam_id)->first();
        }
        $price = $exam_src->Price;
        if ($price == 0) {
            $is_buyable = false;
        } else {
            $is_buyable = true;
        }
        if ($is_buyable) {
            $buy_before_src =  product_order::where('status', 1)->where('VirtualContract', $exam_id)->where('CustomerId', Auth::id())->where('extra', 'exam')->first();
            if ($buy_before_src == null) {
                $buy_before = false;
            } else {
                $buy_before = true;
            }
        }
        return [
            'is_buyable' => $is_buyable,
            'buy_before' => $buy_before,
            'price' => $price,
        ];
    }

    public function SingleExam(Request $request, $ExamID)
    {
        //$exams = new examclass();
        //$exams->start_exam($ExamID);

        if ($request->ajax()) {
            $Exams = new examclass();
            if ($request->has('page')) {
                $TargetPage = $request->input('page');
                $returnHTML = view("exams.objects.$TargetPage", ['Exams' => $Exams])->render();
            }
            return ($returnHTML);
        }
        $ExamMAinSrc = exams::where('id', $ExamID)->first();
        return view('exams.SingleExam', ['for_buy_exam' => $this->for_buy_exam($ExamID, $ExamMAinSrc), 'ExamMAinSrc' => $ExamMAinSrc]);
    }
    public function DoSingleExam(Request $request, $ExamID)
    {
        if ($request->ajax()) {

            $exams = new examclass();


            if ($request->procedure == 'startexam') {
                $exams->start_exam($ExamID);
                $QuestionSrc = $exams->get_next_question();
                $exams->set_input_Json($QuestionSrc->content);
                $returnHTML = view("exams.objects.ExamQuestion", ['QuestionSrc' => $QuestionSrc, 'exams' => $exams])->render();
                return $returnHTML;
            }
            if ($request->procedure == 'next') {
                $Result = $request->checkedValue;
                $exams->save_question_rexult($Result);
                $QuestionSrc = $exams->get_next_question();
                $exams->set_input_Json($QuestionSrc->content);
                $returnHTML = view("exams.objects.ExamQuestion", ['QuestionSrc' => $QuestionSrc, 'exams' => $exams])->render();
                return $returnHTML;
            }
            if ($request->procedure == 'finishQuestion') {
                $Result = $request->checkedValue;
                $exams->save_question_rexult($Result);
                $OrderId = $exams->SaveExam();
                $returnHTML = view("exams.objects.ExamFinish", ['exams' => $exams])->render();
                return $returnHTML;
            }
            if ($request->procedure == 'Previous') {
                $QuestionSrc = $exams->get_previous_question();
                $exams->set_input_Json($QuestionSrc->content);
                $returnHTML = view("exams.objects.ExamQuestion", ['QuestionSrc' => $QuestionSrc, 'exams' => $exams])->render();
                return $returnHTML;
            }
        }
        if ($request->has('submit')) {
            if ($request->submit == 'pay') {
                if (!Auth::check()) {
                    return redirect()->back()->with('error', 'جهت پرداخت می باید به سامانه وارد شوید!');
                }
                $Note = 'خرید آزمون شماره' . $ExamID;
                $price_attr = $this->for_buy_exam($ExamID, null);
                $price = $price_attr['price'];
                $token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10);
                $ResNum = 42;             // for exam buy
                Session::put('price', $price);
                Session::put('ResNum', $ResNum);
                Session::put('target_exam', $ExamID);
                Session::put('finoward_token', $token);
                Session::put('Note', $Note);
                $amount = $price; // مبلغ فاكتور
                $redirectAddress = route('finpay');
                $invoiceNumber = $ResNum; //شماره فاكتور
                $timeStamp = date("Y/m/d H:i:s");
                $invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
                $action = "1003";    // 1003 : براي درخواست خريد
                $Mobile = Auth::user()->MobileNo;
                echo "<form id='peppeyment' action='https://finoward.ir/ipg.php' method='post'>
                <input  type='text' name='token' value='$token' /><br />
                <input  type='text' name='amount' value='$amount' /><br />
                <input  type='text' name='redirectAddress' value='$redirectAddress' /><br />
                <input  name='mobile' value='$Mobile' /><br />
                <input  type='text' name='Note' value='$Note' /><br />
                <button type='submit'>انتقال به درگاه  </button>
                </form><script>document.forms['peppeyment'].submit()</script>";
            }
        }
    }
    public function ExamItems(Request $request, $ExamID)
    {

        $exams = new examclass();



        /*
        $exams = new examclass();
        foreach($exams->Get_exam_Item(1) as $ExamItem){
            $exams->set_input_Json($ExamItem->content);
            dd($exams->get_item_question());
        }*/
        if ($request->ajax()) {
            $exams = new examclass();
            $exams->get_exam($ExamID);
            if ($request->has('data')) {
                $TargetPage = $request->input('page');
                $Data =  $request->input('data');
                if ($request->has('data1')) {
                    $Data2 =  $request->input('data1');
                } else {
                    $Data2 = null;
                }
                $returnHTML = view('exams.objects.' . $TargetPage, ['exams' => $exams, 'Data' => $Data, 'Data2' => $Data2])->render();
                return $returnHTML;
            } elseif ($request->has('page')) {
                $TargetPage = $request->input('page');
                $returnHTML = view('exams.objects.' . $TargetPage, ['exams' => $exams])->render();
                return $returnHTML;
            }
        }
        $exams = new examclass();
        return view('exams.ExamItems', ['exams' => $exams, 'ExamID' => $ExamID]);
    }
    public function DoExamItems(Request $request, $ExamID)
    {
        if ($request->has('ajax')) {

            if ($request->input('procedure') == 'saveanswer') {
                $exams = new examclass();
                $ExamItemId = $request->input('ExamItemId');
                $order = $request->input('order');
                $content = $request->input('content');
                $exams->SaveAnswer($ExamItemId, $order, $content);
                return 'ok';
            } elseif ($request->input('procedure') == 'applytoall') {
                $exams = new examclass();
                $ExamItemId = $request->input('ExamItemId');
                return $exams->applytoall($ExamItemId);
            } elseif ($request->input('procedure') == 'applytoSome') {
                $exams = new examclass();
                $ExamItemId = $request->input('ExamItemId');
                $inputtext = $request->input('inputtext');
                return $exams->applytoSome($ExamItemId, $inputtext);
            } elseif ($request->input('procedure') == 'deleteanswer') {
                $exams = new examclass();
                $ExamItemId = $request->input('ExamItemId');
                $order = $request->input('order');
                $content = $request->input('content');
                $exams->delete_answer($ExamItemId, $order);
                return 'ok';
            } elseif ($request->input('procedure') == 'saveformula') {
                $exams = new examclass();
                $ExamItemId = $request->input('ExamItemId');
                $order = $request->input('order');
                $content = $request->input('content');
                $exams->add_formula($ExamItemId, $order, $content);
                return 'ok';
            }
        }
        if ($request->input('submit') == 'save_img') {
            $ImgURL = $request->input('pic');
            exams::where('id', $ExamID)->update(['ImgURL' => $ImgURL]);
            return redirect()->back()->with('success', 'تصویر آزمون به روز رسانی گردید');
        }
        if ($request->input('submit') == 'Save_Item') {
            $order = $request->input('order');
            $ExamQuestion = $request->input('ce');
            $content = [
                'ExamQuestion' => $ExamQuestion,
                'ExamAnswers' => null,
                'AnswerFormola' => null
            ];
            $content = json_encode($content);
            $SaveData = [
                'exams' => $ExamID,
                'order' => $order,
                'status' => 0,
                'content' => $content,
            ];
            exam_items::create($SaveData);
            return redirect()->back()->with('success', 'سوال اضافه شد!');
        }
    }
    public function ExamAdmin(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('data')) {
                $TargetPage = $request->input('page');
                $Data =  $request->input('data');
                $exams = new examclass();
                $returnHTML = view('exams.objects.' . $TargetPage, ['exams' => $exams, 'Data' => $Data])->render();
                return $returnHTML;
            } elseif ($request->has('page')) {
                $TargetPage = $request->input('page');
                $exams = new examclass();
                $returnHTML = view('exams.objects.' . $TargetPage, ['exams' => $exams])->render();
                return $returnHTML;
            }
        }
        return view('exams.ExamAdmin');
    }
    public function DoExamAdmin(Request $request)
    {
        if ($request->input('submit') == 'addexam') {
            $MyExam = new examclass();
            $MyExam->addexam($request->input());
            return redirect()->back()->with('success', 'آزمون به سیستم اضافه شد!');
        }
        if ($request->has('activate_exam')) {
            $MyExam = new examclass();
            $MyExam->change_state_exam($request->input('activate_exam'), 100);
            return redirect()->back()->with('success', 'آزمون  فعال شد!');
        }
        if ($request->has('deactivate_exam')) {
            $MyExam = new examclass();
            $MyExam->change_state_exam($request->input('activate_exam'), 100);
            return redirect()->back()->with('success', 'آزمون غیر فعال شد!');
        }
        if ($request->has('save_edit')) {
            $MyExam = new examclass();
            $MyExam->editexam($request->input(), $request->input('save_edit'));
            return redirect()->back()->with('success', 'آزمون ویرایش شد!');
        }
    }
}
