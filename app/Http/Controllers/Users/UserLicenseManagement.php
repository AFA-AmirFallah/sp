<?php

namespace App\Http\Controllers\Users;

use App\Functions\TashimClass;
use App\Http\Controllers\Controller;
use App\Models\L1Work;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\UserCreditIndex;
use App\Models\WorkCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserLicenseManagement extends Controller
{
    public function AddLic(){
        $usercreditindexs = UserCreditIndex::all()->where('IndexType', 1);
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();
        $Tashim = new TashimClass();
        $TashimSrc = $Tashim->get_all_tashims();
        $QeryRespons = "SELECT RespnsType.ID, RespnsType.RespnsTypeName,RespnsType.ImgURL, RespnsType.hPrice, RespnsType.fixPrice, RespnsType.CustomerhPrice, RespnsType.CustomerfixPrice , RespnsType.UserCreditIndex , UserCreditIndex.IndexName FROM RespnsType LEFT JOIN UserCreditIndex on RespnsType.UserCreditIndex = UserCreditIndex.IndexID";
        $Services = DB::select($QeryRespons);
        return view('lics/AddLic', ['TashimSrc'=>$TashimSrc, 'usercreditindexs' => $usercreditindexs, 'Services' => $Services, 'WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works]);

    }
    public function DoAddLic(Request $request){
        dd($request->input());
    }
}
