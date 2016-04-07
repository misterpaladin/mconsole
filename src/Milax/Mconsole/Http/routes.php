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
    Route::get('/api/search', 'APIController@doSearch');
    
    /** Resources */
    Route::resource('/users', 'UsersController');
    Route::resource('/roles', 'RolesController');
    Route::resource('/presets', 'PresetsController');
    
    /** Modules */
    Route::group([
        'prefix' => 'modules',
    ], function () {
        Route::get('/', 'ModulesController@index');
        Route::get('/reloadtrans', 'ModulesController@reloadTranslations');
        Route::get('/{id}/install', 'ModulesController@install');
        Route::get('/{id}/uninstall', 'ModulesController@uninstall');
        Route::get('/{id}/extend', 'ModulesController@extend');
    });
    
    Route::resource('/test', 'TestController');
    
});
