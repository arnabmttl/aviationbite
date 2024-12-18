@extends('layouts.frontend.app')

@section('title', 'Forum')

@section('content')
<!-- BEGIN: Show -->
    <div class="container">
        <div class="page-header">
            <h1>
                {{ $profileUser->name }}
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h1>
        </div>

        <!-- User Threads -->
        @foreach($threads as $thread)
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
                            <a href="#"> {{ $thread->creator->username }} </a>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $threads->links('pagination::bootstrap-4') }}

        <!-- User Activities -->
        @foreach ($activities as $date => $activity)
            <p class="title">{{ $date }}</p>
            @foreach ($activity as $record)
                @if (view()->exists("backend.student.profiles.activities.$record->type"))
                    @include ("backend.student.profiles.activities.$record->type", ['activity' => $record])
                @endif
            @endforeach
        @endforeach
    </div>
 <!-- END: Show -->
@endsection
