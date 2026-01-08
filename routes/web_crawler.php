<?php
Route::group(['middleware' => 'UserAccessSuperAdmin'], function () {
    Route::get('/competitor', [\App\Http\Controllers\crawler\CrawlerMain::class, 'competitor'])->name('competitor');
    Route::post('/competitor', [\App\Http\Controllers\crawler\CrawlerMain::class, 'Docompetitor']);
    Route::get('/MainCrawler', [\App\Http\Controllers\crawler\CrawlerMain::class, 'MainCrawler'])->name('MainCrawler');
    Route::post('/MainCrawler', [\App\Http\Controllers\crawler\CrawlerMain::class, 'DoMainCrawler']);
    Route::get('/Crawler/{ID}', [\App\Http\Controllers\crawler\CrawlerMain::class, 'Crawler'])->name('Crawler');
    Route::post('/Crawler/{ID}', [\App\Http\Controllers\crawler\CrawlerMain::class, 'DoCrawler']);
    Route::get('/ItemAnalyze/{ID}', [\App\Http\Controllers\crawler\CrawlerMain::class, 'ItemAnalyze'])->name('ItemAnalyze');
    Route::post('/ItemAnalyze/{ID}', [\App\Http\Controllers\crawler\CrawlerMain::class, 'DoItemAnalyze']);

});
