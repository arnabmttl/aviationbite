<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Course;
use App\Models\CourseChapter;

// Services
use App\Services\CourseService;
use App\Services\CourseChapterService;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CourseChapterRequest;
use App\Http\Requests\Backend\CourseChapterUpdateRequest;
use App\Http\Requests\Backend\UploadChapterExcelRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class CourseChaptersController extends Controller
{
    /**
     * CourseService instance to use various functions of CourseService.
     *
     * @var \App\Services\CourseService
     */
    protected $courseChapterService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->courseChapterService = new CourseChapterService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course)
    {
        return view('backend.admin.course.chapter.index', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Course $course)
    {
        return view('backend.admin.course.chapter.create', compact('course')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseChapterRequest $request, Course $course)
    {
        $input = $request->validated();

        /** 
         * Manually input which is not in a form field
         */

        $input['course_id'] = $course->id;
        $input['sort_order'] = 0;

        $result = $this->courseChapterService->createCourseChapter($input);

        if ($result) 
            Session::flash('success', 'The chapter has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the chapter.');

        return redirect(route('chapter.index',$course->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course,CourseChapter $chapter)
    {
        // dd($courseChapter);
         return view('backend.admin.course.chapter.edit', compact('chapter','course')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course,CourseChapter $chapter)
    {
        // dd($chapter->id);
        return view('backend.admin.course.chapter.edit', compact('chapter','course')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return \Illuminate\Http\Response
     */
    public function update(CourseChapterUpdateRequest $request, Course $course, CourseChapter $chapter)
    {
       $update = $request->validated();

       $result = $this->courseChapterService->updateCourseChapterByObject($update, $chapter);

       if($result)
        Session::flash('success', 'The chapter has been updated successfully.');
       else
        Session::flash('success', 'There is some problem in Update the chapter');


        return redirect(route('chapter.index',$course->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseChapter $courseChapter)
    {
        //
    }

    /**
     * Show the form for getting excel for chapter from user.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchChapterExcel()
    {
        $failures = array();

        return view('backend.admin.course.chapter-excel-upload', compact('failures'));
    }

    /**
     * Process the newly uploaded excel for chapters.
     *
     * @param  \App\Http\Requests\Backend\UploadChapterExcelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadChapterExcel(UploadChapterExcelRequest $request)
    {
        $result = $this->courseChapterService->uploadChaptersExcel($request->chapters);

        switch ($result['result']) {
            case 1:
                Session::flash('success', 'You have successfully added chapters.');

                return redirect(route('course.index'));
                
            case 2:
                $failures = $result['failures'];

                return view('backend.admin.course.chapter-excel-upload', compact('failures'));
            
            default:
                Session::flash('failure', 'There is some problem in uploading the excel.');

                return redirect(route('course.index'));
        }
    }
}
