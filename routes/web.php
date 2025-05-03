<?php

use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\WishlistController;

Auth::routes();

//Home
Route::get('/', [HomeController::class, 'index'])->name('home.index');
//shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');
//cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('cart/increase-qunatity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('cart/decrease-qunatity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.item.remove');
Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.empty');

//User
Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});
//Admin
Route::middleware(['auth', AuthAdmin::class])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    //brand
    Route::get('admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
    Route::post('admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update', [AdminController::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand/delete/{id}', [AdminController::class, 'brand_delete'])->name('admin.brand.delete');
    //categories
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
    Route::post('admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/category/update', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/delete/{id}', [AdminController::class, 'category_delete'])->name('admin.category.delete');
    //product
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{id}', [AdminController::class, 'product_delete'])->name('admin.product.delete');
});

//wishlust
Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');



//gugel_login
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
