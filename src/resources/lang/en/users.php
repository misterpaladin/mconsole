<?php

return [
    'menu' => [
        'list' => [
            'name' => 'Users',
            'description' => 'Display list of users',
        ],
        'create' => [
            'name' => 'Add user',
            'description' => 'Add new user Mconsole',
        ],
        'update' => [
            'name' => 'Edit user',
            'description' => 'Modify information about a user and its access rights',
        ],
        'delete' => [
            'name' => 'Delete user',
            'description' => 'Attention! This option allow only very trusted users',
        ],
    ],
    'table' => [
        'updated' => 'Updated',
        'email' => 'E-mail',
        'name' => 'Name',
    ],
    'filter' => [
        'email' => 'E-mail',
        'id' => 'User ID',
        'role' => 'Group',
    ],
    'form' => [
        'name' => 'Name',
        'email' => 'E-mail',
        'password' => 'Password',
        'changepassword' => 'Change password',
        'placeholder' => [
            'name' => 'John Appleseed',
            'email' => 'example@milax.com',
            'password' => 'Password',
            'changepassword' => 'New password',
        ],
        'main' => 'Main',
        'quickmenu' => 'Quick menu',
        'language' => 'Interface language',
        'role' => 'Group',
    ],
    'types' => [
        'generic' => 'Normal user',
    ],
    'acl' => [
        'index' => 'Users: show list',
        'create' => 'Users: show create form',
        'store' => 'Users: saving',
        'edit' => 'Users: show edit form',
        'update' => 'Users: updating',
        'show' => 'Users: view',
        'destroy' => 'Users: delete',
    ],
];
