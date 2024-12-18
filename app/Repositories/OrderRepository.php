<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Order;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class OrderRepository extends BaseRepository
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
     * Create a new order for a user by object.
     *
     * @param  \App\Models\User  $user
     * @return \App\Models\Order|boolean
     */
    public function createOrderByUserObject($user)
    {
        try {
            $newOrder = new Order;
            $newOrder->user_details = $user;

            return $user->orders()->save($newOrder);
        } catch (Exception $e) {
            Log::channel('order')->error("[OrderRepository:createOrderByUserObject] User's new order not created by object because an exception occured: ");
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get first order by RazorpayOrderId.
     *
     * @param  int  $razorpayOrderId
     * @return \App\Models\Order|boolean
     */
    public function getFirstOrderByRazorpayOrderId($razorpayOrderId)
    {
        try {
            return Order::whereRazorpayOrderId($razorpayOrderId)->first();
        } catch(Exception $e) {
            Log::channel('order')->error("[OrderRepository:getFirstOrderByRazorpayOrderId] First order by razorpay order id not found because an exception occured: ");
            Log::channel('order')->error($e->getMessage());
            
            return false;
        }
    }

    /**
     * Get the paginated list of orders.
     *
     * @param  int  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
     */
    public function getPaginatedListOfOrders($perPage)
    {
        try {
            return Order::paginate($perPage);
        } catch (Exception $e) {
            Log::channel('order')->error('[OrderRepository:getPaginatedListOfOrders] Paginated list of orders not fetched because an exception occurred: ');
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the paginated list of orders by user id.
     *
     * @param  int  $userId
     * @param  int  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
     */
    public function getPaginatedListOfOrdersByUserId($userId, $perPage)
    {
        try {
            return Order::whereUserId($userId)->paginate($perPage);
        } catch (Exception $e) {
            Log::channel('order')->error('[OrderRepository:getPaginatedListOfOrdersByUserId] Paginated list of orders by user id not fetched because an exception occurred: ');
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the first order by the id.
     *
     * @param  int  $id
     * @return \App\Models\Order|boolean
     */
    public function getFirstOrderById($id)
    {
        try {
            return Order::whereId($id)->first();
        } catch (Exception $e) {
            Log::channel('order')->error("[OrderRepository:getFirstOrderById] First order by id not fetched because an exception occured: ");
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }
}