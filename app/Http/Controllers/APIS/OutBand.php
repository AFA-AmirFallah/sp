<?php

namespace App\Http\Controllers\APIS;

use App\APIS\SmsCenter;
use App\Users\UserClass;
use App\Http\Controllers\Controller;
use App\Models\addorder1;
use App\Models\branches;
use App\Models\order_view;
use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use GuzzleHttp\Client;
use DB;
use PhpParser\JsonDecoder;

class OutBand extends Controller
{
    public function PartnerLogin(Request $request)
    {
        return redirect()->route('home');
        $script =
'<script>
    var settings = {
        "url": "https://api.kookbaz.ir/usermanagement/v2/account/token",
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Content-Type": "application/json",
            "Authorization": "Bearer MkZN9xDCqPeQ5fr4zo3Mbw==_Cva9iGRwMZrfQu_FUF3iPRZLRWrveW8kXvCDw==_YeX/pN762aKl30Z+gG8E+QAxBeq53X0Qy+CRdAsQ9xM=",
            "Cookie": "cookiesession1=1AD09B10UCPRVA1YBEGZXZVAIIVU2FDD"
        },
        "data": JSON.stringify({
            "otpCode": "'.$request->input('token').'"
        }),
    };

    $.ajax(settings).done(function (response) {
        console.log(response);
    });
</script>';
        echo $script;
        return  view('Auth.signIn3thparty');
        return true;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.kookbaz.ir/usermanagement/v2/account/token');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, '{"otpCode": "' . $request->input('token') . '"}');

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.kookbaz.ir/usermanagement/v2/account/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "otpCode": "' . $request->input('token') . '"
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer MkZN9xDCqPeQ5fr4zo3Mbw==_Cva9iGRwMZrfQu_FUF3iPRZLRWrveW8kXvCDw==_YeX/pN762aKl30Z+gG8E+QAxBeq53X0Qy+CRdAsQ9xM=',
                'Cookie: cookiesession1=1AD09B10UN3ZAWRMXU2CLLJ3V1I46D2B'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);

        if (isset($response->id)) { // the user is valid from other site
            // dd('yes', $response,$request->input());
            $id = $response->id;
            $birthDate = $response->birthDate;
            $firstName = $response->firstName;
            $lastName = $response->lastName;
            $nationalCode = $response->nationalCode;
            $image = $response->image;
            $cell = $response->cell;
            if ($response->email == null) {
                $email = "$cell@kokbaz.com";
            } else {
                $email = $response->email;
            }
            if ($response->isMale) {
                $isMale = 'm';
            } else {
                $isMale = 'f';
            }

            $TargetUser = UserInfo::where('UserName', $cell . '_KB')->first();
            if ($TargetUser == null) {
                 //RegisterUser
                 $LastExt = DB::table('UserInfo')->latest('Ext')->first();
                 $Ext =  $LastExt->Ext;
                $NewUserData = [
                    'UserName' => $cell . '_KB',
                    'Email' => $email,
                    'password' => Hash::make($cell),
                    'UserPass' => $cell,
                    'Name' => $firstName,
                    'Ext' => $Ext+1,
                    'Family' => $lastName,
                    'MobileNo' => $cell,
                    'Role' => myappenv::role_customer,
                    'Sex' => $isMale,
                    'Status' => myappenv::User_active_status,
                    'remember_token' => $request->input('token')
                ];
                UserInfo::create($NewUserData);
            } else {
                $NewUserData = [
                    'remember_token' => $request->input('token')
                ];
                UserInfo::where('UserName', $cell . '_KB')->update($NewUserData);
            }
            return redirect()->route('login', ['accesstype' => $request->input('token')]);

        } else {
            dd('no', $response, $request->input());
        }

    }

    private function UpdateUser($request)
    {
        $UserData = [
            "Name" => $request->input("Name"),
            "Family" => $request->input("Family"),
            "Email" => $request->input("Email"),
            "Sex" => $request->input("Sex"),
            "MobileNo" => $request->input("MobileNo"),
            "Birthday" => $request->input("Birthday"),
            "Address" => $request->input("Address"),
            "Phone1" => $request->input("Phone1"),
            "Phone2" => $request->input("Phone2"),
        ];

        if ($request->input('keySec') == 'test') {
            echo "Test is Successfully done!";
        } else {
            UserInfo::where("UserName", $request->input("UserName"))->update($UserData);
        }

    }

    private function IsUserExsit($UserItem)
    {
        $MyUser = new UserClass();
        if ($MyUser->IsUserExist($UserItem)) {
            $result = '1';
        } else {
            $result = '0';
        }
        return $result;
    }

    private function AddCustomer($request)
    {
        $UserName = $request->input('UserName');
        $UserPass = $request->input('UserPass');
        $Name = $request->input('Name');
        $Family = $request->input('Family');
        $MobileNo = $request->input('MobileNo');
        $Email = $request->input('Email');
        $Ext = $request->input('Ext');
        $branch = $request->input('branch');
        $MyUser = new UserClass();
        if ($request->input('keySec') == 'test') {
            echo "Test is Successfully done!";
        } else {
            $Result = $MyUser->AddUserBase($UserName, $UserPass, $Name, $Family, $MobileNo, $Email, myappenv::role_customer, myappenv::Default_customer_Status, $Ext, $branch);
        }
        return '1';
    }

    private function AddOrder($request)
    {
        $UserName = $request->input('UserName');
        $UserPass = $request->input('UserPass');
        $Name = $request->input('Name');
        $Family = $request->input('Family');
        $MobileNo = $request->input('MobileNo');
        $Email = $request->input('Email');
        $Ext = $request->input('Ext');
        $branch = $request->input('branch');
        $CatID = $request->input('CatID');
        $Address = $request->input('Address');
        $ADDExtranote = $request->input('ADDExtranote');
        $PearID = $request->input('PearID');
        $MyUser = new UserClass();
        $IsUserExistAllItems = $MyUser->IsUserExistAllItems($UserName);
        if ($IsUserExistAllItems == false) {
            $Result = $MyUser->AddUserBase($UserName, $UserPass, $Name, $Family, $MobileNo, $Email, myappenv::role_customer, myappenv::Default_customer_Status, $Ext, $branch);
        } else {
            $UserName = $IsUserExistAllItems;
        }
        $DataSource = [
            'UserName' => $UserName,
            'BimarUserName' => $UserName,
            'CatID' => $CatID,
            'CreateDate' => now(),
            'Status' => '1',
            'Address' => $Address,
            'Extranote' => $ADDExtranote,
            'branch' => $branch,
            'PearID' => $PearID
        ];
        $result = addorder1::create($DataSource);
        $result = ['orderid' => $result->id];
        $Output = json_encode($result);
        return $Output;
    }

    public function UpdateOrderState(Request $request)
    {
        $OrderID = $request->input('ID');
        $Status = $request->input('Status');
        $UpdateData = [
            'Status' => $Status
        ];
        $result = addorder1::where('ID', $OrderID)->update($UpdateData);
        $OrderSource = order_view::where('ID', $OrderID)->first();
        $MessageText = $OrderSource->Name . ' ' . $OrderSource->Family . ' ' . "عزیز درخواست شما به  " . $OrderSource->statusname . " " . " تغییر وضعیت پیدا کرد " . " " . " **شفاتل**";
        $Mysms = new SmsCenter();
        $Mysms->OndemandSMS($MessageText, $OrderSource->MobileNo, 'Order', $OrderSource->UserName);
        return $result;
    }

    public function CenterControl(Request $request)
    {
        return $request->name;
        $result = 'no result';
        if (myappenv::Apptype == 'customer') {
            if ($request->input('keySec') == myappenv::ShafatelKey) {
                switch ($request->input('function')) {
                    case 'IsUserExsit':
                        $result = $this->IsUserExsit($request->input('UserItem'));
                        break;
                    case 'AddCustomer':
                        $result = $this->AddCustomer($request);
                        break;
                    case 'AddOrder':
                        $result = $this->AddOrder($request);
                        break;

                }
                echo $result;
            } else {
                echo 'Security Error =>' . $request->input('keySec');
            }

        } elseif (myappenv::Apptype == 'owner') {
            if ($request->input('keySec') == 'test') {
                $Branch = 'test';
            } else {
                $Branch = branches::where('license', $request->input('keySec'))->first();
            }
            if ($Branch != null) {
                switch ($request->input('function')) {
                    case 'UpdateUser':
                        $result = $this->UpdateUser($request);
                        break;
                    case 'AddCustomer':
                        $result = $this->AddCustomer($request);
                        break;
                    case 'UpdateOrderState':
                        $result = $this->UpdateOrderState($request);
                        break;
                }
                echo $result;
            } else {
                echo 'Security Error';
            }


        }
    }
}
