<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{
    public static function STD_to_Arr($InputSTB){
        return json_decode(json_encode($InputSTB), true);
    }
   
}
