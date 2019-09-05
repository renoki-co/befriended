<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;

class CanFilterFollowingTest extends TestCase
{
    protected $user;
    protected $user2;
    protected $user3;
    protected $page;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(\Rennokki\Befriended\Test\Models\User::class)->create();
        $this->user2 = factory(\Rennokki\Befriended\Test\Models\User::class)->create();

        factory(\Rennokki\Befriended\Test\Models\Page::class, 10)->create();
    }

    public function testCanFilterFollowings()
    {
        $this->assertEquals(Page::filterFollowingsOf($this->user)->count(), 0);
        $this->assertEquals(Page::filterFollowingsOf($this->user2)->count(), 0);

        $this->user->follow(Page::find(1));
        $this->user->follow(Page::find(2));

        $this->assertEquals(Page::filterFollowingsOf($this->user)->count(), 2);
        $this->assertEquals(Page::filterFollowingsOf($this->user2)->count(), 0);
    }

    public function testCanFilterNonFollowings()
    {
        $this->assertEquals(Page::filterUnfollowingsOf($this->user)->count(), 10);
        $this->assertEquals(Page::filterUnfollowingsOf($this->user2)->count(), 10);

        $this->user->follow(Page::find(1));
        $this->user->follow(Page::find(2));

        $this->assertEquals(Page::filterUnfollowingsOf($this->user)->count(), 8);
        $this->assertEquals(Page::filterUnfollowingsOf($this->user2)->count(), 10);
    }
}
