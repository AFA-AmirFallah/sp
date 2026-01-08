<?php


namespace App\Functions;



class DateTimeClass
{
    /**
     * 1 Sec = 1 int
     * 1 Min = 60 int
     */

    public function get_now_int($WithSec = false){
        if($WithSec){
            $Now = strtotime(date("Y-m-d H:i:s")) ;
            return $Now;

        }else{
            $Now = strtotime(date("Y-m-d H:i"));
            return $Now;
        }
    }

    public function get_now_defrence($Minuts){
        $Now = $this->get_now_int();
        $DifSec = $Minuts * 60;
        return $Now + $DifSec;

    }




}
