<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('dashboard');
})->name('/');


/// ========== auth
Route::get('login', 'AuthController@login')->name('login');
Route::post('login', 'AuthController@login_process')->name('login.login_process');
Route::get('logout', 'AuthController@logout')->name('logout');

/// ========== dashboard
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::post('dashboard/transaction', 'DashboardController@transaction')->name('dashboard.transaction');
Route::post('dashboard/popular_product', 'DashboardController@popular_product')->name('dashboard.popular_product');
Route::post('dashboard/warning_raw_material', 'DashboardController@warning_raw_material')->name('dashboard.warning_raw_material');

/// ========== product_category
Route::get('product_category', 'ProductCategoryController@index')->name('product_category');
Route::post('product_category/search', 'ProductCategoryController@search')->name('product_category.search');
Route::get('product_category/info', 'ProductCategoryController@info')->name('product_category.info');
Route::post('product_category/save', 'ProductCategoryController@save')->name('product_category.save');
Route::post('product_category/delete', 'ProductCategoryController@delete')->name('product_category.delete');

/// ========== raw_material_category
Route::get('raw_material_category', 'RawMaterialCategoryController@index')->name('raw_material_category');
Route::post('raw_material_category/search', 'RawMaterialCategoryController@search')->name('raw_material_category.search');
Route::get('raw_material_category/info', 'RawMaterialCategoryController@info')->name('raw_material_category.info');
Route::post('raw_material_category/save', 'RawMaterialCategoryController@save')->name('raw_material_category.save');
Route::post('raw_material_category/delete', 'RawMaterialCategoryController@delete')->name('raw_material_category.delete');

/// ========== staff
Route::get('staff', 'StaffController@index')->name('staff');
Route::post('staff/search', 'StaffController@search')->name('staff.search');
Route::get('staff/info', 'StaffController@info')->name('staff.info');
Route::post('staff/save', 'StaffController@save')->name('staff.save');
Route::post('staff/delete', 'StaffController@delete')->name('staff.delete');

/// ========== customer
Route::get('customer', 'CustomerController@index')->name('customer');
Route::post('customer/search', 'CustomerController@search')->name('customer.search');
Route::get('customer/info', 'CustomerController@info')->name('customer.info');
Route::post('customer/save', 'CustomerController@save')->name('customer.save');
Route::post('customer/delete', 'CustomerController@delete')->name('customer.delete');

/// ========== product
Route::get('product', 'ProductController@index')->name('product');
Route::post('product/search', 'ProductController@search')->name('product.search');
Route::get('product/info', 'ProductController@info')->name('product.info');
Route::post('product/save', 'ProductController@save')->name('product.save');
Route::post('product/delete', 'ProductController@delete')->name('product.delete');

/// ========== raw_material
Route::get('raw_material', 'RawMaterialController@index')->name('raw_material');
Route::post('raw_material/search', 'RawMaterialController@search')->name('raw_material.search');
Route::get('raw_material/info', 'RawMaterialController@info')->name('raw_material.info');
Route::post('raw_material/save', 'RawMaterialController@save')->name('raw_material.save');
Route::post('raw_material/delete', 'RawMaterialController@delete')->name('raw_material.delete');

/// ========== product_detail
Route::get('product_detail', 'ProductDetailController@index')->name('product_detail');
Route::post('product_detail/search', 'ProductDetailController@search')->name('product_detail.search');
Route::get('product_detail/info', 'ProductDetailController@info')->name('product_detail.info');
Route::post('product_detail/save', 'ProductDetailController@save')->name('product_detail.save');
Route::post('product_detail/delete', 'ProductDetailController@delete')->name('product_detail.delete');

/// ========== purchase
Route::get('purchase', 'PurchaseController@index')->name('purchase');
Route::post('purchase/search', 'PurchaseController@search')->name('purchase.search');
Route::get('purchase/info', 'PurchaseController@info')->name('purchase.info');
Route::post('purchase/save', 'PurchaseController@save')->name('purchase.save');
Route::post('purchase/delete', 'PurchaseController@delete')->name('purchase.delete');

Route::post('purchase/detail/save', 'PurchaseController@detail_save')->name('purchase.detail.save');
Route::post('purchase/detail/delete', 'PurchaseController@detail_delete')->name('purchase.detail.delete');

/// ========== transaction
Route::get('transaction', 'TransactionController@index')->name('transaction');
Route::post('transaction/search', 'TransactionController@search')->name('transaction.search');
Route::get('transaction/info', 'TransactionController@info')->name('transaction.info');
Route::post('transaction/save', 'TransactionController@save')->name('transaction.save');
Route::post('transaction/delete', 'TransactionController@delete')->name('transaction.delete');

Route::post('transaction/detail/save', 'TransactionController@detail_save')->name('transaction.detail.save');
Route::post('transaction/detail/delete', 'TransactionController@detail_delete')->name('transaction.detail.delete');

Route::get('transaction/payment', 'TransactionController@payment')->name('transaction.payment');
Route::get('transaction/print', 'TransactionController@print')->name('transaction.print');
