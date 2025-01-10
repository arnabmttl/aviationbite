@extends('layouts.backend.app')

@section('title', 'Edit Page')

@section('content')

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/summernote.css') }}">
@endsection
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Page</h2>
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
                                Edit Page
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
                <!-- Page Edit Tabs starts -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-justified" id="pageEditTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ Session::has('selected_tab') ? '' : 'active' }}" id="page-details-tab-justified" data-toggle="tab" href="#page-details-just" role="tab" aria-controls="page-details-just" aria-selected="true">Page Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (Session::has('selected_tab') && (Session::get('selected_tab') == 'pagemeta')) ? 'active' : '' }}" id="page-metas-tab-justified" data-toggle="tab" href="#page-metas-just" role="tab" aria-controls="page-metas-just" aria-selected="true">Meta Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (Session::has('selected_tab') && (Session::get('selected_tab') == 'pagesection')) ? 'active' : '' }}" id="page-section-tab-justified" data-toggle="tab" href="#page-section-just" role="tab" aria-controls="page-section-just" aria-selected="true">Sections</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content pt-1">
                                <div class="tab-pane {{ Session::has('selected_tab') ? '' : 'active' }}" id="page-details-just" role="tabpanel" aria-labelledby="page-details-tab-justified">
                                    <div class="col-md-12">
                                        {!! 
                                            Form::model($page, [
                                                'method' => 'Patch', 
                                                'action' => ['App\Http\Controllers\Backend\PagesController@update', $page->id], 
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
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
                                                                    'tabindex' => '1'
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
                                                                    'tabindex' => '2',
                                                                    'readonly' => $page->isHomePage() ? 'true' : 'false'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('slug', 'Slug') !!}

                                                        @error('slug')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Update</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('page.index') }}">
                                                            Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <div class="tab-pane {{ (Session::has('selected_tab') && (Session::get('selected_tab') == 'pagemeta')) ? 'active' : '' }}" id="page-metas-just" role="tabpanel" aria-labelledby="page-metas-tab-justified">
                                    <div class="col-md-12">
                                        {!! 
                                            Form::model($page, [
                                                'method' => 'Patch', 
                                                'action' => ['App\Http\Controllers\Backend\PagesController@updateMetaInformation', $page->id], 
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
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
                                                            Form::textarea(
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

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Update</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('page.index') }}">
                                                            Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <div class="tab-pane {{ (Session::has('selected_tab') && (Session::get('selected_tab') == 'pagesection')) ? 'active' : '' }}" id="page-section-just" role="tabpanel" aria-labelledby="page-section-tab-justified">
                                    <div class="content-header row">
                                        <div class="content-header-left col-md-9 col-12 mb-2">
                                        </div>
                                        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                                            <div class="form-group breadcrumb-right">
                                                <div class="dropdown">
                                                    <a href="{{ route('section.create', ['page', $page->id]) }}">
                                                        <button class="btn btn-primary" type="button">
                                                            <i data-feather="plus"></i>
                                                            Add Section
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Hoverable rows start -->
                                    <div class="row" id="table-hover-row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Sort Order</th>
                                                                <th>Section</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($page->sections as $index => $section)
                                                            <tr>
                                                                <th scope="row">
                                                                    {{ $section->sort_order }}
                                                                </th>
                                                                <td>
                                                                    {{ $section->title }}
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                                            <i data-feather="more-vertical"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="{{ route('section.edit', [$section->pageable_type_url, $section->id]) }}">
                                                                                <i data-feather="edit-2" class="mr-50"></i>
                                                                                <span>Edit</span>
                                                                            </a>
                                                                        @if ($section->sort_order > 1)
                                                                            <a class="dropdown-item" href="{{ route('section.move.up', $section->id) }}">
                                                                                <i data-feather="arrow-up" class="mr-50"></i>
                                                                                <span>Move Up</span>
                                                                            </a>
                                                                        @endif
                                                                        @if ($section->sort_order < $section->pageable->sections->count())
                                                                            <a class="dropdown-item" href="{{ route('section.move.down', $section->id) }}">
                                                                                <i data-feather="arrow-down" class="mr-50"></i>
                                                                                <span>Move Down</span>
                                                                            </a>
                                                                        @endif
                                                                            <a 
                                                                                class="dropdown-item"
                                                                                href="{{ route('section.destroy', [$section->pageable_type_url, $section->id]) }}"
                                                                                onclick="event.preventDefault();document.getElementById('section-delete-form-'+{{ $section->id }}).submit();"
                                                                            >
                                                                                <i data-feather="trash" class="mr-50"></i>
                                                                                <span>Delete</span>
                                                                            </a>
                                                                            <form id="section-delete-form-{{ $section->id }}" action="{{ route('section.destroy', [$section->pageable_type_url, $section->id]) }}" method="POST" style="display: none;">
                                                                                {{ csrf_field() }}
                                                                                <input type="hidden" name="_method" value="delete" />
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Hoverable rows end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page Edit Tabs ends -->
            </div>
        </section>
    </div>
</div>
@endsection

@section('page-scripts')
    <script src="{{ asset('backend/js/summernote.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#meta_description').summernote();
        });
    </script>


@endsection