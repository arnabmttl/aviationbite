@extends('layouts.backend.app')

@section('title', 'Add Section')

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/summernote.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Add Section {{$type}}</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            {!! $breadcrumbs !!}
                            <li class="breadcrumb-item active">
                                Add Section
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="nav-filled">
            <div class="row match-height">
                <!-- Section Edit Tabs starts -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-justified" id="sectionEditTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ Session::has('selected_tab') ? '' : 'active' }}" id="section-details-tab-justified" data-toggle="tab" href="#section-details-just" role="tab" aria-controls="section-details-just" aria-selected="true">Section Details</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content pt-1">
                                <div class="tab-pane {{ Session::has('selected_tab') ? '' : 'active' }}" id="section-details-just" role="tabpanel" aria-labelledby="section-details-tab-justified">
                                    <div class="col-md-12">
                                        {!! 
                                            Form::open([
                                                'method' => 'Post', 
                                                'action' => ['App\Http\Controllers\Backend\SectionsController@store', $type, $item->id],
                                                'class' => 'form',
                                                'id' => 'cbz-section-create',
                                                'files' => true
                                            ])
                                        !!}
                                            
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- Section View -->
                                                    <div class="col-4 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'section_view_id',
                                                                $sectionViews,
                                                                null,
                                                                [
                                                                    'id' => 'section_view_id',
                                                                    'class' => 'form-control '.($errors->has('section_view_id') ? 'is-invalid':''),
                                                                    'placeholder' => 'Select Section View',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'section_view_id',
                                                                    'tabindex' => '1',
                                                                    '@change' => 'getInputBySectionView($event)'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('section_view_id', 'Select Section View') !!}

                                                        @error('section_view_id')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Margin Top -->
                                                    <div class="col-4 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'margin_top',
                                                                0,
                                                                [
                                                                    'id' => 'margin_top',
                                                                    'class' => 'form-control '.($errors->has('margin_top') ? 'is-invalid':''),
                                                                    'placeholder' => 'Margin Top',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'margin_top',
                                                                    'tabindex' => '2',
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('margin_top', 'Margin Top') !!}

                                                        @error('margin_top')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Margin Bottom -->
                                                    <div class="col-4 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'margin_bottom',
                                                                0,
                                                                [
                                                                    'id' => 'margin_top',
                                                                    'class' => 'form-control '.($errors->has('margin_bottom') ? 'is-invalid':''),
                                                                    'placeholder' => 'Margin bottom',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'margin_bottom',
                                                                    'tabindex' => '3',
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('margin_bottom', 'Margin Bottom') !!}

                                                        @error('margin_bottom')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Title -->
                                                    <!-- Special Title for Banner -->
                                                    <div v-if="(sectView == 1)" class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'title',
                                                                'Full Page Banner',
                                                                [
                                                                    'id' => 'title',
                                                                    'class' => 'form-control '.($errors->has('title') ? 'is-invalid':''),
                                                                    'placeholder' => 'Title',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'title',
                                                                    'tabindex' => '4',
                                                                    'readonly' => true
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('title', 'Title') !!}

                                                        @error('title')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Title for other sections -->
                                                    <div v-if="(sectView == 2) || (sectView == 3) || (sectView == 6) || (sectView == 8) || (sectView == 9) || (sectView == 10) || (sectView == 11) || (sectView == 12)" class="col-12 form-label-group">
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

                                                    <!-- Banner Redirection URL -->
                                                    <div v-if="(sectView == 1)" class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'banner_redirection_url',
                                                                null,
                                                                [
                                                                    'id' => 'banner_redirection_url',
                                                                    'class' => 'form-control '.($errors->has('banner_redirection_url') ? 'is-invalid':''),
                                                                    'placeholder' => 'Redirection URL',
                                                                    'aria-describedby' => 'banner_redirection_url',
                                                                    'tabindex' => '5'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('banner_redirection_url', 'Redirection URL') !!}

                                                        @error('banner_redirection_url')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Banner Desktop Image -->
                                                    <div v-if="(sectView == 1)" class="col-12">
                                                        <fieldset class="form-group">
                                                            {!! Form::label('desktop_image', 'Desktop Image') !!}
                                                            <div class="custom-file">
                                                                {!! 
                                                                    Form::file(
                                                                      'desktop_image', 
                                                                      [
                                                                        'class' => 'custom-file-input',
                                                                        'id' => 'desktop_image',
                                                                        'accept'=>'image/*',
                                                                        'required' => true,
                                                                        'tabindex' => '3'
                                                                      ]
                                                                    )
                                                                !!}

                                                                <label class="custom-file-label" for="desktop_image">Choose file</label>
                                                            </div>
                                                        </fieldset>

                                                        @error('desktop_image')
                                                            <span class="help-block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <!-- Banner Mobile Image -->
                                                    <div v-if="(sectView == 1)" class="col-12">
                                                        <fieldset class="form-group">
                                                            {!! Form::label('mobile_image', 'Mobile Image') !!}
                                                            <div class="custom-file">
                                                                {!! 
                                                                    Form::file(
                                                                      'mobile_image', 
                                                                      [
                                                                        'class' => 'custom-file-input',
                                                                        'id' => 'mobile_image',
                                                                        'accept'=>'image/*',
                                                                        'required' => true,
                                                                        'tabindex' => '4'
                                                                      ]
                                                                    )
                                                                !!}

                                                                <label class="custom-file-label" for="mobile_image">Choose file</label>
                                                            </div>
                                                        </fieldset>

                                                        @error('mobile_image')
                                                            <span class="help-block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <!-- Redirection URL -->
                                                    <div v-if="(sectView == 2) || (sectView == 3) || (sectView == 6)" class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'redirection_url',
                                                                null,
                                                                [
                                                                    'id' => 'redirection_url',
                                                                    'class' => 'form-control '.($errors->has('redirection_url') ? 'is-invalid':''),
                                                                    'placeholder' => 'Redirection URL',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'redirection_url',
                                                                    'tabindex' => '5'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('redirection_url', 'Redirection URL') !!}

                                                        @error('redirection_url')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Collection -->
                                                    <div v-if="(sectView == 7)" class="col-12 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'collection_id',
                                                                $collections,
                                                                null,
                                                                [
                                                                    'id' => 'collection_id',
                                                                    'class' => 'form-control '.($errors->has('collection_id') ? 'is-invalid':''),
                                                                    'placeholder' => 'Select Collection',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'collection_id',
                                                                    'tabindex' => '6'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('collection_id', 'Select Collection') !!}

                                                        @error('collection_id')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Description -->
                                                    <div v-if="(sectView == 2) || (sectView == 3) || (sectView == 6) || (sectView == 7) || (sectView == 8) || (sectView == 9) || (sectView == 10) || (sectView == 11) || (sectView == 12)" class="col-12 form-label-group">
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
                                                                    'tabindex' => '7'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('description', 'Description') !!}

                                                        @error('description')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Section Image -->
                                                    <div v-if="(sectView == 3) || (sectView == 6) || (sectView == 8) || (sectView == 11)" class="col-12">
                                                        <fieldset class="form-group">
                                                            {!! Form::label('section_image', 'Image') !!}
                                                            <div class="custom-file">
                                                                {!! 
                                                                    Form::file(
                                                                      'section_image', 
                                                                      [
                                                                        'class' => 'custom-file-input',
                                                                        'id' => 'section_image',
                                                                        'accept'=>'image/*',
                                                                        'required' => true,
                                                                        'tabindex' => '3'
                                                                      ]
                                                                    )
                                                                !!}

                                                                <label class="custom-file-label" for="section_image">Choose file</label>
                                                            </div>
                                                        </fieldset>

                                                        @error('image')
                                                            <span class="help-block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <!-- FAQ Question -->
                                                    <div v-if="(sectView == 12)" class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'faq_question',
                                                                null,
                                                                [
                                                                    'id' => 'faq_question',
                                                                    'class' => 'form-control '.($errors->has('faq_question') ? 'is-invalid':''),
                                                                    'placeholder' => 'Question',
                                                                    'aria-describedby' => 'faq_question',
                                                                    'required' => true,
                                                                    'tabindex' => '6'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('faq_question', 'Question') !!}

                                                        @error('faq_question')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- FAQ Answer -->
                                                    <div v-if="(sectView == 12)" class="col-12 form-label-group">
                                                        {!!
                                                            Form::textarea(
                                                                'faq_answer',
                                                                null,
                                                                [
                                                                    'id' => 'faq_answer',
                                                                    'class' => 'form-control '.($errors->has('faq_answer') ? 'is-invalid':''),
                                                                    'placeholder' => 'Answer',
                                                                    'aria-describedby' => 'faq_answer',
                                                                    'required' => true,
                                                                    'tabindex' => '7'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('faq_answer', 'Answer') !!}

                                                        @error('faq_answer')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Update</button>
                                                            <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ $cancelUrl }}">
                                                                Cancel
                                                            </a>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        {!!Form::close()!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section Edit Tabs ends -->
            </div>
        </section>
    </div>
</div>
@endsection

@section('page-scripts')
    <script src="{{ asset('backend/js/summernote.js') }}"></script>

    <script src="{{ asset('backend/js/vue.min.js') }}"></script>

    <script>
        new Vue({
            el: '#cbz-section-create',

            data: {
                sectView: ''
            },

            methods: {
                getInputBySectionView(event) {
                    this.sectView = event.target.value

                    $(document).ready(function() {
                        $('#description').summernote();
                    });
                },

                checkValueForSecView() {
                    this.sectView = document.getElementById('section_view_id').value
                }
            },

            beforeMount(){
                this.checkValueForSecView()
            },
        })
    </script>
@endsection