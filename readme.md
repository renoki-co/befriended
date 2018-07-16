[![Build Status](https://travis-ci.org/rennokki/befriended.svg?branch=master)](https://travis-ci.org/rennokki/befriended)
[![codecov](https://codecov.io/gh/rennokki/befriended/branch/master/graph/badge.svg)](https://codecov.io/gh/rennokki/befriended/branch/master)
[![StyleCI](https://github.styleci.io/repos/141194551/shield?branch=master)](https://github.styleci.io/repos/141194551)
[![Latest Stable Version](https://poser.pugx.org/rennokki/befriended/v/stable)](https://packagist.org/packages/rennokki/befriended)
[![Total Downloads](https://poser.pugx.org/rennokki/befriended/downloads)](https://packagist.org/packages/rennokki/befriended)
[![Monthly Downloads](https://poser.pugx.org/rennokki/befriended/d/monthly)](https://packagist.org/packages/rennokki/befriended)
[![License](https://poser.pugx.org/rennokki/befriended/license)](https://packagist.org/packages/rennokki/befriended)

[![PayPal](https://img.shields.io/badge/PayPal-donate-blue.svg)](https://paypal.me/rennokki)

# Laravel Befriended
Eloquent Befriended manages social media-like features like following or blocking and filtering content based on those lists.

# Installation
Install the package:
```bash
$ composer require rennokki/befriended
```

If your Laravel version does not support package discovery, add this line in the `providers` array in your `config/app.php` file:
```php
Rennokki\Befriended\BefriendedServiceProvider::class,
```

Publish the config file & migration files:
```bash
$ php artisan vendor:publish
```

Migrate the database:
```bash
$ php artisan migrate
```

# Traits & Interfaces
Multiple traits have different functions for your models. There are some that allows following or blocking other models, but there are traits that permit filtering content based on another model's following list or blocking list.

# Following
Following is the simple form. You can follow from the model that implements `Following` and uses `CanFollow`.
```php
use Rennokki\Befriended\Traits\CanFollow;
use Rennokki\Befriended\Interfaces\Following;

class User extends Model implements Following {
    use CanFollow;
    ...
}
```

From now on, you can follow other models.
```php
$friend = User::where('name', 'John')->first();
$user->follow($friend);

$user->following()->count(); // 1
$friend->followers()->count(); // 1
```

In case you want to follow other models, keep in mind that using `following()` or `followers()` relationships doesn't work unless you pass the class you wish to retrieve from.
```php
$post = Post::find(1);
$user->follow($post);

// Because $user is User class, it does not follow
// any User class.
$user->following()->count(); // 0

// Instead, it follows a Post class.
$user->following(Post::class)->count(); // 1
```

Passing the class as argument for `followers()` relationship works like the `following()`.

```php
$user->unfollow($friend);
$user->following()->count(); // 0
```

Alternatively, you can check if a model is following:
```php
$user->isFollowing($friend);
```

# Blocking
# WIP

# Filtering content
# WIP