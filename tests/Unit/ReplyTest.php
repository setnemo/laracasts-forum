<?php

namespace Tests\Unit;

use Tests\DatabaseTestCase;

class ReplyTest extends DatabaseTestCase
{
    public function testReplayHasOwner()
    {
        $reply = factory('App\Reply')->create();

        $this->assertInstanceOf('App\User', $reply->owner);
    }
}
