Installation
============

Versions
---------
Version 1.0 requires PHP 5.5.9+.

Laravel 5.1
---------

To install this package pull it in through Composer.

```bash
composer require csi-uksw/laravel-cas
```

After Composer is done, you need to tell your application to use the CAS service provider.

Open `config/app.php` and add the service provider

`CSI_UKSW\Laravel\CAS\CASServiceProvider::class`

after

`Illuminate\Auth\AuthServiceProvider::class`

As well the Facade :

`'CAS' => CSI_UKSW\Laravel\CAS\Facades\CAS::class`

Configuration
=============

#### Basic

To set up your CAS for connections you have to publish CAS config. This will provide all the configuration values for your connection.

```
php artisan vendor:publish --provider="CSI_UKSW\Laravel\CAS\CASServiceProvider"
```

After that please edit your `app/cas.php`. Using the `.env` file will allow you to have different environments without even touching the `app/cas.php` config file.

#### Middleware

Optionally you can use provided Auth Middleware.

After publishing please edit your `app/Http/Kernel.php`
```php
protected $routeMiddleware = [
    'auth.cas' => \CSI_UKSW\Laravel\CAS\Http\Middleware\CASAuthMiddleware::class
];
```

Usage
======

Authenticate:

`CAS::authenticate()`

Logout:

`CAS::logout()`

Get username:

`CAS::getUser()`

Get user attributes:

`CAS::getAttributes()`

Check if is authenticated:

`CAS::isAuthenticated()`

Route middleware:

```php
Route::group(['middleware' => 'auth.cas'], function () {
   get('cas', function(){
       echo 'authorized only';
   });
});
```