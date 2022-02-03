<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\SimplePage;
use Rennokki\Befriended\Test\Models\User;

class FollowRequestTest extends TestCase
{
    protected $bob;

    protected $alice;

    protected $mark;

    protected $page;

    protected $simplePage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bob = factory(User::class)->create();

        $this->alice = factory(User::class)->create();

        $this->mark = factory(User::class)->create();

        $this->page = factory(Page::class)->create();

        $this->simplePage = factory(SimplePage::class)->create();
    }

    public function test_follow_request_to_user()
    {
        $this->assertTrue(
            $this->bob->followRequest($this->alice)
        );

        $this->assertFalse(
            $this->bob->followRequest($this->alice)
        );

        $this->assertFalse(
            $this->bob->follows($this->alice)
        );

        $this->assertTrue(
            $this->bob->hasFollowRequested($this->alice)
        );

        $this->assertTrue(
            $this->alice->hasFollowRequestFrom($this->bob)
        );

        $this->assertEquals(1, $this->bob->followRequests()->count());
        $this->assertEquals(1, $this->alice->followerRequests()->count());
    }

    public function test_accept_follow_request()
    {
        $this->assertFalse(
            $this->alice->acceptFollowRequest($this->bob)
        );

        $this->bob->followRequest($this->alice);

        $this->assertTrue(
            $this->alice->acceptFollowRequest($this->bob)
        );

        $this->assertFalse(
            $this->alice->acceptFollowRequest($this->bob)
        );

        $this->assertTrue(
            $this->bob->follows($this->alice)
        );

        $this->assertEquals(0, $this->bob->followerRequests()->count());
        $this->assertEquals(0, $this->alice->followRequests()->count());
    }

    public function test_decline_follow_request()
    {
        $this->assertFalse(
            $this->alice->declineFollowRequest($this->bob)
        );

        $this->bob->followRequest($this->alice);

        $this->assertTrue(
            $this->alice->declineFollowRequest($this->bob)
        );

        $this->assertFalse(
            $this->alice->declineFollowRequest($this->bob)
        );

        $this->assertFalse(
            $this->bob->follows($this->alice)
        );

        $this->assertEquals(0, $this->bob->followerRequests()->count());
        $this->assertEquals(0, $this->alice->followRequests()->count());
    }

    public function test_cancel_follower_request()
    {
        $this->assertFalse(
            $this->bob->cancelFollowRequest($this->alice)
        );

        $this->bob->followRequest($this->alice);

        $this->assertTrue(
            $this->bob->cancelFollowRequest($this->alice)
        );

        $this->assertFalse(
            $this->bob->declineFollowRequest($this->alice)
        );

        $this->assertFalse(
            $this->bob->follows($this->alice)
        );

        $this->assertEquals(0, $this->bob->followerRequests()->count());
        $this->assertEquals(0, $this->alice->followRequests()->count());
    }

    public function test_follow_request_to_custom_model()
    {
        $this->assertTrue(
            $this->bob->followRequest($this->page)
        );

        $this->assertFalse(
            $this->bob->followRequest($this->page)
        );

        $this->assertFalse(
            $this->bob->follows($this->page)
        );

        $this->assertTrue(
            $this->bob->hasFollowRequested($this->page)
        );

        $this->assertTrue(
            $this->page->hasFollowRequestFrom($this->bob)
        );

        // Not specifying the model won't return any results.

        $this->assertEquals(0, $this->bob->followRequests()->count());
        $this->assertEquals(0, $this->page->followerRequests()->count());

        // Not specifying the model won't return any results.

        $this->assertEquals(1, $this->bob->followRequests(Page::class)->count());
        $this->assertEquals(1, $this->page->followerRequests(User::class)->count());
    }

    public function test_accept_follow_request_from_custom_model()
    {
        $this->assertFalse(
            $this->page->acceptFollowRequest($this->bob)
        );

        $this->bob->followRequest($this->page);

        $this->assertTrue(
            $this->page->acceptFollowRequest($this->bob)
        );

        $this->assertFalse(
            $this->page->acceptFollowRequest($this->bob)
        );

        $this->assertTrue(
            $this->bob->follows($this->page)
        );

        $this->assertEquals(0, $this->bob->followerRequests(Page::class)->count());
        $this->assertEquals(0, $this->page->followRequests(User::class)->count());
    }

    public function test_decline_follow_request_from_custom_model()
    {
        $this->assertFalse(
            $this->page->declineFollowRequest($this->bob)
        );

        $this->bob->followRequest($this->page);

        $this->assertTrue(
            $this->page->declineFollowRequest($this->bob)
        );

        $this->assertFalse(
            $this->page->declineFollowRequest($this->bob)
        );

        $this->assertFalse(
            $this->bob->follows($this->page)
        );

        $this->assertEquals(0, $this->bob->followerRequests(Page::class)->count());
        $this->assertEquals(0, $this->page->followRequests(User::class)->count());
    }

    public function test_cancel_follower_request_from_custom_model()
    {
        $this->assertFalse(
            $this->bob->cancelFollowRequest($this->page)
        );

        $this->bob->followRequest($this->page);

        $this->assertTrue(
            $this->bob->cancelFollowRequest($this->page)
        );

        $this->assertFalse(
            $this->bob->declineFollowRequest($this->page)
        );

        $this->assertFalse(
            $this->bob->follows($this->page)
        );

        $this->assertEquals(0, $this->bob->followerRequests(Page::class)->count());
        $this->assertEquals(0, $this->page->followRequests(User::class)->count());
    }
}
