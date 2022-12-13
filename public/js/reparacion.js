$(function(){

    $("[id^='FormInicioOperativo-']").find("[id^='fechaInicioIn-']").on('change input',function(){
      var numID = $(this).attr('id').replace(/fechaInicioIn-/,'');
      let dateString = $(this).val();
      let dateParts = dateString.split("/");
      let dateObject = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]); 

      $("#fechaPromesaIn-"+ numID).datepicker("option","minDate",dateObject);
    });

    //limpieza de modal al cierre
    $("[id^='confirmarInicioModal-'], [id^='ampliacionModal-'], [id^='confirmarTerminoModal-']").on('hide.bs.modal', function (e) {

      $(this).find('input:not(:disabled):not([type=hidden])').val( (i,val) => {
        return $(this).find('input:not(:disabled):not([type=hidden])')[i].getAttribute('value');
      });

      $(this).find('textarea:not(:disabled):not([type=hidden])').val( (i,val) => {
        return "";
      });
    });

});