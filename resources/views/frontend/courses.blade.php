@extends('layouts.frontend.app')

@section('title', 'Courses')

@section('content')
    <!-- BEGIN: Courses -->
    <!-- Courses section -->
    <section class="about courses mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="aboutText">
                        <p class="title">Our Courses</p>
                        <p class="desc">Welcome to AVIATIONBITE, here we offer a comprehensive course specially designed for the pilot examination. Our course is tailored to provide students with a supportive learning environment and a comprehensive test series to excel in their career as a commercial pilot. With a focus on practice questions and extensive learning resources, we are committed to helping students achieve their aviation goals.</p>
                        <p class="desc">Key Features:</p>
                        <ul>
                            <li>Up-to-Date Database: Our course includes an up-to-date database ensuring that students have access to the latest information.</li>
                            <li>Comprehensive Exam Coverage: Our course covers all aspects of the CPL syllabus, including on-demand examinations and regular examinations.</li>
                            <li>Collaborative Learning: Our platform offers self-paced practice and collaborative learning through comments, facilitating the sharing of experiences and knowledge among users.</li>
                            <li>Previously Asked Questions: Our course covers previously asked questions, providing students with an understanding of the types of questions that have appeared on the exam in the past.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="aboutImg">
                        <img src="{{ asset('frontend/images/courses-img.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial section starts-->
    <section class="testimonial coursesAbout p-5 mt-5">
        <div class="container">
            <p class="desc" style="font-size: 26px;">Elevate your pilot training with AviationBite</p>
        </div>
    </section>
    <!-- Testimonial section ends -->
    <!-- Popular Courses -->
    <section class="popCourses mt-5">
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
            @foreach ($courses as $course)
                <div class="item">
                    <div class="coursesCard">
                        <p class="title">{{ $course->name }}</p>
                        <p>
                            @foreach ($course->topics as $topic)
                                {{ $topic->name }}, 
                            @endforeach
                        </p>
                        {!! $course->short_description !!}
                        <div class="cardFooter">
                        @if ($course->special_price != $course->price)
                            <button class="btn"><s>₹ {{ $course->price }}</s>  ₹ {{ $course->special_price }}</button>
                        @else
                            <button class="btn">₹ {{ $course->price }}</button>
                        @endif
                            <a href="{{ route('single.course', $course->slug) }}">Course</a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>
    <section class="faqs mt-5 mb-5">
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
    </section>
    <!-- END: Courses -->
@endsection