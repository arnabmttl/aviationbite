<?php

namespace App\Services;

// Services
use App\Services\CourseService;
use App\Services\CryptoService;
use App\Services\AuthService;
use App\Services\DiscountService;

// Repositories
use App\Repositories\OrderRepository;
use App\Repositories\TaxRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\OrderItemRepository;

//Razorpay
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class OrderService extends BaseService
{
	/**
	 * OrderRepository instance to access various functions of OrderRepository.
	 *
	 * @var \App\Repositories\OrderRepository
	 */
	protected $orderRepository;

    /**
     * OrderItemRepository instance to access various functions of OrderItemRepository.
     *
     * @var \App\Repositories\OrderItemRepository
     */
    protected $orderItemRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
        $this->orderRepository = new OrderRepository;
		$this->orderItemRepository = new OrderItemRepository;
	}

	/**
     * Create a new order for a user by object and course ids.
     *
     * @param  array  $input
     * @param  \App\Models\User  $user
     * @return \App\Models\Order|boolean
     */
    public function createOrderByUserObject($input, $user)
    {
        try {
            $newOrder = $this->orderRepository->createOrderByUserObject($user);

            if ($newOrder) {
                $amount = 0;
                $discount = null;

                $orderDeleted = 0;
                $courseService = new CourseService;
                foreach ($input['course_id'] as $key => $value) {
                    /**
                     * Fetch the course.
                     */
                    $course = $courseService->getFirstCourseById($value);

                    /**
                     * Start date should be today's date.
                     */
                    $startDate = now();

                    /** 
                     * Create new order item.
                     */
                    $newOrderItem = $this->orderItemRepository->createOrderItemByObject($newOrder, $course, $startDate);

                    /**
                     * Check if order item created successfully or not. If not, then delete the order.
                     */
                    if (!$newOrderItem) {
                        $orderDeleted = 1;
                        $newOrder->delete();
                        $newOrder = false;
                        break;
                    }

                    /**
                     * Add amount of each individual order item to get the total order amount.
                     */
                    $amount += $course->special_price;

                    /**
                     * Fetch the discount.
                     */
                    if (isset($input['discount_code']))
                        $discount = (new DiscountService)->getDisountByDiscountCodeUsernameAndCourseSlug($input['discount_code'], $user->username, $course->slug);
                }

                if(!$orderDeleted){
                    /**
                     * Find GST percentage and calculate tax over the order amount.
                     */
                    $gst = (new TaxRepository)->getFirstTaxByLabel('gst');
                    $tax = round(($amount)*($gst->tax_percentage/100), 2);

                    /**
                     * Save amount, tax_amount and tax_percentage in orders table.
                     */
                    if ($discount) {
                        if ($discount->discount_percentage) {
                            $discountAmount = round(($amount*$discount->discount_percentage/100), 2);

                            if ($discountAmount > $discount->maximum_discount)
                                $discountAmount = $discount->maximum_discount;
                        } else {
                            if ($discount->discount_amount < $discount->maximum_discount)
                                $discountAmount = $discount->discount_amount;
                            else
                                $discountAmount = $discount->maximum_discount;
                        }

                        $newOrder->discount_amount = $discountAmount;
                        $newOrder->discount_id = $discount->id;
                        $newOrder->discount_details = $discount;

                        $tax = round(($amount - $discountAmount)*($gst->tax_percentage/100), 2);
                    }

                    $newOrder->amount = $amount;
                    $newOrder->tax_amount = $tax;
                    $newOrder->tax_percentage = $gst->tax_percentage;
                    $newOrder->save();
                }
            }

            return $newOrder;
        } catch (Exception $e) {
            Log::channel('order')->error('[OrderService:createOrderByUserObject] Order not created by user object because an exception occurred: ');
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Create Razorpay Order Id for the order.
     *
     * @param  \App\Models\Order  $order
     * @return \App\Models\Order|boolean
     */
    public function createRpayOrder($order)
    {
        try {
            /**
             * Get the order amount.
             * IF order amount is 0
             * THEN do not create a razorpay order
             */
            $rpayAmount = $order->total_amount;
            $update = array();

            if($rpayAmount) {
                $api = new Api($_ENV['RAZORPAYAPIKEY'], $_ENV['RAZORPAYAPISECRET']);

                /**
                 * Create new razorpay order using current order details.
                 */
                $razorpayOrder = $api->order->create(array(
                                                      'receipt' => "$order->id",
                                                      'amount' => $rpayAmount*100,
                                                      'payment_capture' => 1, //set 1 for auto capture , 0 for manual capture
                                                      'currency' => 'INR'
                                                    ));

                /**
                 * Update the newly created razorpay order's id for the current order.
                 */
                $update['razorpay_order_id'] = $razorpayOrder->id;
            }

            if ($order->update($update))
                return $order;
            else
                return false;
        } catch (Exception $e) {
            Log::channel('order')->error('[OrderService:createRpayOrder] Razorpay Order Id not created because an exception occured: ');
            Log::channel('order')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Update an Order based on the response by Razorpay.
     *
     * @param  array $paymentResponse
     * @return App\Model\Invoice|boolean
     */
    public function updateOrderPayment($paymentResponse)
    {
    	try {
	        $api = new Api($_ENV['RAZORPAYAPIKEY'],$_ENV['RAZORPAYAPISECRET']);

	        /**
	         * Decrypt the razorpay_order_id.
	         */
	        if ($decryptedRazorpayOrderId = (new CryptoService)->decryptValue($paymentResponse['razorpay_order_id'])) {
                /**
                 * Verify the payment signature for the razorpay order.
                 */
	        	try {
		            $attributes = array(
		                'razorpay_order_id' => $decryptedRazorpayOrderId,
		                'razorpay_payment_id' => $paymentResponse['razorpay_payment_id'],
		                'razorpay_signature' => $paymentResponse['razorpay_signature']
		            );

		            $api->utility->verifyPaymentSignature($attributes);
		        } catch(SignatureVerificationError $e) {
		            Log::channel('order')->error("[OrderService:updateOrderPayment] Razopray signature verification error occured: ");
		            Log::channel('order')->error($e->getMessage());

		            return false;
		        }

                /**
                 * Fetch the order based on the razorpay order id.
                 * Do futher processing only if the order is still in pending state.
                 */
		        $order = $this->orderRepository->getFirstOrderByRazorpayOrderId($decryptedRazorpayOrderId);

		        if ($order->status != 0)
		            return false;

                /**
                 * Update the payment status and the razorpay details for the order.
                 */
		        $update['payment_status'] = 1;
		        $update['razorpay_payment_id'] = $paymentResponse['razorpay_payment_id'];
		        $update['razorpay_signature'] = $paymentResponse['razorpay_signature'];
		        
	            if($order->update($update))
	            {
	                /**
	                 * If order updated successfully then create invoice.
	                 */
	                return (new InvoiceRepository)->createInvoiceByOrderObject($order);
	            }
	            else
	                return false;
	        } else {
	        	Log::channel('order')->error('[OrderService:updateOrderPayment] Order not updated because an exception occured. Visit normal log file to check the exception.');

	        	return false;
	        }
	    } catch (Exception $e) {
	    	Log::channel('order')->error("[OrderService:updateOrderPayment] Order not updated because an exception occured: ");
	        Log::channel('order')->error($e->getMessage());

	        return false;
	    }
    }

    /**
     * Get the paginated list of orders.
     *
     * @param  int $perPage
     * @return \App\Models\Order[]|boolean
     */
    public function getPaginatedListOfOrders($perPage)
    {
        $roleLabel = (new AuthService)->getRoleLabelOfCurrentlyLoggedInUser();

        switch ($roleLabel) {
            case 'admin':
                return $this->orderRepository->getPaginatedListOfOrders($perPage);

            case 'student': 
                return $this->orderRepository->getPaginatedListOfOrdersByUserId((new AuthService)->getIdOfCurrentlyLoggedInUser(), $perPage);
            
            default: 
                /**
                 * User id is provided as -1 so that nothing is returned but still
                 * Illuminate\Pagination\LengthAwarePaginator object is returned.
                 */
                return $this->orderRepository->getPaginatedListOfOrdersByUserId(-1, $perPage);
        }
    }

    /**
     * Get the first order based on the id.
     *
     * @param  int  $id
     * @return \App\Models\Order|boolean
     */
    public function getFirstOrderById($id)
    {
        return $this->orderRepository->getFirstOrderById($id);
    }
}