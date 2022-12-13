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
                        <h4 class="mb-0 text-white">PDI {{$hojaInspeccion->id_hoja_inspeccion}} - [{{$hojaInspeccion->estado}}]</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" id="editHojaInspeccionForm" method="PUT" action="{{route('hojaInspeccion.editAction')}}" role="form" autocomplete="off">
                            @csrf
                            @include('ventas.hojasInspeccion.hojaInspeccion', [
                                '_data' => [
                                    'id_hoja_inspeccion' => $hojaInspeccion->id_hoja_inspeccion,
                                    'id_recepcion_ot' => $hojaInspeccion->id_recepcion_ot,
                                    'modelo' => $hojaInspeccion->modelo,
                                    'ano_modelo' => $hojaInspeccion->ano_modelo,
                                    'vin' => $hojaInspeccion->vin,
                                    'color' => $hojaInspeccion->color,
                                    'color' => $hojaInspeccion->color,
                                    'inspector' => $hojaInspeccion->color,
                                    'destino' => $hojaInspeccion->destino,
                                    'elementosGroupedByGroup' => $hojaInspeccion->elementosInspeccion,
                                    'estado' => $hojaInspeccion->estado
                                ],
                                '_usuarioSavar' => $usuarioSavar,
                                '_usuarioDealer' => $usuarioDealer,
                                '_gruposElemento' => $gruposElemento,
                            ])
                            
                            <br>

                            <div class="row justify-content-end">
                                <!-- @if(!isset($motivo))
                                <button class="btn btn-primary justify-content-end mr-3" form="formGenerarFactura" type="submit" value="Submit2">
                                    Siguiente
                                </button>
                                @endif -->
                                <button type="button" class="btn btn-success justify-content-end mr-3 btn-nota-credito" id="btn-nota-credito" type="button" onclick="alert('Imprimiendo PDI')" disabled>
                                 Imprimir PDI
                                </button>
                                
                                @if(\App\Modelos\Ventas\EstadoHojaInspeccion::isNotCompletado($hojaInspeccion->estado))
                                    <button type="submit" class="btn btn-warning justify-content-end mr-3 btn-nota-credito" id="btn_edit_hojainspeccion" type="submit" >
                                    Guardar PDI
                                   </button>
                                @endif 

                            </div>
                            
                        </form>

                    </div>
                </div>
            </div>
        </div>
    
</div>
<style>
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
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/hoja_inspeccion.js')}}"></script>
@endsection
