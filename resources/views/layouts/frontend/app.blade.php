<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @yield('metas')

        <title>@yield('title', 'Aviation Bites') | {{ config('app.name', 'Aviation Bites') }}</title>
        
        <!-- bootstrap -->
        <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/font-awesome5/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">

        <!-- Google font -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Suranna&display=swap" rel="stylesheet">

        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}">

        <!-- Vue and Axios -->
        <script src="{{ asset('backend/js/vue.min.js') }}"></script>
        <script src="{{ asset('backend/js/axios.min.js') }}"></script>
        <script src="{{ asset('backend/js/moment.min.js') }}"></script>

         <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
         <!-- Toastr CSS -->
         <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

         <!-- Toastr JS -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


        <style>
         .dropdown-menu.active {
            display: block;
         }

         .dropdown-toggle {
            cursor: pointer;
         }

         .navbar .dropdown-menu {
            min-width: auto;
            width: 100%;
         }

         .navbar .dropdown-item {
            color: #212529;
            font-size: 12px;
            padding: 5px 10px;
         }

         .coursesCard .cardFooter button:hover {
            box-shadow: rgb(38 57 77) 0px 16px 30px -10px;
         }

         .popup button {
            background: var(--primaryColor);
            border: none;
            color: #fff;
            padding: 12px 25px;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 1px;
            margin-top: 20px;
            border-radius: 6px;
            width: 100%;
            cursor: pointer;
        }

        </style>

        @yield('page-styles')
    </head>

    <body>
        <!-- HEADER -->
        @include('layouts.frontend.partial.header')

        <!-- CONTENT -->
        @yield('content')

        <!-- FOOTER -->
        @include('layouts.frontend.partial.footer')

        <!-- COPYRIGHT -->
        @include('layouts.frontend.partial.copyright')

        <!-- MODALS -->
        @include('layouts.frontend.partial.modals.auth')
        @include('layouts.frontend.partial.modals.notification')

        
        <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('frontend/js/main.js') }}"></script>

        <script>
            $(window).on('load', function() {
               
               @if(session('toastr'))
                  toastr.info('{{ session('toastr') }}');
               @endif
               
            })

        </script>

        

        <!-- VUE Components -->
        @include('layouts.frontend.partial.vue.components')

        @yield('page-scripts')
    </body>

</html>