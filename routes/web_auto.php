<?php

/**
 * Automation routes
 */
Route::group(['middleware' => 'UserAccessSuperAdmin'], function () {
    Route::get('/auto_admin', [\App\Http\Controllers\auto\AdminWorks::class, 'auto_admin'])->name('auto_admin');
    Route::post('/auto_admin', [\App\Http\Controllers\auto\AdminWorks::class, 'Doauto_admin']);
    Route::get('/group_admin/{group_id}', [\App\Http\Controllers\auto\AdminWorks::class, 'group_admin'])->name('group_admin');
    Route::post('/group_admin/{group_id}', [\App\Http\Controllers\auto\AdminWorks::class, 'Dogroup_admin']);

});

Route::group(['middleware' => 'UserAccessAdmin'], function () {

    Route::get('/group_work/{group_id}', [\App\Http\Controllers\auto\GroupWorks::class, 'group_work'])->name('group_work');
    Route::post('/group_work/{group_id}', [\App\Http\Controllers\auto\GroupWorks::class, 'Dogroup_work']);
    Route::get('/tasks/{group_id}/{task_id?}', [\App\Http\Controllers\auto\GroupWorks::class, 'tasks'])->name('tasks');
    Route::post('/tasks/{group_id}/{task_id?}', [\App\Http\Controllers\auto\GroupWorks::class, 'Dotasks']);

});
