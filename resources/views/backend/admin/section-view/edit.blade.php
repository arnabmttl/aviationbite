@extends('layouts.backend.app')

@section('title', 'Edit Section View')

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/summernote.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Section View</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('section-view.index') }}">
                                    Section Views
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Section View
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
                                            Form::model($sectionView, [
                                                'method' => 'Patch', 
                                                'action' => ['App\Http\Controllers\Backend\SectionViewsController@update', $sectionView->id], 
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Topic Details</div>
                                                    </div>
                                                    
                                                    <!-- Type -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'type',
                                                                null,
                                                                [
                                                                    'id' => 'type',
                                                                    'class' => 'form-control '.($errors->has('type') ? 'is-invalid':''),
                                                                    'placeholder' => 'Type',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'type',
                                                                    'tabindex' => '1',
                                                                    'step' => 1
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('type', 'Type') !!}

                                                        @error('type')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Name -->
                                                    <div class="col-12 form-label-group">
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
                                                                    'tabindex' => '2'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('name', 'Name') !!}

                                                        @error('name')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Content -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::textarea(
                                                                'content',
                                                                null,
                                                                [
                                                                    'id' => 'content',
                                                                    'class' => 'form-control '.($errors->has('content') ? 'is-invalid':''),
                                                                    'placeholder' => 'Content',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'content',
                                                                    'tabindex' => '3'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('content', 'Content') !!}

                                                        @error('content')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('section-view.index') }}">
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
            $('#content').summernote('codeview.activate');
        });
    </script>
@endsection