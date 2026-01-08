<?php


namespace App\Functions;

use Illuminate\Support\Facades\Validator;

class UploadFiles
{
    public function uploadTArgetfile($file, $filepath, $filename)
    {
        $data = array();
        // File extension
        $extension = $file->getClientOriginalExtension();
        // File upload location
        // Upload file
        $file->move($filepath, $filename .'.'.$extension);
        // File path
        //$filepath = url('files/' . $filename);
        // Response
        $data['success'] = 1;
        $data['message'] = 'Uploaded Successfully!';
        $data['filepath'] = $filepath;
        $data['extension'] = $extension;
        return $data;
    }
    public function uploadfile($request,$file_field_name,$dis_file_name,$dis_file_path){
        $data = array();
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:2048'
        ]);

        if ($validator->fails()) {

            $data['success'] = 0;
            $data['error'] = $validator->errors()->first('file'); // Error response

        } else {
            if ($request->file($file_field_name)) {
                $file = $request->file($file_field_name);
                $filename = $dis_file_name;
                $filepath = $dis_file_path;
                $data = $this->uploadTArgetfile($file, $filepath, $filename);
            } else {
                // Response
                $data['success'] = 2;
                $data['message'] = 'File not uploaded.';
            }
        }
        return $data;

    }
}
