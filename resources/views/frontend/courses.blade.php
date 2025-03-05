@extends('layouts.frontend.app')
@section('title', 'Courses')
@section('content')
    <!-- BEGIN: Courses -->
    <!-- Courses section -->
    <section class="about testSeries mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="aboutText">
                        <p class="title">Courses</p>
                        <div class="coursemain">
    <h2>Courses</h2>
    <h4>Comprehensive courses designed to elevate your aviation career. </h4> 
    <p>Experience seamless preparation for your aviation exams with our advanced online test platform. Designed specifically for pilots, our platform offers realistic, exam-style questions that simulate actual testing conditions. With 24/7 access, you can study at your own pace, track your progress, and identify areas for improvement . Whether you're preparing for licensing exams or enhancing your aviation knowledge, our online tests provide a reliable and effective way to ensure you're ready to soar to success.</p>

    <ul>
        <li>Expert-Led Instruction</li>
        <li>Interactive Learning Materials </li>
        <li>Mock Exams with Times Assessments</li>
        <li>Community Discussions and Q&A</li>
    </ul>
</div>

<style>
section.about.testSeries.mt-5 {
    margin-top: 0  !important;
    padding: 60px 0;
}
section.about.testSeries.mt-5 .aboutImg img {
    border-radius: 12px;
}
section.about.testSeries.mt-5 .aboutText .title, section.about.testSeries.mt-5 .aboutText a{
    display: none;
}
.coursemain h2 {
    font-size: 80px;
    color: #005eb8;
    font-weight: 600;
}
.coursemain h4 {
    color: #000;
    font-weight: 600;
    margin-bottom: 15px;
}
.coursemain p {
    color: #000;
    font-weight: 500;
}
.coursemain ul li {
    color: #000;
    font-weight: 500;
    font-size: 13px;
}

@media(max-width: 767px) {
.coursemain h2 {
    font-size: 40px;
}
section.about.testSeries.mt-5 {
    margin-top: 0  !important;
    padding: 20px 0;
}
}
</style>
                        
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
    <section class="testimonial coursesAbout p-5">
        <div class="container">
            <p class="desc" style="font-size: 26px;">Elevate your pilot training with AviationBite</p>
        </div>
    </section> 
    <!-- Testimonial section ends -->
    <!-- Popular Courses -->
    @forelse ($types as $type)    
    <section class="popCourses mt-5">
        <div class="container">
            <div class="head mb-5">
                <div class="title">
                    <p>{{$type->name}}</p>
                </div>
            </div>
            <div class="popCoursesContent popCoursesSlider  owl-carousel owl-theme">
            @foreach ($type->courses as $course)
                <div class="item">
                    <a href="{{ route('single.course', $course->slug) }}">
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
                            <span>View Course</span>
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
    </section>
    @empty
        
    @endforelse

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
                            What is Aviationbite.com?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            Aviationbite.com is an online platform designed to assist aspiring airline transport pilots (ATPL) in their exam preparation. It offers an extensive range of practice questions and study materials tailored to help candidates effectively prepare for the ATPL exams and Aviationbite.com also offers a dedicated forum where users can engage in aviation-related discussions.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false">
                            Are the practice questions on Aviationbite.com similar to the actual ATPL exams?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            Yes, the questions on Aviationbite.com are designed to closely replicate the format and difficulty level of the real ATPL exams. They help users become familiar with the types of questions they will face and provide a solid understanding of the subjects covered.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            Can I track my progress on Aviationbite.com?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Yes, Aviationbite.com provides tools to track your performance. You can monitor your scores, pinpoint areas that need improvement, and evaluate your readiness for the exams.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                            Are the study materials regularly updated?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Yes, Aviationbite.com ensures that its study resources are up-to-date. The question bank and materials are consistently reviewed and updated to reflect any changes in aviation regulations or exam guidelines.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                            Can I access Aviationbite.com offline?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Aviationbite.com is primarily an online platform requiring an internet connection. However, some features, such as downloading study materials for offline use, may be available. Refer to the platform’s instructions for more details on offline capabilities.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                            Can I modify or cancel my subscription?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Aviationbite.com has a no-refund policy for purchased subscriptions. Modifications to subscriptions may only be possible under specific circumstances, so it is advised to contact their support team for further assistance with your subscription-related queries.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                            What payment methods are available for subscriptions?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Aviationbite.com accepts various payment methods, including major credit and debit cards, as well as online payment platforms. The exact payment options will be outlined during the subscription process.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                            Is Aviationbite.com affiliated with any official aviation regulatory bodies?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Aviationbite.com operates independently and is not directly affiliated with official aviation regulatory authorities. However, it ensures that its study materials are aligned with the standards and requirements set by relevant aviation agencies.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                            Can I engage with other users through a community or forum?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Aviationbite.com also offers a dedicated forum where users can engage in aviation-related discussions. This forum is a great space to connect with fellow pilots, share insights, ask questions, and discuss various topics related to aviation. Whether you're looking for study tips or just want to dive into an aviation conversation, the forum provides a valuable platform for collaboration and learning.
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!-- END: Courses -->
@endsection