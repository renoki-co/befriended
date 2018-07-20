[![Build Status](https://travis-ci.org/rennokki/befriended.svg?branch=master)](https://travis-ci.org/rennokki/befriended)
[![codecov](https://codecov.io/gh/rennokki/befriended/branch/master/graph/badge.svg)](https://codecov.io/gh/rennokki/befriended/branch/master)
[![StyleCI](https://github.styleci.io/repos/141194551/shield?branch=master)](https://github.styleci.io/repos/141194551)
[![Latest Stable Version](https://poser.pugx.org/rennokki/befriended/v/stable)](https://packagist.org/packages/rennokki/befriended)
[![Total Downloads](https://poser.pugx.org/rennokki/befriended/downloads)](https://packagist.org/packages/rennokki/befriended)
[![Monthly Downloads](https://poser.pugx.org/rennokki/befriended/d/monthly)](https://packagist.org/packages/rennokki/befriended)
[![License](https://poser.pugx.org/rennokki/befriended/license)](https://packagist.org/packages/rennokki/befriended)

[![PayPal](https://img.shields.io/badge/PayPal-donate-blue.svg)](https://paypal.me/rennokki)

# Laravel Befriended
Eloquent Befriended manages social media-like features like following, blocking and filtering content based on following or blocked models.

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
Multiple traits have different functions for your models. There are some that allows following or blocking other models, or allowing to be followed or blocked. There are traits that permit filtering content based on another model's following list or blocking list.

# Following & Followers
Each model can have `followers`, a list of models that can follow, and `following`, a list of models that is currently following. Both methods are separated into two traits, that need to implement two interfaces.

To allow a model to follow, you can use the `CanFollow` trait and `Follower` interface.
```php
use Rennokki\Befriended\Traits\CanFollow;
use Rennokki\Befriended\Contracts\Follower;

class User extends Model implements Follower {
    use CanFollow;
    ...
}
```

In order to allow a model to be followed, you must add `CanBeFollowed` trait and `Followable` interface.
```php
use Rennokki\Befriended\Traits\CanBeFollowed;
use Rennokki\Befriended\Contracts\Followable;

class User extends Model implements Followable {
    use CanBeFollowed;
    ...
}
```

If you plan to set your model as being able to both be followed or follow, use the `Follow` trait and `Following` interface:
```php
use Rennokki\Befriended\Traits\Follow;
use Rennokki\Befriended\Contracts\Following;

class User extends Model implements Following {
    use Follow;
    ...
}
```

# Real-world example
Let's suppose we have an `User` model which can follow and be followed. On it, we can now check for followers or follow new users:
```php
$zuck = User::where('name', 'Mark Zuckerberg')->first();
$user->follow($zuck);

$user->following()->count(); // 1
$zuck->followers()->count(); // 1
```

# Following other models
Let's suppose we have a `Page` model, than can only be followed:
```php
use Rennokki\Befriended\Traits\CanBeFollowed;
use Rennokki\Befriended\Contracts\Followable;

class Page extends Model implements Followable {
    use CanBeFollowed;
    ...
}
```

Following other models needs a bit of attention. By default, if querying `following()` and `followers()` from the `$user`, the functions will return only `User` instances. If you plan to retrieve other instances, such as `Page`, you can use it as an argument to the relationships:
```php
$zuckPage = Page::where('username', 'zuck')->first();

$user->follow($zuckPage);
$user->following()->count(); // 0, because it doesn't follow any User instance
$user->following(Page::class)->count(); // 1, because it follows only Zuck's page.
```

**Note: The previous example on passing a class as an argument to `following()` relationship also works with `followers()`.**

To check if a model is following another one, use the `isFollowing()` method:
```php
$user->isFollowing($friend);
```

**Note: Following, unfollowing or checking if following models that do not correctly implement `CanBeFollowed` and `Followable` will always return `false` and such relation will not be made.**

# Blocking
Most of the functions are working like the follow feature. Here are some quick examples, since re-explaining it again would be non-sense:

To allow a model to block other models, you can use the `CanBlock` trait and `Blocker` interface.
```php
use Rennokki\Befriended\Traits\CanBlock;
use Rennokki\Befriended\Contracts\Blocker;

class User extends Model implements Blocker {
    use CanBlock;
    ...
}
```

Adding `CanBeBlocked` trait and `Blockable` interface sets the model able to be blocked.
```php
use Rennokki\Befriended\Traits\CanBeBlocked;
use Rennokki\Befriended\Contracts\Blockable;

class User extends Model implements Blockable {
    use CanBeBlocked;
    ...
}
```

Using both? You should be using `Block` trait & `Blocking` interface:
```php
use Rennokki\Befriended\Traits\Block;
use Rennokki\Befriended\Contracts\Blocking;

class User extends Model implements Blocking {
    use Block;
    ...
}
```

The following methods are doing like the follow feature, but just for the blocking system:
```php
$user->block($user);
$user->unblock($user);

$user->blockings(); // Users that this user blocks.
$user->blockings(Page::class); // Pages that this user blocks.
$user->blockers(); // Users that block this user.
$user->blockers(Page::class); // Pages that block this user.

$user->isBlocking($page);
```

Same as the follow feature, if you try to block, unblock or checking if the model is blocking another model will always return `false` if the `CanBeBlocked` and `Blockable` are not implemented correctly.

# Liking
For models that can like other models:
```php
use Rennokki\Befriended\Traits\CanLike;
use Rennokki\Befriended\Contracts\Liker;

class User extends Model implements Liker {
    use CanLike;
    ...
}
```

For models that can be liked:
```php
use Rennokki\Befriended\Traits\CanBeLiked;
use Rennokki\Befriended\Contracts\Likeable;

class Page extends Model implements Likeable {
    use CanBeLiked;
    ...
}
```

For both liking & being liked:
```php
use Rennokki\Befriended\Traits\Like;
use Rennokki\Befriended\Contracts\Liking;

class User extends Model implements Liking {
    use Like;
    ...
}
```

You can use the following methods:
```php
$user->like($page);
$user->unlike($page);

$user->likings(); // Users that this user likes.
$user->likings(Page::class); // Pages that this user likes.
$user->likers(); // Users that like this user.
$user->likers(Page::class); // Pages that like this user.

$user->isLiking($page);
```

# Filtering content
Filtering content is what this packages makes it happen to be BE-AU-TIFUL. When querying for your results, you can use the `CanFilterFollowingModels` and `CanFilterBlockedModels` scopes.

```php
use Rennokki\Befriended\Traits\Follow;
use Rennokki\Befriended\Contracts\Following;

use Rennokki\Befriended\Scopes\CanFilterFollowingModels;
use Rennokki\Befriended\Scopes\CanFilterBlockedModels;

class User extends Model implements Following {
    use Follow, CanFilterFollowingModels, CanFilterBlockedModels;
    ...
}
```

You can query models based on blockings:
```php
$bob = User::where('username', 'john')->first();
$alice = User::where('username', 'alice')->first();

User::filterBlockingsOf($bob)->get(); // You will get Alice and Bob as results.

$bob->block($alice);
User::filterBlockingsOf($bob)->get(); // You will get only Bob as result.
```

You can query models based on followings:
```php
$bob = User::where('username', 'john')->first();
$alice = User::where('username', 'alice')->first();

User::filterFollowingsOf($bob)->get(); // You will get no results.

$bob->follow($alice);
User::filterBlockingsOf($bob)->get(); // You will get Alice as result.
```
