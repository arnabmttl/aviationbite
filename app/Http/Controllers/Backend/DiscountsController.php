<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Discount;

// Services
use App\Services\DiscountService;

// Repositories
use App\Repositories\DiscountRepository;
use App\Repositories\UserRepository;
use App\Repositories\CourseRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\DiscountCreateRequest;
use App\Http\Requests\Backend\DiscountEditRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class DiscountsController extends Controller
{
    /**
     * DiscountService instance to use various functions of DiscountService.
     *
     * @var \App\Services\DiscountService
     */
    protected $discountService;

    /**
     * DiscountRepository instance to use various functions of DiscountRepository.
     *
     * @var \App\Repositories\DiscountRepository
     */
    protected $discountRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->discountService = new DiscountService;
        $this->discountRepository = new DiscountRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = $this->discountRepository->getPaginatedListOfDiscountsOrderedByUpdatedAt(20);

        if ($discounts)
            return view('backend.admin.discount.index', compact('discounts'));
        else {
            Session::flash('failure', 'There is some problem in fetching discounts at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = (new UserRepository)->getPluckedListOfActiveStudentsByUsernameAndId();
        $courses = (new CourseRepository)->getPluckedListOfActiveCoursesByNameAndId();
        
        if ($students && $courses)
            return view('backend.admin.discount.create', compact('students', 'courses'));
        else {
            Session::flash('failure', 'There is some problem in creating discount at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Backend\DiscountCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountCreateRequest $request)
    {
        $input = $request->validated();

        $result = $this->discountService->createDiscount($input);
        
        if ($result)
            Session::flash('success', 'The discount has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the discount.');

        return redirect(route('discount.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        $students = (new UserRepository)->getPluckedListOfActiveStudentsByUsernameAndId();
        $courses = (new CourseRepository)->getPluckedListOfActiveCoursesByNameAndId();
        
        if ($students && $courses) {
            
                return view('backend.admin.discount.edit', compact('discount', 'students', 'courses'));
           
        } else {
            Session::flash('failure', 'There is some problem in editing discount at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Backend\DiscountEditRequest  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountEditRequest $request, Discount $discount)
    {
        $update = $request->validated();
        
        $result = $this->discountService->updateDiscountByObject($update, $discount);

        if ($result)
            Session::flash('success', 'The discount has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the discount.');

        return redirect(route('discount.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $result = $this->discountRepository->deleteDiscountByObject($discount);
        
        if ($result) 
            Session::flash('success', 'The discount has been deleted successfully.');
        else
            Session::flash('failure', 'There is some problem in deleting the discount.');

        return redirect(route('discount.index'));
    }
}
