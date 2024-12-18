@extends('layouts.backend.app')

@section('title', 'Add Collection')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Add Collection</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('collection.index') }}">
                                    Collections
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Add Collection
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
                                                'action' => ['App\Http\Controllers\Backend\CollectionsController@store'],
                                                'class' => 'form',
                                                'id' => 'cbz-collection-create'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Collection Details</div>
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
                                                                    'tabindex' => '1'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('name', 'Name') !!}

                                                        @error('name')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Type -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'type',
                                                                [
                                                                    'course' => 'Course'
                                                                ],
                                                                null,
                                                                [
                                                                    'id' => 'type',
                                                                    'class' => 'form-control '.($errors->has('type') ? 'is-invalid':''),
                                                                    'placeholder' => 'Select Type of Collection',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'type',
                                                                    'tabindex' => '2',
                                                                    '@change' => 'getInputByType($event)'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('type', 'Select Type of Collection') !!}

                                                        @error('type')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Test -->
                                                    <div v-if="type === 'course'" class="col-12 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'item_id',
                                                                $courses,
                                                                null,
                                                                [
                                                                    'id' => 'item_id',
                                                                    'class' => 'form-control '.($errors->has('item_id') ? 'is-invalid':''),
                                                                    'placeholder' => 'Select Item',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'item_id',
                                                                    'tabindex' => '3',
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('item_id', 'Select Item') !!}

                                                        @error('item_id')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('collection.index') }}">
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
    <script src="{{ asset('backend/js/vue.min.js') }}"></script>

    <script>
        new Vue({
            el: '#cbz-collection-create',

            data: {
                type: ''
            },

            methods: {
                getInputByType(event) {
                    this.type = event.target.value
                }
            }
        })
    </script>
@endsection