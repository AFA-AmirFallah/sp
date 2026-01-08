<?php


namespace App\LicMgt;

use App\Models\UserInfo;
use stdClass;

class UserLicense
{
    /**
     * This function checks if a user has a specific license by searching for their username and the
     * license name in a database and returns a result with a message if the user does not exist or does
     * not have the license.
     * 
     * @param string UserName A string representing the username of the user whose license needs to be
     * checked.
     * @param string LicName LicName is a string parameter that represents the name of a license. It is
     * used in the is_user_has_lic function to check if a user has a specific license.
     * 
     * @return an array with a 'result' key indicating whether the user has the specified license or not,
     * and an optional 'msg' key providing additional information about the result.
     */
    public function is_user_has_lic(string $UserName, string $LicName)
    {
        $UserInfoSrc = UserInfo::where('UserName', $UserName)->first();
        if ($UserInfoSrc == null) {
            return [
                'result' => false,
                'msg' => 'the user not exist'
            ];
        }
        $UserLic = $UserInfoSrc->UserLic;
        if ($UserLic == null || $UserLic == '') {
            return [
                'result' => false,
                'msg' => 'The user has no lic'
            ];
        }
        $UserLic = json_decode($UserLic);
        if (isset($UserLic->$LicName)) {
            $LicContent = $UserLic->$LicName;
            $date_now = date("Y-m-d"); // this format is string comparable
            if ($date_now <= $LicContent->ExpireDate) {
                return [
                    'result' => true
                ];
            } else {
                return [
                    'result' => false,
                    'msg' => "The user $LicName license has expired"
                ];
            }
        } else {
            return [
                'result' => false,
                'msg' => "The user has not $LicName license"
            ];
        }
    }

    /**
     * The function adds a license to a user's account and updates the user's license information in
     * the database.
     * 
     * @param string UserName The username of the user for whom a license is being added.
     * @param string LicName LicName is a string parameter that represents the name of the license
     * being added to a user's account.
     * 
     * @return An array with two keys: 'result' and 'message'. The value of 'result' is a boolean true
     * and the value of 'message' is a string 'Operation successful'.
     */
    public function add_user_license(string $UserName, string $LicName)
    {
        $UserInfoSrc = UserInfo::where('UserName', $UserName)->first();
        $UserLic = $UserInfoSrc->UserLic;
        if ($UserLic == null || $UserLic == '') { // The user has no any license before
            $LicArray = new stdClass;
            $LicArray->$LicName = [
                'Name' => $LicName,
                'AddDate' => date('Y/m/d'),
                'ExpireDate' => date('Y/m/d', strtotime('+30 days'))
            ];
        } else { // The user has license before
            $LicArray = json_decode($UserLic);
            $LicArray->$LicName = [
                'Name' => $LicName,
                'AddDate' => date('Y/m/d'),
                'ExpireDate' => date('Y/m/d', strtotime('+30 days'))
            ];
        }
        $LicArray = json_encode($LicArray);
        $UserInfoSrc->update(['UserLic' => $LicArray]);
        return [
            'result' => true,
            'message' => 'Operation successful'
        ];
    }
}
