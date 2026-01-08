<?php

namespace App\Http\Controllers\forms;

use App\Http\Controllers\Controller;
use App\Models\forms_meta;
use App\Models\L3Work;
use App\Models\UserRole;
use App\myappenv;
use Illuminate\Http\Request;
use Auth;
use DB;
use Ramsey\Uuid\Type\Integer;

class formsadmin extends Controller
{
    public function MakeForm()
    {
        $WorkCat = myappenv::PostIndexWorkCat;
        $L1ID = myappenv::NewsIndexL1;
        $L2ID = myappenv::NewsIndexL2;
        $L1IDCat = myappenv::NewsCatL1;
        $L2IDCat = myappenv::NewsCatL2;
        $family_index  = [];
        $cats = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1IDCat)->where('L2ID', $L2IDCat);
        $Tags = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->where('L2ID', $L2ID);
        $UserLevel = UserRole::all();
        return view("forms.MakeForm", ['family_index' => $family_index, 'Tags' => $Tags, 'cats' => $cats, 'UserLevel' => $UserLevel]);
    }
    public function DoMakeForm(Request $request)
    {
        $form_data = [
            'title' => $request->title,
            'up_title' => $request->up_title,
            'sub_title' => $request->sub_title,
            'Pic' => $request->pic,
            'Content' => $request->ce,
            'PostContent' => $request->PostContent,
            'Abstract' => $request->Abstract,
            'Creator' => Auth::id(),
            'Owner' => Auth::id(),
            'Status' => 0,
            'Type' => 1,
            'UserAccessLevel' => $request->UserAccessLevel,
            'AdminAccessLevel' => $request->AdminAccessLevel,
            'branch'=>Auth::user()->branch,
        ];
        $createResult = forms_meta::create($form_data);

        if ($createResult->exists) {
            return redirect()->route('FormsList');
        }
    }
    public function FormsList()
    {
        $user_branch = Auth::user()->branch;
        $Query = "SELECT *, userroles.RoleName AS userPrevilage, admin_role.RoleName AS adminPrevilage FROM forms_metas LEFT JOIN UserRole AS admin_role ON forms_metas.AdminAccessLevel = admin_role.Role LEFT JOIN UserRole AS userroles ON forms_metas.UserAccessLevel = userroles.Role where forms_metas.status <= 100 and forms_metas.branch = $user_branch ";
        $forms_src = DB::select($Query);
        return view('forms.FormsList', ['forms_src' => $forms_src]);
    }
    public function DoFormsList()
    {
    }
    public function EditForm(int $form_id)
    {

        $WorkCat = myappenv::PostIndexWorkCat;
        $L1ID = myappenv::NewsIndexL1;
        $L2ID = myappenv::NewsIndexL2;
        $L1IDCat = myappenv::NewsCatL1;
        $L2IDCat = myappenv::NewsCatL2;
        $family_index  = [];
        $cats = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1IDCat)->where('L2ID', $L2IDCat);
        $Tags = L3Work::all()->where('WorkCat', $WorkCat)->where('L1ID', $L1ID)->where('L2ID', $L2ID);
        $UserLevel = UserRole::all();
        $form_src = forms_meta::where('status', '<=', 100)->where('id', $form_id)->where('branch',Auth::user()->branch)->first();
        if ($form_src == null) {
            return abort('400', 'فرم مورد نظر در سامانه موجود نمی باشد!');
        }
        return view("forms.EditForm", ['form_src' => $form_src, 'family_index' => $family_index, 'Tags' => $Tags, 'cats' => $cats, 'UserLevel' => $UserLevel]);
    }
    public function DoEditForm(Request $request, int $form_id)
    {
        if ($request->submit == 'edit') {
            $form_data = [
                'title' => $request->title,
                'up_title' => $request->up_title,
                'sub_title' => $request->sub_title,
                'Pic' => $request->pic,
                'Content' => $request->ce,
                'PostContent' => $request->PostContent,
                'Abstract' => $request->Abstract,
                'UserAccessLevel' => $request->UserAccessLevel,
                'AdminAccessLevel' => $request->AdminAccessLevel,
                'branch'=>Auth::user()->branch
            ];
            $createResult = forms_meta::where('id', $form_id)->update($form_data);

            return redirect()->back()->with('success', 'ویرایش با موفقیت انجام شد!');
        }
    }
}
