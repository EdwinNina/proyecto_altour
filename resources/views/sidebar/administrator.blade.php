<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
   <a href="index.html" class="sidebar-brand d-flex align-items-center justify-content-center">
      <div class="sidebar-brand-icon">
         <img src="img/logo2.png">
      </div> 
      <div class="sidebar-brand-text mx-3">Altour</div>
   </a>
   <hr class="sidebar-divider my-0">
   <li class="nav-item active">
     <a class="nav-link" href="/principal" @click.prevent="menu=0">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
   </li>
   <hr class="sidebar-divider">
   <div class="sidebar-heading">
     Mantenimiento
   </div>
   <li class="nav-item">
      <a class="nav-link" href="/categorias" @click.prevent="menu=1">
      <i class="fab fa-fw fa-wpforms"></i>
         <span>Categorias</span>
      </a>
   </li>
   <li class="nav-item">
     <a class="nav-link" href="/categorias" @click.prevent="menu=2">
      <i class="fas fa-fw fa-palette"></i>
      <span>Atractivos</span>
     </a>
   </li>		  
   <li class="nav-item">
     <a class="nav-link" href="/categorias" @click.prevent="menu=3">
      <i class="fas fa-fw fa-palette"></i>
      <span>Actividades</span>
     </a>
   </li>   
   <li class="nav-item">
     <a class="nav-link" href="/calendario" @click.prevent="menu=4">
      <i class="fas fa-fw fa-palette"></i>
      <span>Calendario actividades</span>
     </a>
   </li>   
   <li class="nav-item">
     <a class="nav-link" href="/usuarios" @click.prevent="menu=5">
      <i class="fas fa-fw fa-users"></i>
      <span>Usuarios</span>
     </a>
   </li>   
</ul>
