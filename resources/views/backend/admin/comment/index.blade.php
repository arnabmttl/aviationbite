@extends('layouts.backend.app')

@section('title', 'Reported Comments')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Reported Comments</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Reported Comments (during practice test)
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
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Comment</th>
                                    <th>Reported By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $index => $item)
                                <tr>
                                    <th scope="row">
                                        {{ $index + $data->firstItem() }}
                                    </th>
                                    <td>
                                        <strong>{{$item->question->question_id}}</strong>:{{$item->question->title}}
                                    </td>
                                    <td>
                                        {{ $item->comment }}
                                    </td>
                                    <td>
                                        {{ $item->reported->username }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                               
                                            
                                                <a 
                                                    class="dropdown-item"
                                                    href="{{ route('comment.destroy', $item->id) }}"
                                                    onclick="event.preventDefault();document.getElementById('comment-delete-form-'+{{ $item->id }}).submit();"
                                                >
                                                    <i data-feather="trash" class="mr-50"></i>
                                                    <span>Delete</span>
                                                </a>
                                                <form id="comment-delete-form-{{ $item->id }}" action="{{ route('comment.destroy', $item->id) }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="delete" />
                                                </form>
                                            
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hoverable rows end -->
    </div>
</div>
@endsection