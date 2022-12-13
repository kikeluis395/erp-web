@extends('tableCanvas')
@section('titulo','Administracion - Tipo de Daño')


@section('table-content')
<div style="background-color:white;">
  <div class="pl-3">
    <h3 class="pt-3">Datos de Tipo de Daño</h3>
    <button class="btn btn-primary" form="tipoDanho" type="submit" value="Submit">Guardar</button>
  </div>

  <form id="tipoDanho" method="POST" action="{{route('tipoDanho.store')}}" value="Submit" autocomplete="off">
    @csrf
    <div class="col-12 row pt-3">
      <div class="col-12">
        <table class="table text-center table-sm col-xl-6">
          <thead>
            <tr>
              <th></th>
              <th>Horas MO</th>
              <th>Paños de Pintura</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>Criterio de Daño</th>
              <th>Mínimo</th>
              <th>Mínimo</th>
            </tr>
            <tr>
              <td>Leve</td>
              <td><input name="min-mo-leve" value="{{round($horasMin[0]->horas_min_mo,2)}}"></td>
              <td><input name="min-panho-leve" value="{{round($horasMin[0]->horas_min_panhos,2)}}"></td>
            </tr>
            <tr>
              <td>Medio</td>
              <td><input name="min-mo-medio" value="{{round($horasMin[1]->horas_min_mo,2)}}"></td>
              <td><input name="min-panho-medio" value="{{round($horasMin[1]->horas_min_panhos,2)}}"></td>
            </tr>
            <tr>
              <td>Fuerte</td>
              <td><input name="min-mo-fuerte" value="{{round($horasMin[2]->horas_min_mo,2)}}"></td>
              <td><input name="min-panho-fuerte" value="{{round($horasMin[2]->horas_min_panhos,2)}}"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-12">
        <table class="table text-center table-sm  col-xl-6">
          <thead>
            <tr>
              <th>VALOR VENTA HH CAR</th>
              @foreach ($listaAutos as $marcaAuto)
                <th>{{$marcaAuto->getNombreMarca()}}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach ($listaSeguros as $ciaSeguro)
              <tr>
                <td>{{$ciaSeguro->nombre_cia_seguro}}</td>
                @foreach ($listaAutos as $marcaAuto)
                  <td><input name="hhCar-{{$ciaSeguro->id_cia_seguro}}-{{$marcaAuto->getIdMarcaAuto()}}" value="{{$valoresTipoDanho->where('id_cia_seguro',$ciaSeguro->id_cia_seguro)->where('id_marca_auto',$marcaAuto->getIdMarcaAuto())->first() ? round($valoresTipoDanho->where('id_cia_seguro',$ciaSeguro->id_cia_seguro)->where('id_marca_auto',$marcaAuto->getIdMarcaAuto())->first()->costo_hh_car,2):''}}"></td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="col-12">
        <table class="table text-center table-sm  col-xl-6">
          <thead>
            <tr>
              <th>VALOR VENTA PAÑO</th>
              @foreach ($listaAutos as $marcaAuto)
                <th>{{$marcaAuto->getNombreMarca()}}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach ($listaSeguros as $ciaSeguro)
              <tr>
                <td>{{$ciaSeguro->nombre_cia_seguro}}</td>
                @foreach ($listaAutos as $marcaAuto)
                  <td><input name="panhos-{{$ciaSeguro->id_cia_seguro}}-{{$marcaAuto->getIdMarcaAuto()}}"  value="{{$valoresTipoDanho->where('id_cia_seguro',$ciaSeguro->id_cia_seguro)->where('id_marca_auto',$marcaAuto->getIdMarcaAuto())->first() ? round($valoresTipoDanho->where('id_cia_seguro',$ciaSeguro->id_cia_seguro)->where('id_marca_auto',$marcaAuto->getIdMarcaAuto())->first()->costo_panho,2):''}}"></td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </form>
  
</div>
@endsection