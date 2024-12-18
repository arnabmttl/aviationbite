@extends('layouts.backend.app')

@section('title', 'Edit Collection')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Collection</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('collection.index') }}">
                                    Collections
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Collection
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <section id="nav-filled">
            <div class="row match-height">
                <!-- Collection Edit Tabs starts -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-justified" id="collectionEditTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ Session::has('selected_tab') ? '' : 'active' }}" id="collection-details-tab-justified" data-toggle="tab" href="#collection-details-just" role="tab" aria-controls="collection-details-just" aria-selected="true">Collection Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (Session::has('selected_tab') && (Session::get('selected_tab') == 'collectionitem')) ? 'active' : '' }}" id="collection-items-tab-justified" data-toggle="tab" href="#collection-items-just" role="tab" aria-controls="collection-items-just" aria-selected="true">Items</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content pt-1">
                                <div class="tab-pane {{ Session::has('selected_tab') ? '' : 'active' }}" id="collection-details-just" role="tabpanel" aria-labelledby="collection-details-tab-justified">
                                    <div class="col-md-12">
                                        {!! 
                                            Form::model($collection, [
                                                'method' => 'Patch', 
                                                'action' => ['App\Http\Controllers\Backend\CollectionsController@update', $collection->id], 
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- Name -->
                                                    <div class="col-12 form-label-group">
                                                        {!!
                                                            Form::text(
                                                                'name',
                                                                null,
                                                                [
                                                                    'id' => 'name',
                                                                    'class' => 'form-control '.($errors->has('name') ? 'is-invalid':''),
                                                                    'placeholder' => 'Name',
                                                                    'required' => true,
                                                                    'aria-describedby' => 'name',
                                                                    'tabindex' => '1'
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('name', 'Name') !!}

                                                        @error('name')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Update</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('collection.index') }}">
                                                            Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <div class="tab-pane {{ (Session::has('selected_tab') && (Session::get('selected_tab') == 'collectionitem')) ? 'active' : '' }}" id="collection-items-just" role="tabpanel" aria-labelledby="collection-items-tab-justified">
                                    <div class="col-md-12">
                                        {!! 
                                            Form::model($collection, [
                                                'method' => 'Post', 
                                                'action' => ['App\Http\Controllers\Backend\CollectionsController@storeItem', $collection->id], 
                                                'class' => 'form'
                                            ])
                                        !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- Item -->
                                                    <div class="col-9 form-label-group">
                                                        {!!
                                                            Form::select(
                                                                'item_id',
                                                                $items,
                                                                null,
                                                                [
                                                                    'id' => 'item_id',
                                                                    'class' => 'form-control '.($errors->has('item_id') ? 'is-invalid':''),
                                                                    'placeholder' => 'Select Item',
                                                                    'aria-describedby' => 'item_id',
                                                                    'tabindex' => '1',
                                                                    'required' => true
                                                                ]
                                                            )
                                                        !!}
                                                        {!! Form::label('item_id', 'Select Item') !!}

                                                        @error('item_id')
                                                            <x-validation-error-message :message="$message" />
                                                        @enderror
                                                    </div>

                                                    <div class="col-3">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Add</button>
                                                        <a class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light" href="{{ route('collection.index') }}">
                                                            Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                    <!-- Hoverable rows start -->
                                    <div class="row" id="table-hover-row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No.</th>
                                                                <th>Item Name</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($collection->items as $index => $item)
                                                            <tr>
                                                                <th scope="row">
                                                                    {{ $index + 1 }}
                                                                </th>
                                                                <td>
                                                                    {{ $item->collectable->name ? $item->collectable->name : $item->collectable->title }}
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                                            <i data-feather="more-vertical"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            @if ($item->sort_order > 1)
                                                                                <a class="dropdown-item" href="{{ route('collection.item.move.up.direct', [$collection->id, $item->id]) }}">
                                                                                    <i data-feather="arrow-up" class="mr-50"></i>
                                                                                    <span>Move Up</span>
                                                                                </a>
                                                                            @endif
                                                                            @if ($item->sort_order < $item->collection->items->count())
                                                                                <a class="dropdown-item" href="{{ route('collection.item.move.down.direct', [$collection->id, $item->id]) }}">
                                                                                    <i data-feather="arrow-down" class="mr-50"></i>
                                                                                    <span>Move Down</span>
                                                                                </a>
                                                                                <a 
                                                                                    class="dropdown-item"
                                                                                    href="{{ route('collection.item.destroy.direct', [$collection->id, $item->id]) }}"
                                                                                    onclick="event.preventDefault();document.getElementById('item-delete-form-'+{{ $item->id }}).submit();"
                                                                                >
                                                                                    <i data-feather="trash" class="mr-50"></i>
                                                                                    <span>Delete</span>
                                                                                </a>
                                                                                <form id="item-delete-form-{{ $item->id }}" action="{{ route('collection.item.destroy.direct', [$collection->id, $item->id]) }}" method="POST" style="display: none;">
                                                                                    {{ csrf_field() }}
                                                                                    <input type="hidden" name="_method" value="delete" />
                                                                                </form>
                                                                            @endif
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
                        </div>
                    </div>
                </div>
                <!-- Collection Edit Tabs ends -->
            </div>
        </section>
    </div>
</div>
@endsection