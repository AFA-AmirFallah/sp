<?php

namespace App\Functions;

use App\Models\UserInfo;
use DateTime;
use Auth;
use App\myappenv;
use App\Models\RespnsType;
class ServiceClass{

public function add_new_shift($Worker,$RequestUser,$StartRespns ,$RespnsType, $EndRespns,$Note , $Branch = 1){

      
        $WorkerInfo = UserInfo::where("UserName", $Worker)->first();
        $RequestUserInfo = UserInfo::where("UserName", $RequestUser)->first();
        if ($WorkerInfo != null) {
            $Status = $WorkerInfo->Status;
            if ($Status > 100) { //Valid worker
                $ResponserID = $Worker;
                $curDateTime = date("Y-m-d H:i:s");
                $inputdate = new DateTime($StartRespns);
                $inputdate = $inputdate->format("Y-m-d H:i:s");
                $MySetting = new AppSetting();
                $ShiftWithPasteTime = $MySetting->GetSettingValue('ShiftWithPasteTime');
                if ($curDateTime <= $inputdate || Auth::User()->Role == myappenv::role_SuperAdmin || $ShiftWithPasteTime == 'true') {
                    $nowdate = date('Y-m-d H:i:s');
                    if ($RequestUserInfo != null) {
                        
                        $SelectedService = RespnsType::where('ID', $RespnsType)->first();
                        $CreditIndex = $SelectedService->UserCreditIndex;
                        $CreditePlan = $RequestUserInfo->CreditePlan;
                        $Transfer = new Transfer($RequestUser, $ResponserID, $nowdate, Auth::id(), $StartRespns, $EndRespns, $RespnsType, $Note, $Holders, $CreditePlan, $Branch ,$CreditIndex );
                        if ($Transfer->TransferShift()) {
                            $Qwnername = $RequestUserInfo->Name . " " . $RequestUserInfo->Family;
                            $OwnerMobile = $RequestUserInfo->MobileNo;
                            $Position = $SelectedService->RespnsTypeName;
                            $responserName = $WorkerInfo->Name . ' ' . $WorkerInfo->Family;
                            $RespnserMobile = $WorkerInfo->MobileNo;
                        } else {
                            return redirect()->back()->with('error', __('error alert'));
                        }
                        $Mytext = new TextClassMain();
                        if ($RespnsType < 100) {
                            $responserText = $Mytext->SetShiftResponserSMS($SelectedService->RespnsTypeName, $Qwnername, myappenv::CenterPhone, myappenv::CenterEndSmsTxt);
                            $ownerText = $Mytext->SetShiftOwnerSMS($responserName, $Position, myappenv::CenterEndSmsTxt);
                        } else {

                            $ownerText = str_replace("*", "", $ownerText);
                            $NoteText = "انجام خدمت توسط:";
                            $NoteText .= " $responserName ";
                            $NoteText .= " گیرنده خدمت: ";
                            $NoteText .= " $Qwnername ";
                            $NoteText .= " نوع خدمت: ";
                            $NoteText .= " $Position ";
                            $NoteText .= " Create By System";
                            $NoteText .= " تاریخ شروع: ";
                            $NoteText .= " $StartDateShamsi ";
                            $NoteText .= " تاریخ پایان: ";
                            $NoteText .= " $EndDateShamsi ";
                            $Transfer->SetTrasactionNote($NoteText);
                            $lessMony = $SelectedService->CustomerfixPrice;
                            $CreditModQuery = "SELECT CreditMod FROM usercreditsummery WHERE UserName = '$RequestUser' and CreditMod != 2 and SUMMony >= $lessMony";
                            $CreditResult = DB::select($CreditModQuery);
                            $CreditResult = usercreditsummery::where('UserName', $RequestUser)->where('CreditMod', '!=', 2)->where('CreditMod', '!=', 1)->where('SUMMony', '>=', $lessMony)->first();
                            if ($CreditResult == null) {
                                $CreditMeta = 1;
                            } else {
                                $CreditMeta = $CreditResult->CreditMod;
                            }
                            $HaveCreditMeta = FALSE;
                            $Transfer->SetCreditMode($CreditMeta);
                            if ($SelectedService->hPrice == $SelectedService->CustomerhPrice and $SelectedService->CustomerhPrice == 0) {
                                //fix Price
                                $lessMony = $SelectedService->CustomerfixPrice * (-1);
                                if ($lessMony != 0) {
                                    $Transfer->SetLessMony($lessMony);

                                    $Transfer->AddMonyToWorkers($SelectedService->fixPrice);

                                    $Transfer->TransferWithPrice();
                                }
                            } elseif ($SelectedService->fixPrice == $SelectedService->CustomerfixPrice and $SelectedService->CustomerfixPrice == 0) {
                                //H Price
                                $hourdiff = round((strtotime($EndRespns) - strtotime($StartRespns)) / 3600, 1);
                                $lessMony = $SelectedService->CustomerhPrice * (-1) * $hourdiff;
                                if ($lessMony != 0) {
                                    $Transfer->SetLessMony($lessMony);
                                    $AddMony = $SelectedService->hPrice * $hourdiff;
                                    $Transfer->AddMonyToWorkers($AddMony);
                                    $Transfer->TransferWithPrice();
                                }
                            }
                        }
                        $MySMS = new SmsCenter();
                        if (\App\myappenv::Lic['HCIS_Workflow']) {
                            $MyWorkFlow = new Workflow();
                            $WorkFlowText = ' ثبت شیفت  : <br>';
                            $NoteText = "انجام خدمت توسط:";
                            $NoteText .= " $responserName ";
                            $NoteText .= " گیرنده خدمت: ";
                            $NoteText .= " $Qwnername ";
                            $NoteText .= " نوع خدمت: ";
                            $NoteText .= " $Position ";
                            $NoteText .= " Create By System";
                            $NoteText .= " تاریخ شروع: ";
                            $NoteText .= " $StartDateShamsi ";
                            $NoteText .= " تاریخ پایان: ";
                            $NoteText .= " $EndDateShamsi ";

                            $WorkFlowText .= $NoteText;
                            $MyWorkFlow->AddWorkFlow($RequestUser, Auth::id(), $WorkFlowText);
                        }

                        if ($RespnsType < 10000) {

                            $MySMS->OndemandSMS($ownerText, $OwnerMobile, 'Shift', $RequestUser);
                        }
                        $MySMS->OndemandSMS($responserText, $RespnserMobile, 'Shift', $ResponserID);
                        return redirect()->back()->with('success', __("success alert"));
                    } else {
                        return redirect()->back()->with('error', __("the user name dos not exist"));
                    }
                } else {
                    return redirect()->back()->with("error", __('The input time is not valid'));
                }
            } else {
                return redirect()->back()->with("error", __('the selected personel is not valid'));
            }
        }
}

}