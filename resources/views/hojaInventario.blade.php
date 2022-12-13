@extends('tableCanvas')
@section('titulo','Hoja de Inventario') 

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="col-12 mt-2 mt-sm-0">
    <div class="row justify-content-between mt-3 mb-4">
      <h2 class="ml-3">Hoja de Inventario</h2>
      <div class="justify-content-end">
        @if($departamento=="DYP")<a href="{{route('detalle_trabajos.index', ['id_recepcion_ot' => $id_recepcion_ot])}}"><button class="btn btn-primary">Regresar</button></a>@endif
        @if($departamento=="MEC")<a href="{{route('mecanica.detalle_trabajos.index', ['id_recepcion_ot' => $id_recepcion_ot])}}"><button class="btn btn-primary">Regresar</button></a>@endif
        <a>
        <button class="btn btn-warning ml-2" form="FormRegistrarInventario" value="Submit" type="submit">
          Guardar
        </button>
        </a>
      </div>
    </div>
</div>
@endsection

@section('table-content')
<div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <form id="FormRegistrarInventario" method="POST" action="{{route('inventarioVehiculo.store')}}" value="Submit">
    @csrf
    <input type="hidden" name="id_recepcion_ot" value="{{$id_recepcion_ot}}" />
    <input type="hidden" name="departamento" value="{{$departamento}}" />
    <div class="table-responsive borde-tabla tableFixHead col-12">
      <div id="inspeccionContainer" class="row mx-0">
        @foreach(array_keys($listaElementosInventario) as $categoriaElementoInventario)
        <div class="card col-md-6 col-lg-12 px-0" style="margin-top:10px;">
          @if($categoriaElementoInventario)
          <div class="card-header" id="categoria-header-{{$loop->iteration}}">
            <h2 class="mb-0">
              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#categoria-content-{{$loop->iteration}}" aria-expanded="true" aria-controls="categoria-content-{{$loop->iteration}}">
                {{$categoriaElementoInventario}}
              </button>
            </h2>
          </div>
          @else
          <div class="card-header" id="categoria-header-{{$loop->iteration}}">
            <h2 class="mb-0">
              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#categoria-content-{{$loop->iteration}}" aria-expanded="true" aria-controls="categoria-content-{{$loop->iteration}}">
                Inventario General
              </button>
            </h2>
          </div>
          @endif

          <div id="categoria-content-{{$loop->iteration}}" class="collapse show" aria-labelledby="categoria-{{$loop->iteration}}">
            <div class="card-body" style="20px 0px 20px 10px">
              <table class="table table-sm col-12" style="table-layout:fixed">
                <tbody class="row">
                @foreach ($listaElementosInventario["$categoriaElementoInventario"] as $elementoInventario)
                <tr class="col-12 col-lg-6 px-0">
                  <td style="width: 65px">{{$loop->iteration}}</td>
                  <td style="width: 280px">{{$elementoInventario->getNombre()}}</td>
                  @if($elementoInventario->clase=='no_cuantificable')
                  <td style="width: 50px" class="custom-checkbox"><input id="a-{{$elementoInventario->getKey()}}" class="custom-control-input" name="objInv-{{$elementoInventario->getKey()}}" type="checkbox" @if(isset($hojaInventario[$elementoInventario->getKey()]) && $hojaInventario[$elementoInventario->getKey()]) checked @endif/><label class="custom-control-label" for="a-{{$elementoInventario->getKey()}}"></label></td>
                  @elseif($elementoInventario->clase=='cuantificable')
                  <td class="pb-1"><input class="form-control" id="b-{{$elementoInventario->getKey()}}" name="objInvObs-{{$elementoInventario->getKey()}}" type="text" style="width: 50px; height: 25px" value="@if(isset($hojaInventario[$elementoInventario->getKey()])) {{$hojaInventario[$elementoInventario->getKey()]}} @endif" required/></td>
                  @elseif($elementoInventario->clase=='rh-lh')
                  <td style="width: 200px" class="p-0">
                    <table class="table-borderless col-12 p-0">
                    <tbody class="row p-0">
                      <tr class="col-6 p-0 custom-checkbox"><td class="p-0">
                        <!-- <input style="margin-left: 2px" id="a-{{$elementoInventario->getKey()}}" name="{{$elementoInventario->getKey()}}" type="text"/> -->
                        <input id="lh-{{$elementoInventario->getKey()}}" class="custom-control-input" name="objInvLh-{{$elementoInventario->getKey()}}" type="checkbox" @if(isset($hojaInventario[$elementoInventario->getKey()]) && $hojaInventario[$elementoInventario->getKey()]->lh) checked @endif/><label class="custom-control-label" for="lh-{{$elementoInventario->getKey()}}">LH</label>
                      </td></tr>
                      <tr class="col-6 p-0 custom-checkbox"><td class="p-0">
                        <!-- <input id="a-{{$elementoInventario->getKey()}}" name="{{$elementoInventario->getKey()}}" type="text"/> -->
                        <input id="rh-{{$elementoInventario->getKey()}}" class="custom-control-input" name="objInvRh-{{$elementoInventario->getKey()}}" type="checkbox" @if(isset($hojaInventario[$elementoInventario->getKey()]) && $hojaInventario[$elementoInventario->getKey()]->rh) checked @endif/><label class="custom-control-label" for="rh-{{$elementoInventario->getKey()}}">RH</label>
                      </td></tr>
                    </tbody>
                    </table>
                  </td>
                  @endif
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </form>
</div>
@endsection

@section('extra-scripts')
  @parent
@endsection