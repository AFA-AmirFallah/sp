<?php

namespace App\Deal;

use App\Users\UserClass;
use App\Models\Calls;
use Illuminate\Support\Facades\DB;

class DealCalls extends DealBase
{
    public function get_file_output_calls($deal_id){
        $query = "SELECT mc.* , uic.Name as NameC , uic.Family as FamilyC , uia.Name as NameA , uia.Family as FamilyA 
        from my_calls mc inner join UserInfo uic on uic.UserName  = mc.caller INNER  JOIN  UserInfo uia on uia.UserName  = mc.answer_username WHERE mc.deal  = $deal_id ";
        $output_result = DB::select($query);
        return $output_result;
    }


    public function define_incoming_call(array $call_attr, array $caller_attr, array $file_attr)
    {
        $call_id = $call_attr['call_id'];
        if ($caller_attr['username'] == null) { // add new user
            $user_funcs = new UserClass();
            $caller_attr['username'] = $user_funcs->add_user_form_calls($caller_attr['Name'], $caller_attr['Family'], $caller_attr['MobileNo'], $caller_attr['Sex']);
            Calls::where('CallID', $call_id)->update(['CallerUser' => $caller_attr['username']]);
        }
        // update call info
        $update_data = [
            'CallType' => $call_attr['CallType'] ?? 0,
            'Status' => $call_attr['Status'] ?? 0,
            'deal' => $file_attr['file_id'],
            'ExtraInfo' => $call_attr['note'] ?? '',
        ];
        Calls::where('CallID', $call_id)->update($update_data);
        return redirect()->back()->with('success', 'درخواست انجام شد!');
    }
    public function get_file_input_calls($file_id)
    {
        $Query = "SELECT c.*,uic.Name as NameC,uic.Family as FamilyC , uia.Name as NameA , uia.Family as FamilyA from Calls c inner join UserInfo uic on c.CallerUser = uic.UserName INNER JOIN UserInfo uia on uia.UserName = c.AnswerUser WHERE  c.deal  = $file_id ";
        $result = DB::select($Query);
        return $result;
    }
}