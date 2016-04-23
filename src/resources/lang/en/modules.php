<?php

return [
    'menu' => [
        'name' => 'Modules',
        'description' => 'List available modules',
    ],
    'table' => [
        'title' => 'Modues list',
        'suggested' => 'Additional modules on Packagist',
        'info' => 'Information',
        'uninstall' => [
            'process' => 'Uninstalling..',
            'info' => 'Delete module, including all data',
            'modal' => [
                'title' => 'Delete module?',
                'content' => 'Attention! Deleting deletes all module files, as well as all information in the database. Are you sure you want to continue?',
                'cancel' => 'Cancel',
                'uninstall' => 'Delete',
            ],
        ],
        'install' => [
            'process' => 'Installing..',
            'info' => 'Install module',
            'package' => 'Install',
        ],
        'extend' => [
            'process' => 'Extending..',
            'custom' => '',
            'extended' => '',
            'base' => '',
        ],
        'buttons' => [
            'uninstall' => 'Uninstall',
            'install' => 'Install',
            'extend' => 'Extend',
        ],
        'installed' => 'Installed',
        'available' => 'Available',
        'notavailable' => 'Unavailable',
        'depends' => 'Dependencies',
        'components' => 'Components',
        'extended' => 'Extended components',
        'base' => 'Base components',
        'models' => 'Model',
        'controllers' => 'Controllers',
        'requests' => 'Requests',
        'migrations' => 'Migrations',
        'views' => 'Views',
        'translations' => 'Language files',
        'unabletoinstall' => 'Installation not possible, required modules is not installed in system',
    ],
];
