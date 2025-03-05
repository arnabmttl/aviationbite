@extends('layouts.backend.app')
 
@section('title', 'Dashboard')

@section('content')
<style>
    .dashboard_card {
        display: inline-flex;
        align-items: center;
        padding: 24px;
        background: linear-gradient(118deg, #7367F0, rgba(115, 103, 240, 0.7));
        box-shadow: 0 0 10px 1px rgba(115, 103, 240, 0.7);
        color: #FFFFFF;
        border-radius: 5px;
        gap: 24px;
        width: 100%;
        max-width: 300px;
        margin-right: 24px;
        margin-bottom: 24px;
    }
    .dashboard_card figure {
        max-width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        flex: 0 0 100%;
        color: #000;
        border-radius: 50%;
        margin: 0;
    }
    .dashboard_card figure svg {
        width: 30px;
        header: 30px;
    }
</style>
<div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
        @if (Auth::user()->role->label == 'admin')
            <div class="dashboard_card">
                <figure>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </figure>
                <figcaption>Total User:<br/>{{$totalUsers}}</figcaption>

            </div>
            <div class="dashboard_card">
                <figure>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                </figure>
                <figcaption>Total Course:<br/>{{$totalCourses}}</figcaption>

            </div>
            <div class="dashboard_card">
                <figure>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </figure>
                <figcaption>Total Order:<br/>{{$totalOrders}}</figcaption>

            </div>

            <div class="row" id="table-hover-row">
                <div class="col-12">
                    <p>Latest Orders</p>
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
                                @foreach($latestOrders as $index => $order)
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

            <div class="row" id="table-hover-row">
                <div class="col-12">
                    <p>Latest Users</p>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
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
                                @foreach($latestUsers as $index => $user)
                                    <tr>
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
        @endif
    </div>
</div>
@endsection