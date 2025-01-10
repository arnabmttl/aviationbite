@extends('layouts.backend.app')
@section('title', 'Edit Banner')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Banner</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('banner.index') }}">
                                    Banner
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Banner
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
                                                'method' => 'POST', 
                                                'action' => ['App\Http\Controllers\Backend\BannerController@update',$banner->id],
                                                'class' => 'form',
                                                'enctype' => 'multipart/form-data'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    
                                                    <!-- Meta Title -->
                                                    <div class="col-8 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'title',
                                                                old('title',$banner->title),
                                                                [
                                                                    'id' => 'title',
                                                                    'class' => 'form-control '.($errors->has('title') ? 'is-invalid':''),
                                                                    'placeholder' => 'Add Title',
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
                                                    <div class="col-4 form-label-group">
                                                        
                                                        {!! Form::label('set_page_for', 'Set Page For') !!}

                                                        <select name="set_page_for" class="form-control @if($errors->has('set_page_for')) is-invalid @endif" id="">
                                                            <option value="" hidden selected>Set banner for</option>
                                                            <option value="home" @if($banner->set_page_for == 'home') selected @endif>Home</option>
                                                            <option value="forum" @if($banner->set_page_for == 'forum') selected @endif>Forum</option>
                                                            <option value="contact" @if($banner->set_page_for == 'contact') selected @endif>Contact Us</option>
                                                        </select>

                                                        @error('set_page_for')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Meta Description -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'description',
                                                                old('description',$banner->description),
                                                                [
                                                                    'id' => 'description',
                                                                    'class' => 'form-control '.($errors->has('description') ? 'is-invalid':''),
                                                                    'placeholder' => 'Add Description',
                                                                    'aria-describedby' => 'description',
                                                                    'tabindex' => '3'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('description', 'Description') !!}

                                                        @error('description')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                     <!-- Image -->
                                                     <div class="col-12 form-label-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="image" accept="image/*">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        </div>

                                                        @error('image')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Image -->
                                                    <div class="col-12 ">
                                                        
                                                        <img src="{{ url($banner->image) }}" class="product-image" alt="Product Image" style="width: 100%;">
                                                    </div>


                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('banner.index') }}">
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
        $(document).ready(function() {

        });

        
    </script>  
@endsection