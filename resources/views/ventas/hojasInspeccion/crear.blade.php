@extends('repuestos.repuestosCanvas')
@section('titulo','PDI Checklist')

@section('pretable-content')

<div id="containerMec" class="mx-auto" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
    <div class="row justify-content-between col-12">
        <h2 class="ml-3 mt-3 mb-0">PDI Checklist</h2>
        <div class="justify-content-end">
            <a href="{{url()->previous()}}"><button type="button" class="btn btn-info mt-4">Regresar</button></a>
        </div>
    </div>
    <p class="ml-3 mt-3 mb-4"></p>
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #435e7c;">
                        <h4 class="mb-0 text-white">FOR - 001 - AUT</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" id="hojaInspeccionForm" method="POST" action="{{route('hojaInspeccion.store')}}" role="form"  autocomplete="off">
                            @csrf

                            @include('ventas.hojasInspeccion.hojaInspeccion', [
                                '_data' => [
                                    'id_recepcion_ot' => old('id_recepcion_ot'),
                                    'modelo' => old('modelo'),
                                    'ano_modelo' => old('ano_modelo'),
                                    'vin' => old('vin'),
                                    'color' => old('color'),
                                    'color' => old('color'),
                                    'inspector' => old('color'),
                                    'destino' => old('destino'),
                                    'elementosGroupedByGroup' => $elementosGroupedByGroup,
                                    'estado' => \App\Modelos\Ventas\EstadoHojaInspeccion::inspeccionSavar()->getNombre()
                                ],
                                '_usuarioSavar' => $usuarioSavar,
                                '_usuarioDealer' => null,
                                '_gruposElemento' => $gruposElemento
                            ])
                            
                            <br>

                            <div class="row justify-content-end">
                                <button class="btn btn-success justify-content-end mr-3" disabled>
                                 Imprimir PDI
                                </button>
                                <button type="submit" class="btn btn-primary justify-content-end mr-3" id="btn_crear_hojainspeccion" type="submit" >
                                 Guardar PDI
                                </button>
                            </div>
                            
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
    
</div>
<style>
    /* .nav {
    overflow-x: auto;
    overflow-y: hidden;
    height: 115px;
    }

    .nav-item {
    cursor: pointer;
    margin: 15px 10px;
    width: 150px;
    height: 80px;
    box-shadow: 0 4px 6px -6px #222;
    }

    .nav-link {
    margin:5px 0;
    font-size: 14px;
    text-align: center;
    }

    .nav-item.selected {
    color: #fff;
    background-color: #007bff;
    }

    .tab-pane {
        padding-left:33%!important;
    }

    #seccion-preparacion-pdi {
        display: none;
    }
    #seccion-debajo-del-cofre-motor-apagado {
        display: none;
    }
    #seccion-exterior {
        display: none;
    }
    #seccion-debajo-del-vehiculo{
        display: none;
    }
    #seccion-interior-motor-encendido {
        display: none;
    }
    #seccion-interior-motor-apagado {
        display: none;
    }
    #seccion-debajo-del-cofre-motor-encendido {
        display: none;
    }
    #seccion-inspeccion-final {
        display: none;
    } */

    .checkbox-teal [type="checkbox"]:checked+label:before {
    border-color: transparent #009688 #009688 transparent;
    }

    .checkbox-warning-filled [type="checkbox"][class*='filled-in']:checked+label:after {
    border-color: #FF8800;
    background-color: #FF8800;
    }

    .checkbox-rounded [type="checkbox"][class*='filled-in']+label:after {
    border-radius: 50%;
    }

    .checkbox-living-coral-filled [type="checkbox"][class*='filled-in']:checked+label:after {
    border-color: #FF6F61;
    background-color: #FF6F61;
    }

    .checkbox-cerulean-blue-filled [type="checkbox"][class*='filled-in']:checked+label:after {
    border-color: #92aad0;
    background-color: #92aad0;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
        padding: 12px 15px;
        vertical-align: middle;
        text-align: initial!important;
    }


</style>
{{session(['message' => ''])}}
@endsection


@section('extra-scripts')
  @parent
  <script src="{{asset('js/hoja_inspeccion.js')}}"></script>
@endsection