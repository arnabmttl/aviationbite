@extends('layouts.backend.app')

@section('title', 'Upload Course Excel')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Upload Course Excel</h2>
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
                                Upload Course Excel
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
                                        Click 'Download' to download the sample file.
                                        <br><br>
                                        <a href="{{ asset('sample-excels/Course.xlsx') }}" target="_blank">
                                            <button class="btn btn-primary" type="button">
                                                <i data-feather="download"></i>
                                                Download
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                                'action' => ['App\Http\Controllers\Backend\CoursesController@uploadCourseExcel'],
                                                'class' => 'form',
                                                'files' => true
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">

                                                    <div class="col-12">
                                                        <fieldset class="form-group">
                                                            {!! Form::label('courses', 'Courses') !!}
                                                            <div class="custom-file">
                                                                {!! 
                                                                    Form::file(
                                                                      'courses', 
                                                                      [
                                                                        'class' => 'custom-file-input',
                                                                        'id' => 'courses',
                                                                        'accept'=>'.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel',
                                                                        'required' => true
                                                                      ]
                                                                    )
                                                                !!}

                                                                <label class="custom-file-label" for="courses">Choose file</label>
                                                            </div>
                                                        </fieldset>

                                                        @error('courses')
                                                            <span class="help-block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
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
                                <div class="row">
                                    <div class="col-md-12">
                                    @foreach ($failures as $failure)
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="help-block">
                                                    <strong>In row {{ $failure->row() }}, {{ $failure->attribute() }} has following errors: </strong>
                                                    <br>
                                                    @foreach ($failure->errors() as $error)
                                                        <strong>{{ $error }}</strong><br>
                                                    @endforeach
                                                    <br><br>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
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