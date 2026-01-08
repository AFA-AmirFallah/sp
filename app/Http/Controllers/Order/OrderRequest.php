<?php

namespace App\Http\Controllers\Order;

use App\Functions\OrderRequestClass;
use App\Functions\TextClassMain;
use App\Functions\UploadFiles;
use App\Http\Controllers\Controller;
use App\Models\citys;
use App\Models\L3Work;
use App\Models\provinces;
use App\Models\UserInfo;
use App\myappenv;
use App\SEO\seo_base;
use App\SEO\seo_base_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends Controller
{
    private function hiring_profile(Request $request, $RequestUser)
    {
        $UserInfo = null;
        if (Auth::user()->Role == myappenv::role_SuperAdmin) {
            if ($RequestUser != null) {
                $UserInfo = UserInfo::where('UserName', $RequestUser)->first();
                if ($UserInfo == null) {
                    return abort('404', 'نام کاربری موجود نیست');
                } else {
                    $UserName = $RequestUser;
                }
            } else {
                $UserName = Auth::id();
            }
        } else {
            $UserName = Auth::id();
        }
        $Order = new OrderRequestClass($UserName);
        if ($request->ajax()) {
            $seo = new seo_base_user($UserName);
            if ($request->has('page')) {
                $TargetPage = $request->input('page');
                $returnHTML = view("hiring.layout.$TargetPage", ['MyOrder' => $this, 'Order' => $Order, 'seo' => $seo])->render();
            } else {
                return 'error';
            }
            if ($request->has('page1')) {
                $TargetPage = $request->input('page1');
                $returnHTML .= view("hiring.layout.$TargetPage", ['MyOrder' => $this, 'Order' => $Order, 'seo' => $seo])->render();
            }
            if ($request->has('page2')) {
                $TargetPage = $request->input('page2');
                $returnHTML .= view("hiring.layout.$TargetPage", ['MyOrder' => $this, 'Order' => $Order, 'seo' => $seo])->render();
            }
            return ($returnHTML);
        }

        $Provinces = provinces::all();
        return view('hiring.MyProfile', ['UserInfo' => $UserInfo, 'Order' => $Order, 'Provinces' => $Provinces]);

    }
    public function myprofile(Request $request, $RequestUser = null)
    {
        if (myappenv::Lic['hiring']) {
            return $this->hiring_profile($request, $RequestUser);
        }
        $UserInfo = null;
        if (Auth::user()->Role == myappenv::role_SuperAdmin) {
            if ($RequestUser != null) {
                $UserInfo = UserInfo::where('UserName', $RequestUser)->first();
                if ($UserInfo == null) {
                    return abort('404', 'نام کاربری موجود نیست');
                } else {
                    $UserName = $RequestUser;
                }
            } else {
                $UserName = Auth::id();
            }
        } else {
            $UserName = Auth::id();
        }
        $Order = new OrderRequestClass($UserName);
        if ($request->ajax()) {
            $seo = new seo_base_user($UserName);


            if ($request->has('page')) {
                $TargetPage = $request->input('page');
                $returnHTML = view("Cooperations.layout.$TargetPage", ['MyOrder' => $this, 'Order' => $Order, 'seo' => $seo])->render();
            } else {
                return 'error';
            }
            if ($request->has('page1')) {
                $TargetPage = $request->input('page1');
                $returnHTML .= view("Cooperations.layout.$TargetPage", ['MyOrder' => $this, 'Order' => $Order, 'seo' => $seo])->render();
            }
            if ($request->has('page2')) {
                $TargetPage = $request->input('page2');
                $returnHTML .= view("Cooperations.layout.$TargetPage", ['MyOrder' => $this, 'Order' => $Order, 'seo' => $seo])->render();
            }
            return ($returnHTML);
        }

        $Provinces = provinces::all();
        if (myappenv::DashboardTheme == 'Theme2') {
            return view('Theme2.MyProfile', ['UserInfo' => $UserInfo, 'Order' => $Order, 'Provinces' => $Provinces]);
        }
        return view('Cooperations.MyProfile', ['UserInfo' => $UserInfo, 'Order' => $Order, 'Provinces' => $Provinces]);
    }

    public function Domyprofile(Request $request, $RequestUser = null)
    {
        if ($request->has('seo')) {
            $targte_url = $request->target_url;
            $seo = new seo_base_user($RequestUser ?? Auth::id());
            $valid_url_src = $seo->is_valid_url_to_save($targte_url);
            if (!$valid_url_src['result']) {
                return redirect()->back()->with('error', $valid_url_src['msg']);
            }
            $seo->set_url($valid_url_src['data']);
            return redirect()->back()->with('success', 'عملیات موفق');
        }
        if (Auth::user()->Role == myappenv::role_SuperAdmin) {
            if ($RequestUser != null) {
                $UserInfo = UserInfo::where('UserName', $RequestUser)->first();
                if ($UserInfo == null) {
                    return abort('404', 'نام کاربری موجود نیست');
                } else {
                    $UserName = $RequestUser;
                }
            } else {
                $UserName = Auth::id();
            }
        } else {
            $UserName = Auth::id();
        }
        $OrderClass = new OrderRequestClass($UserName);
        if ($request->input('submit') == 'savebaseInfo') {
            $OrderClass->SaveBaseInformation($request);
            return 'اطلاعات پایه به روز رسانی شد!';
        }
        if ($request->input('submit') == 'saveinfo') {
            $InfoTxt = $request->input('InfoTxt');
            $OrderClass->AddData('InfoTxt', $InfoTxt);
            return 'متن توضیحات به روز رسانی شد!';
        }
        if ($request->input('submit') == 'saveworktime') {
            $WorkTime = $request->input('WorkTime');
            $OrderClass->AddData('WorkTime', $WorkTime);
            return 'ساعت کاری  به روز رسانی شد!';
        }
        if ($request->input('submit') == 'savetag') {
            $UID = $request->input('UID');
            $reuslt = $OrderClass->AddIndex($UID);
            if ($reuslt) {
                return 'تگ مورد نظر به سیستم اضافه گردید!';
            } else {
                return 'تگ وارد شده از قبل در سیستم موجود بوده است!';
            }
        }
        if ($request->input('submit') == 'removeworkzone') {
            $UID = $request->input('UID');
            $reuslt = $OrderClass->RemoveIndex($UID);
            if ($reuslt) {
                return 'تگ مورد نظر حذف شد!';
            }
        }
        if ($request->input('submit') == 'mgtsave') {
            if ($request->has('mgt_id')) {
                $mgt_id = $request->input('mgt_id');
                $beforeData = $OrderClass->get_data('mgt_' . $mgt_id);
                $mgt_pic = $beforeData->mgt_pic;
                $resulttext = 'ویرایش اعضا انجام گرفت!';
            } else {
                $mgt_id = $OrderClass->GetNewMGTID();
                $mgt_pic = null;
                if ($mgt_id == 0) {
                    return abort('404', '1u427edf');
                }
                $resulttext = 'عضو جدید به سیستم اضافه شد';
            }

            $mgt_name = $request->input('mgt_name');
            $mgt_title = $request->input('mgt_title');
            $mgt_phone = $request->input('mgt_phone');
            $mgt_mail = $request->input('mgt_mail');
            $mgt_desc = $request->input('mgt_desc');
            $mgtInfo = [
                'mgt_name' => $mgt_name,
                'mgt_title' => $mgt_title,
                'mgt_phone' => $mgt_phone,
                'mgt_mail' => $mgt_mail,
                'mgt_desc' => $mgt_desc,
                'mgt_pic' => $mgt_pic,
                'mgt_confirm' => 0,
            ];
            $OrderClass->AddData('mgt_' . $mgt_id, $mgtInfo);



            return $resulttext;
        }
        if ($request->input('submit') == 'saveaddress') {
            if ($request->input('Province') == null) {
                $ProvinceName = null;
            } else {
                $PrvSrc = provinces::where('id', $request->input('Province'))->first();
                $ProvinceName = $PrvSrc->ProvinceName;
            }
            if ($request->input('Shahrestan') == null) {
                $ShahrestanName = null;
            } else {
                $SahrestanSrc = citys::where('id', $request->input('Shahrestan'))->first();
                $ShahrestanName = $SahrestanSrc->CityName;
            }
            $AddressInfo = [
                'Province' => $request->input('Province'),
                'ProvinceName' => $ProvinceName,
                'Shahrestan' => $request->input('Shahrestan'),
                'ShahrestanName' => $ShahrestanName,
                'mgt_phone' => $request->input('mgt_phone'),
                'mgt_mail' => $request->input('mgt_mail'),
                'fulladdress' => $request->input('fulladdress'),

            ];
            $OrderClass->AddData('address', $AddressInfo);
            return 'آدرس به روز رسانی شد!';
        }
        if ($request->has('file')) {

            $Myupload = new UploadFiles;
            $SmallFilePath = '/storage/files/';
            ;
            $filepath = public_path() . $SmallFilePath;
            $filename = time() . '_' . rand(111111, 999999999);
            $data = $Myupload->uploadfile($request, 'file', $filename, $filepath);
            if ($data['success'] == 1) { //upload successfully
                $file_full_path = url('/') . $SmallFilePath . $filename . '.' . $data['extension'];

                if ($request->has('mgt')) {  //picture of managers
                    $OrderClass->UploadManagerPic($request->mgt, $file_full_path);
                } else { //Company logo
                    UserInfo::where('UserName', $OrderClass->get_UserName())->update(['Pic' => $file_full_path]);
                }
            }
            return response()->json($data);
        }
    }
}
