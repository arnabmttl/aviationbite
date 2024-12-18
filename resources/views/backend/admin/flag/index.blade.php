@extends('layouts.backend.app')

@section('title', 'Flagged Questions/Replies')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Flagged Questions/Replies</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Flagged Questions/Replies
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Hoverable rows start -->
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Reported By</th>
                                    <th>Reason</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($flags as $index => $flag)
                                <tr>
                                    <th scope="row">
                                        {{ $index + $flags->firstItem() }}
                                    </th>
                                    <td>
                                        {{ $flag->user->name }}
                                    </td>
                                    <td>
                                        {{ $flag->reason }}
                                    </td>
                                    @if ($flag->flagged)
                                    <td>
                                        <a href="{{ $flag->flagged->path() }}">
                                            <i data-feather="eye" class="mr-50"></i>
                                            <span>View</span>
                                        </a>
                                    </td>
                                    <td>
                                        @if ($flag->flagged->getMorphClass() == 'App\Models\Reply')
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a 
                                                        class="dropdown-item"
                                                        href="#"
                                                        onclick="event.preventDefault();document.getElementById('reply-delete-form-'+{{ $flag->flagged->id }}).submit();"
                                                    >
                                                        <i data-feather="trash" class="mr-50"></i>
                                                        <span>Delete</span>
                                                    </a>
                                                    <form id="reply-delete-form-{{ $flag->flagged->id }}" action="{{ route('reply.destroy', $flag->flagged->id) }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="delete" />
                                                    </form>
                                                </div>
                                            </div>
                                        @elseif ($flag->flagged->getMorphClass() == 'App\Models\Thread')
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a 
                                                        class="dropdown-item"
                                                        href="#"
                                                        onclick="event.preventDefault();document.getElementById('thread-delete-form-'+{{ $flag->flagged->id }}).submit();"
                                                    >
                                                        <i data-feather="trash" class="mr-50"></i>
                                                        <span>Delete</span>
                                                    </a>
                                                    <form id="thread-delete-form-{{ $flag->flagged->id }}" action="{{ route('thread.destroy', [$flag->flagged->channel->slug, $flag->flagged->id]) }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="delete" />
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    @else
                                    <td colspan="2">
                                        Question/Reply no more exists.
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hoverable rows end -->
        {{ $flags->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection