<?php


namespace App\Functions;

use App\Models\L3Work;
use App\myappenv;

class FamilyClass
{
    public function get_family_index(){
        return L3Work::where('WorkCat', myappenv::FamilyWorkCat )
        ->where('L1ID',myappenv::FamilyIndexL1)
        ->where('L2ID',myappenv::FamilyIndexL2)->get();
    }
}
