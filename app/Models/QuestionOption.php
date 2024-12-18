<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'title',
        'description',
        'is_correct'
    ];

    /**
     * Accessors
     */

    /**
     * Get the image of the option.
     *
     * @return \App\Models\Document
     */
    public function getOptionImageAttribute()
    {
        return $this->documents()
                    ->whereDocumentType(1)
                    ->whereType('Option Image')
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
}
