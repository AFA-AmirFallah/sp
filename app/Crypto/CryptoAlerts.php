<?php

namespace App\Crypto;

use App\APIS\SmsCenter;
use App\LicMgt\UserLicense;
use App\Models\metadata;
use App\Models\UserInfo;
use DateInterval;
use DateTime;

class CryptoAlerts
{


    /**
     * This function sends an SMS alert to registered users for each signal in an array.
     * 
     * @param array Signal_Arr An array of signals that have been generated and need to be sent as alerts
     * to registered users.
     * 
     * @return a boolean value. If there are registered users and the SMS is sent successfully, it returns
     * true. If there are no registered users, it also returns true. If the Signal_Arr parameter is empty,
     * it also returns true.
     */
    public function alert_registered_user_generated_signal(array $Signal_Arr)
    {
        if ($Signal_Arr != []) {
            $RegistedUsers = metadata::where('tt', 'signalsmsalert')->get();
            if ($RegistedUsers->count() > 0) {
                $MySMS = new SmsCenter;
                foreach ($Signal_Arr as $SignalItem) {
                    foreach ($RegistedUsers as $RegistedUsersItem) {
                        $UserData = $RegistedUsersItem->meta_value;
                        $UserData = json_decode($UserData);
                        $UserMobile = $RegistedUsersItem->meta_key;
                        $NameFamily = $UserData->Name . " " . $UserData->Family;
                        $Ownertext = "$NameFamily عزیز سیگنال خرید $SignalItem ";
                        $MySMS->OndemandSMS($Ownertext, $UserMobile, 'signal', 'system');
                    }
                }
                return true;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * This function checks if a user has a specific type of alert (in this case, SMS) and returns a
     * boolean result and data if applicable.
     * 
     * @param string UserName A string representing the username of the user whose alert is being checked.
     * @param string AlertType The type of alert to check for, in this case it is 'sms'.
     * 
     * @return The function `check_user_has_alert` returns an array with two possible keys: `result` and
     * `data`. If the user does not have an alert of the specified type, the function returns an array with
     * `result` set to `false`. If the user has an alert of the specified type, the function returns an
     * array with `result` set to `true` and `data` containing
     */
    private function check_user_has_alert(string $UserName, string $AlertType)
    {
        switch ($AlertType) {
            case 'sms':
                $smsalert = metadata::where('tt', 'signalsmsalert')->where('fgstr', $UserName)->first();
                if ($smsalert == null) { // The user not has sms alert before
                    $Output = [
                        'result' => false
                    ];
                    return $Output;
                } else {
                    $Output = [
                        'result' => true,
                        'data' => $smsalert
                    ];
                    return $Output;
                }
        }
    }

    private function check_user_status(string $TargetUserId)
    {
        $UserInfoSrc = UserInfo::where('UserName', $TargetUserId)->first();
        if ($UserInfoSrc == null) {
            $Output = [
                'result' => false,
                'msg' => 'The user not exist'
            ];
            return $Output; // array message
        }
        $UserLicense = new UserLicense;
        $Lic = $UserLicense->is_user_has_lic($TargetUserId, 'send_signal_sms_alert');
        if ($Lic['result']) {
            $Output = [
                'result' => true,
                'FinancialType' => 1,
                'msg' => 'Special User'
            ];
            return $Output; // array message
        } else {
            return $Lic;
        }
    }

    /**
     * This PHP function sets an alert for a user when a signal is generated, based on their financial
     * type and whether they have already activated SMS alerts.
     * 
     * @param string TargetUs   erId The ID of the user for whom the alert needs to be set.
     * @param int FinancialType FinancialType is a parameter that determines the type of financial status
     * of the user. It is an integer value that can be either 0 or 1. If it is 0, the function checks the
     * user's status to assign a financial type. If it is 1, it means the user
     * 
     * @return an array message with either a 'result' key set to true or false, and additional data or
     * message depending on the conditions met in the function.
     */
    public function set_alert_user_when_signal_generate(string $TargetUserId, int $FinancialType = 0)
    {
        if ($FinancialType ==  0) { //Check User Status To assign Financial Type
            $UserCheck = $this->check_user_status($TargetUserId);
            if (!$UserCheck['result']) {
                return $UserCheck;
            } else {
                $FinancialType = $UserCheck['FinancialType'];
            }
        }

        if ($FinancialType ==  1) { // free of charge method for special users
            $UserBeforeAlert = $this->check_user_has_alert($TargetUserId, 'sms');
            if ($UserBeforeAlert['result']) { // the user active sms alert before
                $Result = [
                    'result' => false,
                    'msg' => 'The user has sms alert before'
                ];
                return $Result; // array message
            } else { // activate sms alert 
                $TargetUserSrc = UserInfo::where('UserName', $TargetUserId)->first();
                $CreateDate = new DateTime();
                $ExpireDate = new DateTime();
                $ExpireDate->add(new DateInterval('P30D'));
                $MetaValue = [
                    'Name' => $TargetUserSrc->Name,
                    'Family' => $TargetUserSrc->Family,
                    'ExpireDate' => $ExpireDate,
                    'CreateDate' => $CreateDate,
                ];
                $data = [
                    'tt' => 'signalsmsalert',
                    'fgstr' => $TargetUserId,
                    'fgint' => 13000, // for alerting code
                    'meta_key' => $TargetUserSrc->MobileNo,  //user mobile number
                    'meta_value' => json_encode($MetaValue)  //meta required data
                ];
                $InserResult = metadata::create($data);
                $Result = [
                    'result' => true,
                    'data' => $InserResult
                ];
                return $Result; // array message
            }
        }
    }

    /**
     * This PHP function deletes metadata related to signal SMS alerts for a specific user.
     * 
     * @param string TargetUserId A string representing the user ID of the target user for whom the alert
     * needs to be unset.
     * @param int FinancialType The parameter FinancialType is not used in the function and is therefore
     * irrelevant. It is declared as an integer type but is not used anywhere in the function.
     * 
     * @return An array message containing a boolean result and the data returned from the metadata
     * deletion query.
     */
    public function unset_alert_user_when_signal_generate(string $TargetUserId, int $FinancialType = 0)
    {
        $Result = metadata::where('tt', 'signalsmsalert')->where('fgstr', $TargetUserId)->delete();
        $OutPut = [
            'result' => true,
            'data' => $Result
        ];
        return $OutPut; // array message
    }
}
