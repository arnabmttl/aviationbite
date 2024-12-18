<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'text',
        'button_text',
        'redirection_url',
        'type',
        'imageable_id',
        'imageable_type'
    ];

    /**
     * Accessors
     */

    /**
     * Get the value of path.
     *
     * @return string
     */
    public function getPathAttribute()
    {
        return asset('storage/'.$this->url);
    }

    /**
     * Relationships
     */
    
    /**
     * Get the owning imageable model.
     *
     * @return mixed
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Get the image's image.
     *
     * @return \App\Models\Image
     */
    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    /**
     * Relationship between faq and its associated collection items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collectionItems()
    {
        return $this->morphMany('App\Models\CollectionItem', 'collectable');
    }
}
