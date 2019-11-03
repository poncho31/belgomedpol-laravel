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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('language', 'HomeController@language')->name('language');
Route::resource('politician', 'PoliticianController');
Route::resource('article', 'ArticleController');
Route::get('administration', 'AdministrationController@index');
;