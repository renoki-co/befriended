<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\User;

class FollowTest extends TestCase
{
    protected $user;
    protected $user2;
    protected $user3;
    protected $page;
    protected $simplePage;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\Rennokki\Befriended\Test\Models\User::class)->create();
        $this->user2 = factory(\Rennokki\Befriended\Test\Models\User::class)->create();
        $this->user3 = factory(\Rennokki\Befriended\Test\Models\User::class)->create();
        $this->page = factory(\Rennokki\Befriended\Test\Models\Page::class)->create();
        $this->simplePage = factory(\Rennokki\Befriended\Test\Models\SimplePage::class)->create();
    }

    public function testNoImplements()
    {
        $this->assertFalse($this->user->follow($this->simplePage));
        $this->assertFalse($this->user->unfollow($this->simplePage));
        $this->assertFalse($this->user->isFollowing($this->simplePage));
        $this->assertFalse($this->user->follows($this->simplePage));
    }

    public function testNoFollowersOrFollowing()
    {
        $this->assertEquals($this->user->following()->count(), 0);
        $this->assertEquals($this->user->followers()->count(), 0);

        $this->assertEquals($this->user2->following()->count(), 0);
        $this->assertEquals($this->user2->followers()->count(), 0);

        $this->assertEquals($this->user3->following()->count(), 0);
        $this->assertEquals($this->user3->followers()->count(), 0);
    }

    public function testFollowUser()
    {
        $this->assertTrue($this->user->follow($this->user2));

        $this->assertFalse($this->user->follow($this->user2));
        $this->assertTrue($this->user->isFollowing($this->user2));
        $this->assertTrue($this->user->follows($this->user2));

        $this->assertTrue($this->user2->follow($this->user3));
        $this->assertFalse($this->user2->follow($this->user3));
        $this->assertTrue($this->user2->isFollowing($this->user3));
        $this->assertTrue($this->user2->follows($this->user3));

        $this->assertFalse($this->user->isFollowing($this->user3));
        $this->assertFalse($this->user3->isFollowing($this->user2));
        $this->assertFalse($this->user->follows($this->user3));
        $this->assertFalse($this->user3->follows($this->user2));

        $this->assertEquals($this->user->following()->count(), 1);
        $this->assertEquals($this->user->followers()->count(), 0);
        $this->assertEquals($this->user2->following()->count(), 1);
        $this->assertEquals($this->user2->followers()->count(), 1);
        $this->assertEquals($this->user3->following()->count(), 0);
        $this->assertEquals($this->user3->followers()->count(), 1);
    }

    public function testUnfollowUser()
    {
        $this->assertFalse($this->user->unfollow($this->user2));

        $this->assertTrue($this->user->follow($this->user2));
        $this->assertTrue($this->user->unfollow($this->user2));
        $this->assertFalse($this->user->isFollowing($this->user2));
        $this->assertFalse($this->user->follows($this->user2));

        $this->assertEquals($this->user->following()->count(), 0);
        $this->assertEquals($this->user->followers()->count(), 0);
        $this->assertEquals($this->user2->following()->count(), 0);
        $this->assertEquals($this->user2->followers()->count(), 0);
    }

    public function testFollowOtherModel()
    {
        $this->assertTrue($this->user->follow($this->page));
        $this->assertFalse($this->user->follow($this->page));
        $this->assertTrue($this->user->isFollowing($this->page));
        $this->assertTrue($this->user->follows($this->page));

        $this->assertTrue($this->user2->follow($this->page));
        $this->assertTrue($this->user3->follow($this->page));

        $this->assertFalse($this->page->isFollowing($this->user));
        $this->assertFalse($this->page->isFollowing($this->user2));
        $this->assertFalse($this->page->isFollowing($this->user3));
        $this->assertFalse($this->page->follows($this->user));
        $this->assertFalse($this->page->follows($this->user2));
        $this->assertFalse($this->page->follows($this->user3));

        $this->assertEquals($this->page->following()->count(), 0);
        $this->assertEquals($this->page->followers()->count(), 0);
        $this->assertEquals($this->page->following(User::class)->count(), 0);
        $this->assertEquals($this->page->followers(User::class)->count(), 3);

        $this->assertEquals($this->user->following()->count(), 0);
        $this->assertEquals($this->user->followers()->count(), 0);
        $this->assertEquals($this->user->following(Page::class)->count(), 1);
        $this->assertEquals($this->user->followers(Page::class)->count(), 0);

        $this->assertEquals($this->user2->following()->count(), 0);
        $this->assertEquals($this->user2->followers()->count(), 0);
        $this->assertEquals($this->user2->following(Page::class)->count(), 1);
        $this->assertEquals($this->user2->followers(Page::class)->count(), 0);

        $this->assertEquals($this->user3->following()->count(), 0);
        $this->assertEquals($this->user3->followers()->count(), 0);
        $this->assertEquals($this->user3->following(Page::class)->count(), 1);
        $this->assertEquals($this->user3->followers(Page::class)->count(), 0);
    }

    public function testUnfollowOtherModel()
    {
        $this->assertFalse($this->user->unfollow($this->page));

        $this->assertTrue($this->user->follow($this->page));
        $this->assertTrue($this->user->unfollow($this->page));
        $this->assertFalse($this->user->isFollowing($this->page));
        $this->assertFalse($this->user->follows($this->page));

        $this->assertEquals($this->user->following()->count(), 0);
        $this->assertEquals($this->user->followers()->count(), 0);
        $this->assertEquals($this->user->following(Page::class)->count(), 0);
        $this->assertEquals($this->user->followers(Page::class)->count(), 0);
        $this->assertEquals($this->page->following()->count(), 0);
        $this->assertEquals($this->page->followers()->count(), 0);
        $this->assertEquals($this->page->following(User::class)->count(), 0);
        $this->assertEquals($this->page->followers(User::class)->count(), 0);
    }
}
