<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'section_view_id',
        'pageable_id',
        'pageable_type',
        'sectionable_id',
        'sectionable_type',
        'title',
        'sub_title',
        'description',
        'sort_order',
        'margin_top',
        'margin_bottom',
        'bg_color',
        'redirection_url',
    ];

    /**
     * Accessors
     */

    /**
     * Get the value of pageable type url.
     *
     * @return string
     */
    public function getPageableTypeUrlAttribute()
    {
        return strtolower(explode('\\', $this->pageable_type)[2]);
    }

    /**
     * Relationships
     */
    
    /**
     * Get the owning pageable model.
     *
     * @return mixed
     */
    public function pageable()
    {
        return $this->morphTo();
    }

    /**
     * Get the owning sectionable model.
     *
     * @return mixed
     */
    public function sectionable()
    {
        return $this->morphTo();
    }

    /**
     * Relationship between section and its section view.
     *
     * @return \App\Models\SectionView
     */
    public function sectionView()
    {
        return $this->belongsTo('App\Models\SectionView');
    }

    /**
     * Get the section's image.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
