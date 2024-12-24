<?php

namespace App\Http\Controllers;

// Services
use App\Services\CourseService;
use App\Services\TestService;
use App\Services\UserService;
use App\Services\QuestionService;
use App\Services\DiscountService;

// Repositories
use App\Repositories\UserTestRepository;
use App\Repositories\UserTestQuestionRepository;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\API\GetChaptersByCourseIdRequest;
use App\Http\Requests\API\CheckUsernameRequest;
use App\Http\Requests\API\CheckPhoneNumberRequest;
use App\Http\Requests\API\CheckEmailRequest;
use App\Http\Requests\API\GetQuestionsByPracticeTestIdRequest;
use App\Http\Requests\API\UpdatePracticeTestQuestionByIdRequest;
use App\Http\Requests\API\NumberExistsRequest;
use App\Http\Requests\API\VerifyOTPRequest;
use App\Http\Requests\API\UpdateUserRequest;
use App\Http\Requests\API\GetTotalQuestionsByChaptersDifficultyAndTypeRequest;
use App\Http\Requests\API\GetCommentsByQuestionIdRequest;
use App\Http\Requests\API\SaveCommentByPracticeTestQuestionIdRequest;
use App\Http\Requests\API\GetQuestionsByUserTestIdRequest;
use App\Http\Requests\API\UpdateUserTestQuestionByIdRequest;
use App\Http\Requests\API\CheckDiscountCodeRequest;

// Resources
use App\Http\Resources\PracticeTestQuestionResource;
use App\Http\Resources\UserTestQuestionResource;

// Support Facades
use Illuminate\Support\Facades\Log;
use App\Models\TakeTest;
use App\Models\TakeTestQuestion;
use App\Models\QuestionOption;
use App\Models\PracticeTest;
use App\Models\Comment;

// Exception
use Exception;

class APIController extends Controller
{
    /**
     * Get the chapters of a course by course id.
     *
     * @param  \App\Http\Requests\API\GetChaptersByCourseIdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getChaptersByCourseId(GetChaptersByCourseIdRequest $request)
    {
    	/**
    	 * Make an object of course service to get the course details by course id.
    	 */
        $courseService = new CourseService;

        /**
         * Fetch the course by the course id and then fetch its chapters.
         */
        if ($course = $courseService->getFirstCourseById($request->course_id)) {
            $data['result'] = true;
            $data['chapters'] = $course->chapters;
        } else {
            $data['result'] = false;
        }

        return response()->json($data);
    }

    /**
     * Check if the username is valid or not.
     *
     * @param  \App\Http\Requests\API\CheckUsernameRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function checkUsername(CheckUsernameRequest $request)
    {
        return response()->json(['result' => true]);
    }

    /**
     * Check if the phone number is valid or not.
     *
     * @param  \App\Http\Requests\API\CheckPhoneNumberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function checkPhoneNumber(CheckPhoneNumberRequest $request)
    {
        return response()->json(['result' => true]);
    }

    /**
     * Check if the email is valid or not.
     *
     * @param  \App\Http\Requests\API\CheckEmailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function checkEmail(CheckEmailRequest $request)
    {
        return response()->json(['result' => true]);
    }

    /**
     * Get the questions of a practice test by practice test id.
     *
     * @param  \App\Http\Requests\API\GetQuestionsByPracticeTestIdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getQuestionsByPracticeTestId(GetQuestionsByPracticeTestIdRequest $request)
    {
        /**
         * Make an object of test service to get the practice test details by practice test id.
         */
        $testService = new TestService;

        /**
         * Fetch the practice test by the practice test id and user id.
         * Then fetch its questions.
         */
        if ($practiceTest = $testService->getFirstPracticeTestByIdAndUserId($request->practice_test_id, $request->user_id)) {
            $data['result'] = true;
            $data['questions'] = PracticeTestQuestionResource::collection($practiceTest->questions);
        } else {
            $data['result'] = false;
        }

        return response()->json($data);
    }

    /**
     * Get the questions of a practice test by practice test id.
     *
     * @param  \App\Http\Requests\API\UpdatePracticeTestQuestionByIdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePracticeTestQuestionById(UpdatePracticeTestQuestionByIdRequest $request)
    {
        /**
         * Make an object of test service to get the practice test question details by 
         * practice test question id and user id.
         * Moreover, update the practice test question details using that object.
         */
        $testService = new TestService;

        /**
         * Fetch the practice test question by the practice test question id and user id.
         * Then update the question by using the object.
         */
        if ($practiceTestQuestion = $testService->getFirstPracticeTestQuestionByIdAndUserId($request->question_id, $request->user_id)) {
            /**
             * Take validated input and remove the user_id and question_id from update variable.
             */
            $update = $request->validated();
            unset($update['user_id']);
            unset($update['question_id']);

            $data['result'] = $testService->updatePracticeTestQuestionByObject($update, $practiceTestQuestion);
            $data['question'] = $practiceTestQuestion;
        } else {
            $data['result'] = false;
        }

        return response()->json($data);
    }

    /**
     * Check if a number exists in the database or not.
     *
     * @param  \App\Http\Requests\API\NumberExistsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function sendOTP(NumberExistsRequest $request)
    {
        $userService = new UserService;

        $result = $userService->checkNumber($request->phone_number);

        if ($result) {
            $data['result'] = true;
            $data['is_blocked'] = $result->is_blocked;
            $data['is_first_login'] = !$result->username;
            $data['otp'] = $result->otp->otp;
        } else {
            $data['result'] = false;
        }

        return response()->json($data);
    }

    /**
     * Verify OTP for a user and log the user in.
     *
     * @param  \App\Http\Requests\API\VerifyOTPRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyOTP(VerifyOTPRequest $request)
    {
        $input = $request->validated();
        $userService = new UserService;

        if ($userService->verifyOTP($input)) {
            $data['result'] = true;
            $data['redirectTo'] = route('user.loggingin', encrypt($input['phone_number']));

            return response()->json($data);
        }
        else
            return response()->json(false);
    }

    /**
     * Update user details for the phone number is provided.
     *
     * @param  \App\Http\Requests\API\UpdateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUser(UpdateUserRequest $request)
    {
        $update = $request->validated();
        
        $userService = new UserService;
        
        if ($user = $userService->getFirstUserByPhoneNumber($update['phone_number'])) {
            $phoneNumber = $update['phone_number'];
            unset($update['phone_number']);

            $update['newsletter'] = 1;
            if ($userService->updateUserByObject($update, $user)) {
                $data['result'] = true;
                $data['redirectTo'] = route('user.loggingin', encrypt($phoneNumber));
            } else {
                $data['result'] = false;
            }
        } else {
            $data['result'] = false;
        }

        return response()->json($data);            
    }

    /**
     * Get the total number of questions by the chapters, difficulty and type.
     *
     * @param  \App\Http\Requests\API\GetTotalQuestionsByChaptersDifficultyAndTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getTotalQuestionsByChaptersDifficultyAndType(GetTotalQuestionsByChaptersDifficultyAndTypeRequest $request)
    {
        /**
         * Make an object of question service to get the total questions.
         */
        $questionService = new QuestionService;

        /**
         * Fetch total number of questions based on the chapters, difficulty and type.
         */
        $data['result'] = true;
        $data['total_questions'] = $questionService->getTotalQuestionsByChaptersDifficultyAndType($request->chapter_selected, $request->difficulty_level_id, $request->question_type_id);
    
        return response()->json($data);
    }

    /**
     * Get the comments of a question by practice test question id.
     *
     * @param  \App\Http\Requests\API\GetCommentsByQuestionIdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getCommentsByQuestionId(GetCommentsByQuestionIdRequest $request)
    {
        /**
         * Make an object of test service to get the practice test question details by 
         * practice test question id and user id.
         * Moreover, update the practice test question details using that object.
         */
        $testService = new TestService;

        /**
         * Fetch the practice test question by the practice test question id and user id.
         * Then update the question by using the object.
         */
        if ($practiceTestQuestion = $testService->getFirstPracticeTestQuestionByIdAndUserId($request->question_id, $request->user_id)) {
            $data['result'] = true;
            $data['comments'] = $practiceTestQuestion->question->comments;
        } else {
            $data['result'] = false;
        }

        return response()->json($data);
    }

    /**
     * Save the comment of a question by practice test question id.
     *
     * @param  \App\Http\Requests\API\SaveCommentByPracticeTestQuestionIdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function saveCommentByPracticeTestQuestionId(SaveCommentByPracticeTestQuestionIdRequest $request)
    {
        /**
         * Make an object of test service to get the practice test question details by 
         * practice test question id and user id.
         * Moreover, update the practice test question details using that object.
         */
        $testService = new TestService;

        /**
         * Fetch the practice test question by the practice test question id and user id.
         * Then update the question by using the object.
         */
        if (($practiceTestQuestion = $testService->getFirstPracticeTestQuestionByIdAndUserId($request->question_id, $request->user_id)) && ($testService->createCommentByPracticeTestQuestionObject($request->all(), $practiceTestQuestion))) {
            $data['result'] = true;
            $data['comments'] = $practiceTestQuestion->question->comments;
        } else {
            $data['result'] = false;
        }

        return response()->json($data);
    }

    /**
     * Get the questions of a user test by user test id.
     *
     * @param  \App\Http\Requests\API\GetQuestionsByUserTestIdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getQuestionsByUserTestId(GetQuestionsByUserTestIdRequest $request)
    {
        /**
         * Make an object of user test repository to get the user test details by user test id.
         */
        $userTestRepository = new UserTestRepository;

        /**
         * Fetch the user test by the user test id and user id.
         * Then fetch its questions.
         */
        if ($userTest = $userTestRepository->getFirstUserTestByIdAndUserId($request->user_test_id, $request->user_id)) {
            $data['result'] = true;
            $data['questions'] = UserTestQuestionResource::collection($userTest->questions);
        } else {
            $data['result'] = false;
        }

        return response()->json($data);
    }

    /**
     * Update user test question by id.
     *
     * @param  \App\Http\Requests\API\UpdateUserTestQuestionByIdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserTestQuestionById(UpdateUserTestQuestionByIdRequest $request)
    {
        /**
         * Make an object of test service to update the user test question details.
         */
        $testService = new TestService;

        /**
         * Fetch the user test question by the user test question id and user id.
         * Then update the question by using the object.
         */
        if ($userTestQuestion = (new UserTestQuestionRepository)->getFirstUserTestQuestionByIdAndUserId($request->question_id, $request->user_id)) {
            /**
             * Take validated input and remove the user_id and question_id from update variable.
             */
            $update = $request->validated();
            unset($update['user_id']);
            unset($update['question_id']);

            $data['result'] = $testService->updateUserTestQuestionByObject($update, $userTestQuestion);
        } else {
            $data['result'] = false;
        }

        return response()->json($data);
    }

    /**
     * Check if the discount code is valid or not.
     *
     * @param  \App\Http\Requests\API\CheckDiscountCodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function checkDiscountCode(CheckDiscountCodeRequest $request)
    {
        if ($discount = (new DiscountService)->getDisountByDiscountCodeUsernameAndCourseSlug($request->discount_code, $request->username, $request->slug))
            return response()->json([
                'result' => true,
                'discount' => $discount
            ]);

        return response()->json(['result' => false]);
    }

    /**
     * Get Take Test Question By Id
     **/
    public function get_take_test_qn_by_id(Request $request)
    {
        $take_test_id = $request->take_test_id;
        $id = $request->id;

        

        $data = TakeTestQuestion::with(array(
            "question" => function($query) {
                $query->with("options");                
            }
        ))->find($id);

        if($data->status == 0){
            TakeTestQuestion::where('id', $id)->update(['status'=>1]);
        }



        return response()->json($data);
    }

    /**
     * Save Answer Take Test
     **/
    public function save_answer_take_test_by_id(Request $request)
    {
        $take_test_question_id = $request->take_test_question_id;
        $id = $request->id; // option id

        $question_options = QuestionOption::find($id);
        $is_correct = $question_options->is_correct;

        $take_test_qn = TakeTestQuestion::find($take_test_question_id);
        $question_visited_time = $take_test_qn->updated_at;
        $now = date('Y-m-d H:i:s');
        $timeFirst  = strtotime($question_visited_time);
        $timeSecond = strtotime($now);
        $time_taken = ($timeSecond - $timeFirst);
        
        TakeTestQuestion::where('id', $take_test_question_id)->update([
            'question_option_id' => $id,
            'is_correct' => $is_correct,
            'status' => 2,
            'time_taken' => $time_taken
        ]);



        return response()->json([
            'take_test_question_id' => $take_test_question_id,
            'id' => $id,
            'is_correct' => $is_correct,
            'time_taken' => $time_taken
        ]);
    }

    /**
     * 
     **/
    public function saveNotePracticeTest(Request $request)
    {
        // dd($request->all());

        PracticeTest::where('id', $request->id)->update([
            'note' => $request->note
        ]);

        return response()->json([
            'status' => true
        ]);


    }

    /**
     * Report Comment On Practice Test
     **/
    public function report_comment(Request $request)
    {
        $id = $request->id;
        Comment::where('id', $id)->update([
            'is_reported' => 1
        ]);
        $data = array('status' => true);
        return response()->json($data, 200);
    }
}
