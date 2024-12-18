@extends('layouts.backend.app')

@section('title', 'Edit Tax')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Tax</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('tax.index') }}">
                                    Taxes
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Tax
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
                                            Form::model($tax, [
                                                'method' => 'Patch',
                                                'action' => ['App\Http\Controllers\Backend\TaxesController@update', $tax->id],
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="divider text-center w-100">
                                                        <div class="divider-text">Tax Details</div>
                                                    </div>

                                                    <!-- Tax Percentage -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::number(
                                                                'tax_percentage',
                                                                null,
                                                                [
                                                                    'id' => 'tax_percentage',
                                                                    'class' => 'form-control '.($errors->has('tax_percentage') ? 'is-invalid':''),
                                                                    'placeholder' => 'Tax Percentage',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'tax_percentage',
                                                                    'tabindex' => '1',
                                                                    'step' => 0.01
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('tax_percentage', 'Tax Percentage') !!}

                                                        @error('tax_percentage')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('tax.index') }}">
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