<?php

use App\Http\Controllers\woocommerce\product;
use App\myappenv;

Route::get('shop', [\App\Http\Controllers\Dashboard\Dashboard::class, 'shop'])->name('shop');
Route::post('shop', [\App\Http\Controllers\Dashboard\Dashboard::class, 'Doshop']);
//Route::get('SpecialAccount', [\App\Http\Controllers\woocommerce\buy::class, 'SpecialAccount'])->name('SpecialAccount');
//Route::post('SpecialAccount', [\App\Http\Controllers\woocommerce\buy::class, 'DoSpecialAccount']);
Route::get('ProductCat', [\App\Http\Controllers\woocommerce\product::class, 'ProductCat'])->name('ProductCat');
Route::post('ProductCat', [\App\Http\Controllers\woocommerce\product::class, 'DoProductCat']);
Route::get('brand/{TagName}', [\App\Http\Controllers\woocommerce\product::class, 'brand'])->name('brand');
Route::post('brand/{TagName}', [\App\Http\Controllers\woocommerce\product::class, 'Dobrand']);
Route::get('Product/{Tags?}/{TagName?}', [\App\Http\Controllers\woocommerce\product::class, 'ShowProduct'])->name('ShowProduct');
Route::post('Product/{Tags?}/{TagName?}', [\App\Http\Controllers\woocommerce\product::class, 'DoShowProduct']);
Route::get('checkout', [\App\Http\Controllers\woocommerce\product::class, 'newcheckout'])->name('checkout');
Route::get('ConfirmPay/{pay}/{ref?}', [\App\Http\Controllers\woocommerce\product::class, 'ConfirmPay'])->name('ConfirmPayment');
Route::post('checkout', [\App\Http\Controllers\woocommerce\product::class, 'Donewcheckout']);
Route::get('addlocation', [\App\Http\Controllers\woocommerce\buy::class, 'addlocation'])->name('addlocation');
Route::post('addlocation', [\App\Http\Controllers\woocommerce\buy::class, 'Doaddlocation']);
Route::get('/product/{productID}/{productName?}', function ($productID, $productName = null) {
$product = new product;
$product_url = $product->get_product_custom_url($productID);
if (!$product_url['result']) {
        return redirect()->route('home');
        return abort('404', $product_url['msg']);
    }
    if ($product_url['type'] == 'redirect') {
        $product_url = $product_url['url'];
        if ($product_url != null && $product_url != '') {
            return redirect()->route('SingleProduct', ['productID' => $product_url]);
        }
    }
    if ($product_url['type'] == 'return') {
        return $product->SingleProduct($productID, $productName);
    }
})->name('SingleProduct');
Route::post('/product/{productID}/{productName?}', [\App\Http\Controllers\woocommerce\product::class, 'DoSingleProduct']);
Route::get('/ProductCats/{TargetLayer?}', [\App\Http\Controllers\woocommerce\product::class, 'ProductCats'])->name('ProductCats');
Route::group(['middleware' => 'UserAccessAdmin'], function () {
    Route::get("/AddWarehouse/{StoreID}", [\App\Http\Controllers\woocommerce\store::class, 'AddWarehouse'])->name("AddWarehouse");
    Route::post('/AddWarehouse/{StoreID}', [\App\Http\Controllers\woocommerce\store::class, 'DoAddWarehouse']);
    Route::get("/EditWarehouse/{StoreID}/{Warehousid}", [\App\Http\Controllers\woocommerce\store::class, 'EditWarehouse'])->name("EditWarehouse");
    Route::post('/EditWarehouse/{StoreID}/{Warehousid}', [\App\Http\Controllers\woocommerce\store::class, 'DoEditWarehouse']);
    Route::get("/StoreManageitems/{id}", [\App\Http\Controllers\woocommerce\store::class, 'StoreManageitems'])->name("StoreManageitems");
    Route::post('/StoreManageitems/{id}', [\App\Http\Controllers\woocommerce\store::class, 'DoStoreManageitems']);
    Route::get('UnitManagement', [\App\Http\Controllers\woocommerce\product::class, 'UnitManagement'])->name('UnitManagement');
    Route::post('UnitManagement', [\App\Http\Controllers\woocommerce\product::class, 'DoUnitManagement']);
});
Route::group(['middleware' => 'UserAccessAdmin'], function () {
    Route::get('EditOrder/{OrderID}/{type?}', [\App\Http\Controllers\woocommerce\product::class, 'EditOrder'])->name('EditOrder');
    Route::post('EditOrder/{OrderID}/{type?}', [\App\Http\Controllers\woocommerce\product::class, 'DoEditOrder']);
});
Route::group(['middleware' => 'UserAccessShopOwner'], function () {
    Route::get('EditProductInStore/{id}/{iframe?}', [\App\Http\Controllers\woocommerce\product::class, 'EditProductInStore'])->name('EditProductInStore');
    Route::post('EditProductInStore/{id}', [\App\Http\Controllers\woocommerce\product::class, 'DoEditProductInStore'])->name('P_EditProductInStore');
    Route::get('EditProduct/{id}', [\App\Http\Controllers\woocommerce\product::class, 'EditProduct'])->name('EditProduct');
    Route::post('EditProduct/{id}', [\App\Http\Controllers\woocommerce\product::class, 'DoEditProduct']);
    Route::get('ProductLsit', [\App\Http\Controllers\woocommerce\product::class, 'ProductLsit'])->name('ProductLsit');
    Route::post('ProductLsit', [\App\Http\Controllers\woocommerce\product::class, 'DoProductLsit']);
    Route::get('OpenOrders', [\App\Http\Controllers\woocommerce\product::class, 'OpenOrders'])->name('OpenOrders');
    Route::post('OpenOrders', [\App\Http\Controllers\woocommerce\product::class, 'DoOpenOrders']);
    Route::get('AddGoodToWarehouse', [\App\Http\Controllers\woocommerce\product::class, 'AddGoodToWarehouse'])->name('AddGoodToWarehouse');
    Route::post('AddGoodToWarehouse', [\App\Http\Controllers\woocommerce\product::class, 'DoAddGoodToWarehouse'])->name('P_AddGoodToWarehouse');
    Route::get('AddProduct', [\App\Http\Controllers\woocommerce\product::class, 'AddProduct'])->name('AddProduct');
    Route::post('AddProduct', [\App\Http\Controllers\woocommerce\product::class, 'DoAddProduct']);
    Route::get('ProductGalery/{id}/{iframe?}', [\App\Http\Controllers\woocommerce\product::class, 'ProductGalery'])->name('ProductGalery');
    Route::post('ProductGalery/{id}/{iframe?}', [\App\Http\Controllers\woocommerce\product::class, 'DoProductGalery']);
});
