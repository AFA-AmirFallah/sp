<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Models\forms_meta;
use App\Models\Parvandeh;
use App\Models\ParvandehMain;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Http\Request;
use Auth;
use DB;
use DOMDocument;
use DOMXPath;

class PatDoc extends Controller
{
    private function show_customer_docs($RequestDoc = null)
    {
        $RequestPat = Auth::id();
        if ($RequestDoc == null) {
            $PatRole = myappenv::role_customer;
            $Query = "SELECT UserInfo.UserName,UserInfo.Name as nameofuser,UserInfo.Family,UserInfo.MobileNo,UserInfo.Email,UserInfo.Phone1,UserInfo.Phone2,UserInfo.Address,UserInfo.Role,UserInfo.Birthday,UserInfo.CreateDate,UserStatus.Name as statusname,UserInfo.Status, UserInfo.UserPass,
(SELECT COALESCE(sum(Point),0) as point FROM UserPoint WHERE UserName = '$RequestPat' and ConfirmUser is not null ) as point ,UserInfo.Sex as Sex , UserRole.RoleName ,UserInfo.extranote   FROM UserInfo   inner join UserStatus on UserInfo.Status = UserStatus.Status INNER JOIN UserRole on UserInfo.Role = UserRole.Role where UserInfo.Role = $PatRole and UserName = '$RequestPat'";
            $UserInfoBase = DB::select($Query);
            $Query = "SELECT ParvandehMain.* , UserInfo.Name as creatorName , UserInfo.Family as creatorFamily FROM ParvandehMain INNER JOIN UserInfo on ParvandehMain.FromUser = UserInfo.UserName where ParvandehMain.UserName = '$RequestPat'";
            $ParvandehMains = DB::select($Query);
            foreach ($UserInfoBase as $UserInfoBasetarget) {
                $UserInfoResult = $UserInfoBasetarget;
            }
            $RelatedForms = forms_meta::where('status', 1)->where('branch', Auth::user()->branch)->where('UserAccessLevel', $UserInfoResult->Role)->get();
            $GlobalForms = forms_meta::where('status', 1)->where('branch', Auth::user()->branch)->where('UserAccessLevel', 0)->get();
            return view("Patients.PatDocs_customer", ['RelatedForms' => $RelatedForms, 'GlobalForms' => $GlobalForms, 'RequestPat' => $RequestPat, "UserInfoResult" => $UserInfoResult, "ParvandehMains" => $ParvandehMains, 'RequestPat' => $RequestPat]);
        } else {
            $ParvandehInfo = ParvandehMain::where('ParvandehID', $RequestDoc)->where('UserName', $RequestPat)->first();
            if ($ParvandehInfo == null) {
                return abort('404', 'پرونده درخواست شده وجودندارد');
            }
            $Query = "SELECT Parvandeh.* , UserInfo.Name as creatorName , UserInfo.Family as creatorFamily FROM Parvandeh LEFT JOIN UserInfo on Parvandeh.creator = UserInfo.UserName where Parvandeh.ParvandehID = $RequestDoc order by Parvandeh.SubParvandehID DESC";
            $FormSrc =  DB::select($Query);
            $PatiantInfo = UserInfo::where("UserName", $ParvandehInfo->UserName)->first();
            return view("Patients.PatDoc", ['FormSrc' => $FormSrc, 'ParvandehInfo' => $ParvandehInfo, 'PatiantInfo' => $PatiantInfo]);
        }
    }
    public function MainDoc($RequestPat = null, $RequestDoc = null)
    {
        if (auth::user()->Role == myappenv::role_customer) {
            return $this->show_customer_docs($RequestDoc);
        }
        if ($RequestPat == null) {
            return abort('404');
        }

        if ($RequestDoc == null) {
            $PatRole = myappenv::role_customer;
            $UserRole = Auth::user()->Role;
            $Query = "SELECT UserInfo.UserName,UserInfo.Name as nameofuser,UserInfo.Family,UserInfo.MobileNo,UserInfo.Email,UserInfo.Phone1,UserInfo.Phone2,UserInfo.Address,UserInfo.Role,UserInfo.Birthday,UserInfo.CreateDate,UserStatus.Name as statusname,UserInfo.Status, UserInfo.UserPass,
(SELECT COALESCE(sum(Point),0) as point FROM UserPoint WHERE UserName = '$RequestPat' and ConfirmUser is not null ) as point ,UserInfo.Sex as Sex , UserRole.RoleName ,UserInfo.extranote   FROM UserInfo   inner join UserStatus on UserInfo.Status = UserStatus.Status INNER JOIN UserRole on UserInfo.Role = UserRole.Role where (UserInfo.Role < $UserRole  or UserInfo.Role = $PatRole ) and UserName = '$RequestPat'";
            $UserInfoBase = DB::select($Query);
            $Query = "SELECT ParvandehMain.* , UserInfo.Name as creatorName , UserInfo.Family as creatorFamily FROM ParvandehMain INNER JOIN UserInfo on ParvandehMain.FromUser = UserInfo.UserName where ParvandehMain.UserName = '$RequestPat'";
            $ParvandehMains = DB::select($Query);
            foreach ($UserInfoBase as $UserInfoBasetarget) {
                $UserInfoResult = $UserInfoBasetarget;
            }
            $RelatedForms = forms_meta::where('status', 1)->where('branch', Auth::user()->branch)->where('UserAccessLevel', $UserInfoResult->Role)->get();
            $GlobalForms = forms_meta::where('status', 1)->where('branch', Auth::user()->branch)->where('UserAccessLevel', 0)->get();
            return view("Patients.PatDocs", ['RelatedForms' => $RelatedForms, 'GlobalForms' => $GlobalForms, 'RequestPat' => $RequestPat, "UserInfoResult" => $UserInfoResult, "ParvandehMains" => $ParvandehMains, 'RequestPat' => $RequestPat]);
        } else {
            $ParvandehInfo = ParvandehMain::where('ParvandehID', $RequestDoc)->where('UserName', $RequestPat)->first();
            if ($ParvandehInfo == null) {
                return abort('404', 'پرونده درخواست شده وجودندارد');
            }
            $Query = "SELECT Parvandeh.* , UserInfo.Name as creatorName , UserInfo.Family as creatorFamily FROM Parvandeh LEFT JOIN UserInfo on Parvandeh.creator = UserInfo.UserName where Parvandeh.ParvandehID = $RequestDoc order by Parvandeh.SubParvandehID DESC";
            $FormSrc =  DB::select($Query);
            $PatiantInfo = UserInfo::where("UserName", $ParvandehInfo->UserName)->first();
            return view("Patients.PatDoc", ['FormSrc' => $FormSrc, 'ParvandehInfo' => $ParvandehInfo, 'PatiantInfo' => $PatiantInfo]);
        }
    }

    public function DoMainDoc($RequestPat,  Request $request, $RequestDoc = null)
    {
        if ($request->ajax()) {
            if ($request->function == 'getform') {
                $FormSrc = forms_meta::where('id', $request->FormID)->where('branch', Auth::user()->branch)->where('status', 1)->first();
                if ($FormSrc == null) {
                    return false;
                }
                return $FormSrc;
            }
        }
        if ($request->submit == 'form_register') {
            if ($request->submit == 'form_register') {

                $FormSrc = forms_meta::where('id', $request->form_id)->where('branch', Auth::user()->branch)->where('status', 1)->first();
                $ExtraData['FormSrc'] = $FormSrc;
                if ($FormSrc == null) {
                    return abort('404', 'فرم مورد نظر معتبر نمی باشد');
                }
                $Content =  $FormSrc->Content;
                $inputArr = [];
                foreach ($request->input() as $index => $values) {
                    if ($index != '_token' && $index != 'submit') {
                        $inputArr[$index] = $values;
                        $dom = new DOMDocument();
                        $dom->loadHTML('<?xml encoding="utf-8" ?> ' . $Content);
                        $xpath = new DOMXPath($dom);
                        $out = '';
                        $quey = '//input[@name="' . $index . '"]';
                        $input = $xpath->query($quey); // target that particular element
                        if ($input->length > 0) { // if found!
                            $inputs = $input->item(0);
                            $inputs->setAttribute('value', $values); // set your value
                            $inputs->setAttribute('disabled', true); // set your value
                            $inputs->setAttribute('class', 'report_value');
                            foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $e) {

                                $out .= $dom->saveHTML($e);
                            }
                            $Content =  $out;
                        } else {
                            $quey = '//textarea[@name="' . $index . '"]';
                            $input = $xpath->query($quey); // target that particular element
                            if ($input->length > 0) { // if found!
                                $inputs = $input->item(0);
                                $inputs->setAttribute('placeholder', $values); // set your value
                                $inputs->setAttribute('disabled', true); // set your value
                                $inputs->setAttribute('class', 'report_value');
                                foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $e) {

                                    $out .= $dom->saveHTML($e);
                                }
                                $Content =  $out;
                            }
                        }
                    }
                }
                $html_content = $Content;
                $ParvandehID = $request->ParvandehID;
                $ParvandeSrc = Parvandeh::where('ParvandehID', $ParvandehID)->get();
                $SubParvandehID = count($ParvandeSrc) + 1;
                $Parvandeh_data = [
                    'ParvandehID' => $ParvandehID,
                    'SubParvandehID' => $SubParvandehID, //Increase last form id
                    'owner' => $RequestPat,
                    'branch' => Auth::user()->branch,
                    'creator' => Auth::id(),
                    'form_id' => $request->form_id,
                    'html_content' => $html_content,
                    'fields_content' => json_encode($inputArr),
                    'Type' => 1,
                    'extra' => json_encode($ExtraData)
                ];
                Parvandeh::create($Parvandeh_data);
                return redirect()->back()->with('success', 'فرم در پرونده ثبت شد!');
            }
        }

        if ($request->input('submit') == 'adddoc') {
            $DocSubject = $request->input('DocumentSubject');
            $DocPeriority = '0';
            $DocText = $request->input('DocText');
            $ParvandehData = [
                'UserName' => $RequestPat,
                'Subject' => $DocSubject,
                'Text' => $DocText,
                'Priority' => $DocPeriority,
                'CreateDate' => now(),
                'State' => 0,
                'FromUser' => Auth::id()
            ];
            ParvandehMain::create($ParvandehData);
            return redirect()->back()->with("success", __("Add pat document successfully!!"));
        }
    }
}
