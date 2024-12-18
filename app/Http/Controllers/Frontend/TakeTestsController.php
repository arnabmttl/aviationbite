<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\Question;
use App\Models\TakeTest;
use App\Models\TakeTestQuestion;
use App\Models\CourseTest;
use App\Models\CourseTestChapter;

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
use \Illuminate\Database\Eloquent\Collection;

class TakeTestsController extends Controller
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
        $course_test = CourseTest::where('course_id',$course->id)->first();

        if(!empty($course_test)){
            $course_test_chapters = CourseTestChapter::where('course_test_id',$course_test->id)->where('number_of_questions', '!=', 0)->get()->toArray();
            // dd($course_test_chapters);
            if(!empty($course_test_chapters)){
                $questions = $course_chapter_ids = $difficulty_level_ids = array();
                $number_of_questions_total = 0;
                // $questions = new Collection();
                $all_questions = array();
                foreach($course_test_chapters as $ch){
                    $course_chapter_ids[] = $ch['course_chapter_id'];
                    $difficulty_level_ids[] = $ch['difficulty_level_id'];
                    $number_of_questions_total += $ch['number_of_questions']; 
                    $questions = Question::where('course_chapter_id', $ch['course_chapter_id'])->where('difficulty_level_id',$ch['difficulty_level_id'])->limit($ch['number_of_questions'])->inRandomOrder()->get()->toArray();

                    $all_questions =  array_merge($all_questions,$questions);
                }
                // echo '<pre>'; print_r($all_questions); die;
                $takeTestData = array(
                    'user_id' => \Auth::user()->id,
                    'course_id' => $course->id,
                    'created_at' => date('Y-m-d H:i:s')
                );    
                /* Create take test */    
                $take_test_id =  TakeTest::insertGetId($takeTestData);    
                /* Create take test questions */    
                foreach($all_questions as $question){
                    $testQuestionData = array(
                        'take_test_id' => $take_test_id,
                        'question_id' => $question['id'],
                        'status' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    TakeTestQuestion::insert($testQuestionData);
                }
    
                Session::flash('success', 'Your test has been created successfully.');    
                return redirect(route('take.test.show', [$course->slug, encrypt($take_test_id)]));
                
            } else {
                Session::flash('failure', 'No course test details added. Please talk to system administrator');
                return redirect(route('dashboard'));
            }

        } else {
            Session::flash('failure', 'No course test details added. Please talk to system administrator');
            return redirect(route('dashboard'));
        }

    }

    

    /**
     * Load the page to give the particular practice test.
     *
     * @param  \App\Models\Course  $course
     * @param  string  $encryptedTakeTestId
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, $encryptedTakeTestId)
    {
        try {
            $take_test_id = \Crypt::decrypt($encryptedTakeTestId);
            $take_test = TakeTest::find($take_test_id);
            $take_test_questions = TakeTestQuestion::with('question')->where('take_test_id',$take_test_id)->get();

            $myData = array();
            if(!empty($course->test)){
                $maximum_time = $course->test->maximum_time;
                $explode_maximum_time = explode(":",$maximum_time);
                // dd($explode_maximum_time);
                $myData = array();
                $myData['hours'] = substr($explode_maximum_time[0], -2);
                $myData['minutes'] = $explode_maximum_time[1];
                $myData['seconds'] = $explode_maximum_time[2];
            }
            
            
            return view('backend.student.take-test.show', compact('take_test', 'course','take_test_questions','encryptedTakeTestId','myData'));
        } catch ( \DecryptException $e) {
            return redirect(route('dashboard'));
        }


    }

    /**
     * Finish a test.
     *
     * @param  \App\Models\Course  $course
     * @param  string  $encryptedTakeTestId
     * @return \Illuminate\Http\Response
     */
    public function finish(Course $course, $encryptedTakeTestId)
    {
        try {
            $take_test_id = \Crypt::decrypt($encryptedTakeTestId);
            TakeTest::where('id', $take_test_id)->update([
                'is_submitted' => 1
            ]);
            
            Session::flash('success', 'Test completed successfully.');
            return redirect(route('take.test.result', [$course->slug, $encryptedTakeTestId]));
        } catch ( \DecryptException $e) {
            return redirect(route('dashboard'));
        }
        
        
    }

    /**
     * Load the page to show the result of test.
     *
     * @param  \App\Models\Course  $course
     * @param  string  $encryptedTakeTestId
     * @return \Illuminate\Http\Response
     */
    public function result(Course $course, $encryptedTakeTestId)
    {
        try {
            $take_test_id = \Crypt::decrypt($encryptedTakeTestId);
            $take_test = TakeTest::find($take_test_id);
            $take_test_questions = TakeTestQuestion::where('take_test_id', $take_test_id)->get();

            $number_of_questions_correct = TakeTestQuestion::where('take_test_id', $take_test_id)->where('is_correct', 1)->count();
            $number_of_questions_incorrect = TakeTestQuestion::where('take_test_id', $take_test_id)->where('is_correct', 0)->count();
            $number_of_questions_not_attempted = TakeTestQuestion::where('take_test_id', $take_test_id)->where('status', 0)->count();
            $total_time_taken = TakeTestQuestion::where('take_test_id', $take_test_id)->sum('time_taken');

            $all_incorrect_questions = TakeTestQuestion::where('take_test_id', $take_test_id)->where('is_correct', 0)->get();

            return view('backend.student.take-test.result', compact('take_test','take_test_questions','number_of_questions_correct','number_of_questions_incorrect','number_of_questions_not_attempted','total_time_taken','all_incorrect_questions'));

        } catch ( \DecryptException $e) {
            Session::flash('failure', 'There is some error while fetching your test result. Kindly try again.');

            return redirect(route('dashboard'));
        }
        
        
    }
}
