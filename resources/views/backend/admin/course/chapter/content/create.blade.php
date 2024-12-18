@extends('layouts.backend.app')

@section('title', 'Add Chapter')

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/summernote.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">{{ $content->name }} Content</h2>
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('chapter.index',$chapter->id) }}">
                                    Chapter
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ $content->content }} Content
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrumb-right">
                <div class="dropdown">
                    <a href="{{ route('content.create',[$course->id, $chapter->id]) }}">
                        <button class="btn btn-primary" type="button">
                            <i data-feather="plus"></i>
                            Add Content
                        </button>
                    </a>
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
                                            Form::open([
                                                'method' => 'Post', 
                                                'action' => ['App\Http\Controllers\Backend\CourseChapterContentsController@store',$course->id, $chapter->id], 
                                                'class' => 'form',
                                                'files' => true
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Content Details</div>
                                                    </div>

                                                    <!-- File -->
                                                    <div class="col-12">
                                                        <fieldset class="form-group">
                                                            {!! Form::label('file', 'Select File') !!}
                                                            <div class="custom-file">
                                                                {!! 
                                                                    Form::file(
                                                                      'file', 
                                                                      [
                                                                        'class' => 'custom-file-input',
                                                                        'id' => 'file',
                                                                        'required' => true,
                                                                        'tabindex' => '1'
                                                                      ]
                                                                    )
                                                                !!}

                                                                <label class="custom-file-label" for="file">Choose file</label>
                                                            </div>
                                                        </fieldset>

                                                        @error('file')
                                                            <span class="help-block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <!-- Type -->
                                                    {!! Form::hidden('type', 4) !!}
                                                    <!-- <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'type',
                                                                [
                                                                    0 => 'Content',
                                                                    1 => 'File',
                                                                    2 => 'Image',
                                                                    3 => 'Document'
                                                                ],
                                                                0,
                                                                [
                                                                    'id' => 'type',
                                                                    'class' => 'form-control '.($errors->has('is_preview') ? 'is-invalid':''),
                                                                    'placeholder' => 'Type',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'Type',
                                                                    'tabindex' => '2'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('type', 'Type') !!}

                                                        @error('type')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div> -->

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
                                                                    'tabindex' => '3',
                                                                    'required' => true
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('name', 'Name') !!}

                                                        @error('name')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                     <!-- Time -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::time(
                                                                'duration',
                                                                null,
                                                                [
                                                                    'id' => 'duration',
                                                                    'class' => 'form-control '.($errors->has('duration') ? 'is-invalid':''),
                                                                    'placeholder' => 'Duration',
                                                                    
                                                                    'aria-describedby' => 'duration',
                                                                    'tabindex' => '4',
                                                                    'required' => true
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('duration', 'Duration hh:mm') !!}

                                                        @error('time')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- <div class="divider text-center w-100">
                                                        <div class="divider-text">Conten</div>
                                                    </div> -->

                                                    <!-- Description -->
                                                    <!-- <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::textarea(
                                                                'content',
                                                                null,
                                                                [
                                                                    'id' => 'content',
                                                                    'class' => 'form-control '.($errors->has('content') ? 'is-invalid':''),
                                                                    'placeholder' => 'Content',
                                                                    
                                                                    'aria-describedby' => 'content',
                                                                    'tabindex' => '5'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('content', 'Content') !!}

                                                        @error('content')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div> -->

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
            $('#content').summernote();
        });
    </script>
@endsection