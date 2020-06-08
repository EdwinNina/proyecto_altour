<!DOCTYPE html>
<html lang="es">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Sistema de Promocion turistica</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ asset('css/app.css')}}" rel="stylesheet" />
	<link href="{{ asset('css/plantilla.css')}}" rel="stylesheet" />
	<link rel="shortcut icon" href="{{ asset('img/favicon.png')}}" />
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
</head>
<body id="page-top">
	<div id="app">
		<div class="container-scroller">
			<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
				<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
					<a class="navbar-brand brand-logo" href="#" @click.prevent="menu=0">ALTOUR</a>
					<a class="navbar-brand brand-logo-mini" href="#" @click.prevent="menu=0"><img src="{{ asset('img/logo-mini.svg')}}" alt="logo" /></a>
				</div>
				<div class="navbar-menu-wrapper d-flex align-items-stretch">
					<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
					<span class="mdi mdi-menu"></span>
					</button>
					<ul class="navbar-nav navbar-nav-right">
					<li class="nav-item nav-profile dropdown">
						<a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
							<div class="nav-profile-img">
							<img src="{{ asset('img/faces/face1.jpg')}}" alt="image">
							<span class="availability-status online"></span>
							</div>
							<div class="nav-profile-text">
							<p class="mb-1 text-black">{{ Auth::user()->name }}</p>
							</div>
						</a>
						<div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
							<a class="dropdown-item" href="{{ route('logout') }}"
								onclick="event.preventDefault();
									document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
					</li>
					</ul>
					<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
					<span class="mdi mdi-menu"></span>
					</button>
				</div>
			</nav>
			<!-- partial -->
			<div class="container-fluid page-body-wrapper">
				<!-- partial:partials/_sidebar.html -->
				@if (Auth::check())
					@if (Auth::user()->role_id == 1)
						@include('sidebar.administrator')  
					@endif
					@if (Auth::user()->role_id == 2)
						@include('sidebar.organizator')
				 	@endif
				@endif
				<!-- partial -->
				<div class="main-panel">
					<div class="content-wrapper">
						@yield('content')
					</div>
					<footer class="footer">
					<div class="d-sm-flex justify-content-center justify-content-sm-between">
						<span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="#" target="_blank">ALTOUR</a>. All rights reserved.</span>
						<span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Sistema de Promocion y gestion Altour <i class="mdi mdi-heart text-danger"></i></span>
					</div>
					</footer>
				</div>
			</div>
		</div>	
	</div>
	<script src="{{ asset('js/app.js')}}"></script>
	<script src="{{ asset('js/plantilla.js')}}"></script>
</body>
</html>