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
 * Child Care API 1.0 - Un-Authenticated Routes
 */
Route::group(['prefix' => 'api/v1', 'middleware' => 'cors'], function(){
	Route::post('signin', 'SigninController@signin');
	Route::post('user/facilities', 'UserController@getUserFacilities');
});

/**
 * Child Care API 1.0 - Authenticated Routes
 */
Route::group(['prefix' => 'api/v1', 'middleware' => ['cors', 'auth.token']], function(){

	Route::resource('user', 'UserController');
	Route::resource('facility', 'FacilityController');
	Route::resource('child', 'ChildrenController');

	Route::post('child/{id}/checkin', 'ChildrenController@checkin');
	Route::post('child/{id}/checkout', 'ChildrenController@checkout');
	Route::get('child/{id}/attendance', 'ChildrenController@attendance');

	//  http://localhost:8000/api/v1/child/1/contacts
	Route::get('child/{id}/contacts', 'ChildrenController@contacts');
	
	Route::post('child/{id}/pickup', 'ChildrenController@pickup');

	//attach/detach
	Route::post('attach/parent', 'UserController@attachParent');
	Route::post('attach/contact', 'UserController@attachContact');	
	Route::post('attach/physician', 'UserController@attachPhysician');


	Route::resource('allergies', 'AllergiesController');
	Route::resource('note', 'NoteController');
	Route::get('note/child/{id}', 'NoteController@getChildNotes');

});