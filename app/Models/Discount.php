<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'code',
    	'discount_percentage',
    	'discount_amount',
    	'maximum_discount',
    	'valid_from',
    	'valid_till',
    	'credits_to_user_id',
    	'credits_to_be_given'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'valid_from' => 'datetime',
        'valid_till' => 'datetime',
    ];

    /**
     * Mutators
     */

    /**
     * Set the discount percentage value.
     *
     * @param  float $value
     * @return void
     */
    public function setDiscountPercentageAttribute($value)
    {
    	$this->attributes['discount_percentage'] = $value*100;
    }

    /**
     * Set the discount amount value.
     *
     * @param  float $value
     * @return void
     */
    public function setDiscountAmountAttribute($value)
    {
    	$this->attributes['discount_amount'] = $value*100;
    }

    /**
     * Set the maximum discount amount value.
     *
     * @param  float $value
     * @return void
     */
    public function setMaximumDiscountAttribute($value)
    {
    	$this->attributes['maximum_discount'] = $value*100;
    }

    /**
     * Accessors
     */

   	/**
   	 * Get the value of discount percentage.
   	 *
   	 * @param  int $value
   	 * @return float
   	 */
   	public function getDiscountPercentageAttribute($value)
   	{
   		return $value/100;
   	}

   	/**
   	 * Get the value of discount amount.
   	 *
   	 * @param  int $value
   	 * @return float
   	 */
   	public function getDiscountAmountAttribute($value)
   	{
   		return $value/100;
   	}

   	/**
   	 * Get the value of maximum discount.
   	 *
   	 * @param  int $value
   	 * @return float
   	 */
   	public function getMaximumDiscountAttribute($value)
   	{
   		return $value/100;
   	}

    /**
     * Relationships
     */

    /**
     * Relationship between discount and its courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function courses()
    {
        return $this->belongsToMany('App\Models\Course', 'discount_courses');
    }

    /**
     * Relationship between discount and its users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'discount_users');
    }
}
