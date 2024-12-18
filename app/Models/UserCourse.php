<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_from' => 'datetime',
        'end_on' => 'datetime',
    ];

    /**
     * Relationships
     */

    /**
     * Get the user course's course.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
