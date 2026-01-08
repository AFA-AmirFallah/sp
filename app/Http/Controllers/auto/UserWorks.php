<?php

namespace App\Http\Controllers\auto;

use App\Auto\Auto_user_class;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserWorks extends Controller
{
    public function user_dasahbord()
    {
        $auto = new Auto_user_class(Auth::id());
        return view("Auto.AutoUserDashboard", ['auto' => $auto]);
    }
}
