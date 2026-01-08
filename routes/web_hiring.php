<?php

Route::get('/pb_register', [\App\Http\Controllers\hiring\user_control::class, 'pb_register'])->name('pb_register');
Route::post('/pb_register', [\App\Http\Controllers\hiring\user_control::class, 'Dopb_register']);
Route::get('/add_experience', [\App\Http\Controllers\hiring\experience::class, 'add_experience'])->name('add_experience');
Route::post('/add_experience', [\App\Http\Controllers\hiring\experience::class, 'Doadd_experience']);
Route::get('/search_staff', [\App\Http\Controllers\hiring\reporting::class, 'search_staff'])->name('search_staff');
Route::post('/search_staff', [\App\Http\Controllers\hiring\reporting::class, 'Dosearch_staff']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/experience_list', [\App\Http\Controllers\hiring\experience::class, 'experience_list'])->name('experience_list');
    Route::post('/experience_list', [\App\Http\Controllers\hiring\experience::class, 'Doexperience_list']);
    Route::get('/report_staff/{code}/{gateway?}/{ref?}', [\App\Http\Controllers\hiring\reporting::class, 'report_staff'])->name('report_staff');
    Route::post('/report_staff/{code}/{gateway?}/{ref?}', [\App\Http\Controllers\hiring\reporting::class, 'Doreport_staff']);
});

Route::group(['middleware' => 'UserAccessWorker'], function () {
    Route::get('/worker_experience_list', [\App\Http\Controllers\hiring\experience::class, 'worker_experience_list'])->name('worker_experience_list');
    Route::post('/worker_experience_list', [\App\Http\Controllers\hiring\experience::class, 'Doworker_experience_list']);
    Route::get('/worker_single_experience/{id}', [\App\Http\Controllers\hiring\experience::class, 'worker_single_experience'])->name('worker_single_experience');
    Route::post('/worker_single_experience/{id}', [\App\Http\Controllers\hiring\experience::class, 'Doworker_single_experience']);
});
Route::group(['middleware' => 'UserAccessAdmin'], function () {
    Route::get('/hiring_skill_mgt', [\App\Http\Controllers\hiring\admins::class, 'hiring_skill_mgt'])->name('hiring_skill_mgt');
    Route::post('/hiring_skill_mgt', [\App\Http\Controllers\hiring\admins::class, 'Dohiring_skill_mgt']);
    Route::get('/hiring_confirmable', [\App\Http\Controllers\hiring\admins::class, 'hiring_confirmable'])->name('hiring_confirmable');
    Route::get('/hiring_dashboard', [\App\Http\Controllers\hiring\admins::class, 'hiring_dashboard'])->name('hiring_dashboard');
    Route::post('/hiring_dashboard', [\App\Http\Controllers\hiring\admins::class, 'Dohiring_dashboard']);
    Route::get('/admin_experience_list', [\App\Http\Controllers\hiring\admins::class, 'admin_experience_list'])->name('admin_experience_list');
    Route::post('/admin_experience_list', [\App\Http\Controllers\hiring\admins::class, 'Doadmin_experience_list']);
    Route::get('/admin_single_experience/{id}', [\App\Http\Controllers\hiring\admins::class, 'admin_single_experience'])->name('admin_single_experience');
    Route::post('/admin_single_experience/{id}', [\App\Http\Controllers\hiring\admins::class, 'Doadmin_single_experience']);
    Route::get('/admin_single_experience_person/{id}', [\App\Http\Controllers\hiring\admins::class, 'admin_single_experience_person'])->name('admin_single_experience_person');
    Route::post('/admin_single_experience_person/{id}', [\App\Http\Controllers\hiring\admins::class, 'Doadmin_single_experience_person']);
    Route::get('/admin_experience_reporting/{id}', [\App\Http\Controllers\hiring\admins::class, 'admin_experience_reporting'])->name('admin_experience_reporting');
    Route::post('/admin_experience_reporting/{id}', [\App\Http\Controllers\hiring\admins::class, 'Doadmin_experience_reporting']);
    Route::get('/admin_experience_actions/{id}', [\App\Http\Controllers\hiring\admins::class, 'admin_experience_actions'])->name('admin_experience_actions');
    Route::post('/admin_experience_actions/{id}', [\App\Http\Controllers\hiring\admins::class, 'Doadmin_experience_actions']);

});
