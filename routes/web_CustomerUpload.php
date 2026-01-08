<?php
Route::get('upload', [\App\Http\Controllers\Upload\CustomerUpload::class, 'upload'])->name('upload');
Route::post('upload', [\App\Http\Controllers\Upload\CustomerUpload::class, 'Doupload']);
