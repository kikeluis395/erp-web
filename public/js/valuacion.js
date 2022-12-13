$(function(){
	/*---------------------------------------------------------------*/ 
	// waitForEl($("[id^='valuarSwitch-']"),function() {
	// 	//cuando el switch cambie de estado: true o false
	// 	var num = $(this).attr('id').replace(/valuarSwitch-/,'');

	// 	$("#seccionForm-"+num).prop('disabled',!(this.checked));
	// 	$("#btnSubmit-"+num).prop('disabled',!(this.checked));
	// });

	$("[id^='rechazadoSwitch-']").change(function() {
		//cuando el switch cambie de estado: true o false
		var num = $(this).attr('id').replace(/rechazadoSwitch-/,'');

		if(this.checked){
			$("#perdidaSwitch-"+num).prop("checked",false);
		}
	});

	$("[id^='perdidaSwitch-']").change(function() {
		//cuando el switch cambie de estado: true o false
		var num = $(this).attr('id').replace(/perdidaSwitch-/,'');

		if(this.checked){
			$("#rechazadoSwitch-"+num).prop("checked",false);
		}
	});

	// A BORRAR 30-11-2020
	/*
	$("[id^='FormEditarValuacion-']").find("#manoObraIn").on('change input',function(){
		var numID = $(this).attr('recepOT');
		var num=$(this).val();
		if(num>0){
			$("#horasCompletar-"+numID).show();

			// $("#mecanicaIn-"+numID).on('input',function(){
			// 	var hrmec=$(this).val();
			// 	var hrcar=$("#carroceriaIn-"+numID).val();
			// 	var hrpan=$("#panhosIn-"+numID).val();

			// 	if(hrmec + hrcar + hrpan<=0){
			// 		$("#btnRegistrarRecepcion").attr("disabled",true);
			// 	}
			// 	else{
			// 		$("#btnRegistrarRecepcion").removeAttr("disabled");
			// 	}

			// });


		}
		else{
			$("#horasCompletar-"+numID).hide();
			// $("#mecanicaIn-"+numID).on('input',function(){});
			// $("#carroceriaIn-"+numID).on('input',function(){});
			// $("#panhosIn-"+numID).on('input',function(){});
		}
	});
	*/


	/*---------------------------------------------------------------*/ 
	// waitForEl($("[id^='FormEditarValuacion-']").find("#fechaClienteIn"),function() {
	// 	var numID = $(this).attr('recepOT');
	// 	console.log($(this).val());
		
	// 	if($(this).val().length>0){
	// 		$("#horasValuacion-"+numID).show();
	// 	}
	// 	else{
	// 		$("#horasValuacion-"+numID).hide();
	// 	}
	// });

	$("[id^='FormEditarValuacion-']").find("[id^='fechaClienteIn-']").on('change input',function(){
		var numID = $(this).attr('recepOT');
		if($(this).val().length>0){
			$("#horasValuacion-"+numID).show();
		}
		else{
			$("#horasValuacion-"+numID).hide();
		}
	});

	$("[id^='FormEditarValuacion-']").find("[id^='fechaValuacionIn-']").on('change input',function (a,b) {
		let numID = $(this).attr('id').replace(/fechaValuacionIn-/,'');
		let dateString = $(this).val();
		let dateParts = dateString.split("/");
		let dateObject = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]);

		$("#fechaSeguroIn-" + numID).datepicker("option","minDate",dateObject);
		if(!$("#fechaSeguroIn-" + numID).length){
			//en caso no exista input de fecha de seguro
			$("#fechaClienteIn-"+ numID).datepicker("option","minDate",dateObject);

			if($(this).val().length>0){
				$("#camposAprobacionCliente-"+numID).show();
			}
			else{
				$("#camposAprobacionCliente-"+numID).hide();
			}
		}
		$("#fechaSeguroIn-" + numID).trigger("change");
	});

	// $("[id^='FormEditarValuacion-']").find("[id^='fechaSeguroIn-']").each(function(){
	// 	var numID = $(this).attr('id').replace(/fechaSeguroIn-/,'');
	// 	let dateString = $(this).val();
	// 	let dateParts = dateString.split("/");
	// 	let dateObject = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]); 

	// 	if(dateString)
	// 		$("#fechaClienteIn-"+ numID).datepicker("option","minDate",dateObject);
	// });

	$("[id^='FormEditarValuacion-']").find("[id^='fechaSeguroIn-']").on('change input',function(){
		var numID = $(this).attr('id').replace(/fechaSeguroIn-/,'');
		let dateString = $(this).val();
		let dateParts = dateString.split("/");
		let dateObject = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]);

		$("#fechaClienteIn-"+ numID).datepicker("option","minDate",dateObject);

		if($(this).val().length>0){
			$("#camposAprobacionCliente-"+numID).show();
		}
		else{
			$("#camposAprobacionCliente-"+numID).hide();
		}
	});

	//limpieza de modal al cierre
	$("[id^='editarValuacionModal-']").on('hide.bs.modal', function (e) {
		var numID = $(this).attr('id').replace(/editarValuacionModal-/,'');
		$(this).find('input:not(:disabled):not([type=hidden])').val( (i,val) => {
			return $(this).find('input:not(:disabled):not([type=hidden])')[i].getAttribute('value');
		} );
		
		$(this).find('input[type=checkbox]').prop("checked",false).trigger("change");

	});

	var cotizacionesCounter=1;
	$("[id^='btnAgregarCotizacion-']").on('click', function (e) {
		e.preventDefault();
		let numID = $(this).attr('id').replace(/btnAgregarCotizacion-/,'').replace(/-*/,'');
		let options = $("#cotizacionIn-" + numID + '-1 option[value!=""]');
		let newID = ++cotizacionesCounter;
		let newNode = 
		'<div class="form-group form-inline mb-0" id="cotizacionLine-'+numID+'-'+newID+'">' +
			'<label for="cotizacionIn-'+numID+'-'+newID+'" class="col-sm-6 justify-content-end"> <a id="eliminarLineaCotizacion-'+numID+'-'+newID+'" href="#">&times;&nbsp;&nbsp;</a> Cotización:</label>'+
			'<select name="cotizacion-'+numID+'-'+newID+'" id="cotizacionIn-'+numID+'-'+newID+'" class="form-control col-sm-6" data-validation="length" data-validation-length="min1" data-validation-error-msg="Debe seleccionar una opción" data-validation-error-msg-container="#errorCotizacion-'+numID+'-'+newID+'" required>' +
			'</select>'+
			'<div id="errorCotizacion-'+numID+'-'+newID+'" class="col-12 validation-error-cont text-right no-gutters pr-0"></div>' +
		'</div>';

		$('#containerCotizaciones-'+numID).append(newNode);
		$("#eliminarLineaCotizacion-"+numID+'-'+newID).on('click',function (e) {
			e.preventDefault();
			$("#cotizacionLine-"+numID+'-'+newID).remove();
		})
		$("#cotizacionIn-"+numID+'-'+newID).append(options.clone());
		$("#containerCotizaciones-"+numID).append($("#containerAddCotizacion-"+numID));
	})
	
}); 