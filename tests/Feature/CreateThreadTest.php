<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function testGuestNotCreateNewThread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = raw('App\Thread');

        $this->post('/threads', $thread);
    }

    public function testAuthUserCreateNewThread()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());

        $response = $this->get($thread->getPath());

        $response->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
