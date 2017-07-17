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
    // return view('welcome');
    return redirect()->route('home');
});

// Authentifikasi
Auth::routes();

// Route::get('/home', 'HomeController@index');
Route::group(['middleware' => 'auth'], function() {
	Route::get('/home', 'AdminController@getUserDetail')->name('home');

	//Route management user
	Route::get('/division', 'AdminController@divisionList')->name('division');
	Route::post('/division', 'AdminController@divisionCreate');
	Route::post('/divisionEdit', 'AdminController@divisionEdit');
	Route::delete('/division/{id}', 'AdminController@divisionDelete');

	Route::get('/kares', 'AdminController@karesList')->name('kares');
	Route::post('/kares', 'AdminController@karesCreate');
	Route::post('/karesEdit', 'AdminController@karesEdit');
	Route::delete('/kares/{id}', 'AdminController@karesDelete');

	Route::get('/kota', 'AdminController@kotaList')->name('kota');
	Route::post('/kota', 'AdminController@kotaCreate');
	Route::post('/kotaEdit', 'AdminController@kotaEdit');
	Route::delete('/kota/{id}', 'AdminController@kotaDelete');

	Route::get('/md', 'AdminController@mdList')->name('md');
	Route::post('/md', 'AdminController@mdCreate');
	Route::post('/mdEdit', 'AdminController@mdEdit');
	Route::delete('/md/{id}', 'AdminController@mdDelete');

	Route::get('/status', 'AdminController@statusList')->name('status');
	Route::post('/status', 'AdminController@statusCreate');
	Route::post('/statusEdit', 'AdminController@statusEdit');
	Route::delete('/status/{id}', 'AdminController@statusDelete');

	Route::get('/dealer', 'AdminController@dealerList')->name('dealer');
	Route::post('/dealer', 'AdminController@dealerCreate');
	Route::post('/dealerEdit', 'AdminController@dealerEdit');
	Route::delete('/dealer/{id}', 'AdminController@dealerDelete');

	Route::get('/userDivision', 'AdminController@userDivisionList')->name('userDivision');
	Route::post('/userDivision', 'AdminController@userDivisionCreate');
	Route::post('/userDivisionEdit', 'AdminController@userDivisionEdit');
	Route::delete('/userDivision/{id}', 'AdminController@userDivisionDelete');

	// Route::post('/update', 'AdminController@updateUser');
	// Route::delete('/delete/{id}', 'AdminController@deleteUser');
	Route::post('/create', 'AdminController@createUser');
	Route::get('/change/{id}', 'AdminController@changeForm');
	Route::post('/change', 'AdminController@changePass');

	// Route Questionare
	Route::get('questionare/other', 'QuestionareController@otherQuestionare');
	Route::get('questionare/other/{id}', 'QuestionareController@viewOtherQuestionare');
	Route::resource('questionare', 'QuestionareController');
	Route::resource('task', 'TaskController');
	Route::get('/reportExcel/{id}', 'QuestionareController@reportExcel');

});

// Email
Route::get('/testMail', 'AdminController@cobaMail');
Auth::routes();

// Route::get('/home', 'HomeController@index');
