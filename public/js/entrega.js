$(function(){
    //limpieza de modal al cierre
    $("[id^='confirmarEntregaModal-']").on('hide.bs.modal', function (e) {
		$(this).find('input:not(:disabled):not([type=hidden])').val( (i,val) => {
			return $(this).find('input:not(:disabled):not([type=hidden])')[i].getAttribute('value');
		} );
	});

	$("[id^='FormConfirmarEntrega-']").on('submit', function(e) {
		e.preventDefault();
        $.ajax({
            url : $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
                console.log(data);
                if (data.status != undefined && data.status == 'error') {
                    console.log(data)
                    alert(data.message)
                } else if (data.startsWith("http")) {
                    console.log(data);
                    window.open(data, '_blank');
                }
                location.reload();
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
    
});