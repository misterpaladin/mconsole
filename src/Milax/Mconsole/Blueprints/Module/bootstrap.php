<?php

use App\Mconsole\%s\Installer;

/**
 * %s module bootstrap file
 */
return [
    'name' => '%s',
    'identifier' => 'mconsole-%s',
    'description' => '',
    'menu' => [],
    'register' => [
        'middleware' => [],
        'providers' => [],
        'aliases' => [],
        'bindings' => [],
        'dependencies' => [],
    ],
    'install' => function () {
        Installer::install();
    },
    'uninstall' => function () {
        Installer::uninstall();
    },
    'init' => function () {
        // ..
    },
];
