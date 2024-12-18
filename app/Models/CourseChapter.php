<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Carbon
use Carbon\CarbonInterval;

// DB
use DB;

class CourseChapter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'is_preview',
        'course_id',
        'sort_order'
    ];

    /**
     * Accessors
     */

    /**
     * Get the duration of the course.
     *
     * @return \Carbon\CarbonInterval
     */
    public function getDurationAttribute()
    {
        return CarbonInterval::seconds($this->contents()
                    ->sum(DB::raw("TIME_TO_SEC(duration)")))->cascade();
    }

    /**
     * Relationships
     */

    /**
     * Get the course's chapter's contents.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function contents()
    {
        return $this->hasMany('App\Models\CourseChapterContent');
    }

    /**
     * Get the course's chapter's course.
     *
     * @return \App\Models\Course
     */
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    /**
     * Get the course's chapter's questions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }
}
