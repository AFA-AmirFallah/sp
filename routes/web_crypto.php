<?php
Route::group(['middleware' => 'UserAccessSuperAdmin'], function () {
    Route::get('CurencyList', [\App\Http\Controllers\Crypto\CryptoAdmin::class, 'CurencyList'])->name('CurencyList');
    Route::post('CurencyList', [\App\Http\Controllers\Crypto\CryptoAdmin::class, 'DoCurencyList']);
    Route::get('ExDif', [\App\Http\Controllers\Crypto\CryptoAdmin::class, 'ExDif'])->name('ExDif');
    Route::post('ExDif', [\App\Http\Controllers\Crypto\CryptoAdmin::class, 'DoExDif']);
    Route::get('CurencyProfile/{RequestCurency}', [\App\Http\Controllers\Crypto\CryptoAdmin::class, 'CurencyProfile'])->name('CurencyProfile');
    Route::post('CurencyProfile/{RequestCurency}', [\App\Http\Controllers\Crypto\CryptoAdmin::class, 'DoCurencyProfile']);
});
Route::group(['middleware' => 'UserAccessWorker'], function () {
    Route::get('crypto', [\App\Http\Controllers\Crypto\CryptoMain::class, 'crypto'])->name('crypto');
    Route::post('crypto', [\App\Http\Controllers\Crypto\CryptoMain::class, 'Docrypto']);
    Route::get('cryptoAccount', [\App\Http\Controllers\Crypto\CryptoMain::class, 'cryptoAccount'])->name('cryptoAccount');
    Route::post('cryptoAccount', [\App\Http\Controllers\Crypto\CryptoMain::class, 'DocryptoAccount']);
    Route::get('AccountShow', [\App\Http\Controllers\Crypto\CryptoMain::class, 'AccountShow'])->name('AccountShow');
    Route::get('analyze/{curency}', [\App\Http\Controllers\Crypto\CryptoMain::class, 'analyze'])->name('analyze');
    Route::post('analyze/{curency}', [\App\Http\Controllers\Crypto\CryptoMain::class, 'Doanalyze']);
    Route::get('analyzer/{type?}', [\App\Http\Controllers\Crypto\CryptoMain::class, 'analyzer'])->name('analyzer');
    Route::post('analyzer/{type?}', [\App\Http\Controllers\Crypto\CryptoMain::class, 'Doanalyzer']);
    Route::get('WaletShow/{EXCType?}', [\App\Http\Controllers\Crypto\CryptoMain::class, 'WaletShow'])->name('WaletShow');
    Route::post('WaletShow/{EXCType?}', [\App\Http\Controllers\Crypto\CryptoMain::class, 'DoWaletShow']);
    Route::get('CoinEdit/{CoinId}', [\App\Http\Controllers\Crypto\CryptoMain::class, 'CoinEdit'])->name('CoinEdit');
    Route::post('CoinEdit/{CoinId}', [\App\Http\Controllers\Crypto\CryptoMain::class, 'DoCoinEdit']);
    Route::get('BestDirections', [\App\Http\Controllers\Crypto\CryptoMain::class, 'BestDirections'])->name('BestDirections');
    Route::post('BestDirections', [\App\Http\Controllers\Crypto\CryptoMain::class, 'DoBestDirections']);
    Route::get('CryptoAnalyze', [\App\Http\Controllers\Crypto\CryptoMain::class, 'CryptoAnalyze'])->name('CryptoAnalyze');
    Route::post('CryptoAnalyze', [\App\Http\Controllers\Crypto\CryptoMain::class, 'DoCryptoAnalyze']);
    Route::get('RobotMGT', [\App\Http\Controllers\Crypto\CryptoMain::class, 'RobotMGT'])->name('RobotMGT');
    Route::post('RobotMGT', [\App\Http\Controllers\Crypto\CryptoMain::class, 'DoRobotMGT']);
    Route::get('BTMGT/{type}', [\App\Http\Controllers\Crypto\backtest::class, 'BTMGT'])->name('BTMGT');
    Route::post('BTMGT/{type}', [\App\Http\Controllers\Crypto\backtest::class, 'DoBTMGT']);
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('wizard_ex/{CoinId}', [\App\Http\Controllers\Crypto\buy::class, 'wizard_ex'])->name('wizard_ex');
    Route::post('wizard_ex/{CoinId}', [\App\Http\Controllers\Crypto\buy::class, 'do_wizard_ex']);

});