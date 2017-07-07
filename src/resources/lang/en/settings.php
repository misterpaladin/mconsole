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
        'defaultheading' => 'Default page heading',
        'indexing' => 'Allow search engine indexing',
        'adminemail' => 'Email for system notifications',
        'editorlinenumbers' => 'HTML editor line numbers',
    ],
    'options' => [
        'enabled' => 'Status',
        'group' => [
            'name' => 'Main',
            'other' => 'Other',
            'site' => 'Site',
        ],
        'on' => 'Enabled',
        'off' => 'Disabled',
        'textarea' => 'Textarea',
        'ckeditor' => 'CKEditor',
        'codemirror' => 'Code Mirror',
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
    'acl' => [
        'index' => 'Settings: view settings',
        'store' => 'Settings: saving',
        'clearcache' => 'Settings: clear cache',
        'reloadtrans' => 'Settings: reload language files',
    ],
];
