<?php

return [
    'menu' => [
        'name' => 'Variables',
        'description' => 'View the list of variables',
        'update' => [
            'name' => 'Edit variables',
            'description' => 'Save variables',
        ],
    ],
    'tabs' => [
        'main' => 'Templates editor',
    ],
    'form' => [
        'info' => [
            'title' => 'Wisdom',
            'text' => 'Add variables to use their values in a text page or news, you can use the Blade of the Directive. Example template:<br/> Key: <code>link</code><br/>Pattern: <code>&lt;a href="&#123;&#123; &#036;href &#125;&#125;">&#123;&#123; &#036;text &#125;&#125;&lt;/a&gt;</code>',
        ],
        'key' => 'Key',
        'value' => 'Pattern',
        'description' => 'Comment',
        'copy' => [
            'single' => 'Copy',
            'multiline' => 'Copy multiple lines',
        ],
        'delete' => 'Delete',
    ],
    'buttons' => [
        'add' => 'Add variable',
    ],
    'saved' => 'Variables saved',
    'acl' => [
        'index' => 'Variables: show list',
        'store' => 'Variables: saving',
    ],
];
