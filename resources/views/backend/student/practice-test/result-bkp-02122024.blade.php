@extends('layouts.frontend.app')

@section('title', $practiceTest->course->name.' Practice Test Result')

@section('content')
    <!-- BEGIN: Practice Test Result -->
    <section class="blueBar">
        <a href="{{ route('dashboard') }}">
            <h1><i class="fas fa-angle-left"></i> Dashboard</h1>
        </a>
    </section>
    <section class="prevent-select forumCont resultCont takeTestCont faqsTabsCont pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content-section">
                        <p style="color: #000; font-weight: 500;">{{ $practiceTest->course->name }} Practice Test Results</p>
                    </div>
                    <div class="forumCardCont">
                        <div class="scoreImg">
                            <img src="{{ asset('frontend/images/award.png') }}">
                        </div>
                        <div class="scores">
                            <div class="ques">
                                <span class="cardNumber score">
                                    <b>Score:</b> {{ $practiceTest->number_of_questions_correct }} ({{ round(($practiceTest->number_of_questions_correct/$practiceTest->number_of_questions)*100, 2) }}%)
                                </span>
                            </div>
                        </div>
                        <div class="resultInfo">
                            <div class="">
                                <div class="ques">
                                    <span class="cardNumber"><i class="far fa-clock"></i></span>
                                    <p>
                                        <b>Time Taken:</b> {{ $practiceTest->time_taken }}
                                    </p>
                                </div>
                            </div>
                            <div class="">
                                <div class="ques">
                                    <span class="cardNumber"><i class="fas fa-check-circle"></i></span>
                                    <p>
                                        {{ $practiceTest->number_of_questions_correct }} ({{ round(($practiceTest->number_of_questions_correct/$practiceTest->number_of_questions)*100, 2) }}%)
                                    </p>
                                </div>
                            </div>
                            <div class="">
                                <div class="ques">
                                    <span class="cardNumber"><i class="fas fa-times-circle"></i></span>
                                    <p>
                                        {{ $practiceTest->number_of_questions_incorrect }} ({{ round(($practiceTest->number_of_questions_incorrect/$practiceTest->number_of_questions)*100, 2) }}%)
                                    </p>
                                </div>
                            </div>
                            <div class="">
                                <div class="ques">
                                    <span class="cardNumber"><i class="fas fa-minus-circle"></i></span>
                                    <p>
                                        {{ $practiceTest->number_of_questions_not_attempted }} ({{ round(($practiceTest->number_of_questions_not_attempted/$practiceTest->number_of_questions)*100, 2) }}%)
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                        @foreach ($practiceTest->questions as $index => $question)
                            <br>
                            <hr>
                            <br>
                            <div class="displayBar">
                                <div class="quesCount">
                                    <span style="color: #333;">Q{{ $index+1 }}/{{ $practiceTest->questions->count() }}</span>
                                </div>
                                <div>
                                    
                                </div>
                                <div class="time">
                                    <span>
                                        <i class="far fa-clock"></i> {{ $question->time_taken ?: '00:00:00' }}
                                    </span>
                                </div>
                            </div>
                            <div class='content-section'>
                                <div class='content active'>
                                    <p class="result-question">{{ $question->question->title }}</p>
                                    <div class="forumCardCont">
                                    @if ($question->question->image)
                                        <div class="col-12">
                                            <img src="{{ $question->question->image->path }}">
                                        </div>
                                    @endif
                                    @foreach ($question->question->options as $index1 => $option)
                                        <div
                                            class="forumCard {{ $option->is_correct ? 'correct' : '' }} {{ ($question->question_option_id == $option->id) ? (($option->is_correct) ? 'correct' : 'incorrect') : '' }}"
                                            >
                                            <div class="ques">
                                                <span class="cardNumber">{{ $index1 + 1 }}</span>
                                                <p>
                                                    {{ $option->title }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Practice Test Result -->
@endsection

@section('page-scripts')
    <script type="text/javascript">
        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
@endsection