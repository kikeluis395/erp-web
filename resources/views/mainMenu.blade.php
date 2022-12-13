@extends('header')

@section('header-content')
<div class="container-fluid box">
  <div class="row box">
    <div class="box" style="padding: 0;background-color: #efefef; background-color:white">
      @include('navbar')
      <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
          @include('navbar_side')
        </div>

        <div id="layoutSidenav_content" style="top: 0">
          <main>
            <table style="width: 100%; height: 100vh">
              <td align="center" style="vertical-align: middle">
                <img src="{{asset('assets/images/logo_bienvenida.png')}}"alt="">
                <h1>Bienvenido, @if(Auth::user() && Auth::user()->empleado) {{Auth::user()->empleado->nombreCompleto()}} @endif</h1>
                <h4>Para continuar, presione el botón <span class="bg-dark" style="padding: 5px; color: rgba(255, 255, 255, 0.5); font-size: .875rem;"><i class="fas fa-bars"></i></span> ubicado en la parte superior y seleccione alguna de las opciones</h4>
              </td>
            </table>
          </main>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection