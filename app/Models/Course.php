<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Carbon
use Carbon\CarbonInterval;

// DB
use DB;

class Course extends Model
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
        'name',
        'short_description',
        'description',
        'price',
        'special_price',
        'valid_for',
        'is_active',
        'payout',
        'total_rating',
        'total_reviews',
        'video_url',
        'number_of_tests',
        'created_by_id',
        'updated_by_id',
        'approved_by_id',
        'approved_at'
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        /**
         * IF the field used for route model binding is 'slug'
         * THEN only fetch the course in case it is active.
         * ELSE use the default logic.
         */
        if ($field == 'slug') {
            return $this->where($field ?? $this->getRouteKeyName(), $value)->whereIsActive(1)->first();
        }

        return $this->where($field ?? $this->getRouteKeyName(), $value)->first();
    }

    /**
     * Mutators
     */

    /**
     * Set the price value.
     *
     * @param  float  $value
     * @return void
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value*100;
    }

    /**
     * Set the special price value.
     *
     * @param  float  $value
     * @return void
     */
    public function setSpecialPriceAttribute($value)
    {
        $this->attributes['special_price'] = $value*100;
    }

    /**
     * Accessors
     */

    /**
     * Get the thumbnail of the course.
     *
     * @return \App\Models\File
     */
    public function getThumbnailAttribute()
    {
        return $this->documents()
                    ->whereDocumentType(1)
                    ->whereType('Thumbnail')
                    ->first();
    }

    /**
     * Get the duration of the course.
     *
     * @return \Carbon\CarbonInterval
     */
    public function getDurationAttribute()
    {
        return CarbonInterval::seconds($this->contents()
                    ->sum(DB::raw("TIME_TO_SEC(duration)")))->cascade();
    }

    /**
     * Get the value of price.
     *
     * @param  int  $value
     * @return float
     */
    public function getPriceAttribute($value)
    {
        return $value/100;
    }

    /**
     * Get the value of special price.
     *
     * @param  int  $value
     * @return float
     */
    public function getSpecialPriceAttribute($value)
    {
        return $value/100;
    }

    /**
     * Get the value of last updated on.
     *
     * @return \Carbon\Carbon
     */
    public function getLastUpdatedOnAttribute()
    {
        /**
         * Fetch the latest chapter and content.
         */
        $latestChapter = $this->chapters()->latest() ? $this->chapters()->latest()->first() : null;
        $latestContent = $this->contents()->latest() ? $this->contents()->latest()->first() : null;

        /**
         * Compute the last updated on based on various conditions.
         */
        $lastUpdatedOn = $latestChapter ? ($this->updated_at->gt($latestChapter->updated_at) ? $this->updated_at : $latestChapter->updated_at) : $this->updated_at;

        return $latestContent ? ($lastUpdatedOn->gt($latestContent->updated_at) ? $lastUpdatedOn : $latestContent->updated_at) : $lastUpdatedOn;
    }

    /**
     * Relationships
     */

    /**
     * Get the course's topics.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function topics()
    {
        return $this->belongsToMany('App\Models\Topic', 'course_topics');
    }

    /**
     * Get the course's documents.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function documents()
    {
        return $this->morphMany('App\Models\Document', 'documentable');
    }

    /**
     * Get the course's chapters.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function chapters()
    {
        return $this->hasMany('App\Models\CourseChapter');
    }

    /**
     * Get the course's chapter's contents.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function contents()
    {
        return $this->hasManyThrough('App\Models\CourseChapterContent', 'App\Models\CourseChapter');
    }

    /**
     * Get the course's test.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function test()
    {
        return $this->hasOne('App\Models\CourseTest');
    }

    /**
     * Relationship between course and its associated collection items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collectionItems()
    {
        return $this->morphMany('App\Models\CollectionItem', 'collectable');
    }

    /**
     * Relationship between course and its user course.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function userCourses()
    {
        return $this->hasMany('App\Models\UserCourse');
    }
}
