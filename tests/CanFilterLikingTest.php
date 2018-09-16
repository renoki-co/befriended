<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;

class CanFilterLikingTest extends TestCase
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

        factory(\Rennokki\Befriended\Test\Models\Page::class, 10)->create();
    }

    public function testCanFilterLikes()
    {
        $this->assertEquals(Page::likedBy($this->user)->count(), 0);
        $this->assertEquals(Page::likedBy($this->user2)->count(), 0);

        $this->user->like(Page::find(1));
        $this->user->like(Page::find(2));

        $this->assertEquals(Page::likedBy($this->user)->count(), 2);
        $this->assertEquals(Page::likedBy($this->user2)->count(), 0);
    }

    public function testCanFilterNonLikes()
    {
        $this->assertEquals(Page::filterUnlikedFor($this->user)->count(), 10);
        $this->assertEquals(Page::filterUnlikedFor($this->user2)->count(), 10);

        $this->user->like(Page::find(1));
        $this->user->like(Page::find(2));

        $this->assertEquals(Page::filterUnlikedFor($this->user)->count(), 8);
        $this->assertEquals(Page::filterUnlikedFor($this->user2)->count(), 10);
    }
}
