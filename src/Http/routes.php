<?php

Route::group([
	'middleware' => 'mconsole',
	'namespace' => 'Milax\Mconsole\Http\Controllers'
], function () {
	
	/** Authentication */
	Route::get('/mconsole/login', 'MconsoleController@login');
	Route::post('/mconsole/login', 'MconsoleController@auth');
	Route::get('/mconsole/logout', 'MconsoleController@logout');
	
	/** Mconsole root */
	Route::get('/mconsole', 'MconsoleController@index');
	
	/** Resources */
	Route::resource('/mconsole/pages', 'PagesController');
	
});