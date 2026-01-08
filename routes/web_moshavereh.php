<?php

Route::get('Moshavere/{CatID}', [\App\Http\Controllers\moshavereh\main::class, 'ShowMoshavers'])->name('Moshavere');
Route::post('Moshavere/{CatID}', [\App\Http\Controllers\moshavereh\main::class, 'DoShowMoshavers']);
Route::get('ConfirmSession/{Token}', [\App\Http\Controllers\moshavereh\main::class, 'ConfirmSession'])->name('ConfirmSession');
Route::post('ConfirmSession/{Token}', [\App\Http\Controllers\moshavereh\main::class, 'DoConfirmSession']);


Route::get('Consulting', [\App\Http\Controllers\Consult\ConsultMain::class, 'Consulting'])->name('Consulting');
Route::post('Consulting', [\App\Http\Controllers\Consult\ConsultMain::class, 'DoConsulting']);
Route::get('Consultation/{userid}', [\App\Http\Controllers\Consult\ConsultMain::class, 'Consultation'])->name('Consultation');
Route::post('Consultation/{userid}', [\App\Http\Controllers\Consult\ConsultMain::class, 'DoConsultation']);
Route::get('Reservationlist/{L3id?}/{L3Name?}', [\App\Http\Controllers\Consult\ConsultMain::class, 'Reservationlist'])->name('Reservationlist');
Route::post('Reservationlist/{L3id?}/{L3Name?}', [\App\Http\Controllers\Consult\ConsultMain::class, 'DoReservationlist']);