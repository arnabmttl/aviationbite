<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Carbon Interval
use Carbon\CarbonInterval;
use Carbon\Carbon;

class UserTest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'is_submitted'
    ];

    /**
     * Accessors
     */

    /**
     * Get the number of questions of the user test.
     *
     * @return int
     */
    public function getNumberOfQuestionsAttribute()
    {
        return $this->questions()
                    ->count();
    }

    /**
     * Get the number of questions correctly answered.
     *
     * @return int
     */
    public function getNumberOfQuestionsCorrectAttribute()
    {
        return $this->questions()
                    ->where('is_correct', 1)
                    ->count();
    }

    /**
     * Get the number of questions incorrectly answered.
     *
     * @return int
     */
    public function getNumberOfQuestionsIncorrectAttribute()
    {
        return $this->questions()
                    ->where('is_correct', 0)
                    ->count();
    }

    /**
     * Get the number of questions incorrectly answered.
     *
     * @return int
     */
    public function getNumberOfQuestionsNotAttemptedAttribute()
    {
        return $this->questions()
                    ->where('is_correct', NULL)
                    ->count();
    }

    /**
     * Get the time taken to complete the user test.
     *
     * @return int
     */
    public function getTimeTakenAttribute()
    {
        return CarbonInterval::seconds($this->questions()->sum('time_taken'))
                               ->cascade()
                               ->forHumans();
    }

    /**
     * Get the number of questions of the user test.
     *
     * @return 
     */
    public function getTimeLeftAttribute()
    {
        return $this->course->test->maximum_time->diffInSeconds(Carbon::parse('00:00:00')) - $this->questions()->sum('time_taken');
    }

    /**
     * Relationships
     */

    /**
     * Get the user test's questions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function questions()
    {
        return $this->hasMany('App\Models\UserTestQuestion');
    }

    /**
     * Get the user test's course.
     *
     * @return \App\Models\Course
     */
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    /**
     * Get the user test's user.
     *
     * @return \App\Models\User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
