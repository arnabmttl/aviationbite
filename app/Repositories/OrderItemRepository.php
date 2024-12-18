<?php

namespace App\Repositories;

// Model for the repository
use App\Models\OrderItem;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class OrderItemRepository extends BaseRepository
{
	/**
	 * Create a new repository instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
     * Create a new order item for an order by object.
     *
     * @param  \App\Models\Order  $order
     * @param  \App\Models\Course  $course
     * @param  date  $startDate
     * @return \App\Models\OrderItem|boolean
     */
    public function createOrderItemByObject($order, $course, $startDate)
    {
        try {
            $newOrderItem = new OrderItem;
            $newOrderItem->course_id = $course->id;
            $newOrderItem->course_details = $course;
            $newOrderItem->start_date = $startDate;
            
           return $order->items()->save($newOrderItem);
        } catch (Exception $e) {
            Log::channel('order')->error("[OrderItemRepository:createOrderItemByObject] New order item not created by object because an exception occured: ");
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }
}