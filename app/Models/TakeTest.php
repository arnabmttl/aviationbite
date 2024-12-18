<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TakeTestQuestion;

class TakeTest extends Model
{
    use HasFactory;

    protected $table = "take_tests";
    
    /**
     * Get all of the questions for the TakeTest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(TakeTestQuestion::class, 'take_test_id', 'id');
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
}
