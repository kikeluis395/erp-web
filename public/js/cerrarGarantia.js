$(function () {
     $("[id^='FormEntregarVehiculo']").on('submit', function (e) {
          $('close-entregar').prop('disabled', true)
          $('btnSubmit').prop('disabled', true)

          e.preventDefault()
          $.ajax({
               url: $(this).attr('action'),
               type: 'POST',
               data: $(this).serialize(),
               success: function (data) {
                    if (data.status == 0) {
                         $('#divmensje').html('').addClass('alert alert-danger')
                    } else {
                         var path = window.location.pathname
                         var link_sub = ''

                         if (path.includes('mecanica')) link_sub = '/mecanica/recepcion'
                         else link_sub = '/recepcion'

                         window.open(data, '_blank')
                         window.location.href = `${window.location.origin}${link_sub}`
                    }
               },
               error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown)
               },
          })
     })
})
