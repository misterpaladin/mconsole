<?php

namespace Milax\Mconsole;

class User extends \App\User
{
    /**
     * Extend hidden fields of basic User model
     * 
     * (default value: ['admin', 'password', 'remember_token'])
     * 
     * @var string
     * @access protected
     */
    protected $hidden = ['admin', 'password', 'remember_token'];
}
