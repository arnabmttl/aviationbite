<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relationships
     */

    /**
     * Get the owning flagged model.
     */
    public function flagged()
    {
        return $this->morphTo();
    }

    /**
     * Get the associated user.
     *
     */
    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }
}
