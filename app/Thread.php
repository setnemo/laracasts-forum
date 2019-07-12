<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\ThreadFilters;

class Thread extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::addGlobalScope('creator', function ($builder) {
            $builder->with('creator');
        });
        static::addGlobalScope('channel', function ($builder) {
            $builder->with('channel');
        });
    }

    /**
     * Fetch path to the current thread
     *
     * @return string
     */
    public function getPath(): string
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function addReplay($replay)
    {
        $this->replies()->create($replay);
    }

    public static function filter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }
}
