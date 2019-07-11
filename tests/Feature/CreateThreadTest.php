<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class CreateThreadTest extends DatabaseTestCase
{
    /** @test */
    public function testGuestNotSeeCreateThreadPage()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    public function testAuthUserCreateNewThread()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function testThreadCanMakeStringPath()
    {
        $thread = create('App\Thread');

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->getPath());
    }

    /** @test */
    public function testThreadRequiresTitle()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function testThreadRequireBody()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function testThreadRequireChannel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 99])
            ->assertSessionHasErrors('channel_id');
    }

    private function publishThread(array $overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', 1, $overrides);

        return $this->post('/threads', $thread->toArray());
    }

}
