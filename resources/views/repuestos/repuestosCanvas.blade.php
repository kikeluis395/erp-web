@extends('header')

@section('header-content')
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
                <div class="mx-3">
                  @yield('pretable-content')
                </div>
                @yield('table-content')
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
    <script src="{{asset('js/autorefresh.js')}}"></script>
  @endif
@endsection