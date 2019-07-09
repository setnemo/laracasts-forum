<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    /**
     * Fetch path to the current thread
     *
     * @return string
     */
    public function getPath(): string
    {
        return '/threads/' . $this->id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReplay($replay)
    {
        $this->replies()->create($replay);
    }
}
