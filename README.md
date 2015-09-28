# Milax Mconsole for Laravel 5.x #

This README would normally document whatever steps are necessary to get your application up and running.

### Installation ###

Download, install and configure latest [Laravel 5](http://laravel.com) application.

Navigate to application directory and clone this repository to `/packages/Milax/Mconsole` directory:

```
#!bash
$ cd laravel-project
$ git clone git@bitbucket.org:milaxinc/mconsole-package.git .
```

Publish package files, run migrations and configure application:

```
#!bash
$ php artisan vendor:publish
$ php artisan migrate
```

Add admin user to your system:
```
#!bash
$ php artisan tinker
```

```
#!php
<?php
$user = new App\User();
$user->admin = true;
$user->email = 'admin@milax.com';
$user->password = bcrypt('xyz');
$user->save();
```


### Usage ###

Open `http://domain.com/mconsole` in your browser and log in.

### Extending package classes ###

All package models using the **App** namespace.

Create new model **CustomUser** by calling command `$ php artisan make:model CustomUser`, extend package published User model by yours:

```
#!php
<?php

namespace App;

use App\User;

class CustomUser extends User {
    // ...
}

```


### To Do ###

* Automatic updates
* Single project configuration
* Readme