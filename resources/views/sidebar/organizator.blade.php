<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
  <li class="nav-item nav-profile">
    <a href="#" class="nav-link">
      <div class="nav-profile-image">
      <img src="{{ asset('img/faces/face1.jpg')}}" alt="profile">
      <span class="login-status online"></span>
      <!--change to offline or busy as needed-->
      </div>
      <div class="nav-profile-text d-flex flex-column">
      <span class="font-weight-bold mb-2">{{Auth::user()->name}}</span>
      <span class="text-secondary text-small">Adminstrador</span>
      </div>
      <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" @click.prevent="menu=0">
      <span class="menu-title">Dashboard</span>
      <i class="mdi mdi-home menu-icon"></i>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" @click.prevent="menu=1">
      <span class="menu-title">Categorias</span>
      <i class="mdi mdi-contacts menu-icon"></i>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" @click.prevent="menu=2">
      <span class="menu-title">Atractivos</span>
      <i class="mdi mdi-contacts menu-icon"></i>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" @click.prevent="menu=3">
      <span class="menu-title">Lugares turisticos</span>
      <i class="mdi mdi-contacts menu-icon"></i>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#events" aria-expanded="false" aria-controls="events">
      <span class="menu-title">Planificacion Eventos</span>
      <i class="menu-arrow"></i>
      <i class="mdi mdi-lock menu-icon"></i>
    </a>
    <div class="collapse" id="events">
      <ul class="nav flex-column sub-menu">
      <li class="nav-item"> <a class="nav-link" href="#" @click.prevent="menu=4">Actividades</a></li>
      <li class="nav-item"> <a class="nav-link" href="#" @click.prevent="menu=5">Calendario Actividades</a></li>
      </ul>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" @click.prevent="menu=6">
      <span class="menu-title">Lista de turistas</span>
      <i class="mdi mdi-contacts menu-icon"></i>
    </a>
  </li>
  </ul>
</nav>