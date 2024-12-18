@extends('layouts.frontend.app')

@section('title', 'Dashboard')


@section('page-styles')
<style>
   .profileContent .coursesCard:hover {
        background: #fff;
        color: #005EB8;
    } 

    .profileContent .coursesCard:hover>.title {
        color: #005EB8;
    }

    .coursesCard .cardFooter a {
        color: #ffffff;
    }

    .coursesCard .cardFooter a {
        text-decoration: none;
    }
</style>
@append

@section('content')
    <!-- BEGIN: Dashboard -->
    <section class="profile pt-5 pb-5">
        <div class="container profileCont">
            <ul class="leftBar tabs">
                <div class="item">
                    <li class="active" data-tab-id='tab1'>My Profile</li>
                </div>
                <div class="item">
                    <li data-tab-id='tab2'>My Courses</li>
                </div>
                <div class="item">
                    <li data-tab-id='tab3'>My Orders</li>
                </div>
                <div class="item">
                    <li data-tab-id='tab4'>My Practices</li>
                </div>
                <div class="item">
                    <li data-tab-id='tab5'>My Tests</li>
                </div>
                <div class="item">
                    <li>
                        <span
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            style="text-decoration: none;"
                        >
                            Logout
                        </span>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                    </li>
                </div>
            </ul>
            <div class="mainContent">
                <div id='tab1' class='content active'>
                    @include('backend.student.dashboard-partials.profile')
                </div>
                <div id='tab2' class='content'>
                    <div class="profileContent">
                        <div class="head">
                            <p class="title">My Courses</p>
                        </div>
                        <div class="contentInfo">
                        @foreach(request()->user()->courses as $course)
                            <div class="coursesCard">
                                <p class="title">{{ $course->course->name }}</p>
                                <p>
                                	@foreach ($course->course->topics as $topic)
		                        		{{ $topic->name }},
		                        	@endforeach
                                </p>
                                {!! $course->short_description !!}
                                @if (now()->gt($course->end_on))
                                    <div class="cardFooter">
                                        <p>Expired on {{ $course->end_on->format('d/m/Y') }}.</p>
                                    </div>
                                @else
                                    <div class="cardFooter">
                                        <button class="btn">
                                        	<a href="{{ route('practice.test.create', $course->course->slug) }}">
                                        		Practice
                                        	</a>
                                        </button>
                                    @if ($course->course->test && $course->course->number_of_tests)
                                        @if ($left = ($course->course->number_of_tests - request()->user()->userTests()->whereCourseId($course->course->id)->count()))
                                            <button class="btn btnBlue">
                                                <a href="{{ route('user.test.create', $course->course->slug) }}">
                                                    Test ({{ $left }} Left)
                                                </a>
                                            </button>
                                        @else
                                            <button class="btn btnBlue disabled">
                                                0 Left
                                            </button>
                                        @endif
                                    @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div id='tab3' class='content'>
                    <div class="profileContent family">
                        <div class="head">
                            <p class="title">My Orders</p>
                        </div>
                        <div class="contentInfo">
                        @foreach(request()->user()->orders as $order)
                            <div class="orderDetail">
                                <div class="orderCard">
                                    <p class="title">{{ $order->items->first()->course->name }}</p>
                                    <p>
                                    	Date of Purchase: {{ $order->created_at->format('d/m/Y') }}<br>
                                        Valid Till: {{ $order->created_at->addDays($order->items->first()->course_details['valid_for'])->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="price">
                                    <p class="new">₹ {{ $order->items->first()->course->special_price }}</p>
                                    <p class="old">₹ {{ $order->items->first()->course->price }}</p>
                                    <p>
                                    @if ($order->invoice)
                                        <a href="{{ route('invoice.download', encrypt($order->invoice->id)) }}">
                                            <i class="fas fa-download"></i> Invoice    
                                        </a>
                                    @else
                                        Invoice not generated due to failure of payment.
                                    @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                            <div class="orderDetail">
                                {{-- <a href="{{ route('courses') }}" target="_blank"><button class="btn btnBlue">Buy other courses</button></a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div id='tab4' class='content'>
                    <div class="profileContent family">
                        <div class="head">
                            <p class="title">My Practices</p>
                        </div>
                        <div class="contentInfo">
                        @foreach(request()->user()->practiceTests as $practiceTest)
                            <div class="orderDetail">
                                <div class="orderCard">
                                    <p class="title">{{ $practiceTest->course->name }}</p>
                                    <span>{{ $practiceTest->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                                <div class="price">
                                @if ($practiceTest->is_submitted)
                                    <p class="new">
                                        <a href="{{ route('practice.test.result', [$practiceTest->course->slug, encrypt($practiceTest->id)]) }}">
                                            {{ round(($practiceTest->number_of_questions_correct*100)/$practiceTest->number_of_questions, 2) }}%
                                        </a>
                                    </p>
                                    <span>{{ $practiceTest->number_of_questions_correct }}/{{ $practiceTest->number_of_questions }} Correct</span>
                                @else
                                    <p class="new">
                                    	<a href="{{ route('practice.test.show', [$practiceTest->course->slug, encrypt($practiceTest->id)]) }}">Attempt</a>
                                    </p>
                                @endif
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div id='tab5' class='content'>
                    <div class="profileContent family">
                        <div class="head">
                            <p class="title">My Tests</p>
                        </div>
                        <div class="contentInfo">
                        @foreach(request()->user()->userTests as $userTest)
                            <div class="orderDetail">
                                <div class="orderCard">
                                    <p class="title">{{ $userTest->course->name }}</p>
                                    <span>{{ $userTest->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                                <div class="price">
                                @if ($userTest->is_submitted)
                                    <p class="new">
                                        <a href="{{ route('user.test.result', [$userTest->course->slug, encrypt($userTest->id)]) }}">
                                            {{ round(($userTest->number_of_questions_correct*100)/$userTest->number_of_questions, 2) }}%
                                        </a>
                                    </p>
                                    <span>{{ $userTest->number_of_questions_correct }}/{{ $userTest->number_of_questions }} Correct</span>
                                @else
                                    <p class="new">
                                        <a href="{{ route('user.test.show', [$userTest->course->slug, encrypt($userTest->id)]) }}">Attempt</a>
                                    </p>
                                @endif
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Dashboard -->
@endsection

@section('page-scripts')
	<script type="text/javascript">
	    (function() {
	        var d = document,
	            tabs = d.querySelector('.profileCont .tabs'),
	            tab = d.querySelectorAll('.profileCont .tabs .item li'),
	            contents = d.querySelectorAll('.profileCont .mainContent .content');
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