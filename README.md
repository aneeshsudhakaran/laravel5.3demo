# Laravel-5.3 Demo
laravel 5.3 Demo for Multiauth with user and admin table

# Configurations:

# /config/auth.php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
	'user' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
	'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Model\frontend\User::class,
        ],
	'admins' => [
            'driver' => 'eloquent',
            'model' => App\Model\backend\Admin::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
	'admins' => [
            'provider' => 'admins',
            'table' => 'admins_password_resets',
            'expire' => 60,
        ],
    ],

];

# routes/web.php

<?php

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

# app/Http/Kernel.php
Add with protected $routeMiddleware = [

	      + 'admin' => \App\Http\Middleware\CheckAdmin::class,
        + 'user' => \App\Http\Middleware\CheckUser::class,

#/app/Http/Middleware

CheckAdmin.php ->> For check admin 

CheckUser.php  ->> For check user



# Migration Tables
## /database/migrations

2014_10_12_000000_create_users_table.php

2014_10_12_100000_create_password_resets_table.php

2016_10_18_131257_create_admins_table.php

2016_10_18_131630_create_admins_passowrd_resets_table.php


# Import Tables : 

Excecute

php artisan migrate
