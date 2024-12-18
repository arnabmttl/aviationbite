<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Course;

// Services
use App\Services\CourseService;
use App\Services\TopicService;

// Repositories
use App\Repositories\DifficultyLevelRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CourseStoreRequest;
use App\Http\Requests\Backend\UpdateTestDetailsRequest;
use App\Http\Requests\Backend\CourseUpdateRequest;
use App\Http\Requests\Backend\UploadCourseRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class CoursesController extends Controller
{
    /**
     * CourseService instance to use various functions of CourseService.
     *
     * @var \App\Services\CourseService
     */
    protected $courseService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->courseService = new CourseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.course.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $topics = (new TopicService)->getPluckedListOfTopicsByNameAndId();
        
        if ($topics)
            return view('backend.admin.course.create', compact('topics'));
        else {
            Session::flash('failure', 'There is some problem in creating course at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Backend\CourseStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseStoreRequest $request)
    {
        $input = $request->validated();
        
        $result = $this->courseService->createCourse($input);
        
        if ($result)
            Session::flash('success', 'The course has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the course.');

        return redirect(route('course.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $topics = (new TopicService)->getPluckedListOfTopicsByNameAndId();
        
        if ($topics)
            return view('backend.admin.course.edit', compact('topics', 'course'));
        else {
            Session::flash('failure', 'There is some problem in editing course at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Backend\CourseUpdateRequest  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseUpdateRequest $request, Course $course)
    {
        $update = $request->validated();
        
        $result = $this->courseService->updateCourseByObject($update, $course);

        if ($result)
            Session::flash('success', 'The course has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the course.');

        return redirect(route('course.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    /**
     * Show the form for showing the test details of a course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function editTestDetails(Course $course)
    {
        $numberOfQuestions = $this->courseService->getChapterwiseNumberOfQuestionsByCourseObject($course);
        $difficultyLevels = (new DifficultyLevelRepository)->getPluckedListOfDifficultyLevelsByTitleAndId();

        $timer = array();
        if(!empty($course->test)){
            $maximum_time = $course->test->maximum_time;
            $explode_maximum_time = explode(":",$maximum_time);
            // dd($explode_maximum_time);
            $timer['hours'] = substr($explode_maximum_time[0], -2);
            $timer['minutes'] = $explode_maximum_time[1];
            $timer['seconds'] = $explode_maximum_time[2];
            // dd($timer);
        } 

        return view('backend.admin.course.test.edit', compact('course', 'numberOfQuestions', 'difficultyLevels','timer'));
    }

    
    public function updateTestDetails(Request $request, Course $course)
    {
        // dd($request->all());
        $hours = $request->hours;
        $minutes = $request->minutes;
        $seconds = $request->seconds;
        $maximum_time = $hours.':'.$minutes.':'.$seconds;
        
        $input = $request->except(['_token','_method']);
        $input['maximum_time'] = $maximum_time;
        // dd($input);
        $result = $this->courseService->addTestDetailsByCourseObject($input, $course);

        if ($result)
            Session::flash('success', 'The test details has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the test details.');

        return redirect(route('test.details.edit', $course->id));
    }

    /**
     * Update the test details of a course.
     *
     * @param  \App\Http\Requests\Backend\UpdateTestDetailsRequest  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */

    public function updateTestDetailsBkp(UpdateTestDetailsRequest $request, Course $course)
    {
        $input = $request->validated();

        $result = $this->courseService->addTestDetailsByCourseObject($input, $course);

        if ($result)
            Session::flash('success', 'The test details has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the test details.');

        return redirect(route('test.details.edit', $course->id));
    }

    /**
     * Show the form for getting excel for course from user.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchCourseExcel()
    {
        $failures = array();

        return view('backend.admin.course.course-excel-upload', compact('failures'));
    }

    /**
     * Process the newly uploaded excel for courses.
     *
     * @param  \App\Http\Requests\Backend\UploadCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadCourseExcel(UploadCourseRequest $request)
    {
        $result = $this->courseService->uploadCoursesExcel($request->courses);

        switch ($result['result']) {
            case 1:
                Session::flash('success', 'You have successfully added courses.');

                return redirect(route('course.index'));
                
            case 2:
                $failures = $result['failures'];

                return view('backend.admin.course.course-excel-upload', compact('failures'));
            
            default:
                Session::flash('failure', 'There is some problem in uploading the excel.');

                return redirect(route('course.index'));
        }
    }
}
