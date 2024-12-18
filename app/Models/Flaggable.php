<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

trait Flaggable
{
    /**
    * Something can be flagged.
    *
    * @return \Illuminate\Database\Eloquent\Relations\MorphMany
    */
    public function flags()
    {
        return $this->morphMany(Flag::class, 'flagged');
    }

    /**
    * Favorite the current element.
    *
    * @param  string  $reason
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function flag($reason)
    {
        $attributes = [
            'user_id' => Auth::id(),
            'reason' => $reason
        ];

        if (! $this->flags()->where($attributes)->exists()) {
            return $this->flags()->create($attributes);
        }
    }

    /**
     * Determines if an element is flagged or not
     *
     * @return boolean
     */
    public function isFlagged()
    {
        return !! $this->flags->where('user_id', auth()->id())->count();
    }

    public function getIsFlaggedAttribute()
    {
        return $this->isFavourited();
    }

    /**
    * Get the number of flags for the reply.
    *
    * @return integer
    */
    public function getFlagsCountAttribute()
    {
        return $this->flags->count();
    }
}
