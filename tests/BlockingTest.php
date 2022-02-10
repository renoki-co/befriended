<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\SimplePage;
use Rennokki\Befriended\Test\Models\User;

class BlockingTest extends TestCase
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

    public function test_blocking()
    {
        $this->assertTrue(
            $this->bob->block($this->alice)
        );

        $this->assertFalse(
            $this->bob->block($this->alice)
        );

        $this->assertTrue(
            $this->bob->blocks($this->alice)
        );

        $this->assertEquals(1, $this->bob->blocking()->count());
        $this->assertEquals(0, $this->bob->blockers()->count());

        $this->assertEquals(0, $this->alice->blocking()->count());
        $this->assertEquals(1, $this->alice->blockers()->count());
    }

    public function test_unblocking()
    {
        $this->assertFalse(
            $this->bob->unblock($this->alice)
        );

        $this->bob->block($this->alice);

        $this->assertTrue(
            $this->bob->unblock($this->alice)
        );

        $this->assertFalse(
            $this->bob->blocks($this->alice)
        );

        $this->assertEquals(0, $this->bob->blocking()->count());
        $this->assertEquals(0, $this->bob->blockers()->count());

        $this->assertEquals(0, $this->alice->blocking()->count());
        $this->assertEquals(0, $this->alice->blockers()->count());
    }

    public function test_blocking_with_custom_model()
    {
        $this->assertTrue(
            $this->bob->block($this->page)
        );

        $this->assertFalse(
            $this->bob->block($this->page)
        );

        $this->assertTrue(
            $this->bob->blocks($this->page)
        );

        // Not specifying the model won't return any results.

        $this->assertEquals(0, $this->bob->blocking()->count());
        $this->assertEquals(0, $this->bob->blockers()->count());

        $this->assertEquals(0, $this->page->blocking()->count());
        $this->assertEquals(0, $this->page->blockers()->count());

        // Passing the model should return the values properly.

        $this->assertEquals(1, $this->bob->blocking(Page::class)->count());
        $this->assertEquals(0, $this->bob->blockers(Page::class)->count());

        $this->assertEquals(0, $this->page->blocking(User::class)->count());
        $this->assertEquals(1, $this->page->blockers(User::class)->count());
    }

    public function test_unblocking_with_custom_model()
    {
        $this->assertFalse(
            $this->bob->unblock($this->page)
        );

        $this->bob->block($this->page);

        $this->assertTrue(
            $this->bob->unblock($this->page)
        );

        $this->assertFalse(
            $this->bob->blocks($this->page)
        );

        $this->assertEquals(0, $this->bob->blocking(Page::class)->count());
        $this->assertEquals(0, $this->bob->blockers(Page::class)->count());

        $this->assertEquals(0, $this->page->blocking(User::class)->count());
        $this->assertEquals(0, $this->page->blockers(User::class)->count());
    }
}
