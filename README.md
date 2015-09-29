# Milax Mconsole for Laravel 5.x #

This README would normally document whatever steps are necessary to get your application up and running.

### Installation ###

Download, install and configure latest [Laravel 5](http://laravel.com) application.

Navigate to application directory and download latest stable mconsole and additional packages.

```sh
$ composer require milax/mconsole
$ composer require spatie/laravel-medialibrary
```

Update your composer.json to autoload package:

```javascript
"autoload": {
    "psr-4": {
	"Milax\\Mconsole\\": "vendor/milax/mconsole/src"
    }
},
```

Add Service Provider to config/app.php:

```javascript
'providers' => [
    Milax\Mconsole\Providers\MconsoleServiceProvider::class,
    Spatie\MediaLibrary\MediaLibraryServiceProvider::class,
],
```

Publish package files, run migrations and configure application:

```sh
$ php artisan vendor:publish --provider="Milax\Mconsole\Providers\MconsoleServiceProvider"
$ php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider"
$ php artisan migrate
```

Add admin user to your system:

```sh
$ php artisan tinker
```

```php
$user = new App\User();
$user->admin = true;
$user->email = 'admin@milax.com';
$user->password = bcrypt('xyz');
$user->save();
```


### Usage ###

Open `http://domain.com/mconsole` in your browser and log in.

### Updating ###

To update package, resources and migrations:

```sh
$ composer update
$ php artisan vendor:publish --provider="Milax\Mconsole\Providers\MconsoleServiceProvider"
$ php artisan migrate
```