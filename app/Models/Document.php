<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'document_type',
        'type'
    ];

    /**
     * Accessors
     */

    /**
     * Get the path of the document.
     *
     * @return string
     */
    public function getPathAttribute()
    {
        return asset('/storage/'.$this->url);
    }

    /**
     * Relationships
     */
    
    /**
     * Get the owning documentable model.
     *
     * @return mixed
     */
    public function documentable()
    {
        return $this->morphTo();
    }
}
