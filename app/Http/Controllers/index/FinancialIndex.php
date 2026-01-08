<?php

namespace App\Http\Controllers\index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserCreditIndex;
use Auth;

class FinancialIndex extends Controller
{
    public function FinancialIndex()
    {
        $usercreditindex = usercreditindex::all()->where('branch',Auth::user()->branch);
        return view('Credit.FinancialIndex', ['usercreditindex' => $usercreditindex]);
    }
    public function DoFinancialIndex(Request $request)
    {
        if ($request->input('submit') == 'AddIndex') {
            $user_branch = Auth::user()->branch;
            $usercreditindexData = [
                'IndexName' => $request->input('IndexName'),
                'IndexType' => '1',
                'branch' => $user_branch,
                'Note' => ''
            ];
            usercreditindex::create($usercreditindexData);
            return redirect()->route('FinancialIndex');
        } elseif ($request->has('DeleteIndex')) {
            $DeleteIndex = $request->input('DeleteIndex');
            $UserCreditIndexSrc = UserCreditIndex::where('IndexID', $DeleteIndex)->first();
            if(Auth::user()->branch != $UserCreditIndexSrc->branch){
                return redirect()->back()->with('error','شاخص مالی مورد نظر قابل حذف نیست!');
            }
            $usercreditindexData = [
                'IndexType' => '0',
            ];
            $result = usercreditindex::where('IndexID', $DeleteIndex)->update($usercreditindexData);
            if ($result == 1) {
                return redirect()->back()->with('success', __("Financial index was delete"));
            } else {
                return redirect()->back()->with("error", __("The error has accure in your requsest please try again or call to callcenter!"));
            }
        }elseif ($request->has('RecoverIndex')) {
            $DeleteIndex = $request->RecoverIndex;
            $UserCreditIndexSrc = UserCreditIndex::where('IndexID', $DeleteIndex)->first();
            if(Auth::user()->branch != $UserCreditIndexSrc->branch){
                return redirect()->back()->with('error','شاخص مالی مورد نظر قابل بازیابی نیست!');
            }
            $usercreditindexData = [
                'IndexType' => '1',
            ];
            $result = usercreditindex::where('IndexID', $DeleteIndex)->update($usercreditindexData);
            if ($result == 1) {
                return redirect()->back()->with('success', 'بازیابی موفقیت آمیز');
            } else {
                return redirect()->back()->with("error", __("The error has accure in your requsest please try again or call to callcenter!"));
            }
        }
    }
}
