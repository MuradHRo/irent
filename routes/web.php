<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function() {
    //Home
    Route::get('/', 'HomeController@index')->name('index');

    //Login Social Accounts
    Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider')->name('login');
    Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

    //Advertisement Routes
    Route::resource('advertisements','AdvertisementController');

    //Auth Routes
    Auth::routes();
});
