<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\User;

class FollowRequestTest extends TestCase
{
    protected $user;
    protected $user2;
    protected $user3;
    protected $page;
    protected $simplePage;

    public function setUp(): void
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
        $this->assertFalse($this->user->hasFollowRequested($this->simplePage));
    }

    public function testNoFollowRequestsOrFollowerRequests()
    {
        $this->assertEquals($this->user->followRequests()->count(), 0);
        $this->assertEquals($this->user->followerRequests()->count(), 0);

        $this->assertEquals($this->user2->followRequests()->count(), 0);
        $this->assertEquals($this->user2->followerRequests()->count(), 0);

        $this->assertEquals($this->user3->followRequests()->count(), 0);
        $this->assertEquals($this->user3->followerRequests()->count(), 0);
    }

    public function testFollowRequestUser()
    {
        $this->assertTrue($this->user->followRequest($this->user2));

        $this->assertFalse($this->user->followRequest($this->user2));
        $this->assertTrue($this->user->hasFollowRequested($this->user2));
        $this->assertFalse($this->user->follows($this->user2));
        $this->assertTrue($this->user2->hasFollowRequestFrom($this->user));

        $this->assertTrue($this->user2->followRequest($this->user3));
        $this->assertFalse($this->user2->followRequest($this->user3));
        $this->assertFalse($this->user2->isFollowing($this->user3));
        $this->assertFalse($this->user2->follows($this->user3));
        $this->assertFalse($this->user->hasFollowRequestFrom($this->user2));

        $this->assertFalse($this->user->isFollowing($this->user3));
        $this->assertFalse($this->user3->isFollowing($this->user2));
        $this->assertFalse($this->user->follows($this->user3));
        $this->assertFalse($this->user3->follows($this->user2));
        $this->assertFalse($this->user->hasFollowRequested($this->user3));
        $this->assertTrue($this->user3->hasFollowRequestFrom($this->user2));

        $this->assertEquals($this->user->followRequests()->count(), 1);
        $this->assertEquals($this->user->followerRequests()->count(), 0);
        $this->assertEquals($this->user2->followRequests()->count(), 1);
        $this->assertEquals($this->user2->followerRequests()->count(), 1);
        $this->assertEquals($this->user3->followRequests()->count(), 0);
        $this->assertEquals($this->user3->followerRequests()->count(), 1);
    }

    public function testAcceptFollowRequestUser()
    {
        $this->assertFalse($this->user->acceptFollowRequest($this->user2));

        $this->assertTrue($this->user->followRequest($this->user2));
        $this->assertTrue($this->user2->acceptFollowRequest($this->user));
        $this->assertTrue($this->user->isFollowing($this->user2));
        $this->assertTrue($this->user->unfollow($this->user2));
        $this->assertFalse($this->user->isFollowing($this->user2));
        $this->assertFalse($this->user->follows($this->user2));

        $this->assertEquals($this->user->following()->count(), 0);
        $this->assertEquals($this->user->followRequests()->count(), 0);
        $this->assertEquals($this->user2->followers()->count(), 0);
        $this->assertEquals($this->user2->followerRequests()->count(), 0);
    }

    public function testFollowRequestedUser()
    {
        $this->assertTrue($this->user->followRequest($this->user2));
        $this->assertTrue($this->user->follow($this->user2));
        $this->assertFalse($this->user2->acceptFollowRequest($this->user));
        $this->assertTrue($this->user->isFollowing($this->user2));

        $this->assertEquals($this->user->following()->count(), 1);
        $this->assertEquals($this->user->followRequests()->count(), 0);
        $this->assertEquals($this->user2->followers()->count(), 1);
        $this->assertEquals($this->user2->followerRequests()->count(), 0);
    }

    public function testDeclineFollowRequestUser()
    {
        $this->assertFalse($this->user->declineFollowRequest($this->user2));

        $this->assertTrue($this->user->followRequest($this->user2));
        $this->assertTrue($this->user2->declineFollowRequest($this->user));
        $this->assertFalse($this->user->isFollowing($this->user2));
        $this->assertFalse($this->user->follows($this->user2));

        $this->assertEquals($this->user->following()->count(), 0);
        $this->assertEquals($this->user->followRequests()->count(), 0);
        $this->assertEquals($this->user2->followers()->count(), 0);
        $this->assertEquals($this->user2->followerRequests()->count(), 0);
    }

    public function testCancelFollowRequestUser()
    {
        $this->assertFalse($this->user->cancelFollowRequest($this->user2));

        $this->assertTrue($this->user->followRequest($this->user2));
        $this->assertTrue($this->user->cancelFollowRequest($this->user2));
        $this->assertFalse($this->user->isFollowing($this->user2));

        $this->assertEquals($this->user2->followRequests()->count(), 0);
        $this->assertEquals($this->user2->followers()->count(), 0);
    }

    public function testFollowRequestOtherModel()
    {
        $this->assertTrue($this->user->followRequest($this->page));
        $this->assertFalse($this->user->followRequest($this->page));
        $this->assertTrue($this->user->hasFollowRequested($this->page));
        $this->assertFalse($this->user->isFollowing($this->page));
        $this->assertFalse($this->user->follows($this->page));

        $this->assertTrue($this->user2->followRequest($this->page));
        $this->assertTrue($this->user3->followRequest($this->page));

        $this->assertFalse($this->page->isFollowing($this->user));
        $this->assertFalse($this->page->isFollowing($this->user2));
        $this->assertFalse($this->page->isFollowing($this->user3));
        $this->assertFalse($this->page->follows($this->user));
        $this->assertFalse($this->page->follows($this->user2));
        $this->assertFalse($this->page->follows($this->user3));

        $this->assertEquals($this->page->followRequests()->count(), 0);
        $this->assertEquals($this->page->followerRequests()->count(), 0);
        $this->assertEquals($this->page->followRequests(User::class)->count(), 0);
        $this->assertEquals($this->page->followerRequests(User::class)->count(), 3);

        $this->assertEquals($this->user->followRequests()->count(), 0);
        $this->assertEquals($this->user->followerRequests()->count(), 0);
        $this->assertEquals($this->user->followRequests(Page::class)->count(), 1);
        $this->assertEquals($this->user->followerRequests(Page::class)->count(), 0);

        $this->assertEquals($this->user2->followRequests()->count(), 0);
        $this->assertEquals($this->user2->followerRequests()->count(), 0);
        $this->assertEquals($this->user2->followRequests(Page::class)->count(), 1);
        $this->assertEquals($this->user2->followerRequests(Page::class)->count(), 0);

        $this->assertEquals($this->user3->followRequests()->count(), 0);
        $this->assertEquals($this->user3->followerRequests()->count(), 0);
        $this->assertEquals($this->user3->followRequests(Page::class)->count(), 1);
        $this->assertEquals($this->user3->followerRequests(Page::class)->count(), 0);
    }

    public function testCancelFollowRequestOtherModel()
    {
        $this->assertFalse($this->user->cancelFollowRequest($this->page));

        $this->assertTrue($this->user->followRequest($this->page));
        $this->assertTrue($this->user->cancelFollowRequest($this->page));
        $this->assertFalse($this->user->hasFollowRequested($this->page));

        $this->assertEquals($this->user->followRequests()->count(), 0);
        $this->assertEquals($this->user->followerRequests()->count(), 0);
        $this->assertEquals($this->user->followRequests(Page::class)->count(), 0);
        $this->assertEquals($this->user->followerRequests(Page::class)->count(), 0);

        $this->assertEquals($this->page->followRequests()->count(), 0);
        $this->assertEquals($this->page->followerRequests()->count(), 0);
        $this->assertEquals($this->page->followRequests(User::class)->count(), 0);
        $this->assertEquals($this->page->followerRequests(User::class)->count(), 0);
    }

    public function testAcceptFollowRequestOtherModels()
    {
        $this->assertFalse($this->user->acceptFollowRequest($this->page));

        $this->assertTrue($this->user->followRequest($this->page));
        $this->assertTrue($this->page->acceptFollowRequest($this->user));
        $this->assertTrue($this->user->isFollowing($this->page));
        $this->assertTrue($this->user->unfollow($this->page));
        $this->assertFalse($this->user->isFollowing($this->page));
        $this->assertFalse($this->user->follows($this->page));

        $this->assertEquals($this->user->following()->count(), 0);
        $this->assertEquals($this->user->followRequests()->count(), 0);
        $this->assertEquals($this->page->followers()->count(), 0);
        $this->assertEquals($this->page->followerRequests()->count(), 0);
    }

    public function testDeclineFollowRequestOtherModels()
    {
        $this->assertFalse($this->user->declineFollowRequest($this->page));

        $this->assertTrue($this->user->followRequest($this->page));
        $this->assertTrue($this->page->declineFollowRequest($this->user));
        $this->assertFalse($this->user->isFollowing($this->page));
        $this->assertFalse($this->user->follows($this->page));

        $this->assertEquals($this->user->following()->count(), 0);
        $this->assertEquals($this->user->followRequests()->count(), 0);
        $this->assertEquals($this->page->followers()->count(), 0);
        $this->assertEquals($this->page->followerRequests()->count(), 0);
    }
}
