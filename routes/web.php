<?php

use App\Http\Controllers\security\soc;
use App\Http\Middleware\Lic;

use Illuminate\Support\Facades\Route;

$MySequrity = new soc();
$MySequrity->RouteValidator();


Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
/*
Route::get('send-mail', function () {
    \Mail::to('afa.private@gmail.com')->send(new \App\Mail\MyTestMail());
    dd("Email is Sent.");
});

*/

Route::get('finpay', [\App\Http\Controllers\Credit\DirectPayment::class, 'finpay'])->name('finpay');
Route::get('ikc', [\App\Http\Controllers\APIS\IKC::class, 'main'])->name('ikc');
Route::get('Debug327362/{State?}', [\App\Http\Controllers\setting\debuger::class, 'debugger'])->name('debugger');
Route::post('Debug327362/{State?}', [\App\Http\Controllers\setting\debuger::class, 'Dodebugger']);
if (Lic::check('sitemap')) {
    require __DIR__ . '/web_sitemap.php';
}
Route::get('wordpress/{State}', [\App\Http\Controllers\APIS\wordpress::class, 'main'])->name('wordpress');
Route::get('login/{BranchName?}', [\App\Http\Controllers\Auth\UserController::class, 'Login'])->name('login');
Route::post('login/{BranchName?}', [\App\Http\Controllers\Auth\UserController::class, 'DoLogin']);
Route::get('logout', [\App\Http\Controllers\Auth\UserController::class, 'logout'])->name('logout');
if (\App\myappenv::AuthType == 2) {
    Route::get('register', [\App\Http\Controllers\Auth\UserController::class, 'Register'])->name('register');
    Route::post('register', [\App\Http\Controllers\Auth\UserController::class, 'DoRegister']);
    Route::get('forgot', [\App\Http\Controllers\Auth\UserController::class, 'forgot'])->name('forgot');
    Route::post('forgot', [\App\Http\Controllers\Auth\UserController::class, 'DoForgot']);
}
Route::any('captcha-refresh', function () {
    $form = captcha_img();
    return $form;
});
Route::any('captcha-test', function () {
    if (request()->getMethod() == 'POST') {
        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(request()->all(), $rules);
        if ($validator->fails()) {
            echo '<p style="color: #ff0000;">Incorrect!</p>';
        } else {
            echo '<p style="color: #00ff30;">Matched :)</p>';
        }
    }

    $form = '<form method="post" action="captcha-test">';
    $form .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    $form .= '<p>' . captcha_img() . '</p>';
    $form .= '<p><input type="text" name="captcha"></p>';
    $form .= '<p><button type="submit" name="check">Check</button></p>';
    $form .= '</form>';
    return $form;
});
Route::get('/refresh-captcha', [\App\Http\Controllers\FormController::class, 'refreshCaptcha']);
Route::get('maps', [\App\Http\Controllers\map\mapmain::class, 'ShowMap'])->name('maps');
Route::get('ContactUs', [\App\Http\Controllers\Consult\ConsultMain::class, 'ContactUs'])->name('ContactUs');
Route::post('ContactUs', [\App\Http\Controllers\Consult\ConsultMain::class, 'DoContactUs']);
Route::get('RegisterForm/{RegType}', [\App\Http\Controllers\Order\RegisterForm::class, 'RegisterForm'])->name('RegisterForm');
Route::post('RegisterForm/{RegType}', [\App\Http\Controllers\Order\RegisterForm::class, 'DoRegisterForm']);
Route::get('search', [\App\Http\Controllers\search\MainSearch::class, 'search'])->name('search');
Route::get('mainpage', [\App\Http\Controllers\site\main::class, 'mainpage'])->name('mainpage');
Route::post('changecurrency', [\App\Http\Controllers\Credit\currency::class, 'SetCurrency'])->name('changecurrency');
Route::get('mapsfind', [\App\Http\Controllers\map\mapmain::class, 'mapsfind'])->name('mapsfind');
Route::post('ajax', [\App\Http\Controllers\APIS\AJAX::class, 'main'])->name('ajax');
Route::get('ajax', [\App\Http\Controllers\APIS\AJAX::class, 'main']);


Route::get('/ConfirmIPG/{Token}', [\App\Http\Controllers\Credit\DirectPayment::class, 'ConfirmIPG'])->name('ConfirmIPG');
Route::get('/selfpay/{id}', [\App\Http\Controllers\Credit\DirectPayment::class, 'selfpay'])->name('selfpay');
Route::post('/selfpay/{id}', [\App\Http\Controllers\Credit\DirectPayment::class, 'Doselfpay']);
Route::get('/Invoice/{Invoice?}', [\App\Http\Controllers\Credit\Invoice::class, 'Invoice'])->name('Invoice');
Route::post('/Invoice/{Invoice?}', [\App\Http\Controllers\Credit\Invoice::class, 'DoInvoice']);
Route::get('/Kasrazhoghogh/{Kasrazhoghogh?}', [\App\Http\Controllers\Credit\Invoice::class, 'Invoice'])->name('Kasrazhoghogh');
Route::post('/Kasrazhoghogh/{Kasrazhoghogh?}', [\App\Http\Controllers\Credit\Invoice::class, 'DoInvoice']);
Route::get('/PostReceipt/{PostReceipt?}', [\App\Http\Controllers\Credit\Invoice::class, 'Invoice'])->name('PostReceipt');
Route::post('/PostReceipt/{PostReceipt?}', [\App\Http\Controllers\Credit\Invoice::class, 'DoInvoice']);
Route::get('/Order/{OrderID?}', [\App\Http\Controllers\Order\OrderMain::class, 'Order'])->name('Order');
Route::post('/Order/{OrderID?}', [\App\Http\Controllers\Order\OrderMain::class, 'DoOrder']);
Route::get('/CustomerOrder/{OrderID?}', [\App\Http\Controllers\Order\OrderMain::class, 'CustomerOrder'])->name('CustomerOrder');
Route::post('/CustomerOrder/{OrderID?}', [\App\Http\Controllers\Order\OrderMain::class, 'DoCustomerOrder']);
require __DIR__ . '/web_forms.php';
if (Lic::check('woocommerce')) {
    require __DIR__ . '/web_woocommerce.php';
}
if (Lic::check('Voip')) {
    require __DIR__ . '/web_voip.php';
}
if (Lic::check('auto')) {
    require __DIR__ . '/web_auto.php';
}

if (\App\myappenv::Lic['CustomerUpload']) {
    require __DIR__ . '/web_CustomerUpload.php';
}
if (\App\myappenv::Lic['hiring']) {
    require __DIR__ . '/web_hiring.php';
}

if (\App\myappenv::Lic['news']) {
    require __DIR__ . '/web_news.php';
}
Route::get('changeview/{Target}', [\App\Http\Controllers\Dashboard\Dashboard::class, 'changeview'])->name('changeview');
Route::post('', [\App\Http\Controllers\spa\main_spa::class, 'handler']);
if (\App\myappenv::MainPage == 'dashboard') {
    Route::get('', [\App\Http\Controllers\Dashboard\Dashboard::class, 'Main'])->name('home');
} elseif (\App\myappenv::MainPage == 'news') {
    Route::get('', [\App\Http\Controllers\News\NewsItems::class, 'NewsHome'])->name('home');
}
if (\App\myappenv::Lic['moshavereh']) {
    require __DIR__ . '/web_moshavereh.php';
}

if (Lic::check('wpa')) {
    require __DIR__ . '/web_wpa.php';
}
if (\App\myappenv::Lic['crypto']) {
    require __DIR__ . '/web_crypto.php';
}
if (Lic::check('crawler')) {
    require __DIR__ . '/web_crawler.php';
}
if (\App\myappenv::Lic['SmartInvoice']) {
    require __DIR__ . '/web_SmartInvoice.php';
}
if (\App\myappenv::Lic['TavanPardakht']) {
    require __DIR__ . '/web_TavanPardakht.php';
}
if (\App\myappenv::Lic['HCIS_Workflow']) {
    require __DIR__ . '/web_HCIS_Workflow.php';
}
if (\App\myappenv::Lic['deal']) {
    require __DIR__ . '/web_deal.php';
}
if (\App\myappenv::Lic['statistic']) {
    require __DIR__ . '/web_statistic.php';
}


Route::get('show/{username}/{file_name}', [\App\Http\Controllers\show_files::class, 'show'])->name('show');
Route::get('PersonelCard/{RequestUser}', [\App\Http\Controllers\Users\UserManagement::class, 'PersonelCard'])->name('PersonelCard');
Route::post('PersonelCard/{RequestUser}', [\App\Http\Controllers\Users\UserManagement::class, 'DoPersonelCard']);
Route::post('container', [\App\Http\Controllers\container\container_main::class, 'container']);
Route::group(['middleware' => 'UserAccessShopOwner'], function () {
    Route::get('/tiketsetting', [\App\Http\Controllers\Tiket\TiketMain::class, 'ticketsetting'])->name('tiketsetting');
    Route::post('/tiketsetting', [\App\Http\Controllers\Tiket\TiketMain::class, 'Doticketsetting']);
    Route::get('/BranchSetting', [\App\Http\Controllers\branch\BranchSetting::class, 'BranchSetting'])->name('BranchSetting');
    Route::post('/BranchSetting', [\App\Http\Controllers\branch\BranchSetting::class, 'DoBranchSetting']);
    Route::get('/FinancialIndex', [\App\Http\Controllers\index\FinancialIndex::class, 'FinancialIndex'])->name('FinancialIndex');
    Route::post('/FinancialIndex', [\App\Http\Controllers\index\FinancialIndex::class, 'DoFinancialIndex']);
    Route::get('/ServiceList', [\App\Http\Controllers\Service\ManageService::class, 'ServiceList'])->name('ServiceList');
    Route::get('/Addservice', [\App\Http\Controllers\Service\ManageService::class, 'Addservice'])->name('Addservice');
    Route::post('/Addservice', [\App\Http\Controllers\Service\ManageService::class, 'DoAddservice']);
    Route::get('/Editservice/{ServiceID}', [\App\Http\Controllers\Service\ManageService::class, 'Editservice'])->name('Editservice');
    Route::post('/Editservice/{ServiceID}', [\App\Http\Controllers\Service\ManageService::class, 'DoEditservice']);
    Route::get('/CatOrderList', [\App\Http\Controllers\Service\ManageService::class, 'CatOrderList'])->name('CatOrderList');
    Route::get('/AddCatOrder', [\App\Http\Controllers\Service\ManageService::class, 'AddCatOrder'])->name('AddCatOrder');
    Route::post('/AddCatOrder', [\App\Http\Controllers\Service\ManageService::class, 'DoAddCatOrder']);
    Route::get('/EditCatOrder/{ID}', [\App\Http\Controllers\Service\ManageService::class, 'EditCatOrder'])->name('EditCatOrder');
    Route::post('/EditCatOrder/{ID}', [\App\Http\Controllers\Service\ManageService::class, 'DoEditCatOrder']);
    Route::get('CahngeTransaction', [\App\Http\Controllers\Credit\CreditTransfer::class, 'CahngeTransaction'])->name('CahngeTransaction');
    Route::post('CahngeTransaction', [\App\Http\Controllers\Credit\CreditTransfer::class, 'DoCahngeTransaction']);
});
Route::group(['middleware' => 'UserAccessSuperAdmin'], function () {
    Route::get('/Import/{ID?}', [\App\Http\Controllers\import_export\import_main::class, 'Import'])->name('Import');
    Route::post('/Import/{ID?}', [\App\Http\Controllers\import_export\import_main::class, 'DoImport']);

    if (\App\myappenv::Lic['userlic']) {
        Route::get('/AddLic', [\App\Http\Controllers\Users\UserLicenseManagement::class, 'AddLic'])->name('AddLic');
        Route::post('/AddLic', [\App\Http\Controllers\Users\UserLicenseManagement::class, 'DoAddLic']);
    }
    if (\App\myappenv::version >= 3) {
        Route::get('/branch_order_req', [\App\Http\Controllers\Service\ManageService::class, 'branch_order_req'])->name('branch_order_req');
        Route::post('/branch_order_req', [\App\Http\Controllers\Service\ManageService::class, 'do_branch_order_req']);
    }

    Route::get('/ExamAdmin', [\App\Http\Controllers\exam\ExamAdmin::class, 'ExamAdmin'])->name('ExamAdmin');
    Route::post('/ExamAdmin', [\App\Http\Controllers\exam\ExamAdmin::class, 'DoExamAdmin']);
    Route::get('/ExamItems/{ExamID}', [\App\Http\Controllers\exam\ExamAdmin::class, 'ExamItems'])->name('ExamItems');
    Route::post('/ExamItems/{ExamID}', [\App\Http\Controllers\exam\ExamAdmin::class, 'DoExamItems']);
    Route::get('/ThemeMgt', [\App\Http\Controllers\Themes\ThemeMgt::class, 'ThemeMgt'])->name('ThemeMgt');
    Route::post('/ThemeMgt', [\App\Http\Controllers\Themes\ThemeMgt::class, 'DoThemeMgt']);
    Route::get('/mytheme', [\App\Http\Controllers\Themes\ThemeMgt::class, 'ThemeMgt'])->name('mytheme');
    Route::post('/mytheme', [\App\Http\Controllers\Themes\ThemeMgt::class, 'DoThemeMgt']);
    Route::get('/ThemeObjectMgt/{Theme}', [\App\Http\Controllers\Themes\ThemeMgt::class, 'ThemeObjectMgt'])->name('ThemeObjectMgt');
    Route::post('/ThemeObjectMgt/{Theme}', [\App\Http\Controllers\Themes\ThemeMgt::class, 'DoThemeObjectMgt']);
    Route::get('/mythemeo/{Theme}', [\App\Http\Controllers\Themes\ThemeMgt::class, 'ThemeObjectMgt'])->name('mythemeo');
    Route::post('/mythemeo/{Theme}', [\App\Http\Controllers\Themes\ThemeMgt::class, 'DoThemeObjectMgt']);
    Route::get('/CreditModCreate', [\App\Http\Controllers\Credit\Accounts::class, 'CreditModCreate'])->name('CreditModCreate');
    Route::post('/CreditModCreate', [\App\Http\Controllers\Credit\Accounts::class, 'DoCreditModCreate']);
    Route::get('TashimMgt', [\App\Http\Controllers\Credit\Tashim::class, 'TashimMgt'])->name('TashimMgt');
    Route::post('TashimMgt', [\App\Http\Controllers\Credit\Tashim::class, 'DoTashimMgt']);
    Route::get('AddTashim', [\App\Http\Controllers\Credit\Tashim::class, 'AddTashim'])->name('AddTashim');
    Route::post('AddTashim', [\App\Http\Controllers\Credit\Tashim::class, 'DoAddTashim']);
    Route::get('EditTashim/{TashimId}', [\App\Http\Controllers\Credit\Tashim::class, 'EditTashim'])->name('EditTashim');
    Route::post('EditTashim/{TashimId}', [\App\Http\Controllers\Credit\Tashim::class, 'DoEditTashim']);
    Route::get('KarmozdMgt', [\App\Http\Controllers\Credit\Karmozd::class, 'KarmozdMgt'])->name('KarmozdMgt');
    Route::post('KarmozdMgt', [\App\Http\Controllers\Credit\Karmozd::class, 'DoKarmozdMgt']);
    Route::get('systemsetting', [\App\Http\Controllers\setting\SettingManagement::class, 'systemsetting'])->name('systemsetting');
    Route::post('systemsetting', [\App\Http\Controllers\setting\SettingManagement::class, 'Dosystemsetting']);
    Route::get('MainSetting', [\App\Http\Controllers\setting\SettingManagement::class, 'MainSetting'])->name('MainSetting');
    Route::post('MainSetting', [\App\Http\Controllers\setting\SettingManagement::class, 'DoMainSetting']);
    Route::get('FinancialSetting', [\App\Http\Controllers\setting\SettingManagement::class, 'FinancialSetting'])->name('FinancialSetting');
    Route::post('FinancialSetting', [\App\Http\Controllers\setting\SettingManagement::class, 'DoFinancialSetting']);
    Route::get('PatientSetting', [\App\Http\Controllers\setting\SettingManagement::class, 'PatientSetting'])->name('PatientSetting');
    Route::post('PatientSetting', [\App\Http\Controllers\setting\SettingManagement::class, 'DoPatientSetting']);
    Route::get('/DeviceEditor', [\App\Http\Controllers\Device\DeviceManager::class, 'DeviceEditor'])->name('DeviceEditor');
    Route::post('/DeviceEditor', [\App\Http\Controllers\Device\DeviceManager::class, 'DoDeviceEditor']);
    Route::get('/DeviceContractEditor', [\App\Http\Controllers\Device\DeviceManager::class, 'DeviceContractEditor'])->name('DeviceContractEditor');
    Route::post('/DeviceContractEditor', [\App\Http\Controllers\Device\DeviceManager::class, 'DoDeviceContractEditor']);
    Route::get('/DeviceTarefe/{contractid}', [\App\Http\Controllers\Device\DeviceManager::class, 'DeviceTarefe'])->name('DeviceTarefe');
    Route::post('/DeviceTarefe/{contractid}', [\App\Http\Controllers\Device\DeviceManager::class, 'DoDeviceTarefe']);
    Route::get('BranchOrders', [\App\Http\Controllers\woocommerce\product::class, 'BranchOrders'])->name('BranchOrders');
    Route::post('BranchOrders', [\App\Http\Controllers\woocommerce\product::class, 'DoBranchOrders']);
    if (\App\myappenv::Apptype == "owner") {
        Route::get('ManageIndex', [\App\Http\Controllers\index\mainindex::class, 'Serviceindex'])->name('ManageIndex');
        Route::post('ManageIndex', [\App\Http\Controllers\index\mainindex::class, 'DoServiceindex']);
    }
});
Route::group(['middleware' => 'UserAccessHR'], function () {
});

Route::group(['middleware' => 'UserAccessFinancialManager'], function () {
    Route::get('/BankCreate', [\App\Http\Controllers\Users\UserManagement::class, 'BankCreate'])->name('BankCreate');
    Route::post('/BankCreate', [\App\Http\Controllers\Users\UserManagement::class, 'DoBankCreate']);
    Route::get('/BankList', [\App\Http\Controllers\Users\UserManagement::class, 'BankList'])->name('BankList');
    Route::post('/BankList', [\App\Http\Controllers\Users\UserManagement::class, 'DoBankList']);
    Route::get('IPGReport', [\App\Http\Controllers\Credit\Reports::class, 'IPGReport'])->name('IPGReport');
    Route::post('IPGReport', [\App\Http\Controllers\Credit\Reports::class, 'DoIPGReport']);
    Route::get('DaramadReport', [\App\Http\Controllers\Credit\Reports::class, 'DaramadReport'])->name('DaramadReport');
    Route::post('DaramadReport', [\App\Http\Controllers\Credit\Reports::class, 'DoDaramadReport']);
    Route::get('CreditIndexReport', [\App\Http\Controllers\Credit\Reports::class, 'CreditIndexReport'])->name('CreditIndexReport');
    Route::post('CreditIndexReport', [\App\Http\Controllers\Credit\Reports::class, 'DoCreditIndexReport']);
    Route::get('FinancialTotalReport', [\App\Http\Controllers\Credit\Reports::class, 'FinancialTotalReport'])->name('FinancialTotalReport');
    Route::post('FinancialTotalReport', [\App\Http\Controllers\Credit\Reports::class, 'DoFinancialTotalReport']);
    Route::get('reports', [\App\Http\Controllers\reports\ReportMain::class, 'reports'])->name('reports');
    Route::post('reports', [\App\Http\Controllers\reports\ReportMain::class, 'Doreports']);

    Route::get('/AccountConfirm', [\App\Http\Controllers\Credit\Accounts::class, 'AccountConfirm'])->name('AccountConfirm');
    Route::post('/AccountConfirm', [\App\Http\Controllers\Credit\Accounts::class, 'DoAccountConfirm']);
});
Route::group(['middleware' => 'UserAccessAdmin'], function () {

    Route::get('/CrediteTransferConfirmserv', [\App\Http\Controllers\Credit\CreditTransfer::class, 'CrediteTransferConfirmsrv'])->name('CrediteTransferConfirmserv');
    Route::post('/CrediteTransferConfirmserv', [\App\Http\Controllers\Credit\CreditTransfer::class, 'DoCrediteTransferConfirmsrv']);
    Route::get('/CrediteTransferConfirm', [\App\Http\Controllers\Credit\CreditTransfer::class, 'CrediteTransferConfirm'])->name('CrediteTransferConfirm');
    Route::post('/CrediteTransferConfirm', [\App\Http\Controllers\Credit\CreditTransfer::class, 'DoCrediteTransferConfirm']);
    Route::get('FaildBuy/{id?}', [\App\Http\Controllers\Order\OrderMain::class, 'FaildBuy'])->name('FaildBuy');
    Route::post('FaildBuy/{id?}', [\App\Http\Controllers\Order\OrderMain::class, 'DoFaildBuy']);
    Route::get("/StoreAdd", [\App\Http\Controllers\woocommerce\store::class, 'StoreAdd'])->name("StoreAdd");
    Route::post('/StoreAdd', [\App\Http\Controllers\woocommerce\store::class, 'DoStoreAdd']);
    Route::get('AddCampin', [\App\Http\Controllers\woocommerce\campinmain::class, 'AddCampin'])->name('AddCampin');
    Route::post('AddCampin', [\App\Http\Controllers\woocommerce\campinmain::class, 'DoAddCampin']);
    Route::get('CampinLsit', [\App\Http\Controllers\woocommerce\campinmain::class, 'CampinLsit'])->name('CampinLsit');
    Route::post('CampinLsit', [\App\Http\Controllers\woocommerce\campinmain::class, 'DoCampinLsit']);
    Route::get('cashier', [\App\Http\Controllers\cashier\cashier::class, 'cashier'])->name('cashier');
    Route::post('cashier', [\App\Http\Controllers\cashier\cashier::class, 'Docashier']);
    Route::get('ProductIndex/{id}/{iframe?}', [\App\Http\Controllers\woocommerce\product::class, 'ProductIndex'])->name('ProductIndex');
    Route::post('ProductIndex/{id}/{iframe?}', [\App\Http\Controllers\woocommerce\product::class, 'DoProductIndex']);
    Route::get("/Warehouse/{StoreID}", [\App\Http\Controllers\woocommerce\store::class, 'Warehouse'])->name("Warehouse");
    Route::post('/Warehouse/{StoreID}', [\App\Http\Controllers\woocommerce\store::class, 'DoWarehouse']);
    Route::get("/WarehouseManagement/{StoreID}", [\App\Http\Controllers\woocommerce\store::class, 'WarehouseManagement'])->name("WarehouseManagement");
    Route::post('/WarehouseManagement/{StoreID}', [\App\Http\Controllers\woocommerce\store::class, 'DoWarehouseManagement']);
    Route::get("/WarehouseReport/{warehouseid}", [\App\Http\Controllers\woocommerce\store::class, 'WarehouseReport'])->name("WarehouseReport");
    Route::post('/WarehouseReport/{warehouseid}', [\App\Http\Controllers\woocommerce\store::class, 'DoWarehouseReport']);
    Route::get("/StoreList", [\App\Http\Controllers\woocommerce\store::class, 'StoreList'])->name("StoreList");
    Route::post('/StoreList', [\App\Http\Controllers\woocommerce\store::class, 'DoStoreList']);
    Route::get('AsnadMali', [\App\Http\Controllers\Credit\CreditTransfer::class, 'AsnadMali'])->name('AsnadMali');
    Route::post('AsnadMali', [\App\Http\Controllers\Credit\CreditTransfer::class, 'DoAsnadMali']);
    Route::get('makenotification', [\App\Http\Controllers\notification\notification_main::class, 'makenotification'])->name('makenotification');
    Route::post('makenotification', [\App\Http\Controllers\notification\notification_main::class, 'Domakenotification']);
    Route::get('notifications', [\App\Http\Controllers\notification\notification_main::class, 'notifications'])->name('notifications');
    Route::post('notifications', [\App\Http\Controllers\notification\notification_main::class, 'Donotifications']);
    Route::get('PatShiftManage/{RequestUser}', [\App\Http\Controllers\Patients\PatShift::class, 'ShiftOfPat'])->name('PatShift');
    Route::post('PatShiftManage/{RequestUser}', [\App\Http\Controllers\Patients\PatShift::class, 'DoShiftOfPat']);
    Route::get('UsersModify/{RequestUser?}', [\App\Http\Controllers\Users\UserManagement::class, 'UserModifyMain'])->name('UsersModify');
    Route::post('UsersModify/{RequestUser?}', [\App\Http\Controllers\Users\UserManagement::class, 'DoUserModifyMain']);
    Route::get('UserReport/{RequestUser}', [\App\Http\Controllers\Users\UserManagement::class, 'UserReport'])->name('UserReport');
    Route::post('UserReport/{RequestUser}', [\App\Http\Controllers\Users\UserManagement::class, 'DoUserReport']);
    Route::get('/UserCreate', [\App\Http\Controllers\Users\UserManagement::class, 'CreateUser'])->name('CreateUser');
    Route::post('/UserCreate', [\App\Http\Controllers\Users\UserManagement::class, 'DoCreateUser']);
    Route::get('/UserSearch/{SearchPlan?}', [\App\Http\Controllers\Users\UserManagement::class, 'UserSearch'])->name('UserSearch');
    Route::post('/UserSearch/{SearchPlan?}', [\App\Http\Controllers\Users\UserManagement::class, 'DoUserSearch']);
    Route::get('/CrediteTransfer/{ReferenceId?}', [\App\Http\Controllers\Credit\CreditTransfer::class, 'CrediteTransferRequest'])->name('CrediteTransfer');
    Route::post('/CrediteTransfer/{ReferenceId?}', [\App\Http\Controllers\Credit\CreditTransfer::class, 'DoCrediteTransferRequest']);
    Route::get('/wpaclassification', [\App\Http\Controllers\WPA\classification::class, 'wpaclassification'])->name('wpaclassification');
    Route::get('/MakeInvoice', [\App\Http\Controllers\Credit\Invoice::class, 'MakeInvoice'])->name('MakeInvoice');
    Route::post('/MakeInvoice', [\App\Http\Controllers\Credit\Invoice::class, 'DoMakeInvoice']);
    Route::get('KPI', [\App\Http\Controllers\woocommerce\product::class, 'KPI'])->name('KPI');
    Route::post('KPI', [\App\Http\Controllers\woocommerce\product::class, 'DoKPI']);

    Route::get('/OrderList', [\App\Http\Controllers\Order\OrderMain::class, 'OrderList'])->name('OrderList');
    Route::post('/OrderList', [\App\Http\Controllers\Order\OrderMain::class, 'DoOrderList']);
    Route::view('/temp', 'temp');
});
Route::group(['middleware' => 'UserAccessWorker'], function () {
    if (\App\myappenv::Lic['desk']) {
        Route::get('Desk/{ID?}', [\App\Http\Controllers\Desk\MainDesk::class, 'DeskMain'])->name('Desk');
        Route::post('Desk/{ID?}', [\App\Http\Controllers\Desk\MainDesk::class, 'DoDeskMain']);
    }
    Route::get('Report/{ReportType?}', [\App\Http\Controllers\Reports\Reporter::class, 'ReportHandeller'])->name('Report');
    Route::post('Report/{ReportType?}', [\App\Http\Controllers\Reports\Reporter::class, 'DoReportHandeller']);
    Route::get('myPat', [\App\Http\Controllers\Patients\MyPat::class, 'ListOfPat'])->name('myPat');
    Route::post('myPat', [\App\Http\Controllers\Patients\MyPat::class, 'DoListOfPat']);
    Route::get('patdashboard/{UserName?}', [\App\Http\Controllers\Patients\MyPat::class, 'patdashboard'])->name('patdashboard');
    Route::post('patdashboard/{UserName?}', [\App\Http\Controllers\Patients\MyPat::class, 'Dopatdashboard']);
    Route::get('entrance', [\App\Http\Controllers\Office\entrance::class, 'entrance'])->name('entrance');
    Route::post('entrance', [\App\Http\Controllers\Office\entrance::class, 'Doentrance']);
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/PatDoc/{RequestPat?}/{RequestDoc?}', [\App\Http\Controllers\Patients\PatDoc::class, 'MainDoc'])->name('PatDoc');
    Route::post('/PatDoc/{RequestPat?}/{RequestDoc?}', [\App\Http\Controllers\Patients\PatDoc::class, 'DoMainDoc']);
    Route::get('/RentDevice/{RequestUser?}', [\App\Http\Controllers\Device\RentProces::class, 'RentDevice'])->name('RentDevice');
    Route::post('/RentDevice/{RequestUser?}', [\App\Http\Controllers\Device\RentProces::class, 'DoRentDevice']);
    Route::get('PatShiftDone', [\App\Http\Controllers\Patients\PatShift::class, 'PatShiftDone'])->name('PatShiftDone');
    Route::post('PatShiftDone', [\App\Http\Controllers\Patients\PatShift::class, 'DoPatShiftDone']);
    Route::post('NotificationCenter', [\App\Http\Controllers\notification\notification_main::class, 'NotificationCenter'])->name('NotificationCenter');
    Route::get('dashboard', [\App\Http\Controllers\Dashboard\Dashboard::class, 'Main'])->name('dashboard');
    Route::post('dashboard', [\App\Http\Controllers\Dashboard\Dashboard::class, 'Dodashboard'])->name('Dodashboard');
    Route::get('/tikets/{TicketID?}', [\App\Http\Controllers\Tiket\TiketMain::class, 'Tiket'])->name('tikets');
    Route::post('/tikets/{TicketID?}', [\App\Http\Controllers\Tiket\TiketMain::class, 'DoTiket']);
    Route::get('/MyTransfersReport', [\App\Http\Controllers\Credit\CreditTransfer::class, 'MyTransfersReport'])->name("MyTransfersReport");
    Route::post('/MyTransfersReport', [\App\Http\Controllers\Credit\CreditTransfer::class, 'DoMyTransfersReport']);
    Route::get('/ServicesWithIndex/{IndexID}', [\App\Http\Controllers\Service\Service::class, 'ServicesWithIndex'])->name("ServicesWithIndex");
    Route::post('/ServicesWithIndex/{IndexID}', [\App\Http\Controllers\Service\Service::class, 'DoServicesWithIndex']);
    Route::get('/ServiceToBuy/{ServiceID}', [\App\Http\Controllers\Service\Service::class, 'ServiceToBuy'])->name("ServiceToBuy");
    Route::post('/ServiceToBuy/{ServiceID}', [\App\Http\Controllers\Service\Service::class, 'DoServiceToBuy']);
    Route::get('UserProfile/{RequestUser?}', [\App\Http\Controllers\Users\UserManagement::class, 'UserProfile'])->name('UserProfile');
    Route::post('UserProfile/{RequestUser?}', [\App\Http\Controllers\Users\UserManagement::class, 'DoUserProfile']);
    Route::get('/DirectPay', [\App\Http\Controllers\Credit\DirectPayment::class, 'DirectPay'])->name('DirectPay');
    Route::post('/DirectPay', [\App\Http\Controllers\Credit\DirectPayment::class, 'DoDirectPay'])->name('DoDirectPay');
    Route::get('/MyAccount', [\App\Http\Controllers\Users\Accounts::class, 'MyAccount'])->name('MyAccount');
    Route::post('/MyAccount', [\App\Http\Controllers\Users\Accounts::class, 'DoMyAccount']);
    Route::get('/ConfirmPay/{Token}', [\App\Http\Controllers\Credit\DirectPayment::class, 'ConfirmPay'])->name('ConfirmPay');
    Route::get('OrderList', [\App\Http\Controllers\Order\OrderMain::class, 'OrderList'])->name('OrderList');
    Route::post('OrderList', [\App\Http\Controllers\Order\OrderMain::class, 'DoOrderList']);
    Route::get('myprofile/{RequestUser?}', [\App\Http\Controllers\Order\OrderRequest::class, 'myprofile'])->name('myprofile');
    Route::post('myprofile/{RequestUser?}', [\App\Http\Controllers\Order\OrderRequest::class, 'Domyprofile']);
    Route::get('/Exam/{ExamID}', [\App\Http\Controllers\exam\ExamAdmin::class, 'SingleExam'])->name('SingleExam');
    Route::post('/Exam/{ExamID}', [\App\Http\Controllers\exam\ExamAdmin::class, 'DoSingleExam']);
    Route::get('/ExamResults/{ExamID?}', [\App\Http\Controllers\exam\ExamAdmin::class, 'ExamResults'])->name('ExamResults');
    Route::post('/ExamResults/{ExamID?}', [\App\Http\Controllers\exam\ExamAdmin::class, 'DoExamResults']);
    if (App\myappenv::Lic['affiliate'] ?? false) {
        Route::get('/affiliate', [\App\Http\Controllers\Affiliate\user_affiliate::class, 'affiliate'])->name('affiliate');
        Route::post('/affiliate', [\App\Http\Controllers\Affiliate\user_affiliate::class, 'Doaffiliate']);
    }
});

Route::get('{seo_address?}', [\App\Http\Controllers\SEO_friendly_address::class, 'call_seo_friendly_address']); // seo freindly address handler
