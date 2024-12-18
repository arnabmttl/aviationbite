@extends('layouts.backend.app')

@section('title', 'Users')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Users</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Users
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- User Search start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! 
                                        Form::open([
                                            'method' => 'Post', 
                                            'action' => ['App\Http\Controllers\Backend\UsersController@search'], 
                                            'class' => 'form'
                                        ])
                                    !!}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="divider text-center w-100">
                                                    <div class="divider-text">Search Users</div>
                                                </div>

                                                <!-- Username -->
                                                <div class="col-12 form-label-group">
                                                    {!!
                                                        Form::text(
                                                            'username',
                                                            null,
                                                            [
                                                                'id' => 'username',
                                                                'class' => 'form-control '.($errors->has('username') ? 'is-invalid':''),
                                                                'placeholder' => 'Username',
                                                                'aria-describedby' => 'username',
                                                                'tabindex' => '1',
                                                                'required' => true
                                                            ]
                                                        )
                                                    !!}
                                                    {!! Form::label('username', 'Username') !!}

                                                    @error('username')
                                                        <x-validation-error-message :message="$message" />
                                                    @enderror
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Search</button>
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
        <!-- User Search end -->
        <!-- Hoverable rows start -->
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    @if(request()->user()->hasRole(['admin']))
                                    <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <th scope="row">
                                        {{ $index + $users->firstItem() }}
                                    </th>
                                    <td>
                                        {{ $user->username }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        {{ $user->phone_number }}
                                    </td>
                                    <td>
                                        @if ($user->is_blocked)
                                            <div class="badge badge-pill badge-danger">
                                                Blocked
                                            </div>
                                        @else
                                            <div class="badge badge-pill badge-success">
                                                Active
                                            </div>
                                        @endif
                                    </td>
                                    @if(request()->user()->hasRole(['admin']))
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('user.change.status', $user->id) }}">
                                                    <i data-feather="refresh-cw" class="mr-50"></i>
                                                    <span>Change Status</span>
                                                </a>
                                                <a class="dropdown-item" href="{{ route('userDetailsDownloadCsv', ['id'=>$user->id]) }}">
                                                    <i data-feather="refresh-cw" class="mr-50"></i>
                                                    <span>Download CSV</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hoverable rows end -->
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection