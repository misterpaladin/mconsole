<?php

return [
    'menu' => [
        'name' => 'Settings',
        'description' => 'View list settings',
        'update' => [
            'name' => 'Edit settings',
            'description' => 'Save settings',
        ],
    ],
    'main' => 'Settings',
    'saved' => 'Settings saved',
    'labels' => [
        'name' => 'Project name',
        'url' => 'Website url',
        'notifications' => 'Notifications',
        'editredirect' => 'Redirect to edit after saving',
        'editor' => 'HTML editor Type',
    ],
    'options' => [
        'enabled' => 'Status',
        'group' => [
            'name' => 'Main',
            'other' => 'Other',
        ],
        'on' => 'Enabled',
        'off' => 'Disabled',
        'textarea' => 'Textarea',
        'ckeditor' => 'CKEditor',
    ],
    'additional' => [
        'name' => 'Additional',
        'cache' => [
            'clear' => 'Clear cache',
            'popover' => 'Start, if the new elements do not appear in certain parts of the system',
            'cleared' => 'Cache has been cleared',
        ],
        'translations' => [
            'reload' => 'Reload language files',
            'popover' => 'Start, if the translations in the system does not display correctly',
            'reloaded' => 'Language files were reloaded',
        ],
    ],
];
