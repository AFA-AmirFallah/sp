<?php
Route::get('sitemap.xml', [\App\Http\Controllers\seo\sitmep::class, 'MainSiteMap']);
Route::get('post-sitemap.xml', [\App\Http\Controllers\seo\sitmep::class, 'post_sitemap'])->name('post_sitemap');
Route::get('cover-sitemap.xml', [\App\Http\Controllers\seo\sitmep::class, 'cover_sitemap'])->name('cover_sitemap');
Route::get('deal-sitemap.xml', [\App\Http\Controllers\seo\sitmep::class, 'deal_sitemap'])->name('deal_sitemap');
Route::get('page-sitemap.xml', [\App\Http\Controllers\seo\sitmep::class, 'page_sitemap'])->name('page_sitemap');
Route::get('product-sitemap.xml', [\App\Http\Controllers\seo\sitmep::class, 'product_sitemap'])->name('product_sitemap');
Route::get('emalls', [\App\Http\Controllers\seo\sitmep::class, 'emalls']);
