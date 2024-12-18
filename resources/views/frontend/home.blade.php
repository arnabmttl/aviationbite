@extends('layouts.frontend.app')

@section('title', 'Home Page')

@section('content')
    <!-- BEGIN: HOME BANNER -->
    <section class="homeBanner">
        <div class="homeBannerSlider owl-carousel owl-theme">
            @forelse ($banners as $banner)
                
            <div class="item">
                <div class="banner1-bg" style="background-image: url({{ $banner->image }});">
                    <div class="container ">
                        <div class="bannerCont">
                            <p class="bigTitle">{{$banner->title}} </p>
                            <p class="desc">{{$banner->description}}</p>
                        </div>
                    </div>
                </div>
            </div>            
            @empty
                
            @endforelse
        </div>
    </section>
    <!-- END: HOME BANNER -->

    <!-- BEGIN: About Us -->
    <section class="about mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="aboutImg">
                        <img src="{{ asset('frontend/images/about-us.png') }}">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="aboutText">
                        <p class="title">About Us</p>
                        <p class="desc">{{$aboutUs->meta_title}}</p>
                        <ul>
                            <li class="mb-2">{{$aboutUs->meta_description}}</li>
                            {{-- <li class="mb-2">Provide insight into recent world events .</li>
                            <li class="mb-2">The most experienced pilots design our personalised course to make you feel confident & ready for the big day.</li>
                            <li class="mb-2">Our comprehensive test series helps you evaluate aviation knowledge.</li>
                            <li class="mb-2">As we believe in the five P’s Prior preparations prevent poor performance. </li> --}}
                        </ul>
                        <a class="btn btnBlue" href="{{ url('/about-us') }}">Know More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: About Us -->

    <!-- BEGIN: Key Benefits -->
    <section class="keyBenefits mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="prec-bef-test">
                        <h5>Some Of Our Key Benefits</h5>
                    </div>
                </div>
            </div>
            <div class="row precautionCont">
                <div class="col-lg-4 abt-caution">
                    <div class="icon">
                        <img src="{{ asset('frontend/images/lms.png') }}">
                    </div>
                    <p class="title">LMS</p>
                    <p class="desc">An advanced learning management system</p>
                </div>
                <div class="col-lg-4 abt-caution">
                    <div class="icon">
                        <img src="{{ asset('frontend/images/coverage.png') }}">
                    </div>
                    <p class="title">Wide coverage</p>
                    <p class="desc">Updated aviation question bank.</p>
                </div>
                <div class="col-lg-4 abt-caution">
                    <div class="icon">
                        <img src="{{ asset('frontend/images/cloud.png') }}">
                    </div>
                    <p class="title">Forum</p>
                    <p class="desc">where everyone can help anyone.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Key Benefits -->

    <!-- BEGIN: Popular Courses xxxxxxxxx-->
    <section class="popCourses mt-5 d-none">
        <div class="container">
            <div class="head mb-5">
                <div class="title">
                    <p>Popular Courses</p>
                </div>
                <div class="desc">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                </div>
            </div>
            <div class="popCoursesContent popCoursesSlider  owl-carousel owl-theme">
                <div class="item">
                    <div class="coursesCard">
                        <p class="title">Air Traffic Control</p>
                        <p>ATC</p>
                        <p>Lorem Lipsum </p>
                        <ul>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                        </ul>
                        <div class="cardFooter">
                            <button class="btn">₹ 599</button>
                            <a href="">Course</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="coursesCard">
                        <p class="title">Air Traffic Control</p>
                        <p>ATC</p>
                        <p>Lorem Lipsum </p>
                        <ul>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                        </ul>
                        <div class="cardFooter">
                            <button class="btn">₹ 599</button>
                            <a href="">Course</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="coursesCard">
                        <p class="title">Air Traffic Control</p>
                        <p>ATC</p>
                        <p>Lorem Lipsum </p>
                        <ul>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                        </ul>
                        <div class="cardFooter">
                            <button class="btn">₹ 599</button>
                            <a href="">Course</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="coursesCard">
                        <p class="title">Air Traffic Control</p>
                        <p>ATC</p>
                        <p>Lorem Lipsum </p>
                        <ul>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                        </ul>
                        <div class="cardFooter">
                            <button class="btn">₹ 599</button>
                            <a href="">Course</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="coursesCard">
                        <p class="title">Air Traffic Control</p>
                        <p>ATC</p>
                        <p>Lorem Lipsum </p>
                        <ul>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                        </ul>
                        <div class="cardFooter">
                            <button class="btn">₹ 599</button>
                            <a href="">Course</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="coursesCard">
                        <p class="title">Air Traffic Control</p>
                        <p>ATC</p>
                        <p>Lorem Lipsum </p>
                        <ul>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                            <li>Lorem Lipsum is the dummy text</li>
                        </ul>
                        <div class="cardFooter">
                            <button class="btn">₹ 599</button>
                            <a href="">Course</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Popular Courses -->

    <!-- BEGIN: Test Series section -->
    <section class="about testSeries mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="aboutText">
                        <p class="title">Test Series</p>
                        <p class="desc">Learn anytime anywhere</p>
                        <p class="text"><b>Go Beyond the Classroom:</b> Enhance your learning with our mock tests, detailed explanations, and practice exams.</p>
                        <ul>
                            <li>Practice & review</li>
                            <li>Interactive session</li>
                            <li>Updated question bank</li>
                            <li>Support all devices</li>
                            <li>User-friendly interface.</li>
                        </ul>
                        <button class="btn btnBlue">Know More</button>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="aboutImg">
                        <img src="{{ asset('frontend/images/test-series.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Test Series section -->

    <!-- BEGIN: Our Forums -->
    <section class="forums my-5">
        <div class="container">
            <div class="head">
                <div class="title">
                    <p>Aviation Forum</p>
                </div>
                <div class="desc">
                    A platform dedicated to aviators 
                </div>
            </div>
            <div class="forumContent mt-5">
                <div class="forumCard">
                    <div>
                        <p class="cardNumber">#1</p>
                    </div>
                    <div>
                        <p class="cardTitle">What is Lorem Lpsum?</p>
                        <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                        <div class="cardFooter">
                            <div class="left">
                                <p>Posted 21 june 2021 by XYZ</p>
                                <p>Last Updated 12:20 22 june 2021</p>
                            </div>
                            <div class="right
                                ">
                                <p>25<br><span>Reply</span></p>
                                <p>2.5k<br><span>Views</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="forumCard">
                    <div>
                        <p class="cardNumber">#1</p>
                    </div>
                    <div>
                        <p class="cardTitle">What is Lorem Lpsum?</p>
                        <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                        <div class="cardFooter">
                            <div class="left">
                                <p>Posted 21 june 2021 by XYZ</p>
                                <p>Last Updated 12:20 22 june 2021</p>
                            </div>
                            <div class="right
                                ">
                                <p>25<br><span>Reply</span></p>
                                <p>2.5k<br><span>Views</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="forumCard">
                    <div>
                        <p class="cardNumber">#1</p>
                    </div>
                    <div>
                        <p class="cardTitle">What is Lorem Lpsum?</p>
                        <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                        <div class="cardFooter">
                            <div class="left">
                                <p>Posted 21 june 2021 by XYZ</p>
                                <p>Last Updated 12:20 22 june 2021</p>
                            </div>
                            <div class="right
                                ">
                                <p>25<br><span>Reply</span></p>
                                <p>2.5k<br><span>Views</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="forumCard">
                    <div>
                        <p class="cardNumber">#1</p>
                    </div>
                    <div>
                        <p class="cardTitle">What is Lorem Lpsum?</p>
                        <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                        <div class="cardFooter">
                            <div class="left">
                                <p>Posted 21 june 2021 by XYZ</p>
                                <p>Last Updated 12:20 22 june 2021</p>
                            </div>
                            <div class="right
                                ">
                                <p>25<br><span>Reply</span></p>
                                <p>2.5k<br><span>Views</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="forumCard">
                    <div>
                        <p class="cardNumber">#1</p>
                    </div>
                    <div>
                        <p class="cardTitle">What is Lorem Lpsum?</p>
                        <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                        <div class="cardFooter">
                            <div class="left">
                                <p>Posted 21 june 2021 by XYZ</p>
                                <p>Last Updated 12:20 22 june 2021</p>
                            </div>
                            <div class="right
                                ">
                                <p>25<br><span>Reply</span></p>
                                <p>2.5k<br><span>Views</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="forumCard">
                    <div>
                        <p class="cardNumber">#1</p>
                    </div>
                    <div>
                        <p class="cardTitle">What is Lorem Lpsum?</p>
                        <p class="cardText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            dummy text of the printing and and typesetting industry. Lorem Ipsum is...<a class="readMoreBtn" href="">Read More</a></p>
                        <div class="cardFooter">
                            <div class="left">
                                <p>Posted 21 june 2021 by XYZ</p>
                                <p>Last Updated 12:20 22 june 2021</p>
                            </div>
                            <div class="right
                                ">
                                <p>25<br><span>Reply</span></p>
                                <p>2.5k<br><span>Views</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="" class="viewAllBtn">All Forums <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
    </section>
    <!-- END: Our Forums -->

    <!-- BEGIN: FAQ Section -->
    {{-- <section class="faqs mt-5 mb-5">
        <div class="container">
            <div class="head mb-5">
                <div class="title">
                    <p>FAQS</p>
                </div>
            </div>
            <div class="accordion tabOneContent" id="tabOneContent">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false">
                            How can I access AVIATIONbite's online pilot training service?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            To access our online pilot training service, simply visit our website and create an account. Once you have registered, you can log in and access all of our course materials.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false">
                            What is included in AVIATIONbite's online pilot training service?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            Our online pilot training service includes a comprehensive test series designed to prepare you for all aspects of the DGCA India Exam. We also provide personalized learning experiences, extensive practice questions, and a supportive learning environment.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            How much does AVIATIONbite's online pilot training service cost?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            The cost of our online pilot training service varies depending on the specific course package you choose. Please visit our website for more information on pricing.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                            Are the practice questions in AVIATIONbite's test series updated regularly?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Yes, we are committed to providing up-to-date practice questions to ensure that our students are fully prepared for the DGCA India Exam.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                            How long do I have access to AVIATIONbite's online pilot training service?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Depending on the specific course package you choose, you may have access to our online pilot training service for a set period of time. Please refer to our website for more information on course durations.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                            What if I have questions or need additional support while using AVIATIONbite's online pilot training service?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Our platform includes a forum where you can ask questions and receive support from our experienced instructors and other students. Additionally, you can contact our customer support team for assistance at any time.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End: FAQ Section -->

    <!-- BEGIN: Testimonial section -->
    <section class="testimonial p-5">
        <div class="container">
            <p class="title">Many satisfied users worldwide</p>
            <!-- <p class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever </p> -->
        </div>
    </section>
    <!-- END: Testimonial section -->
@endsection