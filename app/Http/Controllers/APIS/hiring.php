<?php

namespace App\Http\Controllers\APIS;

use App\Functions\TextClassMain;
use App\hiring\hiring_comments;
use App\hiring\hiring_workers;
use App\Http\Controllers\Controller;
use App\Models\branches;
use App\Models\UserInfo;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class hiring extends Controller
{
    protected $branch_id;
    private function connection_validation(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8'
        ]);
        return true;
    }
    private function get_login_branch($token, $password)
    {
        $branch_src = branches::where('api', $token)->where('Phone', $password)->where('status', 1)->first();
        if ($branch_src == null) {
            return [
                'result' => false,
                'msg' => 'the branch is not find!'
            ];
        }
        $this->branch_id = $branch_src->id;
        return [
            'result' => true,
        ];
    }
    private function get_worker_micro_data($username){
     //   Log::info($username); // get market update data 
        $worker_src = UserInfo::where('UserName',$username)->first();
        $user_status_src = UserStatus::where('Status', $worker_src->Status )->first();
        $comments = new hiring_comments;
        $comment_src = $comments->worker_comment_overview($username);

        $worker_data = [
            'status'=> $user_status_src->Name,
            'rate'=>$comment_src['rate'],
            'report_count'=>$comment_src['count'],
            'suggestion'=>'اطلاعاتی در دست نیست'
        ];
        return $worker_data;
    }   
    private function worker_enquiry(Request $request)
    {
        $recive_data = $request->data;
        //Log::info($recive_data); // get market update data 
        if (!isset($recive_data['MobileNo'])) {
            return [
                'result' => false,
                'msg' => 'mobileno missing'
            ];
        }
        $mytext = new TextClassMain;
        $worker_mobile_no =  $mytext->persian_number_to_en($recive_data['MobileNo']) ;
        $worker_class = new hiring_workers;
        $worker_insertion = $worker_class->is_worker_exist_before($worker_mobile_no);
        

        if ($worker_insertion['result']) {// worker exist before
            $worker_data = $this->get_worker_micro_data($worker_insertion['username']);
            $html = view('hiring.micro_state_report',['worker_data'=>$worker_data])->render();
            return [
                'result' => 'true',
                'html' => $html
            ];
        } else { // worker not exist

            $create_user =  $worker_class->create_worker_form_api($recive_data);
            $worker_data = $this->get_worker_micro_data($create_user['username']);
            $html = view('hiring.micro_state_report',['worker_data'=>$worker_data])->render();
            return [
                'result' => 'true',
                'html' => $html
            ];
        }
    }
    public function index(Request $request)
    {
        $valid_connection = $this->connection_validation($request);
        if ($valid_connection) {
            $branch_define = $this->get_login_branch($request->token, $request->password);
            if (!$branch_define['result']) {
                return json_encode($branch_define);
            }
        }
        if (!$valid_connection) {
            $result = [
                'result' => false,
                'msg' => 'validation filed'
            ];
            $result = json_encode($result);
            return $result;
        }
        $function = $request->function;
        switch ($function) {
            case 'worker_enquiry':
                $result = $this->worker_enquiry($request);
                break;

            default:
                $result = [
                    'result' => false,
                    'msg' => 'the function is not define'
                ];
                break;
        }
        $result = json_encode($result);
        return $result;
    }
}
