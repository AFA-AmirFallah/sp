<?php
Route::get('/MakeForm', [\App\Http\Controllers\forms\formsadmin::class, 'MakeForm'])->name('MakeForm');
Route::post('/MakeForm', [\App\Http\Controllers\forms\formsadmin::class, 'DoMakeForm']);
Route::get('/FormsList', [\App\Http\Controllers\forms\formsadmin::class, 'FormsList'])->name('FormsList');
Route::post('/FormsList', [\App\Http\Controllers\forms\formsadmin::class, 'DoFormsList']);
Route::get('/EditForm/{form_id}', [\App\Http\Controllers\forms\formsadmin::class, 'EditForm'])->name('EditForm');
Route::post('/EditForm/{form_id}', [\App\Http\Controllers\forms\formsadmin::class, 'DoEditForm']);
