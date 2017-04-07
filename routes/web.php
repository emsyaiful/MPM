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
    return view('welcome');
});

// Authentifikasi
Auth::routes();

// Route::get('/home', 'HomeController@index');
Route::group(['middleware' => 'auth'], function() {
	Route::get('/home', 'AdminController@getUserDetail')->name('home');

	//Route management user
	Route::get('/user', 'AdminController@getAllUser')->name('user');
	Route::post('/update', 'AdminController@updateUser');
	Route::delete('/delete/{id}', 'AdminController@deleteUser');
	Route::post('/create', 'AdminController@createUser');
	Route::get('/change/{id}', 'AdminController@changeForm');
	Route::post('/change', 'AdminController@changePass');

	// Route Questionare
	Route::resource('questionare', 'QuestionareController');
	Route::resource('task', 'TaskController');
	Route::get('/reportExcel/{id}', 'QuestionareController@reportExcel');

});

// Email
Route::get('/testMail', 'AdminController@cobaMail');