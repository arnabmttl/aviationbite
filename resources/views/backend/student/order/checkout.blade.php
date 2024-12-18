@extends('layouts.backend.app')
 
@section('title', 'Order Checkout')

@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css/pages/app-invoice.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Order Checkout</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Order Checkout
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section class="invoice-preview-wrapper">
            <div id="cbz-checkout" class="row invoice-preview">
                <!-- Invoice -->
                <div class="col-xl-9 col-md-8 col-12">
                    <div class="card invoice-preview-card">
                        <div class="card-body invoice-padding pb-0">
                            <!-- Header starts -->
                            <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                <div>
                                    <div class="logo-wrapper">
                                        <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                                            <defs>
                                                <linearGradient id="invoice-linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                                    <stop stop-color="#000000" offset="0%"></stop>
                                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                                </linearGradient>
                                                <linearGradient id="invoice-linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                                </linearGradient>
                                            </defs>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-400.000000, -178.000000)">
                                                    <g transform="translate(400.000000, 178.000000)">
                                                        <path class="text-primary" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill: currentColor"></path>
                                                        <path d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#invoice-linearGradient-1)" opacity="0.2"></path>
                                                        <polygon fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                                        <polygon fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                                        <polygon fill="url(#invoice-linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <h3 class="text-primary invoice-logo">CSR</h3>
                                    </div>
                                    <p class="card-text mb-25">Office Address of the CSR</p>
                                    <p class="card-text mb-25">North West Delhi, Delhi, India</p>
                                    <p class="card-text mb-0">+91 99999 99999, +9111 2748 7432</p>
                                </div>
                                <div class="mt-md-0 mt-2">
                                    <h4 class="invoice-title">
                                        Order
                                        <!-- <span class="invoice-number">#3492</span> -->
                                    </h4>
                                    <div class="invoice-date-wrapper">
                                        <p class="invoice-date-title">Order Date:</p>
                                        <p class="invoice-date">{{ now()->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Header ends -->
                        </div>

                        <hr class="invoice-spacing" />

                        <!-- Address and Contact starts -->
                        <div class="card-body invoice-padding pt-0">
                            <div class="row invoice-spacing">
                                <div class="col-xl-8 p-0">
                                    <h6 class="mb-2">Invoice To:</h6>
                                    <h6 class="mb-25">{{ $user->name }}</h6>
                                    <p class="card-text mb-25">{{ $user->email }}</p>
                                    <p class="card-text mb-25">{{ $user->phone_number }}</p>
                                </div>
                                <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                </div>
                            </div>
                        </div>
                        <!-- Address and Contact ends -->

                        <!-- Invoice Description starts -->
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="py-1">#</th>
                                        <th class="py-1">Name & Description</th>
                                        <th class="py-1">Price</th>
                                        <th class="py-1">Special Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-bottom">
                                        <td class="py-1">
                                            1
                                        </td>
                                        <td class="py-1">
                                            <p class="card-text font-weight-bold mb-25">{{ $course->name }}</p>
                                            <p class="card-text text-nowrap">Validity: {{ $course->valid_for }} days</p>
                                        </td>
                                        <td class="py-1">
                                            <span class="font-weight-bold">Rs. {{ $course->price }}</span>
                                        </td>
                                        <td class="py-1">
                                            <span class="font-weight-bold">Rs. {{ $course->special_price }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-body invoice-padding pb-0">
                            <div class="row invoice-sales-total-wrapper">
                                <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                </div>
                                <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                    <div class="invoice-total-wrapper">
                                        <div class="invoice-total-item" v-if="discount_amount">
                                            <p class="invoice-total-title">Discount:</p>
                                            <p class="invoice-total-amount">- Rs. @{{ discount_amount }}</p>
                                        </div>
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">Subtotal:</p>
                                            <p class="invoice-total-amount">Rs. @{{ amount }}</p>
                                        </div>
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">Tax ({{ $gst->tax_percentage }}%):</p>
                                            <p class="invoice-total-amount">Rs. @{{ tax }}</p>
                                        </div>
                                        <hr class="my-50" />
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">Total:</p>
                                            <p class="invoice-total-amount">Rs. @{{ total_amount }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Invoice Description ends -->

                        <hr class="invoice-spacing" />
                    </div>
                </div>
                <!-- /Invoice -->

                <!-- Invoice Actions -->
                <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['method' => 'POST', 'action' => ['App\Http\Controllers\Backend\OrdersController@store'], 'class' => 'form-horizontal', 'novalidate' => true]) !!}
                                
                                <!-- Discount Code -->
                                <div class="form-label-group">
                                    {!!
                                        Form::text(
                                            'discount_code',
                                            null,
                                            [
                                                'id' => 'discount_code',
                                                'class' => 'form-control '.($errors->has('discount_code') ? 'is-invalid':''),
                                                'placeholder' => 'Discount Code',
                                                'aria-describedby' => 'discount_code',
                                                'tabindex' => '1',
                                                'v-model' => 'discount_code',
                                                'v-on:change' => 'checkDiscountCode'
                                            ]
                                        )
                                    !!}
                                    {!! Form::label('discount_code', 'Discount Code') !!}

                                    <span v-if="discount_errors" class="error">
                                        <strong v-text="discount_errors"></strong>
                                    </span>
                                    @error('discount_code')
                                        <x-validation-error-message :message="$message" />
                                    @enderror
                                </div>
                            
                                {!! Form::hidden('course_id[]', encrypt($course->id)) !!}
                                
                                <button type="submit" class="btn btn-primary btn-block mb-75">
                                    Pay Online
                                </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <!-- /Invoice Actions -->
            </div>
        </section>
    </div>
</div>
@endsection

@section('page-scripts')
    <script src="{{ asset('backend/js/vue.min.js') }}"></script>
    <script src="{{ asset('backend/js/axios.min.js') }}"></script>

    <script>
        new Vue({
            el: '#cbz-checkout',

            data: {
                course_slug: '{{ $course->slug }}',
                username: '{{ $user->username }}',
                amount: '{{ $amount }}',
                tax_percentage: '{{ $gst->tax_percentage }}',
                tax: '{{ $tax }}',
                discount_amount: 0,
                total_amount: '{{ $totalAmount }}',
                discount_code: null,
                discount_errors: null
            },

            methods: {
                checkDiscountCode() {
                    axios.post(
                        '{{env('APP_URL')}}api/check-discount-code', 
                        {
                            'username': this.username,
                            'slug': this.course_slug,
                            'discount_code': this.discount_code
                        }).then((response) => {
                            if (response.data.result) {
                                this.discount_errors = 'Discount successfully applied.'
                                discount = response.data.discount

                                // Find the exact discount amount to be applied.
                                if (discount.discount_percentage != 0) {
                                    this.discount_amount = (this.amount*discount.discount_percentage/100).toFixed(2)

                                    if (this.discount_amount > discount.maximum_discount)
                                        this.discount_amount = discount.maximum_discount
                                } else {
                                    if (discount.discount_amount < discount.maximum_discount)
                                        this.discount_amount = discount.discount_amount
                                    else
                                        this.discount_amount = discount.maximum_discount
                                }

                                // Recalculate the amount, tax and total amount.
                                this.amount = this.amount - this.discount_amount
                                this.tax = ((this.amount*(this.tax_percentage/100))).toFixed(2)
                                this.total_amount = parseFloat(this.amount) + parseFloat(this.tax)
                            } else {
                                this.discount_errors = 'Provided discount code is invalid.'

                                this.setInitialValues()
                            }
                        }).catch((error) => {
                            if (error.response.status == 422) {
                                this.discount_errors = 'Provided discount code is invalid.'
                            }

                            this.setInitialValues()
                        });
                },

                setInitialValues() {
                    this.amount = '{{ $amount }}'
                    this.tax = '{{ $tax }}'
                    this.discount_amount = 0
                    this.total_amount = '{{ $totalAmount }}'
                }
            }
        })
    </script>
@endsection