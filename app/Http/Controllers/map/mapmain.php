<?php

namespace App\Http\Controllers\map;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class mapmain extends Controller
{
    public function ShowMap(){
        return view('map.ShowMap');
    }
    public function mapsfind(){
        return view("map.FindOnMap");
    }
}
