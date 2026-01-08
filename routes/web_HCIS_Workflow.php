<?php
Route::group(['middleware' => 'UserAccessWorker'], function () {
    Route::get('/Workflow/{RequestUser}', [\App\Http\Controllers\Patients\Workflow::class, 'Workflow'])->name('Workflow');
    Route::post('/Workflow/{RequestUser}', [\App\Http\Controllers\Patients\Workflow::class, 'DoWorkflow']);
});
