<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'collection_id',
        'collectable_id',
        'collectable_type',
        'sort_order'
    ];

    /**
     * Relationships
     */
    
    /**
     * Get the owning collectable model.
     *
     * @return mixed
     */
    public function collectable()
    {
        return $this->morphTo();
    }

    /**
     * Relationship between item and its collection.
     *
     * @return \App\Models\Collection
     */
    public function collection()
    {
        return $this->belongsTo('App\Models\Collection');
    }
}
