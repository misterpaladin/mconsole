<?php

return [
    'menu' => [
        'list' => [
            'name' => 'User groups',
            'description' => 'Display list of users',
        ],
        'create' => [
            'name' => 'Add group',
            'description' => 'Create a new user group and set access rights to its members',
        ],
        'update' => [
            'name' => 'Edit group',
            'description' => 'Edit user rights belong to the group',
        ],
        'delete' => [
            'name' => 'Delete group',
            'description' => 'Note: you cannot delete a group which has users',
        ],
    ],
    'form' => [
        'main' => 'Edit',
        'permissions' => 'Permissions',
        'name' => 'Name',
        'widget' => 'Blade helper',
        'placeholder' => 'Moderator',
    ],
    'table' => [
        'name' => 'Name',
        'users' => 'Number of users',
    ],
    'permission' => [
        'name' => 'Section',
        'description' => 'Description',
    ],
    'acl' => [
        'index' => 'User groups: show list',
        'create' => 'User groups: show create form',
        'store' => 'User groups: saving',
        'edit' => 'User groups: show edit form',
        'update' => 'User groups: updating',
        'show' => 'User groups: view',
        'destroy' => 'User groups: delete',
    ],
];
