<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting;
use App\view_counter\View_counter;
use Illuminate\Http\Request;
use App\Functions\AppSetting;
use App\Functions\CacheData;
use App\Http\Controllers\News\NewsAdmin;
use App\Models\posts;
use Cache;

class SettingManagement extends Controller
{
    public function systemsetting()
    {
        return view("Setting.AdvanceSetting");
    }
    public function Dosystemsetting(Request $request)
    {
        if ($request->has('submit')) {
            $Switch = $request->input('submit');
            exec("cd .. ; sh PlatformScripts.sh $Switch", $output);
            echo "cd .. ; sh PlatformScripts.sh $Switch";
        }
        foreach ($output as $outputItem) {
            echo $outputItem . '<br>';
        }
        $href = route('systemsetting');
        echo "<a href='$href' > بازگشت </a>";

    }
    public static function GetSettingValue($name)
    {
        $SettingVal = setting::where('name', $name)->first();
        if ($SettingVal == null) {
            return null;
        } else {
            return $SettingVal->value;
        }
    }
    public static function GetSiteRole()
    {
        $PostCode = SettingManagement::GetSettingValue('Rolls');
        if ($PostCode == null) {
            return null;
        } else {
            return posts::where('id', $PostCode)->first();
        }
    }
    public function MainSetting()
    {

        $SettingSrc = setting::get()->toArray();
        //dd($SettingSrc , array_search('number_to_point', array_column($SettingSrc, 'name')),$SettingSrc[1]['name'] );
        return view('Setting.MainSetting', ['SettingSrc' => $SettingSrc]);
    }
    public function DoMainSetting(Request $request)
    {

        if ($request->input('submit') == 'flush') {
            AppSetting::ClearCache();
            return redirect()->back()->with('success', 'کش پلتفرم خذف گردید!');
        }
        if ($request->input('submit') == 'comment_reset') {
            $news = new NewsAdmin;
            $news->udpdate_all_post_comment_count();
            return redirect()->back()->with('success', '  تعداد کامنت ها به روز  گردید!');
        }
        $name = $request->input('submit');
        $value = $request->input($name);
        $Result = CacheData::PutSetting($name, $value);
        if ($name == 'view_count_days') {
            $views = new View_counter;
            $views->aggregate_view_counter();
        }
        if ($Result) {
            return redirect()->back()->with('success', 'تنظیمات انجام گردید!');
        }

    }
    public function PatientSetting()
    {
        $MySetting = new AppSetting();
        $ShiftWithPasteTime = $MySetting->GetSettingValue('ShiftWithPasteTime');

        return view('Setting.PatientSetting', ['ShiftWithPasteTime' => $ShiftWithPasteTime]);
    }

    public function DoPatientSetting(Request $request)
    {
        if ($request->has('submit')) {
            $UpdateValue = [
                'value' => $request->input('value')
            ];
            setting::where('name', $request->input('submit'))->update($UpdateValue);
        }
        return redirect()->back()->with("success", __("success alert"));
    }

    public function FinancialSetting()
    {
        $MySetting = new AppSetting();
        $MaliSort = $MySetting->GetSettingValue('MaliSort');
        $TransactionSendSMS = $MySetting->GetSettingValue('TransactionSendSMS');
        $DoubleConfirm = $MySetting->GetSettingValue('DoubleConfirm');
        return view('Setting.FinancialSetting', ['MaliSort' => $MaliSort, 'DoubleConfirm' => $DoubleConfirm, 'TransactionSendSMS' => $TransactionSendSMS]);
    }

    public function DoFinancialSetting(Request $request)
    {
        if ($request->has('submit')) {
            $UpdateValue = [
                'value' => $request->input('value')
            ];
            setting::where('name', $request->input('submit'))->update($UpdateValue);
        }
        return redirect()->back()->with("success", __("success alert"));
    }
}
