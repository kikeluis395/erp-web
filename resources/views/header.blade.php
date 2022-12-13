@php
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
@endphp
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('extra-meta','')
    <link rel="stylesheet"
          href="{{ asset('css/styles.css') }}">

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet"
          href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet"
          href=" {{ asset('css/nuevoEstilo.css') }} ">
    <link rel="stylesheet"
          href=" {{ asset('css/datatables/dataTables.bootstrap4.min.css') }} ">
    <link rel="stylesheet"
          href=" {{ asset('css/toastr.min.css') }} ">
    <link rel="stylesheet"
          href=" {{ asset('css/bootstrap4-toggle.min.css') }} ">


    <link rel="stylesheet"
          href=" {{ asset('css/datatables/rowGroup.dataTables.min.css') }} ">
    <link rel="stylesheet"
          href=" {{ asset('css/datepicker/bootstrap-datepicker3.css') }} ">

    @routes


    <style>
        .form-ocultable {
            background-color: rgb(204, 210, 213);
            border-radius: 5px;
            padding-top: 10px;
            padding-right: 10px;
            margin-bottom: 15px;
        }

        .letra-rotulo-detalle {
            font-size: 13px;
        }

        .fondo-sigma,
        .fondo-sigma .modal-title,
        .fondo-sigma button span {
            background: #002642;
            color: white;
        }

        .validation-error-cont {
            color: rgb(185, 74, 72);
        }

        ::placeholder {
            font-size: 14px;
        }

        :disabled ::placeholder {
            font-size: 0px;
        }

        .hotline {
            color: red;
        }

        .cont-estado {}

        .estado-borde {
            border: solid;
            border-width: 2px;
        }

        .estado-traslado {
            border-color: green;
        }

        .estado-esp-valuacion {
            border-color: yellow;
        }

        .estado-esp-aprobacion {
            border-color: orange;
        }

        .estado-esp-asignacion {
            border-color: red;
        }

        .estado-esp-reparacion {
            background: darkgrey;
        }

        .estado-paralizado {
            background: #DDDDDD;
        }

        .estado-listo {
            background: lightgreen;
        }

        .estado-entregado {
            background: yellow;
        }

        .estado-rechazado {
            background: #806000;
            color: white;
        }

        .estado-perdida {
            background: black;
            color: white;
        }

        .estado-hotline {
            background: red;
            color: white;
        }

        .estado-repuesto-entregado {
            background-color: green;
            color: white;
        }

        .estado-repuesto-pendiente {
            background-color: red;
            color: white;
        }

        .estado-ampliacion {
            background-color: skyblue;
            color: white;
        }

        .estado-esp-control-calidad {
            border-color: black;
        }

        .estado-etapa-reparacion-progreso-mecanica {
            background-color: rgb(39, 96, 255);
            color: #fff
        }

        .estado-etapa-reparacion-progreso {
            background-color: yellow;
        }

        .estado-etapa-reparacion-finalizado {
            color: white;
            background-color: green;
        }

        .estado-liquidado {
            background: yellow;
        }

        .estado {
            font-size: 13px;
        }

        .estado-pendiente {
            background-color: red;
            color: white;
        }

        .estado-facturado {
            background-color: yellow;
        }

        .estado-vendidoRP {
            background-color: orange;
        }

        .estado-vendido {
            background-color: green;
            color: white;
        }

        .tipo-danho {
            font-size: 13px;
        }

        .tipo-danho-express {
            background-color: #5B9BD5;
            color: #44546A;
        }

        .tipo-danho-leve {
            background-color: #C6EFCE;
            color: #006100;
        }

        .tipo-danho-medio {
            background-color: #FFEB9C;
            color: #9C5700;
        }

        .tipo-danho-fuerte {
            background-color: #FFC7CE;
            color: #9C0006;
        }

        .icono-btn-tabla {
            /*font-size: 15px*/
        }

        .select-mini {
            padding: 0;
            font-size: 12px;
            width: 90px;
        }

        .borde-tabla {
            border: solid;
            border-width: 2px;
            border-color: #dee2e6;
        }

        .btn-warning.disabled,
        .btn-warning:disabled {
            opacity: .45;
        }

        html,
        body {
            height: 100%;
            margin: 0
        }

        .acenter {
            display: flex;
            place-content: center;
            place-items: center;
        }

        .xscroll_none {
            overflow-x: hidden;
            flex-wrap: wrap;
        }

        html,
        body {
            height: 100%;
            margin: 0
        }

        .box {
            display: flex;
            flex-flow: column;
            height: 100%;
        }

        .box .fill-height {
            flex: 1 1 auto;
        }

        .circulo-semaforo {
            border-radius: 50% !important;
            width: 30px;
            height: 30px;
            display: flex;
            place-content: center;
            place-items: center;
        }

        .acenter {
            display: flex;
            place-content: center;
            place-items: center;
        }

        .xscroll_none {
            overflow-x: hidden;
            flex-wrap: wrap;
        }

        .circ-semaforo-popover {
            border-radius: 50% !important;
            width: 20px;
            height: 20px;
            display: inline-block;
        }

        .semf-pop-info {
            display: inline-block;
            margin-left: 5px;
        }

        #filtroSemaforo [value=all] {
            background-color: white !important;
        }

        .tableFixHead thead th {
            position: sticky;
            top: 0;
            background: #FFFFFF;
            margin-top: -5px;
            z-index: 1;
        }

        .tableTerceros thead th {
            background: #435d7d;
            color: #fff;
            position: sticky;
            top: 0;
            margin-top: -5px;
            z-index: 1;
        }

        td input {
            width: 35px;
        }

        .table-wrapper {
            background: #fff;
            padding: 20px 25px;
            border-radius: 3px;
            min-width: 1000px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 16px 30px;
            min-width: 100%;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .table-title .btn-group {
            float: right;
        }

        .table-title .btn {
            font-size: 13px;
            border: none;
            min-width: 50px;
            border-radius: 2px;
            border: none;
            outline: none !important;
            margin-left: 10px;
        }

        .table-title .btn i {
            /* float: left; */
            font-size: 21px;
            margin-right: 5px;
        }

        .table-title .btn span {
            /* float: left; */
            margin-top: 2px;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }

        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td:last-child i {
            opacity: 0.9;
            font-size: 22px;
            margin: 0 5px;
        }

        table.table td a {
            font-weight: bold;
            color: #566787;
            /* display: inline-block; */
            text-decoration: none;
            outline: none !important;
        }

        table.table td a:hover {
            color: #2196F3;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #F44336;
        }

        table.table td i {
            font-size: 19px;
        }

        table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
        }


        .table-cont-single {
            overflow-y: auto;
            max-height: 65vh;
        }

        .table-title .modal {
            color: black;
        }

        .tt-query {
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }

        .tt-hint {
            color: #999
        }

        .tt-menu {
            width: 422px;
            margin-top: 4px;
            padding: 4px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
        }

        .tt-suggestion {
            padding: 3px 20px;
            line-height: 24px;
        }

        .tt-suggestion.tt-cursor,
        .tt-suggestion:hover {
            color: #fff;
            background-color: #0097cf;

        }

        .tt-suggestion p {
            margin: 0;
        }

        .tt-dataset {
            max-height: 150px;
            overflow-y: auto;
        }

        .form-group-align-top.form-group,
        .form-group-align-top.form-group * {
            align-items: initial !important;
        }

        .twitter-typeahead {
            width: 100%;
        }


        .none {
            display: none !important;
        }

        .block {
            display: flex;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        .garantia_pendiente {
            background-color: red;
            color: #fff;
            padding: 6px
        }

        .garantia_proceso {
            background-color: yellow;
            color: rgb(0, 0, 0);
            padding: 6px
        }

    </style>

    @yield('extra-style','')

    <title>@yield('titulo','SIGMA')</title>

    <link rel="shortcut icon"
          type="image/png"
          href="{{ asset('assets/images/logo_cuadrado.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
          rel="stylesheet" />
</head>

<body class="sb-nav-fixed sb-sidenav-toggled"
      style="background-color: #efefef;">

    @yield('header-content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="{{ asset('js/handlebars.min-v4.7.6.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('js/datepicker-es.js') }}"></script>

    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tabbable.js') }}"></script>
    <script src="{{ asset('js/myscript.js') }}"></script>
    <script src="{{ asset('js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    

    <script src="{{ asset('js/datatables/dataTables.rowGroup.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.suma.js') }}"></script>
    
    <script>
        var rootURL = "{{ route('/') }}";
        @if (auth()->user())
            var idLocalUsuario={{ auth()->user()->empleado()->first()->id_local }};
            var monedaSimboloSoles = "{{ App\Helper\Helper::obtenerUnidadMoneda('SOLES') }}";
            var monedaSimboloDolares = "{{ App\Helper\Helper::obtenerUnidadMoneda('DOLARES') }}";
        @endif
    </script>
    @yield('variables_extras')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/validaciones.js?v=' . time()) }}"></script>
    <script src="{{ asset('js/facturacion.js?v=' . time()) }}"></script>
    <script src="{{ asset('js/reportes.js?v=' . time()) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        var csrf = "{!! csrf_token() !!}"
    </script>

    {{-- <script src="{{ asset('js/editable.js') }}"></script> --}}
    @yield('extra-scripts')
</body>

</html>
