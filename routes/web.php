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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('units/search/{keyword}', 'UnitController@search')->name('units.search');
    Route::get('pastpapers/search/{keyword}', 'PastpaperController@search')->name('units.search');
    Route::get('sample-exam', 'SampleExamController@index')->name('sampleExam.index');
    Route::get('sample-exam/generate/{keyword}', 'SampleExamController@generate')->name('sampleExam.generate');
    Route::post('sample-exam/download', 'SampleExamController@download')->name('sampleExam.download');
    Route::get('profile', 'ProfileController@showProfilePage')->name('profile');
    Route::post('name', 'ProfileController@updateName')->name('update_name');
    Route::post('email', 'ProfileController@updateEmail')->name('update_email');
    Route::post('password', 'ProfileController@updatePassword')->name('update_password');
    
});

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

    Route::group(['middleware' => ['admin']], function () {
        Route::get('home', 'HomeController@admin_index')->name('admin.home');
        Route::get('profile', 'ProfileController@showAdminProfilePage')->name('admin.profile');
        Route::post('name', 'ProfileController@adminUpdateName')->name('admin.update_name');
        Route::post('email', 'ProfileController@adminUpdateEmail')->name('admin.update_email');
        Route::post('password', 'ProfileController@adminUpdatePassword')->name('admin.update_password');
        Route::resource('pastpapers', 'PastpaperController');
        Route::resource('departments', 'DepartmentController');
        Route::resource('units', 'UnitController');
        Route::get('admins', 'AdminsController@index')->name('admins.index');
        Route::get('admins/create', 'AdminsController@create')->name('admins.create');
        Route::post('admins/store', 'AdminsController@store')->name('admins.store');
        Route::delete('admins/{id}', 'AdminsController@destroy')->name('admins.destroy');
    });
});
