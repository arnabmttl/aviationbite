<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseChapterContent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'duration',
        'content',
        'type',
        'iframe',
        'sort_order',
        'course_chapter_id',
    ];

    
    /**
     * Relationships
     */
    
    /**
     * Get the content's documents.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function documents()
    {
        return $this->morphMany('App\Models\Document', 'documentable');
    }

}
