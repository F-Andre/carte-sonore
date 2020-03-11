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

Route::get('/', 'FrontController@index');

Route::get('/admin', 'AdminController@index');

Route::resource('audio', 'AudioController');
Route::resource('card', 'CardController');
Route::resource('group', 'GroupController');
Route::resource('image', 'ImageController');
Route::resource('pathway', 'PathwayController');