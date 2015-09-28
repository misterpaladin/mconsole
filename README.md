# Milax Mconsole for Laravel 5.x #

This README would normally document whatever steps are necessary to get your application up and running.

### Installation ###

Download, install and configure latest [Laravel 5](http://laravel.com) application.

Navigate to project directory and download this repository to `/packages/Milax/Mconsole` directory:

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

App\User::create([
    'admin' => true,
    'email' => 'admin@example.com',
    'password' => bcrypt('123456')
]);
```

### Usage ###

Open `http://domain.com/mconsole` in your browser and log in.

### To Do ###

* Automatic updates
* Single project configuration
* Readme