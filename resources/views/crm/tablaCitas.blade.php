<script>
    var zero = "{!! $zero === true ? '1' : '0' !!}"
    var admin = "{!! $admin === true ? '1' : '0' !!}"
    var opciones = {!! $opciones ? json_encode($opciones) : json_encode((object) []) !!}
</script>

@if (!$zero)
    <table class="table text-center table-striped table-sm tableFixHead"
           style="width: auto;">
        <thead>
            <tr>
                <th style="width: 75px"></th>
                @foreach ($listaAsesores as $asesor)
                    <th style="width: 250px">{{ $asesor->username }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($listaHoras as $hora)
                <tr>
                    <th style="padding: .3rem;">{{ $hora }}</th>
                    @foreach ($listaAsesores as $asesor)
                        <td style="padding:3px;">
                            @if ($asesor[$hora])
                                <a href="#"
                                   data-toggle="modal"
                                   data-target="#infoCita-{{ $asesor->username }}-{{ str_replace(':', '', $hora) }}"
                                   data-backdrop="static"
                                   style="text-decoration: none"
                                   id="seeDate-{{ $asesor->username }}-{{ str_replace(':', '', $hora) }}">

                                    @if ($asesor[$hora]->estado == 'asistio')
                                        <div class="bg-success"
                                             style="@if (false) background-color: green; @endif
                                             width:100%;
                                             height:25px;
                                             color:white;">{{ $asesor[$hora]->placa_vehiculo }} -
                                            {{ strtoupper($asesor[$hora]->getModelo()) }}</div>
                                    @elseif($asesor[$hora]->estado == 'no-asistio')
                                        <div class="bg-danger"
                                             style="@if (false) background-color: red; @endif
                                             width:100%;
                                             height:25px;
                                             color:white;">{{ $asesor[$hora]->placa_vehiculo }} -
                                            {{ strtoupper($asesor[$hora]->getModelo()) }}
                                        </div>
                                    @elseif($asesor[$hora]->estado == 'reservado')
                                        <div class="bg-warning"
                                             style="@if (false) background-color: yellow; @endif
                                             width:100%;
                                             height:25px;
                                             color:white;">{{ $asesor[$hora]->placa_vehiculo }} -
                                            {{ strtoupper($asesor[$hora]->getModelo()) }}
                                        </div>
                                    @endif
                                </a>

                                <div class="modal fade"
                                     id="infoCita-{{ $asesor->username }}-{{ str_replace(':', '', $hora) }}"
                                     tabindex="-1"
                                     role="dialog"
                                     aria-labelledby="confirmarEntregaLabel"
                                     aria-hidden="true">
                                    @include('modals.detalleCita')
                                </div>
                            @elseif( $fechaCarbon->setTimeFromTimeString($hora) >= \Carbon\Carbon::now() &&
                                ($asesor->id_usuario == Auth::user()->id_usuario || Auth::user()->accesoCitas())
                                )

                                <a href="#"
                                   data-toggle="modal"
                                   data-target="#infoCita-{{ $asesor->username }}-{{ str_replace(':', '', $hora) }}"
                                   data-backdrop="static"
                                   style="text-decoration: none;"
                                   class="register_link"
                                   id="registerDate-{{ $asesor->username }}-{{ str_replace(':', '', $hora) }}">
                                    <div class="bg-secondary"
                                         style="@if (false) background-color: gray; @endif
                                         width:100%;
                                         height:25px;
                                         color=white;"></div>
                                </a>
                                <div class="modal fade"
                                     id="infoCita-{{ $asesor->username }}-{{ str_replace(':', '', $hora) }}"
                                     tabindex="-1"
                                     role="dialog"
                                     aria-labelledby="confirmarEntregaLabel"
                                     aria-hidden="true">
                                    @include('modals.registrarCita')
                                </div>
                            @else
                                <a style="text-decoration: none;">
                                    <div class="bg-secondary"
                                         style="@if (false) background-color: gray; @endif
                                         width:100%;
                                         height:25px;
                                         color=white;"></div>
                                </a>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
