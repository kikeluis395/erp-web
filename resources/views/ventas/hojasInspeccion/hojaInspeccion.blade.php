<div class="row">
    <input type="hidden" name="id_hoja_inspeccion" value="@if(isset($_data['id_hoja_inspeccion'])){{$_data['id_hoja_inspeccion']}}@endIf">
    <div class="form-group row ml-sm-0 col-md-3">
        <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="id_recepcion_ot"> # OT: </label>
        <div class="col-sm-8">
            <input
                id="id_recepcion_ot"
                name="id_recepcion_ot"
                class="form-control w-100 @if($errors->has('id_recepcion_ot')) {{"is-invalid"}} @endIf"
                type="text"
                value="{{$_data['id_recepcion_ot']}}"
            >
            <i id="e_id_recepcion_ot" class="invalid-feedback d-block">
                @if($errors->has('id_recepcion_ot'))
                    {{$errors->first('id_recepcion_ot')}}
                @endIf
            </i>
        </div>
    </div>

    <div class="form-group row ml-sm-0 col-md-3">
        <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="modelo">Modelo: </label>
        <div class="col-sm-8">
            <input
                id="modelo"
                name="modelo"
                class="form-control w-100"
                type="text"
                value="{{$_data['modelo']}}"
            >
            <i id="e_modelo" class="invalid-feedback d-block">
                @if($errors->has('modelo')) {{$errors->first('modelo')}} @endIf
            </i>
        </div>
    </div>

    <div class="form-group row ml-sm-0 col-md-3">
        <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="ano_modelo">Año Modelo: </label>
        <div class="col-sm-8">
            <input
                id="ano_modelo"
                name="ano_modelo"
                class="form-control w-100"
                type="text"
                value="{{$_data['ano_modelo']}}"
            >
            <i id="e_ano_modelo" class="invalid-feedback d-block">
                @if($errors->has('ano_modelo')) {{$errors->first('ano_modelo')}} @endIf
            </i>
        </div>
    </div>

    <div class="form-group row ml-sm-0 col-md-3">
        <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="vin">VIN: </label>
        <div class="col-sm-8">
            <input
                id="vin"
                name="vin"
                class="form-control w-100"
                type="text"
                value="{{$_data['vin']}}"
            >
            <i id="e_vin" class="invalid-feedback d-block">
                @if($errors->has('vin')) {{$errors->first('vin')}} @endIf
            </i>
        </div>
    </div>

    <div class="form-group row ml-sm-0 col-md-3">
        <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="color">Color: </label>
        <div class="col-sm-8">
            <input
                id="color"
                name="color"
                class="form-control w-100"
                type="text"
                value="{{$_data['color']}}"
            >
            <i id="e_color" class="invalid-feedback d-block">
                @if($errors->has('color')) {{$errors->first('color')}} @endIf
            </i>
        </div>
    </div>

    <div class="form-group row ml-sm-0 col-md-3">
        <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="fecha-traslado">Fecha de traslado: </label>
        <div class="col-sm-8">
            <input id="fecha-traslado" name="fecha-traslado" class="form-control w-100" type="text" disabled>
        </div>
    </div>

    <div class="form-group row ml-sm-0 col-md-3">
        <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="inspector">Inspector: </label>
        <div class="col-sm-8">
            <input id="inspector" name="inspector" class="form-control w-100" type="text" value="{{$_usuarioSavar->username}}" disabled>
        </div>
    </div>
    <div class="form-group row ml-sm-0 col-md-3">
        <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="inspector">Inspector dealer: </label>
        <div class="col-sm-8">
            <input
                id="inspector"
                name="inspector"
                class="form-control w-100"
                type="text"
                disabled
                @if(\App\Modelos\Ventas\EstadoHojaInspeccion::isDealer($_data['estado']) && $_usuarioDealer !== null)
                    value="{{ $_usuarioDealer->username }}"
                @endIf
            >
        </div>
    </div>

    <div class="form-group row ml-sm-0 col-md-3">
        <label class="col-sm-4 col-form-label form-control-label justify-content-end" for="destino">Destino: </label>
        <div class="col-sm-8">
            <input
                id="destino"
                name="destino"
                class="form-control w-100"
                type="text"
                value="{{old('destino')}}"
            >
            <i id="e_destino" class="invalid-feedback d-block">
                @if($errors->has('destino')) {{$errors->first('destino')}} @endIf
            </i>
        </div>
    </div>
    <div class="col-12">
        <div id="alert_success" class="alert alert-success text-center" role="alert" style="display: none;">
            <p class="mb-0"></p>
        </div>
        <div id="alert_error" class="alert alert-danger text-center" role="alert" style="display: none;">
            Ocurrio un error inesperado al hacer el registro
        </div>
    </div>
</div>

<div class="">
    
    <div id="accordion">
        @foreach ($_data['elementosGroupedByGroup'] as $key => $grupo)
        <div class="card">
            <div class="card-header">
                    <button
                        type="button"
                        class="btn btn-link btn-block"
                        data-toggle="collapse"
                        data-target="{{"#__".str_replace(" ","",$key)}}"
                        aria-expanded="true"
                        aria-controls="collapseOne"
                    >
                    <h5 class="mb-0">
                        {{$_gruposElemento[$key][0]->id}} - {{$gruposElemento[$key][0]->nombre}}
                    </h5>
                    </button>
            </div>
            <div
                id="__{{str_replace(" ","",$key)}}"
                class="collapse"
                aria-labelledby=""
                data-parent="#accordion"
            >
                <div class="card-body">
                    <table id="preparacionPDI" class="table text-center table-striped table-sm" style="">
                        <thead>
                            <tr class="d-none">
                                <th scope="col" colspan="3" style="width: 2%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grupo as $index =>  $elementoInspeccion)
                                <tr>
                                    <td>
                                        <div class="container">
                                            <input
                                                class="border border-success"
                                                type="checkbox"
                                                style=" display: block," 
                                                name="elementosInspeccion[{{$elementoInspeccion->id_elemento_inspeccion}}][savar]"
                                                @if(isset($elementoInspeccion->isValidatedSavar))
                                                    @if($elementoInspeccion->isValidatedSavar==true)
                                                        {{"checked"}}
                                                        class=""
                                                    @endif
                                                @endif
                                                {{$_data['estado'] == \App\Modelos\Ventas\EstadoHojaInspeccion::inspeccionSavar()->getNombre()?"":"disabled"}}
                                            >
                                        </div>
                                    </td>
                                    <td>
                                        <input
                                            type="checkbox"
                                            style=" display: block, background-color: green!important;" id="exampleCheck1"
                                            name="elementosInspeccion[{{$elementoInspeccion->id_elemento_inspeccion}}][dealer]"
                                            @if(isset($elementoInspeccion->isValidatedDealer))
                                                @if($elementoInspeccion->isValidatedDealer)
                                                    {{"checked"}}
                                                @endif
                                            @endif
                                            {{$_data['estado'] == \App\Modelos\Ventas\EstadoHojaInspeccion::inspeccionDealer()->getNombre()?"":"disabled"}}
                                        >
                                    </td>
                                    <td>({{($index+1)}}) {{$elementoInspeccion->nombre_elemento_inspeccion}}</td>
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
<style>
input[type=checkbox]
{
    /* Doble-tamaño Checkboxes */
    -ms-transform: scale(2); /* IE */
    -moz-transform: scale(2); /* FF */
    -webkit-transform: scale(2); /* Safari y Chrome */
    -o-transform: scale(2); /* Opera */
    padding: 10px;
}
</style>