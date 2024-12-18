@extends('layouts.backend.app')

@section('title', 'Add Discount')

@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Add Discount</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('discount.index') }}">
                                    Discounts
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Add Discount
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
                                                'method' => 'Post', 
                                                'action' => ['App\Http\Controllers\Backend\DiscountsController@store'], 
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Discount Details</div>
                                                    </div>
                                                    <!-- Code -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'code',
                                                                null,
                                                                [
                                                                    'id' => 'code',
                                                                    'class' => 'form-control '.($errors->has('code') ? 'is-invalid':''),
                                                                    'placeholder' => 'Discount Code',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'code',
                                                                    'tabindex' => '1'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('code', 'Code') !!}

                                                        @error('code')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Maximum Discount Amount -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'maximum_discount',
                                                                null,
                                                                [
                                                                    'id' => 'maximum_discount',
                                                                    'class' => 'form-control '.($errors->has('maximum_discount') ? 'is-invalid':''),
                                                                    'placeholder' => 'Maximum Discount Amount',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'maximum_discount',
                                                                    'min' => 1,
                                                                    'tabindex' => '2',
                                                                    'steps' => 1
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('maximum_discount', 'Maximum Discount Amount') !!}

                                                        @error('maximum_discount')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Discount Percentage -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'discount_percentage',
                                                                null,
                                                                [
                                                                    'id' => 'discount_percentage',
                                                                    'class' => 'form-control '.($errors->has('discount_percentage') ? 'is-invalid':''),
                                                                    'placeholder' => 'Discount Percentage (in %) (Required without Discount Amount)',
                                                                    'aria-describedby' => 'discount_percentage',
                                                                    'min' => 1,
                                                                    'max' => 100,
                                                                    'tabindex' => '3',
                                                                    'steps' => 1
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('discount_percentage', 'Discount Percentage') !!}

                                                        @error('discount_percentage')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Discount Amount -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'discount_amount',
                                                                null,
                                                                [
                                                                    'id' => 'discount_amount',
                                                                    'class' => 'form-control '.($errors->has('discount_amount') ? 'is-invalid':''),
                                                                    'placeholder' => 'Discount Amount (Required without Discount Percentage)',
                                                                    'aria-describedby' => 'discount_amount',
                                                                    'min' => 1,
                                                                    'tabindex' => '4',
                                                                    'steps' => 1
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('discount_amount', 'Discount Amount') !!}

                                                        @error('discount_amount')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Valid From -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::date(
                                                                'valid_from',
                                                                null,
                                                                [
                                                                    'id' => 'valid_from',
                                                                    'class' => 'form-control '.($errors->has('valid_from') ? 'is-invalid':''),
                                                                    'placeholder' => 'Valid From',
                                                                    'required' => true,
                                                                    'min' => now()->format('Y-m-d'),
                                                                    'aria-describedby' => 'valid_from',
                                                                    'tabindex' => '5'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('valid_from', 'Valid From') !!}

                                                        @error('valid_from')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <!-- Valid Till -->
                                                    <div class="col-6 form-label-group">
                                                        {!!
                                                            Form::date(
                                                                'valid_till',
                                                                null,
                                                                [
                                                                    'id' => 'valid_till',
                                                                    'class' => 'form-control '.($errors->has('valid_till') ? 'is-invalid':''),
                                                                    'placeholder' => 'Valid Till',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'valid_till',
                                                                    'tabindex' => '6'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('valid_till', 'Valid Till') !!}

                                                        @error('valid_till')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Coupon Code Applicable on Following Students (If none selected the applicable on all)</div>
                                                    </div>

                                                    <!-- Students -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'students[]',
                                                                $students,
                                                                null,
                                                                [
                                                                    'id' => 'students',
                                                                    'class' => 'select2 form-control '.($errors->has('students') ? 'is-invalid':''),
                                                                    'multiple' => true,
                                                                    'aria-describedby' => 'students',
                                                                    'tabindex' => '7'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('students', 'Select Students') !!}

                                                        @error('students')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Coupon Code Applicable on Following Courses (If none selected the applicable on all)</div>
                                                    </div>

                                                    <!-- Courses -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'courses[]',
                                                                $courses,
                                                                null,
                                                                [
                                                                    'id' => 'courses',
                                                                    'class' => 'select2 form-control '.($errors->has('courses') ? 'is-invalid':''),
                                                                    'multiple' => true,
                                                                    'aria-describedby' => 'courses',
                                                                    'tabindex' => '8'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('courses', 'Select Courses') !!}

                                                        @error('courses')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('discount.index') }}">
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
    <script src="{{ asset('backend/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('backend/app-assets/js/scripts/forms/form-select2.js') }}"></script>
@endsection