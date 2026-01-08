<?php

namespace App\Http\Controllers;

use App\myappenv;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use PHPUnit\Framework\MockObject\Builder\Identity;
use Session;

class helpme
{
    const str = null;
}

class FileManagerHandler extends Controller
{

    public $folder = null;
    private function RenewSession()
    {
        if(Auth::user()->Role >= myappenv::role_admin){
            if (isset($_REQUEST['usertraget'])) {
                Session::put('target', $_REQUEST['usertraget']);
            } else {
                //Session::put('target', auth()->id());
            }
        }else{
            if(Auth::check()){
                Session::put('target', Auth::id());
            }else{
                return abort('404','دسترسی غیر مجاز');
            }
            //Session::put('target', auth()->id());
        }

    }
    public function userField()
    {
        //dd($_REQUEST);
        if (Session::has('target')) {
            if (isset($_REQUEST['_'])) {
                // noting
            } else {
                $this->RenewSession();
            }
        } else {
            $this->RenewSession();
        }
        return Session::get('target');
    }
}
