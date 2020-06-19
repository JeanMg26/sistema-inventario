<aside class="left-sidebar">
   <!-- Sidebar scroll-->
   <div class="scroll-sidebar">
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav">
         <ul id="sidebarnav">

            @if (Auth::user()->hasAnyPermission(['ROL-LISTAR', 'PERMISO-LISTAR', 'USUARIO-LISTAR', 'EQUIPO-LISTAR', 'PERSONAL-LISTAR']))
            <li class="nav-small-cap text-center">------ ADMINISTRACIÓN ------</li>
            @endif

            @can('ROL-LISTAR')
            <li>
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fad fa-user-lock"></i>
                  <span class="hide-menu">Roles</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('roles.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan

            @can('PERMISO-LISTAR')
            <li>
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fad fa-user-shield"></i>
                  <span class="hide-menu">Permisos</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('permisos.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan

            @can('USUARIO-LISTAR')
            <li>
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fad fa-user"></i>
                  <span class="hide-menu">Usuarios</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('usuarios.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan
            
            @can('EQUIPO-LISTAR')
            <li>
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fad fa-users"></i>
                  <span class="hide-menu">Equipos</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('equipos.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan

            @can('PERSONAL-LISTAR')
            <li>
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fad fa-user-tie"></i>
                  <span class="hide-menu">Personal</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('empleados.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan

            @if (Auth::user()->hasAnyPermission(['LOCAL-LISTAR', 'AREA-LISTAR', 'OFICINA-LISTAR']))
            <li class="nav-small-cap text-center">------ UBICACIONES ------</li>
            @endif

            @can('LOCAL-LISTAR')               
            <li>
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fad fa-building"></i>
                  <span class="hide-menu">Locales</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('locales.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan

            @can('AREA-LISTAR')   
            <li>
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-treasure-chest"></i>
                  <span class="hide-menu">Áreas</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('areas.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan

            @can('OFICINA-LISTAR') 
            <li>
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-phone-office"></i>
                  <span class="hide-menu">Oficinas</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('oficinas.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan

            @if (Auth::user()->hasAnyPermission(['COORDINACION-LISTAR', 'SUPERVISION-LISTAR']))
            <li class="nav-small-cap text-center">------ CONTROL ------</li>
            @endif
            
            @can('COORDINACION-LISTAR') 
            <li> 
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-users-class"></i>
                  <span class="hide-menu">Coordinaciones</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('coordinaciones.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan

            @can('SUPERVISION-LISTAR') 
            <li> 
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fad fa-laptop"></i>
                  <span class="hide-menu">Supervisiones</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('supervisiones.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan
            
            @if (Auth::user()->hasAnyPermission(['BIEN-LISTAR', 'CRUCE-LISTAR']))
            <li class="nav-small-cap text-center">------ CAMPO ------</li>
            @endif
            
            @can('BIEN-LISTAR') 
            <li> 
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fad fa-tv"></i>
                  <span class="hide-menu">Bienes</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('bienes.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
                  @can('BIEN-IMPORTAR')
                  <li><a href="{{ route('bienes.excel') }}"><i class="fad fa-dot-circle mr-1"></i>Importar Registros</a></li>
                  @endcan
               </ul>
            </li>
            @endcan

            @can('CRUCE-LISTAR') 
            <li> 
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="far fa-crosshairs"></i>
                  <span class="hide-menu">Cruces</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('cruces.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>
            @endcan
            
            <li> 
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fas fa-location-circle"></i>
                  <span class="hide-menu">Ubicaciones</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('ubicaciones.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>

            <li> 
               <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="fad fa-book"></i>
                  <span class="hide-menu">Catálogo</span>
               </a>
               <ul aria-expanded="false" class="collapse">
                  <li><a href="{{ route('catalogo.index') }}"><i class="fad fa-dot-circle mr-1"></i>Listar</a></li>
               </ul>
            </li>

         </ul>
      </nav>
      <!-- End Sidebar navigation -->
   </div>
   <!-- End Sidebar scroll-->
</aside>