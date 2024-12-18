<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeTestQuestion extends Model
{
    use HasFactory;

    protected $table = "take_test_questions";

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
     * @return \App\Models\TakeTest
     */
    public function takeTest()
    {
        return $this->belongsTo('App\Models\TakeTest');
    }

    public function getStatusTextAttribute($value)
    {
    	switch ($value) {
            case 0: return 'Not Visited';
            case 1: return 'Visited';
            case 2: return 'Answered';
    	}
    }
}
