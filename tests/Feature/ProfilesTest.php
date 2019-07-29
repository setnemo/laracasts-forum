<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ProfilesTest extends DatabaseTestCase
{
    /** @test */
    public function testUserHasProfiles()
    {
        $user = create('App\User');
        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /** @test */
    public function testSeeAllThreadByProfileUser()
    {
        $user = create('App\User');

        $this->signIn($user);

        $thread = create('App\Thread', null, ['user_id' => $user->id]);

        $reply = create('App\Reply', null, ['user_id' => $user->id, 'thread_id' => $thread->id]);

        $this->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($reply->title);

    }
}
