<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class FavoritesTest extends DatabaseTestCase
{
    /** test */
    public function testGuestCanNotFavorite()
    {
        $this->withExceptionHandling()
            ->post('/replies/1/favorites')
            ->assertRedirect('/login');

    }

    /** test */
    public function testAuthUserCanFavoriteToReply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    /** test */
    public function testAuthUserMayAddOnlyOneFavoriteToReply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('/replies/' . $reply->id . '/favorites');
        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }
}
