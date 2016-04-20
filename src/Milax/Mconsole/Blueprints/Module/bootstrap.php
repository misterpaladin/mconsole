<?php

use %s\Mconsole\%s\Installer;

/**
 * %s module bootstrap file
 */
return [
    'name' => '%s',
    'identifier' => 'mconsole-%s',
    'description' => '',
    'depends' => [],
    'menu' => [],
    'register' => [
        'middleware' => [],
        'providers' => [
            %s\Mconsole\%s\Provider::class,
        ],
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
