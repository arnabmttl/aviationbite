<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Services
use App\Services\AuthService;
use App\Services\UserService;

// Repositories
use App\Repositories\EnquiryRepository;
use App\Repositories\FlagRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\UpdateUserRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

// Models
use App\Models\Newsletter;
use App\Models\User;
use App\Models\Course;
use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * AuthService instance to use various functions of the AuthService.
     *
     * @var \App\Services\AuthService
     */
    protected $authService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'blocked'])->only('index', 'updateUser');
    	$this->middleware('role:admin')->only('enquiryIndex', 'flaggedRepliesIndex');
    	$this->authService = new AuthService;

        // $currentRouteName =  \Route::currentRouteName();
        // echo $currentRouteName;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	if($roleLabel = $this->authService->getRoleLabelOfCurrentlyLoggedInUser()){
            $totalUsers = User::whereIn('role_id', [2,3])->count();
            $totalCourses = Course::count();
            $totalOrders = Order::count();

            $latestOrders = Order::orderBy('id','desc')->limit(5)->get();
            $latestUsers = User::whereIn('role_id', [2,3])->orderBy('id','desc')->limit(5)->get();
            
            return view('backend.'.$roleLabel.'.index', compact('totalUsers','totalCourses','totalOrders','latestOrders','latestUsers'));
        }else{
            abort(500);
        }
    		
    }

    /**
     * Show the list of enquiries.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function enquiryIndex()
    {
        $enquiries = (new EnquiryRepository)->getPaginatedListOfEnquiriesOrderedByUpdatedAt(20);

        if ($enquiries)
            return view('backend.admin.enquiry.index', compact('enquiries'));
        else {
            Session::flash('failure', 'There is some problem in fetching enquiries at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Show the list of flagged replies.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function flaggedRepliesIndex()
    {
        $flags = (new FlagRepository)->getPaginatedListOfFlagsOrderedByUpdatedAt(15);

        if ($flags)
            return view('backend.admin.flag.index', compact('flags'));
        else {
            Session::flash('failure', 'There is some problem in fetching flagged replies at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Update user.
     *
     * @param  \App\Http\Requests\Backend\UpdateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUser(UpdateUserRequest $request)
    {
        $update = $request->validated();
        
        $result = (new UserService)->updateUserByObject($update, request()->user());
        
        if ($result)
            Session::flash('success', 'The profile has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the profile.');

        return redirect(route('dashboard'));
    }

    /**
     * Newsletter
     **/
    public function newsletter(Request $request)
    {
        $data = Newsletter::orderBy('id', 'desc')->paginate(20);
        return view('backend.admin.newsletter.index', compact('data'));
    }
}
