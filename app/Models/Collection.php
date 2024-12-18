<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_sub_section'
    ];

    /**
     * Relationships
     */

    /**
     * Relationship between collection and its associated items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function items()
    {
        return $this->hasMany('App\Models\CollectionItem')->orderBy('sort_order');
    }

    /**
     * Relationship between collection and its sections.
     *
     * @return \App\Models\Section
     */
    public function sections()
    {
        return $this->morphMany('App\Models\Section', 'sectionable');
    }
}
