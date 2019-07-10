<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

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
}
