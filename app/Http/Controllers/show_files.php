<?php

namespace App\Http\Controllers;

use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class show_files extends Controller
{

    public function show($username,$file_name)
    {
        $base_path = 'public/document';
        $file_name = $base_path . '/'. $username . '/'.$file_name;
        if (!Auth::check()) {
            return null;
        }
        $exist = Storage::disk('private')->exists($file_name);
        if(!$exist){
            return null;
        }
        if(Auth::user()->Role >= myappenv::role_admin){
            return Storage::disk('private')->response($file_name);
        }
        if(Auth::id() != $username ){
            return null;
        }
        return Storage::disk('private')->response($file_name);

    }
}
