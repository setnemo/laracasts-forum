<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    public function testUnAuthUserMayNotAddreplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->create();

        $this->post($thread->getPath() . '/replies', []);
    }

    public function testAuthUserMayParticipateInForum()
    {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        $this->post($thread->getPath() . '/replies', $reply->toArray());

        $this->get($thread->getPath())
            ->assertSee($reply->body);
    }
}
