# Milax Mconsole for Laravel 5.x #

Still in **experimental develop** and not ready for production!

### Installation ###

Download, install and configure latest [Laravel 5](http://laravel.com) application.

Navigate to application directory and download latest stable mconsole and additional packages.

```sh
$ composer require milax/mconsole
$ composer require laravelcollective/html
```

Update your composer.json to autoload package:

```javascript
"autoload": {
    "psr-4": {
		"Milax\\Mconsole\\": "vendor/milax/mconsole/src/Milax/Mconsole"
    }
},
```

Add Service Providers to config/app.php:

```php
'providers' => [
    Milax\Mconsole\Providers\MconsoleServiceProvider::class,
    Collective\Html\HtmlServiceProvider::class,
],
'aliases' => [
	'Form' => Collective\Html\FormFacade::class,
	'Html' => Collective\Html\HtmlFacade::class,
],
```

Publish package files, run migrations and configure application (--force to overwrite default User model):

```sh
$ php artisan vendor:publish --provider="Milax\Mconsole\Providers\MconsoleServiceProvider" --force
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

To update package, models, assets and migrations:

```sh
$ composer update
$ php artisan vendor:publish --provider="Milax\Mconsole\Providers\MconsoleServiceProvider" --tag=migrations --force
$ php artisan vendor:publish --provider="Milax\Mconsole\Providers\MconsoleServiceProvider" --tag=models --force
$ php artisan vendor:publish --provider="Milax\Mconsole\Providers\MconsoleServiceProvider" --tag=assets --force
$ php artisan migrate
```