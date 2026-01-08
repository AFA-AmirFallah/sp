<?php

use App\myappenv;
Route::get('Voip', [\App\Http\Controllers\APIS\AJAX::class, 'main']);
Route::get('VOIP', [\App\Http\Controllers\APIS\VOIP::class, 'main']);
Route::group(['middleware' => 'UserAccessAdmin'], function () {
    Route::get("/phone", [\App\Http\Controllers\voip\phone::class, 'phone'])->name("phone");
    Route::post('/phone', [\App\Http\Controllers\voip\phone::class, 'Dophone']);

    Route::get("/voip_main", [\App\Http\Controllers\voip\phone::class, 'voip_main'])->name("voip_main");
    Route::post('/voip_main', [\App\Http\Controllers\voip\phone::class, 'Dovoip_main']);


});
