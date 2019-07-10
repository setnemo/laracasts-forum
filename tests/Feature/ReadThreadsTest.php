<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ReadThreadsTest extends DatabaseTestCase
{
    protected $threads;

    public function setUp(): void
    {
        parent::setUp();

        $this->threads = create('App\Thread', 10);
    }

    public function testUserShowAllThreads()
    {
        $response = $this->get('/threads');

        foreach ($this->threads as $thread) {
            $response->assertSee($thread->title);
            $response->assertSee($thread->body);
        }
    }

    public function testUserShowSingleThread()
    {
        foreach ($this->threads as $thread) {
            $this->get($thread->getPath())->assertSee($thread->title);
        }
    }

    public function testUserCanReadRepliesForThread()
    {
        foreach ($this->threads as $thread) {
            $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);
            $this->get($thread->getPath())->assertSee($reply->body);
        }
    }

    public function testFilterThreadAccordingChannel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', null, ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function testUserCanFilterThreadByUsername()
    {
        $this->signIn(create('App\User', null, ['name' => 'JohnSnow']));

        $threadByJhon = create('App\Thread', null, ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $this->get('threads?by=JohnSnow')
            ->assertSee($threadByJhon->title)
            ->assertDontSee($threadNotByJohn->title);
    }
}
