<table class="table text-center table-striped table-sm">
	<thead>
		<tr>		  
		  <th scope="col">LOCAL</th>
		  <th scope="col">REGISTRADO POR</th>
		  <th scope="col">FECHA REGISTRO</th>
		  <th scope="col">C. COSTO</th>
		  <th scope="col">TIPO DOCUMENTO</th>
		  <th scope="col">DOCUMENTO</th>  
		  <th scope="col">DOC CLIENTE</th>
		  <th scope="col">CLIENTE</th>
		  <th scope="col">CONDICION DE PAGO</th>
		  <th scope="col">MÉTODO DE PAGO</th>
		  <th scope="col">ENTIDAD FINANCIERA</th>
		  <th scope="col">TIPO TARJETA</th>
		  <th scope="col">NRO OPERACIÓN</th>
		  <th scope="col">TIPO DE OPERACIÓN</th>
		  <th scope="col">DOC REFERENCIA</th>
		  <th scope="col">MONEDA</th>
		  <th scope="col">DETRACCÓN</th>
		  <th scope="col">SUBTOTAL</th>
		  <th scope="col">IMPUESTO</th>
		  <th scope="col">TOTAL</th>
		  <th scope="col">ESTADO</th>		
		  <th scope="col">OBSERVACIONES</th>		
		  <th scope="col">CÓDIGO SUNAT</th>
		  <th scope="col">DESCRIPCIÓN SUNAT</th>
		</tr>
	  </thead>
	  <tbody>
		@foreach ($resultados as $row)
		<tr>		  
		  <td style="vertical-align: middle">{{$row->local}} </td>
		  <td style="vertical-align: middle">{{$row->registrado_por}} </td>
		  <td style="vertical-align: middle">{{$row->fecha_registro}} </td>             
		  <td style="vertical-align: middle">{{$row->centro_costo}} </td>
		  <td style="vertical-align: middle">{{$row->tipo_documento}} </td>
		  <td style="vertical-align: middle">{{$row->documento}} </td>
		  <td style="vertical-align: middle">{{$row->doc_cliente}} </td>
		  <td style="vertical-align: middle">{{$row->cliente}} </td>
		  <td style="vertical-align: middle">{{$row->condicion_pago_texto}} </td>
		  <td style="vertical-align: middle">{{$row->metodo_pago}} </td>
		  <td style="vertical-align: middle">{{$row->entidadFinanciera}} </td>
		  <td style="vertical-align: middle">{{$row->tipoTarjeta}} </td>
		  <td style="vertical-align: middle">{{$row->nro_operacion}} </td>		  
		  <td style="vertical-align: middle">{{$row->tipo_operacion}} </td>
		  <td style="vertical-align: middle">{{$row->doc_referencia_sin_link}} </td>
		  <td style="vertical-align: middle">{{$row->moneda}} </td>
		  <td style="vertical-align: middle">{{$row->detraccion}} </td>
		  <td style="vertical-align: middle">{{$row->subtotal}} </td>
		  <td style="vertical-align: middle">{{$row->impuesto}} </td>
		  <td style="vertical-align: middle">{{$row->total}} </td>
		  <td style="vertical-align: middle">{{$row->estado}} </td>
		  <td style="vertical-align: middle">{{$row->observaciones}} </td>
		  <td style="vertical-align: middle">{{$row->sunat_code}} </td>
		  <td style="vertical-align: middle">{{$row->sunat_description}} </td>
		</tr>
		@endforeach
	  </tbody>
</table>