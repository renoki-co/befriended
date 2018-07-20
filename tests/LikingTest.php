<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\User;

class LikingTest extends TestCase
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
        $this->assertFalse($this->user->like($this->simplePage));
        $this->assertFalse($this->user->unlike($this->simplePage));
        $this->assertFalse($this->user->isLiking($this->simplePage));
    }

    public function testNoLikedOrLiked()
    {
        $this->assertEquals($this->user->liking()->count(), 0);
        $this->assertEquals($this->user->likers()->count(), 0);

        $this->assertEquals($this->user2->liking()->count(), 0);
        $this->assertEquals($this->user2->likers()->count(), 0);

        $this->assertEquals($this->user3->liking()->count(), 0);
        $this->assertEquals($this->user3->likers()->count(), 0);
    }

    public function testLikeUser()
    {
        $this->assertTrue($this->user->like($this->user2));

        $this->assertFalse($this->user->like($this->user2));
        $this->assertTrue($this->user->isLiking($this->user2));

        $this->assertTrue($this->user2->like($this->user3));
        $this->assertFalse($this->user2->like($this->user3));
        $this->assertTrue($this->user2->isLiking($this->user3));

        $this->assertFalse($this->user->isLiking($this->user3));
        $this->assertFalse($this->user3->isLiking($this->user2));

        $this->assertEquals($this->user->liking()->count(), 1);
        $this->assertEquals($this->user->likers()->count(), 0);
        $this->assertEquals($this->user2->liking()->count(), 1);
        $this->assertEquals($this->user2->likers()->count(), 1);
        $this->assertEquals($this->user3->liking()->count(), 0);
        $this->assertEquals($this->user3->likers()->count(), 1);
    }

    public function testUnlikeUser()
    {
        $this->assertFalse($this->user->unlike($this->user2));

        $this->assertTrue($this->user->like($this->user2));
        $this->assertTrue($this->user->unlike($this->user2));
        $this->assertFalse($this->user->isLiking($this->user2));

        $this->assertEquals($this->user->liking()->count(), 0);
        $this->assertEquals($this->user->likers()->count(), 0);
        $this->assertEquals($this->user2->liking()->count(), 0);
        $this->assertEquals($this->user2->likers()->count(), 0);
    }

    public function testLikeOtherModel()
    {
        $this->assertTrue($this->user->like($this->page));
        $this->assertFalse($this->user->like($this->page));
        $this->assertTrue($this->user->isLiking($this->page));

        $this->assertTrue($this->user2->like($this->page));
        $this->assertTrue($this->user3->like($this->page));

        $this->assertFalse($this->page->isLiking($this->user));
        $this->assertFalse($this->page->isLiking($this->user2));
        $this->assertFalse($this->page->isLiking($this->user3));

        $this->assertEquals($this->page->liking()->count(), 0);
        $this->assertEquals($this->page->likers()->count(), 0);
        $this->assertEquals($this->page->liking(User::class)->count(), 0);
        $this->assertEquals($this->page->likers(User::class)->count(), 3);

        $this->assertEquals($this->user->liking()->count(), 0);
        $this->assertEquals($this->user->likers()->count(), 0);
        $this->assertEquals($this->user->liking(Page::class)->count(), 1);
        $this->assertEquals($this->user->likers(Page::class)->count(), 0);

        $this->assertEquals($this->user2->liking()->count(), 0);
        $this->assertEquals($this->user2->likers()->count(), 0);
        $this->assertEquals($this->user2->liking(Page::class)->count(), 1);
        $this->assertEquals($this->user2->likers(Page::class)->count(), 0);

        $this->assertEquals($this->user3->liking()->count(), 0);
        $this->assertEquals($this->user3->likers()->count(), 0);
        $this->assertEquals($this->user3->liking(Page::class)->count(), 1);
        $this->assertEquals($this->user3->likers(Page::class)->count(), 0);
    }

    public function testUnlikeOtherModel()
    {
        $this->assertFalse($this->user->unlike($this->page));

        $this->assertTrue($this->user->like($this->page));
        $this->assertTrue($this->user->unlike($this->page));
        $this->assertFalse($this->user->isLiking($this->page));

        $this->assertEquals($this->user->liking()->count(), 0);
        $this->assertEquals($this->user->likers()->count(), 0);
        $this->assertEquals($this->user->liking(Page::class)->count(), 0);
        $this->assertEquals($this->user->likers(Page::class)->count(), 0);
        $this->assertEquals($this->page->liking()->count(), 0);
        $this->assertEquals($this->page->likers()->count(), 0);
        $this->assertEquals($this->page->liking(User::class)->count(), 0);
        $this->assertEquals($this->page->likers(User::class)->count(), 0);
    }
}
