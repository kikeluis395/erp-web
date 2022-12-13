<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-color: #081f2d!important">
    <a class="navbar-brand" href="{{route('/')}}" style="width: 150px">
        <img src="{{asset('assets/images/logo_banner.png')}}" width="125" height="50" class="d-inline-block align-top" alt="" style="margin-right: 10px">
    </a>
    <button class="btn btn-link btn-sm order-0 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" style="color: white;">
        T.C DOLAR: S/ <span id="tipoCambioCobro">{{\App\Modelos\TipoCambio::getTipoCambioCobroActual()}}<span> &nbsp;&nbsp;&nbsp;
        @if(false) USUARIO: {{Auth::user()->empleado->nombreCompleto()}}@endif
    </div>
    
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <div class="d-md-none">
                    <div class="dropdown-item">{{Auth::user()->empleado->nombreCompleto()}}</div>
                    <div class="dropdown-item">T.C DOLAR: S/ <span id="tipoCambioCobro">{{\App\Modelos\TipoCambio::getTipoCambioCobroActual()}}<span></div>
                    <div class="dropdown-divider"></div>
                </div>
                @if(session('moneda')=='USD')
                <a class="dropdown-item" href="{{route('cambiarMoneda', ['target' => 'PEN'])}}">Cambiar a S/</a>
                @elseif(session('moneda')=='PEN')
                <a class="dropdown-item" href="{{route('cambiarMoneda', ['target' => 'USD'])}}">Cambiar a USD</a>
                @endif
                <a class="dropdown-item" href="{{route('resetPassword')}}">Cambiar Contraseña</a>
                <a class="dropdown-item" href="{{route('logout')}}">Cerrar Sesión</a>
            </div>
        </li>
    </ul>
</nav>
