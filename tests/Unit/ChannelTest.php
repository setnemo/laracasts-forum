<?php

namespace Tests\Unit;

use Tests\DatabaseTestCase;

class ChannelTest extends DatabaseTestCase
{
    public function testChannelConsistsThreads()
    {
        $channel = create('App\Channel');

        $thread = create('App\Thread', null, ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
