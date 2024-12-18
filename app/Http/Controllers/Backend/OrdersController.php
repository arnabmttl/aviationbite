<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Services
use App\Services\OrderService;
use App\Services\CryptoService;
use App\Services\CourseService;
use App\Services\AuthService;

// Repositories
use App\Repositories\TaxRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\OrderCreateRequest;

// Events
use App\Events\InvoiceCreated;

// Support Facades
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    /**
     * OrderService instance to use various functions of the OrderService.
     *
     * @var \App\Services\OrderService
     */
    protected $orderService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->orderService = new OrderService;
    }

    /**
     * Load the checkout page for order.
     *
     * @param  string  $encryptedCourseId
     * @return \Illuminate\Http\Response
     */
  	public function checkout($encryptedCourseId)
    {
    	/**
    	 * Decrypt the course id and fetch the corresponding course for further processing.
    	 */
    	if (($courseId = (new CryptoService)->decryptValue($encryptedCourseId)) && ($course = (new CourseService)->getFirstCourseById($courseId))) {
    		/**
    		 * Fetch order amount from course.
    		 */
    		if($course->special_price)
            	$amount = $course->special_price;
	        else
	            $amount = $course->price;

	        /**
	         * Fetch the tax percentage and compute total amount.
	         */
	        $gst = (new TaxRepository)->getFirstTaxByLabel('gst');
	        $tax = round(($amount)*($gst->tax_percentage/100), 2);
	        $totalAmount = $amount+$tax;

	        /**
	         * Fetch the currently logged in user.
	         */
	        $user = (new AuthService)->getCurrentlyLoggedInUser();

            /**
             * Check if the course is already bought by user and is still active or not.
             * IF still active then return to the course page with failure.
             * ELSE move ahead with the checkout process.
             */
            if ($user->getFirstUserCourseByCourseId($course->id)) {
                Session::flash('failure', 'You had already enrolled for this course.');

                return redirect(route('single.course', $course->slug));
            } else {
                return view('backend.student.order.checkout', compact('course', 'user', 'amount', 'tax', 'totalAmount', 'gst'));
            }
    	}
    	else {
    		Session::flash('failure', 'There is some error while placing the order. Kindly try again.');

    		return redirect(route('dashboard'));
    	}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Backend\OrderCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderCreateRequest $request)
    {
        $input = $request->validated();

        /**
         * Fetch the currently logged in user.
         */
        $currentUser = (new AuthService)->getCurrentlyLoggedInUser();

        /**
         * Create new order.
         */
        $result = $this->orderService->createOrderByUserObject($input, $currentUser);

        if ($result) {
        	/**
        	 * Create razorpay order.
        	 */
            $order = $this->orderService->createRpayOrder($result);

            if ($order)
                return view('backend.student.order.pay', compact('order'));
            else {
                Session::flash('failure', 'There is some problem in creating the order.');

                return redirect(route('dashboard'));
            }
        } else {
            Session::flash('failure', 'There is some problem in creating the order.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Check payment response and create invoice on successful payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentResponse(Request $request)
    {
        $paymentResponse = $request->only('razorpay_order_id','razorpay_payment_id','razorpay_signature');
        
        $result = $this->orderService->updateOrderPayment($paymentResponse);

        if($result)
        {
            event(new InvoiceCreated($result));
            Session::flash('success', 'The payment for order is completed successfully.');

            return redirect(route('single.course', $result->order->items()->first()->course->slug));
        }
        else
        {
            Session::flash('failure', 'There is some problem in completing the payment.');
            return redirect(route('order.index'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderService->getPaginatedListOfOrders(20);

        return view('backend.admin.order.index', compact('orders'));
    }

    /**
     * Load the corresponding view for payment of order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        /**
         * Decrypt the order id and fetch order to show its details else show 404 page.
         */
        if ($orderId = (new CryptoService)->decryptValue($id)) {
            $order = $this->orderService->getFirstOrderById($orderId);

            return view('backend.admin.order.show', compact('order'));
        }
        else
            return abort(404);
    }
}
