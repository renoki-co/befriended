[![Build Status](https://travis-ci.org/rennokki/befriended.svg?branch=master)](https://travis-ci.org/rennokki/befriended)
[![codecov](https://codecov.io/gh/rennokki/befriended/branch/master/graph/badge.svg)](https://codecov.io/gh/rennokki/befriended/branch/master)
[![StyleCI](https://github.styleci.io/repos/141194551/shield?branch=master)](https://github.styleci.io/repos/141194551)
[![Latest Stable Version](https://poser.pugx.org/rennokki/befriended/v/stable)](https://packagist.org/packages/rennokki/befriended)
[![Total Downloads](https://poser.pugx.org/rennokki/befriended/downloads)](https://packagist.org/packages/rennokki/befriended)
[![Monthly Downloads](https://poser.pugx.org/rennokki/befriended/d/monthly)](https://packagist.org/packages/rennokki/befriended)
[![License](https://poser.pugx.org/rennokki/befriended/license)](https://packagist.org/packages/rennokki/befriended)

[![PayPal](https://img.shields.io/badge/PayPal-donate-blue.svg)](https://paypal.me/rennokki)

# Laravel Befriended
Eloquent Befriended brings social media-like features like following, blocking and filtering content based on following or blocked models. Laravel Befriended comes with scopes that manage filtering content that gives you easy control better what your user can see and cannot see.

# Switching from 1.1.x to 1.2.x
The main difference is that the traits that are responsible for filtering content got a better eloquent capability.

Make sure you replace the following traits:
* `Rennokki\Befriended\Scopes\CanFilterFollowingModels`
* `Rennokki\Befriended\Scopes\CanFilterUnfollowedModels`
* `Rennokki\Befriended\Scopes\CanFilterBlockedModels`
* `Rennokki\Befriended\Scopes\CanFilterUnlikedModels`

with the following ones that are paired by the action they filter:
* `Rennokki\Befriended\Scopes\FollowFilterable`
* `Rennokki\Befriended\Scopes\BlockFilterable`
* `Rennokki\Befriended\Scopes\LikeFilterable`

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

# Example
The power of example is better here. This package allows you simply to assign followers, blockings or likes without too much effort. What makes the package powerful is that you can filter queries using scopes out-of-the-box.
```php
$alice = User::where('name', 'Alice')->first();
$bob = User::where('name', 'Bob')->first();
$tim = User::where('name', 'Tim')->first();

$alice->follow($bob);

$alice->following()->count(); // 1
$bob->followers()->count(); // 1

User::followedBy($alice)->get(); // Just Bob shows up
User::unfollowedBy($alice)->get(); // Tim shows up
```

# Following
To follow other models, your model should use the `CanFollow` trait and `Follower` contract.
```php
use Rennokki\Befriended\Traits\CanFollow;
use Rennokki\Befriended\Contracts\Follower;

class User extends Model implements Follower {
    use CanFollow;
    ...
}
```

The other models that can be followed should use `CanBeFollowed` trait and `Followable` contract.
```php
use Rennokki\Befriended\Traits\CanBeFollowed;
use Rennokki\Befriended\Contracts\Followable;

class User extends Model implements Followable {
    use CanBeFollowed;
    ...
}
```

If your model can both follow & be followed, you can use `Follow` trait and `Following` contract.
```php
use Rennokki\Befriended\Traits\Follow;
use Rennokki\Befriended\Contracts\Following;

class User extends Model implements Following {
    use Follow;
    ...
}
```

Let's suppose we have an `User` model which can follow and be followed. Within it, we can now check for followers or follow new users:
```php
$zuck = User::where('name', 'Mark Zuckerberg')->first();
$user->follow($zuck);

$user->following()->count(); // 1
$zuck->followers()->count(); // 1
```

Now, let's suppose we have a `Page` model, than can only be followed:
```php
use Rennokki\Befriended\Traits\CanBeFollowed;
use Rennokki\Befriended\Contracts\Followable;

class Page extends Model implements Followable {
    use CanBeFollowed;
    ...
}
```

By default, if querying `following()` and `followers()` from the `User` instance, the relationships will return only `User` instances. If you plan to retrieve other instances, such as `Page`, you can pass the model name or model class as an argument to the relationships:
```php
$zuckPage = Page::where('username', 'zuck')->first();

$user->follow($zuckPage);
$user->following()->count(); // 0, because it doesn't follow any User instance
$user->following(Page::class)->count(); // 1, because it follows only Zuck's page.
```

On-demand, you can check if your model follows some other model:
```php
$user->isFollowing($friend);
$user->follows($friend); // alias
```

**Note: Following, unfollowing or checking if following models that do not correctly implement `CanBeFollowed` and `Followable` will always return `false`.**

### Filtering followed/unfollowed models
To filter followed or unfollowed models (which can be any other model) on query, your model which you will query should use the `Rennokki\Befriended\Scopes\FollowFilterable` trait.

If your `User` model can only like other `Page` models, your `Page` model should use the trait mentioned.

```php
$bob = User::where('username', 'john')->first();
$alice = User::where('username', 'alice')->first();

User::followedBy($bob)->get(); // You will get no results.
User::unfollowedBy($bob)->get(); // You will get Alice.

$bob->follow($alice);
User::followedBy($bob)->get(); // Only Alice pops up.
```

# Blocking
Most of the functions are working like the follow feature, but this is helpful when your models would like to block other models.

Use `CanBlock` trait and `Blocker` contract to allow the model to block other models.
```php
use Rennokki\Befriended\Traits\CanBlock;
use Rennokki\Befriended\Contracts\Blocker;

class User extends Model implements Blocker {
    use CanBlock;
    ...
}
```

Adding `CanBeBlocked` trait and `Blockable` contract sets the model able to be blocked.
```php
use Rennokki\Befriended\Traits\CanBeBlocked;
use Rennokki\Befriended\Contracts\Blockable;

class User extends Model implements Blockable {
    use CanBeBlocked;
    ...
}
```

For both, you should be using `Block` trait & `Blocking` contract:
```php
use Rennokki\Befriended\Traits\Block;
use Rennokki\Befriended\Contracts\Blocking;

class User extends Model implements Blocking {
    use Block;
    ...
}
```

Most of the methods are the same:
```php
$user->block($user);
$user->block($page);
$user->unblock($user);

$user->blocking(); // Users that this user blocks.
$user->blocking(Page::class); // Pages that this user blocks.
$user->blockers(); // Users that block this user.
$user->blockers(Page::class); // Pages that block this user.

$user->isBlocking($page);
$user->blocks($page); // alias to isBlocking
```

### Filtering blocked models
Blocking scopes provided takes away from the query the models that are blocked. Useful to stop showing content when your models blocks other models.
Make sure that the model that will be queried uses the  `Rennokki\Befriended\Scopes\BlockFilterable` trait.

```php
$bob = User::where('username', 'john')->first();
$alice = User::where('username', 'alice')->first();

User::withoutBlockingsOf($bob)->get(); // You will get Alice and Bob as results.

$bob->block($alice);
User::withoutBlockingsOf($bob)->get(); // You will get only Bob as result.
```

# Liking
Apply `CanLike` trait and `Liker` contract for models that can like:
```php
use Rennokki\Befriended\Traits\CanLike;
use Rennokki\Befriended\Contracts\Liker;

class User extends Model implements Liker {
    use CanLike;
    ...
}
```

`CanBeLiked` and `Likeable` trait can be used for models that can be liked:
```php
use Rennokki\Befriended\Traits\CanBeLiked;
use Rennokki\Befriended\Contracts\Likeable;

class Page extends Model implements Likeable {
    use CanBeLiked;
    ...
}
```

Planning to use both, use the `Like` trait and `Liking` contact:
```php
use Rennokki\Befriended\Traits\Like;
use Rennokki\Befriended\Contracts\Liking;

class User extends Model implements Liking {
    use Like;
    ...
}
```

As you have already got started with, these are the methods:
```php
$user->like($user);
$user->like($page);
$user->unlike($page);

$user->liking(); // Users that this user likes.
$user->liking(Page::class); // Pages that this user likes.
$user->likers(); // Users that like this user.
$user->likers(Page::class); // Pages that like this user.

$user->isLiking($page);
$user->likes($page); // alias to isLiking
```

### Filtering liked content
Filtering liked content can make showing content easier. For example, showing in the news feed posts that weren't liked by an user can be helpful.
The model you're querying from must use the `Rennokki\Befriended\Scopes\LikeFilterable` trait.

Let's suppose there are 10 pages in the database.
```php
$bob = User::where('username', 'john')->first();
$page = Page::find(1);

Page::notLikedBy($bob)->get(); // You will get 10 results.

$bob->like($page);
Page::notLikedBy($bob)->get(); // You will get only 9 results.
Page::likedBy($bob)->get(); // You will get one result, the $page
```
