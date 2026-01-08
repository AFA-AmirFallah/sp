<?php

namespace App\Functions;

use App\Cache\CacheFunctions;
use App\Models\setting;
use App\Models\UserCreditModMeta;
use Illuminate\Support\Facades\Cache;
use Hamcrest\Arrays\IsArray;

class CacheData
{
    private static function update_cache($option){
        $CacheFunctions = new CacheFunctions();
        $data = $CacheFunctions->main($option);
        $cache_data = [
            'data'=>$data,
            'expire'=>date("Y-m-d H:i:s", time() + 36000)
        ];
        Cache::put($option, $cache_data);
        return $data;
    }
    public static function get_theme_options($option)
    {
        if (Cache::has($option)) {
            $Cache_src = Cache::get($option);
            $expire = $Cache_src['expire'];
            if(date("Y-m-d H:i:s") > $expire){
                return self::update_cache($option);
            }
            return $Cache_src['data'];
        } else {
            return self::update_cache($option);
        }
    }
    public static function GetCreditMod($ModID)
    {
        if (Cache::has('CreditMod_' . $ModID)) {
            return Cache::get('CreditMod_' . $ModID);
        } else {
            $MainMenu = UserCreditModMeta::where('ID', $ModID)->first();
            Cache::put('CreditMod_' . $ModID, $MainMenu->extra);
            return $MainMenu->extra;
        }
    }
    public static function PutCreditMod()
    {
        $CreditModSrc = UserCreditModMeta::all();
        foreach ($CreditModSrc as $CreditModItem) {
            Cache::put('CreditMod_' . $CreditModItem->ID, $CreditModItem->extra);
        }
        return true;
    }

    public static function GetSetting($SeetingItem, $false_return = false)
    {
        if (Cache::has($SeetingItem)) {
            return Cache::get($SeetingItem);
        } else {
            $MainMenu = setting::where('name', $SeetingItem)->first();
            if ($MainMenu != null) {
                Cache::put($SeetingItem, $MainMenu->value);
                return $MainMenu->value;
            }
            return $false_return;

        }
    }

    public static function PutSetting($name, $value)
    {
        $targetsrc = setting::where('name', $name)->first();
        if ($targetsrc == null) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $Data = [
                'name' => $name,
                'value' => $value ?? ''
            ];
            setting::create($Data);
            return true;
        } else {
            $TargetId = $targetsrc->id;
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $Data = [
                'name' => $name,
                'value' => $value ?? ''
            ];
            Cache::put($name, $value);
            setting::where('id', $TargetId)->update($Data);
            return true;
        }
        return false;
    }
}
