@extends('layouts.frontend.app')

@section('title', $course->name)

@section('content')
    <!-- BEGIN: Single Course -->
    <!-- Courses section -->
    <section class="about courses mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="aboutText singleCourseText">
                        <p class="title dark course-title">{{ $course->name }}</p>
                        <p class="title dark course-topics">
                        	@foreach ($course->topics as $topic)
                        		{{ $topic->name }},
                        	@endforeach
                        </p>
                        {!! $course->short_description !!}
                        <br/>
                        {!! $course->description !!}
                        
                        <p class="desc">
                            <span><img src="{{ asset('frontend/images/lastUpdated.svg') }}">Last Updated On: {{ $course->last_updated_on->format('d/m/Y') }}</span>
                            
                            <span><img src="{{ asset('frontend/images/chapters.svg') }}">{{ $course->chapters->count() }} Chapters</span>
                        </p>
                        
                        <br/>
                    @auth
                        @if (auth()->user()->getFirstUserCourseByCourseId($course->id))
                            <a href="{{ route('practice.test.create', $course->slug) }}">
                                <button class="btn btn-theme btnLarge">Practice</button>
                            </a>
                        @else
                            @if ($course->special_price != $course->price)
                                <p class="title price"><s>₹ {{ $course->price }}</s>  ₹ {{ $course->special_price }}</p>
                            @else
                                <p class="title price">₹ {{ $course->price }}</p>
                            @endif
                            <a href="{{ route('order.checkout', encrypt($course->id)) }}">
                                <button class="btn btn-theme btnLarge">Enroll Now</button>
                            </a>
                        @endif
                    @else
                        @if ($course->special_price != $course->price)
                            <p class="title price"><s>₹ {{ $course->price }}</s>  ₹ {{ $course->special_price }}</p>
                        @else
                            <p class="title price">₹ {{ $course->price }}</p>
                        @endif
                        <a data-bs-toggle="modal" data-bs-target="#loginModal">
                            <button class="btn btn-theme btnLarge">Enroll Now</button>
                        </a>
                    @endauth
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="testCard">
                    @if ($course->video_url)
                        <div class="holder">
                            <iframe width="560" height="315" src="{{ $course->video_url }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <div class="overlay trigger" src="{{ $course->video_url }}" data-bs-target="#videoModal" data-bs-toggle="modal"></div>
                        </div>
                        <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                <div class="modal-content">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="icon">
                            <img src="{{ asset('frontend/images/list_icon.png') }}" alt="icon">
                        </div>
                    @endif
                        <p class="title">{{ $course->number_of_tests }} Test Included</p>

                        @auth
                            
                            @if ($course->number_of_tests > count(auth()->user()->take_test_course($course->id)))
                                @if (auth()->user()->getFirstUserCourseByCourseId($course->id))
                                    <a href="{{ route('take.test.create', $course->slug) }}" onclick="return confirm('Are you sure want to start the test?');">
                                        <button class="btn">Take Test</button>
                                    </a>   
                                    
                                @else
                                <a href="javascript:void(0)" onclick="testValidityExpired()">
                                    <button class="btn">Take Test</button>
                                </a>
                                @endif    
                            
                            @else
                                <a href="javascript:void(0)" onclick="testQuotaExpired()">
                                    <button class="btn">Take Test</button>
                                </a> 
                            @endif

                            
                        @else
                            <a data-bs-toggle="modal" data-bs-target="#loginModal">
                                <button class="btn btn-dark btnLarge">Take Test</button>
                            </a>

                        @endauth
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Course Content section -->
    <section class="container courseContentCont mt-5 mb-5">
        <div class="head">
            <p class="title dark">Course Content</p>
            <p class="desc">
                <span>{{ $course->chapters->count() }} Chapters</span>
            @if ($course->test)
                <span class="dot"></span>
                <span>{{ $course->test->chapters->sum('number_of_questions') }} Questions</span>
            @else 
                {{-- <span class="dot"></span>
                <span>0 Questions</span> --}}
            @endif
            </p>
        </div>
        <div class="test-included-outer">
        @foreach ($course->chapters as $chapter)
            <div class="accordion">
                <div class="col-md-6 test-name">
                    <p class="title">{{ $chapter->name }}</p>
                </div>
                @if ($course->test)
                <div class="col-md-4 my-auto test-duration">
                    <p>{{ $course->test->chapters()->whereCourseChapterId($chapter->id)->sum('number_of_questions') }} Questions</p>
                </div>
                @else
                <div class="col-md-4 my-auto test-duration">
                    <p>{{count($chapter->questions)}} Questions</p>
                </div>
                @endif 
                <div class="col-md-2 icon">
                    <i class="fas fa-chevron-down test-chevron"></i>
                </div>               
            </div>
            <div class="panel">
                <div class="row">
                    {!! $chapter->description !!} 
                </div>
            </div>
            
        @endforeach
        </div>
    </section>
    <!-- END: Single Course -->
@endsection

@section('page-scripts')
	<script type="text/javascript">
	    var acc = document.getElementsByClassName("accordion");
	    var i;

	    for (i = 0; i < acc.length; i++) {
	        acc[i].addEventListener("click", function() {
	            /* Toggle between adding and removing the "active" class,
	            to highlight the button that controls the panel */
	            this.classList.toggle("active");

	            /* Toggle between hiding and showing the active panel */
	            var panel = this.nextElementSibling;
	            if (panel.style.display === "block") {
	                panel.style.display = "none";
	            } else {
	                panel.style.display = "block";
	            }
	        });
	    }

        function testQuotaExpired(){
            toastr.info('You have exceeded your total test quota');
        }

        function testValidityExpired(){
            toastr.info('Test Validity Over. Enroll Now Again');
        }
    </script>
@endsection