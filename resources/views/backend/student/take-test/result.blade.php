@extends('layouts.frontend.app')

@section('title', $take_test->course->name.' Take Test Result')

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
                        <p style="color: #000; font-weight: 500;">{{ $take_test->course->name }} Practice Test Results</p>
                    </div>
                    <div class="forumCardCont">
                        <div class="scoreImg">
                            <img src="{{ asset('frontend/images/award.png') }}">
                        </div>
                        <div class="scores">
                            <div class="ques">
                                <span class="cardNumber score">
                                    <b>Score:</b> {{ $number_of_questions_correct }} ({{ round(($number_of_questions_correct/count($take_test_questions))*100, 2) }}%)
                                </span>
                            </div>
                        </div>
                        <div class="resultInfo">
                            <div class="">
                                <div class="ques">
                                    <span class="cardNumber"><i class="far fa-clock"></i></span>
                                    @php
                                        $hh = floor($total_time_taken / 3600);
                                        $mm = floor(($total_time_taken % 3600) / 60);
                                        $ss = $total_time_taken % 60;
                                        $total_times = sprintf("%02d:%02d:%02d", $hh, $mm, $ss);
                                    @endphp
                                    <p>
                                        <b>Time Taken:</b> {{ $total_times }}
                                    </p>
                                </div>
                            </div>
                            <div class="">
                                <div class="ques">
                                    <span class="cardNumber"><i class="fas fa-check-circle"></i></span>
                                    <p>
                                        {{ $number_of_questions_correct }} ({{ round(($number_of_questions_correct/count($take_test_questions))*100, 2) }}%)
                                    </p>
                                </div>
                            </div>
                            <div class="">
                                <div class="ques">
                                    <span class="cardNumber"><i class="fas fa-times-circle"></i></span>
                                    <p>
                                        {{ $number_of_questions_incorrect }} ({{ round(($number_of_questions_incorrect/count($take_test_questions))*100, 2) }}%)
                                    </p>
                                </div>
                            </div>
                            <div class="">
                                <div class="ques">
                                    <span class="cardNumber"><i class="fas fa-minus-circle"></i></span>
                                    <p>
                                        {{ $number_of_questions_not_attempted }} ({{ round(($number_of_questions_not_attempted/count($take_test_questions))*100, 2) }}%)
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                                 
                        @forelse ($all_incorrect_questions as $index => $question)
                        @php
                            if(!empty($question->time_taken)){
                                $hours = floor($question->time_taken / 3600);
                                $minutes = floor(($question->time_taken % 3600) / 60);
                                $seconds = $question->time_taken % 60;
                                $val = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
                            } else {
                                $val = '00:00:00';
                            }
                            
                        @endphp 
                            <br>
                            <hr>
                            <br>
                            <div class="displayBar">
                                <div class="quesCount">
                                    <span style="color: #333;">Q{{ $index+1 }}/{{ count($take_test_questions) }}</span>
                                </div>
                                <div>
                                    
                                </div>
                                <div class="time">
                                    <span>
                                        <i class="far fa-clock"></i> {{ $val }}
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
                                    @php
                                        $activeClass = '';
                                        if(!empty($question->question_option_id)){
                                            if($question->question_option_id == $option->id){
                                                $activeClass = 'selected';
                                            }
                                        }
                                    @endphp
                                        <div
                                            class="forumCard  {{ $option->is_correct ? 'correct' : '' }} {{$activeClass}}"
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
                        @empty
                                    
                        @endforelse
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