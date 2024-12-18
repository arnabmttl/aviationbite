<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Carbon Interval
use Carbon\CarbonInterval;

class PracticeTest extends Model
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
     * Get the number of questions of the practice test.
     *
     * @return int
     */
    public function getNumberOfQuestionsAttribute()
    {
        return $this->chapters()
                    ->sum('number_of_questions');
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
     * Get the time taken to complete the practice test.
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
     * Relationships
     */

    /**
     * Get the practice test's questions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function questions()
    {
        return $this->hasMany('App\Models\PracticeTestQuestion');
    }

    /**
     * Get the practice test's chapters.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function chapters()
    {
        return $this->hasMany('App\Models\PracticeTestChapter');
    }

    /**
     * Get the practice test's course.
     *
     * @return \App\Models\Course
     */
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    /**
     * Get the practice test's user.
     *
     * @return \App\Models\User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
