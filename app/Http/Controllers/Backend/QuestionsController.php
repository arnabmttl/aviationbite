<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Question;

// Services
use App\Services\QuestionService;
use App\Services\CourseService;

// Repositories
use App\Repositories\QuestionTypeRepository;
use App\Repositories\DifficultyLevelRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Backend\QuestionStoreRequest;
use App\Http\Requests\Backend\QuestionSearchRequest;
use App\Http\Requests\Backend\UploadQuestionExcelRequest;
use App\Http\Requests\Backend\QuestionUpdateRequest;

// Support Facades
use Illuminate\Support\Facades\Session;

class QuestionsController extends Controller
{
    /**
     * QuestionService instance to use various functions of QuestionService.
     *
     * @var \App\Services\QuestionService
     */
    protected $questionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin');
        $this->questionService = new QuestionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = (new CourseService)->getPluckedListOfCoursesByNameAndId();
        $questionTypes = (new QuestionTypeRepository)->getPluckedListOfQuestionTypesByTitleAndId();
        $difficultyLevels = (new DifficultyLevelRepository)->getPluckedListOfDifficultyLevelsByTitleAndId();
        $questions = $this->questionService->getPaginatedListOfQuestions(20);

        if ($courses && $questionTypes && $difficultyLevels && $questions)
            return view('backend.admin.question.index', compact('courses', 'questionTypes', 'difficultyLevels', 'questions'));
        else {
            Session::flash('failure', 'There is some problem in fetching questions at the moment. Kindly try after some time.');

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
        $courses = (new CourseService)->getPluckedListOfCoursesByNameAndId();
        $questionTypes = (new QuestionTypeRepository)->getPluckedListOfQuestionTypesByTitleAndId();
        $difficultyLevels = (new DifficultyLevelRepository)->getPluckedListOfDifficultyLevelsByTitleAndId();
        
        if ($courses && $questionTypes && $difficultyLevels)
            return view('backend.admin.question.create', compact('courses', 'questionTypes', 'difficultyLevels'));
        else {
            Session::flash('failure', 'There is some problem in creating question at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\Backend\QuestionStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionStoreRequest $request)
    {
        $input = $request->validated();
        
        $result = $this->questionService->createQuestion($input);
        
        if ($result)
            Session::flash('success', 'The question has been added successfully.');
        else
            Session::flash('failure', 'There is some problem in adding the question.');

        return redirect(route('question.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $questionTypes = (new QuestionTypeRepository)->getPluckedListOfQuestionTypesByTitleAndId();
        $difficultyLevels = (new DifficultyLevelRepository)->getPluckedListOfDifficultyLevelsByTitleAndId();
        
        if ($questionTypes && $difficultyLevels)
            return view('backend.admin.question.edit', compact('questionTypes', 'difficultyLevels', 'question'));
        else {
            Session::flash('failure', 'There is some problem in updating question at the moment. Kindly try after some time.');

            return redirect(route('dashboard'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\Backend\QuestionUpdateRequest  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        $update = $request->validated();
        
        $result = $this->questionService->updateQuestionByObject($update, $question);
        
        if ($result)
            Session::flash('success', 'The question has been updated successfully.');
        else
            Session::flash('failure', 'There is some problem in updating the question.');

        return redirect(route('question.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }

    /**
     * Search questions.
     *
     * @param  \App\Http\Request\Backend\QuestionSearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function search(QuestionSearchRequest $request)
    {
        $search = $request->validated();
        
        $questions = $this->questionService->getPaginatedListOfQuestionsBySearchTerms($search['question_id'], $search['course_id'], $search['course_chapter_id'], $search['difficulty_level_id'], $search['question_type_id'], 20);
        $courses = (new CourseService)->getPluckedListOfCoursesByNameAndId();
        $questionTypes = (new QuestionTypeRepository)->getPluckedListOfQuestionTypesByTitleAndId();
        $difficultyLevels = (new DifficultyLevelRepository)->getPluckedListOfDifficultyLevelsByTitleAndId();

        if ($courses && $questionTypes && $difficultyLevels && $questions) {
            Session::flash('success', 'The questions have been searched successfully.');

            return view('backend.admin.question.search-result', compact('questions', 'search', 'courses', 'questionTypes', 'difficultyLevels'));
        }
        else {
            Session::flash('failure', 'There is some problem in searching the question.');

            return redirect(route('question.index'));
        }
    }

    /**
     * Show the form for getting excel for question from user.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchQuestionExcel()
    {
        $failures = array();

        return view('backend.admin.question.question-excel-upload', compact('failures'));
    }

    /**
     * Process the newly uploaded excel for questions.
     *
     * @param  \App\Http\Requests\Backend\UploadQuestionExcelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadQuestionExcel(UploadQuestionExcelRequest $request)
    {
        $result = $this->questionService->uploadQuestionsExcel($request->questions);

        switch ($result['result']) {
            case 1:
                Session::flash('success', 'You have successfully added questions.');

                return redirect(route('question.index'));
                
            case 2:
                $failures = $result['failures'];

                return view('backend.admin.question.question-excel-upload', compact('failures'));
            
            default:
                Session::flash('failure', 'There is some problem in uploading the excel.');

                return redirect(route('question.index'));
        }
    }
}
