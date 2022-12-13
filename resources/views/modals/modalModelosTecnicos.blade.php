<button id="btnModelosTecnicos"
        type="button"
        class="btn btn-warning"
        data-toggle="modal"
        data-target="#modalModelosTecnicos"
        data-backdrop="static"
        font-weight:
        style="margin-left: 15px"> APLICACIÓN MODELO TÉCNICO  <i class="fas fa-info-circle icono-btn-tabla"></i></button>
<!-- Modal -->
<div class="modal fade "
     id="modalModelosTecnicos"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-lg"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title">Aplicación a modelos</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">
                <table class="table text-center table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Modelo</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelosTecnicos as $modeloTecnico)
                            <tr>
                                <th style="vertical-align: middle"
                                    scope="row">{{ $loop->iteration }}</th>
                                <td>{{$modeloTecnico->nombre_modelo}}</td>  
                                <td><input type="checkbox" name="modeloTecnico-{{$modeloTecnico->id_modelo_tecnico}}" id="modeloTecnico-{{$modeloTecnico->id_modelo_tecnico}}" > </td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button id="btnRegistrarRecepcion2"  value="Submit" type="submit" class="btn btn-primary">Guardar</button>
                <button type="button"
                        class="btn btn-primary"
                        data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
