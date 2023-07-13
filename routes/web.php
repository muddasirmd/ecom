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


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

/**
 *          All of the Admin Routes
 **/
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

        // Banners
        Route::get('banners', 'BannerController@index');
        Route::post('update-banner-status', 'BannerController@updateBannerStatus');
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannerController@addEditBanner');
        Route::get('delete-banner/{id}', 'BannerController@deleteBanner');
        Route::get('delete-banner-image/{id}', 'BannerController@deleteBannerImage');

        // Brands
        Route::get('brands', 'BrandController@index');
        Route::post('update-brand-status', 'BrandController@updateBrandStatus');
        Route::get('delete-brand/{id}', 'BrandController@deleteBrand');
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');
        

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
        Route::match(['get', 'post'], 'add-edit-product/{id?}', "ProductController@addEditProduct");
        Route::get('delete-product/{id}', 'ProductController@deleteProduct');
        Route::get('delete-product-image/{id}', 'ProductController@deleteProductImage');
        Route::get('delete-product-video/{id}', 'ProductController@deleteProductVideo');
        // Product Attributes
        Route::match(['get', 'post'], 'add-product-attributes/{id?}', 'ProductController@addProductAttributes');
        Route::post('edit-product-attributes/{id?}', 'ProductController@editProductAttributes');
        Route::post('update-product-attribute-status', 'ProductController@updateProductAttributeStatus');
        Route::get('delete-product-attribute/{id}', 'ProductController@deleteProductAttribute');
        // Product Images
        Route::match(['get', 'post'], 'add-product-image/{id?}', 'ProductController@addProductImages');
        Route::post('edit-product-image/{id?}', 'ProductController@editProductImages');
        Route::post('update-product-image-status', 'ProductController@updateProductImageStatus');
        Route::get('delete-product-images/{id}', 'ProductController@deleteProductImages');


    });    
    
});

Auth::routes();

/**
 *      Front Routes
 * 
 */

 Route::namespace('Front')->group(function(){

    Route::get('/', 'IndexController@index');
    Route::get('/{url}', 'ProductController@listing');
 });

// Route::get('/home', 'HomeController@index')->name('home');
