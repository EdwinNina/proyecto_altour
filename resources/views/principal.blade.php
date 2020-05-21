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
  <link href="css/app.css" rel="stylesheet" />
  <link href="css/plantilla.css" rel="stylesheet" />
</head>

<body id="page-top">
	<div id="app">
		<div id="wrapper">
			<!-- Sidebar -->
			<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
				<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
				  <div class="sidebar-brand-icon">
					<img src="img/logo2.png">
				  </div>
				  <div class="sidebar-brand-text mx-3">RuangAdmin</div>
				</a>
				<hr class="sidebar-divider my-0">
				<li class="nav-item active">
				  <a class="nav-link" href="/principal" @click.prevent="menu=0">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Dashboard</span></a>
				</li>
				<hr class="sidebar-divider">
				<div class="sidebar-heading">
				  Features
				</div>
				<li class="nav-item">
				  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
					aria-expanded="true" aria-controls="collapseBootstrap">
					<i class="far fa-fw fa-window-maximize"></i>
					<span>Bootstrap UI</span>
				  </a>
				  <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
					  <h6 class="collapse-header">Bootstrap UI</h6>
					  <a class="collapse-item" href="alerts.html">Alerts</a>
					  <a class="collapse-item" href="buttons.html">Buttons</a>
					</div>
				  </div>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="/categorias" @click.prevent="menu=1">
					<i class="fab fa-fw fa-wpforms"></i>
					<span>Categorias</span>
				  </a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="ui-colors.html">
					<i class="fas fa-fw fa-palette"></i>
					<span>UI Colors</span>
				  </a>
				</li>
		  
				<hr class="sidebar-divider">
				<div class="version" id="version-ruangadmin"></div>
			  </ul>
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
							<img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 60px">
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
						<span>developed by
							<b><a href="https://indrijunanda.gitlab.io/" target="_blank">indrijunanda</a></b>
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

	<script src="js/app.js"></script>
	<script src="js/plantilla.js"></script>
</body>
</html>