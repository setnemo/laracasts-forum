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

        $thread = create('App\Thread', null, ['user_id' => $user->id]);
        $this->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
}
