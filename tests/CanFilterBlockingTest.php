<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\User;

class CanFilterBlockingTest extends TestCase
{
    protected $bob;

    protected $alice;

    public function setUp(): void
    {
        parent::setUp();

        $this->bob = factory(User::class)->create();

        $this->alice = factory(User::class)->create();

        factory(Page::class, 10)->create();
    }

    public function test_can_filter_blockers()
    {
        $this->assertEquals(
            10, Page::filterBlockingsOf($this->bob)->count()
        );

        $this->assertEquals(
            10, Page::filterBlockingsOf($this->alice)->count()
        );

        $this->bob->block(Page::find(1));

        $this->assertEquals(
            9, Page::filterBlockingsOf($this->bob)->count()
        );

        $this->assertEquals(
            10, Page::filterBlockingsOf($this->alice)->count()
        );
    }
}
