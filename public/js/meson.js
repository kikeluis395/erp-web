$(function () {
     var newLineaCompraCount = 0
     function refreshTabla(type) {
          if (newLineaCompraCount > 0) {
               $('#tableRepuestosMeson[tipo="nuevo"]').show()
          } else {
               $('#tableRepuestosMeson[tipo="nuevo"]').hide()
          }

          if (type == 'del') {
               $('#tableRepuestosMeson')
                    .find("[id^='newLineaCompra-']")
                    .each(function (i, element) {
                         $(element)
                              .children('th')
                              .text(i + 1)
                    })
          }

          refreshTypeaheads()
     }

     function obtenerTotal() {
          let suma = 0
          $("[id^='totalLineaRepuesto-']").each(function () {
               var cadena = $(this).text().replace(/,/, '')
               let aux = parseFloat(cadena == '-' ? 0 : cadena)
               suma = suma + aux
          })

          $("[id^='totalLinea-']").each(function () {
               var cadena = $(this).text().replace(/,/, '')
               let aux = parseFloat(cadena)
               suma = suma + aux
          })

          $('#totalCot').text(suma.toFixed(2))
     }

     function obtenerPTotal() {
          let suma = 0
          $("[id^='pTotalLinea-']").each(function () {
               var cadena = $(this).text().replace(/,/, '')
               let aux = parseFloat(cadena == '-' ? 0 : cadena)
               suma = suma + aux
          })

          $('#PTotalCot').text(suma.toFixed(2))
     }

     function obtenerTotalDescuento() {
          let suma = 0

          $("[id^='descLinea-']").each(function () {
               let aux = parseFloat($(this).text().replace(/,/, ''))
               suma = suma + aux
          })

          $('#totalDescCot').text(suma.toFixed(2))
     }

     $('#monedaIn').on('change', function () {
          var simbolo = $(this).val() == 'SOLES' ? monedaSimboloSoles : monedaSimboloDolares
          $('#simboloTotalCot').text(simbolo)
          $('#simboloTotalDescCot').text(simbolo)
          $('#simboloPTotalCot').text(simbolo)
          $('#simboloPTotalCot2').text(simbolo)
          $('#simboloTotal').text(simbolo)
          $('.simbolo').text(simbolo)
     })

     var simbolo = $('#monedaIn').val() == 'SOLES' ? monedaSimboloSoles : monedaSimboloDolares
     $('#simboloTotalCot').text(simbolo)
     $('#simboloTotalDescCot').text(simbolo)
     $('#simboloPTotalCot').text(simbolo)
     $('#simboloPTotalCot2').text(simbolo)
     $('#simboloTotal').text(simbolo)
     $('.simbolo').text(simbolo)

     obtenerTotal()
     obtenerPTotal()
     obtenerTotalDescuento()

     function excluirCeroSol() {
          //var myInput = document.getElementsByTagName('input')[0];
          $('.cantidadsolrep').keyup(function (e) {
               var key = e.keyCode || e.charCode

               // si la tecla es un cero y el primer carácter es un cero
               if (key == 48 && this.value[0] == '0') {
                    // se eliminan los ceros delanteros
                    this.value = this.value.replace(/^0+/, '')
               }
          })
     }

         function addLineaSolRepuesto() {
        newLineaCompraCount++;
        var required = newLineaCompraCount === 1 ? 'required' : ''
        var td_additional = window.location.pathname==='/meson/create'?'': '<td align="center">-</td><td align="center">-</td>'
        let node=
            "<tr id='newLineaCompra-" + newLineaCompraCount + "'>" +
                '<th scope="row">' + newLineaCompraCount + "</th>" +
                '<td align="center"><input ' + required + '  id="codigoRepuestoIn-'+ newLineaCompraCount+'" name="codigoRepuesto-' + newLineaCompraCount + '" type="text" tipo="repuestos" class="form-control typeahead w-120" autocomplete="nope" data-toggle="tooltip" data-placement="top" form="FormMesonCotizacion"  ></td>' +
                '<td align="center"><input id="descripcionLineaRepuesto-' + newLineaCompraCount + '" name="descripcionLineaRepuesto-' + newLineaCompraCount + '" type="text" class="form-control" typeahead_second_field="codigoRepuestoIn-' + newLineaCompraCount + '" disabled/></td>' +
                '<td align="center">-</td>' +
                ($("#tableRepuestosMeson:not([tipo='nuevo'])").length ? '<td align="center">-</td>' : '')+
                '<td align="center" id="cantidadLineaRepuestoTD-' + newLineaCompraCount + '"><input ' + required + ' id="cantidadLineaRepuesto-' + newLineaCompraCount + '" name="cantidadLineaRepuesto-' + newLineaCompraCount + '" type="text" class="form-control cantidadsolrep" style="width:50px" form="FormMesonCotizacion" required/></td>' +
                '<td align="center" id="aplicaMayoreoLineaRepuestoTD-' + newLineaCompraCount + '">-</td>' +
                '<td align="center" id="disponibilidadLineaRepuesto-' + newLineaCompraCount + '">-</td>' +
                '<td align="center" id="tdimportado-' + newLineaCompraCount + '"></td>' +
                '<td align="center"><span id="simboloLineaRepuesto-' + newLineaCompraCount + '"></span><span id="pUnitLineaRepuesto-' + newLineaCompraCount + '">-</span></td>' +
                '<td align="center"><span id="simboloLineaRepuestoTotal-' + newLineaCompraCount + '"></span><span id="totalLineaRepuesto-' + newLineaCompraCount + '">-</span></td>' +
                ($("#tableRepuestosMeson:not([tipo='nuevo'])").length ? '<td align="center">-</td>' : '')+
                ($("#tableRepuestosMeson:not([tipo='nuevo'])").length ? '<td align="center"><span id="pTotalLineaRepuesto-' + newLineaCompraCount + '">-</span></td>' : '')+
                ($("#tableRepuestosMeson:not([tipo='nuevo'])").length ? '<td align="center">-</td>' : '')+
                
                ($("#tableRepuestosMeson[tipo='vendido']").length ? '<td align="center">-</td>' : '')+
                td_additional+
               //  '<td align="center">-</td>' +
               //  '<td align="center">-</td>' +
                '<td><button id="btnEliminarLineaRepuesto-' + newLineaCompraCount + '" type="button" class="btn btn-warning"><i class="fas fa-trash icono-btn-tabla"></i></button></td>' +
                
                "</tr>";
        $('#tableRepuestosMeson tr:last').after(node);
        refreshTabla();

        $("[id^='btnEliminarLineaRepuesto-']").unbind();
        $("[id^='btnEliminarLineaRepuesto-']").on('click', function () {
            let numID = $(this).attr('id').replace(/btnEliminarLineaRepuesto-/,'');
            $("#newLineaCompra-" + numID).remove();
            newLineaCompraCount--;
            refreshTabla('del');
        });

        //$("[id^='codigoRepuestoIn-']").unbind();
        $("[id^='codigoRepuestoIn-']").on('change', function () {
            let link_sub= rootURL + '/' + 'buscarRepuesto/';
            let link_completo = link_sub + $(this).val();
            let numID = $(this).attr('id').replace(/codigoRepuestoIn-/,'');

            

            $.get(link_completo,{},function(data,status) {
                if(data){
                    console.log($("#monedaIn").val());
                    let tipoCambio = $("#tipoDeCambioMeson").val();
                    tipoCambio = tipoCambio ? tipoCambio : data.tipoCambioSistema;
                    let moneda = $("#monedaIn").val();
                    let precio = data.pvpGrupo;
                    let precio_mayoreo = data.pvp_mayoreo;
                    let precioUnitario = data.moneda != moneda ? ( moneda=="DOLARES" ? precio/tipoCambio : precio*tipoCambio) : precio;
                    let precioUnitarioMayoreo = data.moneda != moneda ? ( moneda=="DOLARES" ? precio_mayoreo/tipoCambio : precio_mayoreo*tipoCambio) : precio_mayoreo;
                    let simbolo = moneda == 'SOLES' ? monedaSimboloSoles : monedaSimboloDolares;
                    $("#descripcionLineaRepuesto-" + numID).val(data.descripcion);
                    $("#unidadesLineaRepuesto-" + numID).text(data.unidad_medida);
                    $("#pUnitLineaRepuesto-" + numID).text(precioUnitario.toFixed(2));
                    $("#unidadGrupo-" + numID).append($("<option selected></option>").attr("value",data.id_unidad_grupo).text(data.nombreUnidadGrupo));
                    $("#unidadGrupo-" + numID).append($("<option></option>").attr("value",data.id_unidad_medida).text(data.nombreUnidadMinima));
                    $("#simboloLineaRepuesto-" + numID).text(simbolo + " ");
                    $("#simboloLineaRepuestoTotal-" + numID).text(simbolo + " ");                   
                    if(data.aplica_mayoreo){
                        $("#aplicaMayoreoLineaRepuestoTD-" + numID).remove();
                        let node = '<td align="center" id="aplicaMayoreoLineaRepuestoTD-'+numID+'" ><input id="aplicaMayoreoLineaRepuesto-' + numID + '" name="aplicaMayoreoLineaRepuesto-' + numID + '" type="checkbox" class="form-control" style="width:100px" form="FormMesonCotizacion"></td>'
                        $("#cantidadLineaRepuestoTD-" + numID).after(node);
                        $("#aplicaMayoreoLineaRepuesto-"+numID).attr('pvp_mayoreo',precioUnitarioMayoreo.toFixed(2));

                        $("#aplicaMayoreoLineaRepuesto-"+numID).on('change', function () {
                            let aux = $("#pUnitLineaRepuesto-" + numID).text();
                            $("#pUnitLineaRepuesto-" + numID).text($("#aplicaMayoreoLineaRepuesto-"+numID).attr('pvp_mayoreo'));
                            $(this).attr('pvp_mayoreo',aux);
                            $("#cantidadLineaRepuesto-" + numID).trigger('change');
                        });
                        
                    }
                    let stock = data.stockLocales.length ? data.stockLocales.find(element => element.id_local == idLocalUsuario).saldo_virtual : 0;
                    $("#cantidadLineaRepuesto-" + numID).attr('stock', stock);
                    $("#cantidadLineaRepuesto-" + numID).trigger('change');
                }
                else{
                    $("#cantidadLineaRepuesto-" + numID).attr('stock', null);
                    $("#descripcionLineaRepuesto-" + numID).val("NO EXISTE");
                }
            });
        });

        

       // $("[id^='cantidadLineaRepuesto-']").unbind();
        $("[id^='cantidadLineaRepuesto-']").on('input change', function () {
            let numID = $(this).attr('id').replace(/cantidadLineaRepuesto-/,'');
            let precioUnitario = parseFloat($("#pUnitLineaRepuesto-" + numID).text());
            let parsedNum = parseFloat($(this).val());
            let cantidad = isNaN(parsedNum) ? 0 : parsedNum ;
            let precioTotal = (cantidad * precioUnitario).toFixed(2);
            let stock=$(this).attr('stock');
            if(stock || stock === 0){
                $("#disponibilidadLineaRepuesto-" + numID).text((cantidad <= stock && stock>0) ? ('EN STOCK (' + stock + ')') : 'SIN STOCK');
                
                if(cantidad >= stock && cantidad>0){
                    $("#tdimportado-" + numID).remove();
                var node = '<td align="center" id="tdimportado-'+numID+'"><input id="esImportado-' + numID + '" name="esImportado-' + numID + '" type="checkbox" class="form-control" style="width:100px" form="FormMesonCotizacion"></td>'
                 $("#disponibilidadLineaRepuesto-" + numID).after(node);
                }

            }
            else{
                $("#disponibilidadLineaRepuesto-" + numID).text('');
            }
            $("#totalLineaRepuesto-" + numID).text(precioTotal);
            obtenerTotal();
            obtenerPTotal();
        });

        excluirCeroSol()
    }
    
     $('#btnAgregarRepuestoMeson').on('click', function () {
          addLineaSolRepuesto()
     })

     if ($("#tableRepuestosMeson[tipo='nuevo']").length) {
          addLineaSolRepuesto()
          addLineaSolRepuesto()
          addLineaSolRepuesto()
          addLineaSolRepuesto()
     }

     $("#FormMesonCotizacion, [form='FormMesonCotizacion']").on('keydown', function (event) {
          return event.key != 'Enter'
     })

     function symbolized_doc_number(word) {
          return !/^[a-z0-9]+$/i.test(String(word).trim().replace(/\s/g, ''))
     }

     $('#nroDocIn').on('change', function () {
          var invalido = false

          const dni = $(this).val()

          if (symbolized_doc_number(dni)) invalido = true
          else invalido = false

          if (invalido) {
               $('#errorNroDoc').text('Documento invalido')
          } else {
               $('#errorNroDoc').text('')

               var link_sub = '/buscarCliente/'
               var link_completo = rootURL + link_sub + dni
               $('#hintCliente').text('Buscando...')

               $.get(link_completo, {}, function (data, status) {
                    if (status == 'success') {
                         if (data) {
                              $('#edit_client_button').css('display', 'block')
                              // const path = window.location.pathname
                              // if (path === '/meson/create') $('#edit_client_button').css('display', 'none')
                              // else $('#edit_client_button').css('display', 'block')

                              $('#hintCliente').text('')

                              $('#telefonoIn').val(data.celular)
                              $('#correoIn').val(data.email)
                              $('#direccionIn').val(data.direccion)

                              $('#departamentoIn').val(data.cod_departamento)
                              updateProvincias(data.cod_departamento, function () {
                                   $('#provinciaIn').val(data.cod_provincia)
                                   updateDistritos(data.cod_departamento, data.cod_provincia, function () {
                                        $('#distritoIn').val(data.cod_distrito)
                                   })
                              })

                              const tipo_doc = data.tipo_doc
                              if (tipo_doc === 'DNI' || tipo_doc === 'CE') {
                                   document.querySelector('#tipo_doc').selectedIndex = 0
                                   $('#ruc').css('display', 'none')
                                   $('#other').css('display', 'block')
                              } else if (tipo_doc === 'RUC') {
                                   document.querySelector('#tipo_doc').selectedIndex = 1
                                   $('#ruc').css('display', 'flex')
                                   $('#other').css('display', 'none')
                              }
                              const { nombre_completo: cliente, nombres, apellido_pat, apellido_mat } = data

                              $('#modal_tipo_doc').val(tipo_doc)

                              if (tipo_doc === 'DNI' || tipo_doc === 'CE') {
                                   $('#cliente').val('')
                                   $('#nombres').val(nombres)
                                   $('#apellido_pat').val(apellido_pat)
                                   $('#apellido_mat').val(apellido_mat)

                                   $('#modal_cliente').val('')
                                   $('#modal_nombres').val(String(nombres).trim())
                                   $('#modal_apellido_pat').val(String(apellido_pat).trim())
                                   $('#modal_apellido_mat').val(String(apellido_mat).trim())

                                   $('#nombreClienteIn').val(`${nombres} ${apellido_pat} ${apellido_mat}`)
                              } else {
                                   $('#cliente').val(cliente)
                                   $('#nombres').val('')
                                   $('#apellido_pat').val('')
                                   $('#apellido_mat').val('')
                                   $('#nombreClienteIn').val(cliente)

                                   $('#modal_cliente').val(String(cliente).trim())
                                   $('#modal_nombres').val('')
                                   $('#modal_apellido_pat').val('')
                                   $('#modal_apellido_mat').val('')
                              }
                         } else {
                              //abrir modal REGISTRO
                              $('#hintCliente').text('NO EXISTE')
                              $('#edit_client_button').css('display', 'block')
                              $('#datosNUser').trigger('click')
                              if (dni.length === 8) {
                                   document.querySelector('#tipo_doc').selectedIndex = 0
                                   $('#ruc').css('display', 'none')
                                   $('#other').css('display', 'block')
                              } else if (dni.length === 11) {
                                   document.querySelector('#tipo_doc').selectedIndex = 1
                                   $('#ruc').css('display', 'flex')
                                   $('#other').css('display', 'none')
                              }
                         }
                    } else {
                         // abrir modal
                         alert('ERROR CONEXION')
                    }
               })

          }
     })

     $('.tipo_doc').each(function () {
          $(this).on('change', function () {
               const val = $(this).val()
               if (val === 'RUC') {
                    $('#ruc').css('display', 'flex')
                    $('#other').css('display', 'none')
               } else {
                    $('#ruc').css('display', 'none')
                    $('#other').css('display', 'block')
               }
          })
     })

     //
     const acented = {'á':'a', 'é':'e', 'í':'i', 'ó':'o', 'ú':'u'}
     const mayusacent = {'á':'Á', 'é':'É', 'í':'Í', 'Ó':'o', 'Ú':'u'}
     function replaceAcent(word){
          var minus = String(word).toLowerCase().trim()
          var sinacent = 0
          var proc = ''
          Object.keys(acented).forEach(acent => {
               if(minus.includes(acent)) {
                    sinacent+=1
                    proc = String(word).replace(acent, acented[acent]).replace(mayusacent[acent], String(acented[acent]).toUpperCase())
               }

          });
          if(sinacent>0) return replaceAcent(proc)
          return word
     }
     function replaceN(word){
          if(String(word).toLowerCase().trim().includes('ñ')) return replaceN(String(word).replace('ñ', '').replace('Ñ', ''))
          return word
     }
     function special(word){return replaceAcent(replaceN(word))}
     function symbolized(word) {
          return !/^[a-z]+$/i.test(special(String(word).trim().replace(/\s/g, '')))
     }
     //

     $('#detalleNuevoUsuarioMeson').on('submit', function (e) {
          e.preventDefault()
          const data_form = $(this).serializeArray()
          var data = data_form.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})
          const { tipo_doc, cliente, nombres, apellido_pat, apellido_mat } = data

          var valid = true
          const errorized = (id, val = true) => {
               if (val) $(id).text('Dato invalido')
               else $(id).text('')

               if (valid) {
                    if (val) valid = false
               }
          }

          if (tipo_doc === 'DNI' || tipo_doc === 'CE') {
               if (symbolized(String(nombres))) errorized('#errorNames')
               else errorized('#errorNames', false)
               if (symbolized(String(apellido_pat))) errorized('#errorapellidooat')
               else errorized('#errorapellidooat', false)
               if (symbolized(String(apellido_mat))) errorized('#errorapellidomat')
               else errorized('#errorapellidomat', false)
          } else {
               if (symbolized(String(cliente))) errorized('#errorCliente')
               else errorized('#errorCliente', false)
          }

          var nombre_completo = ''
          if (tipo_doc === 'DNI' || tipo_doc === 'CE') nombre_completo = `${nombres} ${apellido_pat} ${apellido_mat}`
          else nombre_completo = cliente

          if (valid) {
               $('#modal_tipo_doc').val(tipo_doc)
               if (tipo_doc === 'DNI' || tipo_doc === 'CE') {
                    $('#modal_cliente').val('')
                    $('#modal_nombres').val(String(nombres).trim())
                    $('#modal_apellido_pat').val(String(apellido_pat).trim())
                    $('#modal_apellido_mat').val(String(apellido_mat).trim())
               } else {
                    $('#modal_cliente').val(String(cliente).trim())
                    $('#modal_nombres').val('')
                    $('#modal_apellido_pat').val('')
                    $('#modal_apellido_mat').val('')
               }

               $('#nombreClienteIn').val(nombre_completo)
               $('#datosNuevoCliente').modal('hide')
          }
     })

     $('#FormMesonCotizacion').on('submit', function (e) {
          e.preventDefault()
          const data_form = $(this).serializeArray()
          var data = data_form.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          const nombreCliente = $('#nombreClienteIn').val()
          data.nombreCliente = nombreCliente

          const tipo_doc = data.modal_tipo_doc
          if (tipo_doc === 'DNI' || tipo_doc === 'CE') {
               delete data.modal_cliente
          } else if (tipo_doc === 'RUC') {
               delete data.modal_apellido_mat
               delete data.modal_apellido_pat
               delete data.modal_nombres
          }

          var invalid = false
          Object.keys(data).forEach((v) => {
               const valor = data[v]
               if (String(v).includes('modal_') || String(v) === 'nombreCliente') {
                    if (String(valor).trim() === '') invalid = true
               }
          })

          if (invalid) {
               Swal.fire({
                    icon: 'info',
                    toast: true,
                    text: 'Completa todos los campos del cliente',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
               })
          } else {
               $('#btnGuardarCotizacionMeson').prop('disabled', true)
               $('#btnGuardarCotizacionMeson').html('Guardando...')
               $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data,
                    success: function (res) {
                         if (res.success) {
                              window.location.href = res.route
                         }
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                         alert(errorThrown)
                    },
               })
          }
     })

     $('#close_nuevo_cliente, #closeREG').on('click', function (e) {
          const tipo_doc = $('#modal_tipo_doc').val()
          const cliente = $('#modal_cliente').val()
          const nombres = $('#modal_nombres').val()
          const apellido_pat = $('#modal_apellido_pat').val()
          const apellido_mat = $('#modal_apellido_mat').val()

          if (tipo_doc === 'DNI' || tipo_doc === 'CE') {
               document.querySelector('#tipo_doc').selectedIndex = 0
               $('#ruc').css('display', 'none')
               $('#other').css('display', 'block')
          } else if (tipo_doc === 'RUC') {
               document.querySelector('#tipo_doc').selectedIndex = 1
               $('#ruc').css('display', 'flex')
               $('#other').css('display', 'none')
          }

          if (tipo_doc === 'DNI' || tipo_doc === 'CE') {
               $('#cliente').val('')
               $('#nombres').val(nombres)
               $('#apellido_pat').val(apellido_pat)
               $('#apellido_mat').val(apellido_mat)
          } else {
               $('#cliente').val(cliente)
               $('#nombres').val('')
               $('#apellido_pat').val('')
               $('#apellido_mat').val('')
          }
     })

     $('.datos_saved_user').on('click', function (e) {
          const tipo_doc = $('#modal_tipo_doc').val()
          const cliente = $('#modal_cliente').val()
          const nombres = $('#modal_nombres').val()
          const apellido_pat = $('#modal_apellido_pat').val()
          const apellido_mat = $('#modal_apellido_mat').val()

          if (tipo_doc === 'DNI' || tipo_doc === 'CE') {
               document.querySelector('#tipo_doc').selectedIndex = 0
               $('#ruc').css('display', 'none')
               $('#other').css('display', 'block')
          } else if (tipo_doc === 'RUC') {
               document.querySelector('#tipo_doc').selectedIndex = 1
               $('#ruc').css('display', 'flex')
               $('#other').css('display', 'none')
          }

          if (tipo_doc === 'DNI' || tipo_doc === 'CE') {
               $('#cliente').val('')
               $('#nombres').val(nombres)
               $('#apellido_pat').val(apellido_pat)
               $('#apellido_mat').val(apellido_mat)
          } else {
               $('#cliente').val(cliente)
               $('#nombres').val('')
               $('#apellido_pat').val('')
               $('#apellido_mat').val('')
          }
     })
})
