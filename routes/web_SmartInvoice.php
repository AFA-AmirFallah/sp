<?php
Route::group(['middleware' => 'UserAccessAdmin'], function () {
    Route::get('/MakeSmartInvoice/{RequestUser}', [\App\Http\Controllers\Credit\Invoice::class, 'MakeSmartInvoice'])->name('MakeSmartInvoice');
    Route::post('/MakeSmartInvoice/{RequestUser}', [\App\Http\Controllers\Credit\Invoice::class, 'DoMakeSmartInvoice']);
    Route::get('/EditeSmartInvoice/{InvoiceID}', [\App\Http\Controllers\Credit\Invoice::class, 'EditeSmartInvoice'])->name('EditeSmartInvoice');
    Route::post('/EditeSmartInvoice/{InvoiceID}', [\App\Http\Controllers\Credit\Invoice::class, 'DoEditeSmartInvoice']);
});