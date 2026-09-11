<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGallaryController;
use App\Http\Controllers\Backend\VendorProductVariantController;
use App\Http\Controllers\Backend\VendorProductVariantItemController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use App\Http\Controllers\Frontend\VendorProfileController;
use Illuminate\Support\Facades\Route;


// vendor routes
Route::get('dashboard',[VendorController::class,'dashboard'])->name('dashboard');

Route::get('/profile',[VendorProfileController::class,'index'])->name('profile');
Route::put('profile',[VendorProfileController::class,'updateProfile'])->name('profile.update');
Route::post('profile',[VendorProfileController::class,'updatePassword'])->name('profile.update.password');

/* vendor shop profile */
Route::resource('shop-profile', VendorShopProfileController::class);

/* Vendor Product    */
Route::get('product/get-sub-categories',[VendorProductController::class,'getSubCategories'])->name('product.get-sub-categories');
Route::get('product/get-child-categories',[VendorProductController::class,'getChildCategories'])->name('product.get-child-categories');
Route::put('product/change-status',[VendorProductController::class,'changeStatus'])->name('product.change-status');
Route::resource('products',VendorProductController::class);


/* Product Image Gallary */

Route::resource('products-image-gallary',VendorProductImageGallaryController::class);


/* Product Variant Route */

Route::put('products-variant/change-status',[VendorProductVariantController::class,'changeStatus'])->name('products-variant.change-status');
Route::resource('products-variant',VendorProductVariantController::class);

/* Product Variant Item Route */


Route::get('products-variant-item/{productId}/{variantId}', [VendorProductVariantItemController::class, 'index'])->name('products-variant-item.index');
Route::get('products-variant-item/create/{productId}/{variantId}', [VendorProductVariantItemController::class, 'create'])->name('products-variant-item.create');
Route::post('products-variant-item', [VendorProductVariantItemController::class, 'store'])->name('products-variant-item.store');
Route::get('products-variant-item-edit/{variantItemId}', [VendorProductVariantItemController::class, 'edit'])->name('products-variant-item.edit');
Route::put('products-variant-item-update/{variantItemId}', [VendorProductVariantItemController::class, 'update'])->name('products-variant-item.update');
Route::delete('products-variant-item/{variantItemId}', [VendorProductVariantItemController::class, 'destroy'])->name('products-variant-item.destroy');
Route::put('products-variant-item-status', [VendorProductVariantItemController::class, 'changeStatus'])->name('products-variant-item.change-status');

