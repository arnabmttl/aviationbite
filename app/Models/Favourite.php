<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Relationships
     */

    /**
     * Get the favourite's activities.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function activities()
    {
        return $this->morphMany('App\Models\Activity', 'subjectable');
    }

    /**
     * Get the owning favourited model.
     */
    public function favourited()
    {
        return $this->morphTo();
    }
}
