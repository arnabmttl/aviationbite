<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'course_chapter_id',
        'question_type_id',
        'difficulty_level_id',
        'title',
        'description',
        'previous_years',
        'explanation',
        'practice_test_comment'
    ];

    /**
     * Accessors
     */

    /**
     * Get the image of the question.
     *
     * @return \App\Models\Document
     */
    public function getQuestionImageAttribute()
    {
        return $this->documents()
                    ->whereDocumentType(1)
                    ->whereType('Question Image')
                    ->first();
    }

    /**
     * Relationships
     */

    /**
     * Get the question's documents.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function documents()
    {
        return $this->morphMany('App\Models\Document', 'documentable');
    }

    /**
     * Get the question's options.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function options()
    {
        return $this->hasMany('App\Models\QuestionOption');
    }

    /**
     * Get the question's chapter.
     *
     * @return \App\Models\CourseChapter
     */
    public function chapter()
    {
        return $this->belongsTo('App\Models\CourseChapter', 'course_chapter_id');
    }

    /**
     * Get the question's comments.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment')
                    ->orderBy('id', 'desc');
    }
}
