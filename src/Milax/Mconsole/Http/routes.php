<?php

Route::group([
	'prefix' => 'mconsole',
	'middleware' => ['web', 'mconsole'],
	'namespace' => 'Milax\Mconsole\Http\Controllers'
], function () {
	
	/** Authentication */
	Route::get('/login', 'MconsoleController@login');
	Route::post('/login', 'MconsoleController@auth');
	Route::get('/logout', 'MconsoleController@logout');
	
	/** Mconsole root */
	Route::get('/', 'MconsoleController@index');
	
	/** Resources */
	Route::resource('/pages', 'PagesController');
	Route::resource('/users', 'UsersController');
	Route::resource('/roles', 'RolesController');
	Route::resource('/permissions', 'PermissionsController');
	Route::resource('/news', 'NewsController');
	
	
});