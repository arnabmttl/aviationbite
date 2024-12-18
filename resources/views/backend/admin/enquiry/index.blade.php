@extends('layouts.backend.app')

@section('title', 'Enquiries')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Enquiries</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Enquiries
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
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($enquiries as $index => $enquiry)
                                <tr>
                                    <th scope="row">
                                        {{ $index + $enquiries->firstItem() }}
                                    </th>
                                    <td>
                                        {{ $enquiry->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ $enquiry->name }}
                                    </td>
                                    <td>
                                        {{ $enquiry->phone_number }}
                                    </td>
                                    <td>
                                        {{ $enquiry->email }}
                                    </td>
                                    <td>
                                        {{ $enquiry->message }}
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
        {{ $enquiries->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection