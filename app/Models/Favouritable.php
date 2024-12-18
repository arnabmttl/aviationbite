<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

trait Favouritable
{
    /**
    * A reply can be favorited.
    *
    * @return \Illuminate\Database\Eloquent\Relations\MorphMany
    */
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favourited');
    }

    /**
    * Favorite the current reply.
    *
    * @return Model
    */
    public function favourite()
    {
        $attributes = ['user_id' => Auth::id()];

        if (! $this->favourites()->where($attributes)->exists()) {
            return $this->favourites()->create($attributes);
        }
    }

    /**
     * Determines if a reply is favourited or not
     *
     * @return boolean
     */
    public function isFavourited()
    {
        return !! $this->favourites->where('user_id', auth()->id())->count();
    }

    public function getIsFavouritedAttribute()
    {
        return $this->isFavourited();
    }

    /**
    * Get the number of favorites for the reply.
    *
    * @return integer
    */
    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }

    /**
    * Unfavorite the current reply.
    *
    * @return Model
    */
    public function unfavourite()
    {
        $attributes = ['user_id' => Auth::id()];

        return $this->favourites()->where($attributes)->get()->each->delete();
    }
}
