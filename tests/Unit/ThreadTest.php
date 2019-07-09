<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    public function testThreadHasReplies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $this->thread->replies());
    }

    public function testThreadHasCreator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    public function testThreadAddReply()
    {
        $this->thread->addReplay([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
