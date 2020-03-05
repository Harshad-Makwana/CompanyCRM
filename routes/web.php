<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'], function() {
	Route::group(['middleware' => 'is_admin', 'prefix' => 'admin'], function() {
		Route::get('/home', 'HomeController@adminHome')->name('admin.home');
		
		Route::resource('/company','CompanyController');

		Route::resource('/employee','EmployeeController');
	});
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', 'HomeController@index')->name('home');
