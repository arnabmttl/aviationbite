@extends('layouts.frontend.app')

@section('title', $course->name.' Test')

@section('page-styles')
<style>
    .takeTestSlider.owl-carousel .owl-stage {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        width: 100% !important;
    }

    .faqsTabsCont ul {
        margin-bottom: 50px;
    }

    .takeTestCont .tabs li {
        display: flex;
        align-items: center;
        grid-gap: 5px;
    }

    .takeTestCont .rightCont .buttons button:nth-child(1) {
        border: 1px solid #dcdcdc;
        border-radius: 0;
    }

    .takeTestCont .rightCont .buttons button:nth-child(1):hover {
        background: #fff;
    }

    .btnGrey a ,.btnGrey a:hover {
        color: #747980;
    }
</style>
@append

@section('content')
    <!-- BEGIN: User Test Show -->
    <section class="blueBar">
        <a href="{{ route('dashboard') }}">
            <h1 style="font-size: 25px;
        font-weight: 500;
        color: #fff;"><i class="fas fa-angle-left"></i> Dashboard</h1>
        </a>
    </section>
    <section id="cbz-user-test" class="prevent-select forumCont takeTestCont faqsTabsCont pt-5 pb-5">
        <div class="container">
            <div class="row">
                
                <div class="col-md-9 col-12">
                    @include('backend.student.user-test.partial.question-number-and-time')
                    <div class="progressBar"></div>
                    <div class="progress"></div>
                    <div class="displayBar">
                        <div class="quesCount">
                            <span>Question ID: @{{ selectedQuestion?.question?.question_id }}</span>
                        </div>
                    </div>
                    @include('backend.student.user-test.partial.tabs')
                    <div class="totalQues">
                        <button
                            v-if="(questions.indexOf(selectedQuestion) != 0)"
                            class="ques"
                            v-on:click="selectQuestion(questions[(questions.indexOf(selectedQuestion)-1)])">
                                Previous
                        </button>

                        <button
                            v-if="questions.length != (questions.indexOf(selectedQuestion)+1)"
                            class="ques"
                            v-on:click="selectQuestion(questions[(questions.indexOf(selectedQuestion)+1)])">
                                Next
                        </button>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="rightCont">
                        <div class="buttons">
                            <button v-if="isSubmitted !== '1'" class="btn btnGrey">
                                <a v-on:click="finishTest()">
                                    Finish Test
                                </a>
                            </button>
                        </div>
                        <div class="totalQues">
                            <button
                                v-for="(question, index) in questions"
                                :class="['btn', getClassByStatus(question.status), {active: (question.question_id == selectedQuestion?.question_id)}]"
                                v-on:click="selectQuestion(question)">
                                    @{{ index+1 }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: User Test Show -->
@endsection

@section('page-scripts')
    
    <script>
        document.addEventListener('contextmenu', event => event.preventDefault());
        
        new Vue({
            el: "#cbz-user-test",
            
            data: {
                /**
                 * Timer related variables/data.
                 */
                timer: 0,
                interval: null,

                /**
                 * Update question interval to save question every 5 seconds.
                 */
                updateQuestionInterval: null,

                /**
                 * User Test ID. To be consistent while on this page.
                 */
                userTestId: '{{ encrypt($userTest->id) }}',

                /**
                 * User ID. To be consistent while on this page.
                 */
                userId: '{{ encrypt(request()->user()->id) }}',

                /**
                 * Variable to hold failure/success messages.
                 */
                message: {
                    failure: null,
                    success: null
                },

                /**
                 * Variable to hold all the questions of this user test.
                 */
                questions: [],

                /**
                 * Variable to hold currently selected question.
                 */
                selectedQuestion: null,

                /**
                 * Variable to hold the submission status of the test.
                 */
                isSubmitted:  '{{ $userTest->is_submitted }}',

                /**
                 * Variable to hold the time for various questions.
                 */
                timeForQuestion: 0,

                /**
                 * Variable to hold the time left.
                 */
                timeLeft: '{{ $userTest->time_left }}'
            },

            filters: {
                prettify : function(value) {
                    /** 
                     * Convert the value to number if it is a string.
                     */
                    const sec = parseInt(value, 10)
                    
                    /**
                     * Get the number of hours, number of minutes and number of seconds.
                     */
                    let hours   = Math.floor(sec / 3600)
                    let minutes = Math.floor((sec - (hours * 3600)) / 60)
                    let seconds = sec - (hours * 3600) - (minutes * 60)
                    
                    /**
                     * For the cases when hours/minutes/seconds are less than 10 append 0.
                     */
                    if (hours   < 10)
                        hours   = "0"+hours

                    if (minutes < 10)
                        minutes = "0"+minutes

                    if (seconds < 10)
                        seconds = "0"+seconds

                    /**
                     * Return the values in the desired format.
                     */
                    return hours+':'+minutes+':'+seconds
                 }
            },

            methods: {
                /**
                 * Increment the timer by 1.
                 */
                incrementTime() {
                    this.timer = parseInt(this.timer) + 1;
                    this.timeForQuestion = parseInt(this.timeForQuestion) + 1;
                },

                /**
                 * Decrement the time left by 1.
                 */
                decrementTimeLeft() {
                    this.timeLeft = parseInt(this.timeLeft) - 1;
                    this.timeForQuestion = parseInt(this.timeForQuestion) + 1;
                },

                /**
                 * Get the questions by the user test id.
                 */
                getQuestionsByUserTestId() {
                    axios.post(
                        '{{env('APP_URL')}}api/get-questions-by-user-test-id', 
                    {
                        'user_test_id': this.userTestId,
                        'user_id': this.userId
                    }).then((response) => {
                        if (response.data.result) {
                            this.questions = response.data.questions

                            if (!this.selectedQuestion) {
                                this.selectedQuestion = this.questions[0]
                                this.selectedQuestion.status = 1
                            }
                        }
                    }).catch((error) => {
                        this.message.failure = 'There is some problem in fetching the questions as the moment.'
                        this.message.success = ''
                    });
                },

                /**
                 * Select a question to display values of.
                 */
                selectQuestion(question) {
                    this.updateUserTestQuestionById()

                    this.selectedQuestion = question
                    this.timeForQuestion = question.time_taken ? question.time_taken : 0

                    switch (this.selectedQuestion.status) {
                        case 0: this.selectedQuestion.status = 1
                                break
                    }
                },

                /**
                 * Get the class for a question button by the status.
                 */
                getClassByStatus(status) {
                    switch (status) {
                        case 0: return 'notVisited'
                        case 1: return 'visited'
                        case 2: return 'answered'
                        case 3: return 'markedForReview'
                        case 4: return 'markedForReviewAndAnswered'
                        default: return ''
                    }
                },

                /**
                 * Select an option as answer.
                 */
                selectOption(option) {
                    /**
                     * Select an option only if no option is selected for this question.
                     */
                    this.selectedQuestion.question_option_id = option.id

                    switch (this.selectedQuestion.status) {
                        case 1: this.selectedQuestion.status = 2
                                break;
                        
                        case 3: this.selectedQuestion.status = 4
                                break;
                    }

                    if (option.is_correct) {
                        var index = this.questions.findIndex(ques => ques.question_id == this.selectedQuestion.question_id);
                        this.questions[index].is_correct = 1;
                    }

                    this.updateUserTestQuestionById()
                },

                /**
                 * Mark the seledted question for review.
                 */
                markForReview() {
                    switch (this.selectedQuestion.status) {
                        case 1: this.selectedQuestion.status = 3
                                break;
                        
                        case 2: this.selectedQuestion.status = 4
                                break;

                        case 3: this.selectedQuestion.status = 1
                                break;
                        
                        case 4: this.selectedQuestion.status = 2
                                break;
                    }

                    this.updateUserTestQuestionById()
                },

                /**
                 * Update the user test question by id.
                 */
                updateUserTestQuestionById() {
                    if (this.isSubmitted !== '1') {
                        axios.post(
                            '{{env('APP_URL')}}api/update-user-test-question-by-id', 
                        {
                            'question_id': this.selectedQuestion.question_id,
                            'user_id': this.userId,
                            'status': this.selectedQuestion.status,
                            'question_option_id': this.selectedQuestion.question_option_id,
                            'time_taken': this.timeForQuestion
                        }).then((response) => {
                            if (response.data.result) 
                                return true
                            else
                                return false
                        }).catch((error) => {
                            this.message.failure = 'There is some problem in updating the question at the moment.'
                            this.message.success = ''

                            return false
                        });
                    }
                },

                /**
                 * Finish test. Update the question before final submission to update time.
                 */
                finishTest() {
                    this.updateUserTestQuestionById()

                    window.location = "{{ route('user.test.finish', [$userTest->course->slug, encrypt($userTest->id)]) }}"
                }
            },

            beforeMount() {
                this.getQuestionsByUserTestId()
            },

            created() {
                this.interval = setInterval(this.decrementTimeLeft, 1000)
                this.updateQuestionInterval = setInterval(this.updateUserTestQuestionById, 5000);
            }
        });
    </script>

    <script type="text/javascript">
        (function() {
            var d = document,
                tabs = d.querySelector('.faqsTabsCont .tabs'),
                tab = d.querySelectorAll('.faqsTabsCont li'),
                contents = d.querySelectorAll('.faqsTabsCont .content');
            tabs.addEventListener('click', function(e) {
                if (e.target && e.target.nodeName === 'LI') {
                    // change tabs
                    for (var i = 0; i < tab.length; i++) {
                        tab[i].classList.remove('active');
                    }
                    e.target.classList.toggle('active');


                    // change content
                    for (i = 0; i < contents.length; i++) {
                        contents[i].classList.remove('active');
                    }

                    var tabId = '#' + e.target.dataset.tabId;
                    d.querySelector(tabId).classList.toggle('active');
                }
            });
        })();
    </script>

@endsection