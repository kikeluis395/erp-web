<button id="btnGenerarSolRepuestos" type="button" class="btn btn-warning" data-toggle="modal" data-target="#generarSolRepuestosModal" data-backdrop="static">Solicitar Repuestos</button>
<!-- Modal -->
<div class="modal fade" id="generarSolRepuestosModal" tabindex="-1" role="dialog" aria-labelledby="generarSolRepuestosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondo-sigma">
        <h5 class="modal-title" id="generarSolRepuestosLabel">Solicitud de Repuestos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="FormGenerarSolRepuestos" method="POST" 
        action="{{route('repuestos.store')}}"
        value="Submit" autocomplete="off">
          @csrf
          <input type="hidden" name="idHojaTrabajo" value="{{$datosHojaTrabajo->id_hoja_trabajo}}">
          <fieldset id="seccionForm">
            <div>
              <div class="row justify-content-between" style="padding:0 15px 0 15px">
                <div>
                  Ingrese los repuestos que desea solicitar:
                </div>
                <div>
                  <button id="btnAddLineaSolRepuesto" type="button" class="btn btn-warning">+</button>
                </div>
              </div>
              <table id="tableSolRepuesto" style="display:none">
                <thead>
                  <th scope="col">#</th>
                  <th scope="col">DESCRIPCION</th>
                  <th scope="col">CANTIDAD</th>
                  <th scope="col">ELIMINAR</th>
                </thead>
                <tbody id="tbodySolRepuesto">
                  @if(false)
                  <!-- <tr>
                    <td>1</td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><button id="btnEliminarLineaSolRepuesto" type="button" class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i></button></td>
                  </tr> -->
                  @endif
                </tbody>
              </table>
            </div>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnSubmit" form="FormGenerarSolRepuestos" value="Submit" type="submit" class="btn btn-primary button-disabled-when-cliked">Registrar Cambios</button>
      </div>
    </div>
  </div>
</div>