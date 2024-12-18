<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'parent_id',
    	'name'
    ];

    /**
     * Relationships
     */

    /**
     * Relationship betweeen topic and its parent topic.
     *
     * @return \App\Models\Topic
     */
    public function parent()
    {
    	return $this->belongsTo('App\Models\Topic', 'parent_id', 'id');
    }

    /**
     * Relationship between topic and its children topics.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function children()
    {
    	return $this->hasMany('App\Models\Topic', 'parent_id', 'id');
    }
}
