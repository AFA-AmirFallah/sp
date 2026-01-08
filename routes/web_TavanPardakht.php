<?php
Route::group(['middleware' => 'UserAccessAdmin'], function () {
    Route::get('TavanPardakht', [\App\Http\Controllers\Credit\Reports::class, 'TavanPardakht'])->name('TavanPardakht');
    Route::post('TavanPardakht', [\App\Http\Controllers\Credit\Reports::class, 'DoTavanPardakht']);
});
