<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\User;

class BlockingTest extends TestCase
{
    protected $user;
    protected $user2;
    protected $user3;
    protected $page;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\Rennokki\Befriended\Test\Models\User::class)->create();
        $this->user2 = factory(\Rennokki\Befriended\Test\Models\User::class)->create();
        $this->user3 = factory(\Rennokki\Befriended\Test\Models\User::class)->create();
        $this->page = factory(\Rennokki\Befriended\Test\Models\Page::class)->create();
    }

    public function testNoBlockedOrBlocked()
    {
        $this->assertEquals($this->user->blocking()->count(), 0);
        $this->assertEquals($this->user->blockers()->count(), 0);

        $this->assertEquals($this->user2->blocking()->count(), 0);
        $this->assertEquals($this->user2->blockers()->count(), 0);

        $this->assertEquals($this->user3->blocking()->count(), 0);
        $this->assertEquals($this->user3->blockers()->count(), 0);
    }

    public function testblockUser()
    {
        $this->assertTrue($this->user->block($this->user2));

        $this->assertFalse($this->user->block($this->user2));
        $this->assertTrue($this->user->isBlocking($this->user2));

        $this->assertTrue($this->user2->block($this->user3));
        $this->assertFalse($this->user2->block($this->user3));
        $this->assertTrue($this->user2->isBlocking($this->user3));

        $this->assertFalse($this->user->isBlocking($this->user3));
        $this->assertFalse($this->user3->isBlocking($this->user2));

        $this->assertEquals($this->user->blocking()->count(), 1);
        $this->assertEquals($this->user->blockers()->count(), 0);
        $this->assertEquals($this->user2->blocking()->count(), 1);
        $this->assertEquals($this->user2->blockers()->count(), 1);
        $this->assertEquals($this->user3->blocking()->count(), 0);
        $this->assertEquals($this->user3->blockers()->count(), 1);
    }

    public function testUnblockUser()
    {
        $this->assertFalse($this->user->unblock($this->user2));

        $this->assertTrue($this->user->block($this->user2));
        $this->assertTrue($this->user->unblock($this->user2));
        $this->assertFalse($this->user->isBlocking($this->user2));

        $this->assertEquals($this->user->blocking()->count(), 0);
        $this->assertEquals($this->user->blockers()->count(), 0);
        $this->assertEquals($this->user2->blocking()->count(), 0);
        $this->assertEquals($this->user2->blockers()->count(), 0);
    }

    public function testblockOtherModel()
    {
        $this->assertTrue($this->user->block($this->page));
        $this->assertFalse($this->user->block($this->page));
        $this->assertTrue($this->user->isBlocking($this->page));

        $this->assertTrue($this->user2->block($this->page));
        $this->assertTrue($this->user3->block($this->page));

        $this->assertFalse($this->page->isBlocking($this->user));
        $this->assertFalse($this->page->isBlocking($this->user2));
        $this->assertFalse($this->page->isBlocking($this->user3));

        $this->assertEquals($this->page->blocking()->count(), 0);
        $this->assertEquals($this->page->blockers()->count(), 0);
        $this->assertEquals($this->page->blocking(User::class)->count(), 0);
        $this->assertEquals($this->page->blockers(User::class)->count(), 3);

        $this->assertEquals($this->user->blocking()->count(), 0);
        $this->assertEquals($this->user->blockers()->count(), 0);
        $this->assertEquals($this->user->blocking(Page::class)->count(), 1);
        $this->assertEquals($this->user->blockers(Page::class)->count(), 0);

        $this->assertEquals($this->user2->blocking()->count(), 0);
        $this->assertEquals($this->user2->blockers()->count(), 0);
        $this->assertEquals($this->user2->blocking(Page::class)->count(), 1);
        $this->assertEquals($this->user2->blockers(Page::class)->count(), 0);

        $this->assertEquals($this->user3->blocking()->count(), 0);
        $this->assertEquals($this->user3->blockers()->count(), 0);
        $this->assertEquals($this->user3->blocking(Page::class)->count(), 1);
        $this->assertEquals($this->user3->blockers(Page::class)->count(), 0);
    }

    public function testUnblockOtherModel()
    {
        $this->assertFalse($this->user->unblock($this->page));

        $this->assertTrue($this->user->block($this->page));
        $this->assertTrue($this->user->unblock($this->page));
        $this->assertFalse($this->user->isBlocking($this->page));

        $this->assertEquals($this->user->blocking()->count(), 0);
        $this->assertEquals($this->user->blockers()->count(), 0);
        $this->assertEquals($this->user->blocking(Page::class)->count(), 0);
        $this->assertEquals($this->user->blockers(Page::class)->count(), 0);
        $this->assertEquals($this->page->blocking()->count(), 0);
        $this->assertEquals($this->page->blockers()->count(), 0);
        $this->assertEquals($this->page->blocking(User::class)->count(), 0);
        $this->assertEquals($this->page->blockers(User::class)->count(), 0);
    }
}
