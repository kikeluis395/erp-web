@extends('header')

@section('header-content')
<style>
   .disabled .day {
      color: white!important;
   }
</style>
<div class="container-fluid box">
   <div class="row box">
      <div class="box" style="padding: 0;background-color: #efefef;">
         @include('navbar')

         <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
               @include('navbar_side')
            </div>

            <div id="layoutSidenav_content">
               <main>

                  @yield('content')


               </main>
            </div>
         </div>
      </div>

   </div>
</div>

@endsection

@section('extra-scripts')
{{--this layout is refreshable by default--}}
@if( !isset($refreshable) || ($refreshable==true) )
<script src="{{asset('js/contabilidad.js?v='.time())}}"></script>
@endif
<script src="{{asset('scripts/script_crearOC.js') }}"></script>
@endsection