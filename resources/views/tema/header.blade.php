<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar" id="header_tema">
   <nav class="navbar top-navbar navbar-expand-md navbar-dark">
      <!-- ============================================================== -->
      <!-- Logo -->
      <!-- ============================================================== -->
      <div class="navbar-header">
         <a class="navbar-brand" href=" {{ url('/') }}">
            <!-- Logo icon -->
            <b>
               <!-- Dark Logo icon -->
               <img src="{{ asset('assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
               <!-- Light Logo icon -->
               <img src="{{ asset('img/logo-uns-white.png') }}" alt="homepage" width="35" class="light-logo" />
            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <span>
               <!-- dark Logo text -->
               <img src="{{ asset('assets/images/logo-text.png') }}" alt="homepage" class="dark-logo" />
               <!-- Light Logo text -->
               <span class="title-sidebar">INVENTARIO UNS</span>
            </span>
         </a>
      </div>
      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->
      <div class="navbar-collapse">
         <!-- ============================================================== -->
         <!-- toggle and nav items -->
         <!-- ============================================================== -->
         <ul class="navbar-nav mr-auto">
            <!-- This is  -->
            <li class="nav-item">
               <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)">
                  <i class="fal fa-bars fa-lg"></i>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="fal fa-bars fa-lg"></i>
               </a>
            </li>
         </ul>
         <!-- ============================================================== -->
         <!-- User profile and search -->
         <!-- ============================================================== -->
         <ul class="navbar-nav my-lg-0">
            <!-- ============================================================== -->
            <!-- User Profile -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown u-pro">
               <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="perfil_usuario">
                  {{-- <img src="{{ asset('img/user.jpg') }} " alt="user" class=""> --}} 

                  @if (Auth::user()->rutaimagen == "" || Auth::user()->rutaimagen == null)
                  <img class="img-fluid" src="{{ url('/img/user.jpg') }}">
                  @else
                  <img class="img-fluid" src="/uploads/{{Auth::user()->rutaimagen}}">
                  @endif

                  <span class="hidden-md-down"> {{ Auth::user()->name }} <i class="far fa-angle-down rotate ml-1"></i></span>
               </a>

               <div class="dropdown-menu dropdown-menu-right animated fadeInUp faster">
                  <!-- text-->
                  <a href="javascript:void(0)" class="dropdown-item actualizar_perfil"  id="{{ Auth::user()->id }}" data-toggle="modal" data-target="#modalActualizarUsuario"><i class="fal fa-user mr-1"></i> Mi Perfil</a>
                  <!-- text-->
                  <a href="{{ route('logout') }}" class="dropdown-item"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                     <i class="fal fa-sign-out-alt mr-1"></i> Salir
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     @csrf
                  </form>
               </div>
            </li>
            <!-- ============================================================== -->
            <!-- End User Profile -->
            <!-- ============================================================== -->
         </ul>
      </div>
   </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->