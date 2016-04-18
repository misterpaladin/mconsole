<?php

/**
 * %s module routes file
 */
Route::group([
    'prefix' => 'mconsole',
    'middleware' => ['web', 'mconsole'],
    'namespace' => '%s\Mconsole\%s\Http\Controllers',
], function () {
    
    //

});
