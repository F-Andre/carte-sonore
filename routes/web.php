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

Auth::routes(['register' => false]);

Route::get('/', 'FrontController@index');

Route::get('/admin', 'AdminController@index')->name('admin.home');

Route::resource('audio', 'AudioController');
Route::resource('card', 'CardController');
Route::resource('category', 'CategoryController');
Route::resource('group', 'GroupController');
Route::resource('photo', 'PhotoController');
Route::resource('pathway', 'PathwayController');
