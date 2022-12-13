<button id="btnCerrarCotizacionOT"
        type="button"
        class="btn btn-danger"
        data-toggle="modal"
        data-target="#modalCerrarCotizacionOT"
        data-backdrop="static"
        style="margin-left: 15px"><i class="fas fa-trash"></i></button>
<!-- Modal -->
<div class="modal fade "
     id="modalCerrarCotizacionOT"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-sm"
         role="document">
        <div class="modal-content">
            <div class="modal-header fondo-sigma">
                <h5 class="modal-title">Cerrar Cotización</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"
                 style="max-height: 65vh;overflow-y: auto;">
               <h3>¿Desea finalizar la cotización? </h3>
            </div>

            <div class="modal-footer">
                <div>
                    <form id="formCerrarCotizacion-{{$hojaTrabajo->id_hoja_trabajo}}" method="POST" action="{{route('detalleRepuestos.finalizarCotizacion',['id_hoja_trabajo'=>$hojaTrabajo->id_hoja_trabajo])}}">
                      @csrf
                      <button id="btnFinCot-{{$hojaTrabajo->id_hoja_trabajo}}" type="submit" class="btn btn-warning">Aceptar</button>
                    </form>
                  </div>

                <button type="button"
                        class="btn btn-primary"
                        data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
