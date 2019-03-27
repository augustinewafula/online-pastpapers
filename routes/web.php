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
    return view('auth.login');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login_form');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register_form');
Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email Verification Routes...
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return view('admin.auth.login');
    });
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin_login_form');
    Route::post('/login', 'AdminAuth\LoginController@login')->name('admin_login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin_logout');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin_password.email');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('admin_password.reset');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin_password.request');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
    Route::get('/home', 'HomeController@admin_index')->name('admin_home');
});
