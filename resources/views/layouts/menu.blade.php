<!-- Vertical navbar -->
<div class="vertical-nav bg-white border-right" id="sidebar-menu-left">
  <div class="container-fluid">
    <div class="row mt-3">
      <div class="col-sm-12 text-center">        
        <img class="rounded mb-1" src="{{ url('images/p20.png') }}" width="85%">        
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-sm-12">
        <p class="font-weight-normal mt-0 mb-0 text-left ml-3"><strong class="text-muted">Usuario: </strong>{{ Auth::User()->email }}</p>
        <p id="companny_id" class="font-weight-normal mt-0 mb-0 text-left ml-3" hidden="true">{{ Session::get('company_id') }}</p>
        <p class="font-weight-normal text-left ml-3"><strong class="text-muted">Unidad: </strong>{{ Session::get('companyName')}}</p>
      </div>
    </div>
    <hr style="padding:0; margin:0;"></hr>
    <div class="row mt-4">
      <div class="col-sm-12">
        <ul class="nav flex-column">
          @if(Auth::User()->activeRole()==1)
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Dashboard">
              <span data-feather="home" class="mr-3"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Reportes">
              <span data-feather="shopping-cart" class="mr-3"></span>
              Vts por categorías
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="VtsProyectos">
              <span data-feather="layers" class="mr-3"></span>
              Vts por Proyectos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="recuProyectos">
              <span data-feather="layers" class="mr-3"></span>
              Recu por Proyectos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Inventario">
              <span data-feather="truck" class="mr-3"></span>
              Inventario
            </a>
          </li>
          @if(Session::get('companyName')=='UNIMARK')
          <li>
            <a class="nav-link text-secondary" href="InvTotalizado">
              <span data-feather="package" class="mr-3"></span>
              Inv. Totalizado
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Metas">
              <span data-feather="file" class="mr-3"></span>
              Metas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Usuario">
              <span data-feather="users" class="mr-3"></span>
              Usuarios
            </a>
          </li>
          <li>
            <a class="nav-link text-secondary" href="Saldos">
              <span data-feather="dollar-sign" class="mr-3"></span>
              Saldos
            </a>
          </li>
          @if(Session::get('companyName')=='UNIMARK')
          <li>
            <a class="nav-link text-secondary" href="InteligenciaMercado">
              <span data-feather="message-circle" class="mr-3"></span>
              I. M.
            </a>
          </li>
          @endif
          @if(Session::get('companyName')=='UNIMARK' || Session::get('companyName')=='INNOVA')
          <li>
            <a class="nav-link text-secondary" href="Recuperacion">
              <span data-feather="corner-down-left" class="mr-3"></span>
              Recuperación
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link text-secondary" href="MinutasCorporativas">
              <span data-feather="file-text" class="mr-3"></span>
              Minuta Corp
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Proyecciones">
              <span data-feather="crosshair" class="mr-3"></span>
              Proy de ventas
            </a>
          </li>
          @elseif(Auth::User()->activeRole()==2)
          <li class="nav-item">                
            <a class="nav-link text-secondary" href="Dashboard">
              <span data-feather="home" class="mr-3"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Reportes">
              <span data-feather="bar-chart-2" class="mr-3"></span>
              Ventas por categorías
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Inventario">
              <span data-feather="shopping-cart" class="mr-3"></span>
              Inventario
            </a>
          </li>
          <li>
            <a class="nav-link text-secondary" href="Saldos">
              <span data-feather="dollar-sign" class="mr-3"></span>
              Saldos
            </a>
          </li>
          @if(Session::get('companyName')=='UNIMARK')
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Proyecciones">
              <span data-feather="crosshair" class="mr-3"></span>
              Proy de ventas
            </a>
          </li>
          @endif
          @elseif(Auth::User()->activeRole()==3)
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Metas">
              <span data-feather="file" class="mr-3"></span>
              Metas
            </a>
          </li>
          @elseif(Auth::User()->activeRole()==4 )
          @if(Session::get('companyName')=='UNIMARK')
          <li>
            <a class="nav-link text-secondary" href="Recuperacion">
              <span data-feather="corner-down-left" class="mr-3"></span>
              Recuperación
            </a>
          </li>
          @endif
          @elseif(Auth::User()->activeRole()==5)
          <li class="nav-item">
            <a class="nav-link text-secondary" href="Inventario">
              <span data-feather="shopping-cart" class="mr-3"></span>
              Inventario
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link text-danger font-weight-bold" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span data-feather="log-out" class="mr-3"></span> Cerrar sesion
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div id="_version">
  @include('layouts.app_version', array( 'appVersion'=>Auth::User()->gitVersion() ))
</div>