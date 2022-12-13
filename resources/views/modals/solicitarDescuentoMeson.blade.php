<!-- Modal -->
<div class="modal fade" id="modalSolicitarDescuento" tabindex="-3" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document" style="max-width: 600px">
        <div class="modal-content">
        <div class="modal-header fondo-sigma">
            <h5 class="modal-title">Agregar descuentos por categoria</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
     
        <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
            
            <form id="FormSolicitarDescuento" method="POST"  autocomplete="off">
                @csrf
                <input name="idCotizacion" type="hidden" value="{{$cotizacion->id_cotizacion_meson}}">
                {{-- <div class="form-group form-inline">
                    <label for="inputPorcentaje" class="col-sm-8 justify-content-end text-right">Porcentaje Dscto. Lubricantes: </label>
                    <input name="porcentajeSolicitadoLubricantes" type="text" class="form-control col-sm-2 mr-1" id="inputPorcentajeLubricantes" data-validation-optional-if-answered="porcentajeSolicitadoMO, porcentajeSolicitadoRptos" data-validation="number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el porcentaje de descuento de lubricantes" data-validation-error-msg-container="#errorPorcentajeLubricantes"> %
                    <div id="errorPorcentajeLubricantes" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>
                </div> --}}

                <div class="form-group form-inline text-left">
                    <label for="inputPorcentaje" class="col-4 ">LUBRICANTES: </label>
                    <input name="porcentajeSolicitadoLubricantes" type="text" class="form-control col-2 mr-1" id="inputPorcentajeLubricantes"  data-validation="number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el porcentaje de descuento de lubricantes" data-validation-error-msg-container="#errorPorcentajeLubricantes" value="0"> %
                    
                    <a href="#" id="moreLubricants" onClick="showMoreLubricants()" class="link-success fas fa-eye col-2 mr-1"></a>
                
                    <a href="#" id="lessLubricants" onClick="showLessLubricants()" style="display:none" class="fas fa-eye-slash  link-danger col-2 mr-1"> </a>
                
                    <a href="#" class="fas fa-plus" onClick="applyDiscountLubricants()"> Aplicar a todos</a>

                   
                </div>
                <div id="listLubricants" style="display:none">
                    <table >
                        <thead>
                            <tr>
                                <th> Repuesto</th>
                                <th style="width: 220px" > DSCTO. Marca</th>
                                <th style="width: 120px" > DSCTO. Dealer</th>
                            </tr>
                        </thead>
                         <tbody> 
                            @foreach ($repuestosCotizacion as $repuestoSolicitado)
                                <tr>
                                    
                                    @if($repuestoSolicitado->repuesto->getNombreCategoria()=='LUBRICANTES')
                                    <td style="width: 300px">{{$repuestoSolicitado->getDescripcionRepuesto()}}</td>
                                    <td style="width: 120px" class="form-inline">    
                                        <input type="text" class="form-control mr-2"
                                                id="brand-{{ $repuestoSolicitado->id_linea_cotizacion_meson }}"
                                                name="brand-{{$repuestoSolicitado->id_linea_cotizacion_meson}}"
                                                form="FormSolicitarDescuento"
                                                style="width: 50px"
                                                value="{{ $repuestoSolicitado->descuento_marca }}">%
                                    </td>

                                    <td style="width: 120px" class="justify-content-center align-items-center">    
                                        <div class="row" style="align-items: center">
                                            <input type="text" class="descuento-lubricante form-control mr-2"
                                                id="spare-{{ $repuestoSolicitado->id_linea_cotizacion_meson }}"
                                                name="spare-{{$repuestoSolicitado->id_linea_cotizacion_meson}}"
                                                form="FormSolicitarDescuento"
                                                style="width: 50px"
                                                value="{{ $repuestoSolicitado->descuento_dealer }}">
                                            <span>%</span>
                                        </div>
                                        
                                    </td>
                                    @endIf
                                </tr>
                                 @endForeach

                            </tbody>
                    </table>      
                </div>

                    <div class="form-group form-inline text-left">
                        <label for="inputPorcentaje" class="col-4 ">REPUESTOS: </label>
                        <input name="porcentajeSolicitadoRepuestos" type="text" class="form-control col-2 mr-1" id="inputPorcentajeRepuestos" data-validation="number" data-validation-allowing="float" data-validation-error-msg="Debe ingresar el porcentaje de descuento de lubricantes" data-validation-error-msg-container="#errorPorcentajeLubricantes" value="0"> %
                        
                        <a href="#" id="moreSpares" onClick="showMoreSpares()" class="link-success fas fa-eye col-2 mr-1"></a>
                    
                        <a href="#" id="lessSpares" onClick="showLessSpares()" style="display:none" class="fas fa-eye-slash  link-danger col-2 mr-1"> </a>
                    
                        <a href="#" class="fas fa-plus" onClick="applyDiscountSpares()"> Aplicar a todos</a>
    
                        
                    </div>

                    <div id="listSpares" style="display:none">
                        <table >
                            <thead>
                                <tr>
                                    <th> Repuesto</th>
                                    <th> DSCTO. Marca</th>
                                    <th> DSCTO. Dealer</th>
                                </tr>
                            </thead>
                             <tbody> 
                                @foreach ($repuestosCotizacion as $repuestoSolicitado)
                                <tr>
                                    
                                    @if($repuestoSolicitado->repuesto->getNombreCategoria()!='LUBRICANTES')
                                    <td style="width: 300px">{{$repuestoSolicitado->getDescripcionRepuesto()}}</td>
                                    <td style="width: 120px" class="form-inline">    
                                        <input type="text" class="form-control mr-2"
                                                id="brand-{{ $repuestoSolicitado->id_linea_cotizacion_meson }}"
                                                name="brand-{{$repuestoSolicitado->id_linea_cotizacion_meson}}"
                                                form="FormSolicitarDescuento"
                                                style="width: 50px"
                                                value="{{ $repuestoSolicitado->descuento_marca }}">%
                                    </td>

                                    <td style="width: 120px" class="justify-content-center align-items-center">    
                                        <div class="row" style="align-items: center">
                                            <input type="text" class="descuento-repuesto form-control mr-2"
                                                id="spare-{{ $repuestoSolicitado->id_linea_cotizacion_meson }}"
                                                name="spare-{{$repuestoSolicitado->id_linea_cotizacion_meson}}"
                                                form="FormSolicitarDescuento"
                                                style="width: 50px"
                                                value="{{ $repuestoSolicitado->descuento_dealer }}">
                                            <span>%</span>
                                        </div>
                                        
                                    </td>
                                    @endIf
                                </tr>
                                 @endForeach
                                </tbody>
                        </table>      
                    </div>
            </form>
        </div>
        
        
        <div id="showmore" class="ml-4">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            
            @if(!$cotizacion->gotBrandDiscountLast())
            <button id="btnSendBrandDiscount" class="btn btn-success"   formaction="{{route('cotizacionMeson.sendBrandDiscountRequest')}}"    type="submit" form="FormSolicitarDescuento" type="button" class="btn btn-primary button-disabled-when-cliked">Descuentos de marca</button>
            @else
            <button type="button" class="btn btn-success btn-tabla" data-toggle="modal" data-target="#confirmSolicitarDescuento" data-backdrop="static" style="margin-left:15px" >
                Descuentos de Marca
            </button>
            
            @endIf
            <button id="btnSendDiscount" formaction="{{route('cotizacionMeson.sendDiscountRequest')}}" type="submit" form="FormSolicitarDescuento" type="button" class="btn btn-primary button-disabled-when-cliked">Descuentos de dealer</button>
            
        </div>
        </div>

        {{-- XDDD --}}

        <!-- Modal -->
        <div class="modal fade" id="confirmSolicitarDescuento" tabindex="-3" role="dialog" aria-hidden="true" style="z-index:2000">
            <div class="modal-dialog  modal-sm" >
                <div class="modal-content">
                    <div class="modal-header fondo-sigma">
                        <h5 class="modal-title">descuento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 65vh;overflow-y: auto;">
                        <h5>DESEA REEMPLAZAR EL ÚLTIMO DESCUENTO DE MARCA</h5>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-backdrop="static" data-dismiss="modal">No</button>                        
                        <button id="btnSendBrandDiscount" class="btn btn-success"   formaction="{{route('cotizacionMeson.sendBrandDiscountRequest')}}"    type="submit" form="FormSolicitarDescuento" type="button" class="btn btn-primary button-disabled-when-cliked">Si</button> 
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>

function showMore() {
    var id_cotizacion_meson = JSON.parse("{{ json_encode($idCotizacion) }}");
    //var route = JSON.parse("{{ json_encode(route('cotizacionMeson.sendDiscountRequest')) }}");
    var jArray = <?php echo json_encode($repuestosCotizacion); ?>;
    var link_completo = rootURL + "/cotizacionMeson/sendDiscountRequest"
    
    var table = `
    <form id="formDescuentos" method="POST" action="`+link_completo+`" autocomplete="off" >
        @csrf 
        <input id="id_cotizacion_meson" style="display:none" name="id_cotizacion_meson" type="text" value="`+ id_cotizacion_meson +`">
    <table  >
                    <thead>
                        <tr>
                            <th> Repuesto</th>
                            <th> DESCT. Marca</th>
                            <th> DESCT. Dealer</th>
                        </tr>
                    </thead>
                     <tbody> 
                     `;

    for(var i=0; i<jArray.length; i++){
        console.log('y',jArray[i]);
        let dscto_marca =jArray[i].descuento_marca!=null? jArray[i].descuento_marca: 0;
        let dscto_unitario = jArray[i].descuento_unitario!=null?jArray[i].descuento_unitario:0;
        table+= `
        <tr>
        <td style="width: 150px">`+ jArray[i].repuesto.descripcion +`</td>
        <td style="width: 70px" class="ml-4"> <input form="formDescuentos" id="brand-`+ jArray[i].id_linea_cotizacion_meson+`" name="brand-`+jArray[i].id_linea_cotizacion_meson +`" type="text" class="form-control" form="FormMesonCotizacion" style="width:100px" value="`+  dscto_marca+`"></td>
        <td style="width: 70px" class="ml-4"> <input class="descuento-repuesto" form="formDescuentos" id="spare-`+ jArray[i].id_linea_cotizacion_meson+`" name="spare-`+jArray[i].id_linea_cotizacion_meson +`" type="text" class="form-control" form="FormMesonCotizacion" style="width:100px" value="`+  dscto_unitario+`"></td></tr>`;
    }

                                    
    table+= `
            </tbody>
        </table>
      </form>              
                    `
   
    $('#more').css('display', 'none')
    $('#less').css('display', 'block')
    document.getElementById("showmore").innerHTML = table;
}
function showLess() {
    $('#more').css('display', 'block')
    $('#less').css('display', 'none')
    document.getElementById("showmore").innerHTML = "";
}

function applyDiscount() { 
    console.log('xxdd');
    // var discountPercentajeLubricant = document.getElementById("inputPorcentajeLubricantes").value;
    var discountPercentajeSpare = document.getElementById("inputPorcentajeRepuestos").value;
   
    // $('.descuento-lubricante').val(discountPercentajeLubricant);
    $('.descuento-repuesto').val(discountPercentajeSpare);
    // $('#modalSolicitarDescuento').modal('toggle');
 }
// function showAlert(){
//     Swal.fire({
//         title: 'Do you want to save the changes?',
//         showDenyButton: true,
//         showCancelButton: true,
//         confirmButtonText: `Save`,
//         denyButtonText: `Don't save`,
//         }).then((result) => {
//         /* Read more about isConfirmed, isDenied below */
//         if (result.isConfirmed) {
//             Swal.fire('Saved!', '', 'success')
//         } else if (result.isDenied) {
//             Swal.fire('Changes are not saved', '', 'info')
//         }
//     })
// }
 

 function showMoreSpares() { 
            $('#moreSpares').css('display', 'none')
            $('#lessSpares').css('display', 'block')
            document.getElementById('listSpares').style.display = 'block';  
    }
    function showLessSpares() {
        $('#moreSpares').css('display', 'block')
        $('#lessSpares').css('display', 'none')
        document.getElementById('listSpares').style.display = 'none'; 
    }
    function showMoreLubricants() { 
            $('#moreLubricants').css('display', 'none')
            $('#lessLubricants').css('display', 'block')
            document.getElementById('listLubricants').style.display = 'block';  
    }
    function showLessLubricants() {
        $('#moreLubricants').css('display', 'block')
        $('#lessLubricants').css('display', 'none')
        document.getElementById('listLubricants').style.display = 'none'; 
    }



    function applyDiscountSpares() { 
        var discountPercentajeSpare = document.getElementById("inputPorcentajeRepuestos").value;
        $('.descuento-repuesto').val(discountPercentajeSpare);
    }

    function applyDiscountLubricants() { 
        var discountPercentajeLubricant = document.getElementById("inputPorcentajeLubricantes").value;
        $('.descuento-lubricante').val(discountPercentajeLubricant);
    }
</script>