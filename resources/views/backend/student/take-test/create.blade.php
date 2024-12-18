@extends('layouts.frontend.app')

@section('title', $course->name.' Take Test')

@section('page-styles')

@append

@section('content')
    <!-- BEGIN: Practice Create -->
    <section id="create-cbz-practice-test" class="about courses practiceTest pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                        <div class="form-body">
                            <div class="row">
                                
                                @if (empty($questions))
                                <p>No such chapters added for this course</p>                                    
                                @endif
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Practice Create -->
@endsection

@section('page-scripts')
    <script>
        
    </script>
   
@append