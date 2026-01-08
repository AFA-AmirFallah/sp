<?php

namespace App\Http\Controllers\APIS;

use App\APIS\bale;
use App\APIS\SmsCenter;
use App\Functions\APIClass;
use App\Functions\Financial;
use App\Functions\TashimClass;
use App\Users\UserClass;
use App\Http\Controllers\Controller;
use App\Models\branches;
use App\Models\Calls;
use App\Models\RespnsType;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Http\Request;
use DB;
use UserWithSkillsView;
use Illuminate\Support\Facades\Log;

class VOIP extends Controller
{

    public function NumberFormater($InputNumer)
    {
        if ($InputNumer == null) {
            return [
                'inputType' => 'error',
                'OutputNumber' => $InputNumer
            ];
        }
        $InputNumer = trim($InputNumer);
        if (strlen($InputNumer) < 2) {
            return [
                'inputType' => 'error',
                'OutputNumber' => $InputNumer
            ];
        }

        if (str_starts_with($InputNumer, '98')) {
            $InputNumer = substr($InputNumer, 2);
        }

        $Len = strlen($InputNumer);
        if ($InputNumer[0] == 0 && $Len == 10) {
            if ($InputNumer[1] == 9) {

                $inputType = "mobile";
                $OutputNumber = $InputNumer;
            } else {
                // 10 digit for fixline number out of tehran
                $inputType = "fix";
                $OutputNumber = $InputNumer;
            }
        } else {

            if ($Len == 10) {
                // 10 digit for mobile number without ziro
                if ($InputNumer[0] == 9) {
                    $inputType = "mobile";
                    $OutputNumber = '0' . $InputNumer;
                } else {
                    // 10 digit for fixline number out of tehran
                    $inputType = "fix";
                    $OutputNumber = '0' . $InputNumer;
                }
            } elseif ($Len == 8) {
                //8 digit for Tehran fix line
                $inputType = "fix";
                $OutputNumber = '021' . $InputNumer;
            } elseif ($Len == 11) {
                //11 digit for mobile number
                $inputType = "currect";
                $OutputNumber = $InputNumer;
            } else {
                $inputType = "error";
                $OutputNumber = $InputNumer;
            }
        }
        $Output = [
            'inputType' => $inputType,
            'OutputNumber' => $OutputNumber
        ];

        return $Output;
    }
    private function SecurityCheck($HostIPAddress)
    {
        if (in_array($HostIPAddress, myappenv::VOIPWithList, )) {
            return true;
        } else {
            return false;
        }
    }
    public function who_is_call_username($PhoneNumber)
    {
        $Result = UserInfo::where('MobileNo', $PhoneNumber)->orWhere('Phone1', $PhoneNumber)->orWhere('Phone2', $PhoneNumber)->first();
        if ($Result == null) {
            return null;
        }
        return $Result->UserName;
    }
    private function who_is_call_by_phone_number($PhoneNumber)
    {
        $Result = UserInfo::where('MobileNo', $PhoneNumber)->orWhere('Phone1', $PhoneNumber)->orWhere('Phone2', $PhoneNumber)->first();
        if ($Result == null) {
            return [
                'result' => false,
                'msg' => 'The phone number not belong to users'
            ];
        }
        $Result = $Result->toArray();
        return [
            'result' => true,
            'msg' => 'success',
            'data' => $Result
        ];
    }
    private function IsCallerInDatabase($PhoneNumber)
    {
        $Result = UserInfo::where('MobileNo', $PhoneNumber)->orWhere('Phone1', $PhoneNumber)->orWhere('Phone2', $PhoneNumber)->first();
        if ($Result != null) {
            return $Result->UserName;
        } else {
            return 'false';
        }
    }
    private function call_permission(Request $request)
    {
    }
    private function operation_code(Request $request)
    {
        $CallerId = $request->CallerID;
        if ($CallerId == null) {
            return [
                'result' => false,
                'msg' => 'callerid not set'
            ];
        } else {
            $CallerId = $this->NumberFormater($CallerId);
            if ($CallerId['inputType'] == 'error') {
                return [
                    'result' => false,
                    'msg' => 'caller id format not valid'
                ];
            }
            $Operation = $request->Operation;
            if ($Operation == null) {
                return [
                    'result' => false,
                    'msg' => 'operation id not valid'
                ];
            }
            return [
                'result' => true,
                'msg' => 'done',
                'data' => null
            ];
        }
    }
    private function call_termination(Request $request)
    {
        $CallerId = $request->CallerID;
        $Ext = $request->Ext; // AnswerNumber
        $CallID = $request->CallID; // Voip Unique id
        $call_duration = $request->call_duration;  // by second
        $point = $request->point ?? 0;
        if ($CallerId == null) {
            return [
                'result' => false,
                'msg' => 'caller id not set'
            ];
        } else {
            $CallerId = $this->NumberFormater($CallerId);
            if ($CallerId['inputType'] == 'error') {
                return [
                    'result' => false,
                    'msg' => 'caller id format not valid'
                ];
            }
            if ($Ext == null) {
                return [
                    'result' => false,
                    'msg' => 'nov valid Ext'
                ];
            }
            if ($CallID == null) {
                return [
                    'result' => false,
                    'msg' => 'nov valid CallID'
                ];
            }
            if ($call_duration == null) {
                return [
                    'result' => false,
                    'msg' => 'nov valid call_duration'
                ];
            }
            $data = [
                'point' => $point
            ];
            return [
                'result' => true,
                'msg' => 'done',
                'data' => $data
            ];
        }
    }
    private function set_point(Request $request)
    {
        $CallID = $request->CallID; // Voip Unique id
        $point = $request->point ?? 0;
        if ($CallID == null) {
            return [
                'result' => false,
                'msg' => 'nov valid CallID'
            ];
        }
        if ($point == null) {
            return [
                'result' => false,
                'msg' => 'nov valid point'
            ];
        }
        return [
            'result' => true,
            'msg' => 'done',

        ];
    }
    private function get_account(Request $request)
    {
        $CallerId = $request->CallerID; //caller number
        if ($CallerId == null) {
            return [
                'result' => false,
                'msg' => 'caller id not set'
            ];
        } else {
            $CallerId = $this->NumberFormater($CallerId);
            if ($CallerId['inputType'] == 'error') {
                return [
                    'result' => false,
                    'msg' => 'caller id format not valid'
                ];
            }
            $target_user = UserInfo::where('MobileNo', $CallerId['OutputNumber'])->first();
            if ($target_user == null) {
                $data = [
                    'account' => 0
                ];
                return [
                    'result' => true,
                    'msg' => 'done',
                    'data' => $data
                ];
            }
            $username = $target_user->UserName;
            $Query = "SELECT SUM(Mony) as Mony FROM `UserCredit` WHERE CreditMod = 1 AND ConfirmBy is not null AND UserName = '$username'";
            $mony_src = DB::select($Query);
            foreach ($mony_src as $mony_item) {
                $account = $mony_item->Mony;
            }
            if ($account == null) {
                $account = 0;
            }
            $data = [
                'account' => $account
            ];
            return [
                'result' => true,
                'msg' => 'done',
                'data' => $data
            ];
        }
    }
    private function previous_answer(Request $request)
    {
        $CallerId = $request->CallerID; //caller number
        if ($CallerId == null) {
            return [
                'result' => false,
                'msg' => 'caller id not set'
            ];
        } else {
            $CallerId = $this->NumberFormater($CallerId);
            if ($CallerId['inputType'] == 'error') {
                return [
                    'result' => false,
                    'msg' => 'caller id format not valid'
                ];
            }

            $data = [
                'previous_number' => '09123936105'
            ];
            return [
                'result' => true,
                'msg' => 'done',
                'data' => $data
            ];
        }
    }
    private function find_user_by_index($index_number, $CallerId)
    {
        $Query = "SELECT UserInfo.* FROM UserInfo INNER JOIN WorkerSkils on WorkerSkils.UserName = UserInfo.UserName WHERE WorkerSkils.SkilID = $index_number and UserInfo.Role != 40 and UserInfo.Status = 101";
        $Result = DB::select($Query);
        $data = null;
        foreach ($Result as $Result_item) {
            $data = [
                'call_valid_duration' => 12000,
                'ext_phone' => $Result_item->MobileNo
            ];
            break;
        }
        if ($data == null) {
            return [
                'result' => false,
                'msg' => 'no user in selected index',
                'data' => $data
            ];
        }
        $bale = new bale();
        $CallerId = $this->NumberFormater($CallerId);
        $CallerId = $CallerId['OutputNumber'];
        $TargetUser = UserInfo::where('MobileNo', $CallerId)->orWhere('Phone1', $CallerId)->orWhere('Phone2', $CallerId)->orWhere('Ext', $CallerId)->first();
        if ($TargetUser == null) {
            $caller_name = 'نامشخل';
        } else {
            $caller_name = $TargetUser->Name . ' ' . $TargetUser->Family;
        }

        $answer_by = $Result_item->Name . ' ' . $Result_item->Family;
        $send_description = " *تماس ورودی*  
تماس گیرنده:" . $CallerId . " 
نام تماس گیرنده: $caller_name ,
پاسخ دهنده:  $answer_by ,
 تماس موفق با شاخص  ";
        $bale->send_message($send_description);
        return [
            'result' => true,
            'msg' => 'done',
            'data' => $data
        ];
    }
    private function get_user_which_offer_service($worker_index, $duration)
    {
        $user_set_src = UserWithSkillsView::where('SkilID', $worker_index)->first();
        if ($user_set_src == null) {
            return [
                'result' => false,
                'msg' => 'the worker is not define',
                'data' => null
            ];
        }
        $data = [
            'call_valid_duration' => $duration,
            'ext_phone' => $user_set_src->MobileNo
        ];
        return [
            'result' => true,
            'msg' => 'done',
            'data' => $data
        ];
    }
    private function find_user_by_service($service_id, $CallerId)
    {
        $caller_user_info_src = UserInfo::where('MobileNo', $CallerId)->first();
        if ($caller_user_info_src == null) {
            return [
                'result' => false,
                'msg' => 'the caller user is not defined',
                'data' => null
            ];
        }
        $response_src = RespnsType::where('id', $service_id)->where('OnSale', 1)->first();
        if ($response_src == null) {
            return [
                'result' => false,
                'msg' => 'the service is not defined',
                'data' => null
            ];
        }
        $financial = new Financial;
        $user_financial = $financial->UserFinalState($caller_user_info_src->UserName);
        $caller_credit = 0;
        foreach ($user_financial as $owner_financial_state_item) {
            if ($owner_financial_state_item->CreditMod == myappenv::CachCredit) {
                $caller_credit += $owner_financial_state_item->Mony;
            }
        }
        $tashim_id = $response_src->tashim;
        $tasim_class = new TashimClass;
        $price_type = $response_src->price_type; //1 for h_price | 2 for fix_price
        if ($price_type == 2) { // fix price
            $CustomerfixPrice = $response_src->CustomerfixPrice;
            $buyer_price = $tasim_class->get_sale_price_with_tashim_basic($CustomerfixPrice, 0, 0, $tashim_id);
            $buyer_price = $buyer_price['PriceWithTax'] * -1;
            if ($buyer_price < $caller_credit) {
                // can call
                return $this->get_user_which_offer_service($service_id, 120000);
            }
            return [
                'result' => false,
                'msg' => 'credit_less',
                'data' => null
            ];
        }

        if ($price_type == 1) { // hour based price
            $Customer_h_Price = $response_src->CustomerhPrice;
            $buyer_price = $tasim_class->get_sale_price_with_tashim_basic($Customer_h_Price, 0, 0, $tashim_id);
            $buyer_price = $buyer_price['PriceWithTax'] * -1;
            if ($buyer_price < $caller_credit) {
                // can call
                return $this->get_user_which_offer_service($service_id, 120000);
            }
            return [
                'result' => false,
                'msg' => 'credit_less',
                'data' => null
            ];
        }


        return $caller_credit;
    }
    private function call_by_service(Request $request)
    {
        $CallerId = $request->CallerID; // caller number
        $service_id = $request->service_id; // Request answer service
        $CallID = $request->CallID; // Voip Unique id

        if ($CallerId == null) {
            return [
                'result' => false,
                'msg' => 'caller id not set'
            ];
        }
        $CallerId = $this->NumberFormater($CallerId);
        if ($CallerId['inputType'] == 'error') {
            return [
                'result' => false,
                'msg' => 'caller id format not valid'
            ];
        }
        if ($service_id == null) {
            return [
                'result' => false,
                'msg' => 'nov valid service id'
            ];
        }
        if ($CallID == null) {
            return [
                'result' => false,
                'msg' => 'nov valid CallID'
            ];
        }
        $CallerId = $CallerId['OutputNumber'];
        return $this->find_user_by_service($service_id, $CallerId);
    }

    private function call_by_index(Request $request)
    {
        $CallerId = $request->CallerID; // caller number
        $index_id = $request->index_id; // Request answer index
        $CallID = $request->CallID; // Voip Unique id
        if ($CallerId == null) {
            return [
                'result' => false,
                'msg' => 'caller id not set'
            ];
        } else {
            $CallerId = $this->NumberFormater($CallerId);
            if ($CallerId['inputType'] == 'error') {
                return [
                    'result' => false,
                    'msg' => 'caller id format not valid'
                ];
            }
            if ($index_id == null) {
                return [
                    'result' => false,
                    'msg' => 'nov valid index_id'
                ];
            }
            if ($CallID == null) {
                return [
                    'result' => false,
                    'msg' => 'nov valid CallID'
                ];
            }
            $CallerId = $CallerId['OutputNumber'];
            return $this->find_user_by_index($index_id, $CallerId);
        }
    }
    private function add_user(Request $request)
    {
    }
    private function who_is_call(Request $request)
    {
        $CallerId = $request->CallerID; //caller number
        if ($CallerId == null) {
            return [
                'result' => false,
                'msg' => 'caller id not set'
            ];
        } else {
            $CallerId = $this->NumberFormater($CallerId);
            if ($CallerId['inputType'] == 'error') {
                return [
                    'result' => false,
                    'msg' => 'caller id format not valid'
                ];
            }
            $CallerId = $CallerId['OutputNumber'];
            $find_user = $this->who_is_call_by_phone_number($CallerId);
            if ($find_user['result']) {
                $user_data = $find_user['data'];
                return [
                    'result' => true,
                    'msg' => 'done',
                    'data' => [
                        'role' => $user_data['Role']
                    ]
                ];
            }
            $VoipUser = new UserClass();
            $VoipUser->AddUserBase($CallerId, $CallerId, myappenv::DefaultVoipUser_Name, myappenv::DefaultVoipUser_Family, $CallerId, "$CallerId@nomail.com", myappenv::role_customer, myappenv::Default_customer_Status, null);
            $owner = myappenv::CenterName;
            $site_address = myappenv::SiteAddress;
            $sms_text = " $owner 
مشتری گرامی ثبت نام شما همزمان با تماس شما در  $owner انجام شد. نام کاربری شما :  $CallerId  برای ورود به پنل خود و یا تکمیل اطلاعات خود از لینک زیر اقدام نمایید.
$site_address";
            $sms_center = new SmsCenter;
            $sms_center->OndemandSMS($sms_text, $CallerId, 'wc', $CallerId);
            return [
                'result' => true,
                'msg' => 'add',
                'data' => [
                    'role' => myappenv::role_customer
                ]
            ];
        }
    }
    private function activate_shift(Request $request)
    {
        return [
            'result' => true,
            'msg' => 'done'
        ];
    }
    private function deactivate_shift(Request $request)
    {
        return [
            'result' => true,
            'msg' => 'done'
        ];
    }
    private function callـtoـextension(Request $request)
    {
        // Log::channel('local')->info('call to ext ');
        $CallerId = $request->CallerID;
        $Ext = $request->Ext; // AnswerNumber
        $CallID = $request->CallID; // Voip Unique id
        if ($CallerId == null) {
            return [
                'result' => false,
                'msg' => 'caller id not set'
            ];
        } else {
            $CallerId = $this->NumberFormater($CallerId);
            if ($CallerId['inputType'] == 'error') {
                return [
                    'result' => false,
                    'msg' => 'caller id format not valid'
                ];
            }
            if ($Ext == null) {
                return [
                    'result' => false,
                    'msg' => 'nov valid Ext'
                ];
            }
            if ($CallID == null) {
                return [
                    'result' => false,
                    'msg' => 'nov valid CallID'
                ];
            }
            $target_user_src = UserInfo::where('Ext', $Ext)->first();

            if ($target_user_src == null) {
                $bale = new bale();
                $send_description = " *تماس ورودی*  
تماس گیرنده:" . $request->CallerID . " 
داخلی وارد شده:  $Ext ,
خطای تماس با داخلی تعریف نشده";
                $bale->send_message($send_description);
                return [
                    'result' => false,
                    'msg' => 'target user extension is not in database'
                ];
            }
            $CallerId = $this->NumberFormater($request->CallerID);
            $CallerId = $CallerId['OutputNumber'] ?? '';
            $TargetUser_call = UserInfo::where('MobileNo', $CallerId)->orWhere('Phone1', $CallerId)->orWhere('Phone2', $CallerId)->orWhere('Ext', $CallerId)->first();
            if ($TargetUser_call == null) {
                $caller_name = 'نامشخل';
            } else {
                $caller_name = $TargetUser_call->Name . ' ' . $TargetUser_call->Family;
            }

            $answerby = $target_user_src->Name . ' ' . $target_user_src->Family;
            $bale = new bale();
            $send_description = " *تماس ورودی*  
تماس گیرنده:" . $CallerId . " 
نام تماس گیرنده: $caller_name ,
پاسخ دهنده:  $answerby ,
داخلی وارد شده:  $Ext ,
  تماس موفق با داخلی";
            $bale->send_message($send_description);
            $data = [
                'ext_phone' => $target_user_src->MobileNo,
                'call_valid_duration' => 20000
            ];
            return [
                'result' => true,
                'msg' => 'done',
                'data' => $data
            ];
        }
    }
    private function is_valid_customer(Request $request)
    {
        $API = $request->header('DGKAR-API-KEY');
        $Customer = $request->header('DGKAR-API-Customer');
        $PASSPHRASE = $request->header('DGKAR-API-PASSPHRASE');
        $caller_id_address = $request->ip();
        if (in_array($caller_id_address, myappenv::VOIPWithList)) {
            $Validip = true;
        } else {
            $Validip = false;
        }
        if ($API != 'test') {
            return [
                'result' => 'false',
                'msg' => 'api key error'
            ];
        }
        if ($Customer != 'test') {
            return [
                'result' => 'false',
                'msg' => 'Customer not define error'
            ];
        }
        if ($PASSPHRASE != 'test') {
            return [
                'result' => 'false',
                'msg' => 'Password error'
            ];
        }

        if (!$Validip) {
            return [
                'result' => 'false',
                'msg' => 'sender ip address is not define : ' . $caller_id_address
            ];
        }

        return [
            'result' => 'true',
        ];
    }


    public function call_by_outside(Request $request)
    {
        // log($request->input());
        //Log::channel('local')->info($request->input());
        $function = $request->function;

        $validation = $this->is_valid_customer($request);
        if ($validation['result'] == 'false') {
            return $validation;
        }
        switch ($function) {
            case 'operation_code':
                return $this->operation_code($request);
                break;
            case 'call_termination':
                return $this->call_termination($request);
                break;
            case 'set_point':
                return $this->set_point($request);
                break;
            case 'get_account':
                return $this->get_account($request);
                break;
            case 'previous_answer':
                return $this->previous_answer($request);
                break;
            case 'call_by_index':
                return $this->call_by_index($request);
                break;
            case 'call_by_service':
                return $this->call_by_service($request);
                break;
            case 'add_user':
                return $this->add_user($request);
                break;
            case 'who_is_call':
                return $this->who_is_call($request);
                break;
            case 'activate_shift':
                return $this->activate_shift($request);
                break;
            case 'deactivate_shift':
                return $this->deactivate_shift($request);
                break;
            case 'callextension':
                return $this->callـtoـextension($request);
                break;
            case 'callـtoـextension':
                return $this->callـtoـextension($request);
                break;
            case 'call_permission':
                return $this->call_permission($request);
                break;
            default:
                return [
                    'result' => 'false',
                    'msg' => 'request function is not define: ' . $function
                ];
        }
        $postRequest = array(
            'function' => 'AddCustomer',
            'keySec' => '8CBF7689tf872UfyuQG3',
            'UserName' => $caller_id_address,
            'UserPass' => '1111',
            'Name' => $header,
            'Family' => 'testFamily',
            'MobileNo' => '09127878890',
            'Email' => 'test@yshaoo.com',
            'Ext' => '12',
            'branch' => '1000',
        );
        $postRequest = json_encode($postRequest);
        return $postRequest;
    }
    public function main(Request $request)
    {
        if ($request->input("test") == 'y') {
            $postRequest = array(
                'function' => 'AddCustomer',
                'keySec' => '8CBF7689tf872UfyuQG3',
                'UserName' => 'test11',
                'UserPass' => '1111',
                'Name' => 'testname',
                'Family' => 'testFamily',
                'MobileNo' => '09127878890',
                'Email' => 'test@yshaoo.com',
                'Ext' => '12',
                'branch' => '1000',
            );
            $MyAPI = new APIClass();
            $apiResponse = $MyAPI->PostCurl('https://artanurse.shafatel.com/api/OutBand', $postRequest);
            dd($apiResponse);
        }

        if ($this->SecurityCheck($request->ip())) {
            $CallerId = $request->input("CallerId"); //شماره تماس گیرنده
            $Destination = $request->input("Destination"); // سرخط تلفن
            $CallID = $request->input("CallID"); //شناسه ویپ
            $MobileNo = $this->NumberFormater($CallerId);
            $VoipUser = new UserClass();
            $TargetExt = $VoipUser->GetNewExtension();
            $UserPassword = $VoipUser->GetRandomPassword(4);
            $IsCallerInDatabase = $this->IsCallerInDatabase($MobileNo['OutputNumber']);
            $targetAnswer = branches::where('Phone', $Destination)->orWhere('Phone1', $Destination)->orWhere('Phone2', $Destination)->first();
            if ($targetAnswer == null) {
                $AnswerUser = $Destination;
            } else {
                $AnswerUser = $targetAnswer->id;
            }

            if ($IsCallerInDatabase == 'false') {
                $Result = $VoipUser->AddUserBase($TargetExt, $UserPassword, myappenv::DefaultVoipUser_Name, myappenv::DefaultVoipUser_Family, $MobileNo['OutputNumber'], "$TargetExt@nomail.com", myappenv::role_customer, myappenv::Default_customer_Status, $TargetExt);
                if ($targetAnswer->license != null) {
                    $postRequest = array(
                        'function' => 'AddCustomer',
                        'keySec' => $targetAnswer->license,
                        'UserName' => $TargetExt,
                        'UserPass' => $UserPassword,
                        'Name' => myappenv::DefaultVoipUser_Name,
                        'Family' => myappenv::DefaultVoipUser_Family,
                        'MobileNo' => $MobileNo['OutputNumber'],
                        'Email' => "$TargetExt@nomail.com",
                        'Ext' => $TargetExt,
                        'branch' => myappenv::Shafatel_Branch,
                    );
                    $MyAPI = new APIClass();
                    $apiResponse = $MyAPI->PostCurl($targetAnswer->api, $postRequest);
                }
                $CallerUser = $Result->Ext;
            } else {
                $CallerUser = $IsCallerInDatabase;
            }
            $CallDate = [
                'CallID' => $CallID,
                'CallerNumber' => $MobileNo['OutputNumber'],
                'AnsweredNumber' => $Destination,
                'CallerUser' => $CallerUser,
                'AnswerUser' => $AnswerUser,
                'CallType' => 1
            ];
            Calls::create($CallDate);
            echo "ok";
        } else {
            echo "Security error";
        }
    }
}
