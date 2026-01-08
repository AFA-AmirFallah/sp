<?php


namespace App\Functions;

use App\Models\html_object;
use App\Models\setting;
use Illuminate\Support\Facades\Cache;

class AppSetting
{
    public static function get_html_obj($objectname , $branch =0){
        if (Cache::has($objectname)) {
            return Cache::get($objectname);
        } else {
            $TargetSrc  = html_object::where('htmlname', $objectname)->where('branch', env('Branch'))->first();
            if($TargetSrc == null){
                return null;
            }else{
                Cache::put($objectname, $TargetSrc->htmlobj);
                return $TargetSrc->htmlobj;
            }
        }
    }
    public static function getcache($CacheName , $branch =0)
    {
        
        if (Cache::has($CacheName)) {
            return Cache::get($CacheName);
        } else {
            $TargetSrc  = setting::where('name', $CacheName)->first();
            if($TargetSrc == null){
                return null;
            }else{
                Cache::put($CacheName, $TargetSrc->value);
                return $TargetSrc->value;
            }
        }
    }
    public static function ClearCache(){
        Cache::flush();
        return true;
    }
    private function InitSetingTable($name)
    {
        switch ($name) {
            case 'MaliSort':
                $setingData = [
                    'name' => $name,
                    'value' => 'DESC'
                ];
                $value = 'DESC';
                setting::create($setingData);
                break;
            case 'TransactionSendSMS':
                $setingData = [
                    'name' => $name,
                    'value' => 'true'
                ];
                $value = 'true';
                setting::create($setingData);
                break;
            case 'ShiftWithPasteTime':
                $setingData = [
                    'name' => $name,
                    'value' => 'false'
                ];
                setting::create($setingData);
                $value = 'false';
                break;
            case 'DoubleConfirm':
                $setingData = [
                    'name' => $name,
                    'value' => 'false'
                ];
                setting::create($setingData);
                $value = 'false';
                break;
        }
        return $value;
    }
    public function GetSettingValue($name , $branch =1  )
    { //Todo: This function should use Cache
        $settingType =  setting::where('name', $name)->where('branch',$branch)->first();
        if ($settingType == null) {
            return $this->InitSetingTable($name);
        } else {
            return $settingType->value;
        }
    }
}
