<?php

namespace Tests\Unit;

use Tests\DatabaseTestCase;

class ThreadTest extends DatabaseTestCase
{
    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function testThreadHasCreator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test */
    public function testThreadHasReplies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $this->thread->replies());
    }

    /** @test */
    public function testThreadAddReply()
    {
        $this->thread->addReplay([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function testThreadBelongsToChannel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

}
