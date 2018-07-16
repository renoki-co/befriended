<?php

namespace Rennokki\Befriended\Test;

use \Rennokki\Befriended\Test\Models\User;
use \Rennokki\Befriended\Test\Models\Page;

class CanFilterBlockingTest extends TestCase
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

    public function testCanFilterBlockers()
    {
       $this->assertEquals(Page::filterBlockingsOf($this->user)->count(), 10);
       $this->assertEquals(Page::filterBlockingsOf($this->user2)->count(), 10);

       $this->user->block(Page::find(1));
       $this->user->block(Page::find(2));

       $this->assertEquals(Page::filterBlockingsOf($this->user)->count(), 8);
       $this->assertEquals(Page::filterBlockingsOf($this->user2)->count(), 10);
    }
}
