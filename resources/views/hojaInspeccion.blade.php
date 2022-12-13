@extends('tableCanvas')
@section('titulo','Hoja de Inspección')

@section('pretable-content')
<div style="background: white;padding: 10px">
  <div class="col-12 mt-2 mt-sm-0">
    <div class="row justify-content-between">
      <h2 class="ml-3 mt-3 mb-4">Detalle de Repuestos</h2>
      <div class="justify-content-end mt-3">
        <input class="btn btn-danger" form="FormRegistrarInspeccion" type="submit" name="ignore" value="NO REGISTRAR">
        <button class="btn btn-warning" form="FormRegistrarInspeccion" value="Submit" type="submit">
          Guardar
        </button>
      </div>
    </div>
</div>
@endsection

@section('table-content')
<div class="box" style="overflow-y:auto;background: white;padding: 0px 10px 10px 10px">
  <form id="FormRegistrarInspeccion" method="POST" action="{{route('inspeccionVehiculo.store')}}" value="Submit">
    @csrf
    <div class="table-responsive borde-tabla tableFixHead">
      <div class="row col-12">
        <div id="inspeccionContainer" class="col-4">
          <div class="card" style="margin-top:10px">
            <div class="card-header" id="categoria-header-A">
              <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#categoria-content-A" aria-expanded="false" aria-controls="categoria-content-A">
                  A. Interior del vehículo
                </button>
              </h2>
            </div>

            <div id="categoria-content-A" class="collapse" aria-labelledby="categoria-A">
              <div class="card-body">
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 0, 14) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}</td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card" style="margin-top:10px">
            <div class="card-header" id="categoria-header-B">
              <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#categoria-content-B" aria-expanded="false" aria-controls="categoria-content-B">
                  B. Exterior del vehículo
                </button>
              </h2>
            </div>

            <div id="categoria-content-B" class="collapse" aria-labelledby="categoria-B">
              <div class="card-body">
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 14, 3) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}</td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card" style="margin-top:10px">
            <div class="card-header" id="categoria-header-C">
              <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#categoria-content-C" aria-expanded="false" aria-controls="categoria-content-C">
                  C. Compartimento del motor
                </button>
              </h2>
            </div>

            <div id="categoria-content-C" class="collapse" aria-labelledby="categoria-C">
              <div class="card-body">
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 17, 9) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}</td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div id="inspeccionContainer" class="col-4">
          <div class="card" style="margin-top:10px">
            <div class="card-header" id="categoria-header-D">
              <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#categoria-content-D" aria-expanded="false" aria-controls="categoria-content-D">
                  D. Fluidos
                </button>
              </h2>
            </div>

            <div id="categoria-content-D" class="collapse" aria-labelledby="categoria-D">
              <div class="card-body">
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 26, 11) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}</td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card" style="margin-top:10px">
            <div class="card-header" id="categoria-header-E">
              <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#categoria-content-E" aria-expanded="false" aria-controls="categoria-content-E">
                  E. Debajo del vehículo
                </button>
              </h2>
            </div>

            <div id="categoria-content-E" class="collapse" aria-labelledby="categoria-E">
              <div class="card-body">
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 37, 12) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}</td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card" style="margin-top:10px">
            <div class="card-header" id="categoria-header-F">
              <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#categoria-content-F" aria-expanded="false" aria-controls="categoria-content-F">
                  F. Batería
                </button>
              </h2>
            </div>

            <div id="categoria-content-F" class="collapse" aria-labelledby="categoria-F">
              <div class="card-body">
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 49, 1) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}:</td>
                    <td class="row justify-content-end mr-1"><input id="valor-{{$elementoInspeccion->getKey()}}" name="valor-{{$elementoInspeccion->getKey()}}" type="text" class="form-control" style="width: 50px;"/> <div>%</div></td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div id="inspeccionContainer" class="col-4">
          <div class="card" style="margin-top:10px">
            <div class="card-header" id="categoria-header-G">
              <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#categoria-content-G" aria-expanded="false" aria-controls="categoria-content-G">
                  G. Neumáticos
                </button>
              </h2>
            </div>

            <div id="categoria-content-G" class="collapse" aria-labelledby="categoria-G">
              <div class="card-body">
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 50, 4) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}</td>
                    <td class="row justify-content-end mr-1"><input id="valor-{{$elementoInspeccion->getKey()}}" name="valor-{{$elementoInspeccion->getKey()}}" type="text" class="form-control" style="width: 50px;"/> <div>mm</div></td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>

                <img src="{{asset('assets/images/indicador-neumaticos.png')}}" style="width: 100%;">
              </div>
            </div>
          </div>

          <div class="card" style="margin-top:10px">
            <div class="card-header" id="categoria-header-H">
              <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#categoria-content-H" aria-expanded="false" aria-controls="categoria-content-H">
                  H. Frenos
                </button>
              </h2>
            </div>

            <div id="categoria-content-H" class="collapse" aria-labelledby="categoria-H">
              <div class="card-body">
                <strong>PASTILLAS</strong>
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 54, 4) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}</td>
                    <td class="row justify-content-end mr-1"><input id="valor-{{$elementoInspeccion->getKey()}}" name="valor-{{$elementoInspeccion->getKey()}}" type="text" class="form-control" style="width: 50px;"/> <div>mm</div></td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
                <img src="{{asset('assets/images/indicador-pastillas.png')}}" style="width: 100%;">

                <strong>DISCOS</strong>
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 58, 4) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}</td>
                    <td class="row justify-content-end mr-1"><input id="valor-{{$elementoInspeccion->getKey()}}" name="valor-{{$elementoInspeccion->getKey()}}" type="text" class="form-control" style="width: 50px;"/> <div>mm</div></td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>

                <strong>ZAPATAS</strong>
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 62, 2) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}</td>
                    <td class="row justify-content-end mr-1"><input id="valor-{{$elementoInspeccion->getKey()}}" name="valor-{{$elementoInspeccion->getKey()}}" type="text" class="form-control" style="width: 50px;"/> <div>mm</div></td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
                <img src="{{asset('assets/images/indicador-zapatas.png')}}" style="width: 100%;">

                <strong>TAMBORES</strong>
                <table class="table table-striped table-sm" style="table-layout:fixed;">
                  <tbody>
                  @foreach (array_slice($listaElementosInspeccion, 64, 2) as $elementoInspeccion)
                  <tr>
                    <td style="width: 35px; padding-right: 0px">{{$elementoInspeccion->id_elemento_inspeccion}}</td>
                    <td>{{$elementoInspeccion->getNombre()}}</td>
                    <td class="row justify-content-end mr-1"><input id="valor-{{$elementoInspeccion->getKey()}}" name="valor-{{$elementoInspeccion->getKey()}}" type="text" class="form-control" style="width: 50px;"/> <div>mm</div></td>
                    <td class="custom-radio" style="background: red;    width: 30px"><input id="a-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="red"/><label class="custom-control-label" for="a-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: yellow; width: 30px"><input id="b-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="yellow"/><label class="custom-control-label" for="b-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                    <td class="custom-radio" style="background: green;  width: 30px"><input id="c-{{$elementoInspeccion->getKey()}}" class="custom-control-input" name="color-{{$elementoInspeccion->getKey()}}" type="radio" value="green"/><label class="custom-control-label" for="c-{{$elementoInspeccion->getKey()}}" style="margin-left: 17px"></label></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('extra-scripts')
  @parent
@endsection