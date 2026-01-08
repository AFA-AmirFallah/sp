<?php


Route::get('/NewsHome', [\App\Http\Controllers\News\NewsItems::class, 'NewsHome'])->name('NewsHome');
Route::post('/NewsHome', [\App\Http\Controllers\News\NewsItems::class, 'DoNewsHome']);
Route::get('/news/{NewsId}/{newsitem?}', [\App\Http\Controllers\News\NewsItems::class, 'ShowNewsItem'])->name('ShowNewsItem');
Route::post('/news/{NewsId}/{newsitem?}', [\App\Http\Controllers\News\NewsItems::class, 'DoShowNewsItem']);
Route::get('newscat/{newscat}', [\App\Http\Controllers\News\NewsItems::class, 'newscat'])->name('newscat');
Route::post('newscat/{newscat}', [\App\Http\Controllers\News\NewsItems::class, 'Donewscat']);
Route::get('familycat/{familycat}', [\App\Http\Controllers\News\NewsItems::class, 'familycat'])->name('familycat');
Route::post('familycat/{familycat}', [\App\Http\Controllers\News\NewsItems::class, 'Dofamilycat']);
Route::get('newsgroup/{newscat}', [\App\Http\Controllers\News\NewsItems::class, 'newsgroup'])->name('newsgroup');
Route::post('newsgroup/{newscat}', [\App\Http\Controllers\News\NewsItems::class, 'Donewsgroup']);
Route::get('feed', [App\Http\Controllers\RssFeedController::class,'feed' ])->name('rss_feed') ;

Route::group(['middleware' => 'UserAccessSuperAdmin'], function () {
    Route::get('/MakeNews', [\App\Http\Controllers\News\NewsAdmin::class, 'MakeNews'])->name('MakeNews');
    Route::post('/MakeNews', [\App\Http\Controllers\News\NewsAdmin::class, 'DoMakeNews']);
    Route::get('/editComment/{commentID}', [\App\Http\Controllers\News\NewsAdmin::class, 'editComment'])->name('editComment');
    Route::post('/editComment/{commentID}', [\App\Http\Controllers\News\NewsAdmin::class, 'DoeditComment']);
    Route::get('/MakeTagCover/{TagID?}', [\App\Http\Controllers\News\NewsAdmin::class, 'MakeTagCover'])->name('MakeTagCover');
    Route::post('/MakeTagCover/{TagID?}', [\App\Http\Controllers\News\NewsAdmin::class, 'DoMakeTagCover']);
    Route::get('/EditTagCover/{TagID}', [\App\Http\Controllers\News\NewsAdmin::class, 'EditTagCover'])->name('EditTagCover');
    Route::post('/EditTagCover/{TagID}', [\App\Http\Controllers\News\NewsAdmin::class, 'DoEditTagCover']);
    Route::get('/EditNews/{NewsID}', [\App\Http\Controllers\News\NewsAdmin::class, 'EditNews'])->name('EditNews');
    Route::post('/EditNews/{NewsID}', [\App\Http\Controllers\News\NewsAdmin::class, 'DoEditNews']);
    Route::get('/NewsList/{ListType?}', [\App\Http\Controllers\News\NewsAdmin::class, 'NewsList'])->name('NewsList');
    Route::post('/NewsList/{ListType?}', [\App\Http\Controllers\News\NewsAdmin::class, 'DoNewsList']);
    Route::get('/MenuWorks', [\App\Http\Controllers\News\NewsAdmin::class, 'MenuWorks'])->name('MenuWorks');
    Route::post('/MenuWorks', [\App\Http\Controllers\News\NewsAdmin::class, 'DoMenuWorks']);
    Route::get('/ConfigNews/{NewsID}', [\App\Http\Controllers\News\NewsAdmin::class, 'ConfigNews'])->name('ConfigNews');
    Route::post('/ConfigNews/{NewsID}', [\App\Http\Controllers\News\NewsAdmin::class, 'DoConfigNews']);
});
