@extends('layouts.backend.app')

@section('title', 'Course Types')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Course Types</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Course Types
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <div class="content-body">
        <!-- Hoverable rows start -->
        <div class="row" id="table-hover-row">
            <div class="col-6">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $item)                            
                                <tr>
                                    <th scope="row">
                                        {{ $index + 1 }}
                                    </th>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('course-type.index',$item->id) }}">
                                                <i data-feather="edit-2" class="mr-50"></i>
                                                <span>Edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    
                                @endforelse
                           
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if (!empty($id))
            <div class="col-6">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('course-type.update', $id) }}" class="form">
                                        @csrf
                                        <div class="form-body">
                                            <div class="row">
                                                                                                
                                                <div class="col-12 form-label-group">
                                                    <input id="name" class="form-control @error('name')  is-invalid  @enderror " placeholder="Name"  aria-describedby="name" tabindex="2" name="name" type="text" maxlength="100" value="{{ old('name', $details->name) }}">
                                                    <label for="name">Name</label>
                                                    @error('name')
                                                        <x-validation-error-message :message="$message" />
                                                    @enderror
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Update</button>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-6">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('course-type.create') }}" class="form">
                                        @csrf
                                        <div class="form-body">
                                            <div class="row">
                                                                                                
                                                <div class="col-12 form-label-group">
                                                    <input id="name" class="form-control @error('name')  is-invalid  @enderror " placeholder="Name"  aria-describedby="name" tabindex="2" name="name" type="text" maxlength="100">
                                                    <label for="name">Name</label>
                                                    @error('name')
                                                        <x-validation-error-message :message="$message" />
                                                    @enderror
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Create</button>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
        </div>
        <!-- Hoverable rows end -->
    </div>
</div>


@endsection