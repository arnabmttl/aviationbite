<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Course;

// Services
use App\Services\TestService;
use App\Services\CryptoService;

// Repositories
use App\Repositories\DifficultyLevelRepository;
use App\Repositories\QuestionTypeRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\PracticeTestStoreRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class PracticeTestsController extends Controller
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
     * Show the form for creating a new practice test.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function create(Course $course)
    {
        $difficultyLevels = (new DifficultyLevelRepository)->getPluckedListOfDifficultyLevelsByTitleAndId();
        $questionTypes = (new QuestionTypeRepository)->getPluckedListOfQuestionTypesByTitleAndId();
        
        if ($difficultyLevels && $questionTypes)
            return view('backend.student.practice-test.create', compact('course', 'difficultyLevels', 'questionTypes'));
        else {
            Session::flash('failure', 'There is some problem in creating practice test at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Store a newly created practice test in storage.
     *
     * @param  \App\Http\Requests\Backend\PracticeTestStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PracticeTestStoreRequest $request, Course $course)
    {
        $input = $request->validated();
        
        $result = $this->testService->createPracticeTestByCourseAndUserObject($input, $course, $request->user());
        
        if ($result) {
            Session::flash('success', 'Your practice test has been created successfully.');

            return redirect(route('practice.test.show', [$course->slug, encrypt($result->id)]));
        } else {
            Session::flash('failure', 'There is some problem in creating a practice test for you. Please try again.');

            return redirect(route('single.course', $course->slug));
        }
    }

    /**
     * Load the page to give the particular practice test.
     *
     * @param  \App\Models\Course  $course
     * @param  string  $encryptedPracticeTestId
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, $encryptedPracticeTestId)
    {
        
        /**
         * Decrypt the practice test id.
         * Fetch the corresponding practice test.
         * Compare the course's id with the course id of the practice test.
         * IF all the above conditions are successful.
         * THEN do further processing.
         * ELSE redirect to dashboard with an error.
         */
        if (($practiceTestId = (new CryptoService)->decryptValue($encryptedPracticeTestId)) && ($practiceTest = $this->testService->getFirstPracticeTestByIdAndUserId($practiceTestId, request()->user()->id)) && ($course->id == $practiceTest->course_id)) {
            return view('backend.student.practice-test.show', compact('practiceTest', 'course'));
        }
        else {
            Session::flash('failure', 'There is some error while fetching your practice test. Kindly try again.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Finish a practice test.
     *
     * @param  \App\Models\Course  $course
     * @param  string  $encryptedPracticeTestId
     * @return \Illuminate\Http\Response
     */
    public function finish(Course $course, $encryptedPracticeTestId)
    {
        /**
         * Decrypt the practice test id.
         * Fetch the corresponding practice test.
         * Compare the course's id with the course id of the practice test.
         * IF all the above conditions are successful.
         * THEN do further processing.
         * ELSE redirect to dashboard with an error.
         */
        if (($practiceTestId = (new CryptoService)->decryptValue($encryptedPracticeTestId)) && ($practiceTest = $this->testService->getFirstPracticeTestByIdAndUserId($practiceTestId, request()->user()->id)) && ($course->id == $practiceTest->course_id)) {
            $result = $this->testService->finishPracticeTestByObject($practiceTest);

            if ($result)
                Session::flash('success', 'Practice test completed successfully.');
            else
                Session::flash('failure', 'There is some error while completing your practice test. Kindly try again.');

            return redirect(route('practice.test.result', [$course->slug, encrypt($practiceTestId)]));
        }
        else {
            Session::flash('failure', 'There is some error while fetching your practice test. Kindly try again.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Load the page to show the result of practice test.
     *
     * @param  \App\Models\Course  $course
     * @param  string  $encryptedPracticeTestId
     * @return \Illuminate\Http\Response
     */
    public function result(Course $course, $encryptedPracticeTestId)
    {
        /**
         * Decrypt the practice test id.
         * Fetch the corresponding practice test.
         * Compare the course's id with the course id of the practice test.
         * Check if the practice test is submitted or not.
         * IF all the above conditions are successful.
         * THEN do further processing.
         * ELSE redirect to dashboard with an error.
         */
        if (($practiceTestId = (new CryptoService)->decryptValue($encryptedPracticeTestId)) && ($practiceTest = $this->testService->getFirstPracticeTestByIdAndUserId($practiceTestId, request()->user()->id)) && ($course->id == $practiceTest->course_id) && $practiceTest->is_submitted) {
            return view('backend.student.practice-test.result', compact('practiceTest'));
        }
        else {
            Session::flash('failure', 'There is some error while fetching your practice test. Kindly try again.');

            return redirect(route('dashboard'));
        }
    }
}
