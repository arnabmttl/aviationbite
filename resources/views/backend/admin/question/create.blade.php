@extends('layouts.backend.app')

@section('title', 'Add Question')

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/summernote.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Add Question</h2>
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
                                Add Question
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
                                                'action' => ['App\Http\Controllers\Backend\QuestionsController@store'], 
                                                'class' => 'form',
                                                'id' =>'cbz-question-create',
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
                                                        {!!
                                                            Form::select(
                                                                'course_id',
                                                                $courses,
                                                                null,
                                                                [
                                                                    'id' => 'course_id',
                                                                    'class' => 'form-control '.($errors->has('course_id') ? 'is-invalid':''),
                                                                    'placeholder' => 'Select Course',
                                                                    'aria-describedby' => 'course_id',
                                                                    'tabindex' => '2',
                                                                    'required' => true,
                                                                    'v-on:change' => "selectCourse"
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('course_id', 'Course') !!}

                                                        @error('course_id')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Chapter -->
                                                    <div class="col-6 form-label-group">
                                                        <select 
                                                            name="course_chapter_id"
                                                            id="course_chapter_id"
                                                            class="form-control {{$errors->has('course_chapter_id') ? 'is-invalid':''}}"
                                                            aria-describedby="course_chapter_id"
                                                            tabindex="3"
                                                            required
                                                        >
                                                            <option value="">Select Chapter</option>
                                                            <option v-for="chapter in chapters" :value="chapter.id">@{{ chapter.name }}</option>
                                                        </select>
                                                        {!! Form::label('course_chapter_id', 'Chapter') !!}

                                                        @error('course_chapter_id')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
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

                                                    <!-- Question Image -->
                                                    <div class="col-12 form-label-group">
                                                        <fieldset class="form-group">
                                                            <div class="custom-file">
                                                                <input type="file" name="question_image" class="custom-file-input" accept="image/*">
                                                                <label class="custom-file-label" for="image">Choose file</label>
                                                            </div>
                                                        </fieldset>
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

                                                    <!-- Add Option -->
                                                    <div class="col-6 form-label-group">
                                                        <a class="btn btn-primary mr-1 mb-1 waves-effect waves-light" v-on:click="addOption()">Add Option</a>
                                                    </div>

                                                    <!-- Remove Option -->
                                                    <div class="col-6 form-label-group">
                                                        <a class="btn btn-danger mr-1 mb-1 waves-effect waves-light" v-on:click="deleteOption()">Remove Option</a>
                                                    </div>

                                                    <question-option v-for="index in option_count" :count="index"></question-option>

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

    <script src="{{ asset('backend/js/vue.min.js') }}"></script>
    <script src="{{ asset('backend/js/axios.min.js') }}"></script>

    <script>
        Vue.component('question-option', {
          template: `<div class="col-6 form-label-group">
                        <div class="divider text-center w-100">
                            <div class="divider-text">Option @{{ count }}</div>
                        </div>

                        <!-- Option Title -->
                        <div class="col-12 form-label-group">
                            {!!
                                Form::text(
                                    'option_title[]',
                                    null,
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

                        <!-- Option Image -->
                        <div class="col-12 form-label-group">
                            <fieldset class="form-group">
                                <div class="custom-file">
                                    <input type="file" name="image[]" class="custom-file-input" accept="image/*">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </fieldset>
                        </div>

                        <!-- Is Correct -->
                        <div class="col-12 form-label-group">
                            {!!
                                Form::select(
                                    'is_correct[]',
                                    [
                                        0 => 'No',
                                        1 => 'Yes'
                                    ],
                                    0,
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
                    </div>`,

            props: ['count']
        });

        new Vue({
            el: "#cbz-question-create",
            
            data: {
                chapters: [],
                option_count: 4
            },

            methods: {
                selectCourse(e) {
                    var selectedCourseId = (e.target.value)
                    
                    axios.post(
                        '{{env('APP_URL')}}api/get-chapters-by-course-id', 
                    {
                        'course_id': selectedCourseId
                    }).then((response) => {
                        if (response.data.result) {
                            this.chapters = response.data.chapters
                        } else {
                            this.chapters = []
                        }
                    }).catch((error) => {
                    
                    });
                },

                addOption() {
                    this.option_count++
                },

                deleteOption() {
                    this.option_count--
                }
            }
        });
    </script>
@endsection