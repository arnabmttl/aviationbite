@extends('layouts.backend.app')

@section('title', 'Questions')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Questions</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Questions
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-6 col-12 d-md-block d-none">
            <div class="form-group breadcrumb-right">
                <div class="dropdown">
                    <a href="{{ route('question.excel.upload') }}">
                        <button class="btn btn-primary" type="button">
                            <i data-feather="upload"></i>
                            Upload Question Excel
                        </button>
                    </a>
                    <a href="{{ route('question.create') }}">
                        <button class="btn btn-primary" type="button">
                            <i data-feather="plus"></i>
                            Add Question
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Question Search start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! 
                                        Form::open([
                                            'method' => 'Post', 
                                            'action' => ['App\Http\Controllers\Backend\QuestionsController@search'], 
                                            'class' => 'form',
                                            'id' =>'cbz-question-search'
                                        ])
                                    !!}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="divider text-center w-100">
                                                    <div class="divider-text">Search Questions</div>
                                                </div>

                                                <!-- Question Id -->
                                                <div class="col-4 form-label-group">
                                                    {!!
                                                        Form::text(
                                                            'question_id',
                                                            null,
                                                            [
                                                                'id' => 'question_id',
                                                                'class' => 'form-control '.($errors->has('question_id') ? 'is-invalid':''),
                                                                'placeholder' => 'Question ID',
                                                                'aria-describedby' => 'question_id',
                                                                'tabindex' => '1'
                                                            ]
                                                        )
                                                    !!}
                                                    {!! Form::label('question_id', 'Question ID') !!}

                                                    @error('question_id')
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
                                                                'tabindex' => '2'
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
                                                                'tabindex' => '3',
                                                            ]
                                                        )
                                                    !!}
                                                    {!! Form::label('question_type_id', 'Question Type') !!}

                                                    @error('question_type_id')
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
                                                                'tabindex' => '4',
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
                                                        tabindex="5"
                                                    >
                                                        <option value="">Select Chapter</option>
                                                        <option v-for="chapter in chapters" :value="chapter.id">@{{ chapter.name }}</option>
                                                    </select>
                                                    {!! Form::label('course_chapter_id', 'Chapter') !!}

                                                    @error('course_chapter_id')
                                                        <x-validation-error-message :message="$message" />
                                                    @enderror
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Search</button>
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
        <!-- Question Search end -->
        <!-- Hoverable rows start -->
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Question ID</th>
                                    <th>Question</th>
                                    @if(request()->user()->hasRole(['admin']))
                                    <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $index => $question)
                                <tr>
                                    <th scope="row">
                                        {{ $index + $questions->firstItem() }}
                                    </th>
                                    <td>
                                        {{ $question->question_id }}
                                    </td>
                                    <td>
                                        {{ $question->title }}
                                    </td>
                                    @if(request()->user()->hasRole(['admin']))
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('question.edit', $question->id) }}">
                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <a 
                                                    class="dropdown-item"
                                                    href="{{ route('question.destroy', $question->id) }}"
                                                    onclick="event.preventDefault();document.getElementById('question-delete-form-'+{{ $question->id }}).submit();"
                                                >
                                                    <i data-feather="trash" class="mr-50"></i>
                                                    <span>Delete</span>
                                                </a>
                                                <form id="question-delete-form-{{ $question->id }}" action="{{ route('question.destroy', $question->id) }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="delete" />
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hoverable rows end -->
        {{ $questions->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection

@section('page-scripts')
    <script src="{{ asset('backend/js/vue.min.js') }}"></script>
    <script src="{{ asset('backend/js/axios.min.js') }}"></script>

    <script>
        new Vue({
            el: "#cbz-question-search",
            
            data: {
                chapters: []
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
                }
            }
        });
    </script>
@endsection