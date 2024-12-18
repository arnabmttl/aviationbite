<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'maximum_time'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'maximum_time' => 'datetime',
    ];

    /**
     * Relationships
     */

    /**
     * Get the course test's chapters.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function chapters()
    {
        return $this->hasMany('App\Models\CourseTestChapter');
    }
}
