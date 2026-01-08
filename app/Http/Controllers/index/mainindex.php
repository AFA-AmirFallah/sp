<?php

namespace App\Http\Controllers\index;

use App\Http\Controllers\Controller;
use App\Models\L1Work;
use App\Models\L2Work;
use App\Models\L3Work;
use App\Models\WorkCat;
use App\myappenv;
use Illuminate\Http\Request;

class mainindex extends Controller
{
    public function  Serviceindex()
    {
        if (myappenv::Apptype == 'owner') {
            $WorkCats = WorkCat::all();
            $L1Works = L1Work::all();
            $L2Works = L2Work::all();
            $L3Works = L3Work::all();
            return view('Index.ManageIndex', ['WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works]);
        } else {
            return abort('404');
        }
    }
    public function Addservice()
    {
        $usercreditindexs = usercreditindex::all()->where('IndexType', 1);
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();
        $QeryRespons = "SELECT RespnsType.ID, RespnsType.RespnsTypeName,RespnsType.ImgURL, RespnsType.hPrice, RespnsType.fixPrice, RespnsType.CustomerhPrice, RespnsType.CustomerfixPrice , RespnsType.UserCreditIndex , usercreditindex.IndexName FROM RespnsType LEFT JOIN usercreditindex on RespnsType.UserCreditIndex = usercreditindex.id";
        $Services = DB::select($QeryRespons);
        return view('Index.ManageIndex', ['usercreditindexs' => $usercreditindexs, 'Services' => $Services, 'WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works]);
    }
    public function DoAddservice(Request $request)
    {
        if ($request->input('submit') == 'AddService') {
            if ($request->input('CustomerhPrice') != null) {
                $serviceData = [
                    'RespnsTypeName' => $request->input('RespnsTypeName'),
                    'Description' => $request->input('MainDescription'),
                    'CustomerhPrice' => $request->input('CustomerhPrice'),
                    'hPrice' => $request->input('hPrice'),
                    'Status' => $request->input('Status'),
                    'MainIndex' => $request->input('L3Work'),
                    'UserCreditIndex' => $request->input('UserCreditIndex'),
                    'MainDescription' => $request->input('ce'),
                ];
            } elseif ($request->input('CustomerfixPrice') != null) {
                $serviceData = [
                    'RespnsTypeName' => $request->input('RespnsTypeName'),
                    'Description' => $request->input('MainDescription'),
                    'CustomerfixPrice' => $request->input('CustomerfixPrice'),
                    'fixPrice' => $request->input('fixPrice'),
                    'Status' => $request->input('Status'),
                    'MainIndex' => $request->input('L3Work'),
                    'UserCreditIndex' => $request->input('UserCreditIndex'),
                    'MainDescription' => $request->input('ce'),
                ];
            } else {
                //todo error
            }
            $resultID = RespnsType::create($serviceData);
            return redirect()->back()->with('success', __("success alert"));
        }
    }
    private function EditSelectedService($uid)
    {
        $showindex = 'SelectBox';
        $Query = "SELECT UID, NameFn, NameEn, IRID, IntID, GoodsStatus.Name as GoodsStatusName, MinPrice, MaxPrice, GoodsUnit.Name as GoodsUnitName ,Description, GoodsStatus.Status AS statusid, GoodsUnit.Unit as unitID ,MainDescription,Goods.ImgURL,WarehouseInventory.QTY as QTY, WarehouseInventory.Price as Price FROM Goods LEFT JOIN GoodsUnit on Goods.Unit = GoodsUnit.Unit LEFT JOIN GoodsStatus on GoodsStatus.Status = Goods.Status INNER JOIN WarehouseInventory on WarehouseInventory.GoodsID = Goods.UID INNER JOIN Warehouse on Warehouse.ID = WarehouseInventory.WarehousID INNER JOIN Store on Store.ID = Warehouse.StoreID  WHERE Goods.UID='$GoodsID' ";
        $Goods = DB::select($Query);
        $TreeQuery = "SELECT SuperCat.ID as SuperCatID , SuperCat.Name as SuperCatName , WorkCat.ID as WorkCatID, WorkCat.Name as WorkCatName, L1Work.L1ID as L1WorkL1ID, L1Work.Name as L1WorkName , L2Work.L2ID as L2WorkL2ID , L2Work.Name as L2WorkName , L3Work.UID as L3WorkUID, L3Work.L3ID as L3WorkL3ID, L3Work.Name as L3WorkName FROM SuperCat INNER JOIN WorkCat ON WorkCat.SuperCat = SuperCat.ID INNER JOIN L1Work ON WorkCat.ID = L1Work.WorkCat AND L1Work.SuperCat = WorkCat.SuperCat INNER JOIN L2Work ON L1Work.WorkCat = L2Work.WorkCat AND L1Work.L1ID = L2Work.L1ID AND L2Work.SuperCat = L1Work.SuperCat INNER JOIN L3Work ON L2Work.WorkCat = L3Work.WorkCat AND L2Work.L1ID = L3Work.L1ID AND L2Work.L2ID = L3Work.L2ID AND L3Work.SuperCat = L2Work.SuperCat ORDER BY SuperCat.ID, WorkCat.ID, L1Work.L1ID, L2Work.L2ID, L3Work.L3ID";
        $Treeresult = DB::select($TreeQuery);
        $Query = "SELECT * FROM picrefrence WHERE type = 1";
        $picrefrence = DB::select($Query);
        if ($showindex != 'SelectBox') {
            $listClass = new ListView("myUL", 5);
            foreach ($Treeresult as $Treerow) {
                $LayersIDArr = array(
                    $Treerow->SuperCatID,
                    $Treerow->WorkCatID,
                    $Treerow->L1WorkL1ID,
                    $Treerow->L2WorkL2ID,
                    $Treerow->L3WorkUID
                );
                $LayersNameArr = array(
                    $Treerow->SuperCatName,
                    $Treerow->WorkCatName,
                    $Treerow->L1WorkName,
                    $Treerow->L2WorkName,
                    $Treerow->L3WorkName
                );
                $listClass->AddItem($LayersIDArr, $LayersNameArr);
            }
            $IndexList = $listClass->GetList();
        } else {
            $IndexList = L3Work::all();
        }

        $Query = "SELECT L3Work.UID, L3Work.Name as L3WorkName ,Goods.NameFn from Goodsindex INNER JOIN L3Work on Goodsindex.IndexID = L3Work.UID INNER JOIN Goods on Goodsindex.GoodID = Goods.UID  WHERE Goodsindex.GoodID = '$GoodsID'";
        $GoodIndexes = DB::select($Query);
        $ImagesImages = json_decode($Goods[0]->ImgURL, true);
        $GoodOptions = goods_options_meta::all();
        $Query = "SELECT goods_options_meta.OptionName as OptionName ,goods_option.*  FROM goods_option INNER JOIN Goods on goods_option.GoodID = Goods.UID INNER JOIN goods_options_meta on goods_option.Option = goods_options_meta.id WHERE  Goods.UID = '$GoodsID'";
        $GoodOptionList = DB::select($Query);
        return view('web.Service.EditService', ['Good' => $Goods[0], 'GoodStatusResult' => $this->GoodStatusResult, 'GoodsUnitResults' => $this->GoodsUnitResults, 'IndexList' => $IndexList, 'GoodIndexes' => $GoodIndexes, 'picrefrence' => $picrefrence, "ImagesImages" => $ImagesImages, 'GoodOptions' => $GoodOptions, 'GoodOptionList' => $GoodOptionList, 'showindex' => $showindex]);
    }
    public function Editservice($uid)
    {
        $MyService = new ServiceClass();
        $ServiceResult = $MyService->IsServiceDefine();
        $usercreditindexs = usercreditindex::all()->where('IndexType', 1);
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();
        $RespnsType = RespnsType::all()->where('ID', $uid)->first();
        $ImagesImages = json_decode($RespnsType->ImgURL, true);
        $Query = "SELECT * FROM picrefrence WHERE type = 1";
        $picrefrence = DB::select($Query);
        return view('web.Service.EditService', ['ImagesImages' => $ImagesImages, 'picrefrence' => $picrefrence, 'usercreditindexs' => $usercreditindexs, 'RespnsType' => $RespnsType, 'WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works]);
    }
    public function DoEditservice(Request $request, $uid)
    {

        if ($request->input('submit') == 'EditService') {
            $ProductImage = new Images();
            $picrefrence = $request->input('picrefrence');
            if ($request->input('filepath') != null) {
                $ImgURL = $ProductImage->AddNewImageJson($request->input('OldimagesURL'), $picrefrence, $request->input('filepath'));
            } else {
                $ImgURL = null;
            }
            if ($request->has('L3Work')) {
                $Indexmain = $request->input('L3Work');
            } else {
                $Indexmain = $request->input('MainIndexback');
            }
            if ($request->input('CustomerhPrice') != null && $request->input('CustomerhPrice') != '0') {
                if ($ImgURL != null) {
                    $serviceData = [
                        'RespnsTypeName' => $request->input('RespnsTypeName'),
                        'Description' => $request->input('MainDescription'),
                        'CustomerhPrice' => $request->input('CustomerhPrice'),
                        'hPrice' => $request->input('hPrice'),
                        'Status' => $request->input('Status'),
                        'MainIndex' => $Indexmain,
                        'UserCreditIndex' => $request->input('UserCreditIndex'),
                        'MainDescription' => $request->input('ce'),
                        'ImgURL' => $ImgURL
                    ];
                } else {
                    $serviceData = [
                        'RespnsTypeName' => $request->input('RespnsTypeName'),
                        'Description' => $request->input('MainDescription'),
                        'CustomerhPrice' => $request->input('CustomerhPrice'),
                        'hPrice' => $request->input('hPrice'),
                        'Status' => $request->input('Status'),
                        'MainIndex' => $Indexmain,
                        'UserCreditIndex' => $request->input('UserCreditIndex'),
                        'MainDescription' => $request->input('ce'),
                    ];
                }
            } elseif ($request->input('CustomerfixPrice') != null && $request->input('CustomerfixPrice') != '0') {
                if ($ImgURL != null) {
                    $serviceData = [
                        'RespnsTypeName' => $request->input('RespnsTypeName'),
                        'Description' => $request->input('MainDescription'),
                        'CustomerfixPrice' => $request->input('CustomerfixPrice'),
                        'fixPrice' => $request->input('fixPrice'),
                        'Status' => $request->input('Status'),
                        'MainIndex' => $Indexmain,
                        'UserCreditIndex' => $request->input('UserCreditIndex'),
                        'MainDescription' => $request->input('ce'),
                        'ImgURL' => $ImgURL
                    ];
                } else {
                    $serviceData = [
                        'RespnsTypeName' => $request->input('RespnsTypeName'),
                        'Description' => $request->input('MainDescription'),
                        'CustomerfixPrice' => $request->input('CustomerfixPrice'),
                        'fixPrice' => $request->input('fixPrice'),
                        'Status' => $request->input('Status'),
                        'MainIndex' => $Indexmain,
                        'UserCreditIndex' => $request->input('UserCreditIndex'),
                        'MainDescription' => $request->input('ce'),

                    ];
                }
            } else {
                //todo error
            }

            $resultID = RespnsType::where('ID', $uid)->update($serviceData);
            return redirect()->back()->with('success', __("success alert"));
        }
    }
    public function ServiceView($uid = null)
    {
        $MyService = new ServiceClass();
        $ServiceResult = $MyService->IsServiceDefine();
        $WorkCats = WorkCat::all();
        $L1Works = L1Work::all();
        $L2Works = L2Work::all();
        $L3Works = L3Work::all();
        $QeryRespons = "SELECT RespnsType.ID, RespnsType.RespnsTypeName,RespnsType.ImgURL, RespnsType.hPrice, RespnsType.fixPrice, RespnsType.CustomerhPrice, RespnsType.CustomerfixPrice , RespnsType.UserCreditIndex , usercreditindex.IndexName , L3Work.Name as Minindexname FROM RespnsType INNER JOIN L3Work on L3Work.UID = RespnsType.MainIndex  LEFT JOIN usercreditindex on RespnsType.UserCreditIndex = usercreditindex.id ";
        $Services = DB::select($QeryRespons);

        return view('web.Service.MainService', ['Services' => $Services, 'WorkCats' => $WorkCats, 'L1Works' => $L1Works, 'L2Works' => $L2Works, 'L3Works' => $L3Works]);
    }
    public function DoServiceindex(Request $request)
    {
        if ($request->has('submit') && $request->input('submit') == 'workcat_edit') {
            $OldSource =  WorkCat::where('ID', $request->input('OldID'))->first();

            $Data = [
                'ID' => $request->input('ID'),
                'Name' => $request->input('Name'),
                'img' => $request->input('img')??''
            ];
            WorkCat::where('ID', $request->input('OldID'))->update($Data);
            if ($OldSource->ID != $request->input('ID')) {
                L1Work::where('WorkCat', $OldSource->ID)->update(['WorkCat' => $request->input('ID')]);
                L2Work::where('WorkCat', $OldSource->ID)->update(['WorkCat' => $request->input('ID')]);
                L3Work::where('WorkCat', $OldSource->ID)->update(['WorkCat' => $request->input('ID')]);
            }
            return redirect()->back()->with('success', 'شاخص اصلی به روز رسانی شد!');
        }
        if ($request->has('submit') && $request->input('submit') == 'L1_edit') {
            $OldSource = L1Work::where('WorkCat', $request->input('OldWorkCat'))->where('L1ID', $request->input('OldL1ID'))->first();
            $Data = [
                'WorkCat' => $request->input('WorkCat'),
                'L1ID' => $request->input('L1ID'),
                'Name' => $request->input('Name'),
                'img' => $request->input('img')??''
            ];
            L1Work::where('WorkCat', $request->input('OldWorkCat'))->where('L1ID', $request->input('OldL1ID'))->update($Data);
            if ($OldSource->WorkCat != $request->input('WorkCat') || $OldSource->L1ID != $request->input('L1ID')) {
                L2Work::where('WorkCat', $OldSource->WorkCat)->where('L1ID', $OldSource->L1ID)->update(['WorkCat' => $request->input('WorkCat'), 'L1ID' => $request->input('L1ID')]);
                L3Work::where('WorkCat', $OldSource->WorkCat)->where('L1ID', $OldSource->L1ID)->update(['WorkCat' => $request->input('WorkCat'), 'L1ID' => $request->input('L1ID')]);
            }
            return redirect()->back()->with('success', 'شاخص لایه اول به روز رسانی شد!');
        }
        if ($request->has('submit') && $request->input('submit') == 'L2_edit') {
            $OldSource = L2Work::where('WorkCat', $request->input('OldWorkCat'))->where('L1ID', $request->input('OldL1ID'))->where('L2ID', $request->input('OldL2ID'))->first();
            $Data = [
                'WorkCat' => $request->input('WorkCat'),
                'L1ID' => $request->input('L1ID'),
                'L2ID' => $request->input('L2ID'),
                'Name' => $request->input('Name'),
                'img' => $request->input('img')??''
            ];
            L2Work::where('WorkCat', $request->input('OldWorkCat'))->where('L1ID', $request->input('OldL1ID'))->where('L2ID', $request->input('OldL2ID'))->update($Data);
            if ($OldSource->WorkCat != $request->input('WorkCat') || $OldSource->L1ID != $request->input('L1ID')|| $OldSource->L2ID != $request->input('L2ID')) {
                L3Work::where('WorkCat', $OldSource->WorkCat)->where('L1ID', $OldSource->L1ID)->where('L2ID', $OldSource->L2ID)->update(['WorkCat' => $request->input('WorkCat'), 'L1ID' => $request->input('L1ID'), 'L2ID' => $request->input('L2ID')]);
            }
            return redirect()->back()->with('success', 'شاخص لایه دوم به روز رسانی شد!');
        }
        if ($request->has('submit') && $request->input('submit') == 'L3_edit') {
            $Data = [
                'WorkCat' => $request->input('WorkCat'),
                'L1ID' => $request->input('L1ID'),
                'L2ID' => $request->input('L2ID'),
                'L3ID' => $request->input('L3ID'),
                'Name' => $request->input('Name'),
                'img' => $request->input('img')??''
            ];
            L3Work::where('UID', $request->input('UID'))->update($Data);
            return redirect()->back()->with('success', 'شاخص لایه سوم به روز رسانی شد!');
        }

        if ($request->input('WorkCatAdd') != '' || $request->input('WorkCatAdd') != null) {
            $WorkCatData = [
                'Name' => $request->input('WorkCatAdd'),
                'img' => ''
            ];
            WorkCat::create($WorkCatData);
            return redirect()->back()->with('success', __("success alert"));
        } elseif ($request->input('L1Add') != '' || $request->input('L1Add') != null) {
            $LastID = L1Work::where('WorkCat', $request->input('WorkCat'))->max('L1ID');
            if ($LastID == null) {
                $LastID = 1;
            } else {
                $LastID++;
            }
            $L1WorkData = [
                'WorkCat' => $request->input('WorkCat'),
                'L1ID' => $LastID,
                'Name' => $request->input('L1Add'),
                'img' => ''
            ];
            L1Work::create($L1WorkData);
            return redirect()->back()->with('success', __("success alert"));
        } elseif ($request->input('L2Add') != '' || $request->input('L2Add') != null) {
            $LastID = L2Work::where('WorkCat', $request->input('WorkCat'))->where('L1ID', $request->input('L1Work'))->max('L2ID');
            if ($LastID == null) {
                $LastID = 1;
            } else {
                $LastID++;
            }
            $L2WorkData = [
                'WorkCat' => $request->input('WorkCat'),
                'L1ID' => $request->input('L1Work'),
                'L2ID' => $LastID,
                'Name' => $request->input('L2Add'),
                'img' => ''
            ];
            L2Work::create($L2WorkData);
            return redirect()->back()->with('success', __("success alert"));
        } elseif ($request->input('L3Add') != '' || $request->input('L3Add') != null) {
            $LastID = L3Work::where('WorkCat', $request->input('WorkCat'))->where('L1ID', $request->input('L1Work'))->where('L2ID', $request->input('L2Work'))->max('L3ID');
            if ($LastID == null) {
                $LastID = 1;
            } else {
                $LastID++;
            }
            $L3WorkData = [
                'WorkCat' => $request->input('WorkCat'),
                'L1ID' => $request->input('L1Work'),
                'L2ID' => $request->input('L2Work'),
                'L3ID' => $LastID,
                'Name' => $request->input('L3Add'),
                'Description' => '',
                'img' => $request->input('pic')
            ];
            L3Work::create($L3WorkData);
            return redirect()->back()->with('success', __("success alert"));
        }
    }
}
