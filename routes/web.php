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
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth']], function () {

        // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

        // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('logs', 'LogsController@index');
});

Route::get('/', 'HomeController@index');
Route::get('language', 'HomeController@language')->name('language');
Route::resource('politician', 'PoliticianController');
Route::resource('article', 'ArticleController');
Route::get('administration', 'AdministrationController@index');
;