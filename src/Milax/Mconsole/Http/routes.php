<?php

use Milax\Mconsole\Http\Controllers\MconsoleController;
use Milax\Mconsole\Http\Controllers\ModulesController;
use Milax\Mconsole\Http\Controllers\SettingsController;
use Milax\Mconsole\Http\Controllers\VariablesController;
use Milax\Mconsole\Http\Controllers\UsersController;
use Milax\Mconsole\Http\Controllers\API\NotificationsController;
use Milax\Mconsole\Http\Controllers\API\SearchController;
use Milax\Mconsole\Http\Controllers\API\UploadsController;
use Milax\Mconsole\Http\Controllers\API\ToolsController;

Route::get('/sitemap.xml', function () {
    return app('API')->sitemap->handle();
});

Route::group([
    'prefix' => config('mconsole.url'),
    'middleware' => ['web', 'mconsole'],
    'namespace' => 'Milax\Mconsole\Http\Controllers',
], function () {
    // Authentication
    Route::get('/login', [MconsoleController::class, 'login']);
    Route::post('/login', [MconsoleController::class, 'auth']);
    Route::get('/logout', [MconsoleController::class, 'logout']);
    
    // Mconsole root
    Route::get('/', function () {
        return redirect(mconsole_url('/dashboard'));
    });
    Route::get('/dashboard', [MconsoleController::class, 'index']);
    
    // API
    Route::group([
        'prefix' => 'api',
        'namespace' => 'API',
    ], function () {
        Route::get('/notifications', [NotificationsController::class, 'handle']);
        Route::get('/notifications/{id}/seen', [NotificationsController::class, 'markAsSeen']);
        Route::get('/search', [SearchController::class, 'handle']);
        Route::get('/search/{namespace}', [SearchController::class, 'handle']);
        Route::any('/uploads/upload', [UploadsController::class, 'upload']);
        Route::get('/uploads/restore', [UploadsController::class, 'restore']);
        Route::get('/uploads/get', [UploadsController::class, 'get']);
        Route::get('/uploads/delete/{file}', [UploadsController::class, 'delete']);
        Route::group(['prefix' => '/tools'], function () {
            Route::post('/slug', [ToolsController::class, 'slug']);
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
        Route::get('/', [ModulesController::class, 'index']);
        Route::get('/{id}/install', [ModulesController::class, 'install']);
        Route::get('/{id}/uninstall', [ModulesController::class, 'uninstall']);
        Route::get('/{id}/extend', [ModulesController::class, 'extend']);
    });
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::post('/settings', [SettingsController::class, 'save']);
    Route::get('/settings/clearcache', [SettingsController::class, 'clearCache']);
    Route::get('/settings/reloadtrans', [SettingsController::class, 'reloadTranslations']);
    
    // Variables
    Route::get('/variables', [VariablesController::class, 'index']);
    Route::post('/variables', [VariablesController::class, 'save']);
    
    // User menus
    Route::post('/users/{user}/menus', [UsersController::class, 'updateMenuOrder']);
});
