<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'title',
        'description'
    ];

    /**
     * Relationships
     */

    /**
     * Relationship between page and its associated sections.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function sections()
    {
        return $this->morphMany('App\Models\Section', 'pageable')->orderBy('sort_order');
    }

    /**
     * Relationship between page and its associated collection items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collectionItems()
    {
        return $this->morphMany('App\Models\CollectionItem', 'collectable');
    }

    /**
     * Get the page's images.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    /**
     * Get the page's desktop banner images.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function banners()
    {
        return $this->images()->whereType('Desktop Banner');
    }

    /**
     * Functions
     */

    /**
     * Find out if the page is home page or not.
     *
     * @return boolean
     */
    public function isHomePage()
    {
        return $this->slug == 'home-page';
    }
}
