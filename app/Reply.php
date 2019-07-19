<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Reply extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    /**
     * @return bool
     */
    public function isFavorited()
    {
         return $this->favorites()->where('user_id', auth()->id())->exists();
    }
}
