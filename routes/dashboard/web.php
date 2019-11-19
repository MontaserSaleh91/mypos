<?php

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {

        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

            Route::get('/', 'WelcomeController@index')->name('welcome');

            //category routes
            Route::resource('categories', 'CategoryController')->except(['show']);

            //product routes
            Route::resource('products', 'ProductController')->except(['show']);

            //stock show
            Route::get('stock','StockController@index')->name('product.stock');

            //client routes
            Route::resource('clients', 'ClientController')->except(['show']);
            Route::resource('clients.orders', 'Client\OrderController')->except(['show']);

            //order routes
            Route::resource('orders', 'OrderController');
            Route::get('/orders/{order}/products', 'OrderController@products')->name('orders.products');


            //user routes
            Route::resource('users', 'UserController')->except(['show']);

            //data show
            Route::get('data','DataController@index')->name('data');


            //Units
            Route::get('units','UnitController@index')->name('units');
            Route::post('units','UnitController@store')->name('units.store');
            Route::delete('units/{id}','UnitController@destroy')->name('units.delete');
            Route::get('units/{id}', 'UnitController@edit')->name('units.edit');
            Route::post('units/{id}', 'UnitController@update')->name('units.update');

        });//end of dashboard routes
    });


