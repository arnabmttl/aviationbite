<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Course;

// Services
use App\Services\TestService;
use App\Services\CryptoService;

// Repositories
use App\Repositories\UserTestRepository;

// Requests
use Illuminate\Http\Request;

// Support Facades
use Illuminate\Support\Facades\Session;

class UserTestsController extends Controller
{
    /**
     * TestService instance to use various functions of TestService.
     *
     * @var \App\Services\TestService
     */
    protected $testService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:student');
        $this->testService = new TestService;
    }

    /**
     * Create a new user test.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function create(Course $course)
    {
        $result = $this->testService->createUserTestByCourseAndUserObject($course, request()->user());
        
        if ($result) {
            Session::flash('success', 'Your test has been created successfully.');

            return redirect(route('user.test.show', [$course->slug, encrypt($result->id)]));
        } else {
            Session::flash('failure', 'There is some problem in creating a test for you. Please try again.');

            return redirect(route('single.course', $course->slug));
        }
    }

    /**
     * Load the page to give the particular user test.
     *
     * @param  \App\Models\Course  $course
     * @param  string  $encryptedUserTestId
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, $encryptedUserTestId)
    {
        /**
         * Decrypt the user test id.
         * Fetch the corresponding user test.
         * Compare the course's id with the course id of the user test.
         * IF all the above conditions are successful.
         * THEN do further processing.
         * ELSE redirect to dashboard with an error.
         */
        if (($userTestId = (new CryptoService)->decryptValue($encryptedUserTestId)) && ($userTest = (new UserTestRepository)->getFirstUserTestByIdAndUserId($userTestId, request()->user()->id)) && ($course->id == $userTest->course_id)) {
            return view('backend.student.user-test.show', compact('userTest', 'course'));
        }
        else {
            Session::flash('failure', 'There is some error while fetching your test. Kindly try again.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Finish a user test.
     *
     * @param  \App\Models\Course  $course
     * @param  string  $encryptedUserTestId
     * @return \Illuminate\Http\Response
     */
    public function finish(Course $course, $encryptedUserTestId)
    {
        /**
         * Decrypt the user test id.
         * Fetch the corresponding user test.
         * Compare the course's id with the course id of the user test.
         * IF all the above conditions are successful.
         * THEN do further processing.
         * ELSE redirect to dashboard with an error.
         */
        if (($userTestId = (new CryptoService)->decryptValue($encryptedUserTestId)) && ($userTest = (new UserTestRepository)->getFirstUserTestByIdAndUserId($userTestId, request()->user()->id)) && ($course->id == $userTest->course_id)) {
            $result = $this->testService->finishUserTestByObject($userTest);

            if ($result)
                Session::flash('success', 'Test completed successfully.');
            else
                Session::flash('failure', 'There is some error while completing your test. Kindly try again.');

            return redirect(route('user.test.result', [$course->slug, encrypt($userTestId)]));
        }
        else {
            Session::flash('failure', 'There is some error while fetching your test. Kindly try again.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Load the page to show the result of user test.
     *
     * @param  \App\Models\Course  $course
     * @param  string  $encryptedUserTestId
     * @return \Illuminate\Http\Response
     */
    public function result(Course $course, $encryptedUserTestId)
    {
        /**
         * Decrypt the user test id.
         * Fetch the corresponding user test.
         * Compare the course's id with the course id of the user test.
         * Check if the user test is submitted or not.
         * IF all the above conditions are successful.
         * THEN do further processing.
         * ELSE redirect to dashboard with an error.
         */
        if (($userTestId = (new CryptoService)->decryptValue($encryptedUserTestId)) && ($userTest = (new UserTestRepository)->getFirstUserTestByIdAndUserId($userTestId, request()->user()->id)) && ($course->id == $userTest->course_id) && $userTest->is_submitted) {
            return view('backend.student.user-test.result', compact('userTest'));
        }
        else {
            Session::flash('failure', 'There is some error while fetching your test. Kindly try again.');

            return redirect(route('dashboard'));
        }
    }
}
