<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\User;

class CanFilterFollowingTest extends TestCase
{
    protected $bob;

    protected $alice;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bob = factory(User::class)->create();

        $this->alice = factory(User::class)->create();

        factory(Page::class, 10)->create();
    }

    public function test_filters_followed_pages()
    {
        $this->assertEquals(
            0, Page::filterFollowingsOf($this->bob)->count()
        );

        $this->assertEquals(
            0, Page::filterFollowingsOf($this->alice)->count()
        );

        $this->bob->follow(Page::find(1));

        $this->assertEquals(
            1, Page::filterFollowingsOf($this->bob)->count()
        );

        $this->assertEquals(
            0, Page::filterFollowingsOf($this->alice)->count()
        );
    }

    public function test_filters_non_followed_pages()
    {
        $this->assertEquals(
            10, Page::filterUnfollowingsOf($this->bob)->count()
        );

        $this->assertEquals(
            10, Page::filterUnfollowingsOf($this->alice)->count()
        );

        $this->bob->follow(Page::find(1));

        $this->assertEquals(
            9, Page::filterUnfollowingsOf($this->bob)->count()
        );

        $this->assertEquals(
            10, Page::filterUnfollowingsOf($this->alice)->count()
        );
    }
}
