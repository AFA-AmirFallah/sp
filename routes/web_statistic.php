<?php

Route::group(['middleware' => 'UserAccessSuperAdmin'], function () {
        Route::get('/add_statistic', [\App\Http\Controllers\statistic\statistic_mgt::class, 'add_statistic'])->name('add_statistic');
        Route::post('/add_statistic', [\App\Http\Controllers\statistic\statistic_mgt::class, 'Doadd_statistic']);
        Route::get('/edit_statistic/{id}', [\App\Http\Controllers\statistic\statistic_mgt::class, 'edit_statistic'])->name('edit_statistic');
        Route::post('/edit_statistic/{id}', [\App\Http\Controllers\statistic\statistic_mgt::class, 'Doedit_statistic']);
        Route::get('/statistic_list', [\App\Http\Controllers\statistic\statistic_mgt::class, 'statistic_list'])->name('statistic_list');
        Route::post('/statistic_list', [\App\Http\Controllers\statistic\statistic_mgt::class, 'Dostatistic_list']);


});

