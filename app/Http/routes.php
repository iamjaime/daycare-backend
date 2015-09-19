<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


/**
 * Child Care API 1.0 - Authenticated Routes
 */
Route::group(['prefix' => 'api/v1', 'before' => 'auth.token'], function(){

	Route::resource('user', 'UserController');
	Route::resource('facility', 'FacilityController');
	Route::resource('child', 'ChildrenController');
	//attach/detach
	Route::post('attach/parent', 'UserController@attachParent');
	Route::post('attach/contact', 'UserController@attachContact');	
	Route::post('attach/physician', 'UserController@attachPhysician');

	Route::resource('allergies', 'AllergiesController');
	Route::resource('checkin', 'CheckinController');

});