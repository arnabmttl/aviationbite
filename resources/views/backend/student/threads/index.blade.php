@extends('layouts.frontend.app')

@section('title', 'Forum')

@section('content')
<?php
$fileUrl = asset('frontend/images/about-us.png');
?>
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
    <!-- BEGIN: Forum -->
   <section class="forumCont faqsTabsCont pt-5 pb-5 bg-white">



        <div id="cbz-thread-index" class="container">
            <div class="row">
                <div class="col-12 hide-d">
                     {{-- <form class="searchForm">
                        <i class="fas fa-search"></i>
                        <input type="search" name="search" placeholder="Search Topics">
                    </form> --}}
                    <form method="POST" action="{{ route('threads.search') }}" class="searchForm">
                        @csrf
                        <i class="fas fa-search"></i>
                        <input type="search" name="search" placeholder="Search Topics">
                    </form>

                    <div class="ask">
                         <button> <i class="fas fa-plus"></i> Ask A Question </button> </a>

                    </div>
                </div>
                <div class="col-md-8 col-12">
                    @if ($channel->exists)
                        <p class="title">{{ $channel->name }} </p>
                        <nav>
                            <ul class='tabs tabsSlider owl-carousel owl-theme'>
                                <div class="item">
                                    <li class="{{ request()->has('popular') || request()->has('subscribed') ? '' : 'active' }}" data-tab-id='tab1'> <a href="{{ route('threads.index') }}">All Topics</a></li>
                                </div>
                                @if (auth()->check())
                                <div class="item">
                                    <li class="{{ request()->has('subscribed') ? 'active' : '' }}" data-tab-id='tab2'><a href="{{ route('thread.channel.index', $channel->slug) . '?subscribed=1' }}">Subscribed</a></li>
                                </div>
                                @endif
                                <div class="item">
                                    <li class="{{ request()->has('popular') ? 'active' : '' }}" data-tab-id='tab3'> <a href="{{ route('thread.channel.index', $channel->slug) . '?popular=1' }}">Trending </a></li>
                                </div>
                            </ul>
                        </nav>
                    @else
                        @if ($search)
                            <p class="title">Search results for "{{ $search }}"</p>
                        @else
                            <p class="title">Aviation Forums</p>
                        @endif
                        <nav>
                            <ul class='tabs tabsSlider owl-carousel owl-theme'>
                                <div class="item">
                                    <li class="{{ request()->has('popular') || request()->has('subscribed') ? '' : 'active' }}" data-tab-id='tab1'> <a href="{{ route('threads.index', '')}}">All Topics</a></li>
                                </div>
                                @if (auth()->check())
                                <div class="item">
                                    <li class="{{ request()->has('subscribed') ? 'active' : '' }}" data-tab-id='tab2'><a href="{{ route('threads.index').'?subscribed=1' }}">Subscribed</a></li>
                                </div>
                                @endif
                                <div class="item">
                                    <li class="{{ request()->has('popular') ? 'active' : '' }}" data-tab-id='tab3'> <a href="{{ route('threads.index').'?popular=1' }}">Trending </a></li>
                                </div>
                            </ul>
                        </nav>
                    @endif
                    <div class="">
                        <div class='content-section'>
                            <div id='tab1' class='content active'>
                                <div class="forumCardCont">
                                    @forelse ($threads as $index => $thread)
                                        <div class="forumCard">
                                            <div>
                                                <p class="cardNumber highlight">#{{ $index + $threads->firstItem()  }}</p>
                                            </div>
                                            <div>
                                                <article>
                                                    <h4>
                                                        <a href="{{ $thread->path() }}">
                                                            {{ $thread->title }}
                                                        </a>
                                                    </h4>
                                                    <p class="cardText">
                                                    @if (strlen($thread->body) > 120)
                                                        {{ substr($thread->body, 0, 120) }}<a class="readMoreBtn" href="{{ $thread->path() }}">Read More</a>
                                                    @else
                                                        {{ $thread->body }}
                                                    @endif
                                                    </p>
                                                </article>
                                                <div class="cardFooter">
                                                    <div class="left">
                                                        <i class="far fa-user-circle"></i>
                                                        <p>Posted at {{ $thread->created_at }} by
                                                        <a href="#"> {{ $thread->creator->username }} </a> </p>
                                                    </div>
                                                    <div class="right">
                                                    @auth
                                                        <img data-bs-toggle="modal" data-bs-target="#qFlaggingModal{{$thread->id}}" src="{{ asset('frontend/images/flag.svg') }}">
                                                        <!-- Question Flagging Modal -->
                                                        <div class="modal fade" id="qFlaggingModal{{$thread->id}}" tabindex="-1" aria-labelledby="qFlaggingModal{{$thread->id}}Label" aria-hidden="true">
                                                          <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content" style="padding: 25px;text-align: left;">
                                                                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                                                    <div>
                                                                        <div>
                                                                            <p class="title">Report a reply.</p>
                                                                            <p class="desc">Write your reason for reporting (max. 255 characters)</p>
                                                                        </div>
                                                                        <div>
                                                                            <div class="col-12 form-group">
                                                                                <textarea class="form-control" v-model="reasonForReporting"></textarea>
                                                                            </div>
                                                                            <div class="col-12 form-group">
                                                                                <button class="form-control" v-on:click="reportQuestion({{ $thread->id }})">Report</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                    @endauth

                                                        <p>{{ $thread->replies->count() }}<br><span><a href="{{ $thread->path() }}">{{ Str::plural('Reply' , $thread->replies->count()) }}</span></a></p>
                                                        <p>{{ $thread->views }}<br><span>Views</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="forumCard">
                                            There are no relevant results at this time.
                                        </div>
                                    @endforelse
                                </div>
                                {{ $threads->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
                @include ('backend.student.threads.partial.side-bar')
            </div>
        </div>
    </section>
    <!-- END: Forum -->
@endsection

@section('page-scripts')
    <script>
        new Vue({
            el: '#cbz-thread-index',

            data: {
                reasonForReporting: null
            },

            methods: {
                /**
                 * Function to report the question.
                 */
                reportQuestion(id) {
                    axios.post('{{env('APP_URL')}}forum/threads/' + id + '/flags', {
                        reason: this.reasonForReporting
                    });

                    this.reasonForReporting = null;
                    $('#qFlaggingModal'+id).modal('toggle');
                },
            }
        });
    </script>
@endsection