<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\SimplePage;
use Rennokki\Befriended\Test\Models\User;

class likeTest extends TestCase
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

    public function test_liking()
    {
        $this->assertTrue(
            $this->bob->like($this->alice)
        );

        $this->assertFalse(
            $this->bob->like($this->alice)
        );

        $this->assertTrue(
            $this->bob->likes($this->alice)
        );

        $this->assertEquals(1, $this->bob->liking()->count());
        $this->assertEquals(0, $this->bob->likers()->count());

        $this->assertEquals(0, $this->alice->liking()->count());
        $this->assertEquals(1, $this->alice->likers()->count());
    }

    public function test_unliking()
    {
        $this->assertFalse(
            $this->bob->unlike($this->alice)
        );

        $this->bob->like($this->alice);

        $this->assertTrue(
            $this->bob->unlike($this->alice)
        );

        $this->assertFalse(
            $this->bob->likes($this->alice)
        );

        $this->assertEquals(0, $this->bob->liking()->count());
        $this->assertEquals(0, $this->bob->likers()->count());

        $this->assertEquals(0, $this->alice->liking()->count());
        $this->assertEquals(0, $this->alice->likers()->count());
    }

    public function test_liking_with_custom_model()
    {
        $this->assertTrue(
            $this->bob->like($this->page)
        );

        $this->assertFalse(
            $this->bob->like($this->page)
        );

        $this->assertTrue(
            $this->bob->likes($this->page)
        );

        // Not specifying the model won't return any results.

        $this->assertEquals(0, $this->bob->liking()->count());
        $this->assertEquals(0, $this->bob->likers()->count());

        $this->assertEquals(0, $this->page->liking()->count());
        $this->assertEquals(0, $this->page->likers()->count());

        // Passing the model should return the values properly.

        $this->assertEquals(1, $this->bob->liking(Page::class)->count());
        $this->assertEquals(0, $this->bob->likers(Page::class)->count());

        $this->assertEquals(0, $this->page->liking(User::class)->count());
        $this->assertEquals(1, $this->page->likers(User::class)->count());
    }

    public function test_unliking_with_custom_model()
    {
        $this->assertFalse(
            $this->bob->unlike($this->page)
        );

        $this->bob->like($this->page);

        $this->assertTrue(
            $this->bob->unlike($this->page)
        );

        $this->assertFalse(
            $this->bob->likes($this->page)
        );

        $this->assertEquals(0, $this->bob->liking(Page::class)->count());
        $this->assertEquals(0, $this->bob->likers(Page::class)->count());

        $this->assertEquals(0, $this->page->liking(User::class)->count());
        $this->assertEquals(0, $this->page->likers(User::class)->count());
    }
}
