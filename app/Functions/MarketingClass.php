<?php

namespace App\Functions;

use App\Models\UserInfo;
use Session;


class MarketingClass
{
    public function MarketingCodeEntered($code)
    {
        $MarketerSrc =  UserInfo::where('EXT', $code)->first();
        if ($MarketerSrc == null) {
            return false;
        }
        Session::put('Marketer', $MarketerSrc->UserName);
        return true;
    }
    public function get_marketer(){
        if( Session::has('Marketer')){
            return session::get('Marketer');
        }else{
            return null;
        }

    }
}
