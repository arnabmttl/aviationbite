<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Course;
use App\Models\Page;
use App\Models\Banner;

// Services
use App\Services\CourseService;
use App\Services\UserService;
use App\Services\PageService;

// Repositories
use App\Repositories\EnquiryRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Frontend\EnquiryCreateRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function home()
    // {
    //     if ($page = (new PageService)->getFirstPageBySlug('home-page'))
    //         return view('frontend.page.show', compact('page'));
    //     else
    //         return abort(404);
    // }

    public function home(Request $request)
    {
        $banners = Banner::all();
        $aboutUs = Page::where('slug', 'about-us')->first();
        return view('frontend.home', compact('banners','aboutUs'));
    }

    /**
     * Show the about us page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutUs()
    {
        return view('frontend.about-us');
    }

    public function privacy()
    {
        return view('frontend.privacy');
    }

    public function terms()
    {
        return view('frontend.terms');
    }

    /**
     * Show the courses page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function courses()
    {
        $courses = (new CourseService)->getAllActiveCourses();
        // dd($courses);

        return view('frontend.courses', compact('courses'));
    }

    /**
     * Show the blog page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function blog()
    {
        return view('frontend.blog');
    }

    /**
     * Show the forum page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function forum()
    {
        return view('frontend.forum');
    }

    /**
     * Show the contact us page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contactUs()
    {
        return view('frontend.contact-us');
    }

    /**
     * Show the single course details page.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function courseBySlug(Course $course)
    {
        
        // foreach($course->chapters as $chapter){
        //     echo 'Chapter id:- '.$chapter->id.'<br/>';
        //     echo 'Chapter name:- '.$chapter->name.'<br/>';
        //     foreach($chapter->contents as $content){

        //     }
        // }
        // dd($course->chapters);
        return view('frontend.single-course', compact('course'));
    }

    /**
     * Show the page on frontend.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function showPage(Page $page)
    {
        if ($page->slug == 'home-page')
            return redirect()->route('home');
        else
            return view('frontend.page.show', compact('page'));
    }

    /**
     * Log in the user using encrypted phone number.
     *
     * @param  string  $encryptedUserPhoneNumber
     * @return \Illuminate\Http\Response
     */
    public function logUserInByPhoneNumber($encryptedUserPhoneNumber)
    {
        $userService = new UserService;

        if ($userService->logUserInByPhoneNumber(decrypt($encryptedUserPhoneNumber)))
            Session::flash('success', 'You are successfully logged in.');
        else
            Session::flash('failure', 'There is some problem in logging in. Kindly try again later.');

        return redirect()->back();
    }

    /**
     * Store a newly created enquiry in storage.
     *
     * @param  \App\Http\Requests\Frontend\EnquiryCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function enquiry(EnquiryCreateRequest $request)
    {
        $input = $request->validated();

        $result = (new EnquiryRepository)->createEnquiry($input);

        if ($result)
            Session::flash('success_enquiry_form', 'The enquiry has been logged successfully. Someone from our team will get in touch with you shortly.');
        else
            Session::flash('failure_enquiry_form', 'There is some problem in logging the enquiry. Kindly try after some time.');

        return redirect()->back();
    }
}
