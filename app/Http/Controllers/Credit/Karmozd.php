<?php

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Karmozd extends Controller
{
    public function KarmozdMgt(){
        return view('Credit.KarmozdMgt');
    }
    public function DoKarmozdMgt(Request $request){
        dd('hi');
    }
}
