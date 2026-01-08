<?php


namespace App\Functions;

use App\Models\exam_items;
use App\Models\exam_orders;
use App\Models\exams;
use Illuminate\Support\Facades\Auth;
use Session;
use stdClass;
use DB;

class examclass
{
    private $exam_orders_id;
    private  $Examvariables;
    private $JsonArr;
    public function get_exam_Name($ExamID)
    {
        $ExamTargetSrc = exams::where('id', $ExamID)->first();
        if ($ExamTargetSrc == null) {
            return 'ثبت نشده';
        } else {
            return $ExamTargetSrc->NameFa;
        }
    }
    public function get_exam_results($ExamID)
    {
        $Query = "SELECT exam_orders.* , UserInfo.Name , UserInfo.Family FROM exam_orders INNER JOIN UserInfo  on UserInfo.UserName = exam_orders.CustomerId where exam_id = $ExamID";
        $result = DB::select($Query);
        return $result;
    }
    public function get_exam_order_status_txt($status)
    {
        switch ($status) {
            case 0:
                return 'در انتظار پردازش';
            case 100:
                return 'تکمیل شده';
        }
    }
    public function get_result($exam_result)
    {
        if ($exam_result == null) {
            return null;
        }
        $ExamResult = json_decode($exam_result);
        $ExamResult = $ExamResult->ExamResult;
        $outputArr = array();
        foreach ($ExamResult->notes as $index => $value) {
            if (!is_object($ExamResult->val)) {
                $Pointvalue = $ExamResult->val[$index];
            } else {
                $Pointvalue = $ExamResult->val->$index;
            }
            $ArrFild = [
                'PointName' => $value,
                'Pointvalue' => $Pointvalue
            ];
            array_push($outputArr, $ArrFild);
        }
        return ($outputArr);
    }

    public function SaveExam()
    {
        //exam_result
        $ExamID = Session::get('MyExam');
        $examSrc = exams::where('id', $ExamID)->first();
        $unit_sales = $examSrc->Price;
        $unit_Price = $examSrc->BasePrice;
        $ExamItems = Session::get('ExamItems');
        $exam_checklist = json_encode($ExamItems);
        $SaveData = [
            'CustomerId' => Auth::id(),
            'status' => 0,
            'exam_id' => $ExamID,
            'unit_Price' => $unit_Price,
            'unit_sales' => $unit_sales,
            'tax_total' => 0,
            'customer_benefit_total' => $unit_Price - $unit_sales,
            'exam_checklist' => $exam_checklist,
            'start_time' => now(),
            'end_time' => now(),
            'confirmer' => 'system',
            'confirm_time' => now()
        ];
        $result = exam_orders::create($SaveData);
        exams::where('id', $ExamID)->increment('total_sales');
        $this->exam_orders_id = $result->id;
        return $result->id;
    }
    public function get_exam_Order_id()
    {
        return $this->exam_orders_id;
    }
    public function applytoSome($ExamItemId, $inputtext)
    {
        $SampleSrc = exam_items::where('id', $ExamItemId)->first();
        $SampleExamID = $SampleSrc->exams;
        $sampleContent = json_decode($SampleSrc->content);
        $inputArr = explode(' ', $inputtext); // convert text to array based on space
        foreach ($inputArr as $InputItem) {
            if (is_numeric($InputItem)) {
                $TochangeSrc = exam_items::where('exams', $SampleExamID)->where('order', $InputItem)->first();
                if ($TochangeSrc != null) {
                    $targetid = $TochangeSrc->id;
                    $TargetContent = json_decode($TochangeSrc->content);
                    $TargetQuestion =  $TargetContent->ExamQuestion;
                    $TargetContent = $sampleContent;
                    $TargetContent->ExamQuestion = $TargetQuestion;
                    $TargetContent = json_encode($TargetContent);
                    exam_items::where('id', $targetid)->update(['content' => $TargetContent]);
                }
            }
        }
    }
    public function applytoall($ExamItemId)
    {

        $SampleSrc = exam_items::where('id', $ExamItemId)->first();
        $SampleExamID = $SampleSrc->exams;
        $sampleContent = json_decode($SampleSrc->content);
        $TochangeSrc = exam_items::where('exams', $SampleExamID)->get();
        foreach ($TochangeSrc as $TochangeItem) {
            $TargetContent = json_decode($TochangeItem->content);
            $TargetQuestion =  $TargetContent->ExamQuestion;
            $TargetContent = $sampleContent;
            $TargetContent->ExamQuestion = $TargetQuestion;
            $TargetContent = json_encode($TargetContent);
            exam_items::where('id', $TochangeItem->id)->update(['content' => $TargetContent]);
        }
    }
    public function get_question_result()
    {
        $ExamItems = Session::get('ExamItems');
        $fildName = 'Ques_' . $ExamItems->QuestionPointer;
        if (isset($ExamItems->$fildName)) {
            return $ExamItems->$fildName;
        } else {
            return null;
        }
    }
    public function save_question_rexult($Result)
    {
        $ExamItems = Session::get('ExamItems');
        $fildName = 'Ques_' . $ExamItems->QuestionPointer;
        $ExamItems->$fildName = $Result;
    }
    public function start_exam($ExamID)
    {
        Session::put('MyExam', $ExamID);
        $ExamItems = new stdClass;
        $ExamItems->StartTime = date('m/d/Y h:i:s a', time());
        $ExamItems->QuestionQty = $this->get_exam_item_count($ExamID);
        $ExamItems->QuestionPointer = 0;
        Session::put('ExamItems', $ExamItems);
    }
    public function is_last_question($CurentOrder)
    {
        $ExamItems = Session::get('ExamItems');
        if ($ExamItems->QuestionQty == $CurentOrder) {
            return true;
        } else {
            return false;
        }
    }
    public function load_exam_Item($ExamID, $ExamItemId)
    {
    }
    public function get_previous_question()
    {
        $ExamID = Session::get('MyExam');
        $ExamItems = Session::get('ExamItems');
        $CurentPostion = $ExamItems->QuestionPointer;
        $CurentPostion--;
        $ExamItems->QuestionPointer = $CurentPostion;
        Session::put('ExamItems', $ExamItems);
        return exam_items::where('exams', $ExamID)->where('order', $CurentPostion)->first();
    }

    public function get_next_question()
    {
        $ExamID = Session::get('MyExam');
        $ExamItems = Session::get('ExamItems');
        $CurentPostion = $ExamItems->QuestionPointer;
        $CurentPostion++;
        $ExamItems->QuestionPointer = $CurentPostion;
        Session::put('ExamItems', $ExamItems);
        return exam_items::where('exams', $ExamID)->where('order', $CurentPostion)->first();
    }
    private function save_edited_formula($ExamItemId, $order, $content)
    {
        $OldArr = $this->get_item_ansewers_formula();
        $newarr = [];
        foreach ($OldArr as $arritem) {
            if ($arritem->Order == $order) {
                $InsertArr = [
                    'Order' => $order,
                    'content' => $content
                ];
                array_push($newarr, $InsertArr);
            } else {
                array_push($newarr, $arritem);
            }
        }
        $this->JsonArr->AnswerFormola = $newarr;
        $newcontent = json_encode($this->JsonArr);
        exam_items::where('id', $ExamItemId)->update(['content' => $newcontent]);
        return true;
    }
    public function save_new_formola($ExamItemId, $order, $content)
    {
        $OldArr = $this->get_item_ansewers_formula();
        $InsertArr = [
            'Order' => $order,
            'content' => $content
        ];
        array_push($OldArr, $InsertArr);
        $this->JsonArr->AnswerFormola = $OldArr;
        $newcontent = json_encode($this->JsonArr);
        exam_items::where('id', $ExamItemId)->update(['content' => $newcontent]);
        return true;
    }

    public function add_formula($ExamItemId, $order, $content)
    {
        $ExamTarget = exam_items::where('id', $ExamItemId)->first();
        $this->set_input_Json($ExamTarget->content);
        $OldArr = $this->get_item_ansewers_formula();
        $findOrder = false;
        foreach ($OldArr as $arritem) {
            if ($arritem->Order == $order) {
                $findOrder = true;
            }
        }
        if ($findOrder) {
            return $this->save_edited_formula($ExamItemId, $order, $content);
        } else {
            return $this->save_new_formola($ExamItemId, $order, $content);
        }
    }
    public function delete_answer($ExamItem, $AnswerOrder)
    {
        $ExamTarget = exam_items::where('id', $ExamItem)->first();
        $this->set_input_Json($ExamTarget->content);
        $OldArr = $this->get_item_ansewers();
        $newarr = [];
        foreach ($OldArr as $arritem) {
            if ($arritem->Order == $AnswerOrder) {
                //noting to delete
            } else {
                array_push($newarr, $arritem);
            }
        }
        $this->JsonArr->ExamAnswers = $newarr;
        $newcontent = json_encode($this->JsonArr);
        exam_items::where('id', $ExamItem)->update(['content' => $newcontent]);
        return true;
    }
    public function save_new_answer($ExamItem, $AnswerOrder, $content)
    {
        $OldArr = $this->get_item_ansewers();
        $InsertArr = [
            'Order' => $AnswerOrder,
            'content' => $content
        ];
        array_push($OldArr, $InsertArr);
        $this->JsonArr->ExamAnswers = $OldArr;
        $newcontent = json_encode($this->JsonArr);
        exam_items::where('id', $ExamItem)->update(['content' => $newcontent]);
        return true;
    }
    public function save_edited_answer($ExamItem, $AnswerOrder, $content)
    {
        $OldArr = $this->get_item_ansewers();
        $newarr = [];
        foreach ($OldArr as $arritem) {
            if ($arritem->Order == $AnswerOrder) {
                $InsertArr = [
                    'Order' => $AnswerOrder,
                    'content' => $content
                ];
                array_push($newarr, $InsertArr);
            } else {
                array_push($newarr, $arritem);
            }
        }
        $this->JsonArr->ExamAnswers = $newarr;
        $newcontent = json_encode($this->JsonArr);
        exam_items::where('id', $ExamItem)->update(['content' => $newcontent]);
        return true;
    }

    public function SaveAnswer($ExamItem, $AnswerOrder, $content)
    {
        $ExamTarget = exam_items::where('id', $ExamItem)->first();
        $this->set_input_Json($ExamTarget->content);
        $OldArr = $this->get_item_ansewers();
        $findOrder = false;
        foreach ($OldArr as $arritem) {
            if ($arritem->Order == $AnswerOrder) {
                $findOrder = true;
            }
        }
        if ($findOrder) {
            return $this->save_edited_answer($ExamItem, $AnswerOrder, $content);
        } else {
            return $this->save_new_answer($ExamItem, $AnswerOrder, $content);
        }
    }
    public function get_single_item($ItemID)
    {
        return exam_items::where('id', $ItemID)->first();
    }
    public function set_input_Json($InputJSON)
    {
        $this->JsonArr = json_decode($InputJSON);
    }
    public function get_item_question()
    {
        $ExamQuestion = $this->JsonArr;
        return ($ExamQuestion->ExamQuestion);
    }
    public function get_item_ansewers()
    {
        $ExamQuestion = $this->JsonArr;
        if ($ExamQuestion->ExamAnswers == null) {
            return [];
        } else {
            return ($ExamQuestion->ExamAnswers);
        }
    }
    private function get_item_ansewrs_formula_all()
    {
        $ExamQuestion = $this->JsonArr;
        if ($ExamQuestion->AnswerFormola == null) {
            return [];
        } else {
            return $ExamQuestion->AnswerFormola;
        }
    }
    private function get_item_ansewr_formula($TargetOrder)
    {
        $ExamQuestion = $this->JsonArr;
        if ($ExamQuestion->AnswerFormola == null) {
            return null;
        } else {
            $AnswerFormola = $ExamQuestion->AnswerFormola;
            foreach ($AnswerFormola as $arritem) {
                if ($arritem->Order == $TargetOrder) {
                    return $arritem->content;
                }
            }
            return null;
        }
    }
    public function add_exam_question($ExamID, $order, $ExamQuestion)
    {
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
        $result =  exam_items::create($SaveData);
        $this->set_input_Json($content);
        return $result;
    }



    public function get_item_ansewers_formula($TargetOrder = null)
    {
        if ($TargetOrder == null) {
            return $this->get_item_ansewrs_formula_all();
        } else {
            return $this->get_item_ansewr_formula($TargetOrder);
        }
    }
    public function get_exam_item_count($ExamID)
    {
        return exam_items::where('exams', $ExamID)->count();
    }
    public function Get_exam_Item($ExamID)
    {
        return exam_items::where('exams', $ExamID)->orderBy('order')->get();
    }
    public function change_state_exam($ExamId, $targetState)
    {
        return exams::where('id', $ExamId)->update(['Status' => $targetState]);
    }
    public function get_exam_variables()
    {
        $Examvariables = $this->Examvariables;
        $Examvariables = json_decode($Examvariables);
        return $Examvariables;
    }
    public function get_exam($ExamID = null)
    {
        if ($ExamID == null) {
            return exams::all();
        } else {
            $ExamTarget = exams::where('id', $ExamID)->first();
            $this->Examvariables = $ExamTarget->variables;
            return $ExamTarget;
        }
    }
    public function editexam($request, $ExamID)
    {
        $variables = preg_split("/\r\n|\n|\r/", $request['variables']);
        $notes = preg_split("/\r\n|\n|\r/", $request['notes']);
        $defaultval = preg_split("/\r\n|\n|\r/", $request['defaultval']);
        $ArrayResult = [
            'Variables' => $variables,
            'notes' => $notes,
            'defaultval' => $defaultval
        ];
        $ArrayResult = json_encode($ArrayResult);
        $SaveData = [
            'SKU' => $request['SKU'],
            'NameFa' => $request['NameFa'],
            'NameEn' => $request['NameEn'],
            'unit' => $request['unit'],
            'Status' => 0,
            'Description' => $request['Description'],
            'ImgURL' => $request['ImgURL'],
            'BasePrice' => $request['BasePrice'],
            'Price' => $request['Price'],
            'variables' => $ArrayResult
        ];
        return exams::where('id', $ExamID)->update($SaveData);
    }
    public function addexam($request)
    {
        $variables = preg_split("/\r\n|\n|\r/", $request['variables']);
        $notes = preg_split("/\r\n|\n|\r/", $request['notes']);
        $defaultval = preg_split("/\r\n|\n|\r/", $request['defaultval']);
        $ArrayResult = [
            'Variables' => $variables,
            'notes' => $notes,
            'defaultval' => $defaultval
        ];
        $ArrayResult = json_encode($ArrayResult);
        $SaveData = [
            'SKU' => $request['SKU'],
            'NameFa' => $request['NameFa'],
            'NameEn' => $request['NameEn'],
            'unit' => $request['unit'],
            'Status' => 0,
            'Description' => $request['Description'],
            'ImgURL' => $request['ImgURL'],
            'BasePrice' => $request['BasePrice'],
            'Price' => $request['Price'],
            'variables' => $ArrayResult
        ];
        return exams::create($SaveData);
    }
}
