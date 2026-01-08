<?php


namespace App\Functions;

use App\Models\exam_items;
use App\Models\exam_orders;
use App\Models\exams;
use App\Models\UserInfo;
use App\myappenv;
use stdClass;

class examAnalyzeClass extends examclass
{
    private $PointResult;
    private $ExamOrderID;
    private $examOrdersrc;
    private $ExamID;
    private $UserInfo;
    private $ExamSorce;

    function __construct($ExamOrderID)
    {
        $this->ExamOrderID = $ExamOrderID;
        $this->examOrdersrc = null;
        $this->set_exam_source();
        $this->set_UserInfo();
        $examOrdersrc = $this->examOrdersrc;
        $this->ExamID = $examOrdersrc->exam_id;
        $this->ExamSorce = exams::where('id', $this->ExamID)->first();
        $this->get_exam_variabales();
    }
    public function get_exam_Name_en()
    {
        return $this->ExamSorce->NameEn;
    }
    public function get_exam_score($Point)
    {
        $ExamResult = json_decode($this->examOrdersrc->exam_result);
        $ExamResultScors = $ExamResult->ExamResult;
        foreach ($ExamResultScors->Variables as $index => $value) {
            if ($value == $Point) {
                return $ExamResultScors->val[$index];
            }
        }
        return null;
    }
    public function get_mbti_result()
    {
        $e_index = $this->get_exam_score('e_index');
        $i_index = $this->get_exam_score('i_index');
        $s_index = $this->get_exam_score('s_index');
        $n_index = $this->get_exam_score('n_index');
        $t_index = $this->get_exam_score('t_index');
        $f_index = $this->get_exam_score('f_index');
        $j_index = $this->get_exam_score('j_index');
        $p_index = $this->get_exam_score('p_index');
        $OutPut = '';
        if ($e_index > $i_index) {
            $OutPut .= 'E';
        } else {
            $OutPut .= 'I';
        }
        if ($s_index > $n_index) {
            $OutPut .= 'S';
        } else {
            $OutPut .= 'N';
        }
        if($t_index > $f_index){
            $OutPut .= 'T';
        }else{
            $OutPut .= 'F';
        }
        if($j_index > $p_index){
            $OutPut .= 'J';
        }else{
            $OutPut .= 'P';
        }
        return $OutPut;
    }

    private function set_UserInfo()
    {
        $this->UserInfo = UserInfo::where('UserName', $this->examOrdersrc->CustomerId)->first();
        return true;
    }
    public function get_user($fild)
    {
        return $this->UserInfo->$fild;
    }

    public function is_valid_user($UserName, $UserRole)
    {

        $examOrdersrc = $this->examOrdersrc;
        if ($UserRole > myappenv::role_customer) {
            return true;
        } else {
            if ($examOrdersrc->CustomerId == $UserName) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function set_exam_source()
    {
        $this->examOrdersrc = exam_orders::where('id', $this->ExamOrderID)->first();
        return true;
    }
    public function get_exam_id()
    {
        return $this->examOrdersrc->exam_id;
    }


    public function get_exam_checklist()
    {
        $examOrdersrc = $this->examOrdersrc;
        $exam_checklist = $examOrdersrc->exam_checklist;
        $exam_checklist = json_decode($exam_checklist);
        return $exam_checklist;
    }
    public function get_all_Variabales()
    {
        return $this->PointResult->Variables;
    }
    public function get_exam_variabales()
    {
        $examsrc = $this->ExamSorce;
        $Variable = json_decode($examsrc->variables);
        $conter = 0;
        $OutPut = new stdClass;
        foreach ($Variable->Variables as $VariableT) {
            $OutPut->Variables[$conter] = $VariableT;

            $conter++;
        }
        $conter = 0;
        foreach ($Variable->notes as $notesT) {

            $OutPut->notes[$conter] = $notesT;
            $conter++;
        }
        $conter = 0;
        foreach ($Variable->defaultval as $val) {
            $OutPut->val[$conter] = $val;
            $conter++;
        }
        $this->PointResult = $OutPut;

        return true;
    }
    private function get_point_index($PointName)
    {

        $VariablesArr = $this->PointResult->Variables;
        foreach ($VariablesArr as $item => $value) {
            if ($value == $PointName) {
                return $item;
            }
        }
    }
    private function get_index_value($IndexId)
    {
        return ($this->PointResult->val[$IndexId]);
    }
    private function set_index_value($IndexId, $Value)
    {
        $this->PointResult->val[$IndexId] = $Value;
    }
    private function get_examItem_answer_formola($Order)
    {
        $examItemsSrc = exam_items::where('exams', $this->ExamID)->where('order', $Order)->first();
        $examItemsSrc = json_decode($examItemsSrc->content);
        $examItemsSrc = $examItemsSrc->AnswerFormola;
        if ($examItemsSrc == null) {
            $examItemsSrc = [];
        }
        return $examItemsSrc;
    }


    public function Alalyze_exam()
    {
        $result = null;
        foreach ($this->get_exam_checklist() as $exam_checklist_item => $customercheckvalue) {

            $Order = substr($exam_checklist_item, 5); //Ques_1  remove 5 cahr to send order number
            if (is_numeric($Order)) {
                foreach ($this->get_examItem_answer_formola($Order) as $examItemsItem) {
                    if ($examItemsItem->Order == $customercheckvalue) {
                        $content = $examItemsItem->content;
                        $Order = $examItemsItem->Order;
                        $FormolStr = substr($content, strpos($content, "=") + 1);
                        $FormolStr = trim($FormolStr);
                        $arr = explode("=", $content, 2);
                        $Variable = $arr[0];
                        $Variable = trim($Variable);
                        $main_variable_index = null;
                        foreach ($this->get_all_Variabales() as $variableTarget) {
                            if ($Variable == $variableTarget) {
                                $main_variable_index = $this->get_point_index($variableTarget);
                            }
                            $variableIndex = $this->get_point_index($variableTarget);
                            $FormolStr = str_replace($variableTarget, $this->get_index_value($variableIndex), $FormolStr);
                        }
                        if ($FormolStr != '') {
                            eval('$result = (' . $FormolStr . ');');
                        }
                        $this->set_index_value($main_variable_index, $result);
                    }
                }
            }
        }
        return true;
    }
    private function get_Exam_analyze()
    {
        return '';
    }
    public function save_exam_result()
    {
        $ExamResult = [
            'ExamResult' => $this->PointResult,
            'ExamAnalyze' => $this->get_Exam_analyze(),
            'Analyzer' => 'system',
            'AnalyzeDate' => date('Y-m-d H:i:s')
        ];
        $ExamResult = json_encode($ExamResult);
        $UpdateData = [
            'exam_result' => $ExamResult,
            'status' => 100
        ];
        exam_orders::where('id', $this->ExamOrderID)->update($UpdateData);
        return true;
    }
}
