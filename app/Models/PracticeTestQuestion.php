<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeTestQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'status',
        'question_option_id',
        'is_correct',
        'marks_awarded',
        'time_taken'
    ];

    /**
     * Accessors
     */

    /**
     * Get the value of status text.
     *
     * @param  int $value
     * @return string
     */
    public function getStatusTextAttribute($value)
    {
    	switch ($value) {
            case 0: return 'Not Visited';
            case 1: return 'Visited';
            case 2: return 'Answered';
            case 3: return 'Marked For Review';
            case 4: return 'Marked For Review And Answered';
    	}
    }

    /**
     * Relationships
     */

    /**
     * Get the practice test question's question.
     *
     * @return \App\Models\Question
     */
    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }

    /**
     * Get the practice test question's practice test.
     *
     * @return \App\Models\PracticeTest
     */
    public function practiceTest()
    {
        return $this->belongsTo('App\Models\PracticeTest');
    }
}
