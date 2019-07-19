<?php


namespace App;


use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Favoritable
{

    /**
     * @return bool
     */
    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * @return integer
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    /**
     * @return MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     *
     */
    public function favorite()
    {
        $params = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($params)->exists()) {
            $this->favorites()->create($params);
        }
    }
}
