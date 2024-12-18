@extends('layouts.backend.app')

@section('title', 'Edit Section')

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/summernote.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Section</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            {!! $breadcrumbs !!}
                            <li class="breadcrumb-item active">
                                Edit Section
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
                            @if (!in_array($section->sectionView->type, [2, 3, 6, 8, 9, 10, 11]))
                                <li class="nav-item">
                                    <a class="nav-link {{ (Session::has('selected_tab') && (Session::get('selected_tab') == 'sectioncontent')) ? 'active' : '' }}" id="section-content-tab-justified" data-toggle="tab" href="#section-content-just" role="tab" aria-controls="section-content-just" aria-selected="true">Section Content</a>
                                </li>
                            @endif
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content pt-1">
                                <div class="tab-pane {{ Session::has('selected_tab') ? '' : 'active' }}" id="section-details-just" role="tabpanel" aria-labelledby="section-details-tab-justified">
                                    <div class="col-md-12">
                                        {!! 
                                            Form::model($section, [
                                                'method' => 'Patch', 
                                                'action' => ['App\Http\Controllers\Backend\SectionsController@update', $section->id], 
                                                'class' => 'form',
                                                'files' => true
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- Title -->
                                                    <div class="col-12 form-label-group">
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
                                                                    'tabindex' => '1'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('title', 'Title') !!}

                                                        @error('title')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    @if (in_array($section->sectionView->type, [2, 3, 6]))
                                                        <!-- Redirection URL -->
                                                        <div class="col-12 form-label-group">
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
                                                                        'tabindex' => '2'
                                                                    ]
                                                                )
                                                            !!}
                                                            {!! Form::label('redirection_url', 'Redirection URL') !!}

                                                            @error('redirection_url')
                                                                <x-validation-error-message :message="$message" />
                                                            @enderror
                                                        </div>
                                                    @endif

                                                    @if ($section->image)
                                                        <!-- Image -->
                                                        <div class="col-4">
                                                            <img src="{{ asset('storage/'.$section->image->url) }}" height="100px">
                                                        </div>
                                                        <div class="col-8">
                                                            <fieldset class="form-group">
                                                                {!! Form::label('image', 'New Image') !!}
                                                                <div class="custom-file">
                                                                    {!! 
                                                                        Form::file(
                                                                          'image', 
                                                                          [
                                                                            'class' => 'custom-file-input',
                                                                            'id' => 'image',
                                                                            'accept'=>'image/*',
                                                                            'tabindex' => '3'
                                                                          ]
                                                                        )
                                                                    !!}

                                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                                </div>
                                                            </fieldset>

                                                            @error('image')
                                                                <span class="help-block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    @endif

                                                    @if (in_array($section->sectionView->type, [2, 3, 6, 7, 8, 9, 10, 11, 12]))
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
                                                                        'tabindex' => '4'
                                                                    ]
                                                                )
                                                            !!}
                                                            {!! Form::label('description', 'Description') !!}

                                                            @error('description')
                                                                <x-validation-error-message :message="$message" />
                                                            @enderror
                                                        </div>
                                                    @endif

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Update</button>
                                                            <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ $cancelUrl }}">
                                                                Cancel
                                                            </a>
                                                    </div>
                                                </div>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            @if (!in_array($section->sectionView->type, [2, 3, 6, 8, 9, 10, 11]))
                                <div class="tab-pane {{ (Session::has('selected_tab') && (Session::get('selected_tab') == 'sectioncontent')) ? 'active' : '' }}" id="section-content-just" role="tabpanel" aria-labelledby="section-content-tab-justified">
                                    @switch ($section->sectionView->type)
                                        @case (1)
                                            @include('backend.admin.section.partial.add-banner-for-page')
                                            @break
                                        @case (7)
                                            <div class="col-md-12">
                                                <p>You can change the content of this section by changing the collection named "{{ $section->sectionable->name }}" in the Collections list.</p>
                                                <br>
                                                <p><b>Note:</b> Changing the collection will change the content everywhere it is being used.</p>
                                            </div>
                                            @break
                                        @case (12)
                                            @include('backend.admin.section.partial.add-faq')
                                            @break
                                    @endswitch
                                </div>
                            @endif
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#description').summernote();
            $('#banner_text').summernote();
        });
    </script> 
@endsection