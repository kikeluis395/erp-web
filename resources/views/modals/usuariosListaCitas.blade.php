<style>
    .table_costo_mensual td {
        padding: 5px 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.068)
    }

</style>
<div class="modal fade"
     id="crearST"
     tabindex="-1"
     role="dialog"
     aria-labelledby="crearSTLabel"
     aria-hidden="true">

    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title"
                    id="editarSTLabel">ASESORES DE SERVICIO: ACCESO A CITAS</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">
                <form id="FormGuardarAccesos"
                      method="POST"
                      action="{{ route('dealer.accesos') }}"
                      autocomplete="off">
                    @csrf
                    <div class="row justify-content-center">
                        <table class="table_costo_mensual">
                            <thead>
                                <th style="text-align: center; padding: 10px 20px">ASESOR</th>
                                <th style="text-align: center; padding: 10px 20px">ACTIVO</th>
                            </thead>
                            <tbody>
                                @foreach ($asesores as $asesor)
                                    @php
                                        $mapeo = $accesos["I$asesor->id_usuario"];
                                        $habilitado = 0;
                                        if (!is_null($mapeo)) {
                                            $habilitado = $mapeo->habilitado;
                                        }
                                        
                                    @endphp
                                    <tr>
                                        <td align="center"
                                            width="200">{{ strtoupper($asesor->username) }}</td>
                                        <td align="center"
                                            width="200"
                                            style="padding: 0px;">
                                            <input class="form-check-input mt-0 asesor_check"
                                                   type="checkbox"
                                                   {{-- form="FormGuardarAccesos" --}}
                                                   name="ACC-{{ $asesor->id_usuario }}"
                                                   value="M"
                                                   style="margin-top: -8px !important; margin-left: -8px; height: 18px; width: 18px;"
                                                   {{ $habilitado === 1 ? 'checked' : '' }}>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary rounded-pill px-4 py-2"
                        data-dismiss="modal"
                        id="closeREG">Cerrar</button>
                <button type="submit"
                        class="btn btn-primary rounded-pill px-4 py-2"
                        form="FormGuardarAccesos"
                        id="saveREG">Registrar</button>

            </div>
        </div>
    </div>
</div>
