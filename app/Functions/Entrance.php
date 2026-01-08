<?php


namespace App\Functions;


use App\Models\entrance_personel;
use App\myappenv;
use Request;
use date;
use DB;

class Entrance
{

    public function isuseronline($UserName){

        $today = date('Y-m-d');
        $Entrance = entrance_personel::where('UserName',$UserName)->where('WorkingDate',$today)->first();
        if($Entrance == null){
            return false;
        }else{
            return true;
        }
    }
    public function OnlinePersonel($Branch = null){
        $today = date('Y-m-d');
        if($Branch == null){
            $Query = "SELECT UserInfo.UserName, UserInfo.Name , UserInfo.Family , entertime ,enterip  
            FROM entrance_personels INNER JOIN UserInfo 
            on entrance_personels.UserName = UserInfo.UserName
            where WorkingDate = '$today' and exittime is null ";
        }else{
            $Query = "SELECT UserInfo.UserName, UserInfo.Name , UserInfo.Family , entertime ,enterip  
            FROM entrance_personels INNER JOIN UserInfo 
            on entrance_personels.UserName = UserInfo.UserName
            where WorkingDate = '$today' and UserInfo.branch = $Branch and exittime is null ";
        }

        return DB::select($Query);
    }
    public function SaveEntrance($UserName)
    {
        $today = date('Y-m-d');
        $entrance_record = entrance_personel::where('WorkingDate', $today)->where('UserName', $UserName)->where('exittime', null)->first();
        if ($entrance_record == null) {
            $EntranceData = [
                'UserName' => $UserName,
                'WorkingDate' => now(),
                'entertime' => now(),
                'enterip' => Request::ip()
            ];
            $result = entrance_personel::create($EntranceData);
            if ($result->id != null) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function ExitSave($UserName)
    {
        $today = date('Y-m-d');
        $entrance_record = entrance_personel::where('WorkingDate', $today)->where('UserName', $UserName)->where('exittime', null)->first();
        if ($entrance_record != null) {
            $EntranceData = [
                'exittime' => now(),
                'exitip' => Request::ip()
            ];
            $result = entrance_personel::where('UserName',$UserName)->where('WorkingDate',$today)->where('exittime',null)->update($EntranceData);
            if ($result == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

}
