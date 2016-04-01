<?php

/**
 * %s module routes file
 */
Route::group([
    'prefix' => 'mconsole',
    'middleware' => ['web', 'mconsole'],
    'namespace' => 'App\Mconsole\%s\Http\Controllers',
], function () {
    
    //

});
