@extends('layouts.frontend.app')

@section('title', 'Show Thread')

@section('content')

<style>
    .forumHead .buttons button {
        margin: 0;
    }
    .share_btn {
        display: inline-block;
        position: relative;
    }
    .share_btn_icon {
        display: flex;
        padding: 6px;
        align-items: center;
        justify-content: center;
    }
    .share_btn .a2a_default_style {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 80px;
    }
    .share_btn .a2a_default_style.active {
        display: flex;
        gap: 5px;
    }
    .answerForum .forumHead .cardFooter {
        margin-bottom: 15px;
    }
    .copy-link {
        max-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 100%;
    }
</style>
    <!-- BEGIN: Show -->
    <section id="cbz-thread-show" class="forumCont answerForum faqsTabsCont pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 hide-d">
                    <form class="searchForm">
                        <i class="fas fa-search"></i>
                        <input type="search" name="search" placeholder="Search Topics">
                    </form>
                    <div class="ask">
                        <button><i class="fas fa-plus"></i> Ask A Question </button>
                    </div>
                </div>
                <div class="col-md-8 col-12 main">
                    <div class="dropdown" style="display: none;">
                        <a class="btn btn-secondary dropdown-toggle" href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Browse </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a href="{{ route('threads.index', '')}}">All Threads </a> </li>
                            @if(auth()->check())
                                <li><a href="{{asset('/forum?by=' . auth()->user()->name ) }}">My Threads</a> </li>
                            @endif
                        </ul>
                    </div>


                    <div class="dropdown" style="display: none;">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        All Channels </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach ($channels as $channel)
                                <li> <a class="dropdown-item" href=" {{ asset('/threads/' . $channel->slug ) }}">{{ $channel->name }}</a> </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="forumHead">
                        <div class="row">
                            <div class="col-10">
                                <p class="title">{{ $thread->title }}</p>
                            </div>
                        @can ('update', $thread)
                            <div class="col-2">
                                <a 
                                    href="{{ route('thread.destroy', [$thread->channel->slug, $thread->id]) }}"
                                    onclick="event.preventDefault();document.getElementById('thread-delete-form-'+{{ $thread->id }}).submit();"
                                >
                                    <i data-feather="trash" class="mr-50"></i>
                                    <span>Delete</span>
                                </a>
                                <form id="thread-delete-form-{{ $thread->id }}" action="{{ route('thread.destroy', [$thread->channel->slug, $thread->id]) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete" />
                                </form>
                            </div>
                        @endcan
                        </div>
                        <p class="content-body">{{ $thread->body }}</p>
                        <div class="cardFooter">
                            <div class="left">
                                <p>Posted at {{ $thread->created_at }} by
                                    <a href="#"> {{ $thread->creator->username }} </a> </p>
                            </div>
                            <div class="right">
                                <p>{{ $thread->replies->count() }}<br><span>{{ Str::plural('Reply' , $thread->replies->count()) }}</span></p>
                                <p>{{ $thread->views }}<br><span>Views</span></p>
                            </div>
                        </div>
                        <div class="buttons">
                        @auth
                            @if ($thread->is_subscribed_to)
                                {!! 
                                    Form::open([
                                        'method' => 'Delete', 
                                        'action' => ['App\Http\Controllers\Backend\ThreadSubscriptionsController@destroy', $thread->channel->slug, $thread->id], 
                                        'class' => 'form'
                                    ])
                                !!}
                                    <button type="submit"><i class="fas fa-bell"></i> Unsubscribe</button>
                                    
                                    {{-- <a href="javascript:void(0)" class="btn btn-primary copy-link" >Copy Link</a> --}}
                                {{ Form::close() }}
                            @else
                                {!! 
                                    Form::open([
                                        'method' => 'Post', 
                                        'action' => ['App\Http\Controllers\Backend\ThreadSubscriptionsController@store', $thread->channel->slug, $thread->id], 
                                        'class' => 'form'
                                    ])
                                !!}
                                    <button><i class="fas fa-bell"></i> Subscribe</button>
                                    
                                    {{-- <a href="javascript:void(0)" class="btn btn-primary copy-link" >Copy Link</a> --}}
                                {{ Form::close() }}
                            @endif
                        @else
                            <a href="" data-bs-toggle="modal" data-bs-target="#loginModal"><button><i class="fas fa-bell"></i> Subscribe</button></a>                            
                            
                        @endauth
                            <div class="share_btn">
                                <a href="javascript:void(0)" class="share_btn_icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg></a>
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                    <a href="javascript:void(0)" class="btn btn-primary copy-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></a>
                                    <div id="messageCopyLink"></div>
                                    <!-- <a class="a2a_button_email"></a> -->
                                    <!-- <a class="a2a_button_facebook"></a> -->
                                    <!-- <a class="a2a_button_sms"></a> -->
                                    <a class="a2a_button_whatsapp"></a>
                                    <!-- <a class="a2a_button_x"></a> -->
                                </div>
                            </div>
                            
                        </div>
                        
                        
                    </div>

                    <div class="item">
                        @foreach ($replies as $reply)
                            @include ('backend.student.threads.reply')
                        @endforeach

                        {{ $replies->links() }}
                    </div>

                    @if(Auth::check())
                    <div class="" style="padding-top: 25px;">
                        <div class='content-section'>
                            <div class="forumCardCont">
                                <form method="POST" action="{{ $thread->path() . '/replies' }}">
                                    @csrf
                                    <div class="form-group" >
                                        <textarea name="body" id="body" placeholder="Have something to say?" class="form-control" rows="5"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="margin-top: 25px; margin-bottom: 25px;">Reply</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                        <p>Please <a href="" data-bs-toggle="modal" data-bs-target="#loginModal"> Sign In </a> to participate in this discussion.</p>
                    @endif
                </div>
                @include ('backend.student.threads.partial.side-bar')
            </div>
        </div>
    </section>
    <!-- END: Show -->
@endsection

@section('page-scripts')   
    @if ($replies->count())
        @include('layouts.frontend.partial.vue.templates.reply')
    @endif

    <script>
        new Vue({
            el: '#cbz-thread-show',
        });

        
    </script>

    <script>
        var a2a_config = a2a_config || {};
        a2a_config.templates = a2a_config.templates || {};

        var title = "{{$thread->title}}";
        var link = "{{route('thread.show',[$channelId,$thread->id])}}";

        $(document).ready(function(){
            
        });
        $('.copy-link').click(function() {
            
            navigator.clipboard.writeText(link).then(function() {
                // alert('Link copied to clipboard!');
                var message = $('<span>Link copied!</span>'); // Create a new <span> element with a message
                $('#messageCopyLink').append(message);

                // Make the message disappear after 3 seconds (3000 ms)
                setTimeout(function() {
                    message.fadeOut(function() {
                        $(this).remove(); // Remove the element from the DOM after fade out
                    });
                }, 3000);
            }).catch(function(err) {
                // alert('Failed to copy the link: ' + err);
            });
        });
        
        a2a_config.templates.email = {
            subject: "Check this out: "+title,
            body: "Click the link:\n"+link,
        };
        
        a2a_config.templates.facebook = {
            app_id: "5303202981",
            redirect_uri: "https://static.addtoany.com/menu/thanks.html",
        };
        
        a2a_config.templates.sms = {
            body: "Check this out: "+title+" "+link,
        };
        
        a2a_config.templates.whatsapp = {
            //phone: "15551234567",
            text: "I'm interested in "+title+" posted here: "+link,
        };
        
        a2a_config.templates.x = {
            text: "Reading: "+title+" "+link,
        };
    </script>

    <script>
        $('.share_btn_icon').click(function() {
            $('.a2a_default_style').toggleClass('active');
        });
    </script>
    
    <script defer src="https://static.addtoany.com/menu/page.js"></script>
@endsection