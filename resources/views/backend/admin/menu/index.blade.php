@extends('layouts.backend.app')

@section('title', 'Menu Items')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Menu Items</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Menu Items
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrumb-right">
                <div class="dropdown">
                    <a href="{{ route('menu.create') }}">
                        <button class="btn btn-primary" type="button">
                            <i data-feather="plus"></i>
                            Add Menu Item
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
                                    <th></th>
                                    <th>Title</th>
                                    <th>Redirection URL</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($menuItms as $index => $menuItm)
                                <tr>
                                    <th scope="row">
                                        {{ $index + 1 }}
                                    </th>
                                    <td></td>
                                    <td>
                                        {{ $menuItm->title }}
                                    </td>
                                    <td>
                                        {{ $menuItm->redirection_url }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                            @if ($index != 0)
                                                <a class="dropdown-item" href="{{ route('menu.move.up', $menuItm->id) }}">
                                                    <i data-feather="arrow-up" class="mr-50"></i>
                                                    <span>Move Up</span>
                                                </a>
                                            @endif
                                            @if ($index < $menuItms->count()-1)
                                                <a class="dropdown-item" href="{{ route('menu.move.down', $menuItm->id) }}">
                                                    <i data-feather="arrow-down" class="mr-50"></i>
                                                    <span>Move Down</span>
                                                </a>
                                            @endif
                                                <a class="dropdown-item" href="{{ route('menu.edit', $menuItm->id) }}">
                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <a 
                                                    class="dropdown-item"
                                                    href="{{ route('menu.destroy', $menuItm->id) }}"
                                                    onclick="event.preventDefault();document.getElementById('menu-delete-form-'+{{ $menuItm->id }}).submit();"
                                                >
                                                    <i data-feather="trash" class="mr-50"></i>
                                                    <span>Delete</span>
                                                </a>
                                                <form id="menu-delete-form-{{ $menuItm->id }}" action="{{ route('menu.destroy', $menuItm->id) }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="delete" />
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @foreach($menuItm->children as $childIndex => $child)
                                    <tr>
                                        <td></td>
                                        <th scope="row">
                                            {{ $index + 1 }}.{{ $childIndex + 1 }}
                                        </th>
                                        <td>
                                            {{ $child->title }}
                                        </td>
                                        <td>
                                            {{ $child->redirection_url }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                @if ($childIndex != 0)
                                                    <a class="dropdown-item" href="{{ route('menu.move.up', $child->id) }}">
                                                        <i data-feather="arrow-up" class="mr-50"></i>
                                                        <span>Move Up</span>
                                                    </a>
                                                @endif
                                                @if ($childIndex < $menuItm->children->count()-1)
                                                    <a class="dropdown-item" href="{{ route('menu.move.down', $child->id) }}">
                                                        <i data-feather="arrow-down" class="mr-50"></i>
                                                        <span>Move Down</span>
                                                    </a>
                                                @endif
                                                    <a class="dropdown-item" href="{{ route('menu.edit', $child->id) }}">
                                                        <i data-feather="edit-2" class="mr-50"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    <a 
                                                        class="dropdown-item"
                                                        href="{{ route('menu.destroy', $child->id) }}"
                                                        onclick="event.preventDefault();document.getElementById('menu-delete-form-'+{{ $child->id }}).submit();"
                                                    >
                                                        <i data-feather="trash" class="mr-50"></i>
                                                        <span>Delete</span>
                                                    </a>
                                                    <form id="menu-delete-form-{{ $child->id }}" action="{{ route('menu.destroy', $child->id) }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="delete" />
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
@endsection