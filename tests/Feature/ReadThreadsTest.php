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

        $this->threads = factory('App\Thread', 10)->create();
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
}
