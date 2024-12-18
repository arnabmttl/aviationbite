@extends('layouts.backend.app')

@section('title', 'Edit Test Details')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Test Details</h2>
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
                                Edit Test Details
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
                                                'action' => ['App\Http\Controllers\Backend\CoursesController@updateTestDetails', $course->id], 
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- Maximum Time -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::time(
                                                                'maximum_time',
                                                                $course->test ? $course->test->maximum_time : null,
                                                                [
                                                                    'id' => 'maximum_time',
                                                                    'class' => 'form-control '.($errors->has('maximum_time') ? 'is-invalid':''),
                                                                    'placeholder' => 'Maximum Time in hh:mm format',
                                                                    'aria-describedby' => 'maximum_time',
                                                                    'tabindex' => '1',
                                                                    'required' => true
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('maximum_time', 'Maximum Time in hh:mm format') !!}

                                                        @error('maximum_time')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Total Number of Questions</div>
                                                    </div>

                                                @if ($course->test)
                                                    <div class="col-6 form-label-group">
                                                        <span>Total - {{ $course->test->chapters->sum('number_of_questions') }}</span>
                                                    </div>

                                                    @foreach ($difficultyLevels as $dlId => $difficultyLevel)
                                                        <div class="col-2 form-label-group">
                                                            <span>{{ $difficultyLevel }} - {{ $course->test->chapters()->whereDifficultyLevelId($dlId)->sum('number_of_questions') }}</span>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="col-6 form-label-group">
                                                        <span>Total - 0</span>
                                                    </div>

                                                    @foreach ($difficultyLevels as $dlId => $difficultyLevel)
                                                        <div class="col-2 form-label-group">
                                                            <span>{{ $difficultyLevel }} - 0</span>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Chapter-wise Number of Questions Details</div>
                                                    </div>

                                                    <div class="col-6 form-label-group">
                                                        <span>Question</span>
                                                    </div>

                                                    @foreach ($difficultyLevels as $dlId => $difficultyLevel)
                                                        <div class="col-2 form-label-group">
                                                            <span>{{ $difficultyLevel }}</span>
                                                        </div>
                                                    @endforeach

                                                @foreach ($course->chapters as $index => $chapter)
                                                    <!-- Name -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'name[]',
                                                                $chapter->name,
                                                                [
                                                                    'class' => 'form-control '.($errors->has('name') ? 'is-invalid':''),
                                                                    'placeholder' => 'Name',
                                                                    'aria-describedby' => 'name',
                                                                    'readonly'
                                                                ]
                                                            )
                                                        !!}
                                                    </div>

                                                    @foreach ($difficultyLevels as $dlId => $difficultyLevel)
                                                        <!-- Number of questions -->
                                                        <div class="col-2 form-label-group">
                                                            {!!
                                                                Form::number(
                                                                    'number_of_questions['.$dlId.'][]',
                                                                    $numberOfQuestions[$dlId][$chapter->id],
                                                                    [
                                                                        'id' => 'number_of_questions_'.$dlId.'_'.$index,
                                                                        'class' => 'form-control '.($errors->has('number_of_questions.'.$dlId.'.'.$index) ? 'is-invalid':''),
                                                                        'placeholder' => 'Maximum '.$chapter->questions()->whereDifficultyLevelId($dlId)->count(),
                                                                        'aria-describedby' => 'number_of_questions_'.$dlId.'_'.$index,
                                                                        'tabindex' => ($index+2),
                                                                        'required',
                                                                        'max' => $chapter->questions()->whereDifficultyLevelId($dlId)->count()
                                                                    ]
                                                                )
                                                            !!}

                                                            @error ('number_of_questions.'.$dlId.'.'.$index)
                                                                <x-validation-error-message :message="$message" />
                                                            @enderror
                                                        </div>
                                                    @endforeach
                                                @endforeach

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('course.index', $course->id) }}">
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