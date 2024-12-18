@extends('layouts.backend.app')

@section('title', 'Edit Chapter')

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/summernote.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Chapter</h2>
                    <div class="breadcrumb-wrapper col-12">
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('chapter.index',$course->id) }}">
                                    {{ $chapter->name }} Chapters
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Chapter
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="input-file-browser">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! 
                                            Form::model($chapter,[
                                                'method' => 'Patch', 
                                                'action' => ['App\Http\Controllers\Backend\CourseChaptersController@update',$course->id, $chapter->id], 
                                                'class' => 'form',
                                                'files' => true
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Chapter Details</div>
                                                    </div>

                                                    <!-- Name -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'name',
                                                                null,
                                                                [
                                                                    'id' => 'name',
                                                                    'class' => 'form-control '.($errors->has('name') ? 'is-invalid':''),
                                                                    'placeholder' => 'Name',
                                                                    
                                                                    'aria-describedby' => 'name',
                                                                    'tabindex' => '1'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('name', 'Name') !!}

                                                        @error('name')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Is Preview -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'is_preview',
                                                                [
                                                                    0 => 'No',
                                                                    1 => 'Yes'
                                                                ],
                                                                0,
                                                                [
                                                                    'id' => 'is_preview',
                                                                    'class' => 'form-control '.($errors->has('is_preview') ? 'is-invalid':''),
                                                                    'placeholder' => 'Is Preview',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'is_preview',
                                                                    'tabindex' => '2'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('is_preview', 'Is Preview') !!}

                                                        @error('is_preview')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Description</div>
                                                    </div>

                                                    <!-- Description -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::textarea(
                                                                'description',
                                                                null,
                                                                [
                                                                    'id' => 'description',
                                                                    'class' => 'form-control '.($errors->has('description') ? 'is-invalid':''),
                                                                    'placeholder' => 'Description',
                                                                    
                                                                    'aria-describedby' => 'description',
                                                                    'tabindex' => '3'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('description', 'Description') !!}

                                                        @error('description')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('chapter.index', $course->id) }}">
                                                            Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        {{ Form::close() }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('page-scripts')
    <script src="{{ asset('backend/js/summernote.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#description').summernote();
        });
    </script>
@endsection