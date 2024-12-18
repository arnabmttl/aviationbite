<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_details' => 'array',
        'order_details' => 'array',
        'order_item_details' => 'array',
    ];

    /**
     * Accessors
     */

    /**
     * Get invoice number.
     *
     * @return string
     */
    public function getInvoiceNumberAttribute(){
        return $this->created_at->format('Ym').str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    /**
     * Get the value of total amount.
     *
     * @return float
     */
    public function getTotalAmountAttribute()
    {
        return $this->order_details['amount'] - $this->order_details['discount_amount'] + $this->order_details['tax_amount'];
    }

    /**
     * Relationships
     */

    /**
     * Relationship between invoice and its order.
     *
     * @return \App\Models\Order
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    /**
     * Relationship between invoice and its user.
     *
     * @return \App\Models\User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Relationship between invoice and its user course.
     *
     * @return \App\Models\UserCourse
     */
    public function userCourse()
    {
        return $this->hasOne('App\Models\UserCourse');
    }
}
