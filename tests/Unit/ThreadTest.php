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

    public function testThreadHasCreator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    public function testThreadHasReplies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $this->thread->replies());
    }

    public function testThreadAddReply()
    {
        $this->thread->addReplay([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function testThreadBelongsToChannel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

}
