@include('sections.formModificarRepuestoCotizacion')

@if($repuesto->esPedible())

<div id="disponibilidadCont-{{$repuesto->id_item_necesidad_repuestos}}" class="form-group form-inline" @if(!$repuesto->repuesto) hidden_start style="display: none" @endif value="{{$repuesto->repuesto ? $repuesto->repuesto->getStockVirtual($necesidadRepuestos->getIdLocal()) : 0}}">
  <label class="col-sm-6 justify-content-end">Disponibilidad:</label>
  <ul>
    <li>Stock Fisico: <span id="disponibilidadFisica-{{$repuesto->id_item_necesidad_repuestos}}">{{$repuesto->repuesto ? $repuesto->repuesto->getStock($necesidadRepuestos->getIdLocal()) : 0}}</span></li>
    <li>Stock Virtual: <span name="disponibilidadVirtual" id="disponibilidadVirtual-{{$repuesto->id_item_necesidad_repuestos}}">{{$repuesto->repuesto ? $repuesto->repuesto->getStockVirtual($necesidadRepuestos->getIdLocal()) : 0}}</span></li>
  </ul>
  <!-- <div id="disponibilidad-{{$repuesto->id_item_necesidad_repuestos}}" class="col-sm-6 text-left" value="{{$repuesto->repuesto ? $repuesto->repuesto->getStockVirtual($necesidadRepuestos->getIdLocal()) : 0}}"></div> -->
</div>

<div id="importacionCont-{{$repuesto->id_item_necesidad_repuestos}}" class="form-group form-inline" @if( $repuesto->es_importado === null ) hidden_start style="display: none" @endif>
  <label for="importacionIn-{{$repuesto->id_item_necesidad_repuestos}}" class="col-sm-6 justify-content-end">Status Pedido:</label>
  @if($repuesto->getDisponibilidad() == 'EN STOCK')
  <div>@if($repuesto->es_importado === 0)EN STOCK @elseif ($repuesto->es_importado) EN STOCK @endif</div>
  @else
  <select name="esImportacion" id="importacionIn-{{$repuesto->id_item_necesidad_repuestos}}" class="form-control col-sm-6" data-validation="length" onchange="control_status_pedido({{$repuesto->id_item_necesidad_repuestos}})" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorImportacion-{{$repuesto->id_item_necesidad_repuestos}}" value="{{$repuesto->es_importado}}">
    <option value=""></option>
    <option value="0" @if($repuesto->es_importado === 0) selected @endif>EN TRÁNSITO</option>
    <option value="1" @if($repuesto->es_importado) selected @endif>EN IMPORTACIÓN</option>
  </select>
  @endif
  <div id="errorImportacion-{{$repuesto->id_item_necesidad_repuestos}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>

<fieldset id="fechasImportacion-{{$repuesto->id_item_necesidad_repuestos}}" @if($repuesto->es_importado === null || $repuesto->getDisponibilidad() == 'EN STOCK') hidden_start style="display: none" @endif>
<div name="fechaPedidoContainer" class="form-group form-inline">
  <label for="fechaPedidoIn-{{$repuesto->id_item_necesidad_repuestos}}" class="col-sm-6 justify-content-end">Fecha pedido:</label>
  @if($repuesto->fecha_pedido === null)
  <input  name="fechaPedido" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaPedidoIn-{{$repuesto->id_item_necesidad_repuestos}}" placeholder="dd/mm/aaaa" maxlength="10" data-validation="date" data-validation-length="10" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaPedido-{{$repuesto->id_item_necesidad_repuestos}}" autocomplete="off">
  @else
  <div>{{\Carbon\Carbon::parse($repuesto->fecha_pedido)->format('d/m/Y')}}</div>
  @endif
  <div id="errorFechaPedido-{{$repuesto->id_item_necesidad_repuestos}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
<div name="fechaPromesaContainer" id="fechaPromesaRepuestoIn-{{$repuesto->id_item_necesidad_repuestos}}" class="form-group form-inline">
  <label for="fechaPromesaIn-{{$repuesto->id_item_necesidad_repuestos}}" class="col-sm-6 justify-content-end">Fecha promesa:</label>
  @if($repuesto->getDisponibilidad() == 'EN STOCK')
  <div>{{$repuesto->getFechaPromesaCarbon()}}</div>
  @else
  <input  name="fechaPromesa" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaPromesaIn-{{$repuesto->id_item_necesidad_repuestos}}" value="{{$repuesto->getFechaPromesaCarbon()}}" placeholder="dd/mm/aaaa" maxlength="10" data-validation="date" data-validation-length="10" data-validation-format="dd/mm/yyyy" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-error-msg-container="#errorFechaPromesa-{{$repuesto->id_item_necesidad_repuestos}}" autocomplete="off">
  @endif
  <div id="errorFechaPromesa-{{$repuesto->id_item_necesidad_repuestos}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
</fieldset>

@if($repuesto->getDisponibilidad() == 'EN STOCK' )
<div id="fechaEntregaField-{{$repuesto->id_item_necesidad_repuestos}}" class="form-group form-inline">
  <label for="fechaEntregaIn-{{$repuesto->id_item_necesidad_repuestos}}" class="col-sm-6 justify-content-end">Fecha de entrega: </label>
  <input name="fechaEntregaRepuesto" type="text"  autocomplete="off" class="datepicker form-control col-sm-6" id="fechaEntregaIn-{{$repuesto->id_item_necesidad_repuestos}}" min-date="{{$repuesto->getFechaPedidoTexto()}}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-length="10" data-validation-error-msg="Debe ingresar la fecha en el formato dd/mm/aaaa" data-validation-optional="true" data-validation-error-msg-container="#errorFechaEntrega-{{$repuesto->id_item_necesidad_repuestos}}" placeholder="dd/mm/aaaa" maxlength="10" autocomplete="off">
  <div id="errorFechaEntrega-{{$repuesto->id_item_necesidad_repuestos}}" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
</div>
@endif

@if(($repuesto->getDisponibilidad() == 'EN TRÁNSITO' || $repuesto->getDisponibilidad() == 'EN IMPORTACIÓN')) 
<div  id="numPedidoField-{{$repuesto->id_item_necesidad_repuestos}}" class="form-group form-inline">
  <label for="numPedido-{{$repuesto->id_item_necesidad_repuestos}}" class="col-sm-6 justify-content-end">Numero de pedido: </label>
  <input value="{{$repuesto->num_pedido}}" name="numPedido" type="text"  autocomplete="off" class=" form-control col-sm-6" id="numPedido-{{$repuesto->id_item_necesidad_repuestos}}" placeholder="numero pedido" maxlength="50" autocomplete="off">
  
</div>
@endIf

@endif

<script>
// window.addEventListener("load", function(){
//   console.log('xd',$('[name=disponibilidadVirtual]').text());
//     if($('[name=disponibilidadVirtual]').val() > 0){
//       $('[name=disponibilidadVirtual]').val() =  Date.now();
//     }
// });

function control_status_pedido(id){
    

    var divElementFechaPromesaIn = '#fechaPromesaRepuestoIn-'+id;
    var divElementFechasImportacion = '#fechasImportacion-'+id;
    var divElementImportacionIn = '#importacionIn-'+id;
    var valor = $(divElementImportacionIn).val();
		if(valor == 0){   //En transito
			$(divElementFechaPromesaIn).hide();
			$(divElementFechasImportacion).hide();
		}
		else{ //En importacion
      $(divElementFechaPromesaIn).show();
			$(divElementFechasImportacion).show();
		}
	}
</script>