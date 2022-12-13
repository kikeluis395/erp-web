$(function () {

   function init() {

      events();
      saltar();
   }

   function events() {

      // *************** PERMITIR SOLO LETRAS Y NUMEROS *******************
      $(".alfanumerico").bind('keypress', function (event) {
         var regex = new RegExp("^[a-zA-Z0-9 ]+$");
         var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
         if (!regex.test(key)) {
            event.preventDefault();
            return false;
         }
      });

      $(".numeros").bind('keypress', function (event) {
         var regex = new RegExp("^[0-9]+$");
         var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
         if (!regex.test(key)) {
            event.preventDefault();
            return false;
         }
      });

      $('.decimal').keypress(function (e) {
         var character = String.fromCharCode(e.keyCode)
         var newValue = this.value + character;
         if (isNaN(newValue) || hasDecimalPlace(newValue, 5)) {
            e.preventDefault();
            return false;
         }
      });


      function hasDecimalPlace(value, x) {
         var pointIndex = value.indexOf('.');
         return pointIndex >= 0 && pointIndex < value.length - x;
      }



   }


   function saltar() {

      $(document).off('keydown ,select2:close', '.form-control, .custom-switch, .select2-search__field')
      $.extend($.expr[':'], {
         focusable: function (el, index, selector) {
            return $(el).is('a, button, :input, [tabindex]');
         }
      });

      $(document).on('keydown ,select2:close', '.form-control, .custom-switch, .select2-search__field', function (e) {

         if (e.which == 13) {
            e.preventDefault();
            $.tabNext();
         }
      });
   }


   init();

});