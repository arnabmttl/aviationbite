@extends('layouts.backend.app')

@section('title', 'Orders')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Orders</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Orders
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
                                    <th>Order Number</th>
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
                            @foreach($orders as $index => $order)
                                <tr>
                                    <th scope="row">
                                        {{ $order->orderNumber }}
                                    </th>
                                    <td>
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ $order->user_details['name'] }}
                                    </td>
                                    <td>
                                        {{ $order->user_details['email'] }}
                                    </td>
                                    <td>
                                        {{ $order->user_details['phone_number'] }}
                                    </td>
                                    <td>
                                        {{ isset($order->user_details['address']) ? $order->user_details['address'] : '' }}
                                    </td>
                                    <td>
                                        {{ $order->payment_method }}
                                    </td>
                                    <td>
                                        @switch($order->getRawOriginal('payment_status'))
                                            @case(0)
                                                <div class="badge badge-pill badge-primary">
                                                    {{ $order->payment_status }}
                                                </div>
                                            @break
                                            @case(1)
                                                <div class="badge badge-pill badge-success">
                                                    {{ $order->payment_status }}
                                                </div>
                                            @break
                                            @case(2)
                                                <div class="badge badge-pill badge-danger">
                                                    {{ $order->payment_status }}
                                                </div>
                                            @break
                                            @default
                                                Some problem occured please try again.
                                        @endswitch
                                    </td>
                                    <td>
                                        {{ $order->amount }}
                                    </td>
                                    <td>
                                        @if ($order->discount_amount)
                                            - {{ $order->discount_amount }}
                                        @else
                                            {{ $order->discount_amount }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $order->tax_amount }}
                                    </td>
                                    <td>
                                        {{ $order->total_amount }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('order.details', encrypt($order->id)) }}">
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
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection