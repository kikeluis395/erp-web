<div class="form-group form-inline">
  <label for="nroPlacaIn" class="col-sm-6 justify-content-end">Placa: </label>
  <input name="nroPlaca" type="text" class="form-control col-sm-6" id="nroPlacaInModal" data-validation="length" data-validation-length="6" data-validation-error-msg="Debe ingresar una placa de 6 caracteres" data-validation-error-msg-container="#errorPlaca" placeholder="Ingrese el número de placa" maxlength="6" oninput="this.value = this.value.toUpperCase()">
  <div id="errorPlaca" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<fieldset id="infoVehiculo">
  <div class="form-group form-inline">
    <label for="vinIn" class="col-sm-6 justify-content-end">VIN: </label>
    <input name="vin" type="text" class="form-control col-sm-6" id="vinIn" placeholder="Ingrese el VIN" maxlength="17" oninput="this.value = this.value.toUpperCase()">
  </div>
  @if(false)
  <div class="form-group form-inline">
    <label for="motorIn" class="col-sm-6 justify-content-end">Motor: </label>
    <input name="motor" type="text" class="form-control col-sm-6" id="motorIn" placeholder="Ingrese el número de motor" oninput="this.value = this.value.toUpperCase()">
  </div>
  @endif
  <div class="form-group form-inline">
    <label for="marcaAutoIn" class="col-sm-6 justify-content-end">Marca:</label>
    <select name="marcaAuto" id="marcaAutoIn" class="form-control col-sm-6">
      <option value=""></option>
      @foreach ($listaMarcas as $marca)
      <option value="{{$marca->getIdMarcaAuto()}}">{{$marca->getNombreMarca()}}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group form-inline">
    <label for="modeloTecnicoIn" class="col-sm-6 justify-content-end">Modelo Técnico:</label>
    <select name="modeloTecnico" id="modeloTecnicoIn" class="form-control col-sm-6">
      <option value=""></option>
      @foreach ($listaModelosTecnicos as $modeloTecnico)
      <option value="{{$modeloTecnico->id_modelo_tecnico}}">{{$modeloTecnico->nombre_modelo}}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group form-inline">
    <label for="modeloIn"  class="col-sm-6 justify-content-end">Modelo:</label>
    <input name="nombreModelo" type="text" class="form-control col-sm-6" id="modeloIn" placeholder="Ingrese el modelo" maxlength="30" oninput="this.value = this.value.toUpperCase()">
  </div>
  @if(false)
  <div class="form-group form-inline">
    <label for="colorIn" class="col-sm-6 justify-content-end">Color:</label>
    <input name="color" type="text" class="form-control col-sm-6" id="colorIn" placeholder="Ingrese el color" maxlength="30" oninput="this.value = this.value.toUpperCase()">
  </div>
  <div class="form-group form-inline">
    <label for="anhoVehiculoIn" class="col-sm-6 justify-content-end">Año del vehículo:</label>
    <input name="anhoVehiculo" type="text" class="form-control col-sm-6" id="anhoVehiculoIn" placeholder="Ingrese el año" maxlength="4" oninput="this.value = this.value.toUpperCase()">
  </div>
  <div class="form-group form-inline">
    <label for="tipoTransmisionIn" class="col-sm-6 justify-content-end">Tipo de transmisión:</label>
    <select name="tipoTransmision" id="tipoTransmisionIn" class="form-control col-sm-6">
      <option value=""></option>
      <option value="mecanico">MECÁNICA</option>
      <option value="automatico">AUTOMÁTICA</option>
    </select>
  </div>
  <div class="form-group form-inline">
    <label for="tipoCombustibleIn" class="col-sm-6 justify-content-end">Tipo de combustible:</label>
    <select name="tipoCombustible" id="tipoCombustibleIn" class="form-control col-sm-6">
      <option value=""></option>
      <option value="gasolina">GASOLINA</option>
      <option value="gnv-glp">GNV - GLP</option>
      <option value="petroleo">PETRÓLEO</option>
    </select>
  </div>
  @endif
</fieldset>