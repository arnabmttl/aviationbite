<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CourseChapterContentStoreRequest;

 // Models
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseChapterContent;
use App\Models\Document;

// Services
use App\Services\CourseService;
use App\Services\CourseChapterContentService;

// Storage Facades
use Illuminate\Support\Facades\Storage;

// Support Facades
use Illuminate\Support\Facades\Session;

class CourseChapterContentsController extends Controller
{
     /**
     * CourseService instance to use various functions of CourseService.
     *
     * @var \App\Services\CourseService
     */
     protected $courseChapterContentService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->courseChapterContentService = new CourseChapterContentService; 
    }

     /**
     * Display a listing of the Content.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */ 
    public function index(Course $course, CourseChapter $chapter){

        // dd($chapter->contents);

        // $data = CourseChapterContent::all();

        return view('backend.admin.course.chapter.content.index', compact('course','chapter'));
    }


      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function create(Course $course, CourseChapter $chapter, CourseChapterContent $content)
      {

        return view('backend.admin.course.chapter.content.create', compact('course','chapter','content'));
      }


      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      public function store(CourseChapterContentStoreRequest $request, Course $course, CourseChapter $chapter)
      {
        $input = $request->validated();

        // dd($input);

         /**
         * manuly input which is not in form field
         * */
        $input['course_chapter_id'] = $chapter->id;
        $input['sort_order'] = 0;

        $result = $this->courseChapterContentService->createCourseChapterContent($input);

        if ($result) 
            Session::flash('success', 'The content has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the content.');

        return redirect(route('content.index',[$course->id, $chapter->id]));
      }
}
