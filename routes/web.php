<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// All of the Admin Routes
Route::prefix('/admin')->namespace('Admin')->group(function(){

    Route::match(['get', 'post'], '/', 'AdminController@login');
    
    Route::group(['middleware'=>['admin']], function () {
        
        Route::get('dashboard', 'AdminController@dashboard');
        Route::get('settings', 'AdminController@settings');
        Route::get('logout', 'AdminController@logout');
        Route::post('check-current-password', 'AdminController@chkCurrentPassword');
        Route::post('update-current-password', 'AdminController@updateCurrentPassword');
        Route::match(['get','post'], 'update-admin-details', 'AdminController@updateAdminDetails');
        
        // Sections
        Route::get('sections', 'SectionController@index');
        Route::post('update-section-status', 'SectionController@updateSectionStatus');

        // Categories
        Route::get('categories', 'CategoryController@index');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        Route::post('append-categories-level', 'CategoryController@appendCategoriesLevel');
        Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}', 'CategoryController@deleteCategory');

        // Products
        Route::get('products', 'ProductController@index');
        Route::post('update-product-status', 'ProductController@updateProductStatus');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductController@addEditProduct');
        Route::get('delete-product/{id}', 'ProductController@deleteProduct');
        Route::match(['get','post'], 'add-edit-product/{id?}',"ProductController@addEditProduct");
        Route::get('delete-product-image/{id}', 'ProductController@deleteProductImage');
        Route::get('delete-product-video/{id}', 'ProductController@deleteProductVideo');
        // Product Attributes
        Route::match(['get', 'post'], 'add-edit-product-attributes/{id?}', 'ProductController@addEditProductAttributes');

    });    
    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
