<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\SimplePage;
use Rennokki\Befriended\Test\Models\User;

class FollowTest extends TestCase
{
    protected $bob;

    protected $alice;

    protected $mark;

    protected $page;

    protected $simplePage;

    public function setUp(): void
    {
        parent::setUp();

        $this->bob = factory(User::class)->create();

        $this->alice = factory(User::class)->create();

        $this->mark = factory(User::class)->create();

        $this->page = factory(Page::class)->create();

        $this->simplePage = factory(SimplePage::class)->create();
    }

    public function test_following()
    {
        $this->assertTrue(
            $this->bob->follow($this->alice)
        );

        $this->assertFalse(
            $this->bob->follow($this->alice)
        );

        $this->assertTrue(
            $this->bob->follows($this->alice)
        );

        $this->assertEquals(1, $this->bob->following()->count());
        $this->assertEquals(0, $this->bob->followers()->count());

        $this->assertEquals(0, $this->alice->following()->count());
        $this->assertEquals(1, $this->alice->followers()->count());
    }

    public function test_unfollowing()
    {
        $this->assertFalse(
            $this->bob->unfollow($this->alice)
        );

        $this->bob->follow($this->alice);

        $this->assertTrue(
            $this->bob->unfollow($this->alice)
        );

        $this->assertFalse(
            $this->bob->follows($this->alice)
        );

        $this->assertEquals(0, $this->bob->following()->count());
        $this->assertEquals(0, $this->bob->followers()->count());

        $this->assertEquals(0, $this->alice->following()->count());
        $this->assertEquals(0, $this->alice->followers()->count());
    }

    public function test_following_with_custom_model()
    {
        $this->assertTrue(
            $this->bob->follow($this->page)
        );

        $this->assertFalse(
            $this->bob->follow($this->page)
        );

        $this->assertTrue(
            $this->bob->follows($this->page)
        );

        // Not specifying the model won't return any results.

        $this->assertEquals(0, $this->bob->following()->count());
        $this->assertEquals(0, $this->bob->followers()->count());

        $this->assertEquals(0, $this->page->following()->count());
        $this->assertEquals(0, $this->page->followers()->count());

        // Passing the model should return the values properly.

        $this->assertEquals(1, $this->bob->following(Page::class)->count());
        $this->assertEquals(0, $this->bob->followers(Page::class)->count());

        $this->assertEquals(0, $this->page->following(User::class)->count());
        $this->assertEquals(1, $this->page->followers(User::class)->count());
    }

    public function test_unfollowing_with_custom_model()
    {
        $this->assertFalse(
            $this->bob->unfollow($this->page)
        );

        $this->bob->follow($this->page);

        $this->assertTrue(
            $this->bob->unfollow($this->page)
        );

        $this->assertFalse(
            $this->bob->follows($this->page)
        );

        $this->assertEquals(0, $this->bob->following(Page::class)->count());
        $this->assertEquals(0, $this->bob->followers(Page::class)->count());

        $this->assertEquals(0, $this->page->following(User::class)->count());
        $this->assertEquals(0, $this->page->followers(User::class)->count());
    }

    public function test_revoke_follow()
    {
        $this->assertTrue(
            $this->bob->followRequest($this->alice)
        );

        $this->assertEquals(1, $this->alice->followerRequests()->count());

        $this->assertTrue(
            $this->alice->acceptFollowRequest($this->bob)
        );

        $this->assertTrue($this->bob->follows($this->alice));

        $this->assertTrue(
            $this->alice->revokeFollower($this->bob)
        );

        $this->assertFalse($this->bob->follows($this->alice));
    }
}
