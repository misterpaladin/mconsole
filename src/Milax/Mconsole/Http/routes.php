<?php

Route::get('/sitemap.xml', function () {
    return app('API')->sitemap->handle();
});

Route::group([
    'prefix' => config('mconsole.url'),
    'middleware' => ['web', 'mconsole'],
    'namespace' => 'Milax\Mconsole\Http\Controllers',
], function () {
    // Authentication
    Route::get('/login', 'MconsoleController@login');
    Route::post('/login', 'MconsoleController@auth');
    Route::get('/logout', 'MconsoleController@logout');
    
    // Mconsole root
    Route::get('/', function () {
        return redirect(mconsole_url('/dashboard'));
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
        Route::get('/uploads/restore', 'UploadsController@restore');
        Route::get('/uploads/get', 'UploadsController@get');
        Route::get('/uploads/delete/{file}', 'UploadsController@delete');
        Route::group(['prefix' => '/tools'], function () {
            Route::post('/slug', 'ToolsController@slug');
        });
    });
    
    // Resources
    Route::resource('/users', 'UsersController');
    Route::resource('/tags', 'TagsController');
    Route::resource('/roles', 'RolesController');
    Route::resource('/presets', 'PresetsController');
    Route::resource('/menus', 'MenusController');
    Route::resource('/uploads', 'UploadsController');
    Route::resource('/languages', 'LanguagesController');
    
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
    
    // User menus
    Route::post('/users/{user}/menus', 'UsersController@updateMenuOrder');
});
