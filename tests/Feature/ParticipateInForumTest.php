<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ParticipateInForumTest extends DatabaseTestCase
{
    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function testUnAuthUserMayNotAddreplies()
    {
        $this->withExceptionHandling()
            ->post($this->thread->getPath() . '/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function testAuthUserMayParticipateInForum()
    {
        $this->signIn();

        $reply = make('App\Reply');

        $this->post($this->thread->getPath() . '/replies', $reply->toArray());

        $this->get($this->thread->getPath())
            ->assertSee($reply->body);
    }

    public function testReplyRequiresBody()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        $this->post($thread->getPath() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
