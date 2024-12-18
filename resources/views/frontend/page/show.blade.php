@extends('layouts.frontend.app')

@section('title', $page->name)

@section('content')
    @foreach($page->sections as $section)
    	@if(($section->margin_top)||($section->margin_bottom))
		    @section('page-styles')
		        <style type="text/css">
		            #section-{{$section->id}}-custom-margin
		            {
		                @if($section->margin_top)
		                    margin-top: {{$section->margin_top}}px;
		                @endif
		                @if($section->margin_bottom)
		                    margin-bottom: {{$section->margin_bottom}}px;
		                @endif
		            }
		        </style>
		    @append
		@endif

		@include('frontend.page.partial.'.$section->sectionView->type)
    @endforeach
@endsection