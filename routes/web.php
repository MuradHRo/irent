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
    Route::get('/dashboard/advertisements/getquestions/','Dashboard\AdvertisementController@getquestions');
    Route::get('/advertisements/comment/add/','AdvertisementController@addComment')->middleware('auth');
    Route::get('/advertisements/comment/update/','AdvertisementController@updateComment')->middleware('auth');
    Route::get('/advertisements/comment/delete/','AdvertisementController@deleteComment')->middleware('auth');
    Route::get('/advertisements/{advertisement_id}/renew/','AdvertisementController@renew')->name('advertisements.renew');
    Route::get('/advertisements/report/{advertisement}','AdvertisementController@report')->name('advertisements.report');
    Route::post('/advertisements/mark_unavailable/{advertisement}','AdvertisementController@markUnavailable')->middleware('auth')->name('advertisements.mark_unavailable');
    Route::get('/advertisements/mark_available/{advertisement}','AdvertisementController@markAvailable')->middleware('auth')->name('advertisements.mark_available');
    Route::resource('advertisements','AdvertisementController');

    //User Routes
    Route::get('users/{user}/profile/','UserController@profile')->name('users.profile');

    //Message Routes
    Route::get('message' , 'HomeController@sendMessage')->middleware('auth');
    Route::get('message/getUsers' , 'HomeController@getUsers')->middleware('auth');
    Route::get('message/getMessages' , 'HomeController@getMessages')->middleware('auth');

    // SSE
    Route::get('/SSE','HomeController@SSE')->middleware('auth');

    //Auth Routes
    Auth::routes();
});
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
