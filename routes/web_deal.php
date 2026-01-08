<?php

Route::group(['middleware' => 'UserAccessSuperAdmin'], function () {
        Route::get('/edit_file/{file_id}', [\App\Http\Controllers\deal\SuperAdminController::class, 'edit_file'])->name('edit_file');
        Route::post('/edit_file/{file_id}', [\App\Http\Controllers\deal\SuperAdminController::class, 'Doedit_file']);
        Route::get('/edit_pic/{file_id}', [\App\Http\Controllers\deal\SuperAdminController::class, 'edit_pic'])->name('edit_pic');
        Route::post('/edit_pic/{file_id}', [\App\Http\Controllers\deal\SuperAdminController::class, 'Doedit_pic']);
        Route::get('/edit_properties/{file_id}', [\App\Http\Controllers\deal\SuperAdminController::class, 'edit_properties'])->name('edit_properties');
        Route::post('/edit_properties/{file_id}', [\App\Http\Controllers\deal\SuperAdminController::class, 'Doedit_properties']);
        Route::get('/edit_admins/{file_id}', [\App\Http\Controllers\deal\SuperAdminController::class, 'edit_admins'])->name('edit_admins');
        Route::post('/edit_admins/{file_id}', [\App\Http\Controllers\deal\SuperAdminController::class, 'Doedit_admins']);
        Route::get('/setting_admins/{file_id}', [\App\Http\Controllers\deal\SuperAdminController::class, 'setting_admins'])->name('setting_admins');
        Route::post('/setting_admins/{file_id}', [\App\Http\Controllers\deal\SuperAdminController::class, 'Dosetting_admins']);

});
Route::group(['middleware' => 'UserAccessWorker'], function () {
        Route::get('/working_file/{file_id}', [\App\Http\Controllers\deal\WorkerController::class, 'working_file'])->name('working_file');
        Route::post('/working_file/{file_id}', [\App\Http\Controllers\deal\WorkerController::class, 'Doworking_file']);
        Route::get('/input_calls/{file_id}', [\App\Http\Controllers\deal\WorkerController::class, 'input_calls'])->name('input_calls');
        Route::post('/input_calls/{file_id}', [\App\Http\Controllers\deal\WorkerController::class, 'Doinput_calls']);
        Route::get('/output_calls/{file_id}', [\App\Http\Controllers\deal\WorkerController::class, 'output_calls'])->name('output_calls');
        Route::post('/output_calls/{file_id}', [\App\Http\Controllers\deal\WorkerController::class, 'Dooutput_calls']);
        Route::get('/file_workflow/{file_id}', [\App\Http\Controllers\deal\WorkerController::class, 'file_workflow'])->name('file_workflow');
        Route::post('/file_workflow/{file_id}', [\App\Http\Controllers\deal\WorkerController::class, 'Dofile_workflow']);

});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/add_file', [\App\Http\Controllers\deal\SuperAdminController::class, 'add_file'])->name('add_file');
    Route::post('/add_file', [\App\Http\Controllers\deal\SuperAdminController::class, 'Doadd_file']);
    Route::get('/deal_search', [\App\Http\Controllers\deal\SuperAdminController::class, 'deal_search'])->name('deal_search');
    Route::post('/deal_search', [\App\Http\Controllers\deal\SuperAdminController::class, 'Dodeal_search']);
});
Route::get('/files/{file_id}/{file_name?}', [\App\Http\Controllers\deal\CustomerController::class, 'files'])->name('files');
Route::post('/files/{file_id}/{file_name?}', [\App\Http\Controllers\deal\CustomerController::class, 'Dofiles']);
Route::get('/deals/{cat?}', [\App\Http\Controllers\deal\CustomerController::class, 'deals'])->name('deals');
Route::post('/deals/{cat?}', [\App\Http\Controllers\deal\CustomerController::class, 'Dodeals']);
Route::get('/contact', [\App\Http\Controllers\deal\CustomerController::class, 'contact'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\deal\CustomerController::class, 'Docontact']);
