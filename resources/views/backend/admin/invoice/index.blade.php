@extends('layouts.backend.app')

@section('title', 'Invoices')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Invoices</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Invoices
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
                                    <th>Invoice Number</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>Tax</th>
                                    <th>Total Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $index => $invoice)
                                <tr>
                                    <th scope="row">
                                        {{ $invoice->invoiceNumber }}
                                    </th>
                                    <td>
                                        {{ $invoice->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ $invoice->order->user_details['name'] }}
                                    </td>
                                    <td>
                                        {{ $invoice->order->user_details['email'] }}
                                    </td>
                                    <td>
                                        {{ $invoice->order->user_details['phone_number'] }}
                                    </td>
                                    <td>
                                        {{ isset($invoice->order->user_details['address']) ? $invoice->order->user_details['address'] : '' }}
                                    </td>
                                    <td>
                                        {{ $invoice->order_details['payment_method'] }}
                                    </td>
                                    <td>
                                        @switch($invoice->order_details['payment_status'])
                                            @case('Pending')
                                                <div class="badge badge-pill badge-primary">
                                                    {{ $invoice->order_details['payment_status'] }}
                                                </div>
                                            @break
                                            @case('Completed')
                                                <div class="badge badge-pill badge-success">
                                                    {{ $invoice->order_details['payment_status'] }}
                                                </div>
                                            @break
                                            @case('Failed')
                                                <div class="badge badge-pill badge-danger">
                                                    {{ $invoice->order_details['payment_status'] }}
                                                </div>
                                            @break
                                            @default
                                                Some problem occured please try again.
                                        @endswitch
                                    </td>
                                    <td>
                                        {{ $invoice->order_details['amount'] }}
                                    </td>
                                    <td>
                                        @if ($invoice->order_details['discount_amount'])
                                            - {{ $invoice->order_details['discount_amount'] }}
                                        @else
                                            {{ $invoice->order_details['discount_amount'] }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $invoice->order_details['tax_amount'] }}
                                    </td>
                                    <td>
                                        {{ $invoice->total_amount }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('invoice.details', encrypt($invoice->id)) }}">
                                                    <i data-feather="eye" class="mr-50"></i>
                                                    <span>View</span>
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
        {{ $invoices->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection