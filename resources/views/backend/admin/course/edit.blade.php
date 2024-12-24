@extends('layouts.backend.app')

@section('title', 'Edit Course')

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
                    <h2 class="content-header-title float-left mb-0">Edit Course</h2>
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
                            <li class="breadcrumb-item active">
                                Edit Course
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
                                            Form::model($course, [
                                                'method' => 'Patch',
                                                'action' => ['App\Http\Controllers\Backend\CoursesController@update', $course->id],
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Course Meta Information</div>
                                                    </div>

                                                    <!-- Meta Title -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'meta_title',
                                                                null,
                                                                [
                                                                    'id' => 'meta_title',
                                                                    'class' => 'form-control '.($errors->has('meta_title') ? 'is-invalid':''),
                                                                    'placeholder' => 'Meta Title',
                                                                    'aria-describedby' => 'meta_title',
                                                                    'tabindex' => '1'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('meta_title', 'Meta Title') !!}

                                                        @error('meta_title')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Meta Keywords -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'meta_keywords',
                                                                null,
                                                                [
                                                                    'id' => 'meta_keywords',
                                                                    'class' => 'form-control '.($errors->has('meta_keywords') ? 'is-invalid':''),
                                                                    'placeholder' => 'Meta Keywords',
                                                                    'aria-describedby' => 'meta_keywords',
                                                                    'tabindex' => '2'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('meta_keywords', 'Meta Keywords') !!}

                                                        @error('meta_keywords')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Meta Description -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'meta_description',
                                                                null,
                                                                [
                                                                    'id' => 'meta_description',
                                                                    'class' => 'form-control '.($errors->has('meta_description') ? 'is-invalid':''),
                                                                    'placeholder' => 'Meta Description',
                                                                    'aria-describedby' => 'meta_description',
                                                                    'tabindex' => '3'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('meta_description', 'Meta Description') !!}

                                                        @error('meta_description')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Course Details</div>
                                                    </div>

                                                    <!-- Topics -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'topics[]',
                                                                $topics,
                                                                null,
                                                                [
                                                                    'id' => 'parent_id',
                                                                    'class' => 'select2 form-control '.($errors->has('topics') ? 'is-invalid':''),
                                                                    'multiple' => true,
                                                                    'aria-describedby' => 'topics',
                                                                    'required' => true,
                                                                    'tabindex' => '4'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('topics', 'Select Topics') !!}

                                                        @error('topics')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
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
                                                                    'required' => true,
                                                                    'aria-describedby' => 'name',
                                                                    'tabindex' => '5'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('name', 'Name') !!}

                                                        @error('name')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Slug -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'slug',
                                                                null,
                                                                [
                                                                    'id' => 'slug',
                                                                    'class' => 'form-control '.($errors->has('slug') ? 'is-invalid':''),
                                                                    'placeholder' => 'Slug',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'slug',
                                                                    'tabindex' => '6'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('slug', 'Slug') !!}

                                                        @error('slug')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Price -->
                                                    <div class="col-2 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'price',
                                                                null,
                                                                [
                                                                    'id' => 'price',
                                                                    'class' => 'form-control '.($errors->has('price') ? 'is-invalid':''),
                                                                    'placeholder' => 'Price',
                                                                    'required' => true,
                                                                    'step' => 1,
                                                                    'aria-describedby' => 'price',
                                                                    'tabindex' => '7'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('price', 'Price') !!}

                                                        @error('price')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Special Price -->
                                                    <div class="col-2 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'special_price',
                                                                null,
                                                                [
                                                                    'id' => 'special_price',
                                                                    'class' => 'form-control '.($errors->has('special_price') ? 'is-invalid':''),
                                                                    'placeholder' => 'Special Price',
                                                                    'required' => true,
                                                                    'step' => 1,
                                                                    'aria-describedby' => 'special_price',
                                                                    'tabindex' => '8'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('special_price', 'Special Price') !!}

                                                        @error('special_price')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Valid for (in days) -->
                                                    <div class="col-2 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'valid_for',
                                                                null,
                                                                [
                                                                    'id' => 'valid_for',
                                                                    'class' => 'form-control '.($errors->has('valid_for') ? 'is-invalid':''),
                                                                    'placeholder' => 'Valid for (in days)',
                                                                    'required' => true,
                                                                    'step' => 1,
                                                                    'aria-describedby' => 'valid_for',
                                                                    'tabindex' => '9'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('valid_for', 'Valid for (in days)') !!}

                                                        @error('valid_for')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Is active? -->
                                                    <div class="col-2 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'is_active',
                                                                [
                                                                    0 => 'No',
                                                                    1 => 'Yes'
                                                                ],
                                                                $course->is_active,
                                                                [
                                                                    'id' => 'is_active',
                                                                    'class' => 'form-control '.($errors->has('is_active') ? 'is-invalid':''),
                                                                    'placeholder' => 'Is active?',
                                                                    'required' => true,
                                                                    'step' => 1,
                                                                    'aria-describedby' => 'is_active',
                                                                    'tabindex' => '10'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('is_active', 'Is active?') !!}

                                                        @error('is_active')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Number of Tests -->
                                                    <div class="col-2 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'number_of_tests',
                                                                null,
                                                                [
                                                                    'id' => 'number_of_tests',
                                                                    'class' => 'form-control '.($errors->has('number_of_tests') ? 'is-invalid':''),
                                                                    'placeholder' => 'Number of Tests',
                                                                    'required' => true,
                                                                    'step' => 1,
                                                                    'min' => 0,
                                                                    'aria-describedby' => 'number_of_tests',
                                                                    'tabindex' => '11'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('number_of_tests', 'Number of Tests') !!}

                                                        @error('number_of_tests')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Video URL -->
                                                    <div class="col-2 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'video_url',
                                                                null,
                                                                [
                                                                    'id' => 'video_url',
                                                                    'class' => 'form-control '.($errors->has('video_url') ? 'is-invalid':''),
                                                                    'placeholder' => 'Video URL',
                                                                    'aria-describedby' => 'video_url',
                                                                    'tabindex' => '12',
                                                                    'required' => true
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('video_url', 'Video URL') !!}

                                                        @error('video_url')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Thumbnail Image -->
                                                    <!-- <div class="col-12">
                                                        <fieldset class="form-group">
                                                            {!! Form::label('thumbnail_image', 'Thumbnail Image') !!}
                                                            <div class="custom-file">
                                                                {!! 
                                                                    Form::file(
                                                                      'thumbnail_image', 
                                                                      [
                                                                        'class' => 'custom-file-input',
                                                                        'id' => 'thumbnail_image',
                                                                        'accept'=>'image/*',
                                                                        'required' => true,
                                                                        'tabindex' => '11'
                                                                      ]
                                                                    )
                                                                !!}

                                                                <label class="custom-file-label" for="thumbnail_image">Choose file</label>
                                                            </div>
                                                        </fieldset>

                                                        @error('thumbnail_image')
                                                            <span class="help-block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> -->

                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Short Description</div>
                                                    </div>

                                                    <!-- Short Description -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::textarea(
                                                                'short_description',
                                                                null,
                                                                [
                                                                    'id' => 'short_description',
                                                                    'class' => 'form-control '.($errors->has('short_description') ? 'is-invalid':''),
                                                                    'placeholder' => 'Short Description',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'short_description',
                                                                    'tabindex' => '13'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('short_description', 'Short Description') !!}

                                                        @error('short_description')
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
                                                                    'required' => true,
                                                                    'aria-describedby' => 'description',
                                                                    'tabindex' => '14'
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
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('course.index') }}">
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
    <script src="{{ asset('backend/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/app-assets/js/scripts/forms/form-select2.js') }}"></script>

    <script src="{{ asset('backend/js/summernote.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#description').summernote();
            $('#short_description').summernote();
        });
    </script>
@endsection