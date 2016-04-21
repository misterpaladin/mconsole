<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class MconsoleModule extends Model
{
    use \Cacheable;
    
    public $register;
    public $config;
    public $translations;
    public $routes;
    public $migrations;
    public $views;
    public $models;
    public $extend;
    public $original;
    public $type;
    public $name;
    public $description;
    public $menu;
    public $controllers;
    public $requests;
    public $init;
    public $public;
    public $path;
    public $depends;
    public $package;
    
    protected $fillable = ['identifier', 'installed'];
}
