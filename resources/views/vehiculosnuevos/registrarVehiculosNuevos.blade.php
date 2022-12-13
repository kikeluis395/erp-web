@extends('repuestos.repuestosCanvas')
@section('titulo','Vehiculos Nuevos - Maestro')

@section('table-content')
<div class="mx-3" style="overflow-y:auto;background: white;padding: 15px 10px 10px 15px">
  <div class="row justify-content-between col-12">
    <h2 class="ml-3 mt-3 mb-0">Registro de Vehiculos Nuevos</h2>    
  </div>
  <div class="row">
    <div class=" col-10">
      <p class="ml-3 mt-3 mb-4">Ingrese los datos del modelo comercial para completar el registro</p>
    </div>
    <div class=" col-2">
      <a href="{{route('vehiculonuevo.index')}}"><button type="button" class="btn btn-info">Regresar</button></a>
    </div>
  </div>
  
  
  
  <form class="col-12" id="FormRegistrarRecepcion" method="POST" action="{{route('vehiculonuevo.store')}}" value="Submit" autocomplete="off" onkeydown="return event.key != 'Enter';">
    @csrf
    <div class="row">
      @if($vehiculoNuevo!=null)
      <input style="display:none" value="{{$vehiculoNuevo->id_vehiculo_nuevo}}"  name="id_vehiculo_nuevo" id="id_vehiculo_nuevo" type="text" class="form-control col-12 typeahead repuesto" autocomplete="off" readonly>
      @endIf
      <div class=" col-6">
       
        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="ModeloComercial" class="col-sm-6 justify-content-end">Modelo Comercial: </label>
            <div class="col-4">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->modelo_comercial:''}}"  id="ModeloComercial" type="text" class="form-control col-12 typeahead repuesto" autocomplete="off" readonly>
              <div id="errorCodigo" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
            @if(false)
            <div class="col-1">
              
              <a class ="col-1"><button id="btnBuscarModeloComercialModal" type="button" class="btn btn-info" data-toggle="modal" data-target="#buscarModeloComercial"><i class="fas fa-search"></i></button></a>
              {{-- MODAL --}}


              <div class="modal fade" id="buscarModeloComercial" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header fondo-sigma">
                      <h5 class="modal-title">BUSCAR MODELO COMERCIAL</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                      <form id="formBuscarModeloComercial" method="POST" action="{{route('vehiculonuevo.findModeloComercial')}}" value="Submit">
                        @csrf
                        <div class="form-group row ml-1 col-12">
                          <div class="col-12 col-sm-6">
                            <label for="modeloComercial" class="col-form-label">Modelo Comercial:</label>
                          </div>
                          <div class="col-12 col-sm-6">
                            {{-- <input name="modeloComercial" type="text" class="form-control col-12 typeahead vehiculonuevo" autocomplete="off" tipo="modelosComerciales" id="codigoIn" style="width:100%" data-validation-error-msg="Debe ingresar el código del repuesto" data-validation-error-msg-container="#errorCodigo" placeholder="Ingrese el modelo Comercial" oninput="this.value = this.value.toUpperCase()">
                              <div id="errorCodigo" class="col-12 validation-error-cont text-left no-gutters pr-0"></div> --}}
                          </div>
                        </div>
                                 
                      </form>
                     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button formaction="{{route('vehiculonuevo.findModeloComercial')}}"  type="submit" class="btn btn-primary" >Buscar</button>
                    </div>
                  </div>
                </div>
              </div>
              
              {{-- FIN MODAL --}}
            
            </div>
            @endIf
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="habilitado" class="col-sm-6 justify-content-end">Activo:</label>
            <div class="col-sm-6">
              <select name="habilitado" id="habilitado" class="form-control required col-12" style="width:100%" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" >
                @if($vehiculoNuevo!=null)
                <option @if($vehiculoNuevo->habilitado==1)selected="true"@endIf value="1">Activo</option>
                <option @if($vehiculoNuevo->habilitado==0)selected="true"@endIf value="0">Inactivo</option>       
              @else
              <option value="1">Activo</option>
                <option value="0">Inactivo</option>  
              @endIf
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="idMarca" class="col-sm-6 justify-content-end">Marca:</label>
            <div class="col-sm-6">
              <select  @if($vehiculoNuevo!=null??$vehiculoNuevo!=null) disabled @endIf name="idMarca" id="idMarca" class="form-control required col-12" style="width:100%" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorMarca">
                <option value=""></option>
                @foreach($listaMarcas as $marca)
                @if($vehiculoNuevo!=null)
                <option @if($vehiculoNuevo->id_marca_auto == $marca->id_marca_auto) selected="true"@endIf value="{{$marca->id_marca_auto}}">{{$marca->nombre_marca}}</option>
                @else
                <option value="{{$marca->id_marca_auto}}">{{$marca->nombre_marca}}</option>
                @endIf
               
                @endforeach                
              </select>
              <div id="errorMarca" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label  for="modelo" class="col-sm-6 justify-content-end">Modelo: </label>
            <div class="col-sm-6">
              <input @if($vehiculoNuevo!=null??$vehiculoNuevo!=null) readonly @endIf value="{{$vehiculoNuevo!=null?$vehiculoNuevo->modelo:''}}" name="modelo" type="text" class="form-control col-12" id="modelo" style="width:100%" data-validation="required" data-validation-error-msg="Debe ingresar el modelo" data-validation-error-msg-container="#errorModelo" placeholder="Ingrese el modelo del vehiculo" oninput="this.value = this.value.toUpperCase()">
              <div id="errorModelo" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="version" class="col-sm-6 justify-content-end">Version: </label>
            <div class="col-sm-6">
              <input @if($vehiculoNuevo!=null?$vehiculoNuevo!=null:'') readonly @endIf value="{{$vehiculoNuevo!=null?$vehiculoNuevo->version:''}}"  name="version" type="text" class="form-control col-12" id="version" style="width:100%" data-validation="required" data-validation-error-msg="Debe ingresar la version" data-validation-error-msg-container="#errorVersion" placeholder="Ingrese la version del vehiculo" oninput="this.value = this.value.toUpperCase()">
              <div id="errorVersion" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="carroceria" class="col-sm-6 justify-content-end">Carroceria: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->carroceria:''}}"  name="carroceria" type="text" class="form-control col-12" id="version" style="width:100%" data-validation="required" data-validation-error-msg="Debe llenar el campo carroceria" data-validation-error-msg-container="#errorCarroceria" placeholder="Ingrese la carroceria" >
              <div id="errorCarroceria" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>
        
       
        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="tipo" class="col-sm-6 justify-content-end">Tipo: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->tipo:''}}"  name="tipo" type="text" class="form-control col-12" id="tipo" style="width:100%" data-validation="required" data-validation-error-msg="Debe ingresar el tipo" data-validation-error-msg-container="#errorTipo" placeholder="Ingrese el tipo vehiculo">
              <div id="errorTipo" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="combustible" class="col-sm-6 justify-content-end">Combustible:</label>
            <div class="col-sm-6">
              <select name="combustible" id="combustible" class="form-control required col-12" style="width:100%" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" >
                @if($vehiculoNuevo!=null)
                  <option @if($vehiculoNuevo->combustible == "Gasolina") selected="true"@endIf value="Gasolina">Gasolina</option>
                  <option @if($vehiculoNuevo->combustible == "Petroleo") selected="true"@endIf value="Petroleo">Petróleo</option>       
                @else
                  <option value="Gasolina">Gasolina</option>
                  <option value="Petroleo">Petróleo</option>       
                @endIf
               
              </select>
            </div>
          </div>
        </div>
        
        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="potencia" class="col-sm-6 justify-content-end">Potencia: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->potencia:''}}"  name="potencia" type="number" step="any" class="form-control col-12" tipo="repuestos" id="potencia" style="width:100%"  data-validation-error-msg="Debe ingresar la potencia" data-validation-error-msg-container="#errorPotencia" data-validation="required">
              <div id="errorPotencia" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>
     
        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label value="{{$vehiculoNuevo!=null?$vehiculoNuevo->num_cilindros:''}}"  for="numCilindros" class="col-sm-6 justify-content-end">Num. de cilindros: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->num_cilindros:''}}"  name="numCilindros" type="number" class="form-control col-12" tipo="repuestos" id="numCilindros" style="width:100%" data-validation="number" data-validation-error-msg="Debe ingresar el numero de cilindros" data-validation-error-msg-container="#errorNumCilindros" >
              <div id="errorNumCilindros" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>
  
        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="cilindrada" value="{{$vehiculoNuevo!=null?$vehiculoNuevo->cilindrada:''}}"  class="col-sm-6 justify-content-end">Cilindrada: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->cilindrada:''}}"  name="cilindrada" type="number" step="any" class="form-control col-12" tipo="repuestos" id="potencia" style="width:100%"  data-validation-error-msg="Debe ingresar la cilindrada" data-validation-error-msg-container="#errorCilindrada" data-validation="required">
              <div id="errorCilindrada" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>
     

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="transmision" class="col-sm-6 justify-content-end">Transmisión:</label>
            <div class="col-sm-6">
              <select name="transmision" id="transmision" class="form-control required col-12" style="width:100%" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" >
                @if($vehiculoNuevo!=null)
                <option @if($vehiculoNuevo->transmision == "Mecánica") selected="true"@endIf value="Mecánica">Mecánica</option>
                <option @if($vehiculoNuevo->transmision == "Automática") selected="true"@endIf value="Automática">Automática</option>  
                <option @if($vehiculoNuevo->transmision == "Variable continua") selected="true"@endIf value="Variable continua">Variable continua</option> 
                @else
                <option value="Mecánica">Mecánica</option>
                <option  value="Automática">Automática</option>  
                <option  value="Variable continua">Variable continua</option> 
                @endIf

              </select>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="traccion" class="col-sm-6 justify-content-end">Tracción:</label>
            <div class="col-sm-6">
              <select name="traccion" id="traccion" class="form-control required col-12" style="width:100%" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" >
                @if($vehiculoNuevo!=null)
                  <option @if($vehiculoNuevo->traccion == "4X2") selected="true"@endIf value="4X2">4X2</option>
                  <option @if($vehiculoNuevo->traccion == "4X4") selected="true"@endIf value="4X4">4X4</option>  
                  <option @if($vehiculoNuevo->traccion == "2WD") selected="true"@endIf value="2WD">2WD</option> 
                  <option @if($vehiculoNuevo->traccion == "4WD") selected="true"@endIf value="4WD">4WD</option> 
                @else
                <option value="4X2">4X2</option>
                <option value="4X4">4X4</option>  
                <option value="2WD">2WD</option> 
                <option value="4WD">4WD</option> 
                @endIf
              </select>
            </div>
          </div>
        </div>


        
      </div>


      <div class=" col-6">
       
        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="numRuedas" class="col-sm-6 justify-content-end">Num. ruedas: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->num_ruedas:''}}"  name="numRuedas" id="numRuedas" type="number" class="form-control col-12" tipo="repuestos"  style="width:100%" data-validation="number" data-validation-error-msg="Debe ingresar el numero de cilindros" data-validation-error-msg-container="#errorNumRuedas" >
              <div id="errorNumRuedas" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="numEjes" class="col-sm-6 justify-content-end">Num. Ejes: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->num_ejes:''}}"  name="numEjes" id="numEjes" type="number" class="form-control col-12" tipo="repuestos"  style="width:100%" data-validation="number" data-validation-error-msg="Debe ingresar el numero de ejes" data-validation-error-msg-container="#errorNumEjes" >
              <div id="errorNumEjes" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>
       
        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="distEntreEjes" class="col-sm-6 justify-content-end">Dist. entre Ejes: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->distancia_entre_ejes:''}}"  name="distEntreEjes" id="distEntreEjes" type="number" step="any" class="form-control col-12" tipo="repuestos"  style="width:100%"  data-validation-error-msg="Debe ingresar la distancia entre ejes" data-validation-error-msg-container="#errorDistEntreEjes"data-validation="required">
              <div id="errorDistEntreEjes" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>
        
        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="numPuertas" class="col-sm-6 justify-content-end">Num Puertas: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->num_puertas:''}}"  name="numPuertas" id="numPuertas" type="number" class="form-control col-12" tipo="repuestos"  style="width:100%" data-validation="number" data-validation-error-msg="Debe ingresar el numero de puertas" data-validation-error-msg-container="#errorNumPuertas" >
              <div id="errorNumPuertas" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>
     
        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="numAsientos" class="col-sm-6 justify-content-end">Num Asientos: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->num_asientos:''}}" name="numAsientos" id="numAsientos" type="number" class="form-control col-12" tipo="repuestos"  style="width:100%" data-validation="number" data-validation-error-msg="Debe ingresar el numero de asientos" data-validation-error-msg-container="#errorNumAsientos" >
              <div id="errorNumAsientos" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="capPasajeros" class="col-sm-6 justify-content-end">Cap. Pasajeros: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->cap_pasajeros:''}}"  name="capPasajeros" id="capPasajeros" type="number" class="form-control col-12" tipo="repuestos"  style="width:100%" data-validation="number" data-validation-error-msg="Debe ingresar la capacidad de pasajeros" data-validation-error-msg-container="#errorCapPasajeros" data-validation="required">
              <div id="errorCapPasajeros" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="pesoBruto" class="col-sm-6 justify-content-end">Peso Bruto: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->peso_bruto:''}}"  name="pesoBruto" id="pesoBruto" type="number" step="any" class="form-control col-12" tipo="repuestos"  style="width:100%"  data-validation-error-msg="Debe ingresar el peso en bruto" data-validation-error-msg-container="#errorPesoBruto"data-validation="required">
              <div id="errorPesoBruto" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="pesoNeto" class="col-sm-6 justify-content-end">Peso Neto: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->peso_neto:''}}" required name="pesoNeto" id="pesoNeto" type="number" step="any" class="form-control col-12" tipo="repuestos"  style="width:100%"  data-validation-error-msg="Debe ingresar el peso neto" data-validation-error-msg-container="#errorPesoNeto" data-validation="required">
              <div id="errorPesoNeto" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="cargaUtil" class="col-sm-6 justify-content-end">Carga Útil: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->carga_util:''}}" name="cargaUtil" id="numPuertas" type="number"  step="any" class="form-control col-12" tipo="repuestos"  style="width:100%"  data-validation-error-msg="Debe ingresar la carga util" data-validation-error-msg-container="#errorCargaUtil" data-validation="required">
              <div id="errorCargaUtil" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="alto" class="col-sm-6 justify-content-end">Alto: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->alto:''}}" name="alto" id="alto" type="number" step="any" class="form-control col-12" tipo="repuestos"  style="width:100%"  data-validation-error-msg="Debe ingresar el alto del vehiculo" data-validation-error-msg-container="#errorAlto"data-validation="required">
              <div id="errorAlto" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="largo" class="col-sm-6 justify-content-end">Largo: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->largo:''}}" name="largo" id="largo" type="number" step="any" class="form-control col-12"  style="width:100%"  data-validation-error-msg="Debe ingresar el largo del vehiculo" data-validation-error-msg-container="#errorLargo" data-validation="required">
              <div id="errorLargo" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <div class="form-group form-inline">
            <label for="ancho" class="col-sm-6 justify-content-end">Ancho: </label>
            <div class="col-sm-6">
              <input value="{{$vehiculoNuevo!=null?$vehiculoNuevo->ancho:''}}" name="ancho" type="number" step="any" class="form-control col-12"  style="width:100%"  data-validation-error-msg="Debe ingresar el ancho del vehiculo" data-validation-error-msg-container="#errorAncho" data-validation="required">
              <div id="errorAncho" class="col-12 validation-error-cont text-left no-gutters pr-0"></div>
             
            </div>
          </div>
        </div>
     
        
      </div>
    </div>
    
    <div class="row justify-content-center">
      <button id="btnRegistrarRecepcion" value="Submit" class="btn btn-primary button-disabled-when-cliked"  type="submit" >Registrar</button>
    </div>
  </form>
</div>
@endsection

@section('extra-scripts')
  @parent
  <script src="{{asset('js/recepcion.js')}}"></script>
  <script>
    $("[method='POST']").on('submit',function(e){
      // $("[type='submit']").attr("disabled",true);
      $(".button-disabled-when-cliked").prop('disabled', true);
    });
  
  </script>
@endsection