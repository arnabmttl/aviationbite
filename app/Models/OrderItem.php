<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'course_details' => 'array',
    ];
    
    /**
     * Relationships
     */

    /**
     * Relationship between order item and its order.
     *
     * @return \App\Models\Order
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    /**
     * Relationship between order item and its course.
     *
     * @return \App\Models\Course
     */
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
