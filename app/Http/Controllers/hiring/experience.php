<?php

namespace App\Http\Controllers\hiring;

use App\Functions\TextClassMain;
use App\hiring\hiring_comments;
use App\hiring\hiring_main;
use App\hiring\hiring_package_manager;
use App\Http\Controllers\Controller;
use App\Models\comments;
use App\Users\otp;
use App\Users\UserClass;
use Dotenv\Store\File\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class experience extends Controller
{
    public function worker_single_experience($id)
    {
        $comment = new hiring_comments;
        $comment_src = $comment->get_single_comment($id, Auth::id(), Auth::user()->Role);

        return view('hiring.worker_single_experience', ['id' => $id, 'comment_src' => $comment_src]);
    }
    public function Doworker_single_experience($id)
    {

    }
    public function worker_experience_list()
    {
        $pkg = new hiring_package_manager;
        $package = $pkg->get_user_active_license(Auth::id() . 'sss');
        $lic_count = $package->count();
        if ($lic_count == 0) {
            return view('hiring.worker_no_lic');
        }



        $comments = new hiring_comments;
        $comments_src = $comments->get_worker_comments(Auth::id());
        return view('hiring.worker_experience_list', ['comments' => $comments, 'comments_src' => $comments_src]);
    }
    public function Doworker_experience_list(Request $request)
    {

    }


    public function experience_list()
    {
        $experience_src = comments::where('creator', Auth::id())->get();
        return view('Layouts.Theme7.experience_list', ['experience_src' => $experience_src]);
    }
    private function load_comment(Request $request)
    {
        $comment = new hiring_comments;
        return $comment->get_single_comment($request->id, Auth::id(), Auth::user()->Role);
    }

    public function Doexperience_list(Request $request)
    {
        if ($request->ajax()) {
            if ($request->function == 'load_comment') {
                return $this->load_comment($request);
            }

        }
    }

    public function add_experience()
    {
        $hiring = new hiring_comments;
        $open_comments = $hiring->number_of_my_open_comment();
        if ($open_comments == 0) {
            return view('Layouts.Theme7.add_experience', ['hiring' => $hiring]);
        } else {
            return view('Layouts.Theme7.add_experience_open', ['hiring' => $hiring]);
        }


    }
    private function add_customer_comment(Request $request, $creator_username)
    {
        $hiring = new hiring_comments;
        $add_comment = $hiring->add_new_comment($request, $creator_username);
        if ($add_comment['result']) {
            return [
                'result' => true,
                'data' => view('Layouts.Theme7.add_experience_result', ['code' => $add_comment['id']])->render()
            ];
        }
        return [
            'result' => false
        ];

    }
    private function add_customer_by_comment(Request $request)
    {
        $user_class = new UserClass;
        $my_text = new TextClassMain;
        $user_Name = $my_text->StripText($request->user_Name);
        $user_Name = substr($user_Name, 0, 20);
        $user_Family = $my_text->StripText($request->user_Family);
        $user_Family = substr($user_Family, 0, 20);
        $user_MobileNo = $request->user_MobileNo;

        $user_src = $user_class->AddUserBase('','',$user_Name,$user_Family,$user_MobileNo,$user_MobileNo);
        return $user_src->UserName;
    }
    public function Doadd_experience(Request $request)
    {
        if ($request->ajax()) {
            if ($request->function == 'send_otp') {
                $captcha = $request->captcha ?? '';
                $form = captcha_check($captcha);
                if ($form) {
                    $otp = new otp;
                    return $otp->send_otp($request->Mobile_no);
                }
                return [
                    'result' => false,
                    'msg' => 'لطفا کد کپتچا را مطابق تصویر وارد نمائید!'
                ];
            }
            if ($request->function == 'add_comment') {
                if (Auth::check()) {
                    $creator_username = Auth::id();
                } else {
                    $creator_username = $this->add_customer_by_comment($request);
                }

                return $this->add_customer_comment($request, $creator_username);
            }
            if ($request->function == 'number_validation') {
                $hiring = new hiring_comments;
                return $hiring->find_input_code_type($request->Mobile_number);
            }
            if ($request->function == 'code_verification') {
                return [
                    'result'=>true
                ];
            }
        }

    }
}
