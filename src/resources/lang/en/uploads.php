<?php

return [
    'menu' => [
        'name' => 'Uploads',
    ],
    'table' => [
        'type' => 'Type',
        'path' => 'Path',
        'filename' => 'File name',
        'copies' => 'Copies',
        'related' => 'Related object',
    ],
    'filter' => [
        'filename' => 'File name',
        'type' => 'Type',
    ],
    'acl' => [
        'uploadlist' => 'Uploads: view attached files',
        'upload' => 'Uploads: upload attached files',
        'index' => 'Uploads: show list',
        'create' => 'Uploads: show create form',
        'store' => 'Uploads: saving',
        'edit' => 'Uploads: show edit form',
        'update' => 'Uploads: updating',
        'show' => 'Uploads: view',
        'destroy' => 'Uploads: delete',
    ],
    'form' => [
        'name' => 'Upload files',
        'help' => [
            'name' => 'Help',
            'text' => '',
        ],
    ],
];
