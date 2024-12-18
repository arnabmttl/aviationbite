@extends('layouts.backend.app')

@section('title', 'Discounts')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Discounts</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Discounts
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrumb-right">
                <div class="dropdown">
                    <a href="{{ route('discount.create') }}">
                        <button class="btn btn-primary" type="button">
                            <i data-feather="plus"></i>
                            Add Discount
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
                                    <th>Code</th>
                                    <th>Discount Percentage</th>
                                    <th>Discount Amount</th>
                                    <th>Maximum Discount</th>
                                    @if(request()->user()->hasRole(['admin']))
                                    <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($discounts as $index => $discount)
                                <tr>
                                    <th scope="row">
                                        {{ $index + $discounts->firstItem() }}
                                    </th>
                                    <td>
                                        {{ $discount->code }}
                                    </td>
                                    <td>
                                        {{ $discount->discount_percentage }}%
                                    </td>
                                    <td>
                                        Rs. {{ $discount->discount_amount }}
                                    </td>
                                    <td>
                                        Rs. {{ $discount->maximum_discount }}
                                    </td>
                                    @if(request()->user()->hasRole(['admin']))
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('discount.edit', $discount->id) }}">
                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                    <span>Edit</span>
                                                </a>
                                                @if (!$discount->valid_from->lte(now()))

                                                <a 
                                                    class="dropdown-item"
                                                    href="{{ route('discount.destroy', $discount->id) }}"
                                                    onclick="event.preventDefault();document.getElementById('discount-delete-form-'+{{ $discount->id }}).submit();"
                                                >
                                                    <i data-feather="trash" class="mr-50"></i>
                                                    <span>Delete</span>
                                                </a>
                                                <form id="discount-delete-form-{{ $discount->id }}" action="{{ route('discount.destroy', $discount->id) }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="delete" />
                                                </form>
                                                @endif
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
        {{ $discounts->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection