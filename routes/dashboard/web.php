<?php
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],function()
    {
        Route::group(['prefix'=>'dashboard','as'=>'dashboard.'],function (){
        Route::get('/index','DashboardController@index')->name('index');
        Route::resource('users','UserController');
    });

});


