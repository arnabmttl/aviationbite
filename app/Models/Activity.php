<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'subjectable_id',
        'subjectable_type'
    ];

    /**
     * Relationships
     */
	
    /**
	 * Get the owning subjectable model.
	 */
    public function subjectable()
    {
        return $this->morphTo();
    }

    /**
     * Functions
     */

    public static function feed($user, $take=50)
    {
        return static::where('user_id', $user->id)
                ->latest()
                ->with('subjectable')
                ->take($take)
                ->get()
                ->groupBy(function($activity) {
                    return $activity->created_at->format('Y-m-d');
                });
    }
}
