<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vanee Foods - Samples</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="{{ asset('public/js/all.js') }}"></script>

    <!-- Favicon -->
    <!--link rel="shortcut icon" href="{{ asset('public/images/favicon.png') }}"-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/samples.css') }}" rel="stylesheet">

    <!-- Bootstrap / Core CSS -->
    <link href="{{ asset('public/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/datatables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('public/css/all.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('public/css/global.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">

    <!-- Bootstrap / Core CSS -->
    <link href="{{ asset('public/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/datatables.bootstrap4.min.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Page Content -->
    <div id="page-content-wrapper">
	<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
		<a href="#" class="navbar-brand">
			<img src="{{ asset('public/images/logo.png') }}" width="45" class="d-inline-block align-middle" />
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="navbar-collapse collapse" id="navbarSupportedContent">
			@if (session('authenticated'))

			@else

			@endif
			<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
				<li class="nav-item {{ Request::is('/samples') ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('sample-inventory') }}">Samples <span class="sr-only">(current)</span></a>
				</li>
			</ul>
		</div>
	</nav>
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- JavaScript Assets -->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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
