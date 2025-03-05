@extends('layouts.frontend.app')

@section('title', $course->name.' Practice')

@section('page-styles')
<style>
    /*Input rangeSlider css*/

    /* The slider itself */
    .sliderPracticeTest {
      -webkit-appearance: none;  /* Override default CSS styles */
      appearance: none;
      width: 100%; /* Full-width */
      height: 25px; /* Specified height */
      background: #d3d3d3; /* Grey background */
      outline: none; /* Remove outline */
      opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
      -webkit-transition: .2s; /* 0.2 seconds transition on hover */
      transition: opacity .2s;
    }

    /* Mouse-over effects */
    .sliderPracticeTest:hover {
      opacity: 1; /* Fully shown on mouse-over */
    }

    /* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
    .sliderPracticeTest::-webkit-slider-thumb {
      -webkit-appearance: none; /* Override default look */
      appearance: none;
      width: 25px; /* Set a specific slider handle width */
      height: 25px; /* Slider handle height */
      background: #005EB8; /* Green background */
      cursor: pointer; /* Cursor on hover */
    }

    .sliderPracticeTest::-moz-range-thumb {
      width: 25px; /* Set a specific slider handle width */
      height: 25px; /* Slider handle height */
      background: #005EB8; /* Green background */
      cursor: pointer; /* Cursor on hover */
    }

    .takeTestCont .tabs li {
        display: flex;
        align-items: center;
        grid-gap: 5px;
    }

</style>
@append

@section('content')
    <!-- BEGIN: Practice Create -->
    <section id="create-cbz-practice-test" class="about courses practiceTest pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! 
                        Form::open([
                            'method' => 'Post', 
                            'action' => ['App\Http\Controllers\Frontend\PracticeTestsController@store', $course->slug], 
                            'class' => 'form'
                        ])
                    !!}
                        <div class="form-body">
                            <div class="row">
                                <!-- Select/Deselect All -->
                                <div class="col-12 form-label-group">
                                    <span 
                                        v-on:click="selectDeselectAll"
                                        class="btn btn-primary mr-1 mb-1 waves-effect waves-light"
                                    >
                                        Select/Deselect All
                                    </span>
                                </div>

                                <div class="col-12 form-label-group">
                                @foreach ($course->chapters as $index => $chapter)
                                    <!-- Chapters -->
                                    <div class="col-12 form-label-group chaptersRow">
                                        {!!
                                            Form::checkbox(
                                                'chapter_selected[]',
                                                $chapter->id,
                                                true,
                                                [
                                                    'id' => 'chapter_'.($index+1),
                                                    'aria-describedby' => 'chapter_'.($index+1),
                                                    'tabindex' => ($index+1),
                                                    'v-model' => 'chapters',
                                                    'v-on:change' => 'getTotalQuestionsByChaptersDifficultyAndType'
                                                ]
                                            )
                                        !!}
                                        {!! Form::label('chapter_'.($index+1), $chapter->name) !!}

                                        @error('chapter_selected.'.$index)
                                            <x-validation-error-message :message="$message" />
                                        @enderror
                                    </div>
                                @endforeach
                                </div>

                                <!-- Difficulty Level -->
                                {{-- <div class="col-6 form-label-group pt-5">
                                    {!! Form::label('difficulty_level_id', 'Difficulty Level') !!}
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
                                                'tabindex' => '1',
                                                'v-model' => 'difficulty',
                                                'v-on:change' => 'getTotalQuestionsByChaptersDifficultyAndType'
                                            ]
                                        )
                                    !!}

                                    @error('difficulty_level_id')
                                        <x-validation-error-message :message="$message" />
                                    @enderror
                                </div> --}}

                                <!-- Question Type -->
                                <div class="col-6 form-label-group pt-5">
                                    {!! Form::label('question_type_id', 'Question Type') !!}
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
                                                'tabindex' => '2',
                                                'v-model' => 'type',
                                                'v-on:change' => 'getTotalQuestionsByChaptersDifficultyAndType'
                                            ]
                                        )
                                    !!}

                                    @error('question_type_id')
                                        <x-validation-error-message :message="$message" />
                                    @enderror
                                </div>

                                <!-- Number of Questions -->                               
                                <div class="col-12">
                                     <div class="quesSlider pt-5 pb-5">
                                        <div class="slidecontainer">
                                            <div class="text">
                                                <p>Questions</p>
                                                <input type="number" name="number_of_questions" id="selectValue" min="0" :max="totalQuestions">
                                                <p>of <span class="font-bold">@{{ totalQuestions }}</span>available</p>
                                            </div>
                                            <div class="rangeSliderPracticeTest pt-2">
                                                <input class="sliderPracticeTest" type="range" min="0" value="0" :max="totalQuestions" id="sliderPracticeTest">
                                            </div>
                                        </div>
                                    </div>

                                    @error('number_of_questions')
                                        <x-validation-error-message :message="$message" />
                                    @enderror
                                </div>


                                <div class="col-12 pb-5">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                    <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('single.course', $course->slug) }}">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
    <!-- END: Practice Create -->
@endsection

@section('page-scripts')
    <script>
        new Vue({
            el: "#create-cbz-practice-test",
            
            data: {
                /**
                 * Variable to hold total number of questions as per chapters selected.
                 */
                totalQuestions: 50,

                /**
                 * Variables for chapters, difficulty and type selected.
                 */
                chapters: [],
                difficulty: '',
                type: '',

                /**
                 * Variable to hold failure/success messages.
                 */
                message: {
                    failure: null,
                    success: null
                },

                /**
                 * Variable to hold values for select/deselect all.
                 */
                selectAll: false
            },

            methods: {
                /**
                 * Select/Deselect all the checkbox of chapters.
                 */
                selectDeselectAll() {
                    if (this.selectAll) {
                        this.chapters = []
                    } else {
                        this.chapters = {{ $course->chapters->pluck('id') }}
                    }

                    this.selectAll = !this.selectAll

                    this.getTotalQuestionsByChaptersDifficultyAndType()
                },

                /**
                 * Get the total number of questions by the chapters, difficulty and type.
                 */
                getTotalQuestionsByChaptersDifficultyAndType() {
                    if (this.chapters.length) {
                        axios.post(
                            '{{env('APP_URL')}}api/get-total-questions-by-chapters-difficulty-and-type', 
                        {
                            'chapter_selected': this.chapters,
                            'difficulty_level_id': this.difficulty,
                            'question_type_id': this.type
                        }).then((response) => {
                            if (response.data.result) {
                                this.totalQuestions = response.data.total_questions
                            }
                        }).catch((error) => {
                            this.message.failure = 'There is some problem in fetching the total questions at the moment.'
                            this.message.success = ''
                        });
                    } else {
                        this.totalQuestions = 0
                    }
                },
            },

            mounted() {
                this.selectDeselectAll()

                this.getTotalQuestionsByChaptersDifficultyAndType()
            }
        });
    </script>
    <script type="text/javascript">
        // Input Range Slider
        var slider = document.getElementById("sliderPracticeTest");
        var selectValue = document.getElementById("selectValue");

        // Update the current slider value (each time you drag the slider handle)
        slider.oninput = function() {
          selectValue.value = this.value;
        }
    </script>
@append