$(function () {
   function init() {
       // ************************** DATATABLES **************************
       $.fn.dataTable.ext.errMode = "throw";
       let table = $("#tablaOrdenCompra").DataTable({
           serverSide: true,
           processing: true,

           pageLength: 10,
           order: [[5, "desc"]],
           dom: 'rB<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6 infoDT"i><"col-12 col-md-6 pagDT"p>>',
           ajax: {
               url: route("mostrarOCDT.data"),
               type: "GET",
               data: function (d) {
                   d.alm_buscar = $("#almacen_buscar").val();
                   d.suc_buscar = $("#sucursal_buscar").val();
                   d.est_buscar = $("#estado_buscar").val();
                   d.doc_buscar = $("#dococ_buscar").val();
                   d.docni_buscar = $("#docni_buscar").val();
                   d.prov_buscar = $("#proveedorID").val();
                   d.fecInicial_buscar = $("#fec_inicial").val();
                   d.fecFinal_buscar = $("#fec_final").val();
               },
           },
           columns: [
               {
                   data: "DT_RowIndex",
                   name: "DT_RowIndex",
                   orderable: false,
                   searchable: false,
               },
               {
                   data: "local",
                   name: "local",
                   orderable: false,
                   render: function (data, type, row) {
                       if (row.local == "" || row.local == null) {
                           return "<span>-----------</span>";
                       } else {
                           return "<span>" + row.local + "</span>";
                       }
                   },
               },
               {
                   data: "almacen",
                   name: "almacen",
                   orderable: false,
                   render: function (data, type, row) {
                       if (row.almacen == "" || row.almacen == null) {
                           return "<span>-----------</span>";
                       } else {
                           return "<span>" + row.almacen + "</span>";
                       }
                   },
               },
               {
                   data: "motivo",
                   name: "motivo",
                   orderable: false,
                   render: function (data, type, row) {
                       if (row.motivo == "" || row.motivo == null) {
                           return "<span>-----------</span>";
                       } else {
                           return "<span>" + row.motivo + "</span>";
                       }
                   },
               },
               {
                   data: "fechaCreacion",
                   name: "fechaCreacion",
                   orderable: true,
               },
               {
                   data: "id_orden_compra",
                   name: "codigo_orden_compra",
                   orderable: true,
                   order: "desc",
               },
               {
                   data: "idProveedor",
                   name: "idProveedor",
                   orderable: false,
                   visible: false,
               },
               {
                   data: "rucProveedor",
                   name: "rucProveedor",
                   orderable: false,
               },
               {
                   data: "nomProveedor",
                   name: "nomProveedor",
                   orderable: false,
               },
               {
                   data: "factura_proveedor",
                   name: "factura_proveedor",
                   orderable: false,
                   render: function (data, type, row) {
                       if (
                           row.factura_proveedor == "" ||
                           row.factura_proveedor == null
                       ) {
                           return "<span>-----------</span>";
                       } else {
                           return "<span>" + row.factura_proveedor + "</span>";
                       }
                   },
               },
               {
                   data: "estado",
                   name: "estado",
                   orderable: false,
                   render: function (data, type, row) {
                       if (row.estado == "" || row.estado == null) {
                           return "<span>-----------</span>";
                       } else {
                           return "<span>" + row.estado + "</span>";
                       }
                   },
               },
               {
                   data: "tipo_moneda",
                   name: "tipo_moneda",
                   orderable: false,
               },
               {
                   data: "sumatotal",
                   name: "sumatotal",
                   orderable: false,
                   render: function (data, type, row) {
                       if (row.sumatotal == "" || row.sumatotal == null) {
                           return "<span>-----------</span>";
                       } else {
                           return (
                               "<span>" + row.sumatotal.toFixed(2) + "</span>"
                           );
                       }
                   },
               },

               {
                   data: "acciones",
                   orderable: false,
                   searchable: false,
               },

               {
                data: "acciones2",
                orderable: false,
                searchable: false,
            },
           ],
           language: {
               url: "js/datatables/datatable-es.json",
           },
           columnDefs: [
               {
                   targets: [4],
                   render: function (data) {
                       return moment(data).format("DD/MM/YYYY");
                   },
               },
           ],
           drawCallback: function () {
               $('[data-toggle="tooltip"]').tooltip({
                   trigger: "hover",
               });
           },
       });

       $(document).on("click", ".btn-collapse", function () {
           var name = $(this).closest("tr").data("name");
           collapsedGroups[name] = !collapsedGroups[name];
           table.draw();
       });

       $("#filtrar").on("click", function () {
           var almacen = $("#almacen_buscar").val();
           var almacenText = $("#almacen_buscar option:selected").text();
           var sucursal = $("#sucursal_buscar").val();
           var sucursalText = $("#sucursal_buscar option:selected").text();
           var estado = $("#estado_buscar").val();
           var estadoText = $("#estado_buscar option:selected").text();
           var nrodoc = $("#dococ_buscar").val();
           var nrodocni = $("#docni_buscar").val();
           var proveedor = $("#proveedor_buscar").val();
           var fInicial = $("#fec_inicial").val();
           var fFinal = $("#fec_final").val();

           if (
               almacenText == "TODOS" &&
               sucursalText == "TODOS" &&
               estadoText == "TODOS" &&
               fInicial == "" &&
               fFinal == ""
           ) {
               $("#SectionDatatables").removeClass("d-none");
           }

           // *********** FILTRO POR SOLO FECHAS ************
           if (fInicial != "") {
               if (fFinal != "") {
                   $("#tablaOrdenCompra").DataTable().draw(true);
                   $("#SectionDatatables").removeClass("d-none");
               } else {
                   Swal.fire({
                       icon: "warning",
                       text: "Ingresar la fecha final.",
                       confirmButtonText: "OK",
                       customClass: {
                           confirmButton: "btn btn-success btn-lg px-4",
                       },
                       buttonsStyling: false,
                   });
               }
           }

           if (fFinal != "") {
               if (fInicial != "") {
                   $("#tablaOrdenCompra").DataTable().draw(true);
                   $("#SectionDatatables").removeClass("d-none");
               } else {
                   Swal.fire({
                       icon: "warning",
                       text: "Ingresar la fecha inicial.",
                       confirmButtonText: "OK",
                       customClass: {
                           confirmButton: "btn btn-success btn-lg px-4",
                       },
                       buttonsStyling: false,
                   });
               }
           }
           // *********** / FILTRO POR SOLO FECHAS ************

           if (sucursal != null && nrodoc== null) {
               if (fInicial != "" && fFinal != "") {
                   $("#tablaOrdenCompra").DataTable().draw(true);
                   $("#SectionDatatables").removeClass("d-none");
               } else {
                   Swal.fire({
                       icon: "warning",
                       text: "Ingresar el rango de fechas.",
                       confirmButtonText: "OK",
                       customClass: {
                           confirmButton: "btn btn-success btn-lg px-4",
                       },
                       buttonsStyling: false,
                   });
               }
           }

           if (almacen != null && nrodoc== null) {
               if (fInicial != "" && fFinal != "") {
                   $("#tablaOrdenCompra").DataTable().draw(true);
                   $("#SectionDatatables").removeClass("d-none");
               } else {
                   Swal.fire({
                       icon: "warning",
                       text: "Ingresar el rango de fechas.",
                       confirmButtonText: "OK",
                       customClass: {
                           confirmButton: "btn btn-success btn-lg px-4",
                       },
                       buttonsStyling: false,
                   });
               }
           }

           if (estado != null && nrodoc== null) {
               if (fInicial != "" && fFinal != "") {
                   $("#tablaOrdenCompra").DataTable().draw(true);
                   $("#SectionDatatables").removeClass("d-none");
               } else {
                   Swal.fire({
                       icon: "warning",
                       text: "Ingresar el rango de fechas.",
                       confirmButtonText: "OK",
                       customClass: {
                           confirmButton: "btn btn-success btn-lg px-4",
                       },
                       buttonsStyling: false,
                   });
               }
           }

           if (nrodoc != "") {
               $("#tablaOrdenCompra").DataTable().draw(true);
               $("#SectionDatatables").removeClass("d-none");
           }

           if (proveedor != "") {
               $("#tablaOrdenCompra").DataTable().draw(true);
               $("#SectionDatatables").removeClass("d-none");
           }
       });

       $("#reiniciar").on("click", function () {
           $("#almacen_buscar").val("0").trigger("change");
           $("#sucursal_buscar").val("0").trigger("change");
           $("#estado_buscar").val("0").trigger("change");
           $("#dococ_buscar").val("");
           $("#docni_buscar").val("");
           $("#proveedorID").val("");
           $("#proveedor_buscar").val("");
           $("#fec_inicial").val("");
           $("#fec_final").val("");
           $("#SectionDatatables").addClass("d-none");
           $("#tablaOrdenCompra").DataTable().draw(true);
       });

       events();
       empresa_local();
       buscar_proveedor();
   }

   function events() {
       var getDate = function (input) {
           return new Date(input.date.valueOf());
       };

       // ********** DATEPICKER *******************/
       $("#fec_inicial")
           .datepicker({
               format: "dd-mm-yyyy",
               autoclose: true,
               todayHighlight: true,
               language: "es",
               orientation: "bottom auto",
           })
           .on("changeDate", function (selected) {
               $("#fec_final").datepicker("clearDates");
               $("#fec_final").datepicker("setStartDate", getDate(selected));
           });

       $("#fec_final").datepicker({
           format: "dd-mm-yyyy",
           autoclose: true,
           todayHighlight: true,
           language: "es",
           orientation: "bottom auto",
       });

       // DESACTIVAR LA PRIMER OPCION DE LOS DESPLEGABLES (SELECCIONAR)
       // $('#almacen_buscar option:eq(0)').prop('disabled', true);
       // $('#sucursal_buscar option:eq(0)').prop('disabled', true);
       // $('#estado_buscar option:eq(0)').prop('disabled', true);
   }

   // ******************* TRAER LOS LOCALES SEGUN LA EMPRESA SELECCIONADA ***************
   function empresa_local() {
       // $('#empresa').on('change', function () {
       // CUANDO SE AGREGUEN MAS EMPRESAS A LA TABLA LOCAL_EMPRESA, AQUI IRIA EL CODIGO
       // });

       var empresa_id = $("#empresa option:selected").text();

       $.ajax({
           url: route("mostrar_sucursal.data") + "?empresaName=" + empresa_id,
           type: "GET",
           dataType: "json",
           success: function (empresa) {
               $("#sucursal_buscar").empty();
               $("#sucursal_buscar").append(
                   '<option value="0" disabled selected hidden>TODOS</option>'
               );
               $.each(empresa, function (index, data) {
                   // $('#sucursal').append("<option value=' " + data.id_local + " ' " + (old == data.id_local ? 'selected' : '') + ">" + data.nombre_local) + "</option>";
                   $("#sucursal_buscar").append(
                       '<option value="' +
                           data.id_local +
                           '">' +
                           data.nombre_local +
                           "</option>"
                   );
               });
           },
       });
   }

   function buscar_proveedor() {
       var path = route("mostrar_proveedor.data");

       let outerData = [];
       $("#proveedor_buscar").typeahead({
           source: function (proveedor, result) {
               $.ajax({
                   url: path,
                   data: { campo_buscar: proveedor },
                   dataType: "json",
                   success: function (data) {
                       outerData = data;
                       result(
                           $.map(data, function (item) {
                               return item.ruc;
                           })
                       );
                   },
               });
           },

           highlighter: function (item) {
               let data = Object.keys(outerData).find(
                   (key) => outerData[key]["ruc"] === item
               );
               html = "";
               html =
                   "<strong>" +
                   outerData[data]["ruc"] +
                   "</strong>" +
                   " - " +
                   outerData[data]["nombre"];
               return html;
           },
           updater: function (item) {
               let data = Object.keys(outerData).find(
                   (key) => outerData[key]["ruc"] === item
               );
               $("#proveedorID").val(outerData[data]["provedorID"]);

               return item;
           },
       });
   }

   init();
});
