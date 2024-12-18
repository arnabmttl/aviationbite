@extends('layouts.backend.app')

@section('title', 'Edit Space')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Space</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('channel.index') }}">
                                    Spaces
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Space
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
                                            Form::model($channel, [
                                                'method' => 'Patch', 
                                                'action' => ['App\Http\Controllers\Backend\ChannelsController@update', $channel->slug], 
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Space Details</div>
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
                                                                    'tabindex' => '2'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('name', 'Name') !!}

                                                        @error('name')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Slug -->
                                                    <div class="col-12 form-label-group">
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
                                                                    'tabindex' => '6'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('slug', 'Slug') !!}

                                                        @error('slug')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('channel.index') }}">
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
    <script type="text/javascript">
        $("#name").keyup(function(){
            var slug = $(this).val().toLowerCase().replace(/[^a-zA-Z0-9]+/g,'-');
            $("#slug").val(slug);        
        });
    </script>
@endsection