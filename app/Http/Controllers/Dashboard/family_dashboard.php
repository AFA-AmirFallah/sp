<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class family_dashboard extends Controller
{
    public function family_dashboard(Request $request) {
        return view('Layouts.Theme9.DashboardFamily');
    }
}
