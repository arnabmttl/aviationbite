<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'razorpay_order_id',
    	'razorpay_payment_id',
    	'razorpay_signature',
    	'payment_status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_details' => 'array',
        'discount_details' => 'array',
    ];

    /**
     * Mutators
     */

    /**
     * Set the amount value.
     *
     * @param  float $value
     * @return void
     */
    public function setAmountAttribute($value)
    {
    	$this->attributes['amount'] = $value*100;
    }

    /**
     * Set the tax amount value.
     *
     * @param  float $value
     * @return void
     */
    public function setTaxAmountAttribute($value)
    {
    	$this->attributes['tax_amount'] = $value*100;
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
     * Accessors
     */

    /**
     * Get the value of payment method.
     *
     * @param  int $value
     * @return string
     */
    public function getPaymentMethodAttribute($value)
    {
    	switch ($value) {
    		case 0: return 'Cash';
    		case 1: return 'Online';
    	}
    }

    /**
     * Get the value of payment status.
     *
     * @param  int $value
     * @return string
     */
   	public function getPaymentStatusAttribute($value)
   	{
   		switch ($value) {
   			case 0: return 'Pending';
   			case 1: return 'Completed';
   			case 2: return 'Failed';
   		}
   	}

   	/**
   	 * Get the value of amount.
   	 *
   	 * @param  int $value
   	 * @return float
   	 */
   	public function getAmountAttribute($value)
   	{
   		return $value/100;
   	}

   	/**
   	 * Get the value of tax amount.
   	 *
   	 * @param  int $value
   	 * @return float
   	 */
   	public function getTaxAmountAttribute($value)
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
   	 * Get the value of total amount.
   	 *
   	 * @return float
   	 */
   	public function getTotalAmountAttribute()
   	{
   		return ($this->amount - $this->discount_amount) + $this->tax_amount;
   	}

   	/**
     * Get order number.
     *
     * @return string
     */
    public function getOrderNumberAttribute()
    {
        return $this->created_at->format('Ym').str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    /**
     * Relationships
     */

    /**
     * Relationship between order and its user.
     *
     * @return \App\Models\User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Relationship between order and its items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    /**
     * Relationship between order and its invoice.
     *
     * @return \App\Models\Invoice
     */
    public function invoice()
    {
        return $this->hasOne('App\Models\Invoice');
    }
}
