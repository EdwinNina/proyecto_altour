<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>Sistema de Promocion turistica</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('css/app.css')}}" rel="stylesheet" />
  <link href="{{ asset('css/plantilla.css')}}" rel="stylesheet" />
</head>

<body id="page-top">
	<div id="app">
		<div id="wrapper">
			<!-- Sidebar -->
				@include('./sidebar.administrator')
			<!-- Sidebar -->
			<div id="content-wrapper" class="d-flex flex-column">
				<div id="content">
				<!-- TopBar -->
					<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
						<button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
						<i class="fa fa-bars"></i>
						</button>
						<ul class="navbar-nav ml-auto">
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							<img class="img-profile rounded-circle" src="{{ asset('img/boy.png') }}" style="max-width: 60px">
							<span class="ml-2 d-none d-lg-inline text-white small">Maman Ketoprak</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
							<a class="dropdown-item" href="#">
								<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
								Profile
							</a>
							<a class="dropdown-item" href="#">
								<i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
								Settings
							</a>
							<a class="dropdown-item" href="#">
								<i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
								Activity Log
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="login.html">
								<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
								Logout
							</a>
							</div>
						</li>
						</ul>
					</nav>
				<!-- Topbar -->
				<!-- Container Fluid-->
					<div class="container-fluid" id="container-wrapper">
						@yield('content')
					</div>
				<!---Container Fluid-->
				</div>
				<!-- Footer -->
				<footer class="sticky-footer bg-white">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
						<span>Todos los derechos reservados
							<b><a href="#" target="_blank">Altour</a></b>
						</span>
						</div>
					</div>
				</footer>
				<!-- Footer -->
			</div>
		</div>	
	</div>
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>		

	<script src="{{ asset('js/app.js')}}"></script>
	<script src="{{ asset('js/plantilla.js')}}"></script>
</body>
</html>