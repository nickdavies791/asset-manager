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

Route::get('/', function () {
	return redirect('login');
})->middleware('guest');

Route::group(['middleware' => ['auth']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('schools', 'SchoolController');
	Route::resource('categories', 'CategoryController')->except(['index', 'show']);
	Route::resource('types', 'TypeController')->except(['index', 'show']);
	Route::resource('assets', 'AssetController')->except('index');
	Route::get('schools/{school}/assets', 'SchoolAssetController@show')->name('schools.assets');
});