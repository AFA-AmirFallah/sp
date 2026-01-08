<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerUpload extends Controller
{
    public function upload(){
        return view('Upload.CustomerUploadWPA');
    }

    public function Doupload(Request $request){
        dd($request->file('Myfile'));
    }
}
