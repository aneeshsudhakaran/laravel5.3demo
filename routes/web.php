<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Auth::routes();

Route::group(['middleware' => ['guest']], function () {
    
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', function () {
        return view('frontend.home');
    });
    
    
    // ADMIN
    Route::get('admin/login', 'backend\Auth\LoginController@getLoginForm');
    Route::post('admin/authenticate', 'backend\Auth\LoginController@authenticate');
    
    Route::get('admin/register', 'backend\Auth\RegisterController@getRegisterForm');
    Route::post('admin/saveregister', 'backend\Auth\RegisterController@saveRegisterForm');
    
    // USER 
    Route::get('user/login', 'frontend\Auth\LoginController@getLoginForm');
    Route::post('user/authenticate', 'frontend\Auth\LoginController@authenticate');
    
    Route::get('user/register', 'frontend\Auth\RegisterController@getRegisterForm');
    Route::post('user/saveregister', 'frontend\Auth\RegisterController@saveRegisterForm');


});


Route::group(['middleware' => ['user']], function () {
    
    Route::post('user/logout', 'frontend\Auth\LoginController@getLogout');
    Route::get('user/dashboard', 'frontend\UserController@dashboard');
    
    Route::get('user/dashboard1/', function () {
        
        return view('frontend.dashboard');
    });
    
});



Route::group(['middleware' => ['admin']], function () {
    
    
    Route::get('admin/dashboard', 'backend\AdminController@dashboard');
    Route::post('admin/logout', 'backend\Auth\LoginController@getLogout');
    
    
});


