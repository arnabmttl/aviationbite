@extends('layouts.backend.app')

@section('title', $course->name.' Chapters')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">{{ $course->name }} Chapters</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('course.index') }}">
                                    Courses
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ $course->name }} Chapters
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrumb-right">
                <div class="dropdown">
                    <a href="{{ route('chapter.create', $course) }}">
                        <button class="btn btn-primary" type="button">
                            <i data-feather="plus"></i>
                            Add Chapter
                        </button>
                    </a>
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
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Preview</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($course->chapters as $index => $chapter)
                                <tr>
                                    <th scope="row">
                                        {{ $index + 1 }}
                                    </th>
                                    <td>
                                        {{ $chapter->name }}
                                    </td>
                                    <td>
                                        {{ $chapter->description }}
                                    </td>
                                    <td>
                                        {{ $chapter->is_preview ? 'Yes' : 'No' }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('chapter.edit', [$course->id, $chapter->id]) }}">
                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <a class="dropdown-item" href="{{ route('content.index', [$course->id, $chapter->id]) }}">
                                                    <i data-feather="eye" class="mr-50"></i>
                                                    <span>Show</span>
                                                </a>
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