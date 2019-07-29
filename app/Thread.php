<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
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

    /**
     * @return HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * @return MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    /**
     * @param $replay
     */
    public function addReplay($replay)
    {
        $this->replies()->create($replay);
    }

    /**
     * @param $query
     * @param ThreadFilters $filters
     * @return mixed
     */
    public static function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }
}
