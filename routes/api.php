
<?php

use App\Http\Controllers\APIS\hiring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Lic;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

if (Lic::check('SMSReciver')) {
    Route::get('SMSReciver', [\App\Http\Controllers\APIS\SMSReciver::class, 'MainSMSReciver'])->name('SMSReciver');
}
Route::post('alert', [\App\Functions\CallCenterClass::class, 'alert_platform']);
Route::post('OutBand', [\App\Http\Controllers\APIS\OutBand::class, 'CenterControl']);
Route::post('DirectPay', [\App\Http\Controllers\Credit\DirectPayment::class, 'DoDirectPay']);
Route::post('seppay', [\App\Http\Controllers\Credit\DirectPayment::class, 'Doseppay'])->name('seppay');
Route::get('seppay', [\App\Http\Controllers\Credit\DirectPayment::class, 'seppay']);
Route::post('peppay', [\App\Http\Controllers\Credit\DirectPayment::class, 'Dopeppay'])->name('peppay');
Route::get('peppay', [\App\Http\Controllers\Credit\DirectPayment::class, 'peppay']);
Route::get('PartnerLogin', [\App\Http\Controllers\APIS\OutBand::class, 'PartnerLogin']);
Route::post('ikc', [\App\Http\Controllers\APIS\IKC::class, 'revicer'])->name('ikcReciver');
Route::post('poolkhord', [\App\Http\Controllers\APIS\poolkhord::class, 'receiver'])->name('poolkhord_Reciver');
Route::post('azki', [\App\Http\Controllers\APIS\azki::class, 'receiver']);
Route::get('azki', [\App\Http\Controllers\APIS\azki::class, 'receiver'])->name('azki_Reciver');
Route::post('pna', [\App\Http\Controllers\APIS\PNA::class, 'revicer'])->name('pnaReciver');
Route::post('pec', [\App\PEC\PECMain::class, 'revicer'])->name('pecReciver');

//Route::get('webservice/{endpoint}', [\App\Http\Controllers\APIS\WebService::class, 'WebService'])->name('WebService');
Route::post('webservice/{endpoint}', [\App\Http\Controllers\APIS\WebService::class, 'DoWebService']);

if (\App\myappenv::Lic['hiring']) {
    Route::post('hiring', [hiring::class, 'index']);
}
