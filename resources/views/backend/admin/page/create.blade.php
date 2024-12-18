@extends('layouts.backend.app')

@section('title', 'Add Page')

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/summernote.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Add Page</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('page.index') }}">
                                    Pages
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Add Page
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
                                            Form::open([
                                                'method' => 'Post', 
                                                'action' => ['App\Http\Controllers\Backend\PagesController@store'],
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Page Meta Information</div>
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
                                                        <div class="divider-text">Page Details</div>
                                                    </div>

                                                    <!-- Title -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'title',
                                                                null,
                                                                [
                                                                    'id' => 'title',
                                                                    'class' => 'form-control '.($errors->has('title') ? 'is-invalid':''),
                                                                    'placeholder' => 'Title',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'title',
                                                                    'tabindex' => '4'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('title', 'Title') !!}

                                                        @error('title')
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
                                                                    'tabindex' => '5'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('slug', 'Slug') !!}

                                                        @error('slug')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('page.index') }}">
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

        $("#title").keyup(function(){
            var slug = $(this).val().toLowerCase().replace(/[^a-zA-Z0-9]+/g,'-');
            $("#slug").val(slug);        
        });
    </script>  
@endsection