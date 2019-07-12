<?php


namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];

    /**
     * Filter a query by given username
     *
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Popularity filter dispatcher
     *
     * @param $key
     * @return mixed
     */
    protected function popular($key)
    {
        return method_exists($this, $key) ? $this->$key() : $this->builder;
    }

    protected function all()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }
}
