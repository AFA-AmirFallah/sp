<?php

namespace App\Http\Controllers\Calender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function calendermain()
    {
        return view('calender.calender_main');
    }
    public function Docalendermain(Request $request)
    {
        return 'post';
    }
}
