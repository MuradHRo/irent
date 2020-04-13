<?php

use Illuminate\Support\Facades\Route;
Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function()
{
    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth','role:admin|super_admin'])->group(function (){
        Route::get('/index','DashboardController@index')->name('index');

        // user Routes
        Route::resource('admins','AdminController')->except('show');
        Route::resource('users','UserController')->except('show');

        // category Routes
        Route::resource('categories','CategoryController')->except('show');
        // SubCategory Routes
        Route::resource('subcategories','SubcategoryController')->except('show');

        // Selection Routes
        Route::resource('selections','SelectionController')->except('show');

        // Question Routes
        Route::resource('questions','QuestionController')->except('show');

        // Advertisement Routes
        Route::resource('advertisements','AdvertisementController');
    });

});

