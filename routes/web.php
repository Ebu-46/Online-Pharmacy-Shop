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

// frontend

Route::get('/', 'Frontend\PagesController@index')->name('index');
Route::get('/contact', 'Frontend\PagesController@contact')->name('contact');
Route::get('/search', 'Frontend\PagesController@search')->name('search');

Route::get('/products', 'Frontend\ProductsController@index')->name('products');
Route::get('/products/{slug}', 'Frontend\ProductsController@show')->name('product.show');
// user route
Route::get('/user/dashboard', 'Frontend\UsersController@dashboard')->name('dashboard');
Route::get('/user/edit', 'Frontend\UsersController@edit')->name('user.edit');
Route::post('/user/dashboard', 'Frontend\UsersController@update')->name('user.update');

// cart route
Route::get('/cart', 'Frontend\CartsController@index')->name('cart');
Route::post('/cart/store', 'Frontend\CartsController@store')->name('cart.store');
Route::post('/cart/update/{id}', 'Frontend\CartsController@update')->name('cart.update');
Route::post('/cart/delete/{id}', 'Frontend\CartsController@delete')->name('cart.delete');

// checkout route
Route::get('/checkout', 'Frontend\CheckoutsController@index')->name('checkout');
Route::post('/checkout/store', 'Frontend\CheckoutsController@store')->name('checkout.store');

// backend

Route::group(['prefix' => 'admin'],function(){
    Route::get('/','Backend\PagesController@index')->name('admin.index');

    //Products routes
    Route::group(['prefix' => '/products'],function(){
        Route::get('/','Backend\ProductsController@index')->name('admin.products');
        Route::get('/create','Backend\ProductsController@create')->name('admin.product.create');
        Route::get('/edit/{id}','Backend\ProductsController@edit')->name('admin.product.edit');
        //above get request changing to post for test

        // below post request
        Route::post('/store','Backend\ProductsController@store')->name('admin.product.store');
        Route::post('/edit/{id}','Backend\ProductsController@update')->name('admin.product.update');
        Route::post('/delete/{id}','Backend\ProductsController@delete')->name('admin.product.delete');
    });

    //Categories routes
    Route::group(['prefix' => '/categories'],function(){
        Route::get('/','Backend\CategoriesController@index')->name('admin.categories');
        Route::get('/create','Backend\CategoriesController@create')->name('admin.category.create');
        Route::get('/edit/{id}','Backend\CategoriesController@edit')->name('admin.category.edit');
        //above get request changing to post for test

        // below post request
        Route::post('/store','Backend\CategoriesController@store')->name('admin.category.store');
        Route::post('/edit/{id}','Backend\CategoriesController@update')->name('admin.category.update');
        Route::post('/delete/{id}','Backend\CategoriesController@delete')->name('admin.category.delete');
    });

    //Brands routes
    Route::group(['prefix' => '/brands'],function(){
        Route::get('/','Backend\BrandsController@index')->name('admin.brands');
        Route::get('/create','Backend\BrandsController@create')->name('admin.brand.create');
        Route::get('/edit/{id}','Backend\BrandsController@edit')->name('admin.brand.edit');
        //above get request changing to post for test

        // below post request
        Route::post('/store','Backend\BrandsController@store')->name('admin.brand.store');
        Route::post('/edit/{id}','Backend\BrandsController@update')->name('admin.brand.update');
        Route::post('/delete/{id}','Backend\BrandsController@delete')->name('admin.brand.delete');
    });

    
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
