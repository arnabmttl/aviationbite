@extends('layouts.backend.app')

@section('title', 'Edit Question')

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/summernote.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Question</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('question.index') }}">
                                    Questions
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Question
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
                                            Form::model($question, [
                                                'method' => 'Patch',
                                                'action' => ['App\Http\Controllers\Backend\QuestionsController@update', $question->id],
                                                'class' => 'form',
                                                'id' =>'cbz-question-edit',
                                                'files' => true
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Question Details</div>
                                                    </div>

                                                    <!-- Question Id -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'question_id',
                                                                null,
                                                                [
                                                                    'id' => 'question_id',
                                                                    'class' => 'form-control '.($errors->has('question_id') ? 'is-invalid':''),
                                                                    'placeholder' => 'Question ID',
                                                                    'aria-describedby' => 'question_id',
                                                                    'required' => 'true',
                                                                    'tabindex' => '1'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('question_id', 'Question ID') !!}

                                                        @error('question_id')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Course -->
                                                    <div class="col-6 form-label-group">
                                                        <input class="form-control" type="text" value="{{ $question->chapter->course->name }}" readonly>
                                                    </div>

                                                    <!-- Chapter -->
                                                    <div class="col-6 form-label-group">
                                                        <input class="form-control" type="text" value="{{ $question->chapter->name }}" readonly>
                                                    </div>

                                                    <!-- Difficulty Level -->
                                                    <div class="col-4 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'difficulty_level_id',
                                                                $difficultyLevels,
                                                                null,
                                                                [
                                                                    'id' => 'difficulty_level_id',
                                                                    'class' => 'form-control '.($errors->has('difficulty_level_id') ? 'is-invalid':''),
                                                                    'placeholder' => 'Select Difficulty Level',
                                                                    'aria-describedby' => 'difficulty_level_id',
                                                                    'tabindex' => '4',
                                                                    'required' => true
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('difficulty_level_id', 'Difficulty Level') !!}

                                                        @error('difficulty_level_id')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Question Type -->
                                                    <div class="col-4 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'question_type_id',
                                                                $questionTypes,
                                                                null,
                                                                [
                                                                    'id' => 'question_type_id',
                                                                    'class' => 'form-control '.($errors->has('question_type_id') ? 'is-invalid':''),
                                                                    'placeholder' => 'Select Question Type',
                                                                    'aria-describedby' => 'question_type_id',
                                                                    'tabindex' => '5',
                                                                    'required' => true
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('question_type_id', 'Question Type') !!}

                                                        @error('question_type_id')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Previous Years -->
                                                    <div class="col-4 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'previous_years',
                                                                null,
                                                                [
                                                                    'id' => 'previous_years',
                                                                    'class' => 'form-control '.($errors->has('previous_years') ? 'is-invalid':''),
                                                                    'placeholder' => 'Previous Years',
                                                                    'aria-describedby' => 'previous_years',
                                                                    'tabindex' => '6'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('previous_years', 'Previous Years') !!}

                                                        @error('previous_years')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Title -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'title',
                                                                null,
                                                                [
                                                                    'id' => 'title',
                                                                    'class' => 'form-control '.($errors->has('title') ? 'is-invalid':''),
                                                                    'placeholder' => 'Question',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'title',
                                                                    'tabindex' => '7'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('title', 'Question') !!}

                                                        @error('title')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    @if ($question->question_image)
                                                        <!-- Existing Image -->
                                                        <div class="col-6 form-label-group">
                                                            <img class="col-12" src="{{ $question->question_image->path }}">
                                                        </div>
                                                        <!-- Question Image -->
                                                        <div class="col-6 form-label-group">
                                                            <fieldset class="form-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="question_image" class="custom-file-input" accept="image/*">
                                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    @else
                                                        <!-- Question Image -->
                                                        <div class="col-12 form-label-group">
                                                            <fieldset class="form-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="question_image" class="custom-file-input" accept="image/*">
                                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    @endif

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
                                                                    'tabindex' => '8'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('description', 'Description') !!}

                                                        @error('description')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Explanation</div>
                                                    </div>

                                                    <!-- Explanation -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::textarea(
                                                                'explanation',
                                                                null,
                                                                [
                                                                    'id' => 'explanation',
                                                                    'class' => 'form-control '.($errors->has('explanation') ? 'is-invalid':''),
                                                                    'placeholder' => 'Explanation',
                                                                    'aria-describedby' => 'explanation',
                                                                    'tabindex' => '9'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('explanation', 'Explanation') !!}

                                                        @error('explanation')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Practice Test Comment</div>
                                                    </div>

                                                    <!-- Practice Test Comment -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::textarea(
                                                                'practice_test_comment',
                                                                $question->practice_test_comment,
                                                                [
                                                                    'id' => 'practice_test_comment',
                                                                    'class' => 'form-control '.($errors->has('practice_test_comment') ? 'is-invalid':''),
                                                                    'placeholder' => 'Practrice Test Comment',
                                                                    'rows' => 2
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('practice_test_comment', 'Practrice Test Comment') !!}

                                                        @error('practice_test_comment')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    @foreach ($question->options as $index => $option)
                                                        <div class="col-6 form-label-group">
                                                            <div class="divider text-center w-100">
                                                                <div class="divider-text">Option {{ $index + 1 }}</div>
                                                            </div>

                                                            <!-- Option Title -->
                                                            <div class="col-12 form-label-group">
                                                                {!!
                                                                    Form::text(
                                                                        'option_title[]',
                                                                        $option->title,
                                                                        [
                                                                            'class' => 'form-control '.($errors->has('option_title') ? 'is-invalid':''),
                                                                            'placeholder' => 'Option Title',
                                                                            'required' => true,
                                                                            'aria-describedby' => 'option_title',
                                                                            'tabindex' => '9'
                                                                        ]
                                                                    )
                                                                !!}
                                                                {!! Form::label('option_title', 'Option Title') !!}

                                                                @error('option_title')
                                                                    <x-validation-error-message :message="$message" />
                                                                @enderror
                                                            </div>

                                                            @if ($option->option_image)
                                                                <!-- Existing Image -->
                                                                <div class="col-6 form-label-group">
                                                                    <img class="col-12" src="{{ $option->option_image->path }}">
                                                                </div>
                                                                <!-- Option Image -->
                                                                <div class="col-6 form-label-group">
                                                                    <fieldset class="form-group">
                                                                        <div class="custom-file">
                                                                            <input type="file" name="image[]" class="custom-file-input" accept="image/*">
                                                                            <label class="custom-file-label" for="image">Choose file</label>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                            @else
                                                                <!-- Option Image -->
                                                                <div class="col-12 form-label-group">
                                                                    <fieldset class="form-group">
                                                                        <div class="custom-file">
                                                                            <input type="file" name="image[]" class="custom-file-input" accept="image/*">
                                                                            <label class="custom-file-label" for="image">Choose file</label>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                            @endif

                                                            <!-- Is Correct -->
                                                            <div class="col-12 form-label-group">
                                                                {!!
                                                                    Form::select(
                                                                        'is_correct[]',
                                                                        [
                                                                            0 => 'No',
                                                                            1 => 'Yes'
                                                                        ],
                                                                        $option->is_correct,
                                                                        [
                                                                            'class' => 'form-control '.($errors->has('is_correct') ? 'is-invalid':''),
                                                                            'placeholder' => 'Is Correct?',
                                                                            'aria-describedby' => 'is_correct',
                                                                            'tabindex' => '10',
                                                                            'required' => true
                                                                        ]
                                                                    )
                                                                !!}
                                                                {!! Form::label('is_correct', 'Is Correct?') !!}

                                                                @error('is_correct')
                                                                    <x-validation-error-message :message="$message" />
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('question.index') }}">
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
            $('#explanation').summernote();
        });
    </script>
@endsection