<?php

return [
    'menu' => [
        'list' => [
            'name' => 'Upload presets',
            'description' => 'List of presets',
        ],
        'create' => [
            'name' => 'Add preset',
            'description' => 'Add a new preset for upload files',
        ],
        'update' => [
            'name' => 'Edit preset',
            'description' => 'Change the requirements for the uploaded files, as well as add/delete operations of image processing',
        ],
        'delete' => [
            'name' => 'Delete preset',
            'description' => '',
        ],
    ],
    'types' => [
        'image' => 'Images',
        'document' => 'Documents',
        'audio' => 'Audio files',
        'video' => 'Video files',
    ],
    'table' => [
        'id' => '#',
        'name' => 'Name',
        'type' => 'Applies to',
        'operations' => 'Number of rules',
    ],
    'form' => [
        'type' => 'Applies to',
        'width' => 'Width',
        'height' => 'Height',
        'main' => 'Main',
        'operations' => [
            'title' => 'Image processing rules',
            'add' => 'Add rule',
            'type' => 'Rule type',
            'remove' => 'Delete',
            'resize' => [
                'name' => 'Resize',
                'ratio' => 'Preserve aspect ratio',
                'center' => 'Center',
                'fixed' => 'Fixed size',
            ],
            'save' => [
                'path' => 'Subdirectory',
                'quality' => 'Quality',
                'pathhelp' => 'Directory will be appended to the directory preset. When using the directory from another rule file will be overwritten!',
            ],
            'watermark' => [
                'top' => 'Top',
                'center' => 'Center',
                'bottom' => 'Bottom',
                'left' => 'Left',
                'right' => 'Right',
            ],
            'types' => [
                'groups' => [
                    'file' => 'File',
                    'actions' => 'Operations',
                    'filters' => 'Filters',
                ],
                'notselected' => 'Not selected',
                'loadoriginal' => 'Load original file',
                'resize' => 'Resize',
                'save' => 'Save a copy',
                'watermark' => 'Apply watermark',
                'greyscale' => 'Greyscale',
            ],
        ],
        'sequence' => 'All operations are executed sequentially',
        'name' => 'Preset name',
        'extensions' => 'Allowed file extensions (wihout dots, separated by comma)',
        'minwidth' => 'Minimum width',
        'minheight' => 'Minimum height',
        'path' => 'Save directory',
        'imageonly' => 'Rrocessing rules is available only for images',
    ],
];
