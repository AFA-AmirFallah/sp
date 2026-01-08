<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\DeviceContractType;
use App\Models\DeviceMeta;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use DB;

class DeviceManager extends Controller
{
    public function DeviceTarefe($contractid)
    {
        $DeviceMetas = DeviceMeta::all();
        $Query = "SELECT DeviceType.ID,DeviceType.MetaID, DeviceType.TypeID, DeviceType.DeviceName , DeviceContractItemPrice.Price, DeviceContractItemPrice.fixPrice FROM DeviceType left JOIN DeviceContractItemPrice ON DeviceType.ID = DeviceContractItemPrice.DeviceID and DeviceContractItemPrice.ContractType = $contractid where DeviceContractItemPrice.OwnerID = 1";
        $DeviceTypes = DB::select($Query);
        return view('Devices.DeviceTarefe', ['DeviceMetas' => $DeviceMetas,'DeviceTypes'=>$DeviceTypes]);
    }

    public function DoDeviceTarefe(Request $request)
    {
        dd($request->input());
    }

    public function DeviceContractEditor()
    {
        $DeviceContractTypes = DeviceContractType::all();
        return view('Devices.DeviceContractEditor', ['DeviceContractTypes' => $DeviceContractTypes]);
    }

    public function DoDeviceContractEditor(Request $request)
    {
        if ($request->input('submit') == 'addcontract') {
            if ($request->input('useable') == 'on') {
                $useable = 1;
            } else {
                $useable = 0;
            }
            $InputData = [
                'TypeName' => $request->input('TypeName'),
                'DurationDays' => $request->input('DurationDays'),
                'IsShow' => $useable
            ];
            $activity = DeviceContractType::create($InputData);
            if ($activity->exists) {
                return redirect()->back()->with("success", __('data has modify'));
            } else {
                return redirect()->back()->with("error", __("The error has accure in your requsest please try again or call to callcenter!"));
            }

        } elseif ($request->input('submit') == 'Editcontract') {
            $request->validate([
                'TypeName' => 'required',
                'DurationDays' => 'required'
            ], [
                'TypeName.required' => __("Enter") . __("Device Type") . __(" Is required!!"),
                'DurationDays.required' => __("Enter") . __("Number of rent days") . __(" Is required!!"),
            ]);
            if ($request->input('useable') == '0') {
                $useable = 1;
            } else {
                $useable = 0;
            }
            $InputData = [
                'TypeName' => $request->input('TypeName'),
                'DurationDays' => $request->input('DurationDays'),
                'IsShow' => $useable
            ];
            $activity = DeviceContractType::where('ID', $request->input('DeviceContractID'))->update($InputData);
            if ($activity) {
                return redirect()->back()->with("success", __('data has modify'));
            } else {
                return redirect()->back()->with("error", __("The error has accure in your requsest please try again or call to callcenter!"));
            }

        }
    }

    public function DeviceEditor()
    {
        $DeviceMetas = DeviceMeta::all();
        $DeviceTypes = DeviceType::all();
        return view("Devices.DeviceEditor", ['DeviceMetas' => $DeviceMetas, 'DeviceTypes' => $DeviceTypes]);
    }

    public function DoDeviceEditor(Request $request)
    {
        if ($request->input('submit') == 'AddMetaDevice') {
            $request->validate([
                'DeviceName' => 'required'
            ], [
                'DeviceName.required' => __("Enter") . __("Device Type") . __(" Is required!!"),
            ]);
            $DataRow = [
                'DeviceName' => $request->input('DeviceName')
            ];
            DeviceMeta::create($DataRow);
            return redirect()->back()->with("success", __("success alert"));

        } elseif ($request->input('submit') == "EditeMetaDevice") {
            $request->validate([
                'DeviceName' => 'required'
            ], [
                'DeviceName.required' => __("Enter") . __("Device Type") . __(" Is required!!"),
            ]);
            $DataRow = [
                'DeviceName' => $request->input('DeviceName')
            ];
            $result = DeviceMeta::where('ID', $request->input('metadeviceid'))->update($DataRow);
            if ($result == 1) {
                return redirect()->back()->with("success", __("success alert"));
            } else {
                return redirect()->back()->with("error", __("The error has accure in your requsest please try again or call to callcenter!"));
            }
        } elseif ($request->input('submit') == 'AddModelDevice') {
            $request->validate([
                'DeviceName' => 'required'
            ], [
                'DeviceName.required' => __("Enter") . __("Device model") . __(" Is required!!"),
            ]);
            $maxID = DeviceType::where('MetaID', $request->input('DeviceType'))->max('TypeID');
            if ($maxID != null) {
                $maxID++;
            } else {
                $maxID = 1;
            }
            $InputData = [
                'MetaID' => $request->input('DeviceType'),
                'TypeID' => $maxID,
                'DeviceName' => $request->input('DeviceName')
            ];
            $activity = DeviceType::create($InputData);
            if ($activity->exists) {
                return redirect()->back()->with("success", __('data has modify'));
            } else {
                return redirect()->back()->with("error", __("The error has accure in your requsest please try again or call to callcenter!"));
            }


        } elseif ($request->input('submit') == 'EditModelDevice') {
            $request->validate([
                'DeviceName' => 'required'
            ], [
                'DeviceName.required' => __("Enter") . __("Device model") . __(" Is required!!"),
            ]);
            $InputData = [
                'DeviceName' => $request->input('DeviceName')
            ];

            $request = DeviceType::where('ID', $request->input('DeviceModel'))->update($InputData);
            if ($request) {
                return redirect()->back()->with("success", __('data has modify'));
            } else {
                return redirect()->back()->with("error", __("The error has accure in your requsest please try again or call to callcenter!"));
            }

        }
    }
}
