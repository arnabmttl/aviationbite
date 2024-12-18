<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'parent_id',
    	'title',
    	'redirection_url',
        'sort_order'
    ];

    /**
     * Relationships
     */

    /**
     * Relationship between menu item and its parent.
     *
     * @return \App\Models\MenuItem
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\MenuItem', 'parent_id');
    }

    /**
     * Relationship between menu item and its children.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function children()
    {
        return $this->hasMany('App\Models\MenuItem', 'parent_id')->orderBy('sort_order');
    }
}
