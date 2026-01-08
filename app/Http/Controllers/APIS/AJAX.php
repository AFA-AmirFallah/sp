<?php

namespace App\Http\Controllers\APIS;

use App\APIS\SmsCenter;
use App\APIS\Tapin;
use App\Functions\ConsultClass;
use App\Functions\DeleverClass;
use App\Functions\Images;
use App\Functions\MoshaverehClass;
use App\Functions\NewsClass;
use App\Functions\persian;
use App\Functions\TashimClass;
use App\Functions\TashimVars;
use App\Functions\TavanPardakhtClass;
use App\Functions\TextClassMain;
use App\Users\UserClass;
use App\Http\Controllers\Controller;
use App\Http\Controllers\crawler\CrawlerMain;
use App\Http\Controllers\Credit\Reports;
use App\Http\Controllers\Patients\Workflow;
use App\Http\Controllers\woocommerce\buy;
use App\Http\Controllers\woocommerce\product;
use App\Models\addorder1;
use App\Models\alertme;
use App\Models\BankAccount;
use App\Models\catorder;
use App\Models\citys;
use App\Models\crypto_price_24hs;
use App\Models\forms_meta;
use App\Models\goods;
use App\Models\L3Work;
use App\Models\locations;
use App\Models\notification;
use App\Models\orderstatus;
use App\Models\posts;
use App\Models\provinces;
use App\Models\RespnsType;
use App\Models\setting;
use App\Models\SMS;
use App\Models\tashim;
use App\Models\tavanpardakht_temp;
use App\Models\UserCreditModMeta;
use App\Models\UserInfo;
use App\Models\warehouse_goods;
use App\myappenv;
use App\Patient\PatientClass;
use App\Shop\ProductAlert;
use App\Shop\ProductMark;
use Throwable;
use CreateTavanpardakhtTemp;
use Illuminate\Support\Facades\DB;
use Dotenv\Util\Str;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AJAX extends Controller
{
    public function CheckUsersMobile($request)
    {
        $user_branch = Auth::user()->branch;
        $Query = "SELECT MobileNo , Name , Family ,UserName FROM UserInfo  WHERE branch = $user_branch and  MobileNo like '" . $request->input('MobileNo') . "%'  ";
        $result = DB::select($Query);
        $OutPut = '';
        if (!empty($result)) {
            $FirstLoop = true;
            foreach ($result as $row) {
                if ($FirstLoop) {
                    $OutPut .= '<label>' . $row->Name . " " . $row->Family . '</label> <input class="form-group" type="radio" checked name="TargetUser" value="' . $row->UserName . '" onchange="newuserchange()">';
                    $FirstLoop = false;
                } else {
                    $OutPut .= '<label>' . $row->Name . " " . $row->Family . '</label> <input class="form-group" type="radio" name="TargetUser" value="' . $row->UserName . '" onchange="newuserchange()">';
                }
            }
            $OutPut .= '<label>کاربر جدید با همین شماره</label> <input class="form-group" id="useradd_radio" type="radio" name="TargetUser" value="-1" onchange="newuserchange()" >';
        } else {
            $OutPut = "nok";
        }

        return $OutPut;
    }
    public function WorkerSearch_advance($request)
    {
        $SelectService = $request->SelectService;
        $targetbranch = Auth::user()->branch;
        $serviceSrc = RespnsType::where('id', $SelectService)->where('branch', $targetbranch)->first();
        if ($serviceSrc == null) {
            return 'خدمت درخواستی وجود ندارد!';
        }
        $worker_index = $serviceSrc->worker_index;
        if ($worker_index == null || $worker_index == '') {
            return 'nok';
        }
        $InputString = $request->input('InputString');
        $Role = myappenv::role_worker;
        //$Query = "SELECT UserName , Name , Family FROM UserInfo  WHERE UserInfo.Role = 1 and ( CONCAT(UserInfo.Name, UserInfo.Family) like '%$InputString%' or UserInfo.UserName like '%$InputString%') ";
        if ($InputString == null || $InputString = '') {
            $username_condition = '';
        } else {
            $username_condition = "( CONCAT(user_with_skills_view.Name, user_with_skills_view.Family) like '%$InputString%' or user_with_skills_view.UserName like '%$InputString%') and";
        }
        $worker_role = myappenv::role_worker;
        $Query = "SELECT * FROM user_with_skills_view  WHERE $username_condition branch = $targetbranch and Role = $worker_role and  SkilID = $worker_index";
        $result = DB::select($Query);
        $OutPut = '';
        if (!empty($result)) {
            if ($request->axios) {
                return $result;
            }
            foreach ($result as $row) {
                $UserName = $row->UserName;
                $NameFamily = $row->Name . " " . $row->Family;
                $MobileNo = $row->MobileNo;
                $OutPut .= "<tr>";
                $OutPut .= "<td>$NameFamily</td>";
                $OutPut .= "<td>$MobileNo</td>";
                $OutPut .= "<td>نیروی عملیاتی</td>";
                $OutPut .= '<td><button  class="btn btn-success" type="button"' . 'onclick="fff(' . "'" . $UserName . "'" . ',' . "'" . $NameFamily . "'" . ')" > انتخاب </td>';
                $OutPut .= "</tr>";
            }
        } else {
            $OutPut = "nok";
        }
        return $OutPut;
    }
    public function WorkerSearch($request)
    {
        $InputString = $request->input('InputString');
        $Role = myappenv::role_worker;
        $targetbranch = Auth::user()->branch;
        //$Query = "SELECT UserName , Name , Family FROM UserInfo  WHERE UserInfo.Role = 1 and ( CONCAT(UserInfo.Name, UserInfo.Family) like '%$InputString%' or UserInfo.UserName like '%$InputString%') ";
        $Query = "SELECT UserInfo.* , UserRole.RoleName  FROM UserInfo inner join UserRole on UserInfo.Role = UserRole.Role   WHERE   ( CONCAT(UserInfo.Name, UserInfo.Family) like '%$InputString%' or UserInfo.Phone1 like '%$InputString%' or UserInfo.Phone2 = '$InputString' or UserInfo.MobileNo = '$InputString' or UserInfo.MobileNo = '$InputString')  and UserInfo.branch = $targetbranch";
        $result = DB::select($Query);
        $OutPut = 'جستجو نتیجه ای در پی نداشت!';
        $counter = 0;
        if (!empty($result)) {
            if ($request->axios) {
                return $result;
            }
            foreach ($result as $row) {
                if ($counter == 0) {
                    $OutPut = '';
                }
                $UserName = $row->UserName;
                $NameFamily = $row->Name . " " . $row->Family;
                $mobile_no = $row->MobileNo;
                $role = $row->RoleName;
                $OutPut .= "<tr>";
                $OutPut .= "<td>$NameFamily</td>";
                $OutPut .= "<td>$mobile_no</td>";
                $OutPut .= "<td>$role</td>";
                $OutPut .= '<td><button class="btn btn-success" type="button"' . 'onclick="fff(' . "'" . $UserName . "'" . ',' . "'" . $NameFamily . "'" . ')" > انتخاب </td>';
                $OutPut .= "</tr>";
                $counter++;
            }
        } else {
            $OutPut = "nok";
        }
        return $OutPut;
    }
    public function ChangeNewsStatus($request)
    {
        $NewsID = $request->input('NewsID');
        $Status = $request->input('TargetStatus');
        $post_src = posts::find($NewsID);
        $post_src->Status = $Status;
        $post_src->save();
        $Type = $post_src->Type;
        $this->update_wordpress_status($NewsID,$Status);
        if($Type == 1 && $Status == 1 ){

            $news_class = new NewsClass('SingleNews', true);
            $news_class->post_after_update_jobs($NewsID);

        }
        return '1';
    }
    public function update_wordpress_status($post_id,$Status){
        $post_item =posts::where('id', $post_id)->first();
        // if (!$post_item || !$post_item->wordpress_post_id) {
        //     return false;
        // }
        $wordpress_id = $post_item->wordpress_post_id;
        $post_status = ($Status == 1) ? 'publish' : 'draft';
        DB::table('wp_posts')
            ->where('ID', $wordpress_id)
            ->update(['post_status' => $post_status]);

        return true;
   }
    public function ChangeFormStatus($request)
    {
        $NewsID = $request->input('FormID');
        $Status = $request->input('TargetStatus');
        $updateData = [
            'Status' => $Status,
        ];
        forms_meta::where('id', $NewsID)->update($updateData);
        return '1';
    }
    public function ChangeOrderStatus($request)
    {
        $OrderID = $request->input('OrderID');
        $Status = $request->input('TargetStatus');
        if (\App\myappenv::Lic['HCIS_Workflow']) {
            $MyWorkFlow = new Workflow();
            $WorkFlowText = 'تغییر وضعیت درخواست: ' . $request->input('OrderID') . '<br>';
            $TargetOrder = addorder1::where('ID', $OrderID)->first();
            $OrderCat = catorder::where('ID', $TargetOrder->CatID)->first();
            $BeforChange = orderstatus::where('ID', $TargetOrder->Status)->first();
            $AfterChange = orderstatus::where('ID', $Status)->first();
            $WorkFlowText .= '<h6>' . $OrderCat->TitleDescription . '</h6>';
            $WorkFlowText .= 'از وضعیت : ' . $BeforChange->status . ' - ' . ' به وضعیت: ' . $AfterChange->status;
            $MyWorkFlow->AddWorkFlow($TargetOrder->BimarUserName, Auth::id(), $WorkFlowText);
        }

        $UpdateData = [
            'Status' => $Status,
        ];
        $result = addorder1::where('ID', $OrderID)->update($UpdateData);
        $DataSource = addorder1::where('ID', $OrderID)->first();
        /*
        if ($DataSource->branch == myappenv::Shafatel_Branch) {
        $postRequest = array(
        'function' => 'UpdateOrderState',
        'keySec' => myappenv::ShafatelKey,
        'ID' => $DataSource->PearID,
        'Status' => $Status
        );
        $MyAPI = new APIClass();
        $apiResponse = $MyAPI->PostCurl(myappenv::ShafatelAPIAddress, $postRequest);
        } */
        return $result;
    }
    public function GetUserCredite($request)
    {
        $ReferenceId = $request->input('ReferenceId');
        $OwnerUserID = $request->input('OwnerUserID');
        $ResponserID = $request->input('ResponserID');
        $CreateDate = $request->input('CreateDate');
        $worker = $request->input('worker');
        $Patant = $request->input('Patant');
        $Work = $request->input('Work');
        $Query = "SELECT UserCredit.ID as UserCreditID  ,UserCredit.UserName,OwnerUserInfo.Name as OwnerUserInfoName , OwnerUserInfo.Family as OwnerUserInfoFamily, UserCredit.Mony,UserCredit.Note,UserCredit.TransferBy,byUserInfo.Name as byUserInfoName , byUserInfo.Family as byUserInfoFamily, UserCredit.Date as UserCreditDate ,UserCreditModMeta.ModName ,CONCAT(UserInfo.name,' ',UserInfo.Family ) as name ,UserCredit.ID ,UserCredit.RealMony,UserCredit.Type,UserCredit.ReferenceId
FROM UserCredit join UserCreditModMeta join UserInfo
INNER JOIN UserInfo as byUserInfo on byUserInfo.UserName=UserCredit.TransferBy
INNER JOIN UserInfo as OwnerUserInfo on OwnerUserInfo.UserName=UserCredit.UserName
WHERE  UserCredit.UserName = UserInfo.UserName and ReferenceId  = $ReferenceId and UserCredit.CreditMod = UserCreditModMeta.ID";
        $RequestedCredits = DB::select($Query);

        $output = "<input class=\"nested\" name=\"OwnerUserID\" value=\"$OwnerUserID\"><input class=\"nested\" name=\"ResponserID\" value=\"$ResponserID\"><input class=\"nested\" name=\"CreateDate\" value=\"$CreateDate\">";
        $output .= "<p>بیمار : $Patant </p>";
        $output .= "<p>نیرو عملیاتی : $worker </p>";
        $output .= "<p>خدمت : $Work </p>";
        $output .= '
                   <div class="table-responsive">
                        <table id="myTable" class="' . myappenv::MainTableClass . '" style="width:100%">
                            <thead>
                            <tr>
                                <th>شماره تراکنش</th>
                                <th>به حساب</th>
                                <th>مبلغ</th>
                                <th>نوع اعتبار</th>
                                <th>تاریخ ثبت</th>
                            </tr>
                            </thead>
                            <tbody>';
        $MyPersian = new persian();
        foreach ($RequestedCredits as $RequestedCredit) {
            $Transaction_code = $RequestedCredit->UserCreditID;
            $To_account = $RequestedCredit->OwnerUserInfoName . " " . $RequestedCredit->OwnerUserInfoFamily;
            $Price = number_format($RequestedCredit->Mony);
            $Credit_Type = $RequestedCredit->ModName;
            $Date_of_enter = $MyPersian->MyPersianDate($RequestedCredit->UserCreditDate, true);
            $output .= "
            <tr>
                                <th>$Transaction_code</th>
                                <th>$To_account</th>
                                <th>$Price</th>
                                <th>$Credit_Type</th>
                                <th>$Date_of_enter</th>
                            </tr>
            ";
        }

        $output .= ' </tbody>

                        </table>

                    </div>
        ';
        $output .= '<div class="card-body">
                        <div class="card-title"> انجام خدمت با سطح رضایت</div>
                        <button type="submit" name="submit" value="1" class="btn btn-danger btn-rounded m-1">افتضاح عدم تایید</button>
                        <button type="submit" name="submit" value="2" class="btn btn-warning btn-rounded m-1">بد عدم تایید</button>
                        <button type="submit" name="submit" value="3" class="btn btn-info btn-rounded m-1">متوسط</button>
                        <button type="submit" name="submit" value="4" class="btn btn-primary btn-rounded m-1">خوب</button>
                        <button type="submit" name="submit" value="5" class="btn btn-success btn-rounded m-1">عالی</button>
                        <button type="submit" name="submit" value="100" class="btn btn-dark btn-rounded m-1">تایید بدون مبلغ!!</button>
                    </div>';
        return $output;
    }
    public function SendConfirmCodeSMS($request)
    {
        $MobileNumber = $request->input('MobileNumber');
        $MyPassWoord = rand(myappenv::minpass, myappenv::maxpass);
        $mytext = new TextClassMain();
        $SMSText = $mytext->ResetPassword($MyPassWoord);
        $MySMS = new SmsCenter();

        $MySMS->OndemandSMS($SMSText, $MobileNumber, 'ResetPassword', $MobileNumber);
        return $MyPassWoord;
    }
    public function GetProductInfo($request)
    {

        $ProductWarehouseID = $request->input('ProductWarehouseID');
        $GoodID = $request->input('GoodID');
        $menueworkcat = myappenv::menueworkcat;
        $Query = "SELECT
        lw.Name as l3name , lw2.Name as l2name
    from
        goodindices g
    inner join L3Work lw on
        g.IndexID = lw.UID
    INNER JOIN L2Work lw2 on
        lw2.WorkCat = lw.WorkCat AND
        lw2.L1ID =lw.L1ID AND
        lw2.L2ID =lw.L2ID
        WHERE g.GoodID  = $GoodID and lw.WorkCat != $menueworkcat";
        $Setting = setting::where('name', 'show_table_of_index')->first();

        if ($Setting == null || $Setting->value == '1') {

            $indexes = DB::select($Query);
            $JsonIndex = json_encode($indexes);
        } else {
            $JsonIndex = '';
        }

        $ProductsInWarehouse = warehouse_goods::all()->where('GoodID', $GoodID);
        $TotallQty = 0;
        foreach ($ProductsInWarehouse as $ProductInWarehouse) {
            if ($ProductInWarehouse->SaleLimit > $ProductInWarehouse->Remian) {
                $TotallQty .= $ProductInWarehouse->Remian;
            } else {
                $TotallQty .= $ProductInWarehouse->SaleLimit;
            }
        }
        $output = array($JsonIndex, $TotallQty);
        return $output;
    }
    public function AddToBasketStepper($request)
    {
        $ProductId = $request->input('ProductId');
        $pw_id = $request->input('pw_id');
        $OrderQty = $request->input('OrderQty');
        $MyBuy = new buy();
        if ($MyBuy->IsValidProduct($pw_id)) {
            return $MyBuy->AddToBasketStepper($ProductId, $OrderQty, $pw_id);
        } else {
            return 'typemismatch';
        }
    }
    public function AddToBasket($request)
    {
        $ProductId = $request->input('ProductId');
        $MySchadul = new buy();
        $MySchadul->RemoveOldGoodFromBasket($ProductId);
        $pw_id = $request->input('pw_id');
        $OrderQty = $request->input('OrderQty');
        $Benefit = $request->input('Benefit');
        $OldBenefit = Session::get('benefit');
        Session::put('benefit', $OldBenefit + $Benefit);
        $MyBuy = new buy();
        return $MyBuy->AddToBasket($ProductId, $OrderQty, $pw_id);
    }
    public function RemoveFromOrder($request)
    {
        $ProductId = $request->input('ProductId');
        $MySchadul = new buy();
        return $MySchadul->RemoveGoodFromBasket($ProductId);
    }
    public function RemoveSMS($request)
    {
        $MessageId = $request->input('MessageId');
        $ModifyData = [
            'Status' => 1000,
        ];
        SMS::where('SMSID', $MessageId)->update($ModifyData);
        return true;
    }
    public function GetCitysOfProvinces($request)
    {
        $ProvinceCode = $request->input('ProvinceCode');
        $Citys = citys::all()->where('province', $ProvinceCode);
        $OutputString = '';
        foreach ($Citys as $City) {
            $OutputString .= "<option value='$City->id'> $City->CityName </option>";
        }
        return $OutputString;
    }
    public function GetDeleverPrice($request)
    {
        $rate_type = $request->input('rate_type');
        $price = $request->input('price');
        if ($request->has('weight') && $request->input('weight') > 0) {
            $weight = $request->input('weight');
        } else {
            $weight = 100;
        }

        $pay_type = $request->input('pay_type');
        $to_province = $request->input('to_province');
        $from_province = $request->input('from_province');
        $to_city = $request->input('to_city');
        $from_city = $request->input('from_city');
        $MyDelever = new DeleverClass();
        $DeleverMony = $MyDelever->GetDeleverPriceTopin($rate_type, $price, $weight, $pay_type, $to_province, $from_province, $to_city, $from_city);
        $mod = $DeleverMony % 5000;
        if ($mod > 0) {
            $DeleverMony = $DeleverMony - $mod + 5000;
        }
        session::put('DeleverMony', $DeleverMony);
        return $DeleverMony;
    }
    public function GetL3Index($request)
    {
        $UID = $request->input('UID');
        $result = L3Work::where('UID', $UID)->first();
        $result = json_encode($result);
        return $result;
    }

    public function GetTapinPrice($request)
    {
        $mytext = new TextClassMain;
        $Tapin = new Tapin();
        $location = $request->location;

        $price = $request->input('price');
        $weight = $request->input('weight');
        $loc_src = locations::where('id', $location)->first();
        $address = $loc_src->OthersAddress;
        $city_code = $loc_src->CityID;
        $province_code = $loc_src->ProvinceID;
        $first_name = Auth::user()->Name;
        $last_name = Auth::user()->Family;
        $mobile = $loc_src->reciverphone;
        $postal_code = $mytext->persian_number_to_en($loc_src->PostalCode);
        $package_weight = $request->input('weight');
        $DeleverMony = $Tapin->GetTapinPrice($price, $weight, $address, $city_code, $province_code, $first_name, $last_name, $mobile, $postal_code, $package_weight);
        if (!$DeleverMony[0]) {
            return $DeleverMony;
        }
        $mod = $DeleverMony[1] % 5000;
        if ($mod > 0) {
            $DeleverMony[1] = $DeleverMony[1] - $mod + 5000;
        }
        session::put('DeleverMony', $DeleverMony[1]);
        return $DeleverMony;
    }
    public function SearchProduct($request)
    {
        $SearchText = $request->input('SearchText');
        $Goods = goods::where('NameFa', 'like', "%$SearchText%")->limit(5)->get();
        if (myappenv::MainOwner != 'kookbaz') {
            $OutPut = '<div style="border-width: 0px;" >نتایج مرتبط</div>';
        } else {
            $OutPut = '';
        }
        $Counter = 0;
        foreach ($Goods as $Good) {
            $Counter++;
            $TargetRoute = route('SingleProduct', ['productID' => $Good->id]);
            $ProductName = $Good->NameFa;
            $ProductImage = '<img alt="" class="search_item_308"   src="' . Images::GetPicture($Good->ImgURL, 1) . '">';

            if (Str::len($ProductName) > 30) {
                //$ProductName = $Good->NameFa;
                //$ProductName = substr($ProductName, 0, 31);
                //$ProductName .= '...';

                $OutPut .= '<a title="" class="search_item_308" rel="nofollow" href="' . $TargetRoute . '">' . $ProductImage . $ProductName . '</a>';
            } else {
                $OutPut .= '<a title="" class="search_item_308" rel="nofollow" href="' . $TargetRoute . '">' . $ProductImage . $ProductName . '</a>';
            }
            $OutPut .= '<hr class="search_item_308" style="margin-top: 16px;margin-bottom: 16px;margin-left:10px" >';
        }
        $OutPut .= '<a title="" class="search_item_308" rel="nofollow" href="' . route('search') . '?q=' . $SearchText . '">' . 'نمایش همه' . '</a>';
        if ($Counter == 0) {
            return '<p class="noresult_321"> کالا یافت نشد! </p>';
        } else {
            return $OutPut;
        }
    }
    public function SearchProductSystem($request)
    {
        $SearchText = $request->input('SearchText');
        $Goods = goods::where('NameFa', 'like', "%$SearchText%")->limit(5)->get();
        if (myappenv::MainOwner != 'kookbaz') {
            $OutPut = '<div style="border-width: 0px;" >نتایج مرتبط</div>';
        } else {
            $OutPut = '';
        }
        $Counter = 0;
        foreach ($Goods as $Good) {
            $Counter++;
            $TargetRoute = route('SingleProduct', ['productID' => $Good->id]);
            $ProductName = $Good->NameFa;
            $ProductImage = '';
            $OutPut .= '<button type="button" class="linkbut" id="' . $Good->id . '" value="' . $ProductName . '" onclick="selectProductitem(this)" >' . $ProductName . '</button>';
            $OutPut .= '<hr class="search_item_308" style="margin-top: 16px;margin-bottom: 16px;margin-left:10px" >';
        }
        if ($Counter == 0) {
            return '<p class="noresult_321"> کالا یافت نشد! </p>';
        } else {
            return $OutPut;
        }
    }
    public function checkCrawlLink($request)
    {
        $LinkID = $request->input('LinkID');
        $MyCrawler = new CrawlerMain();
        $Result = $MyCrawler->IsValidLink($LinkID);
        if ($Result == 'false') {
            return 'لینک قابل پردازش نیست!';
        } elseif ($Result == 'before') {
            return 'قبلا پردازش شده!';
        } else {
            return $Result;
        }
    }
    public function DuplicateNameCheck($request)
    {
        $SearchText = $request->input('SearchText');
        $Goods = goods::where('NameFa', $SearchText)->first();
        if ($Goods == null) {
            return 0;
        } else {
            return $Goods->id;
        }
    }
    public function DuplicateSKUCheck($request)
    {
        $SearchText = $request->input('SearchText');
        $Goods = goods::where('SKU', $SearchText)->first();
        if ($Goods == null) {
            return 0;
        } else {
            return $Goods->id;
        }
    }
    public function alertme($request)
    {
        if (Auth::check()) {
            $OrderText = $request->input('OrderText');
            $GoodID = $request->input('GoodID');
            $DataSource = [
                'UserName' => Auth::id(),
                'RequestProduct' => $GoodID,
                'note' => $OrderText,
            ];
            alertme::create($DataSource);
            return 'Added';
        } else {
            return 'not login';
        }
    }
    public function GetInformolaPrice($request)
    {

        $JsonPlan = $request->input('JsonPlan');
        $Qty = $request->input('Qty');
        $MyProduct = new product();
        if (is_array($JsonPlan)) {
            return $MyProduct->GetTargetPriceFromPricePlan($JsonPlan, $Qty);
        } else {
            return $MyProduct->GetTargetPriceFromPricePlanJson($JsonPlan, $Qty);
        }
    }
    public function GetBaseInformolaPrice($request)
    {
        $JsonPlan = $request->input('JsonPlan');
        $Qty = $request->input('Qty');
        $MyProduct = new product();
        return $MyProduct->GetTargetBasePriceFromPricePlanJson($JsonPlan, $Qty);
    }
    public function GetBasicInfoToloadModal($request)
    {
        $JsonPlan = $request->input('JsonPlan');
        $JsonPlan = json_decode($JsonPlan);
        $MinimumPrice = product::GetMinPrice($JsonPlan);
        $MaxPrice = product::GetMaxPrice($JsonPlan);
        $MyProduct = new product();
        $Price = $MyProduct->GetTargetPriceFromPricePlan($JsonPlan, 1);
        $InitBasePrice = $MyProduct->GetTargetBasePriceFromPricePlan($JsonPlan, 1);
        $OutPut = ['MinPrice' => $MinimumPrice, 'MaxPrice' => $MaxPrice, 'Price' => $Price, 'initformola' => $InitBasePrice];
        return $OutPut;
    }
    public function GetWalet($request)
    {
        $TargetUserName = $request->input('TargetUserName');
        $Query = "SELECT sum(Mony) as Mony ,CreditMod   FROM `UserCredit` as uc  WHERE uc.UserName = '$TargetUserName' and uc.ConfirmBy is not null GROUP BY uc.CreditMod";
        $Resutl = DB::select($Query);
        $Resutl = json_encode($Resutl);
        return $Resutl;
    }

    public function tavanpardakhtAdminfn($request)
    {
        $myTavan = new TavanPardakhtClass();

        $UserAttr = [
            'TargetMelliID' => $request->input('TargetMelliID'),
            'TargetMobileNumber' => $request->input('TargetMobileNumber'),
        ];
        $returnValue = $myTavan->tavanpardakhtAdminfn($UserAttr);
        return $returnValue["message"];
    }
    public function tavanpardakhtAdminAdd($request)
    {

        $myTavan = new TavanPardakhtClass();
        $UserAttr = [
            'TargetMelliID' => $request->input('TargetMelliID'),
            'TargetMobileNumber' => $request->input('TargetMobileNumber'),
        ];
        $Periodcredit = $request->input('TargetPeriodcredit');

        $returnValue = $myTavan->tavanpardakhtAdminfn($UserAttr, $Periodcredit);
        return $returnValue["message"];
    }

    public function tavanpardakhtfn($request)
    {
        $TargetUserName = $request->input('TargetUserName');
        $TargetUserSrc = UserInfo::where('UserName', $TargetUserName)->first();
        $MyRepost = new Reports();
        if ($TargetUserSrc->MelliID == '0123456789') { // test procedure
            session::put('tavanpardakht', '123456');
            session::put('person', 1);
            return 'ok';
        }
        $Estelam = $MyRepost->Estelam($TargetUserSrc->MelliID);
        if ($Estelam == 'notvalid') {
            return 'notvalid';
        } else {
            $Es_Mobile = $Estelam->tham;
            // $Es_Mobile = '09192228284';
            $Es_fullName = $Estelam->fullName;
            if ($Estelam->personType == 'PENSIONER') {
                $personType = ' مستمری بگیر ';
                $person = 2;
            } else {
                $personType = 'بازنشسته ';
                $person = 1;
            }
            $UserClass = new UserClass();
            $secCode = $UserClass->GetRandomPassword(5);
            info('code = ' . $secCode);
            $MessageText = $personType . ' گرامی در سامانه کوک باز شما درخواست کاربری ویژه جهت خرید اعتباری اقساطی داده اید در صورتی که مورد تایید است کد ' . $secCode . ' را در سامانه وارد فرمایید! ';
            $Mysms = new SmsCenter();
            $Mysms->OndemandSMS($MessageText, $Es_Mobile, 'SystemUA', Auth::id());
            session::put('tavanpardakht', $secCode);
            session::put('person', $person);
            return 'ok';
        }
    }

    public function TestTashim($request)
    {

        $Counter = $request->input('Counter');
        $FormolaID = $request->input('FormolaID');
        $MyTashim = new TashimClass();
        $Tashimvar = new TashimVars();
        $Tashimvar->SalePrice = $request->input('SaleMony');
        $Tashimvar->BuyPrice = $request->input('BuyMony');
        $Tashimvar->shippingPrice = $request->input('DeleverMony');
        $Tashimvar->TavanPrice = $request->input('Tavan');
        $Tashimvar->TaxPrice = $request->input('TaxMony');
        $TashimSorce = tashim::where('ItemOrder', '>', 0)->where('TashimID', $FormolaID)->orderBy('ItemOrder', 'ASC')->get();
        $Lcounter = 0;
        foreach ($TashimSorce as $TashimSorceIetem) {
            if ($Counter == $Lcounter) {
                $TargetFormola = $TashimSorceIetem;
                break;
            }
            $Lcounter++;
        }
        $FormolStr = $TargetFormola->FormolStr;
        $CreditModeSRC = UserCreditModMeta::where('ID', $TargetFormola->CreditMod)->first();
        $result = $MyTashim->FormulaCalc($FormolStr, $Tashimvar);
        $OutPut = 'Step ' . strval($Lcounter + 1) . ':' . '&#013;&#010;';
        $OutPut .= '<<<<' . $TargetFormola->Note . '>>>>>' . '&#013;&#010;';
        $OutPut .= $TargetFormola->FormolStr . ' => ' . $TargetFormola->TargetUser . ' ' . $result . ' کیف پول ' . $CreditModeSRC->ModName . '&#013;&#010;';
        return $OutPut;
    }
    public function CheckShaba($request)
    {
        $TargetShaba = $request->input('TargetShaba');
        $Targetcard = $request->input('Targetcard');
        $Targetbank = $request->input('Targetbank');
        $SaveData = [
            'UserName' => Auth::id(),
            'CardNo' => strip_tags($Targetcard),
            'Account' => strip_tags($TargetShaba),
            '‌BankName' => strip_tags($Targetbank),
            'Status' => 1,
        ];
        info($SaveData);
        BankAccount::create($SaveData);
        $output = 'Success';
        return $output;
    }
    public function GetBasketBref($request)
    {
        return buy::GetBasketItemsBrif();
    }
    public function removeitem($request)
    {

        $ProductID = $request->input('ProductID');
        $MyBuy = new buy();
        $MyBuy->RemoveGoodFromBasket($ProductID);
    }
    public function AddProductAlert($request)
    {
        if (!Auth::check()) {
            return abort('The use not login!');
        }
        $product_id = $request->input('ProductID');
        $username = Auth::id();
        $my_alert = new ProductAlert();
        $function_result = $my_alert->add_customer_alert($product_id, $username);
        return $function_result;
    }
    public function TavanPardakhtGroup($request)
    {


        $json_data = json_decode($request->input('data'), true);

        foreach ($json_data as $item) {

            //$Name = trim($item['Name']);
            //$Family = trim($item['Family']);
            $Meliid = trim($item['MeliID']);
            //$Phone = trim($item['Phone']);
            $TavanData = [
                'Name' => 'Name',
                'Family' => 'Name',
                'MobileNo' => "",
                'MelliID' => $Meliid,
                'Tavan' => 0,
                'Status' => 0,
            ];

            tavanpardakht_temp::create($TavanData);
        }
        $targetuser = tavanpardakht_temp::where('Name', 'Name')->where('Status', 0)->get();
        if ($targetuser == null) {
            //finish database
            return response()->json(['دیتایی برای نمایش وجود ندارد' => true]);
        }
        $MyReport = new Reports();
        foreach ($targetuser as $targetuserlist) {
            $MelliID = $targetuserlist->MelliID;
            $Result = $MyReport->Estelam($MelliID);
            try {
                $fullname = $Result->fullName;
                $Name = strtok($fullname, '  ');
                $Family = substr($fullname, strpos($fullname, " ") + 1);
                $Mobile = $Result->tham;
                $Tavan = $Result->tavg;
                $NewData = [
                    'Name' => $Name,
                    'Family' => $Family,
                    'MobileNo' => $Mobile,
                    'Tavan' => $Tavan,
                    'ExtraInfo' => $fullname,
                    'Status' => 1,
                ];
            } catch (Throwable $e) {
                $fullname = 'faild';
                $NewData = [
                    'Name' => 'faild',
                    'Family' => 'faild',
                    'Status' => 1,
                ];
            }
            tavanpardakht_temp::where('Name', 'Name')->where('MelliID', $MelliID)->update($NewData);
        }

        $targetuser = tavanpardakht_temp::where('Status', 1)->get();
        if ($targetuser == null) {
            //finish database
            return response()->json(['دیتایی برای نمایش وجود ندارد' => true]);
        }
        return response()->json(['data' => $targetuser]);
    }
    private function PatientSetter(Request $request)
    {
        $mypat = new PatientClass;
        return $mypat->PatientSetter_1($request->UserName);
    }
    private function debug_report(Request $request)
    {
        $message = $request->message;
        $mian_url = $request->main_url;
        $report = "message: $message  #
        url: $mian_url";
        throw new Exception($report);
    }
    private function receive_notifications(Request $request)
    {
        $NotificationId = $request->NotificationId;
        $notification_src = notification::where('id', $NotificationId)->first();
        $extra = $notification_src->extra;
        if ($extra == null) {
            return [];
        } else {
            $extra = json_decode($extra);
        }
        $output = '
        <div class="table-responsive">
             <table id="myTable" class="' . myappenv::MainTableClass . '" style="width:100%">
                 <thead>
                 <tr>
                     <th>ارسال از</th>
                     <th>کاربر</th>
                     <th>تاریخ</th>
                     <th>متن پیامک</th>
                 </tr>
                 </thead>
                 <tbody>';
        $RequestedCredits = [];
        foreach ($extra as $extra_item) {
            $notification_data = $extra_item[1];
            $user_text = '';
            $user_src = UserInfo::where('MobileNo', $notification_data->mobile_no)->get();
            foreach ($user_src as $user_item) {
                $user_text .= '<p style="margin-left:3px;">' . $user_item->Name . ' ' . $user_item->Family . '</p>';
            }
            $output .= "
 <tr>
                     <th>$notification_data->mobile_no </th>
                     <th>$user_text</th>
                     <th>$notification_data->receive_time</th>
                     <th>$notification_data->sms_text</th>
                 </tr>
 ";
        }

        $output .= ' </tbody>

             </table>

         </div>
';
        return $output;
    }
    private function BothSideCall(Request $request)
    {
        if (myappenv::Lic['Voip']) {
            $moshavereh = new ConsultClass;
            $UserInfo_src = UserInfo::where('UserName', $request->target_user)->first();
            if ($UserInfo_src == null) {
                return 'متاسفانه کاربر مورد نظر در سیستم موجود نمی باشد!';
            } else {
                $moshavereh->BothSideCall(Auth::user()->MobileNo, $UserInfo_src->MobileNo);
                return 'اراسال درخواست پیام انجام شد لطفا منتظر تماس بمانید!';
            }
        } else {
            return 'شما مجوز انجام تماس دوطرفه ندارید!';
        }
    }
    private function edit_user_address(Request $request)
    {
        $location_id = $request->Location;
        $mytext = new TextClassMain;
        $UserName = Auth::id();
        $Exist_location = locations::where('id', $location_id)->first();
        if ($Exist_location == null) {
            return false;
        }
        $LocationName = $mytext->StripText($request->LocationName);
        $mobile_no = $mytext->StripText($request->mobile_no ?? Auth::user()->MobileNo);
        $mobile_no = $mytext->persian_number_to_en($mobile_no);
        $Province = $mytext->StripText($request->Province);
        $Shahrestan = $mytext->StripText($request->Shahrestan);
        $OthersAddress = $mytext->StripText($request->OthersAddress);
        $PostalCode = $mytext->StripText($request->PostalCode ?? '1111111111');
        $PostalCode = $mytext->persian_number_to_en($PostalCode);
        $Province_src = provinces::where('id', $Province)->first();
        $city_src = citys::where('id', $Shahrestan)->first();
        $LocationData = [
            'Owner' => $UserName,
            'name' => $LocationName,
            'Province' => $Province_src->ProvinceName,
            'ProvinceID' => $Province,
            'City' => $city_src->CityName,
            'CityID' => $Shahrestan,
            'Street' => '',
            'OthersAddress' => $OthersAddress,
            'Pelak' => '',
            'PostalCode' => $PostalCode,
            'ExtraNote' => '',
            'recivername' => '',
            'reciverphone' => $mobile_no,
        ];
        $Result = locations::where('id', $location_id)->update($LocationData);
        return true;
    }
    private function add_user_address(Request $request)
    {
        if ($request->has('Location')) {
            if ($request->Location != 0) {
                return $this->edit_user_address($request);
            }
        }

        $mytext = new TextClassMain;
        $UserName = Auth::id();
        $LocationName = $mytext->StripText($request->LocationName);
        $mobile_no = $mytext->StripText($request->mobile_no ?? Auth::user()->MobileNo);
        $mobile_no = $mytext->persian_number_to_en($mobile_no);
        $Province = $mytext->StripText($request->Province);
        $Shahrestan = $mytext->StripText($request->Shahrestan);
        $OthersAddress = $mytext->StripText($request->OthersAddress);
        $PostalCode = $mytext->StripText($request->PostalCode ?? '1111111111');
        $PostalCode = $mytext->persian_number_to_en($PostalCode);
        $Province_src = provinces::where('id', $Province)->first();
        $city_src = citys::where('id', $Shahrestan)->first();
        $LocationData = [
            'Owner' => $UserName,
            'name' => $LocationName,
            'Province' => $Province_src->ProvinceName,
            'ProvinceID' => $Province,
            'City' => $city_src->CityName,
            'CityID' => $Shahrestan,
            'Street' => '',
            'OthersAddress' => $OthersAddress,
            'Pelak' => '',
            'PostalCode' => $PostalCode,
            'ExtraNote' => '',
            'recivername' => '',
            'reciverphone' => $mobile_no,
        ];
        $Result = locations::create($LocationData);
        return true;
    }
    private function remove_user_address(Request $request)
    {
        locations::where('Owner', Auth::id())->where('id', $request->location_id)->delete();
        return true;
    }
    private function product_mark($product_id)
    {
        if (!Auth::check()) {
            return [
                'result' => false,
                'msg' => 'لطفا جهت ثبت علاقه مندی وارد سامانه شوید!'
            ];
        }
        $product_mark = new ProductMark;
        $before_mark = $product_mark->is_marked_before(Auth::id(), $product_id, 1);
        if ($before_mark) {
            $product_mark->remove_mark(Auth::id(), $product_id, 1);
            return [
                'result' => true,
            ];
        }
        $product_mark->mark_a_product(Auth::id(), $product_id, 1);
        return [
            'result' => true,
        ];
    }
    private function call_parastarbank(Request $request)
    {
        $username = $request->username;
        $user_src = UserInfo::where('UserName', $username)->first();
        if ($user_src == null) {
            return [
                'result' => false,
                'msg' => 'اطلاعات ارسالی نادرست است.'
            ];
        }
        $user_src = $user_src->getOriginal();
        $body_data = [
            'token' => 'asfadfejkjfqF_QEf#fewfqqEQFQFqklqlkmfqhuqewf',
            'password' => '09123936105',
            'function' => 'worker_enquiry',
            'data' => $user_src
        ];
        $body_data = http_build_query($body_data);
        $ch = curl_init('https://parastarbank.com/api/hiring');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    public function main(Request $request)
    {
        $AjaxType = $request->input('AjaxType');

        switch ($AjaxType) {
            case 'product_mark':
                return $this->product_mark($request->product_id);
                break;

            case 'call_parstarbank':
                return $this->call_parastarbank($request);


            case 'totallMarketIndexChart_usd':
                $USD_TMN = crypto_price_24hs::where('curency', 'USD-TMN')->orderBy('updated_at', 'ASC')->limit(10)->get();
                $USDT_TMN = crypto_price_24hs::where('curency', 'USDT-TMN')->orderBy('updated_at', 'ASC')->limit(10)->get();
                $DRH_TMN = crypto_price_24hs::where('curency', 'DRH-TMN')->orderBy('updated_at', 'ASC')->limit(10)->get();
                return [
                    'USD_TMN' => $USD_TMN,
                    'USDT_TMN' => $USDT_TMN,
                    'DRH_TMN' => $DRH_TMN
                ];
                break;
            case 'BothSideCall':
                return $this->BothSideCall($request);
                break;
            case 'get_crypto_graph':
                return 'sakam';
                break;
            case 'receive_notifications':
                return $this->receive_notifications($request);
                break;
            case 'Debug':
                return $this->debug_report($request);
                break;
            case 'PatientSetter':
                return $this->PatientSetter($request);
                break;
            case 'CheckUsersMobile':
                return $this->CheckUsersMobile($request);
                break;
            case 'WorkerSearch':
                return $this->WorkerSearch($request);
                break;
            case 'WorkerSearch_advance':
                return $this->WorkerSearch_advance($request);
                break;
            case 'ChangeNewsStatus':
                return $this->ChangeNewsStatus($request);
                break;
            case 'ChangeFormStatus':
                return $this->ChangeFormStatus($request);
                break;
            case 'ChangeOrderStatus':
                return $this->ChangeOrderStatus($request);
                break;
            case 'GetUserCredite':
                return $this->GetUserCredite($request);
                break;
            case 'SendConfirmCodeSMS':
                return $this->SendConfirmCodeSMS($request);
                break;
            case 'GetProductInfo':
                return $this->GetProductInfo($request);
                break;
            case 'AddToBasketStepper':
                return $this->AddToBasketStepper($request);
                break;
            case 'AddToBasket':
                return $this->AddToBasket($request);
                break;
            case 'RemoveFromOrder':
                return $this->RemoveFromOrder($request);
                break;
            case 'RemoveSMS':
                return $this->RemoveSMS($request);
                break;
            case 'GetCitysOfProvinces':
                return $this->GetCitysOfProvinces($request);
                break;
            case 'GetDeleverPrice':
                return $this->GetDeleverPrice($request);
                break;
            case 'GetL3Index':
                return $this->GetL3Index($request);
                break;
            case 'GetTapinPrice':
                return $this->GetTapinPrice($request);
                break;
            case 'SearchProduct':
                return $this->SearchProduct($request);
                break;
            case 'SearchProductSystem':
                return $this->SearchProductSystem($request);
                break;
            case 'checkCrawlLink':
                return $this->checkCrawlLink($request);
                break;
            case 'DuplicateNameCheck':
                return $this->DuplicateNameCheck($request);
                break;
            case 'DuplicateSKUCheck':
                return $this->DuplicateSKUCheck($request);
                break;
            case 'alertme':
                return $this->alertme($request);
                break;
            case 'GetInformolaPrice':
                return $this->GetInformolaPrice($request);
                break;
            case 'GetBaseInformolaPrice':
                return $this->GetBaseInformolaPrice($request);
                break;
            case 'GetBasicInfoToloadModal':
                return $this->GetBasicInfoToloadModal($request);
                break;
            case 'GetWalet':
                return $this->GetWalet($request);
                break;
            case 'tavanpardakhtAdminfn':
                return $this->tavanpardakhtAdminfn($request);
                break;
            case 'tavanpardakhtAdminAdd':
                return $this->tavanpardakhtAdminAdd($request);
                break;
            case 'tavanpardakhtfn':
                return $this->tavanpardakhtfn($request);
                break;
            case 'TestTashim':
                return $this->TestTashim($request);
                break;
            case 'CheckShaba':
                return $this->CheckShaba($request);
                break;
            case 'removeitem':

                return $this->removeitem($request);
                break;
            case 'AddProductAlert':

                return $this->AddProductAlert($request);
                break;
            case 'GetBasketBref':
                return $this->GetBasketBref($request);
                break;
            case 'TavanPardakhtGroup':
                return $this->TavanPardakhtGroup($request);
                break;
            case 'add_user_address':
                return $this->add_user_address($request);
                break;
            case 'remove_user_address':
                return $this->remove_user_address($request);
                break;
            default:
                return null;
        }
    }
}
