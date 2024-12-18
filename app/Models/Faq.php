<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionable_id',
        'questionable_type',
        'question',
        'answer'
    ];

    /**
     * Relationships
     */

    /**
     * Get FAQ's associated collection items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collectionItems()
    {
        return $this->morphMany('App\Models\CollectionItem', 'collectable');
    }
}
