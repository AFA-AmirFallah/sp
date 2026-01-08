<?php

namespace App\hiring;

use App\Models\L3Work;
use App\Models\WorkerSkils;
use Illuminate\Support\Facades\DB;

class hiring_skills extends hiring_main
{

    public function update_worker_skills(string $username, array $skill_arr)
    {
        $this->pre_remove_all_skills($username);
        foreach ($skill_arr as $skill_item) {
            $this->add_new_skill($username, $skill_item);
        }
        $this->post_remove_all_skills($username);
        return true;
    }
    public function get_worker_exact_skills($username){
        $workcat = $this->skill_index['workcat'];
        $l1 = $this->skill_index['l1'];
        $l2 =  $this->skill_index['l2'];
        $Query = "SELECT lw.* , ws.UserName from L3Work lw  
        inner join WorkerSkils ws on lw.UID = ws.SkilID and ws.UserName  = '$username'  
         WHERE lw.WorkCat  = $workcat and lw.L1ID = $l1 and lw.L2ID  = $l2 and ( lw.validation = 1 or ws.UserName is not null )
";
        $skills_src = DB::select($Query);
        return $skills_src;
    }
    public function get_all_skills($username){
        $workcat = $this->skill_index['workcat'];
        $l1 = $this->skill_index['l1'];
        $l2 =  $this->skill_index['l2'];
        $Query = "SELECT lw.* , ws.UserName from L3Work lw  
        left join WorkerSkils ws on lw.UID = ws.SkilID and ws.UserName  = '$username'  
         WHERE lw.WorkCat  = $workcat and lw.L1ID = $l1 and lw.L2ID  = $l2  and lw.validation = 1 
";
        $skills_src = DB::select($Query);
        return $skills_src;
    }
    
    public function get_worker_skills($username)
    {
        $workcat = $this->skill_index['workcat'];
        $l1 = $this->skill_index['l1'];
        $l2 =  $this->skill_index['l2'];
        $Query = "SELECT lw.* , ws.UserName from L3Work lw  
        left join WorkerSkils ws on lw.UID = ws.SkilID and ws.UserName  = '$username'  
         WHERE lw.WorkCat  = $workcat and lw.L1ID = $l1 and lw.L2ID  = $l2 and ( lw.validation = 1 or ws.UserName is not null )
";
        $skills_src = DB::select($Query);
        return $skills_src;

    }

    private function pre_remove_all_skills($username)
    {
        WorkerSkils::where('UserName', $username)->where('WorkCat', $this->skill_index['workcat'])->where('L1ID', $this->skill_index['l1'])->where('L2ID', $this->skill_index['l2'])->where('Status', 1)->update(['Status' => 0]);
    }
    private function post_remove_all_skills($username)
    {
        WorkerSkils::where('UserName', $username)->where('WorkCat', $this->skill_index['workcat'])->where('L1ID', $this->skill_index['l1'])->where('L2ID', $this->skill_index['l2'])->where('Status', 0)->delete();
    }

    private function is_skill_is_exist($username, $skill_id)
    {
        $skill_src = WorkerSkils::where('UserName', $username)->where('SkilID', $skill_id)->first();
        if ($skill_src == null) {
            return false;
        }
        return true;
    }
    public function get_uid_of_skill($skill_text)
    {
        $target_skill_src = L3Work::where('WorkCat', $this->skill_index['workcat'])->where('L1ID', $this->skill_index['l1'])->where('L2ID', $this->skill_index['l2'])->where('Name', $skill_text)->first();
        if ($target_skill_src == null) {
            $L3Data = [
                'WorkCat' => $this->skill_index['workcat'],
                'L1ID' => $this->skill_index['l1'],
                'L2ID' => $this->skill_index['l2'],
                'L3ID' => 99, //add by system
                'Name' => $skill_text,
                'validation' => 0,
                'Description' => 'worker index',
                'img' => ''
            ];
            $TargetL3work = L3Work::create($L3Data);
            return $TargetL3work->id;
        }
        return $target_skill_src->UID;
    }
    private function add_new_skill($username, $skill_text)
    {

        $skill_id = $this->get_uid_of_skill($skill_text);
        $is_exist = $this->is_skill_is_exist($username, $skill_id);
        if (!$is_exist) {
            $index_src = L3Work::where('UID', $skill_id)->first();
            $SingleData = [
                'UserName' => $username,
                'SkilID' => $skill_id,
                'WorkCat' => $index_src->WorkCat,
                'L1ID' => $index_src->L1ID,
                'L2ID' => $index_src->L2ID,
                'CreateDate' => now(),
                'Status' => 1, // skill active status is 1  
                'Weight' => 0,
                'Note' => "add by system",
            ];
            WorkerSkils::create($SingleData);
            return true;
        }
        WorkerSkils::where('UserName', $username)->where('SkilID', $skill_id)->update(['Status' => 1]);
        return true;
    }

}