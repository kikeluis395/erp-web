<div class="row col-12 px-0 my-3">
    <div class="row col-sm-6 col-lg-4">
        <span
              class="font-weight-bold letra-rotulo-detalle col-6 text-right text-uppercase">{{ config('app.rotulo_documento') }}:
        </span> <span id="numDocCliente"
              class="col-6   ">
            @if ($esEditableCot)
                <a id="abrirModificarCliente"
                   href="#"
                   data-toggle="modal"
                   data-target="#modificarClienteModal"> {{ $datosHojaTrabajo->getNumDocCliente() }} &nbsp; <i
                       class="fas fa-edit"></i></a>
            @else {{ $datosHojaTrabajo->getNumDocCliente() }}
            @endif
        </span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CLIENTE: </span> <span id="nombreCliente"
              class="col-6   ">{{ $datosHojaTrabajo->getNombreCliente() }}</span>
        <br>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CONTACTO: </span>
        <span class="col-6">
            @if ($esEditableCot)
                <input id="contacto"
                       name="contacto"
                       type="text"
                       form="formDetallesTrabajo"
                       class="form-control py-0 px-2"
                       style="height: 25px; font-size: 15px"
                       id="contactoInExt"
                       data-validation="required"
                       data-validation-error-msg="Debe especificar el nombre del contacto"
                       data-validation-error-msg-container="#errorContacto"
                       placeholder="Ingrese el nombre del contacto"
                       value="{{ $datosHojaTrabajo->contacto }}">
                <div id="errorContacto"
                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            @else
                {{ $datosHojaTrabajo->contacto }}
            @endif
        </span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TELF. CONTACTO: </span>
        <span class="col-6">
            @if ($esEditableCot)
                <input id="telfContacto"
                       name="telfContacto"
                       type="text"
                       form="formDetallesTrabajo"
                       class="form-control py-0 px-2"
                       style="height: 25px; font-size: 15px"
                       id="telfContactoInExt"
                       data-validation="required"
                       data-validation-error-msg="Debe especificar el teléfono del contacto"
                       data-validation-error-msg-container="#errorTelfContacto"
                       placeholder="Ingrese el teléfono del contacto"
                       value="{{ $datosHojaTrabajo->telefono_contacto }}">
                <div id="errorTelfContacto"
                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            @else
                {{ $datosHojaTrabajo->telefono_contacto }}
            @endif
        </span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">EMAIL CONTACTO: </span>
        <span class="col-6">
            @if ($esEditableCot)
                <input id="correoContacto"
                       name="correoContacto"
                       type="email"
                       form="formDetallesTrabajo"
                       class="form-control py-0 px-2"
                       style="height: 25px; font-size: 15px"
                       id="correoContactoInExt"
                       data-validation=""
                       data-validation-error-msg="Debe especificar el correo del contacto"
                       data-validation-error-msg-container="#errorCorreoContacto"
                       placeholder="Ingrese el correo del contacto"
                       value="{{ $datosHojaTrabajo->email_contacto }}">
                <div id="errorCorreoContacto"
                     class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            @else
                {{ $datosHojaTrabajo->email_contacto }}
            @endif
        </span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MONEDA: </span>
        <span class="col-6">
            @if ($esEditableCot)
                <select name="monedaHT"
                        id="monedaHT"
                        class="form-control py-0 px-2"
                        style="height: 25px; font-size: 15px"
                        form="formDetallesTrabajo"
                        autocomplete="off">
                    <option value="SOLES"
                            @if ($datosHojaTrabajo->moneda == 'SOLES') selected @endif>Soles</option>
                    <option value="DOLARES"
                            @if ($datosHojaTrabajo->moneda == 'DOLARES') selected @endif>Dólares</option>
                </select>
            @else
                {{ $datosHojaTrabajo->moneda }}
            @endif
        </span>
        {{-- <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TELF. CONTACTO 2: </span>
        <span class="col-6">
            @if ($esEditableCot)
                <input id="telfContacto2"
                       name="telfContacto2"
                       type="text"
                       form="formDetallesTrabajo"
                       class="form-control py-0 px-2"
                       style="height: 25px; font-size: 15px"
                       id="telfContactoInExt2"
                       placeholder="Ingrese segundo número de teléfono"
                       value="{{ $datosHojaTrabajo->telefono_contacto2 }}">
            @else
                {{ $datosHojaTrabajo->telefono_contacto2 }}
            @endif
        </span>

        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">CORREO CONTACTO 2: </span>
        <span class="col-6">
            @if ($esEditableCot)
                <input id="correoContacto2"
                       name="correoContacto2"
                       type="text"
                       form="formDetallesTrabajo"
                       class="form-control py-0 px-2"
                       style="height: 25px; font-size: 15px"
                       id="correoContactoInExt2"
                       placeholder="Ingrese segundo correo"
                       value="{{ $datosHojaTrabajo->email_contacto2 }}">
            @else
                {{ $datosHojaTrabajo->email_contacto2 }}
            @endif
        </span> --}}

    </div>
    <div class="row col-sm-6 col-lg-4 align-content-start">
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">COTIZACIÓN: </span> <span
              class="col-6">{{ $datosHojaTrabajo->id_cotizacion }}</span>
        {{-- <br> --}}
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">PLACA: </span> <span class="col-6   ">
            @if ($esEditableCot)<a id="placaVehiculo"
                   href="#"
                   data-toggle="modal"
                   data-target="#modificarVehiculoModal">{{ substr($datosHojaTrabajo->placa_auto, 0, 3) . '-' . substr($datosHojaTrabajo->placa_auto, 3, 3) }}
                &nbsp; <i class="fas fa-edit"></i> </a>@else
                {{ substr($datosHojaTrabajo->placa_auto, 0, 3) . '-' . substr($datosHojaTrabajo->placa_auto, 3, 3) }}
            @endif
        </span>
        {{-- <br> --}}
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MARCA: </span> <span id="marcaVehiculo"
              class="col-6   ">{{ $datosHojaTrabajo->vehiculo->getNombreMarca() }}</span>
        {{-- <br> --}}
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">MODELO TECNICO: </span> <span
              id="modeloTecnicoVehiculo"
              class="col-6   ">{{ $datosHojaTrabajo->vehiculo->getNombreModeloTecnico() }}</span>
        {{-- <br> --}}
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">VIN: </span> <span id="vinVehiculo"
              class="col-6   ">{{ $datosHojaTrabajo->vehiculo->getVin() }}</span>
    </div>
    <div class="row col-sm-6 col-lg-4 align-self-start">
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">FECHA COTIZACIÓN: </span> <span
              class="col-6   ">{{ $datosHojaTrabajo->getFechaRecepcionFormat() }}</span>
        <br>
        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">ASESOR: </span> <span
              class="col-6   ">{{ $datosHojaTrabajo->empleado->nombreCompleto() }}</span>

        <span class="font-weight-bold letra-rotulo-detalle col-6 text-right">TIPO DE CAMBIO: </span> <span
              class="col-6   ">{{ $datosHojaTrabajo->getTC() }}</span>
    </div>
</div>

@include('modals.modificarCliente',["cliente"=>$datosHojaTrabajo->cliente])
@include('modals.modificarVehiculo',["vehiculo"=>$datosHojaTrabajo->vehiculo])
