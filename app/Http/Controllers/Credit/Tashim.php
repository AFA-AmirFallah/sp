<?php

namespace App\Http\Controllers\Credit;

use App\Functions\CacheData;
use App\Functions\Orders;
use App\Functions\TashimClass;
use App\Functions\TashimVars;
use App\Http\Controllers\Controller;
use App\Models\tashim as ModelsTashim;
use App\Models\UserCreditIndex;
use App\Models\UserCreditModMeta;
use App\Models\UserInfo;
use App\Models\warehouse_goods;
use App\myappenv;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use stdClass;

class Tashim extends Controller
{
    //$Persian->jgetdate(),$Persian->jalali_to_gregorian(1401,8,1)
    private $Walet = [];
    private $buyer;
    private $Seller;
    private $owner;
    private $Insurance = myappenv::InsuranceHolder;
    private $Daramad = myappenv::StackHolder;
    private $Marketer;
    private $Taxer = myappenv::TaxHolder;

    public function set_holders($buyer, $Seller, $owner, $Daramad, $Marketer)
    {
        $this->buyer = $buyer;
        $this->Seller = $Seller;
        $this->owner = $owner;
        $this->Daramad = $Daramad;
        $this->Marketer = $Marketer;
        return true;
    }

    public function CustomerTashimInfo($TargetProduct, $TargetTashim, $PwID = 0)
    {
        if ($PwID == 0) { // find providrt price
            $TargetSrc = warehouse_goods::where('GoodID', $TargetProduct)->where('Remian', '>', 0)->first();
            $Price = $TargetSrc->Price;
        } else {
            $TargetSrc = warehouse_goods::where('id', $PwID)->where('Remian', '>', 0)->first();
            $Price = $TargetSrc->Price;
        }
        $ProductAttr = [
            'ProductId' => $TargetProduct,
            'PwID' => $PwID,
            'TashimID' => $TargetTashim,
        ];
        $MonyAttr = [
            'SaleMony' => $Price,
            'BuyMony' => 0,
            'DeleverMony' => 0,
        ];
        $this->buyer = '';
        $this->Seller = '';
        $result = $this->ExecTashim($ProductAttr, $MonyAttr);
        return $result;
    }
    public function WaletSummery($Walet, $User)
    {
        if ($Walet == null) {
            return null;
        }
        $WaletArr = array();
        foreach ($Walet as $WaletItem) {
            $creditMod = $WaletItem['CreditMod'];
            $HasBefore = false;
            if ($WaletItem['TargetUser'] == $User) {
                foreach ($WaletArr as $key => $value) {
                    if ($WaletArr[$key]['CreditMod'] == $creditMod) {
                        $WaletArr[$key]['amount'] = $WaletArr[$key]['amount'] + $WaletItem['Amount'];
                        $HasBefore = true;
                    }
                }
                if (!$HasBefore) {
                    $ModSource = UserCreditModMeta::where('ID', $creditMod)->first();
                    $newItem = [
                        'amount' => $WaletItem['Amount'],
                        'CreditMod' => $creditMod,
                        'CreditModName' => $ModSource->ModName,
                    ];
                    array_push($WaletArr, $newItem);
                }
            }
        }
        return $WaletArr;
    }

    public function AddWallet(
        $ProductAttr,
        $TashimTarget
    ) {

        $TargetWarehouse = $ProductAttr['TargetWarehouse'];
        $SaleMony = $ProductAttr['SaleMony'];
        $BuyMony = $ProductAttr['BuyMony'];
        $ProductId = $ProductAttr['ProductId'];
        $PwID = $ProductAttr['PwID'];
        $TaxMony = $ProductAttr['TaxMony'];

        if (Session::has('Walets')) {
            $WaletSession = Session::get('Walets');
        } else {
            $WaletSession = array();
        }

        if ($TashimTarget == null) {
            $hasTashim = false;
        } else {
            $hasTashim = true;
        }
        $Query = "SELECT s.Owner FROM warehouses as w INNER JOIN stores as s ON w.StoreID = s.id WHERE w.id = $TargetWarehouse ";
        $Result = DB::select($Query);
        foreach ($Result as $ResultItem) {
            $Seller = $ResultItem->Owner;
        }
        $ProductSrc = warehouse_goods::where('id', $PwID)->first();
        if ($ProductSrc->owner == null) {
            $Owner = $Seller;
        } else {
            $Owner = $ProductSrc->owner;
        }
        $DeleverMony = Orders::getshiping();
        if (Session::has('customerID')) {
            $buyer = Session::get('customerID');
        } else {
            $buyer = Auth::id();
        }

        $Daramad = myappenv::StackHolder;
        $Marketer = 'marketer';
        if ($hasTashim) {
            $ProductAttr = [
                'ProductId' => $ProductId,
                'PwID' => $PwID,
                'TashimID' => $TashimTarget,
            ];
            $MonyAttr = [
                'SaleMony' => $SaleMony,
                'BuyMony' => $BuyMony,
                'DeleverMony' => $DeleverMony,
                'TaxMony' => $TaxMony,
            ];
            if (Session::has('customerID')) {
                $this->buyer = Session::get('customerID');
            } else {
                $this->buyer = Auth::id();
            }

            $this->Seller = $Seller;
            $this->owner = $Owner;
            $this->Marketer = '';
            $Result = $this->ExecTashim($ProductAttr, $MonyAttr);
            foreach ($Result as $ResultItem) {
                array_push($WaletSession, $ResultItem);
            }
        } else { // فروش نقدی
            $Result = $this->ExecNaghd($ProductId, $PwID, $SaleMony, $BuyMony, $DeleverMony, $buyer, $Seller, $Daramad, $Marketer);

            foreach ($Result as $ResultItem) {
                array_push($WaletSession, $ResultItem);
            }
        }
        Session::put('Walets', $WaletSession);
    }

    public function TashimPreResult($Tashims, $SaleProducts)
    {
        if ($SaleProducts == null) {
            return null;
        }

        $Walet = array();
        if (!auth::check()) {
            return null;
        }

        foreach ($SaleProducts as $SaleItem) {
            $SaleItemQty = $SaleItem['ProductQty'];
            $ProductInWarehouse = $SaleItem['ProductInWarehouse'];
            $ProductSrc = $SaleItem['Product'];
            $TaxStaus = $ProductSrc->tax_status;
            if ($TaxStaus == 10) { //if product has tax
                $TaxPercent = myappenv::TaxPercent;
                $TaxMony = $ProductInWarehouse->Price * $TaxPercent / 100;
            } else {
                $TaxMony = 0;
            }
            $SaleItemPrice = $ProductInWarehouse->Price;
            $BuyMonyItem = $ProductInWarehouse->BuyPrice;
            $ProductId = $ProductInWarehouse->GoodID;
            $PwID = $ProductInWarehouse->id;
            $hasTashim = false;
            if ($Tashims != []) {
                foreach ($Tashims as $TashimItem) {
                    $TashimProductID = $TashimItem->ProductId;
                    $TashimTarget = $TashimItem->Tashim;
                    if ($TashimProductID == $ProductId) {
                        $hasTashim = true;
                        break;
                    }
                }
            } else {
                $hasTashim = false;
            }

            $TargetWarehouse = $ProductInWarehouse->WarehouseID;
            $Query = "SELECT s.Owner FROM warehouses as w INNER JOIN stores as s ON w.StoreID = s.id WHERE w.id = $TargetWarehouse ";
            $Result = DB::select($Query);
            foreach ($Result as $ResultItem) {
                $Seller = $ResultItem->Owner;
            }
            $SaleMony = $SaleItemPrice * $SaleItemQty;
            $TaxMony = $TaxMony * $SaleItemQty;
            $BuyMony = $BuyMonyItem * $SaleItemQty;

            $DeleverMony = 0;

            if (Session::has('customerID')) {
                $buyer = Session::get('customerID');
            } else {
                $buyer = Auth::id();
            }
            $Daramad = myappenv::StackHolder;
            $Marketer = 'marketer';
            if ($hasTashim) {
                $ProductAttr = [
                    'ProductId' => $ProductId,
                    'PwID' => $PwID,
                    'TashimID' => $TashimTarget,
                ];
                $MonyAttr = [
                    'SaleMony' => $SaleMony,
                    'BuyMony' => $BuyMony,
                    'DeleverMony' => $DeleverMony,
                    'TaxMony' => $TaxMony,
                ];
                if (Session::has('customerID')) {
                    $this->buyer = Session::get('customerID');
                } else {
                    $this->buyer = Auth::id();
                }
                $this->Seller = $Seller;
                $this->Marketer = '';
                $Result = $this->ExecTashim($ProductAttr, $MonyAttr);
                foreach ($Result as $ResultItem) {
                    array_push($Walet, $ResultItem);
                }
            } else { // فروش نقدی
                $Result = $this->ExecNaghd($ProductId, $PwID, $SaleMony, $BuyMony, $DeleverMony, $buyer, $Seller, $Daramad, $Marketer);
                foreach ($Result as $ResultItem) {
                    array_push($Walet, $ResultItem);
                }
            }
        }
        return $Walet;
    }
    public function ExecNaghd($ProductId, $PwID, $SaleMony = 0, $BuyMony = 0, $DeleverMony = 0, $buyer, $Seller, $Daramad, $Marketer)
    {
        $Walet = array();
        $ArrItem = [
            'TashimID' => 0,
            'ProductId' => $ProductId,
            'PwID' => $PwID,
            'MainName' => '',
            'TargetUser' => 'buyer',
            'TargteUserID' => $buyer,
            'Amount' => -1 * ($SaleMony + $DeleverMony),
            'Note' => '',
            'extra' => '',
            'CreditIndex' => '',
            'Operation' => '',
            'NoteBefore' => '',
            'NoteAfter' => '',
            'CreditMod' => myappenv::CachCredit,
        ];
        array_push($Walet, $ArrItem);
        $ArrItem = [
            'TashimID' => 0,
            'ProductId' => $ProductId,
            'PwID' => $PwID,
            'MainName' => '',
            'TargetUser' => 'Seller',
            'TargteUserID' => $Seller,
            'Amount' => $BuyMony,
            'Note' => '',
            'extra' => '',
            'CreditIndex' => '',
            'Operation' => '',
            'NoteBefore' => '',
            'NoteAfter' => '',
            'CreditMod' => myappenv::UnaccessCredit,
        ];
        array_push($Walet, $ArrItem);
        $ArrItem = [
            'TashimID' => 0,
            'ProductId' => $ProductId,
            'PwID' => $PwID,
            'MainName' => '',
            'TargetUser' => 'daramad',
            'TargteUserID' => $Daramad,
            'Amount' => ($SaleMony - $BuyMony) / 2,
            'Note' => '',
            'extra' => '',
            'CreditIndex' => '',
            'Operation' => '',
            'NoteBefore' => '',
            'NoteAfter' => '',
            'CreditMod' => myappenv::CachCredit,
        ];
        array_push($Walet, $ArrItem);
        $ArrItem = [
            'TashimID' => 0,
            'ProductId' => $ProductId,
            'PwID' => $PwID,
            'MainName' => '',
            'TargetUser' => 'Seller',
            'TargteUserID' => $Seller,
            'Amount' => ($SaleMony - $BuyMony) / 2,
            'Note' => '',
            'extra' => '',
            'CreditIndex' => '',
            'Operation' => '',
            'NoteBefore' => '',
            'NoteAfter' => '',
            'CreditMod' => myappenv::UnaccessCredit,
        ];
        array_push($Walet, $ArrItem);
        return $Walet;
    }
    private function get_marketing_layer_2($username){
        $user_src = UserInfo::where('UserName',$username)->first();
        if($user_src == null){
            return myappenv::StackHolder;
        }
        $first_marketer = $user_src->Marketer;
        if($first_marketer == null){
            return myappenv::StackHolder;
        }
        $user_src = UserInfo::where('UserName',$first_marketer)->first();
        if($user_src == null){
            return myappenv::StackHolder;
        }
        $second_marketer = $user_src->Marketer;
        if($second_marketer == null){
            return myappenv::StackHolder;
        }
        return $second_marketer;

    }
    private function get_marketing_layer_3($username){
        $user_src = UserInfo::where('UserName',$username)->first();
        if($user_src == null){
            return myappenv::StackHolder;
        }
        $first_marketer = $user_src->Marketer;
        if($first_marketer == null){
            return myappenv::StackHolder;
        }
        $user_src = UserInfo::where('UserName',$first_marketer)->first();
        if($user_src == null){
            return myappenv::StackHolder;
        }
        $second_marketer = $user_src->Marketer;
        if($second_marketer == null){
            return myappenv::StackHolder;
        }
        $user_src = UserInfo::where('UserName',$second_marketer)->first();
        if($user_src == null){
            return myappenv::StackHolder;
        }
        $three_marketer = $user_src->Marketer;
        if($three_marketer == null){
            return myappenv::StackHolder;
        }
        return $three_marketer;
    }
    public function ExecTashim($ProductAttr, $MonyAttr)
    {
        $MyTashim = new TashimClass();
        $TashimVars = new TashimVars();
        $ProductId = $ProductAttr['ProductId'];
        $PwID = $ProductAttr['PwID'];
        $TashimID = $ProductAttr['TashimID'];
        if (isset($MonyAttr['SaleMony'])) {
            $TashimVars->SalePrice = $MonyAttr['SaleMony'];
        }
        if (isset($MonyAttr['BuyMony'])) {
            $TashimVars->BuyPrice = $MonyAttr['BuyMony'];
        }
        if (isset($MonyAttr['DeleverMony'])) {
            $TashimVars->shippingPrice = $MonyAttr['DeleverMony'];
        }
        if (isset($MonyAttr['TaxMony'])) {
            $TashimVars->TaxPrice = $MonyAttr['TaxMony'];
        }
        $TashimSorce = ModelsTashim::where('ItemOrder', '>', 0)->where('TashimID', $TashimID)->orderBy('ItemOrder', 'ASC')->get();
        $OutPutArr = array();
        foreach ($TashimSorce as $TashimSorceIetem) {
            if ($TashimSorceIetem->id != $TashimSorceIetem->TashimID) {
                $result = $MyTashim->FormulaCalc($TashimSorceIetem->FormolStr, $TashimVars);
                switch ($TashimSorceIetem->TargetUser) {
                    case 'buyer':
                        $TargteUserID = $this->buyer;
                        break;
                    case 'Seller':
                        $TargteUserID = $this->Seller;
                        break;
                    case 'Daramad':
                        $TargteUserID = $this->Daramad;
                        break;
                    case 'Marketer':
                        $TargteUserID = $this->Marketer;
                        break;
                    case 'm2':
                        $TargteUserID = $this->get_marketing_layer_2($this->buyer);
                        break;
                    case 'm3':
                        $TargteUserID = $this->get_marketing_layer_3($this->buyer);
                        break;
                    case 'Taxer':
                        $TargteUserID = $this->Taxer;
                        break;
                    case 'owner':
                        $TargteUserID = $this->owner;
                        break;
                    case 'insurance':
                        $TargteUserID = $this->Insurance;
                        break;
                    default:
                        $TargteUserID = $TashimSorceIetem->TargetUser;
                }
                $ArrItem = [
                    'TashimID' => $TashimID,
                    'ProductId' => $ProductId,
                    'PwID' => $PwID,
                    'MainName' => $TashimSorceIetem->Name,
                    'TargetUser' => $TashimSorceIetem->TargetUser,
                    'TargteUserID' => $TargteUserID,
                    'Amount' => $result,
                    'Note' => $TashimSorceIetem->Note,
                    'extra' => $TashimSorceIetem->extra,
                    'CreditIndex' => $TashimSorceIetem->CreditIndex,
                    'Operation' => $TashimSorceIetem->Operation,
                    'NoteBefore' => $TashimSorceIetem->NoteBefore,
                    'NoteAfter' => $TashimSorceIetem->NoteAfter,
                    'CreditMod' => $TashimSorceIetem->CreditMod,
                ];
                array_push($OutPutArr, $ArrItem);
            }
        }
        return $OutPutArr;
    }
    public function DoTashim($TashimID, $MonyAttr)
    {
        $MyTashim = new TashimClass();
        $TashimVars = new TashimVars();
        if (isset($MonyAttr['SaleMony'])) {
            $TashimVars->SalePrice = $MonyAttr['SaleMony'];
        }
        if (isset($MonyAttr['BuyMony'])) {
            $TashimVars->BuyPrice = $MonyAttr['BuyMony'];
        }
        if (isset($MonyAttr['DeleverMony'])) {
            $TashimVars->shippingPrice = $MonyAttr['DeleverMony'];
        }
        if (isset($MonyAttr['TaxMony'])) {
            $TashimVars->TaxPrice = $MonyAttr['TaxMony'];
        }
        if (isset($MonyAttr['Tavan'])) {
            $TashimVars->TavanPrice = $MonyAttr['Tavan'];
        }

        $TashimSorce = ModelsTashim::where('ItemOrder', '>', 0)->where('TashimID', $TashimID)->get();
        $OutPutArr = array();
        foreach ($TashimSorce as $TashimSorceIetem) {
            $result = $MyTashim->FormulaCalc($TashimSorceIetem->FormolStr, $TashimVars);
            $ArrItem = [
                'TargetUser' => $TashimSorceIetem->TargetUser,
                'Amount' => $result,
                'CreditMod' => $TashimSorceIetem->CreditMod,
            ];
            array_push($OutPutArr, $ArrItem);
        }
        return $OutPutArr;
    }
    public function format_Extra_view($JasonInput)
    {
        if ($JasonInput != null || $JasonInput != '') {
            $OutPut = '';
            $Extra = json_decode($JasonInput);
            $initloop = true;
            foreach ($Extra as $index => $value) {
                if ($initloop) {
                    $OutPut .= "$index = $value";
                } else {
                    $OutPut .= "\n" . "$index = $value";
                }
                $initloop = false;
            }
            return $OutPut;
        } else {
            return '';
        }
    }
    public function EditTashim($TashimId)
    {
        $Tashim = ModelsTashim::where('TashimID', $TashimId)->OrderBy('ItemOrder')->get();
        $CreditIndex = UserCreditIndex::all();
        $creditMod = UserCreditModMeta::all();
        return view('Credit.EditTashim', ['function' => $this, 'Tashim' => $Tashim, 'CreditIndex' => $CreditIndex, 'creditMod' => $creditMod]);
    }
    private function get_text_lines($InputText)
    {

        return preg_split("/((\r?\n)|(\r\n?))/", $InputText);
    }
    private function format_extra($ItemScript, $OutType = 'array')
    {
        /**
         * convert extra items formula and attrebute to array
         *
         * output array
         */
        if ($ItemScript == '' || $ItemScript == null) {
            return null;
        }
        $ItemScriptArr = $this->get_text_lines($ItemScript);
        $OutPutArr = new stdClass;
        foreach ($ItemScriptArr as $MianInpuItem) {
            $ItemInputArr = explode('=', $MianInpuItem);
            if (isset($ItemInputArr[0]) && isset($ItemInputArr[1])) {
                $ItemScript = trim(preg_replace('/\s\s+/', '', $ItemScript));
                $Name = trim($ItemInputArr[0]);
                $Val = trim($ItemInputArr[1]);
                $OutPutArr->$Name = $Val;
            }
        }
        if ($OutType == 'array') {
            return $OutPutArr;
        } else {
            return json_encode($OutPutArr);
        }
    }
    public function DoEditTashim(Request $request, $TashimId)
    {
        $ItemScript = $request->input('ItemScript');
        $Extra = $this->format_extra($ItemScript, 'json');
        if ($request->input('submit') == 'save') {
            $DataTosave = [
                'Name' => $request->input('MainTashimName'),
                'TashimID' => $TashimId,
                'ItemOrder' => $request->input('ItemOrder'),
                'TargetUser' => $request->input('TargetUser'),
                'FormolStr' => $request->input('FormolStr'),
                'Operation' => '',
                'CreditMod' => $request->input('creditMod'),
                'Note' => $request->input('Note'),
                'extra' => $Extra,
            ];
            ModelsTashim::create($DataTosave);
            return redirect()->back()->with('success', 'روال مالی اضافه شد!');
        }
        if ($request->input('submit') == 'edit') {
            $DataTosave = [
                'TashimID' => $TashimId,
                'ItemOrder' => $request->input('ItemOrder'),
                'TargetUser' => $request->input('TargetUser'),
                'FormolStr' => $request->input('FormolStr'),
                'Operation' => '',
                'CreditMod' => $request->input('creditMod'),
                'Note' => $request->input('Note'),
                'extra' => $Extra,
            ];
            ModelsTashim::where('id', $request->input('EditId'))->update($DataTosave);
            return redirect()->back()->with('success', 'به روز رسانی فرمول تسهیم انجام گردید!');
        }
        if ($request->input('submit') == 'delete') {
            ModelsTashim::where('id', $request->input('EditId'))->delete();
            return redirect()->back()->with('success', 'حذف فرمول تسهیم انجام گردید!');
        }
        if ($request->input('submit') == 'updatemain') {
            $DataTosave = [
                'Name' => $request->input('Name'),
                'Note' => $request->input('Note'),
            ];
            ModelsTashim::where('id', $request->input('id'))->update($DataTosave);
            $DataTosave = [
                'Name' => $request->input('Name'),
            ];
            ModelsTashim::where('TashimID', $request->input('id'))->update($DataTosave);

            return redirect()->back()->with('success', 'به روز رسانی  تسهیم انجام گردید!');
        }
        if ($request->input('submit') == 'setDefault') {
            $DataTosave = [
                'Name' => $request->input('Name'),
                'Note' => $request->input('Note'),
            ];

            ModelsTashim::where('extra', 'defualt')->update(['extra' => '']);
            ModelsTashim::where('id', $request->input('id'))->update(['extra' => 'defualt']);
            CacheData::PutSetting('DefultTashim', $request->input('id'));
            return redirect()->back()->with('success', 'تسهیم مورد نظر به پیشفرض تغییر پیدا کرد!');
        }
    }
    public function TashimMgt()
    {
        $Tashims = ModelsTashim::where('ItemOrder', 0)->get();
        return view('Credit.TashimMgt', ['Tashims' => $Tashims]);
    }
    public function DoTashimMgt(Request $request)
    {
        $TashimId = $request->input('TashimID');
        if ($request->input('submit') == 'DisableItem') {

            ModelsTashim::where('TashimID', $TashimId)->limit(1)->update(['Operation' => 0]);
            return redirect()->back()->with('success', __("success alert"));
        }
        if ($request->input('submit') == 'EnableItem') {
            ModelsTashim::where('TashimID', $TashimId)->limit(1)->update(['Operation' => 1]);
            return redirect()->back()->with('success', __("success alert"));
        }
    }
    public function AddTashim()
    {
        return view('Credit.AddTashim');
    }
    public function DoAddTashim(Request $request)
    {
        if ($request->input('submit') == 'save') {
            $OldData = ModelsTashim::where('Name', $request->input('Name'))->first();
            if ($OldData == null) {
                $TargetData = [
                    'Name' => $request->input('Name'),
                    'TashimID' => 0,
                    'ItemOrder' => 0,
                    'TargetUser' => '',
                    'FormolStr' => '',
                    'Operation' => 1,
                    'CreditMod' => 0,
                    'Note' => $request->input('Note'),

                ];
                $Resutl = ModelsTashim::create($TargetData);
                ModelsTashim::where('Name', $request->input('Name'))->update(['TashimID' => $Resutl->id]);
                return redirect()->route('TashimMgt')->with('success', 'تسهیم ' . $request->input('Name') . ' به سیستم اضافه شد! ');
            } else {
                return redirect()->back()->with('error', 'نام تسهیم وارد شده در سیستم وجود دارد!');
            }
        }
    }
}
