function waitForEl(selector, callback) {
     var poller1 = setInterval(function () {
          $jObject = jQuery(selector)
          if ($jObject.length < 1) {
               return
          }
          clearInterval(poller1)
          callback($jObject)
     }, 100)
}

$.validate({
	scrollToTopOnError : true, // Set this property to true on longer forms
	modules: 'logic'
});

var updateProvincias = null;
var updateDistritos = null;
var updateModelosSeminuevos = null;
var refreshTypeaheads = null;

$(function(){
	$('[data-toggle="popover"]').popover({content: $('#prueba').html(), html: true});
	var vehiculoCompleto = false;
	var clienteCompleto = false;

	function updateKilometrajeContactoVisibility(){
		if(vehiculoCompleto && clienteCompleto){
			$('#kilometrajeInExt').attr( "disabled", false );
			$('#contactoInExt').attr( "disabled", false );
			$('#telfContactoInExt').attr( "disabled", false );
			$('#correoContactoInExt').attr( "disabled", false );
			$('#correoContactoInExt2').attr( "disabled", false );
			$('#contactoInExt2').attr( "disabled", false );
			$('#telfContactoInExt2').attr( "disabled", false );
			$('#direccion').attr( "disabled", false );
			$('#facturara').attr( "disabled", false );
			$('#numDoc').attr( "disabled", false );
			
			
		}
		else{
			$('#kilometrajeInExt').attr( "disabled", true );
			$('#contactoInExt').attr( "disabled", true );
			$('#telfContactoInExt').attr( "disabled", true );
			$('#contactoInExt2').attr( "disabled", true );
			$('#telfContactoInExt2').attr( "disabled", true );
			$('#direccion').attr( "disabled", true );
			$('#facturara').attr( "disabled", true );
			
			$('#contactoInExt2').attr( "disabled", true );
		}
	}

	$('[data-toggle="tooltip"]').tooltip()
	// Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path

	$("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
		if ((this.href === path && path.slice(-1)!="#") || (path.slice(-1)=="#" && this.href === path.slice(0, -1))) {
			$(this).addClass("active");
		}
	});

    // Toggle the side navigation
	$("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
	});

	if($('#MensajeInicioModal').length){
		$('#MensajeInicioModal').modal('show');
	}

	$('#busquedaCollapsable form button[type="submit"]').each(function () {
		let form = $(this).closest('form');
		if (form.attr('noLimpiar') === undefined){
			$(this).before('<button id="sendFiltroLimpio" type="button" class="btn btn-secondary mr-3">Quitar filtros</button>');
			$('#sendFiltroLimpio').on('click', function () {
				window.location.replace(form.attr('action'));
			})
		}
	});

	$('#busquedaCollapsable form button[type="submit"], #busquedaForm form button[type="submit"]').each(function () {
		//$(this).prop('disabled', true);
	});

	$('#busquedaCollapsable form input, #busquedaCollapsable form select, #busquedaForm form input, #busquedaForm form select').on('change input', function () {
		let form = $(this).closest('form');
		form.find('button[type="submit"]').first().prop('disabled', false);
		form.find('button[name="exportar"]').first().prop('disabled', false);
		//$(this).unbind();
	});

	/*---------------------------------------------------------------*/ 
	updateProvincias = function updateProvincias(codDepartamento, callback) {
          $('#provinciaIn option:gt(0)').remove() // remove all options, but not the first
          $('#fact_provinciaIn option:gt(0)').remove() // remove all options, but not the first
          $('#distritoIn option:gt(0)').remove()
          $('#fact_distritoIn option:gt(0)').remove()
          if (codDepartamento) {
               var link_sub = '/obtenerProvincias/'
               var link_completo = rootURL + link_sub + codDepartamento
               $.get(link_completo, {}, function (data, status) {
                    if (status == 'success') {
                         $.each(data, function (key, value) {
                              $('#provinciaIn').append(
                                   $('<option></option>').attr('value', value.codigo_provincia).text(value.provincia),
                              )
                              $('#fact_provinciaIn').append(
                                   $('<option></option>').attr('value', value.codigo_provincia).text(value.provincia),
                              )
                         })
                         if (callback) callback()
                    }
               })
          }
     }
	
	function updateProvinciasProveedores(codDepartamento, numID, callback){
		$('#provinciaIn-' + numID + 'option:gt(0)').remove(); // remove all options, but not the first 
		$('#distritoIn-' + numID + 'option:gt(0)').remove();
		if(codDepartamento){
			var link_sub='/obtenerProvincias/';
			var link_completo = rootURL + link_sub + codDepartamento;
			$.get(link_completo,{},function(data,status) {
				if(status=='success'){
					$.each(data, function(key,value) {
						$('#provinciaIn-'+numID).append($("<option></option>")
							.attr("value", value.codigo_provincia).text(value.provincia));
					});
					if(callback) callback();
				}
			});
		}
	}
	

	updateDistritos = function updateDistritos(codDepartamento, codProvincia, callback) {
          $('#distritoIn option:gt(0)').remove()
          $('#fact_distritoIn option:gt(0)').remove()
          if (codProvincia) {
               var link_sub = '/obtenerDistritos/'
               var link_completo = rootURL + link_sub + codDepartamento + '/' + codProvincia
               $.get(link_completo, {}, function (data, status) {
                    if (status == 'success') {
                         $.each(data, function (key, value) {
                              $('#distritoIn').append(
                                   $('<option></option>').attr('value', value.codigo_distrito).text(value.distrito),
                              )
                              $('#fact_distritoIn').append(
                                   $('<option></option>').attr('value', value.codigo_distrito).text(value.distrito),
                              )
                         })
                         if (callback) callback()
                    }
               })
          }
     }

	 updateModelosSeminuevos = function updateModelosSeminuevos(marcaSeminuevo, callback) {
		// $('#marca_seminuevoIn option:gt(0)').remove()
		$('#modelo_seminuevoIn option:gt(0)').remove()
		if (marcaSeminuevo) {
			 var link_sub = '/obtenerModelosSeminuevos/'
			 var link_completo = rootURL + link_sub + marcaSeminuevo
			 $.get(link_completo, {}, function (data, status) {
				  if (status == 'success') {
					   $.each(data, function (key, value) {
							$('#modelo_seminuevoIn').append(
								 $('<option></option>').attr('value', value.id_modelo_auto_seminuevo).text(value.nombre),
							)
						
					   })
					   if (callback) callback()
				  }
			 })
		}
   }

	function updateDistritosProveedores(codDepartamento, codProvincia, numID, callback) {
		$('#distritoIn-' + numID + 'option:gt(0)').remove();
		if(codProvincia){
			var link_sub='/obtenerDistritos/';
			var link_completo = rootURL + link_sub + codDepartamento + '/' + codProvincia;
			$.get(link_completo,{},function(data,status) {
				if(status=='success'){
					$.each(data, function(key,value) {
						$('#distritoIn-'+numID).append($("<option></option>")
							.attr("value", value.codigo_distrito).text(value.distrito));
					});
					if(callback) callback();
				}
			});
		}
	}

	function setVehiculo(data) {
          $('#nroPlacaInModal').val(data.placa)
          $('#vinIn').val(data.vin)
          $('#motorIn').val(data.motor)
          $('#marcaAutoIn').val(data.id_marca_auto)
          $('#modeloIn').val(data.modelo_auto)
          $('#colorIn').val(data.color)
          $('#anhoVehiculoIn').val(data.anho_vehiculo)
          $('#anhoModelo').val(data.anho_modelo)
          $('#tipoTransmisionIn').val(data.tipo_transmision)
          $('#kilometrajeIn').val(data.kilometraje)
          $('#tipoCombustibleIn').val(data.tipo_combustible)

          $('#modeloTecnicoIn').val(data.modelo_tecnico)
          $('#nombreModelo2').val(data.modelo)
          $('#nombreModelo').val(data.modelo_auto)

		console.log(data)
          if (String(data.id_marca_auto) === '1') {
			if(String(data.modelo_tecnico)!='58'){
				$('#nombreModelo2').show()
				$('#nombreModelo2').prop('required', true)
				if(document.querySelector('#nombreModelo2'))
				document.querySelector('#nombreModelo2').disabled = false

				$('#nombreModelo').hide() 
				if(document.querySelector('#nombreModelo')){
					document.querySelector('#nombreModelo').removeAttribute('required')
					document.querySelector('#nombreModelo').disabled = true
				}
			}else{
				$('#nombreModelo').show()  
				$('#nombreModelo').prop('required', true)
				if(document.querySelector('#nombreModelo'))
				document.querySelector('#nombreModelo').disabled = false

				$('#nombreModelo2').hide()
				if(document.querySelector('#nombreModelo2')){
					document.querySelector('#nombreModelo2').removeAttribute('required')
					document.querySelector('#nombreModelo2').disabled = true
				}
			}
		} else {
               $('#nombreModelo2').hide()                           
			if(document.querySelector('#nombreModelo2'))
			document.querySelector('#nombreModelo2').removeAttribute('required')
               $('#nombreModelo').show()
               $('#nombreModelo').prop('required', true)
          }
          var id_mod = 58
          var name_mod = 'OTROS MODELOS'
          if (String(data.id_marca_auto) === '2') {
               $('#modeloTecnicoIn').css('display', 'none')
               $('#modeloTecnicoIn').prop('disabled', true)
               $('#modeloTecnicoIn2').css('display', 'block')              
			if(document.querySelector('#modeloTecnicoIn2'))
			document.querySelector('#modeloTecnicoIn2').removeAttribute('disabled')
               $('#modeloTecnicoIn2').removeProp('disabled')
               $('#modeloTecnicoIn2').append('<option value="' + id_mod + '" selected>' + name_mod + '</option>')
          } else {
               $('#modeloTecnicoIn').css('display', 'block')              
			if(document.querySelector('#modeloTecnicoIn'))
			document.querySelector('#modeloTecnicoIn').removeAttribute('disabled')
               $('#modeloTecnicoIn').removeProp('disabled')
               $('#modeloTecnicoIn2 option').remove()
               $('#modeloTecnicoIn2').css('display', 'none')
               $('#modeloTecnicoIn2').prop('disabled', true)
          }

          // if (String(data.id_marca_auto) === '2') {			
          //      $('#nombreModelo2').hide()
          //      $('#nombreModelo').show()
          // } else {
          //      $('#nombreModelo2').show()
          //      $('#nombreModelo').hide()
          // }
     }

	function setCliente(data) {
          console.log(data)
          $('#clienteInModal').val(data.nro_doc)
          $('#tipoClienteIn').val(data.tipo_cliente).change()
          $('#tipoIDIn').val(data.tipo_doc).change()
          $('#nombresIn').val(data.nombres)
          $('#apellidoPatIn').val(data.apellido_pat)
          $('#apellidoMatIn').val(data.apellido_mat)
          $('#sexoIn').val(data.sexo)
          $('#estadoCivilIn').val(data.estado_civil)
          $('#departamentoIn').val(data.cod_departamento)
          $('#fact_departamentoIn').val(data.cod_departamento)
          updateProvincias(data.cod_departamento, function () {
               $('#provinciaIn').val(data.cod_provincia)
               $('#fact_provinciaIn').val(data.cod_provincia)
               updateDistritos(data.cod_departamento, data.cod_provincia, function () {
                    $('#distritoIn').val(data.cod_distrito)
                    $('#fact_distritoIn').val(data.cod_distrito)
               })
          })
          $('#direccionIn').val(data.direccion)
          $('#telefonoIn').val(data.celular)
          $('#emailIn').val(data.email)

          // se toma cualquiera de estos campos y se toma el formulario
          // se hara el trigger de cambio entonces de todos estos cambios
     }

	$("#nroPlacaIn").on('input', function () {
		$('#hintPlaca').text("");
	});

	$("#nroPlacaIn").on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$("#btnBuscarPlaca").trigger('click');
		}
	});

	$(document).on('change', '#customSwitchRealPro', function (e) {
		let test = e.target.checked;
		let element = document.getElementById('proyeccion');

		if(test){
			$("#customSwitchRealProText").text("PROYECCIÓN")
			element.style.setProperty('color', 'blue');
			 				
		}else{
			$("#customSwitchRealProText").text("MES EN CURSO")	
			 element.style.setProperty('color', '');			
		}
		console.log(test);
	});

	$('#customSwitchRealPro').change()

	$(document).on('change', '#customSwitch1', function (e) {
		let test = e.target.checked;
		if(test){
			$("#customSwitch1Text").text("PAGO CON FACTURA")
			$("#facturaraText").text("Razon social:")
			
		}else{
			$("#customSwitch1Text").text("PAGO CON BOLETA")
			$("#facturaraText").text("Nombre:")
		}
		
	});

	$(document).on('change', '#customSwitchMayoreo', function (e) {
		let test = e.target.checked;
		if(test){
			$("#customSwitchMayoreoText").text("Mayoreo*")
			$("#precioMayoreo").show()
			
		}else{
			$("#customSwitchMayoreoText").text("Sin Mayoreo*")
			$("#precioMayoreo").hide()
		}
		
	});


	$(document).on('change', '#customSwitchvp', function (e) {
		let test = e.target.checked;
		let element = document.getElementById('proyeccion');

		if(test){
			$("#switch1vptext").text("PROYECCIÓN")
			$("#facturaraTextvp").text("Aplica exclusivamente para el mes en transcurso:")
			
			element.style.setProperty('color', 'blue');
			//element.style.setProperty('margin-right', '-40px');
			
		}else{
			$("#switch1vptext").text("MES EN CURSO")
			$("#facturaraTextvp").text("El valor real del mes")

			element.style.setProperty('color', '');
			//element.style.setProperty('margin-right', '-90px');
		}
		console.log(test);
	});


	$('#btnBuscarPlaca').on('click', function () {
          let nroPlaca = $('#nroPlacaIn').val()
          if (nroPlaca.length == 6) {
               //consultar datos y llenar los campos del form
               var link_sub = '/buscarRecepcion/'
               var link_completo = rootURL + link_sub + nroPlaca
               $('#hintPlaca').text('Buscando...')

               $.get(link_completo, {}, function (data, status) {
                    if (status == 'success') {
                         if (data) {
                              let data_mostrada = data.marca_auto + ' - ' + data.modelo_auto
                              $('#hintPlaca').text('')
                              $('#hintPlaca').append(
                                   '<a href="#" data-toggle="modal" data-target="#registrarVehiculoModal"><i class="fas fa-edit"></i>  ' +
                                        data_mostrada +
                                        '</a>',
                              )
                              $('#clienteIn').attr('disabled', false)
                              $('#contactoInExt').val(data.contacto)
                              $('#facturara').val(data.contacto)
                              $('#numDoc').val(data.num_doc)
                              $('#telfContactoInExt').val(data.telefono_contacto)
                              $('#correoContactoInExt').val(data.correo_contacto)
                              $('#telfContactoInExt2').val(data.telefono_contacto)
                              $('#correoContactoInExt2').val(data.correo_contacto)
                              $('#direccion').val(data.direccion)
                              setVehiculo(data)
                              vehiculoCompleto = true
                              if (data.num_doc) {
                                   $('#clienteIn').val(data.num_doc)
                                   data.nro_doc = data.num_doc
                                   setCliente(data)
                                   clienteCompleto = true
                                   $('#hintCliente').text('')
                                   $('#hintCliente').append(
                                        '<a href="#" data-toggle="modal" data-target="#registrarClienteModal"><i class="fas fa-edit"></i>  ' +
                                             data.nombre_completo +
                                             '</a>',
                                   )
                              } else {
                                   clienteCompleto = false
                                   $('#hintCliente').text('')
                              }

                              $('#kilometrajeInExt').attr(
                                   'data-validation-error-msg',
                                   'Debe especificar el kilometraje del vehiculo. Minimo: ' + data.kilometraje + ' KM',
                              )
                              $('#kilometrajeInExt').attr(
                                   'data-validation-allowing',
                                   'range[' + data.kilometraje + ';999999999]',
                              )
                         } else {
                              //abrir modal REGISTRO
                              $('#registrarVehiculoModal form').trigger('reset')
                              vehiculoCompleto = false
                              $('#nroPlacaInModal').val(nroPlaca)
                              $('#registrarVehiculoModal').modal({ show: true, backdrop: 'static' })
                              $('#kilometrajeInExt').attr(
                                   'data-validation-error-msg',
                                   'Debe especificar el kilometraje del vehiculo.',
                              )
                              $('#kilometrajeInExt').attr('data-validation-allowing', 'range[0;999999999]')
                              $('#hintPlaca').text('SIN RESULTADOS')
                         }
                    } else {
                         // abrir modal
                         // alert('ERROR CONEXION');
                    }
                    updateKilometrajeContactoVisibility()
               })
          } else {
               vehiculoCompleto = false
               updateKilometrajeContactoVisibility()
               $('#hintPlaca').text('')
          }
     })

	$('#abrirModificarCliente').on('click',function(){
		$departamento = $(this).attr('departamento');
		$provincia = $(this).attr('provincia');
		$distrito = $(this).attr('distrito');
		$("#departamentoIn").val($departamento);
		updateProvincias($departamento, function () {
			$("#provinciaIn").val($provincia);
			updateDistritos($departamento,$provincia, function () {
				$("#distritoIn").val($distrito);
			});
		});
	});

	$("[id^='editarProvButton-']").on('click',function(){
		$departamento = $(this).attr('departamento');
		$provincia = $(this).attr('provincia');
		$distrito = $(this).attr('distrito');
		console.log($distrito);
		let numID = $(this).attr('id').replace(/editarProvButton-/,'');

		$("#departamentoIn-"+numID).val($departamento);
		updateProvinciasProveedores($departamento, numID, function () {
			$("#provinciaIn-"+numID).val($provincia);
			updateDistritosProveedores($departamento,$provincia, numID, function () {
				$("#distritoIn-"+numID).val($distrito);
			});
		});
	});

	$('#FormRegistrarVehiculo').on('submit', function (e) {
          e.preventDefault()
          const data = $(this).serializeArray()
          var incoming = data.reduce((o, v) => ({ ...o, [v.name]: v.value }), {})

          var invalid = false
          const anhoModelo = incoming.anhoModelo
          const anhoVehiculo = incoming.anhoVehiculo
          const marca = incoming.marcaAuto

          const modeloTecnico = incoming.modeloTecnico
          const nombreModelo = incoming.nombreModelo
          const nombreModeloText = incoming.nombreModeloText

          if (String(modeloTecnico).trim() === '') {
               invalid = true
               $('#errorModeloTecnico').text('Debe especificar modelo tecnico')
          } else $('#errorModeloTecnico').text('')

          if (String(marca) === '1') {
               if (String(nombreModelo).trim() === '') {
                    invalid = true
                    $('#errorModelo').text('Debe especificar modelo')
               } else $('#errorModelo').text('')
          } else if (String(marca) === '2') {
               if (String(nombreModeloText).trim() === '') {
                    invalid = true
                    $('#errorModelo').text('Debe especificar nombre de modelo')
               } else $('#errorModelo').text('')
          }

          if (String(anhoModelo).length < 4) {
               $('#errorAnhoModelo').text('Debe especificar el año del vehículo')
               invalid = true
          } else $('#errorAnhoModelo').text('')

          if (String(anhoVehiculo).length < 4) {
               $('#errorAnhoVehiculo').text('Debe especificar el año del vehículo')
               invalid = true
          } else $('#errorAnhoVehiculo').text('')

          if (String(marca) === '1') {
			if(String(modeloTecnico)!='58'){
				delete incoming.nombreModeloText
			}
          } else {
               delete incoming.nombreModelo
          }

		console.log(incoming)
          if (!invalid) {
               console.log(incoming)
               $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: incoming,
                    success: function (data) {
                         $('#registrarVehiculoModal').modal('hide')
                         $('#hintPlaca').text('VEHICULO REGISTRADO')
                         $('#clienteIn').attr('disabled', false)
                         vehiculoCompleto = true
                         updateKilometrajeContactoVisibility()
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                         alert(errorThrown)
                    },
               })
          }
     })

	$('#FormModificarVehiculo').on('submit', function(e) {
		console.log($(this).serializeArray());
		e.preventDefault();
        $.ajax({
            url : $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
				$('#modificarVehiculoModal').modal('hide');
				$('#placaVehiculo').text($('#nroPlacaInModal').val());
				$('#anhoVehiculo').text($('#anhoVehiculoIn').val());
				$('#marcaVehiculo').text($('#marca-'+$('#marcaAutoIn').val()).text());
				$('#modeloTecnicoVehiculo').text($('#modeloTecnico-'+$('#modeloTecnicoIn').val()).text());
				$('#vinVehiculo').text($('#vinIn').val());
				$('#motorVehiculo').text($('#motorIn').val());

				$('#btnGuardarHojaTrabajo').trigger('click')
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });

	$("#clienteIn").on('input', function () {
		$('#hintCliente').text("");
		clienteCompleto = false;
		updateKilometrajeContactoVisibility();
	});

	$("#clienteIn").on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$("#btnBuscarCliente").trigger('click');
		}
	});

	$('#btnBuscarCliente').on('click', function () {
          let nroDoc = $('#clienteIn').val()
          if (nroDoc.length > 6) {
               //consultar datos y llenar los campos del form
               var link_sub = '/buscarCliente/'
               var link_completo = rootURL + link_sub + nroDoc
               $('#hintCliente').text('Buscando...')

               $.get(link_completo, {}, function (data, status) {
                    if (status == 'success') {
                         if (data) {
                              console.log('data', data)
                              setCliente(data)
                              clienteCompleto = true
                              $('#hintCliente').text('')
                              $('#hintCliente').append(
                                   '<a href="#" data-toggle="modal" data-target="#registrarClienteModal"><i class="fas fa-edit"></i>  ' +
                                        data.nombre_completo +
                                        '</a>',
                              )
                              $('#contactoInExt').val(data.nombre_completo)
                              $('#facturara').val(data.nombre_completo)
                              $('#numDoc').val(data.nro_doc)
                              $('#telfContactoInExt').val(data.celular)
                              $('#correoContactoInExt').val(data.email)
                              $('#telfContactoInExt2').val(data.celular)
                              $('#correoContactoInExt2').val(data.email)
                              $('#direccion').val(data.direccion)
                         } else {
                              //abrir modal REGISTRO
                              $('#registrarClienteModal form').trigger('reset')
                              clienteCompleto = false
                              $('#clienteInModal').val(nroDoc)
                              $('#registrarClienteModal').modal({ show: true, backdrop: 'static' })
                              $('#hintCliente').text('SIN RESULTADOS')
                              $('#contactoInExt').attr('disabled', true)
                         }
                    } else {
                         // abrir modal
                         alert('ERROR CONEXION')
                    }
                    updateKilometrajeContactoVisibility()
               })
          } else {
               clienteCompleto = false
               updateKilometrajeContactoVisibility()
               $('#hintCliente').text('')
          }
     })

	$('#FormRegistrarCliente').on('submit', function(e) {
		e.preventDefault();
        $.ajax({
            url : $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
				$('#registrarClienteModal').modal('hide');
				$("#hintCliente").text('CLIENTE REGISTRADO');
				clienteCompleto = true;
				updateKilometrajeContactoVisibility();
				$('#contactoInExt').val($("#nombresIn").val() + ($("#tipoIDIn").val() == 'RUC' ? '' : (' ' + $("#apellidoPatIn").val() + ' ' + $("#apellidoMatIn").val())) );
				$('#telfContactoInExt').val($("#telefonoIn").val());
				$('#correoContactoInExt').val($("#emailIn").val());
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });

	$('#FormModificarCliente').on('submit', function(e) {
		e.preventDefault();
        $.ajax({
            url : $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
				$('#modificarClienteModal').modal('hide');
				$('#abrirModificarCliente').text($('#clienteInModal').val());
				$('#nombreCliente').text($('#nombresIn').val()+' '+$('#apellidoPatIn').val());
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });


     $('#departamentoIn, #fact_departamentoIn').change(function () {
		updateProvincias($(this).val())
	})

	$("#provinciaIn").change(function () {
		updateDistritos($('#departamentoIn').val(), $(this).val())
	});

	$('#fact_provinciaIn').change(function () {
		updateDistritos($('#fact_departamentoIn').val(), $(this).val())
	});

	$('#marca_seminuevoIn').change(function () {
		updateModelosSeminuevos($('#marca_seminuevoIn').val(), $(this).val())
	});

	/*---------------------------------------------------------------*/ 

	// $("#FormRegistrarRepuesto").find("#importacionIn").on('change input',function(){
	// 	console.log($(this).val());
		
	// 	if($(this).val()==1){
	// 		$("#fechaPromesaRepuestoIn").show();
	// 	}
	// 	else{
	// 		$("#fechaPromesaRepuestoIn").hide();
	// 	}
	// });
	// DESCARTADO EL DÍA 4/09/19 SEGÚN CORRECCIÓN DE "REVISIÓN 25/08"
	/*---------------------------------------------------------------*/ 

	$(".datepicker").datepicker({
		changeMonth:true,
		changeYear: true,
		dateFormat: "dd/mm/yy"
	});

	$(".datepicker").datepicker("option",$.datepicker.regional["es"] );

	var dateFormat = "dd/mm/yy",
	from = $( ".fecha-inicio" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: dateFormat
	  }).on( "change", function() {
		to.datepicker( "option", "minDate", getDate( this.value ) );
	  }),
	to = $( ".fecha-fin" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: dateFormat
	}).on( "change", function() {
	  from.datepicker( "option", "maxDate", getDate( this.value ) );
	});

	function getDate( element ) {
		var date;
		try {
			if(element){
				date = $.datepicker.parseDate( dateFormat, element);
			}
			else{
				date=null;
			}
		} catch( error ) {
		date = null;
		}

		return date;
	}

  	$("[max-date]").each(function() {
		$(this).datepicker("option","maxDate",getDate($(this).attr("max-date")));
 	 });

  	$("[min-date]").each(function() {
		$(this).datepicker("option","minDate",getDate($(this).attr("min-date")));
 	 });


	$("#filtroSemaforo").css("background-color",function (){
		let optionSelected = $(this).val();
		if(optionSelected!='all'){
			return optionSelected;
		}
		else{
			return "white";
		}
	});
  
	$("#filtroSemaforo").change(function () {
		let optionSelected = $(this).val();
		if(optionSelected!='all'){
			$(this).css("background-color",optionSelected);
		}
		else{
			$(this).css("background-color","white");
		}
	});


	$('#tipoIDIn').on('change', function () {
		let tipo = $(this).val();
		if (tipo == "RUC") {
			$("#fieldsetPNatural").prop("disabled", true);
			$("#fieldsetPNatural").hide();
		}
		else{
			$("#fieldsetPNatural").prop("disabled", false);
			$("#fieldsetPNatural").show();
		}
	});
	
	var url = new URLSearchParams(window.location.search)
     var object = ''
     var id_recepcion_ot = url.has('id_recepcion_ot')
     var id_cotizacion = url.has('id_cotizacion')
     if (id_recepcion_ot) object = `O${url.get('id_recepcion_ot')}`
     else if (id_cotizacion) object = `C${url.get('id_cotizacion')}`

     var objClientes = { ruta: '/sugerenciasClientes/', bludjaund: null }
     var objProveedores = { ruta: '/sugerenciasProveedores/', bludjaund: null }
     var objOperacionesMEC = { ruta: '/sugerenciasOperacionesMEC/', bludjaund: null }
     var objOperacionesDYP = { ruta: '/sugerenciasOperacionesDYP/', bludjaund: null }
     var objRepuestos = { ruta: '/sugerenciasRepuestos/', bludjaund: null }
     var objModelosComerciales = { ruta: '/sugerenciasModeloComercial/', bludjaund: null }
     var objServiciosTerceros = { ruta: `/sugerenciasServicioTercero/${object}/`, bludjaund: null }
	 var objTodosVehiculosPorIngresar= { ruta: '/sugerenciasIngresoVehiculoNuevo/', bludjaund: null } 
	 var objTodosVehiculosSeminuevosPorIngresar= { ruta: '/sugerenciasIngresosVehiculoSeminuevo/', bludjaund: null }
	// var objVehiculos= {ruta: '/ruta4/', bludjaund: null};
	var sugerencias = {proveedores: objProveedores, operacionesMEC: objOperacionesMEC,
		 operacionesDYP: objOperacionesDYP, 
		 repuestos: objRepuestos, clientes: objClientes, 
		 serviciosTerceros: objServiciosTerceros,
		 modelosComerciales: objModelosComerciales,
		 vehiculosNuevos: objTodosVehiculosPorIngresar,
		 vehiculosSeminuevos: objTodosVehiculosSeminuevosPorIngresar
		};
	var arregloTipos = Object.keys(sugerencias);

	function construirBludjaund(subruta) {
		return new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: '',
			remote: {
			  url: rootURL + subruta + '%QUERY',
			  wildcard: '%QUERY'
			}
		  });
	}

	function obtenerSugerencias(tipo){
		//validacion
		if( !arregloTipos.includes(tipo) ) 
			return null;

		if(sugerencias[tipo].bludjaund === null)
			sugerencias[tipo].bludjaund = construirBludjaund(sugerencias[tipo].ruta);
		
		return sugerencias[tipo].bludjaund;
	}
		
	$('.typeahead:not(.tt-hint):not(.tt-input)').each(function(){
		let tipo = $(this).attr('tipo');
		let sourceRetriever = obtenerSugerencias(tipo);
		if(tipo!= 'modelosComerciales' && tipo!= 'vehiculosNuevos' && tipo!= 'vehiculosSeminuevos'){
			$(this).typeahead(null, {
				name: 'best-pictures',
				display: 'input_show',
				source: sourceRetriever,
				limit: 20,
				templates: {
					empty: [
						'<div class="empty-message">',
						'Sin resultados',
						'</div>'
					].join('\n'),
					suggestion: Handlebars.compile('<div style="text-align: start;"><strong>{{input_show}}</strong> – {{second_field}}</div>')
				}
			});
		}else{
			$(this).typeahead(null, {
				name: 'best-pictures',
				display: 'input_show',
				source: sourceRetriever,
				limit: 20,
				templates: {
					empty: [
						'<div class="empty-message">',
						'Sin resultados',
						'</div>'
					].join('\n'),
					suggestion: Handlebars.compile('<div style="text-align: start;"><strong>{{input_show}}</strong></div>')
				}
			});
		}
		
	})

	refreshTypeaheads = function refreshTypeaheads() {
		//Todo sobre typeahead aqui adentro

		$('.typeahead:not(.tt-hint):not(.tt-input)').each(function(){
			let tipo = $(this).attr('tipo');
			let sourceRetriever = obtenerSugerencias(tipo);
				
			$(this).typeahead(null, {
				name: 'best-pictures',
				display: 'input_show',
				source: sourceRetriever,
				limit: 20,
				templates: {
					empty: [
					  '<div class="empty-message">',
						'Sin resultados',
					  '</div>'
					].join('\n'),
					suggestion: Handlebars.compile('<div style="text-align: start;"><strong>{{input_show}}</strong> – {{second_field}}</div>')
				}
			});
			$('[data-toggle="tooltip"]').tooltip()
		})
		$('.typeahead').on('typeahead:select', function(ev, suggestion) {
			let id = $(this).attr('id');
			$("[typeahead_second_field="+id+']').val(suggestion.second_field);
		  });

		$('.typeahead.tt-hint').removeAttr('data-validation');

		// $('.typeahead').on('typeahead:render', function(ev, suggestion, flag, nameDataSet){
		// 	$(".tt-menu").each(function(){
		// 		if($(this).offset().left !=0 && $(this).parent()[0] != $('main')[0]){
		// 			var left_position = $(this).offset().left + 225.1999969482422;
		// 			console.log($('#containerMec').offset());
		// 			console.log($('#prueba1').offset());
		// 			console.log($('#prueba2').offset());
		// 			console.log($('#prueba3').offset());
		// 			console.log($('#tablaDetallesTrabajo').offset());
		// 			console.log($('#prueba4').offset());
		// 			var top_position = $(this).offset().top -62 ;
		// 			$('main').append($(this));
		// 			$(this).css({ top: top_position, left: left_position });
		// 		}
		// 	});
		// })
	
	}
	
	$('.typeahead').on('typeahead:select', function(ev, suggestion) {
		let id = $(this).attr('id');
		$("[typeahead_second_field="+id+']').val(suggestion.second_field);
	});

	$('.typeahead.tt-hint').removeAttr('data-validation');

	// $('.typeahead').on('typeahead:render', function(ev, suggestion, flag, nameDataSet){
	// 	$(".tt-menu").each(function(){
	// 		if($(this).offset().left !=0 && $(this).parent()[0] != $('main')[0]){
	// 			var left_position = $(this).offset().left + 225.1999969482422;

	// 			var top_position = $(this).offset().top -62 ;
	// 			$('main').append($(this));
	// 			$(this).css({ top: top_position, left: left_position });
	// 		}
	// 	});
	// })

	var objTodosClientes= '/sugerenciasClientes';
	var objTodosProveedores= '/sugerenciasProveedores';
	var objTodosOperacionesMEC= '/sugerenciasOperacionesMEC';
	var objTodosOperacionesDYP= '/sugerenciasOperacionesDYP';
	var objTodosRepuestos= '/sugerenciasRepuestos';
	var objTodosServiciosTerceros= '/sugerenciasServicioTercero';
	var objTodosVehiculosPorIngresar= '/sugerenciasIngresoVehiculoNuevo';
	var objTodosVehiculosSeminuevosPorIngresar= '/sugerenciasIngresosVehiculoSeminuevo';
	

	var sugerenciasTodos = {proveedores: objTodosProveedores, 
							operacionesMEC: objTodosOperacionesMEC, 
							operacionesDYP: objTodosOperacionesDYP, 
							repuestos: objTodosRepuestos, 
							clientes: objTodosClientes, 
							serviciosTerceros: objTodosServiciosTerceros,
							vehiculosNuevos: objTodosVehiculosPorIngresar,
							vehiculosSeminuevos: objTodosVehiculosSeminuevosPorIngresar
						};
	var arregloTodosTipos = Object.keys(sugerenciasTodos);

	function obtenerRuta(tipo){
		if( !arregloTodosTipos.includes(tipo) ) 
			return null;
		
		return rootURL + sugerenciasTodos[tipo];
	}

	refreshSelect2 = function refreshSelect2() {
		$('.selector2').each(function(){
			let tipo = $(this).attr('tipo');
			console.log(tipo);
			let link = obtenerRuta(tipo);
			console.log(link);
			//$(this).find("option"); si no hay tipo hacer arreglo
			$(this).select2({
				ajax: {
					url: link,
					dataType : "json",
					type: "GET",
					processResults: function (data) {
						console.log('entro');
						let respuestas = [];
						let contador = 0;
						
						data.forEach(element => {
							contador++;
							respuestas.push({'id':contador, 'text': element.suggestion_display});
						});
						console.log(data);
						return {
						results: respuestas
						};
					}
				}
			})
		});
	}

	$('.selector2').each(function(){
		let tipo = $(this).attr('tipo');
		let link = obtenerRuta(tipo);
		$(this).select2({
			ajax: {
				url: link,
				dataType : "json",
				type: "GET",
				processResults: function (data) {
					console.log('entro');
					let respuestas = [];
					let contador = 0;
					
					data.forEach(element => {
						contador++;
						respuestas.push({'id':contador, 'text': element.suggestion_display});
					});
					console.log(data);
					return {
					results: respuestas
					};
				}
			}
		})
	});

	
	//Maestro de repuestos

	$('.typeahead.repuesto').on('typeahead:select change', function(ev, suggestion) {
		let link = rootURL + '/buscarRepuesto/' + $(this).val();
		$.ajax({
            url : link,
            type: "GET",
            data: $(this).serialize(),
            success: function (data) {
				$("#customSwitchMayoreo").removeAttr("checked");
				$("#precioMayoreo").hide();
				if(data){
					console.log(data);
					$('#descripcionIn').val(data.descripcion);
					$('#marcain').val(data.id_marca);
					$('#categoriaIn').val(data.id_categoria_repuesto);
					$('#unidadMedidaIn').val(data.id_unidad_medida);
					$('#precioRepuestoIn').val(data.pvp);
					$('#margenRepuestoIn').val(data.margen);
					$('#ubicacionIn').val(data.ubicacion);
					$('#monedaIn').val(data.moneda_pvp);
					$('#unidadGrupoIn').val(data.id_unidad_grupo);
					$('#cantGrupoIn').val(data.cantidad_unidades_grupo);
					$('#precioMayoreo').val(data.pvp_mayoreo);
					if(data.pvp_mayoreo>1 ){
						$('#customSwitchMayoreo').attr('checked', '')
						$("#customSwitchMayoreoText").text("Mayoreo*")
						$("#precioMayoreo").show()
					}
					var aplicacionModelosTecnicos = data.modelos_tecnicos;
					aplicacionModelosTecnicos.map((row)=>{
						let x = "#modeloTecnico-"+row.id_modelo_tecnico;
						$(x).attr('checked', '')
					})

					var ventas = document.querySelector('.ventas_accesorio')
                         if (ventas) {
                              ventas.checked = data.aplicacion_ventas
                              var label = ventas.getAttribute('data-label')
                              $(`#${label}`).text(data.aplicacion_ventas ? 'SI' : 'NO')
                         }
					
				}
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
				$('#btnRegistrarRecepcion').removeClass('d-none')
            }
        });
	});

	//Maestro de vehiculos nuevos

	$('.typeahead.vehiculonuevo').on('typeahead:select change', function(ev, suggestion) {
		let link = rootURL + '/buscarRepuesto/' + $(this).val();
		$.ajax({
            url : link,
            type: "GET",
            data: $(this).serialize(),
            success: function (data) {
				if(data){
					console.log(data);
					
				}
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
				$('#btnRegistrarRecepcion').removeClass('d-none')
            }
        });
	});

	$("[method='POST']").on('submit',function(e){
		// $("[type='submit']").attr("disabled",true);
		$(".button-disabled-when-cliked").prop('disabled', true);
	})
	$('#unidadGrupoIn').on('change',function(){
		if($(this).val() != ''){
			$('#cantGrupoIn').prop('disabled',false);
			$('#cantGrupoIn').prop('placeholder',"Ingrese la cantidad en 1 grupo");
		} 
		else {
			$('#cantGrupoIn').val('');
			$('#cantGrupoIn').prop('placeholder',"");
			$('#cantGrupoIn').prop('disabled',true);
		}
	});


	$('#rbtDeducible').change(function (e) { 
		e.preventDefault()
		let val = $('#rbtDeducible').parent().next().text()

		if(val == 'DEDUCIBLE') $('#rbtDeducible').parent().next().text('SEGURO')
		else $('#rbtDeducible').parent().next().text('DEDUCIBLE')
		
		$('#divSeguro').toggleClass('d-none');
	});

	$('#seguroOT').change(function (e) { 
		e.preventDefault();
		let id_seguro = $('#seguroOT').val()

		if(id_seguro) {
			$.ajax({
				url : `/api/buscarSeguros/${id_seguro}`,
				type: "GET",				
				success: function (data) {
					//console.log(data)
					$('#seguroRUC').val(data.ruc)
					$('#seguroRS').val(data.razon_social)
					$('#seguroDir').val(data.direccion)
				},
				error: function (jXHR, textStatus, errorThrown) {
					alert(errorThrown);
				}
			});
		}
	});

	$('#seguroOT').change()

	
	function updateNotaCreditoDebito(id,num_doc,id_sibi_credit_notes){
		
		var link_redirect = rootURL + '/seguimientoFacturacion'

		var link_completo = rootURL + '/updateNotaCreditoDebito';
		var data ={
			id:id,
			num_doc:num_doc,
			id_sibi_credit_notes: id_sibi_credit_notes
		};
		$.get(link_completo,{data},(response) =>{
			window.location.replace(link_redirect);
			if(status=='success'){
				alert('Exitoso','Nota de credito/debito creada exitosamente')

			}
		})
	}


	function saveNotaCreditoDebito(creditNotes){
		let typeDocRef = $("#selectDocumentoReferencia").val();
		let nroDoc = $("#numDocRef").val();
		let serie = $("#numSerieRef").val();
		var documento =  typeDocRef+serie+'-'+nroDoc;
		
		var link_completo = rootURL + '/saveNotaCreditoDebito'
		var data ={
			selectTipoDocumento: $('#selectTipoDocumento').val(),
			numSerie: $('#numSerie').val(),
			numDocRef: documento,
			fechaVencimiento: $('#fechaVencimiento').val(),
			condicion_pago: $('#condicionPago').val(),
			reason:  $('#reason').val(),
			observaciones: $('#observaciones').val(),
			precio_total: $('#total_price').val(),
			taxable_operations: $('#taxable_operations').val(),
			moneda: $('#moneda').val(),
			tipo_cambio: $('#tipoCambio').val(),
			tipo_operacion: $('#tipoOperacion').val(),
			tipo_venta: $('#tipoVenta').val(),
			sale_id: $('#sale_id').val(),
			id_comprobante_venta: $('#id_comprobante_venta').val(),
			id_comprobante_anticipo : $('#id_comprobante_anticipo').val(),
		};
		
		$.get(link_completo,{data},(response)=> {
			
			updateNotaCreditoDebito(response, creditNotes.number, creditNotes.id)
			
		})
	}
	$("#refreshState").on('click', function () {
		let url_api_sibi= "https://app.sibi.pe/graphql";
		const myHeader = {
			'Content-Type': 'application/json',
			'Accept': 'application/json',
			'token-type': 'Bearer',
			'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiODZjODBiM2ZmODYyYjI4Njk5YjM2ZGNmMThjMDZkZjdjZTdhYjI1NWM2ZjY1ZDU1YjYxZGEwOTMxNWFiMDRjY2QxMTRlY2Q1Njc0M2EwY2IiLCJpYXQiOjE2MjI3NDA3MjgsIm5iZiI6MTYyMjc0MDcyOCwiZXhwIjo0Nzc4NDE0MzI4LCJzdWIiOiI4MjgiLCJzY29wZXMiOltdfQ.CpEjnuyBRlECh1gpRQdmvB1RNWgClGFjKw1Q3iqXmxKUUvAMRr9uEZE1UBBSrq2r8CbEF94DG-HaUcZNevDmdG7m2WRa_oOZy81Dz3pIW9s84j1OLGZd2DEPK7Wu7dJEj_DexfUz4DwwuGX1R3E6YGVnp_r57dUeEiU92Jp_oKWjEoaGKAQiAF_PG5x0dXy_HZAyzdB7YLah_AIzx6gdknqF76dS1eRqQh_SrjMsYEeQ08lnmGZVnpFHZD-vNEKaqdfW-X43-HQKVV1mZGUMc6mnpfvdUhsnIH-GlR8i7zpgNuWlVcallHNHpQ3ACFt74PcOGZbd27Cid7dLIupUpw3i0RaUxE7udibpf7aS0yBzdk-W2BI5cL2pmgiQjRrFB4QjzA7czE0QFJM01jkCPTyk9HSxO7RKr2NmnZLTJyEtQZy2qESvfWkUirgXdIk0Kw8h-zWVJyKnZc_lsqFWpwQVx7IZid94ndzQzf24wbN6pvt4d6n1nBH16a24laCDghFI6k-WwTjjapdrI9_qZWxrnCZNFxVMqwPSHd-zwZGqxTt76wzTI5j_p7zanSfJ-rfmiQs92c8LZy23dAZz5fHJ0vU0wSYQ2ArZEOIM-56DN1-LM5EvLjCP0R_uST6Nt3IzD7STc52-tG4QjAtftxR626BPBprMTs3jIFvVVqE',
		}

		const myQuery = `
		query {
			sales {
			  id,
			  sunat_code,
			  sunat_description
			} 
		  }
		`

          axios.post(
               url_api_sibi,
               {
                    query: myQuery,
               },
               { headers: myHeader },
          )
               .then((response) => {
                    console.log('response', response)
               })
               .catch((error) => alert('Error', 'No se pudo conectar a sibi'))
     })

     $('#btnSendNCNDSIBI').on('click', function () {
          var datos = JSON.parse($('#mycontent').val())

          var observaciones = $('#observaciones').val()
          console.log('observaciones', observaciones)
          if (observaciones.length == 0) {
               observaciones = 'Sin observaciones'
          }

          var reason = $('#reason').val()
          var total_price = $('#total_price').val()
          var total_igv = $('#total_igv').val()
          var taxable_operations = $('#taxable_operations').val()
          var sale_id = $('#sale_id').val()
          var items = datos.items
          var selectTipoDocumento = $('#selectTipoDocumento').val()

          var creditdebitNoteSerie = $('#selectDocumentoReferencia').val() + $('#numSerie').val()
          var coin = 'PEN'
          if ($('#moneda').val() == 'DOLARES') {
               coin = 'USD'
          }
          var issue_date = $('#fechaEmision').val()
          console.log('sale_id', sale_id)

          var detailItems = items.map((item) => {
               return {
                    item_id: 1,
                    quantity: item.cantidad,
                    unit_measure: 'UNI',
                    description: item.descripcion,
                    igv: item.impuesto,
                    sale_value: item.valor_venta,
                    discount: item.descuento,
                    igv_type: '10',
                    unit_value: item.valor_unitario,
                    unit_price: item.valor_unitario + item.impuesto,
               }
          })

          let url_api_sibi = 'https://app.sibi.pe/graphql'
          const myHeader = {
               'Content-Type': 'application/json',
               Accept: 'application/json',
               'token-type': 'Bearer',
               Authorization:
                    'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiODZjODBiM2ZmODYyYjI4Njk5YjM2ZGNmMThjMDZkZjdjZTdhYjI1NWM2ZjY1ZDU1YjYxZGEwOTMxNWFiMDRjY2QxMTRlY2Q1Njc0M2EwY2IiLCJpYXQiOjE2MjI3NDA3MjgsIm5iZiI6MTYyMjc0MDcyOCwiZXhwIjo0Nzc4NDE0MzI4LCJzdWIiOiI4MjgiLCJzY29wZXMiOltdfQ.CpEjnuyBRlECh1gpRQdmvB1RNWgClGFjKw1Q3iqXmxKUUvAMRr9uEZE1UBBSrq2r8CbEF94DG-HaUcZNevDmdG7m2WRa_oOZy81Dz3pIW9s84j1OLGZd2DEPK7Wu7dJEj_DexfUz4DwwuGX1R3E6YGVnp_r57dUeEiU92Jp_oKWjEoaGKAQiAF_PG5x0dXy_HZAyzdB7YLah_AIzx6gdknqF76dS1eRqQh_SrjMsYEeQ08lnmGZVnpFHZD-vNEKaqdfW-X43-HQKVV1mZGUMc6mnpfvdUhsnIH-GlR8i7zpgNuWlVcallHNHpQ3ACFt74PcOGZbd27Cid7dLIupUpw3i0RaUxE7udibpf7aS0yBzdk-W2BI5cL2pmgiQjRrFB4QjzA7czE0QFJM01jkCPTyk9HSxO7RKr2NmnZLTJyEtQZy2qESvfWkUirgXdIk0Kw8h-zWVJyKnZc_lsqFWpwQVx7IZid94ndzQzf24wbN6pvt4d6n1nBH16a24laCDghFI6k-WwTjjapdrI9_qZWxrnCZNFxVMqwPSHd-zwZGqxTt76wzTI5j_p7zanSfJ-rfmiQs92c8LZy23dAZz5fHJ0vU0wSYQ2ArZEOIM-56DN1-LM5EvLjCP0R_uST6Nt3IzD7STc52-tG4QjAtftxR626BPBprMTs3jIFvVVqE',
          }

          const myMutation = `
		mutation 
			creditNotes($mydetails: [CreditNoteDetailsInput]!, $nombre_cliente: String!, $correo: String!, $doc_cliente: String!, $observaciones: String!, $reason: String!, $total_price: Float!, $total_igv: Float!, $taxable_operations: Float!, $creditdebitNoteSerie: String!, $coin: String!, $issue_date: String!, $sale_id: Int!){
			creditNotes(
			  user_id:1,
			  store_id:1,
			  sale_id: $sale_id,
			  serie: $creditdebitNoteSerie,
			  coin: $coin,
			  issue_date: $issue_date,
			  total_igv: $total_igv,
			  unaffected_operations: 0.0,
			  exempted_operations:0.0,
			  total_price: $total_price,
			  global_discount: 0.0,
			  contact_identity: $doc_cliente,
			  contact_name: $nombre_cliente,
			  contact_address: $correo,
			  total_isc: 0.0,
			  reason: $reason,
			  note_code: "02",
			  taxable_operations: $taxable_operations,
			  observations: $observaciones,
			  details: $mydetails
			) {
				id
				sunat_description
				sunat_code
				total_discount
				document_type
				serie
				number
				global_discount
				taxable_operations
			}		
		  }
		`
          const myMutationDebit = `
		mutation 
			debitNotes($mydetails: [DebitNoteDetailsInput]!, $nombre_cliente: String!, $correo: String!, $doc_cliente: String!, $reason: String!, $total_price: Float!, $total_igv: Float!, $taxable_operations: Float!, $creditdebitNoteSerie: String!, $coin: String!, $issue_date: String!, $sale_id: Int!){
			debitNotes(
			  user_id:1,
			  store_id:1,
			  sale_id: $sale_id,
			  serie: $creditdebitNoteSerie,
			  coin: $coin,
			  issue_date: $issue_date,
			  total_igv: $total_igv,
			  unaffected_operations: 0.0,
			  exempted_operations:0.0,
			  total_price: $total_price,
			  global_discount: 0.0,
			  contact_identity: $doc_cliente,
			  contact_name: $nombre_cliente,
			  contact_address: $correo,
			  total_isc: 0.0,
			  reason: $reason,
			  note_code: "02",
			  taxable_operations: $taxable_operations,
			  details: $mydetails
			) {
				id
				sunat_description
				sunat_code
				total_discount
				document_type
				serie
				number
				global_discount
				taxable_operations
			}		
		  }
		
		`

          if (selectTipoDocumento == 'NC') {
               axios.post(
                    url_api_sibi,
                    {
                         query: myMutation,
                         variables: {
                              nombre_cliente: datos.nombre,
                              doc_cliente: datos.doc_cliente,
                              direccion: datos.direccion,
                              correo: datos.correo != null ? datos.correo : '-',
                              telefono: datos.telefono,
                              observaciones: observaciones,
                              mydetails: detailItems,
                              reason: reason,
                              total_price: total_price,
                              taxable_operations: taxable_operations,
                              total_igv: total_igv,
                              creditdebitNoteSerie: creditdebitNoteSerie,
                              coin: coin,
                              issue_date: issue_date,
                              sale_id: sale_id,
                         },
                    },
                    { headers: myHeader },
               )
                    .then((response) => {
                         console.log('response', response)
                         let id = response.data.data.creditNotes.id
                         window.open('https://app.sibi.pe/pdf/vouchers/20606257261/07/' + id)

                         saveNotaCreditoDebito(response.data.data.creditNotes)
                    })
                    .catch((error) => alert('Error', 'No se pudo generar la Nota de Credito'))
          } else {
               axios.post(
                    url_api_sibi,
                    {
                         query: myMutationDebit,
                         variables: {
                              nombre_cliente: datos.nombre,
                              doc_cliente: datos.doc_cliente,
                              direccion: datos.direccion,
                              correo: datos.correo != null ? datos.correo : '-',
                              telefono: datos.telefono,
                              mydetails: detailItems,
                              reason: reason,
                              total_price: total_price,
                              taxable_operations: taxable_operations,
                              total_igv: total_igv,
                              creditdebitNoteSerie: creditdebitNoteSerie,
                              coin: coin,
                              issue_date: issue_date,
                              sale_id: sale_id,
                         },
                    },
                    { headers: myHeader },
               )
                    .then((response) => {
                         console.log('response', response)
                         let id = response.data.data.debitNotes.id
                         window.open('https://app.sibi.pe/pdf/vouchers/20606257261/08/' + id)

                         saveNotaCreditoDebito(response.data.data.debitNotes)
                    })
                    .catch((error) => alert('Error', 'No se pudo generar la Nota de Debito'))
          }
     })

     $('#btnBuscarDataNC').on('click', function () {
          let typeDocRef = $('#selectDocumentoReferencia').val()
          let nroDoc = $('#numDocRef').val()
          let serie = $('#numSerieRef').val()
          var documento = typeDocRef + serie + '-' + nroDoc

          if (documento.length > 8) {
               //consultar datos y llenar los campos del form
               var link_sub = '/buscarDatosNotaCredito/'
               var link_completo = rootURL + link_sub + documento
               $('#hintCliente').text('Buscando...')

               $.get(link_completo, {}, function (data, status) {
                    if (status == 'success') {
                         if (data) {
                              $('#hintCliente').text('')
                              $('#mycontent').val(JSON.stringify(data[0]))

                              $('#direccionCliente').val(data[0].direccion)
                              $('#docCliente').val(data[0].doc_cliente)
                              $('#nombreCliente').val(data[0].nombre)
                              $('#emailCliente').val(data[0].correo)
                              $('#telefonoCliente').val(data[0].telefono)
                              $('#placa').val(data[0].placa)
                              $('#marca').val(data[0].marca.nombre_marca)
                              $('#modelo').val(data[0].modelo)
                              $('#kilometraje').val(data[0].kilometraje)
                              $('#vin').val(data[0].vin)
                              $('#motor').val(data[0].motor)
                              $('#ano').val(data[0].ano)
                              $('#color').val(data[0].color)
                              $('#tipoCambio').val(data[0].tipo_cambio)
                              $('#moneda').val(data[0].moneda)
                              $('#tipoOperacion').val(data[0].tipo_operacion)
                              $('#tipoVenta').val(data[0].tipo_venta)
                              $('#value_sale').val(data[0].valor_venta)
                              $('#total_discont').val(data[0].descuento)
                              $('#total_price').val(data[0].total_price)
                              $('#total_igv').val(data[0].total_igv)
                              $('#taxable_operations').val(data[0].taxable_operations)
                              $('#numSerie').val(serie)
                              $('#sale_id').val(data[0].sale_id)
                              $('#id_comprobante_anticipo').val(data[0].id_comprobante_anticipo)
                              $('#id_comprobante_venta').val(data[0].id_comprobante_venta)

                              if (data[0].placa == '-') {
                                   $('#card_vehiculo').hide()
                              }

                              var items = data[0].items
                              for (var i = 0, max = items.length; i < max; i += 1) {
                                   let count = items[i].id + 1
                                   let node =
                                        "<tr id='newItem-" +
                                        count +
                                        "'>" +
                                        '<td scope="row">' +
                                        count +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].cantidad +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].codigo +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].descripcion +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].costo +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].unidad +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].valor_unitario +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].valor_venta +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].descuento +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].sub_total +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].impuesto +
                                        '</th>' +
                                        '<td scope="row">' +
                                        items[i].total +
                                        '</th>' +
                                        '</tr>'
                                   $('#tablaDetalleNotaCredito tr:last').after(node)
                                   // refreshTabla();
                              }
                         } else {
                              $('#hintCliente').text('No se encontraron resultados')
                         }
                    } else {
                         // abrir modal
                         alert('ERROR CONEXION')
                    }
                    updateKilometrajeContactoVisibility()
               })
          } else {
               clienteCompleto = false
               updateKilometrajeContactoVisibility()
               $('#hintCliente').text('')
          }
     })
})

/* Angel Cayhualla */
function borrarError(id) {
     if ($(`#err-${id}`).length) {
          $(`#err-${id}`).remove()
     }
}

function validateForm() {
     let validate = true
     let inputs = {
          docCliente: 'El documento del cliente es requerido',
          nomCliente: 'El nombre del cliente es requerido',
          direccionCliente: 'La dirección del cliente es requerido',
          telefonoCliente: 'El teléfono del cliente es requerido',
          emailCliente: 'El correo del cliente es requerido',
     }

     for (const prop in inputs) {
          // console.log(`obj.${prop} = ${inputs[prop]}`);
          if ($(`#${prop}`).val() == '') {
               if (!$(`#err-${prop}`).length) {
                    $(`#div-${prop}`).append(`<span id="err-${prop}" class="text-danger">${inputs[prop]}</span>`)
               }

               validate = false
          }
     }

     return validate
}
/* Angel Cayhualla */

/************************** */
// modulo ingreso de vehiculos

$(document).on('change', '#customSwitchTipoIngreso', function (e) {
	let test = e.target.checked;
	if(test){
		
		$("#vehiculoNuevoSection").show()
		$("#vehiculoSeminuevoSection").hide()
	}else{
		
		$("#vehiculoNuevoSection").hide()
		$("#vehiculoSeminuevoSection").show()
	}
	
});


$('.typeahead.vehiculosNuevos').on('typeahead:select change', function(ev, suggestion) {
	let link = rootURL + '/buscarDataVehiculoNuevo/' + $(this).val();
	$.ajax({
		url : link,
		type: "GET",
		data: $(this).serialize(),
		success: function (data) {
			console.log('datavehicuhulo', data)
			if(data){
				console.log(data);
				$('#tipo_stock').val(data.tipo_stock);
				$('#marca').val(data.marca);
				$('#modelo_comercial').val(data.modelo_comercial);
				$('#motor').val(data.motor);
				$('#anho_modelo').val(data.anho_modelo);
				$('#color').val(data.color);
				$('#kilometraje').val(data.kilometraje);
				$('#guia_remision').val(data.guia_remision);
				$('#documento').val(data.documento);

				$('#fecha_recepcion').val(data.fecha_recepcion);
				$('#observaciones').val(data.observaciones);
				$('#documentoRelacionado').val(data.oc);


				var a = document.getElementById('linkImprimir');
				a.href = "http://localhost:8000/hojaNotaIngresoVehiculoNuevo?id_nota_ingreso="+data.documento;
				if(data.documento!=null){		
					$('#linkImprimir').removeClass('d-none');
					//$('#btn_regstrar').removeClass('d-none');
				}else{
					$('#linkImprimir').toggleClass('d-none');
					//$('#btn_regstrar').toggleClass('d-none');
				}
							
			}
		},
		error: function (jXHR, textStatus, errorThrown) {
			alert(errorThrown);
			$('#btnRegistrarRecepcion').removeClass('d-none')
		}
	});
});

$(document).on('change', '#customSwitchIngresoVehiculo', function (e) {
	let test = e.target.checked;
	

	if(test){
		$("#customSwitchIngresoVehiculoText").text("Seminuevo");
		$('#seccionVehiculoNuevo').toggleClass('d-none');
		$('#seccionVehiculoSeminuevo').removeClass('d-none');
		
		
	}else{
		
		$("#customSwitchIngresoVehiculoText").text("Nuevo");
		$('#seccionVehiculoNuevo').removeClass('d-none');
		$('#seccionVehiculoSeminuevo').toggleClass('d-none');

	}
});


$('.typeahead.vehiculosSeminuevos').on('typeahead:select change', function(ev, suggestion) {
	console.log('seminuevoxd');
	let link = rootURL + '/buscarDataVehiculoSeminuevo/' + $(this).val();
	$.ajax({
		url : link,
		type: "GET",
		data: $(this).serialize(),
		success: function (data) {
			console.log('datavehicuhuloSeminuevo', data)
			if(data){			

				$('#tipo_stock_sn').val(data.tipo_stock);
				$('#marca_sn').val(data.marca);
				$('#modelo_sn').val(data.modelo);
				$('#version_sn').val(data.version);
				$('#motor_sn').val(data.motor);
				$('#vin_sn').val(data.vin);
				$('#anho_fabricacion_sn').val(data.anho_fabricacion);
				$('#anho_modelo_sn').val(data.anho_modelo);
				$('#color_sn').val(data.color);
				$('#kilometraje_sn').val(data.kilometraje);

				$('#documento_sn').val(data.documento);

				$('#fecha_recepcion_sn').val(data.fecha_recepcion);
				$('#observaciones_sn').val(data.observaciones);
				$('#documentoRelacionado_sn').val(data.oc);		

				var a = document.getElementById('linkImprimir');
				a.href = "http://localhost:8000/hojaNotaIngresoVehiculoSeminuevo?id_nota_ingreso="+data.documento;
				if(data.documento!=null){		
					$('#linkImprimir_sn').removeClass('d-none');
					// $('#btn_regstrar_sn').removeClass('d-none');
					
				}else{
					$('#linkImprimir_sn').toggleClass('d-none');
					//$('#btn_regstrar_sn').toggleClass('d-none');
				}
							
			}
		},
		error: function (jXHR, textStatus, errorThrown) {
			alert(errorThrown);
			$('#btnRegistrarRecepcion').removeClass('d-none')
		}
	});
});


