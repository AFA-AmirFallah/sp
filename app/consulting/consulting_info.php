<?php

namespace App\consulting;

use App\Models\L1Work;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\WorkCat;
use DateTime;
use DB;
use Illuminate\Support\Facades\Storage;

class consulting_info
{
    private function update_L1_index($key_arr)
    {
        $WorkCat = $key_arr['WorkCat'];
        $sub_l1_src = L1Work::where('WorkCat', $WorkCat)->get();
        foreach ($sub_l1_src as $sub_l1_item) {
            $WorkCat = $sub_l1_item->WorkCat;
            $L1ID = $sub_l1_item->L1ID;
            $data_set = L3Work::where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->get();
            $count = 0;
            $user_set_main = [];
            foreach ($data_set as $data_item) {
                $l3_id = $data_item->UID;
                $query = "SELECT UserInfo.UserName,UserInfo.avatar,UserInfo.Name,UserInfo.Family from UserInfo INNER JOIN WorkerSkils on UserInfo.UserName = WorkerSkils.UserName and WorkerSkils.SkilID = $l3_id ORDER BY `UserInfo`.`avatar` DESC";
                $user_set = DB::select($query);
                $count += count($user_set);
                foreach ($user_set as $user_item) {
                    array_push($user_set_main, $user_item);
                }
            }
            $user_set = json_encode($user_set_main);
            $ExtraData = [
                'count' => $count,
                'user_set' => $user_set
            ];
            $extra_data = json_encode($ExtraData);
            L1Work::where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->update(['extra_data' => $extra_data]);
        }

        return true;
    }
    private function update_L2_index($key_arr)
    {
        $WorkCat = $key_arr['WorkCat'];
        $L1ID = $key_arr['L1ID'];
        $sub_l1_src = L1Work::where('WorkCat', $WorkCat)->get();
        foreach ($sub_l1_src as $sub_l1_item) {
            $WorkCat = $sub_l1_item->WorkCat;
            $L1ID = $sub_l1_item->L1ID;
            $sub_l2_src = L2Work::where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->get();
            foreach ($sub_l2_src as $sub_l2_item) {
                $L2ID = $sub_l2_item->L2ID;
                $data_set = L3Work::where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->where('L2ID', $L2ID)->get();
                $count = 0;
                $user_set_main = [];
                foreach ($data_set as $data_item) {
                    $l3_id = $data_item->UID;
                    $query = "SELECT UserInfo.UserName,UserInfo.avatar,UserInfo.Name,UserInfo.Family from UserInfo INNER JOIN WorkerSkils on UserInfo.UserName = WorkerSkils.UserName and WorkerSkils.SkilID = $l3_id ORDER BY `UserInfo`.`avatar` DESC";
                    $user_set = DB::select($query);
                    $count += count($user_set);
                    foreach ($user_set as $user_item) {
                        array_push($user_set_main, $user_item);
                    }
                }
                $user_set = json_encode($user_set_main);
                $ExtraData = [
                    'count' => $count,
                    'user_set' => $user_set
                ];
                $extra_data = json_encode($ExtraData);
                L2Work::where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->where('L2ID', $L2ID)->update(['extra_data' => $extra_data]);
            }
        }

        return true;
    }
    private function update_L3_index($key_arr)
    {
        $L3_src = L3Work::where('WorkCat', $key_arr['WorkCat'])->where('L1ID', $key_arr['L1ID'])->where('L2ID', $key_arr['L2ID'])->get();
        foreach ($L3_src as $L3_item) {
            $l3_id = $L3_item->UID;
            $query = "SELECT UserInfo.UserName,UserInfo.avatar,UserInfo.Name,UserInfo.Family from UserInfo INNER JOIN WorkerSkils on UserInfo.UserName = WorkerSkils.UserName and WorkerSkils.SkilID = $l3_id ORDER BY `UserInfo`.`avatar` DESC";
            $user_set = DB::select($query);
            $count = count($user_set);
            $user_set = json_encode($user_set);
            $ExtraData = [
                'count' => $count,
                'user_set' => $user_set
            ];
            $extra_data = json_encode($ExtraData);
            L3Work::where('UID', $l3_id)->update(['extra_data' => $extra_data]);
        }
    }


    private function update_extra_info($index_table, $key_arr)
    {
        switch ($index_table) {
            case ('WorkCat'):
                $this->update_L1_index($key_arr);
                break;
            case ('L2Work'):
                $this->update_L2_index($key_arr);
                break;
            case ('L3Work'):
                $this->update_L3_index($key_arr);
                break;
        }
    }


    public function update_index_extra_data(string $table, $key_arr)
    {
        $this->update_extra_info($table, $key_arr);
        return true;
        if (Storage::has($table . '_last_update')) {
            $update_date = Storage::get($table . '_last_update');
            $today = new DateTime("today"); // This object represents current date/time with time set to midnight
            $match_date = DateTime::createFromFormat("Y-m-d", $update_date);
            $match_date->setTime(0, 0, 0); // set time part to midnight, in order to prevent partial comparison
            $diff = $today->diff($match_date);
            $diffDays = (int)$diff->format("%R%a");
            if ($diffDays > 0) { //update consulting info if last update older than 1 day

            }
        } else {
            Storage::put($table . '_last_update', date("Y-m-d"));
        }
    }
}
