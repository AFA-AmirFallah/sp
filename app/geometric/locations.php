<?php

namespace App\geometric;

use App\Models\citys;
use App\Models\provinces;

class locations
{

    public static function get_all_provinces()
    {
        return provinces::all();
    }
    public static function get_provinces_by_id($provinces_id){
        if($provinces_id == null){
            return 'استان مشخص نشده';
        }
        $provinces_src = provinces::where('id',$provinces_id)->first();
        if($provinces_src == null){
            return 'استان مشخص نشده';
        }
        return $provinces_src->ProvinceName;
    }
    public static function get_city_by_id($city_id){
        if($city_id == null){
            return 'شهر مشخص نشده';
        }
        if(!is_numeric($city_id)){
            return '';
        }
        $city_src = citys::where('id',$city_id)->first();
        if($city_id == null){
            return '';
        }
        return $city_src->CityName;
    }
}
