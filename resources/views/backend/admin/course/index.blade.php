 @extends('layouts.backend.app')

@section('title', 'Courses')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Courses</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Courses
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-6 col-12 d-md-block d-none">
            <div class="form-group breadcrumb-right">
                <div class="dropdown">
                    <a href="{{ route('course.create') }}">
                        <button class="btn btn-primary" type="button">
                            <i data-feather="plus"></i>
                            Add Course
                        </button>
                    </a>
                </div>
            </div>
            <div class="form-group breadcrumb-right">
                <div class="dropdown">
                    <a href="{{ route('chapter.excel.upload') }}">
                        <button class="btn btn-primary" type="button">
                            <i data-feather="upload"></i>
                            Upload Chapter Excel
                        </button>
                    </a>
                    <a href="{{ route('course.excel.upload') }}">
                        <button class="btn btn-primary" type="button">
                            <i data-feather="upload"></i>
                            Upload Course Excel
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Hoverable rows start -->
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Special Price</th>
                                    <th>Is Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(request()->user()->createdCourses as $index => $course)
                                <tr>
                                    <th scope="row">
                                        {{ $index + 1 }}
                                    </th>
                                    <td>
                                        {{ $course->name }}
                                    </td>
                                    <td>
                                        {{ $course->price }}
                                    </td>
                                    <td>
                                        {{ $course->special_price }}
                                    </td>
                                    <td>
                                        {{ $course->is_active ? 'Yes' : 'No' }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('course.edit', $course->id) }}">
                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <a class="dropdown-item" href="{{ route('chapter.index', $course->id) }}">
                                                    <i data-feather="eye" class="mr-50"></i>
                                                    <span>Show</span>
                                                </a>
                                                <a class="dropdown-item" href="{{ route('test.details.edit', $course->id) }}">
                                                    <i data-feather="eye" class="mr-50"></i>
                                                    <span>Test Details</span>
                                                </a>
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
@endsection