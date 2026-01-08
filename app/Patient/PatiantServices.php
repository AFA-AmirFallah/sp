<?php

namespace App\Patient;

use App\APIS\SmsCenter;
use App\Functions\AppSetting;
use App\Functions\persian;
use App\Functions\TashimClass;
use App\Functions\TashimVars;
use App\Functions\TextClassMain;
use App\Functions\Transfer;
use App\Http\Controllers\Patients\Workflow;
use App\Http\Controllers\setting\SettingManagement;
use App\Models\branches;
use App\Models\branchs_order;
use App\Models\locations;
use App\Models\product_order;
use App\Models\RelatedStaff;
use App\Models\RespnsType;
use App\Models\tashim;
use App\Models\UserCredit;
use App\Models\UserInfo;
use App\Models\UserPoint;
use App\myappenv;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class PatiantServices
{
    private $related_service_id;
    private $RespnsType_src = null;
    private $TransferList;
    private $service_attr_general;
    private $order_id;
    private $order_tashim;
    public function EditOrder($OrderID)
    {
        $user_branch = Auth::user()->branch;
        $OrderSrc = product_order::where('ServiceContract', $OrderID)->first();
        $ProductOrder = $OrderSrc;
        if ($OrderSrc == null) {
            return abort('404', 'لینک مورد نظر وجود ندارد');
        }
        $OrderID = $OrderSrc->id;
        $ServiceId = $OrderSrc->ServiceContract;
        $UserBranch = Auth::user()->branch;
        $OrderBranch = branchs_order::where('branch', $UserBranch)->where('order_id', $OrderID)->first();
        if ($OrderBranch == null) {
            return abort('404', 'لینک مورد نظر وجود ندارد');
        }
        $UserPoint = UserPoint::where('UserName', Auth::id())->where('ConfirmUser', '!=', null)->sum('Point');
        $related_staff = RelatedStaff::where('id', $ServiceId)->where('branch', $user_branch)->first();
        if ($related_staff == null) {
            return abort('404');
        }
        $creator_src = UserInfo::where('UserName', $related_staff->CreateBy)->first();
        $worker_src = UserInfo::where('UserName', $related_staff->ResponserID)->first();
        $work_src = RespnsType::where('id', $related_staff->RespnsType)->first();
        $locations = locations::where('id', $ProductOrder->SendLocation)->first();
        $Customer = UserInfo::where('UserName', $ProductOrder->CustomerId)->first();
        $RelatedCredite = $related_staff->RelatedCredite;
        $query = "SELECT UserCredit.* , UserCreditModMeta.ModName FROM UserCredit INNER JOIN UserCreditModMeta on UserCredit.CreditMod = UserCreditModMeta.ID and UserCredit.UserName = '$ProductOrder->CustomerId' and UserCredit.ReferenceId = $RelatedCredite";
        $patiant_payment = DB::select($query);
        $CurentPoint = UserPoint::where('Work', $OrderID)->first();
        return view('woocommerce.admin.EditOrderService', ['patiant_payment' => $patiant_payment, 'related_staff' => $related_staff, 'work_src' => $work_src, 'creator_src' => $creator_src, 'worker_src' => $worker_src,  'CurentPoint' => $CurentPoint,  'UserPoint' => $UserPoint, 'locations' => $locations, 'ProductOrder' => $ProductOrder,  'Customer' => $Customer]);
    }

    private function get_user_info($UserName)
    {
        $branch = Auth::user()->branch;
        return UserInfo::where("UserName", $UserName)->where('branch', $branch)->first();
    }
    private function add_related_order($ServiceID, $OwnerUserID, $RelatedStaffData)
    {
        $order_data = [
            'CustomerId' => $OwnerUserID,
            'ServiceContract' => $ServiceID,
            'status_history' => $RelatedStaffData,


        ];
        $Order_result =  product_order::create($order_data);
        $OrderID = $Order_result->id;
        $this->order_id = $OrderID;
        $BranchData = [
            'branch' => Auth::user()->branch,
            'order_status' => 1,
            'order_id' => $OrderID,
        ];
        branchs_order::create($BranchData);
        return $OrderID;
    }
    private function add_service($worker, $customer, $service_attr)
    {

        $RelatedStaffData = [
            'OwnerUserID' => $customer->UserName,
            'ResponserID' => $worker->UserName,
            'CreateDate' => $service_attr['now_date'],
            'CreateBy' => Auth::id(),
            'StartRespns' => $service_attr['StartRespns'],
            'EndRespns' => $service_attr['EndRespns'],
            'RespnsType' => $service_attr['Service_id'],
            'Note' => $service_attr['Note'],
            'EndNote' => '',
            'tashim' => $this->order_tashim,
            'branch' => $service_attr['branch']
        ];
        $result = RelatedStaff::create($RelatedStaffData);
        $service_id = $result->id;
        $related_order_id = $this->add_related_order($service_id, $customer->UserName, json_encode($RelatedStaffData));
        RelatedStaff::where('id', $service_id)->update(['ContractID' => $related_order_id]);
        return $result;
    }
    private function get_RespnsType($service_attr)
    {
        if ($this->RespnsType_src == null) {
            $this->RespnsType_src =  RespnsType::where('id', $service_attr['Service_id'])->first();
            $this->service_attr_general['Position'] = $this->RespnsType_src->RespnsTypeName;
            $this->service_attr_general['ServiceType'] = $this->RespnsType_src->ServiceType;
        }
        return $this->RespnsType_src;
    }
    private function get_service_price($service_attr)
    {

        $SelectedService = $this->get_RespnsType($service_attr);
        if ($SelectedService->ServiceType != 2) { // the service has not price
            return [
                'SalePrice' => 0,
                'BuyPrice' => 0
            ];
        }


        if ($SelectedService->price_type == 2) { // Session based service
            return [
                'SalePrice' => $SelectedService->CustomerfixPrice,
                'BuyPrice' => $SelectedService->fixPrice
            ];
        } elseif ($SelectedService->price_type == 1) { // Time based Service
            $hourdiff = round((strtotime($service_attr['EndRespns']) - strtotime($service_attr['StartRespns'])) / 3600, 1);
            $SalePrice =  $SelectedService->CustomerhPrice * $hourdiff;
            $BuyPrice = $SelectedService->hPrice * $hourdiff;
            return [
                'SalePrice' => $SalePrice,
                'BuyPrice' => $BuyPrice
            ];
        }
    }
    private function get_target_UserName($worker, $customer, $TargetUser)
    {
        switch ($TargetUser) {
            case 'buyer':
                return $customer->UserName;
            case 'Seller':
                return $worker->UserName;
            case 'Daramad':
                return myappenv::StackHolder . Auth::user()->branch;
            case 'owner':
                $TargetBranch = branches::where('id', Auth::user()->branch)->first();
                return $TargetBranch->UserName;
            case 'Marketer':
                if ($customer->Marketer == null) {
                    return myappenv::StackHolder . Auth::user()->branch;
                }
                return $customer->Marketer;
            case 'Taxer':
                return myappenv::TaxHolder . Auth::user()->branch;
            case 'Insurance':
                return myappenv::InsuranceHolder . Auth::user()->branch;
            default:
                return $TargetUser;
                break;
        }
    }
    private function get_transfer_list($worker, $customer, $service_attr)
    {
        $MyTashim = new TashimClass();
        $Tashimvar = new TashimVars();
        $service_price = $this->get_service_price($service_attr);
        $Tashimvar->SalePrice = $service_price['SalePrice'];
        $Tashimvar->BuyPrice = $service_price['BuyPrice'];
        $Tashimvar->shippingPrice = 0;
        $Tashimvar->TavanPrice = 0;
        $Tashimvar->TaxPrice = 0;
        $RespnsType = $this->get_RespnsType($service_attr);
        if ($service_attr['tashim'] == null) {
            $select_tashim = $RespnsType->tashim;
        } else {
            $select_tashim = $service_attr['tashim'];
        }
        $this->order_tashim = $select_tashim;
        $TashimSorce = tashim::where('TashimID', $select_tashim)->where('ItemOrder', '>', 0)->get();
        $Credit_arr = array();
        foreach ($TashimSorce as $TashimSorceIetem) {
            $FormolStr = $TashimSorceIetem->FormolStr;
            $result = $MyTashim->FormulaCalc($FormolStr, $Tashimvar);
            //echo "Target uesr : $TashimSorceIetem->TargetUser , CreditMod : $TashimSorceIetem->CreditMod  and result = $result and Note = $TashimSorceIetem->Note   <br> ";
            $Credit_item = [
                'Target_user' => $TashimSorceIetem->TargetUser,
                'Target_UserName' => $this->get_target_UserName($worker, $customer, $TashimSorceIetem->TargetUser),
                'CreditMod' => $TashimSorceIetem->CreditMod,
                'Mony' => $result,
                'Note' => $TashimSorceIetem->Note,
            ];
            array_push($Credit_arr, $Credit_item);
        }
        return $Credit_arr;
    }
    private function get_user_transfer(array $TransferList, $TargetUse)
    {
        $Output_price = 0;
        foreach ($TransferList as $TransferList_item) {
            if ($TransferList_item['Target_user'] == $TargetUse && $TransferList_item['CreditMod'] == myappenv::CachCredit) {
                $Output_price += $TransferList_item['Mony'];
            }
        }
        return $Output_price;
    }
    private function negative_defense($customer, $customer_price)
    {
        $UserCredit_src = UserCredit::where('UserName', $customer->UserName)->whereNotNull('ConfirmBy')->where('CreditMod', myappenv::CachCredit)->get();
        $UserCredit = $UserCredit_src->sum('Mony');
        if ($customer_price > 0) {
            return [
                'result' => false,
                'credit' => $UserCredit,
                'msg' => 'بروز مشکل امنیتی: مبلغ کسر از مشتری صحیح نیست!'
            ];
        }

        $customer = $this->get_user_info($customer->UserName);
        $extradata = $customer->extradata;
        $Credit_limit = 0;
        if ($extradata != null) {

            $extradata = json_decode($extradata);
            if (isset($extradata->max_credit)) {
                $Credit_limit = $extradata->max_credit;
            }
        }
        $UserCredit += $Credit_limit;
        $customer_price = abs($customer_price);
        if ($UserCredit  >= $customer_price) {
            return [
                'result' => true,
                'credit' => $UserCredit,

            ];
        }
        return [
            'result' => false,
            'credit' => $UserCredit,
            'msg' => 'میزان اعتبار مشتری کافی نیست در صورتی که میخواهید این خدمت انجام شود مبلغ کسر اعتبار معادل:   ' . number_format($customer_price - $UserCredit)  . ' ریال به حساب کاربر اضافه کنید! ',

        ];
    }
    private function transfer_mony($worker, $customer, $service_attr)
    {
        $TransferList = $this->get_transfer_list($worker, $customer, $service_attr);
        // echo '<br>';
        //print_r($TransferList);
        $this->TransferList = $TransferList;

        $customer_price = $this->get_user_transfer($TransferList, 'buyer');
        $Valid_transfer = $this->negative_defense($customer, $customer_price);
        if (!$Valid_transfer['result']) {
            //  echo 'problem';
            return [
                'result' => false,
                'msg' => $Valid_transfer['msg']
            ];
        }
        return [
            'result' => true
        ];
    }
    private function finalize_transfer($service_attr)
    {
        $customer_pay = 0;
        $daramad_pay = 0;
        $Offer_Service_src = RelatedStaff::where('id', $this->related_service_id)->first();
        $service_note = $Offer_Service_src->Note;
        $Service_src = $this->get_RespnsType($service_attr);
        $ExtraNote = $Service_src->Description;
        $ReferenceId = 0;
        foreach ($this->TransferList as $transfer_item) {
            $InsertData = [
                'UserName' => $transfer_item['Target_UserName'],
                'Mony' =>  $transfer_item['Mony'],
                'Type' =>  166,
                'Date' => now(),
                'Note' =>  $transfer_item['Note'] . " خدمت: $ExtraNote توضیحات: $service_note ",
                'InvoiceNo' => $this->related_service_id,
                'ReferenceId' => $ReferenceId,
                'TransferBy' => Auth::id(),
                'branch' => Auth::user()->branch,
                'CreditMod' => $transfer_item['CreditMod'],
                'CreditIndex' => $Service_src->UserCreditIndex
            ];
            if ($transfer_item['Target_user'] == 'buyer') {
                $customer_pay += $transfer_item['Mony'];
            }
            if ($transfer_item['Target_user'] == 'Daramad') {
                $daramad_pay += $transfer_item['Mony'];
            }
            $Create_result = UserCredit::create($InsertData);
            if ($ReferenceId == 0) {
                $ReferenceId = $Create_result->id;
                UserCredit::where('id', $ReferenceId)->update(['ReferenceId' => $ReferenceId]);
                RelatedStaff::where('id', $this->related_service_id)->update(['RelatedCredite' => $ReferenceId]);
            }
        }
        $order_data = [
            'total_sales' => abs($customer_pay),
            'status' => 1,
            'net_total' => $daramad_pay
        ];
        product_order::where('id', $this->order_id)->update($order_data);
        return true;
    }
    private function service_alerts()
    {
        $Mytext = new TextClassMain();
        $extra_info = [
            'responserName' => $this->service_attr_general['responserName'],
            'responserExt' => $this->service_attr_general['responser_Ext'],
            'Ownername' => $this->service_attr_general['Qwnername'],
            'Position' => $this->service_attr_general['Position'],
            'StartDateShamsi' => $this->service_attr_general['StartDateShamsi'],
            'userExt' => $this->service_attr_general['responser_Ext'],
            'EndDateShamsi' => $this->service_attr_general['EndDateShamsi']
        ];

        $responserText = $Mytext->SetShiftResponserSMS($this->service_attr_general['Position'],  $this->service_attr_general['Qwnername'], myappenv::CenterPhone, myappenv::CenterEndSmsTxt,$extra_info);
        $ownerText = $Mytext->SetShiftOwnerSMS($this->service_attr_general['responserName'], $this->service_attr_general['Position'], myappenv::CenterEndSmsTxt,$extra_info);
        $MySMS = new SmsCenter();
        if ($this->service_attr_general['ServiceType'] != 3) {
            $MySMS->OndemandSMS($ownerText, $this->service_attr_general['OwnerMobile'], 'Shift', $this->service_attr_general['Qwner_UserName']);
        }
        $MySMS->OndemandSMS($responserText, $this->service_attr_general['RespnserMobile'], 'Shift',   $this->service_attr_general['responser_UserName']);
    }
    private function service_finalize()
    {
    }
    private function service_work_flow()
    {
        if (\App\myappenv::Lic['HCIS_Workflow']) {
            $MyWorkFlow = new Workflow();
            $WorkFlowText = ' ثبت شیفت  : <br>';
            $NoteText = "انجام خدمت توسط:";
            $NoteText .= "  " . $this->service_attr_general['responserName'] . " ";
            $NoteText .= " گیرنده خدمت: ";
            $NoteText .= "  " . $this->service_attr_general['Qwnername'];
            $NoteText .= " نوع خدمت: ";
            $NoteText .= "  " . $this->service_attr_general['Position'];
            $NoteText .= " Create By System";
            $NoteText .= " تاریخ شروع: ";
            $NoteText .= "  " . $this->service_attr_general['StartDateShamsi'];
            $NoteText .= " تاریخ پایان: ";
            $NoteText .= "  " . $this->service_attr_general['EndDateShamsi'];
            $WorkFlowText .= $NoteText;
            $MyWorkFlow->AddWorkFlow($this->service_attr_general['Qwner_UserName'], Auth::id(), $WorkFlowText);
            $MyWorkFlow->AddWorkFlow($this->service_attr_general['responser_UserName'], Auth::id(), $WorkFlowText);
        }
    }
    private function assign_service($worker, $customer, $service_attr)
    {
        // echo 'transferig';
        $transfer_result = $this->transfer_mony($worker, $customer, $service_attr);
        if (!$transfer_result['result']) {
            return redirect()->back()->with('error', $transfer_result['msg']);
        }
        $add_service_result = $this->add_service($worker, $customer, $service_attr);
        // echo  'service resutlt ' . $add_service_result . '<br>';
        $this->related_service_id = $add_service_result->id;
        $this->finalize_transfer($service_attr);
        $this->service_work_flow(); // add to work flow
        $this->service_alerts();
        //echo 'ثبت خدمت انجام گرفت';
        return redirect()->back()->with('success', 'ثبت خدمت انجام گرفت');
    }
    public function add_cunsulting_service_to_patiant($Service_id, $Worker, $RequestUser)
    {
        $MyPersian = new persian;
        $WorkerInfo = UserInfo::where('Ext', $Worker)->first();
        $customer = UserInfo::where('UserName', $RequestUser)->first();

        if ($WorkerInfo == null) {
            return [
                'result' => 'false',
                'msg' => 'مشاور درخواستی در سیستم وجود ندارد!'
            ];
        }
        if ($customer == null) {
            return [
                'result' => 'false',
                'msg' => 'مشتری مورد نظر امکان تغییر توسط شما ندارد'
            ];
        }

        $Status = $WorkerInfo->Status;
        if ($Status < 101) { //check Valid worker
            return [
                'result' => 'false',
                'msg' => 'the selected personel is not valid'
            ];
        }
        $Persian = new persian;
        $this->service_attr_general['Service_id'] = $Service_id;
        $this->service_attr_general['Qwner_UserName'] = $customer->UserName;
        $this->service_attr_general['Qwnername'] = $customer->Name . " " . $customer->Family;
        $this->service_attr_general['OwnerMobile'] = $customer->MobileNo;
        $this->service_attr_general['responser_UserName'] = $WorkerInfo->UserName;
        $this->service_attr_general['responser_Ext'] = $WorkerInfo->Ext;
        $this->service_attr_general['responserName'] = $WorkerInfo->Name . ' ' . $WorkerInfo->Family;
        $this->service_attr_general['RespnserMobile'] = $WorkerInfo->MobileNo;
        $this->service_attr_general['StartDateShamsi'] = $Persian->MyPersianNow();
        $this->service_attr_general['EndDateShamsi'] =  $Persian->MyPersianNow();
        $StartRespns = date("Y-m-d H:i:s");
        $curDateTime = date("Y-m-d H:i:s");
        $inputdate = new DateTime($StartRespns);
        $inputdate = $inputdate->format("Y-m-d H:i:s");
        $MySetting = new AppSetting();
        $ShiftWithPasteTime = $MySetting->GetSettingValue('ShiftWithPasteTime');  //TODO: change with branch selector
        $RespnsType = RespnsType::where('MainIndex', $Service_id)->first();
        $tashim = $RespnsType->tashim;
        $service_attr = [
            'Service_id' => $RespnsType->id,
            'EndDate' => date('Y-m-d H:i:s'),
            'EndRespns' => date('Y-m-d H:i:s'),
            'Note' => 'مشاوره',
            'now_date' => date('Y-m-d H:i:s'),
            'EndDateShamsi' => $this->service_attr_general['EndDateShamsi'],
            'StartRespns' => $StartRespns,
            'branch' => Auth::user()->branch,
            'tashim' => $tashim
        ];
        // echo '<br>';
        // print_r($service_attr);
        return $this->assign_service($WorkerInfo, $customer, $service_attr);
    }

    public function add_service_to_patient(Request $request, $RequestUser)
    {
        $MyPersian = new persian;
        $Service_id = $request->input('RespnsType');
        if ($request->ResponserID == null) {
            $Worker = $request->ResponserID_i;
        } else {
            $Worker = $request->ResponserID;
        }
        $WorkerInfo = $this->get_user_info($Worker);
        $customer = $this->get_user_info($RequestUser);

        if ($WorkerInfo == null) {
            return redirect()->back()->with("error", __('the selected personel is not valid'));
        }
        if ($customer == null) {
            return redirect()->back()->with("error", __('مشتری مورد نظر امکان تغییر توسط شما ندارد!'));
        }

        $Status = $WorkerInfo->Status;
        if ($Status < 101) { //check Valid worker
            return redirect()->back()->with("error", __('the selected personel is not valid'));
        }
        $StartDate = $request->StartDate;
        $this->service_attr_general['Service_id'] = $Service_id;
        $this->service_attr_general['Qwner_UserName'] = $customer->UserName;
        $this->service_attr_general['Qwnername'] = $customer->Name . " " . $customer->Family;
        $this->service_attr_general['OwnerMobile'] = $customer->MobileNo;
        $this->service_attr_general['responser_UserName'] = $WorkerInfo->UserName;
        $this->service_attr_general['responser_Ext'] = $WorkerInfo->Ext;
        $this->service_attr_general['responserName'] = $WorkerInfo->Name . ' ' . $WorkerInfo->Family;
        $this->service_attr_general['RespnserMobile'] = $WorkerInfo->MobileNo;
        $this->service_attr_general['StartDateShamsi'] = $StartDate . ' - ' . $request->StartTime;
        $this->service_attr_general['EndDateShamsi'] = $request->input('EndDate') . ' - ' . $request->input('EndTime');
        $StartRespns = $MyPersian->MyMiladiDateTime($StartDate, $request->StartTime);
        $curDateTime = date("Y-m-d H:i:s");
        $inputdate = new DateTime($StartRespns);
        $inputdate = $inputdate->format("Y-m-d H:i:s");
        $MySetting = new AppSetting();
        $ShiftWithPasteTime = $MySetting->GetSettingValue('ShiftWithPasteTime');  //TODO: change with branch selector
        if ($request->has('tashim')) {
            $tashim = $request->tashim;
        } else {
            $tashim = null;
        }
        if ($curDateTime <= $inputdate || Auth::User()->Role == myappenv::role_SuperAdmin || $ShiftWithPasteTime == 'true') {
            $service_attr = [
                'Service_id' => $Service_id,
                'EndDate' => $request->input('EndDate'),
                'EndRespns' => $MyPersian->MyMiladiDateTime($request->input('EndDate'), $request->input('EndTime')),
                'Note' => $request->input('Note'),
                'now_date' => date('Y-m-d H:i:s'),
                'EndDateShamsi' => $this->service_attr_general['EndDateShamsi'],
                'StartRespns' => $StartRespns,
                'branch' => Auth::user()->branch,
                'tashim' => $tashim
            ];
            return $this->assign_service($WorkerInfo, $customer, $service_attr);

            dd('end');



            $Branch = 1;
            if ($customer != null) {

                $SelectedService = RespnsType::where('id', $RespnsType)->first();
                $CreditIndex = $SelectedService->UserCreditIndex ?? 0;
                $CreditePlan = $customer->CreditePlan;
                $Transfer = new Transfer($RequestUser, $Worker, $nowdate, Auth::id(), $StartRespns, $EndRespns, $RespnsType, $Note, $Holders, $CreditePlan, $Branch, $CreditIndex);
                $MyArr2 = $request->input('formDoor');
                $Transfer->SetCatHolders($MyArr2);
                if ($Transfer->TransferShift()) {
                    $Qwnername = $customer->Name . " " . $customer->Family;
                    $OwnerMobile = $customer->MobileNo;
                    $Position = $SelectedService->RespnsTypeName;
                    $responserName = $WorkerInfo->Name . ' ' . $WorkerInfo->Family;
                    $RespnserMobile = $WorkerInfo->MobileNo;
                } else {
                    return redirect()->back()->with('error', __('error alert'));
                }

                return redirect()->back()->with('success', __("success alert"));
            } else {
                return redirect()->back()->with('error', __("the user name dos not exist"));
            }
        } else {
            return redirect()->back()->with("error", __('The input time is not valid'));
        }
    }
}
