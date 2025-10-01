<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vanee Foods</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="{{ asset('public/js/all.js') }}"></script>

    <!-- Favicon -->
    <!--link rel="shortcut icon" href="{{ asset('public/images/favicon.png') }}"-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!--link href="{{ asset('css/app.css') }}" rel="stylesheet"-->

    <!-- Bootstrap / Core CSS -->
    <link href="{{ asset('public/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--link href="{{ asset('public/css/datatables.min.css') }}" rel="stylesheet"-->
    <link href="{{ asset('public/css/datatables.bootstrap4.min.css') }}" rel="stylesheet">
    <!--link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /-->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <!--link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css"-->

    <!-- Font Awesome -->
    <link href="{{ asset('public/css/all.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('public/css/simple-sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/global.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">


    <!-- Bootstrap / Core CSS -->
    <link href="{{ asset('public/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--link href="{{ asset('public/css/datatables.min.css') }}" rel="stylesheet"-->
    <link href="{{ asset('public/css/datatables.bootstrap4.min.css') }}" rel="stylesheet">
</head>

<body>
    @auth
        @if (Auth::user()->menu_state == "collapse")
            <div class="d-flex toggled" id="wrapper">
        @else
            <div class="d-flex" id="wrapper">
        @endif
    @else
        <div class="d-flex" id="wrapper">
    @endif

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- JavaScript Assets -->
    <!--script src="{{ asset('public/jquery/jquery.min.js') }}"></script-->

    <!--script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script-->

    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable-min.js"></script-->

    <!--script src="{{ asset('public/js/datatables.min.js') }}"></script-->
    <!--script src="{{ asset('public/js/datatables.bootstrap4.min.js') }}"></script-->
    <!--script src="{{ asset('public/js/popper.min.js') }}"></script-->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!--script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script-->
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js" type="text/javascript"></script-->
    <!--script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script-->
    <!--script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

    @yield ('scripts')

    <!-- Menu Toggle Script -->
    <script>
        /*$(".datatable-standard").DataTable({
            "pageLength": 50
        });*/
    </script>
</body>
</html>
