<?php

namespace Rennokki\Befriended\Test\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Rennokki\Befriended\Models\BlockerModel;
use Rennokki\Befriended\Test\TestCase;

class BlockerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    protected $alice;
    protected $bob;

    public function setUp(): void
    {
        parent::setUp();
        $this->alice = factory(User::class)->create();
        $this->bob = factory(User::class)->create();
    }

    public function testBlockerAndBlockable() {
        $blocker = factory(BlockerModel::class)->create([
            "blocker_id"     => $this->bob->id,
            "blocker_type"   => "Rennokki\Befriended\Test\Models\User",
            "blockable_id"   => $this->alice->id,
            "blockable_type" => "Rennokki\Befriended\Test\Models\User",
        ]);

        $this->assertEquals($this->alice->id, $blocker->blockable->id);
        $this->assertEquals($this->bob->id, $blocker->blocker->id);

    }
}
