<?php

namespace Tests\Unit;

use App\Activity;
use Tests\DatabaseTestCase;

class ActivityTest extends DatabaseTestCase
{
    /** @test */
    public function testActivityThenThreadCreated()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread',
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function testActivityThenReplyCreated()
    {
        $this->signIn();

        create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }
}
