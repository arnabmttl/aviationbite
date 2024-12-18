@extends('layouts.backend.app')

@section('title', 'Add Menu Item')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Add Menu Item</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('menu.index') }}">
                                    Menu Items
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Add Menu Item
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
                                                'action' => ['App\Http\Controllers\Backend\MenuAndFooterController@storeMenuItem'],
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">

                                                    <!-- Parent Menu Item -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'parent_id',
                                                                $menuItms,
                                                                null,
                                                                [
                                                                    'id' => 'parent_id',
                                                                    'class' => 'form-control '.($errors->has('parent_id') ? 'is-invalid':''),
                                                                    'placeholder' => 'Select Parent Menu Item',
                                                                    'aria-describedby' => 'parent_id',
                                                                    'tabindex' => '1'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('parent_id', 'Select Parent Menu Item') !!}

                                                        @error('parent_id')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

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
                                                                    'aria-describedby' => 'title',
                                                                    'required' => true,
                                                                    'tabindex' => '2'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('title', 'Title') !!}

                                                        @error('title')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

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
                                                                    'aria-describedby' => 'redirection_url',
                                                                    'required' => true,
                                                                    'tabindex' => '3'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('redirection_url', 'Redirection URL') !!}

                                                        @error('redirection_url')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('menu.index') }}">
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