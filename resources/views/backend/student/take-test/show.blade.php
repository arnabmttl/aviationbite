@extends('layouts.frontend.app')
@section('title', $course->name.' Take Test')
@section('page-styles')
@append
@section('content')

<style>
    .takeTestCont .rightCont .buttons button:nth-child(1) {
        border: 1px solid #dcdcdc;
        border-radius: 0;
    }
    .disableAnswer {
        pointer-events: none;
    }
</style>

    <!-- BEGIN: Practice Test Show -->
    @if ($take_test->is_submitted == 0)
    <section class="blueBar">
        <a href="{{ route('single.course', $course->slug) }}">
            <h1><i class="fas fa-angle-left"></i> {{ $course->name }} Take Test</h1>
        </a>
    </section>
    @else
    <section class="blueBar">
        <a href="{{ route('dashboard') }}">
            <h1 style="font-size: 25px;
        font-weight: 500;
        color: #fff;"><i class="fas fa-angle-left"></i> Dashboard</h1>
        </a>
    </section>
    @endif

    <section id="cbz-take-test" class="prevent-select forumCont takeTestCont faqsTabsCont pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-12">
                    <div class="displayBar">
                        <div class="quesCount">
                            <span style="color: rgb(51, 51, 51);" id="quesCountHeader"></span>
                        </div> 
                        <div></div> 
                        <div class="time">
                            <span id="countdown"> </span>
                        </div> 
                        <a title="Next Question" class="next"><i class="fas fa-angle-right"></i></a>
                    </div>
                    <div class="progressBar">
                        <div class="progress"></div>
                    </div>
                    <div class="displayBar">
                        <div class="quesCount">
                            <span id="spanQnId"></span>
                        </div>
                    </div>
                    <nav>
                        <ul class='tabs takeTestSlider owl-carousel owl-theme'>
                            <div class="item">
                                <li class='active' data-tab-id='tab1'><i class="fas fa-caret-right"></i> Question</li>
                            </div>
                            <div class="item">
                                <li data-tab-id='tab6'><i class="far fa-compass"></i> FLT. comp</li>
                            </div>
                        </ul>
                    </nav>
                    <div class="">
                        <div class='content-section'>
                            <div id='tab1' class='content active'>
                                <p style="color: rgb(0, 0, 0); font-weight: 500;" id="qn_title"></p>

                                <div class="forumCardCont">
                                    
                                </div>
                                <div class="totalQues">
                                    <button class="ques" id="prev">Previous</button>
                                    <button class="ques" id="next">Next</button>
                                </div>
                            </div>

                            <div id='tab6' class='content'>
                                <div class="content-section">
                                    <a href="https://online.prepware.com/cx3e/index.html" target="_blank">
                                        ASA:: CX-3 (Click to redirect)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{$course->maximum_time}}
                <div class="col-md-3 col-12">
                    <div class="rightCont">
                        <div class="buttons">
                            <button class="btn btnGrey">
                                <a href="{{ route('take.test.finish',[$course->slug,$encryptedTakeTestId]) }}" onclick="return confirm('Are you sure want to finish the test?');" class="finishBtnCls">
                                    Finish Test
                                </a>
                            </button>
                        </div>
                        <div class="totalQues">
                            @forelse ($take_test_questions as $key => $question)
                            @php
                                $key = $key+1;
                                $answerClass = '';
                                
                                
                                
                                
                            @endphp
                            <button class="btn btnQnNo " id="btnQnNoId{{$question->id}}" onclick="getQn({{$question->id}},{{$key}})">{{$key}}</button>
                            @empty
                                
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Practice Test Show -->
@endsection

@section('page-scripts')
    <script>
        var id = "{{ $take_test_questions[0]->id }}";
        var totalQn = "{{ count($take_test_questions) }}";
        var qnId = "{{ $take_test_questions[0]->question->question_id }}";
        var spanQnId = 'Question ID: '+qnId;
        $('#spanQnId').text(spanQnId);
        var index = 1;  
        let curIndex = index;      
        let curId = id;      
        $(document).ready(function(){
            $('#prev').hide();
            getQn(id,index);  
            
            let timer;
            let hours = "{{$myData['hours']}}";
            let minutes = "{{$myData['minutes']}}";
            let seconds = "{{$myData['seconds']}}";
            
            let countdownTime = timeConversionSeconds(hours,minutes,seconds);

            function formatTime(seconds) {
                let hours = Math.floor(seconds / 3600); // Get hours
                let minutes = Math.floor((seconds % 3600) / 60); // Get minutes
                let remainingSeconds = seconds % 60; // Get remaining seconds

                // Return the formatted time as HH:MM:SS
                return `${padZero(hours)}:${padZero(minutes)}:${padZero(remainingSeconds)}`;
            }
            // Function to add leading zero if the number is less than 10
            function padZero(number) {
                return number < 10 ? '0' + number : number;
            }
            
            timer = setInterval(function() {
                console.log(countdownTime); 
                countdownTime--;
                
                $('#countdown').html('<i class="far fa-clock"></i> '+formatTime(countdownTime));
                if (countdownTime < 0) {
                    clearInterval(timer);
                    alert('Test Ended! Please click ok and finish button'); 
                    $('.ques').prop('disabled', true); 
                    $('.btnQnNo').prop('disabled', true);
                    
                }
            }, 1000); // 1000ms = 1 second
            
        });
        function getQn(id,index){
            $('.btnQnNo').removeClass('active');
            $('#btnQnNoId'+id).addClass('active');
            if(index > 1){
                $('#prev').show();
            } else {
                $('#prev').hide();
            }
            if (index == totalQn) {                
                $('#next').hide();
            } else {
                $('#next').show();
            }
            
            var indexNo = index;
            if(index < 10){
                indexNo = '0'+index;
            }
            var quesCountHeader = indexNo+'/'+totalQn;
            $('#quesCountHeader').text(quesCountHeader);
            $.ajax({
                url: "{{ route('get-take-test-qn-by-id') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                },
                dataType: 'JSON',
                success: function (data) { 
                    // console.log(data);                    
                    var qn_title = data.question.title;
                    $('#qn_title').html(qn_title);
                    
                    // if(data.is_correct == 1){
                    //     $('#btnQnNoId'+id).addClass('correct');
                    // } else if(data.is_correct == 0){
                    //     $('#btnQnNoId'+id).addClass('incorrect');
                    // } else {
                    //     $('#btnQnNoId'+id).removeClass('incorrect');
                    //     $('#btnQnNoId'+id).removeClass('correct');
                    // }

                    if(data.status == 2){
                        $('#btnQnNoId'+id).addClass('answered');
                    }


                    var question_id =  data.question.question_id;
                    spanQnId = 'Question ID: '+question_id;
                    $('#spanQnId').text(spanQnId);

                    var options = data.question.options;
                    let QnOptionsHtml = ``;
                    if(options.length > 0){
                        for(var i = 0; i < options.length; i++){
                            let optionNo = i+1;
                            let correctClass = '';
                            let incorrectClass = '';
                            let isAnswered = false;
                            
                            let selected = '';
                            if(data.status == 2){
                                if(options[i].id == data.question_option_id){
                                    selected = 'selected';
                                    isAnswered = true;
                                    if(options[i].is_correct == 1){
                                        correctClass = 'correct';
                                    } else {
                                        incorrectClass = 'incorrect';
                                    }                                    
                                }
                            }
                            QnOptionsHtml += `<div class="forumCard `+selected+`" id="options_`+options[i].id+`" onclick="saveAnswer(`+optionNo+`,`+options[i].id+`,`+id+`)">
                                        <div class="ques">
                                            <span class="cardNumber ">`+optionNo+`</span>
                                            <p>`+options[i].title+`</p>
                                        </div>
                                    </div>
                                    `;
                        }
                    }
                    $('.forumCardCont').html(QnOptionsHtml);   
                    curIndex = index;   
                    curId = id;   
                }
            }); 
        }

        function saveAnswer(index,val,testQnId){
            $('.forumCard').removeClass('selected');
            $('#options_'+val).addClass('selected');
            // alert('firstSel:-'+ val)
            // $(document).click('.forumCard',function(e){
            //     $('.forumCard').addClass('disableAnswer');
            // });
            $.ajax({
                url: "{{ route('save-answer-take-test-by-id') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    take_test_question_id: testQnId,
                    id: val,
                },
                dataType: 'JSON',
                success: function (data) { 
                    console.log(data);   
                    let incorrect = '';
                    let correct = '';
                    

                    $('#btnQnNoId'+testQnId).addClass('answered')
                    // $('#btnQnNoId'+testQnId).addClass(correct)

                    // $('#options_'+val).addClass(incorrect)
                    // $('#options_'+val).addClass(correct);
                    isAnswered = true;
                                
                }
            }); 
            

            
        }

        $('#next').on('click', function(){            
            let nextCurId = (parseInt(curId)+1);
            let nextCurIndex = (parseInt(curIndex)+1);
            $('#btnQnNoId'+nextCurId).click();         
        });
        $('#prev').on('click', function(){
            let prevCurId = (parseInt(curId)-1);
            let nextCurIndex = (parseInt(curIndex)-1);
            $('#btnQnNoId'+prevCurId).click();       
        });

        function timeConversionSeconds(hours,minutes,seconds){
            hours = parseInt(hours);
            minutes = parseInt(minutes);
            seconds = parseInt(seconds);
            
            let val = (hours * 3600) + (minutes * 60) + seconds ;
            // alert(val);
            return val;
            
        }

        // Disable Ctrl key
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey) {
                event.preventDefault();  // Disable the Ctrl key
                alert('Ctrl key is disabled!');
            }
            if (event.shiftKey) {
                event.preventDefault();  // Disable the Shift key
                alert('Shift key is disabled!');
            }
        });

        // Disable right-click (context menu)
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();  // Disable right-click context menu
            alert('Right-click is disabled!');
        });


        
    </script>
    
@endsection