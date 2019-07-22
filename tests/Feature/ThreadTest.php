<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ThreadTest extends DatabaseTestCase
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

    /** @test */
    public function testAuthUserCanDeleteThread()
    {
        $user = create('App\User');
        $this->signIn($user);

        $thread = create('App\Thread', null, ['user_id' => $user->id]);
        $reply = create('App\Reply', null, ['thread_id' => $thread->id]);
        $this->json('DELETE', $thread->getPath())
            ->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id])
            ->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $thread = create('App\Thread', null, ['user_id' => $user->id]);
        $reply = create('App\Reply', null, ['thread_id' => $thread->id]);
        $this->delete($thread->getPath())
            ->assertStatus(302);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id])
            ->assertDatabaseMissing('replies', ['id' => $reply->id]);

    }

    /** @test */
    public function testGuestNotDeleteThread()
    {
        $this->withExceptionHandling();
        $user = create('App\User');
        $userNew = create('App\User');
        $thread = create('App\Thread', null, ['user_id' => $userNew->id]);

        $this->delete($thread->getPath())
            ->assertRedirect('/login');

        $this->signIn($user)
            ->json('DELETE', $thread->getPath())
            ->assertStatus(403);
    }

    /** @support */
    private function publishThread(array $overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', 1, $overrides);

        return $this->post('/threads', $thread->toArray());
    }

}
