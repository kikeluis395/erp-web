@extends('contabilidadv2.layoutCont')
@section('titulo', 'Reporte - Seguimiento OTs')

@section('content')
    <div style="background: white;padding: 10px">
        <div class="row justify-content-between col-12">
            <h2>Reporte - Seguimiento OT's</h2>
        </div>

        <div id="busquedaForm"
             class="col-12 borde-tabla"
             style="background: white;margin-top:10px">
            <form id="FormObtenerReporteOTs"
                  class="my-3 mr-3"
                  method="GET"
                  action="{{ route('reportes.consulta.cantidadots') }}"
                  value="search">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="local_otIn"
                               class="col-form-label">Local:</label>
                        <select name="local_ot"
                                id="local_otIn"
                                class="form-control col-lg-12 valid"
                                style="width: 100%;"
                                data-validation="length"
                                data-validation-length="min1"
                                data-validation-error-msg="Debe seleccionar una opción"
                                data-validation-error-msg-container="#errorlocal_ot"
                                required="">
                            @foreach ($locales as $local)
                                <option value="{{ $local->id_local }}"
                                        {{ isset(request()->local_ot) && request()->local_ot == $local->id_local ? 'selected' : '' }}>
                                    {{ $local->nombre_local }}</option>
                            @endforeach
                        </select>
                        <div id="errorlocal_ot"
                             class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
                    </div>

                    <div class="col-md-2">
                        <label for="anio_ot"
                               class="col-form-label">Año:</label>
                        <select name="anio_ot"
                                id="anio_otIn"
                                class="form-control col-lg-12 valid"
                                style="width: 100%;"
                                data-validation="length"
                                data-validation-length="min1"
                                data-validation-error-msg="Debe seleccionar una opción"
                                data-validation-error-msg-container="#erroranio_ot"
                                required="">
                            <option value="2021"
                                    {{ isset(request()->anio) && request()->anio == '2021' ? 'selected' : '' }}>2021
                            </option>
                            <option value="2022"
                                    {{ isset(request()->anio) && request()->anio == '2022' ? 'selected' : '' }}>2022
                            </option>
                            <option value="2023"
                                    {{ isset(request()->anio) && request()->anio == '2023' ? 'selected' : '' }}>2023
                            </option>
                            <option value="2024"
                                    {{ isset(request()->anio) && request()->anio == '2024' ? 'selected' : '' }}>2024
                            </option>
                        </select>
                        <div id="erroranio_ot"
                             class="col-sm-8 validation-error-cont text-right no-gutters pr-0 has-success"></div>
                    </div>

                    @php
                        if (!isset($resultadoCantidad)) {
                            $activo1 = '';
                            $activo2 = '';
                            $est_act1 = '';
                            $est_act2 = '';
                            $est_act3 = '';
                            $est_act4 = '';
                            $est_ot = '';
                            $seccion_1 = '';
                            $seccion_2 = '';
                            $proyeccion = '';
                        
                            if ($seccion_1 === '') {
                                $activo1 = 'checked';
                            }
                        
                            if ($seccion_2 === '') {
                                $activo2 = 'checked';
                            }
                        
                            if ($est_ot === '') {
                                $est_act4 = 'checked';
                            }
                        }
                    @endphp

                    <div class="col-md-2"
                         style="top: 10px!important;">
                        <span class="font-weight-bold letra-rotulo-detalle text-left">Sección una | ambas</span>
                        <div class="form-check">
                            <input class="form-check-input valid"
                                   type="checkbox"
                                   name="seccion_1"
                                   value="DYP"
                                   id="defaultCheck1"
                                   {{ $activo1 }}>
                            <label class="form-check-label valid"
                                   for="defaultCheck1">Carrocería y Pintura</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="seccion_2"
                                   value="PREVENTIVO"
                                   id="defaultCheck2"
                                   {{ $activo2 }}>
                            <label class="form-check-label"
                                   for="defaultCheck2">Mecánica</label>
                        </div>
                    </div>

                    <div class="row col-md-3"
                         style="top: 10px!important; margin-right: -50px;">
                        <div style="margin-left: 10px;">
                            <span class="font-weight-bold letra-rotulo-detalle text-left">Tipo de OT</span>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="estado_ot"
                                       value="FACTURADAS"
                                       {{ $est_act1 }}>
                                <label class="form-check-label"
                                       for="flexRadioDefault1">Facturadas</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="estado_ot"
                                       value="CERRADAS"
                                       {{ $est_act2 }}>
                                <label class="form-check-label"
                                       for="flexRadioDefault2">Cerradas</label>
                            </div>
                        </div>

                        <label></label>

                        <div style="margin-left: 20px;">
                            <span class="font-weight-bold letra-rotulo-detalle col-6 text-left"></span>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="estado_ot"
                                       value="ABIERTAS"
                                       {{ $est_act3 }}>
                                <label class="form-check-label"
                                       for="flexRadioDefault1">Abiertas</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="estado_ot"
                                       value="TOTALES"
                                       {{ $est_act4 }}>
                                <label class="form-check-label"
                                       for="flexRadioDefault2">Totales</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2"
                         id="proyeccion"
                         style="top: 34px!important; margin-right: -30px;">
                        <span class="font-weight-bold letra-rotulo-detalle text-left">Proyección</span>
                        <div class="custom-control custom-switch">
                            <input type="checkbox"
                                   class="custom-control-input"
                                   name="proyeccion"
                                   id="customSwitchvp"
                                   {{ $proyeccion ? 'checked' : '' }}>
                            <label class="custom-control-label"
                                   for="customSwitchvp">
                                <div id="switch1vptext"
                                     name="switch1vptext">{{ $proyeccion ? 'PROYECCIÓN' : 'MES EN CURSO' }}</div>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <label class="col-form-label"
                               style="position: relative; margin-bottom: 20px;"></label>
                        <button type="submit"
                                class="btn btn-primary">Generar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (isset($resultadoCantidad))
        @php
            $mes1 = '';
            $mes2 = '';
            $mes3 = '';
            $mes4 = '';
            $mes5 = '';
            $mes6 = '';
            $mes7 = '';
            $mes8 = '';
            $mes9 = '';
            $mes10 = '';
            $mes11 = '';
            $mes12 = '';
            
            $dato1 = '';
            $dato2 = '';
            $dato3 = '';
            $dato4 = '';
            $dato5 = '';
            $dato6 = '';
            $dato7 = '';
            $dato8 = '';
            $dato9 = '';
            $dato10 = '';
            $dato11 = '';
            $dato12 = '';
            
            $clase1 = '';
            $clase2 = '';
            $clase3 = '';
            $clase4 = '';
            $clase5 = '';
            $clase6 = '';
            $clase7 = '';
            $clase8 = '';
            $clase9 = '';
            $clase10 = '';
            $clase11 = '';
            $clase12 = '';
            
            $color1 = '';
            $color2 = '';
            $color3 = '';
            $color4 = '';
            $color5 = '';
            $color6 = '';
            $color7 = '';
            $color8 = '';
            $color9 = '';
            $color10 = '';
            $color11 = '';
            $color12 = '';
            
            if ($mes_actual == '01') {
                $color1 = '#91f1fb!important';
            }
            
            if ($mes_actual == '02') {
                $color2 = '#91f1fb!important';
            }
            
            if ($mes_actual == '03') {
                $color3 = '#91f1fb!important';
            }
            
            if ($mes_actual == '04') {
                $color4 = '#91f1fb!important';
            }
            
            if ($mes_actual == '05') {
                $color5 = '#91f1fb!important';
            }
            
            if ($mes_actual == '06') {
                $color6 = '#91f1fb!important';
            }
            
            if ($mes_actual == '07') {
                $color7 = '#91f1fb!important';
            }
            
            if ($mes_actual == '08') {
                $color8 = '#91f1fb!important';
            }
            
            if ($mes_actual == '09') {
                $color9 = '#91f1fb!important';
            }
            
            if ($mes_actual == '10') {
                $color10 = '#91f1fb!important';
            }
            
            if ($mes_actual == '11') {
                $color11 = '#91f1fb!important';
            }
            
            if ($mes_actual == '12') {
                $color12 = '#91f1fb!important';
            }
        @endphp

        <div style="overflow-y:block;background: white;padding: 0px 10px 10px 10px">
            <div class="table-responsive borde-tabla tableFixHead">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row col-12">
                            <h2>Reporte Seguimiento OT's</h2>
                        </div>
                    </div>

                    <div class="table-cont-single mt-3">
                        <table class="table text-center table-striped table-sm">
                            <thead>
                                <tr class="alert alert-warning">
                                    <th scope="col"
                                        align="left">DÍAS TRANSCURRIDOS</th>
                                    @for ($i = 1; $i <= 12; $i++)
                                        @php
                                            $diasutiles = App\Helper\Helper::getDiasHabiles("$anio_ot-$i-01", "$anio_ot-$i-" . App\Helper\Helper::getDayForDiasHabiles($anio_ot, $anio_actual, $i, $mes_actual, $dia_actual), App\Helper\Helper::getFeriados($anio_ot, $i));
                                        @endphp
                                        <th>
                                            {{ $diasutiles }}
                                        </th>
                                    @endfor
                                </tr>

                                <tr class="alert alert-warning">
                                    <th scope="col"
                                        align="left">DÍAS HÁBILES</th>
                                    @for ($i = 1; $i <= 12; $i++)
                                        @php
                                            $diashabiles = App\Helper\Helper::getDiasHabiles("$anio_ot-$i-01", "$anio_ot-$i-" . cal_days_in_month(CAL_GREGORIAN, $i, $anio_ot), App\Helper\Helper::getFeriados($anio_ot, $i));
                                        @endphp
                                        <th>
                                            {{ $diashabiles }}
                                        </th>
                                    @endfor
                                </tr>

                                <tr class="alert alert-primary">
                                    <th scope="col"
                                        style="background-color: #e9e9e9;">TIPO OT</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color1 }}">
                                        ENE-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color2 }}">
                                        FEB-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color3 }}">
                                        MAR-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color4 }}">
                                        ABR-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color5 }}">
                                        MAY-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color6 }}">
                                        JUN-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color7 }}">
                                        JUL-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color8 }}">
                                        AGO-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color9 }}">
                                        SET-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color10 }}">
                                        OCT-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color11 }}">
                                        NOV-{{ SUBSTR($anio_ot, -2) }}</th>
                                    <th scope="col"
                                        style="background-color: #e9e9e9; background-color:{{ $color12 }}">
                                        DIC-{{ SUBSTR($anio_ot, -2) }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (count($resultadoCantidad))
                                    @foreach ($resultadoCantidad as $resultado)
                                        <tr>
                                            <td style="vertical-align: middle"><b>{{ $resultado->TIPO_OT }}</b></td>
                                            @php
                                                if ($mes_actual == '01' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes1 = ($resultado->ENE / $diasUtiles) * $diasTotales;
                                                    $dato1 = number_format($mes1, 0, ',', '.');
                                                    $clase1 = 'text-danger';
                                                } else {
                                                    $dato1 = $resultado->ENE;
                                                }
                                            @endphp
                                            <td class="{{ $clase1 }}"
                                                style="vertical-align: middle; background-color:{{ $color1 }}">
                                                {{ $dato1 }}</td>

                                            @php
                                                if ($mes_actual == '02' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes2 = ($resultado->FEB / $diasUtiles) * $diasTotales;
                                                    $dato2 = number_format($mes2, 0, ',', '.');
                                                    $clase2 = 'text-danger';
                                                } else {
                                                    $dato2 = $resultado->FEB;
                                                }
                                            @endphp
                                            <td class="{{ $clase2 }}"
                                                style="vertical-align: middle; background-color:{{ $color2 }}">
                                                {{ $dato2 }}</td>

                                            @php
                                                if ($mes_actual == '03' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes3 = ($resultado->MAR / $diasUtiles) * $diasTotales;
                                                    $dato3 = number_format($mes3, 0, ',', '.');
                                                    $clase3 = 'text-danger';
                                                } else {
                                                    $dato3 = $resultado->MAR;
                                                }
                                            @endphp
                                            <td class="{{ $clase3 }}"
                                                style="vertical-align: middle; background-color:{{ $color3 }}">
                                                {{ $dato3 }}</td>

                                            @php
                                                if ($mes_actual == '04' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes4 = ($resultado->ABR / $diasUtiles) * $diasTotales;
                                                    $dato4 = number_format($mes4, 0, ',', '.');
                                                    $clase4 = 'text-danger';
                                                } else {
                                                    $dato4 = $resultado->ABR;
                                                }
                                            @endphp
                                            <td class="{{ $clase4 }}"
                                                style="vertical-align: middle; background-color:{{ $color4 }}">
                                                {{ $dato4 }}</td>

                                            @php
                                                if ($mes_actual == '05' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes5 = ($resultado->MAY / $diasUtiles) * $diasTotales;
                                                    $dato5 = number_format($mes5, 0, ',', '.');
                                                    $clase5 = 'text-danger';
                                                } else {
                                                    $dato5 = $resultado->MAY;
                                                }
                                            @endphp
                                            <td class="{{ $clase5 }}"
                                                style="vertical-align: middle; background-color:{{ $color5 }}">
                                                {{ $dato5 }}</td>

                                            @php
                                                if ($mes_actual == '06' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes6 = ($resultado->JUN / $diasUtiles) * $diasTotales;
                                                    $dato6 = number_format($mes6, 0, ',', '.');
                                                    $clase6 = 'text-danger';
                                                } else {
                                                    $dato6 = $resultado->JUN;
                                                }
                                            @endphp
                                            <td class="{{ $clase6 }}"
                                                style="vertical-align: middle; background-color: {{ $color6 }}">
                                                {{ $dato6 }}</td>

                                            @php
                                                if ($mes_actual == '07' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes7 = ($resultado->JUL / $diasUtiles) * $diasTotales;
                                                    $dato7 = number_format($mes7, 0, ',', '.');
                                                    $clase7 = 'text-danger';
                                                } else {
                                                    $dato7 = $resultado->JUL;
                                                }
                                            @endphp
                                            <td class="{{ $clase7 }}"
                                                style="vertical-align: middle; background-color: {{ $color7 }}">
                                                {{ $dato7 }}</td>

                                            @php
                                                if ($mes_actual == '08' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes8 = ($resultado->AGO / $diasUtiles) * $diasTotales;
                                                    $dato8 = number_format($mes8, 0, ',', '.');
                                                    $clase8 = 'text-danger';
                                                } else {
                                                    $dato8 = $resultado->AGO;
                                                }
                                            @endphp
                                            <td class="{{ $clase8 }}"
                                                style="vertical-align: middle; background-color: {{ $color8 }}">
                                                {{ $dato8 }}</td>

                                            @php
                                                if ($mes_actual == '09' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes9 = ($resultado->SEP / $diasUtiles) * $diasTotales;
                                                    $dato9 = number_format($mes9, 0, ',', '.');
                                                    $clase9 = 'text-danger';
                                                } else {
                                                    $dato9 = $resultado->SEP;
                                                }
                                            @endphp
                                            <td class="{{ $clase9 }}"
                                                style="vertical-align: middle; background-color: {{ $color9 }}">
                                                {{ $dato9 }}</td>

                                            @php
                                                if ($mes_actual == '10' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes10 = ($resultado->OCT / $diasUtiles) * $diasTotales;
                                                    $dato10 = number_format($mes10, 0, ',', '.');
                                                    $clase10 = 'text-danger';
                                                } else {
                                                    $dato10 = $resultado->OCT;
                                                }
                                            @endphp
                                            <td class="{{ $clase10 }}"
                                                style="vertical-align: middle; background-color: {{ $color10 }}">
                                                {{ $dato10 }}</td>

                                            @php
                                                if ($mes_actual == '11' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes11 = ($resultado->NOV / $diasUtiles) * $diasTotales;
                                                    $dato11 = number_format($mes11, 0, ',', '.');
                                                    $clase11 = 'text-danger';
                                                } else {
                                                    $dato11 = $resultado->NOV;
                                                }
                                            @endphp
                                            <td class="{{ $clase11 }}"
                                                style="vertical-align: middle; background-color: {{ $color11 }}">
                                                {{ $dato11 }}</td>

                                            @php
                                                if ($mes_actual == '12' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes12 = ($resultado->DIC / $diasUtiles) * $diasTotales;
                                                    $dato12 = number_format($mes12, 0, ',', '.');
                                                    $clase12 = 'text-danger';
                                                } else {
                                                    $dato12 = $resultado->DIC;
                                                }
                                            @endphp
                                            <td class="{{ $clase12 }}"
                                                style="vertical-align: middle; background-color: {{ $color12 }}">
                                                {{ $dato12 }}</td>
                                        </tr>
                                    @endforeach

                                    @foreach ($resultadoTotal as $result)
                                        <tr>
                                            <td style="vertical-align: middle"><b>TOTAL</b></td>
                                            @php
                                                if ($mes_actual == '01' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes1 = ($result->T_ENE / $diasUtiles) * $diasTotales;
                                                    $dato1 = number_format($mes1, 0, ',', '.');
                                                    $clase1 = 'text-danger';
                                                } else {
                                                    $dato1 = $result->T_ENE;
                                                }
                                            @endphp
                                            <td class="{{ $clase1 }}"
                                                style="vertical-align: middle; background-color: {{ $color1 }}">
                                                <b>{{ $dato1 }}</b></td>

                                            @php
                                                if ($mes_actual == '02' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes2 = ($result->T_FEB / $diasUtiles) * $diasTotales;
                                                    $dato2 = number_format($mes2, 0, ',', '.');
                                                    $clase2 = 'text-danger';
                                                } else {
                                                    $dato2 = $result->T_FEB;
                                                }
                                            @endphp
                                            <td class="{{ $clase2 }}"
                                                style="vertical-align: middle; background-color: {{ $color2 }}">
                                                <b>{{ $dato2 }}</b></td>

                                            @php
                                                if ($mes_actual == '03' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes3 = ($result->T_MAR / $diasUtiles) * $diasTotales;
                                                    $dato3 = number_format($mes3, 0, ',', '.');
                                                    $clase3 = 'text-danger';
                                                } else {
                                                    $dato3 = $result->T_MAR;
                                                }
                                            @endphp
                                            <td class="{{ $clase3 }}"
                                                style="vertical-align: middle; background-color: {{ $color3 }}">
                                                <b>{{ $dato3 }}</b></td>

                                            @php
                                                if ($mes_actual == '04' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes4 = ($result->T_ABR / $diasUtiles) * $diasTotales;
                                                    $dato4 = number_format($mes4, 0, ',', '.');
                                                    $clase4 = 'text-danger';
                                                } else {
                                                    $dato4 = $result->T_ABR;
                                                }
                                            @endphp
                                            <td class="{{ $clase4 }}"
                                                style="vertical-align: middle; background-color: {{ $color4 }}">
                                                <b>{{ $dato4 }}</b></td>

                                            @php
                                                if ($mes_actual == '05' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes5 = ($result->T_MAY / $diasUtiles) * $diasTotales;
                                                    $dato5 = number_format($mes5, 0, ',', '.');
                                                    $clase5 = 'text-danger';
                                                } else {
                                                    $dato5 = $result->T_MAY;
                                                }
                                            @endphp
                                            <td class="{{ $clase5 }}"
                                                style="vertical-align: middle; background-color: {{ $color5 }}">
                                                <b>{{ $dato5 }}</b></td>

                                            @php
                                                if ($mes_actual == '06' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes6 = ($result->T_JUN / $diasUtiles) * $diasTotales;
                                                    $dato6 = number_format($mes6, 0, ',', '.');
                                                    $clase6 = 'text-danger';
                                                } else {
                                                    $dato6 = $result->T_JUN;
                                                }
                                            @endphp
                                            <td class="{{ $clase6 }}"
                                                style="vertical-align: middle; background-color: {{ $color6 }}">
                                                <b>{{ $dato6 }}</b></td>

                                            @php
                                                if ($mes_actual == '07' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes7 = ($result->T_JUL / $diasUtiles) * $diasTotales;
                                                    $dato7 = number_format($mes7, 0, ',', '.');
                                                    $clase7 = 'text-danger';
                                                } else {
                                                    $dato7 = $result->T_JUL;
                                                }
                                            @endphp
                                            <td class="{{ $clase7 }}"
                                                style="vertical-align: middle; background-color: {{ $color7 }}">
                                                <b>{{ $dato7 }}</b></td>

                                            @php
                                                if ($mes_actual == '08' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes8 = ($result->T_AGO / $diasUtiles) * $diasTotales;
                                                    $dato8 = number_format($mes8, 0, ',', '.');
                                                    $clase8 = 'text-danger';
                                                } else {
                                                    $dato8 = $result->T_AGO;
                                                }
                                            @endphp
                                            <td class="{{ $clase8 }}"
                                                style="vertical-align: middle; background-color: {{ $color8 }}">
                                                <b>{{ $dato8 }}</b></td>

                                            @php
                                                if ($mes_actual == '09' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes9 = ($result->T_SEP / $diasUtiles) * $diasTotales;
                                                    $dato9 = number_format($mes9, 0, ',', '.');
                                                    $clase9 = 'text-danger';
                                                } else {
                                                    $dato9 = $result->T_SEP;
                                                }
                                            @endphp
                                            <td class="{{ $clase9 }}"
                                                style="vertical-align: middle; background-color: {{ $color9 }}">
                                                <b>{{ $dato9 }}</b></td>

                                            @php
                                                if ($mes_actual == '10' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes10 = ($result->T_OCT / $diasUtiles) * $diasTotales;
                                                    $dato10 = number_format($mes10, 0, ',', '.');
                                                    $clase10 = 'text-danger';
                                                } else {
                                                    $dato10 = $result->T_OCT;
                                                }
                                            @endphp
                                            <td class="{{ $clase10 }}"
                                                style="vertical-align: middle; background-color: {{ $color10 }}">
                                                <b>{{ $dato10 }}</b></td>

                                            @php
                                                if ($mes_actual == '11' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes11 = ($result->T_NOV / $diasUtiles) * $diasTotales;
                                                    $dato11 = number_format($mes11, 0, ',', '.');
                                                    $clase11 = 'text-danger';
                                                } else {
                                                    $dato11 = $result->T_NOV;
                                                }
                                            @endphp
                                            <td class="{{ $clase11 }}"
                                                style="vertical-align: middle; background-color: {{ $color11 }}">
                                                <b>{{ $dato11 }}</b></td>

                                            @php
                                                if ($mes_actual == '12' && $anio_actual == $anio_ot && $proyeccion == true) {
                                                    $mes12 = ($result->T_DIC / $diasUtiles) * $diasTotales;
                                                    $dato12 = number_format($mes12, 0, ',', '.');
                                                    $clase12 = 'text-danger';
                                                } else {
                                                    $dato12 = $result->T_DIC;
                                                }
                                            @endphp
                                            <td class="{{ $clase12 }}"
                                                style="vertical-align: middle; background-color: {{ $color12 }}">
                                                <b>{{ $dato12 }}</b></td>
                                        </tr>
                                    @endforeach

                                @else
                                    <tr>
                                        <td align="center"
                                            scope="col"
                                            colspan=12
                                            class="mensajeError"><strong>No se encontraron resultados</strong></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                @if (isset($resultadoCantidad))
                    <div class="alert alert-primary"
                         role="alert"
                         align="center">
                        <h5>Información actualizada al {{ $fechaActual }} a las {{ date('h:i a', strtotime($date)) }}
                        </h5>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
