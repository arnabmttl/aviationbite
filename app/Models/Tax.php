<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'label',
    	'name',
    	'tax_percentage'
    ];

    /**
     * Mutators
     */

    /**
     * Set the tax percentage value.
     *
     * @param  float  $value
     * @return void
     */
    public function setTaxPercentageAttribute($value)
    {
    	$this->attributes['tax_percentage'] = $value*100;
    }

    /**
     * Accessors
     */

    /**
     * Get the value of tax percentage.
     *
     * @param  int  $value
     * @return float
     */
    public function getTaxPercentageAttribute($value)
    {
    	return $value/100;
    }
}
