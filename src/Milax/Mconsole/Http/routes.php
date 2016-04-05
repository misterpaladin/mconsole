<?php

Route::group([
    'prefix' => 'mconsole',
    'middleware' => ['web', 'mconsole'],
    'namespace' => 'Milax\Mconsole\Http\Controllers',
], function () {
    
    /** Authentication */
    Route::get('/login', 'MconsoleController@login');
    Route::post('/login', 'MconsoleController@auth');
    Route::get('/logout', 'MconsoleController@logout');
    
    /** Mconsole root */
    Route::get('/', 'MconsoleController@index');
    
    /** API */
    Route::get('/api/notifications', 'APIController@getNotifications');
    Route::get('/api/notifications/{id}/seen', 'APIController@seeNotification');
    
    /** Resources */
    Route::resource('/users', 'UsersController');
    Route::resource('/roles', 'RolesController');
    Route::resource('/presets', 'PresetsController');
    
    Route::group([
        'prefix' => 'modules',
    ], function () {
        Route::get('/', 'ModulesController@index');
        Route::get('/{id}/install', 'ModulesController@install');
        Route::get('/{id}/uninstall', 'ModulesController@uninstall');
    });
    
    Route::resource('/test', 'TestController');
    
});
