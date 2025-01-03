<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['by', 'popular'];
    /*
    * Filter the query by a given username
    * @param string $username
    * @return \Illuminate\Database\Eloquent\Builder
    */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /*
    * Filter the query according to most popular threads
    * @return \Illuminate\Database\Eloquent\Builder
    */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->withCount('replies')->orderBy("replies_count", "desc");
    }
}
