<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\User;

class CanFilterLikingTest extends TestCase
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

    public function test_filters_liked_pages()
    {
        $this->assertEquals(
            0, Page::likedBy($this->bob)->count()
        );

        $this->assertEquals(
            0, Page::likedBy($this->alice)->count()
        );

        $this->bob->like(Page::find(1));

        $this->assertEquals(
            1, Page::likedBy($this->bob)->count()
        );

        $this->assertEquals(
            0, Page::likedBy($this->alice)->count()
        );
    }

    public function test_filters_non_liked_pages()
    {
        $this->assertEquals(
            10, Page::filterUnlikedFor($this->bob)->count()
        );

        $this->assertEquals(
            10, Page::filterUnlikedFor($this->alice)->count()
        );

        $this->bob->like(Page::find(1));

        $this->assertEquals(
            9, Page::filterUnlikedFor($this->bob)->count()
        );

        $this->assertEquals(
            10, Page::filterUnlikedFor($this->alice)->count()
        );
    }
}
