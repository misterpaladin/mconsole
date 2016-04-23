<?php

Route::group([
    'prefix' => 'mconsole',
    'middleware' => ['web', 'mconsole'],
    'namespace' => 'Milax\Mconsole\Http\Controllers',
], function () {
    
    // Authentication
    Route::get('/login', 'MconsoleController@login');
    Route::post('/login', 'MconsoleController@auth');
    Route::get('/logout', 'MconsoleController@logout');
    
    // Mconsole root
    Route::get('/', function () {
        return redirect('/mconsole/dashboard');
    });
    Route::get('/dashboard', 'MconsoleController@index');
    
    // API
    Route::group([
        'prefix' => 'api',
        'namespace' => 'API',
    ], function () {
        Route::get('/notifications', 'NotificationsController@handle');
        Route::get('/notifications/{id}/seen', 'NotificationsController@markAsSeen');
        Route::get('/search', 'SearchController@handle');
        Route::get('/search/{namespace}', 'SearchController@handle');
        Route::any('/uploads/upload', 'UploadsController@upload');
        Route::get('/uploads/get', 'UploadsController@get');
        Route::get('/uploads/delete/{file}', 'UploadsController@delete');
    });
    
    // Resources
    Route::resource('/users', 'UsersController');
    Route::resource('/tags', 'TagsController');
    Route::resource('/roles', 'RolesController');
    Route::resource('/presets', 'PresetsController');
    Route::resource('/menus', 'MenusController');
    Route::resource('/uploads', 'UploadsController');
    
    // Modules
    Route::group([
        'prefix' => 'modules',
    ], function () {
        Route::get('/', 'ModulesController@index');
        Route::get('/{id}/install', 'ModulesController@install');
        Route::get('/{id}/uninstall', 'ModulesController@uninstall');
        Route::get('/{id}/extend', 'ModulesController@extend');
    });
    
    // Settings
    Route::get('/settings', 'SettingsController@index');
    Route::post('/settings', 'SettingsController@save');
    Route::get('/settings/clearcache', 'SettingsController@clearCache');
    Route::get('/settings/reloadtrans', 'SettingsController@reloadTranslations');
    
    // Variables
    Route::get('/variables', 'VariablesController@index');
    Route::post('/variables', 'VariablesController@save');

});
