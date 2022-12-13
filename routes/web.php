<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\Modelos\ComprobanteVenta;
use App\Modelos\MovimientoRepuesto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'MainMenu\MainMenuController@index')->middleware('roles')->name('/');
Route::get('/prueba', function () {
   echo "Esta es la sección prueba";
});

Route::get('/resetPassword', 'Administracion\UsuarioController@showCambiarPassword')->name('resetPassword')->middleware('auth');
Route::post('/resetPassword', 'Administracion\UsuarioController@cambiarPassword')->name('resetPassword.post')->middleware('auth');
Route::get('/cambiarMoneda', 'Administracion\TipoCambioController@cambiarMoneda')->name('cambiarMoneda')->middleware('auth');
Route::get('/hojaCotizacion', 'DocumentosController@cotizacion')->name('hojaCotizacion')->middleware('auth');
Route::get('/hojaOT', 'DocumentosController@ordenTrabajo')->name('hojaOT')->middleware('auth');
Route::get('/hojaNotaIngreso', 'DocumentosController@notaIngreso')->name('hojaNotaIngreso')->middleware('auth');
Route::get('/hojaNotaIngresoVehiculoNuevo', 'DocumentosController@notaIngresoVehiculoNuevo')->name('hojaNotaIngresoVehiculoNuevo')->middleware('auth');
Route::get('/hojaNotaIngresoVehiculoSeminuevo', 'DocumentosController@notaIngresoVehiculoSeminuevo')->name('hojaNotaIngresoVehiculoSeminuevo')->middleware('auth');
Route::get('/hojaDevolucion', 'DocumentosController@devolucion')->name('hojaDevolucion')->middleware('auth');
Route::get('/hojaConsumoTaller', 'DocumentosController@consumoTaller')->name('hojaConsumoTaller')->middleware('auth');
Route::get('/hojaReingresoTaller', 'DocumentosController@reingresoTaller')->name('hojaReingresoTaller')->middleware('auth');
Route::get('/hojaLiquidacion', 'DocumentosController@liquidacion')->name('hojaLiquidacion')->middleware('auth');
Route::get('/hojaInspeccion', 'DocumentosController@hojaInspeccion')->name('hojaInspeccion')->middleware('auth');
Route::get('/hojaConstancia', 'DocumentosController@hojaConstancia')->name('hojaConstancia')->middleware('auth');

Route::get('/hojaRepuestos', 'DocumentosController@hojaPedidoRepuestos')->name('hojaRepuestos')->middleware('auth');
Route::get('/hojaOrdenCompra', 'DocumentosController@ordenCompra')->name('hojaOrdenCompra')->middleware('auth');
Route::get('/hojaOrdenCompraSeminuevo', 'DocumentosController@ordenCompraSeminuevo')->name('hojaOrdenCompraSeminuevo')->middleware('auth');
Route::get('/hojaOrdenServicio', 'DocumentosController@ordenServicio')->name('hojaOrdenServicio')->middleware('auth');
Route::get('/hojaNotaEntrega', 'DocumentosController@notaEntrega')->name('hojaNotaEntrega')->middleware('auth');

Route::get('/export', 'Reportes\ExportController@index')->middleware('auth');

Route::get('/emailTracking', 'EmailTrackingController@show')->name('emailTracking.show');

Route::get('/parametros/{nombre}', function ($nombre) {
   echo "Esta es la sección con parámetros. Pusiste :" . $nombre;
});

Route::get('/buscarCitaPlaca/{nroPlaca}', 'CRM\CitasController@buscarPlacaCita');
Route::get('/buscarRecepcion/{nroPlaca}', 'CarroceriaPintura\RecepcionController@buscarRecepcionPlaca');
Route::get('/buscarCliente/{nroDoc}', 'Administracion\ClienteController@show');
Route::get('/existeOT/{nroOT}', 'CarroceriaPintura\RecepcionController@existeOT');
Route::get('/buscarRepuesto/{nroRepuesto}', 'Repuestos\RepuestosController@buscarRepuestoID');
Route::get('/obtenerStockRepuesto', 'Repuestos\RepuestosController@consultarStockLocal');
Route::get('/buscarOperacionTrabajoDyP/{nroOperacion}', 'Administracion\OperacionTrabajoController@getOperacionTrabajoDyP');
Route::get('/buscarOperacionTrabajoMec/{nroOperacion}', 'Administracion\OperacionTrabajoController@getOperacionTrabajoMec');
Route::post('/asociarOTCotizacion', 'CarroceriaPintura\DetalleTrabajoController@asociarOTCotizacion')->name('asociarOTCotizacion');
Route::post('/agregarServicioTercero', 'CarroceriaPintura\RecepcionController@agregarServicioTercero')->name('agregarServicioTercero');
Route::delete('/serviciosTerceros/{id}', 'CarroceriaPintura\RecepcionController@eliminarServicioTercero')->name('servicios_terceros.destroy');
Route::post('/cierreOT', 'CarroceriaPintura\RecepcionController@cerrarOT')->name('cierreOT');
Route::post('/reAbrirOT', 'CarroceriaPintura\RecepcionController@reAbrirOT')->name('reAbrirOT');
Route::post('/cierreCotizacion', 'CarroceriaPintura\DetalleTrabajoController@cerrarCotizacion')->name('cierreCotizacion');
Route::get('/obtenerProvincias/{codDepartamento}', function ($codDepartamento) {
   return App\Modelos\Ubigeo::provinciasCod($codDepartamento);
});
Route::get('/obtenerModelosSeminuevos/{marcaSeminuevoCod}', function ($marcaSeminuevoCod) {
   return App\Modelos\ModeloAutoSeminuevo::modeloCod($marcaSeminuevoCod);
});
Route::get('/obtenerDistritos/{codDepartamento}/{codProvincia}', function ($codDepartamento, $codProvincia) {
   return App\Modelos\Ubigeo::distritosCod($codDepartamento, $codProvincia);
});
Route::get('/obtenerCuentas/{codBanco}', function ($codBanco) {
   return App\Modelos\CuentaBancaria::cuentasCod($codBanco);
});

//NOTA VENTA
Route::get('/buscarDatosNotaCredito/{strNumDoc}', 'APIsController@buscarDataNotaCredito')->name('xd.xd');
Route::get('/saveNotaCreditoDebito', 'Facturacion\NotaCreditoDebitoController@store')->middleware('roles');
Route::get('/updateNotaCreditoDebito', 'Facturacion\NotaCreditoDebitoController@update')->middleware('roles');
//Route::get('/buscarDatosNotaCredito', 'APIsController@buscarDataNotaCredito')->name('xd.xd');
//Typeahead
Route::get('/sugerenciasOperacionesMEC/{strOperacion}', 'APIsController@buscarOperacionSugerenciaMEC');
Route::get('/sugerenciasOperacionesDYP/{strOperacion}', 'APIsController@buscarOperacionSugerenciaDYP');
Route::get('/sugerenciasRepuestos/{strRepuesto}', 'APIsController@buscarRepuestoSugerencia');
Route::get('/sugerenciasClientes/{strCliente}', 'APIsController@buscarClienteSugerencia');
Route::get('/sugerenciasProveedores/{strProveedor}', 'APIsController@buscarProveedorSugerencia');
Route::get('/sugerenciasServicioTercero/{idOT}/{strServicioTercero}', 'APIsController@buscarServicioTerceroSugerencia');
Route::get('/sugerenciasProveedores/{strProveedor}', 'APIsController@buscarProveedorSugerencia');
Route::get('/sugerenciasIngresoVehiculoNuevo/{vin}', 'APIsController@buscarPosiblesIngresosVehiculoNuevo');
Route::get('/sugerenciasIngresosVehiculoSeminuevo/{placa}', 'APIsController@buscarPosiblesIngresosVehiculoSeminuevo');
//Select2
Route::get('/sugerenciasOperacionesMEC', 'APIsController@buscarTodosOperacionMEC');
Route::get('/sugerenciasOperacionesDYP', 'APIsController@buscarTodosOperacionDYP');

Route::get('/sugerenciasRepuestos', 'APIsController@buscarTodosRepuesto');
Route::get('/sugerenciasClientes', 'APIsController@buscarTodosCliente');
Route::get('/sugerenciasProveedores', 'APIsController@buscarTodosProveedor');
Route::get('/sugerenciasServicioTercero', 'APIsController@buscarTodosServicioTercero');
Route::get('/sugerenciasIngresoVehiculoNuevo', 'APIsController@buscarPosiblesIngresosVehiculoNuevo');
Route::get('/sugerenciasIngresosVehiculoSeminuevo', 'APIsController@buscarPosiblesIngresosVehiculoSeminuevo');

Route::get('mecanica/registrarOT', 'Mecanica\RecepcionController@create', ['as' => 'mecanica'])->name('mecanica.registrarOT')->middleware('roles');
Route::get('mecanica/registrarCotizacion', 'Mecanica\CotizacionesController@create', ['as' => 'mecanica'])->name('mecanica.registrarCotizacion')->middleware('roles');
Route::resource('mecanica/recepcion', 'Mecanica\RecepcionController', ['as' => 'mecanica'])->middleware('roles');
Route::resource('mecanica/cotizaciones', 'Mecanica\CotizacionesController', ['as' => 'mecanica'])->middleware('roles');
Route::resource('mecanica/detalle_trabajos', 'Mecanica\DetalleTrabajoController', ['as' => 'mecanica'])->middleware('roles');
Route::resource('mecanica/reparacion', 'Mecanica\ReparacionController', ['as' => 'mecanica'])->middleware('roles');
Route::resource('mecanica/tecnicos', 'Mecanica\TecnicosEnProcesoController', ['as' => 'mecanica'])->middleware('roles');
Route::get('dyp/registrarOT', 'CarroceriaPintura\RecepcionController@create', ['as' => 'dyp'])->name('dyp.registrarOT')->middleware('roles');
Route::get('dyp/registrarCotizacion', 'CarroceriaPintura\CotizacionesController@create', ['as' => 'dyp'])->name('dyp.registrarCotizacion')->middleware('roles');
Route::resource('recepcion', 'CarroceriaPintura\RecepcionController')->middleware('roles');
Route::resource('cotizaciones', 'CarroceriaPintura\CotizacionesController')->middleware('roles');
Route::resource('detalle_trabajos', 'CarroceriaPintura\DetalleTrabajoController')->middleware('roles');

Route::post('detalle_trabajos/solicitarDescuentoDealerUnitario', 'CarroceriaPintura\DetalleTrabajoController@solicitarDescuentoDealerUnitario')->name('detalle_trabajos.solicitarDescuentoDealerUnitario')->middleware('roles');

Route::resource('inventarioVehiculo', 'HojaInventarioController')->middleware('roles');
Route::resource('inspeccionVehiculo', 'HojaInspeccionController')->middleware('roles');
Route::get('hojaInspeccionVehiculoPDI', 'HojaInspeccionController@store2')->name('hojaInspeccionVehiculo')->middleware('roles');
Route::get('verHojaInspeccionVehiculoPDI', 'HojaInspeccionController@indexPDI')->name('verHojaInspeccionVehiculo')->middleware('roles');
Route::resource('valuacion', 'CarroceriaPintura\ValuacionController')->middleware('roles');
Route::resource('reparacion', 'CarroceriaPintura\ReparacionController')->middleware('roles');
Route::resource('tecnicos', 'CarroceriaPintura\TecnicosEnProcesoController')->middleware('roles');
Route::resource('entrega', 'CarroceriaPintura\EntregaController')->middleware('roles');
Route::resource('rebates', 'Facturacion\RebatesController')->middleware('roles');
Route::resource('repuestoPendientes', 'Facturacion\RepuestosPendientesController')->middleware('roles');
Route::get('repuestosOT', 'Repuestos\RepuestosController@repuestosOT')->name('repuestosOT')->middleware('roles');
Route::get('repuestosCot', 'Repuestos\RepuestosController@repuestosCot')->name('repuestosCot')->middleware('roles');
Route::get('repuestos/movimientos', 'Repuestos\RepuestosController@movimientosIndex')->name('repuestos.movimientos')->middleware('roles');
Route::resource('repuestos', 'Repuestos\RepuestosController')->middleware('roles');
Route::resource('detalle_repuestos', 'Repuestos\DetalleRepuestosController')->middleware('roles');
Route::post('detalle_repuestos/update', 'Repuestos\DetalleRepuestosController@update')->name('detalle_repuestos.update')->middleware('roles');
Route::post('detalle_repuestos/saveDescuento', 'Repuestos\DetalleRepuestosController@saveDescuento')->name('detalle_repuestos.saveDescuento')->middleware('roles');
Route::resource('garantia', 'Garantias\GarantiasController')->middleware('roles');
Route::get('hojaEntrega', 'Garantias\GarantiasController@generarHojaEntrega')->name('hojaEntrega')->middleware('roles');
Route::post('garantia/facturar', 'Garantias\GarantiasController@entregarfactura')->name('garantia.facturar')->middleware('roles');
Route::post('garantia/facturadas', 'Garantias\GarantiasController@generarReporteGarantiasFacturadas')->name('garantia.reporte')->middleware('roles');
Route::post('garantia/registrar', 'Garantias\GarantiasController@procesarCargaRegistro')->name('garantia.registrar')->middleware('roles');
Route::post('garantia/motivo', 'Garantias\GarantiasController@procesarMotivo')->name('garantia.motivo')->middleware('roles');

Route::resource('/carroceria_mo', 'Administracion\CarroceriaMOController')->middleware('auth');
Route::post('/carroceria_mo/lineas', 'Administracion\CarroceriaMOController@store_lineas')->name('carroceria_mo.store_lineas')->middleware('auth');
Route::resource('/mecanica_mo', 'Administracion\MecanicaMOController')->middleware('auth');
Route::post('/mecanica_mo/lineas', 'Administracion\MecanicaMOController@store_lineas')->name('mecanica_mo.store_lineas')->middleware('auth');
Route::resource('/perfiles', 'Administracion\ProfilesController')->middleware('auth');
Route::post('/perfiles/accesos', 'Administracion\ProfilesController@store_mapeo')->name('perfiles.accesos')->middleware('auth');
Route::post('/perfiles/reportes', 'Administracion\ProfilesController@store_report')->name('perfiles.reportes')->middleware('auth');
Route::resource('/dealer_config', 'Administracion\DealerController')->middleware('auth');
Route::post('/dealer_config/accesos', 'Administracion\DealerController@store_acceso_citas')->name('dealer.accesos')->middleware('auth');
Route::post('/dealer_config/horario', 'Administracion\DealerController@store_horario')->name('dealer.horario')->middleware('auth');
Route::resource('/pdi_mo', 'Administracion\PreDeliveryInspectionMOController')->middleware('auth');

Route::resource('/precios_nuevo', 'Ventas\PrecioNuevoController')->middleware('auth');
Route::resource('/precios_seminuevo', 'Ventas\PrecioSeminuevoController')->middleware('auth');


Route::put('lineaCotizacionMeson/saveDescuento/{id}', 'Repuestos\MesonController@saveDescuento')->name('lineaCotizacionMeson.saveDescuento')->middleware('roles');
Route::post('cotizacionMeson/sendDiscountRequest', 'Repuestos\MesonController@sendDiscountRequest')->name('cotizacionMeson.sendDiscountRequest')->middleware('roles');
Route::post('cotizacionMeson/sendBrandDiscountRequest', 'Repuestos\MesonController@sendBrandDiscountRequest')->name('cotizacionMeson.sendBrandDiscountRequest')->middleware('roles');

Route::resource('reporte', 'Reportes\ReportesController')->middleware('auth');
Route::resource('tipoDanho', 'Administracion\TipoDanhoController')->middleware('roles');
Route::resource('compras', 'Contabilidad\ComprasController', ['as' => 'contabilidad'])->middleware('roles');
Route::get('detalleCompras', 'Contabilidad\ComprasController@detalleCompras')->name('contabilidad.detalleCompras')->middleware('roles');
Route::post('detalleCompras', 'Contabilidad\ComprasController@storeDetalleCompras')->name('contabilidad.detalleCompras.store')->middleware('roles');
Route::resource('proveedores', 'Contabilidad\ProveedoresController', ['as' => 'contabilidad'])->middleware('roles');
Route::post('editarProveedor', 'Contabilidad\ProveedoresController@editarProveedor')->name('contabilidad.proveedores.editarProveedor')->middleware('roles');
Route::resource('citas', 'CRM\CitasController', ['as' => 'crm'])->middleware('roles');
Route::get('seguimientoProactivo', 'CRM\CitasController@seguimientoProactivo')->name('crm.seguimientoProactivo')->middleware('roles');
Route::post('citaReprogramacion', 'CRM\CitasController@reprogramacionCita')->name('crm.reprogramacion')->middleware('roles');
Route::post('cancelarCita', 'CRM\CitasController@cancelarCita')->name('crm.cancelarCita')->middleware('roles');
Route::post('editarCita', 'CRM\CitasController@editarCita')->name('crm.editarCita')->middleware('roles');
Route::resource('clientes', 'Administracion\ClienteController', ['as' => 'administracion'])->middleware('roles');
Route::resource('admrepuesto', 'Administracion\RepuestoController', ['as' => 'administracion'])->middleware('roles');
Route::resource('serviciosTerceros', 'Administracion\ServiciosTercerosController', ['as' => 'administracion'])->middleware('roles');
Route::get('/responsables', 'Administracion\ServiciosTercerosController@getResponsables')->name('administracion.responsables')->middleware('roles');
Route::delete('admin-serviciosTerceros/{id}','Administracion\ServiciosTercerosController@destroy')->name('admin.destroy.servicioTerceros');

Route::get('/reingresoRepuestos', 'Repuestos\ReingresoRepuestosController@index')->name('reingresoRepuestos.index')->middleware('roles');
Route::post('/reingresoRepuestos/store', 'Repuestos\ReingresoRepuestosController@store')->name('reingresoRepuestos.store')->middleware('roles');
Route::get('/reingresoRepuestos/downloadPDF', 'Repuestos\ReingresoRepuestosController@downloadPDF')->name('reingresoRepuestos.downloadPDF')->middleware('roles');

Route::get('/prueba123', function () {
   return App\Modelos\MovimientoRepuesto::getMovimientosBaseQuery();
});

Route::post('/meson/registrarDescuento', 'Repuestos\MesonController@registrarDescuento')->name('meson.registrarDescuento');
Route::post('/meson/aprobarDescuento', 'Repuestos\MesonController@aprobarDescuento')->name('meson.aprobarDescuento');
Route::post('/meson/aprobarDescuentoUnitarios', 'Repuestos\MesonController@aprobarTodosDescuentoUnitarios')->name('meson.aprobarTodosDescuentoUnitarios');
Route::post('/meson/rechazarDescuentoUnitarios', 'Repuestos\MesonController@rechazarTodosDescuentoUnitarios')->name('meson.rechazarTodosDescuentoUnitarios');
Route::post('/meson/rechazarDescuento', 'Repuestos\MesonController@rechazarDescuento')->name('meson.rechazarDescuento');
Route::post('/meson/cerrarCotizacion/{id}', 'Repuestos\MesonController@cerrarCotizacion')->name('meson.cerrarCotizacion');
Route::delete('/meson/reabrirCotizacion/{id}', 'Repuestos\MesonController@reabrirCotizacion')->name('meson.reabrirCotizacion');
Route::post('/meson/venderCotizacion/{id}', 'Repuestos\MesonController@venderCotizacion')->name('meson.venderCotizacion');
Route::post('/meson/entregarVentaCotizacion/', 'Repuestos\MesonController@entregarVentaCotizacion')->name('meson.entregarVentaCotizacion');
Route::get('/meson/notaVentaPDF/', 'DocumentosController@notaVentaMeson')->name('meson.imprimirNotaVenta');
Route::get('/meson/cotizacionPDF/', 'DocumentosController@cotizacionMeson')->name('meson.imprimirCotizacion');
Route::post('/meson/eliminarRepuesto/', 'Repuestos\MesonController@eliminarRepuesto')->name('meson.eliminarRepuesto');
Route::resource('meson', 'Repuestos\MesonController')->middleware('roles');

Route::post('/actualizarImportado', 'Repuestos\DetalleRepuestosController@actualizarImportado')->name('actualizarImportado');
Route::post('/finalizarCotizacion', 'Repuestos\DetalleRepuestosController@finalizarCotizacion')->name('detalleRepuestos.finalizarCotizacion');

Route::get('/crearOC', 'Contabilidad\CrearOCController@index')->name('contabilidad.crearOC');
Route::get('/crearOCVehiculoNuevo', 'Contabilidad\CrearOCController@indexVehiculoNuevo')->name('contabilidad.crearOCVehiculoNuevo');
Route::get('/actualizarOC', 'Contabilidad\ActualizarOCController@index')->name('contabilidad.actualizarOC');
Route::post('/actualizardataOC', 'Contabilidad\ActualizarOCController@update')->name('actualizaroc.update');
Route::post('/storeOC', 'Contabilidad\CrearOCController@store')->name('contabilidad.crearOC.store');


// ***************************** GIANCARLO MONTALVAN - MEJORAMIENTO *******************************
// Route::get('/seguimientoOC', 'Contabilidad\SeguimientoOCController@index')->name('contabilidad.seguimientoOC');
// Usando Datatables
Route::get('seguimientoOC-data', 'Contabilidad\SeguimientoOCController@datatables')->name('seguimientoOC.data');
Route::get('buscar_proveedor/data', 'Contabilidad\CrearOCController@buscar_proveedor')->name('buscar_proveedor.data');
Route::get('buscar_repuesto/data', 'Contabilidad\CrearOCController@buscar_repuesto')->name('buscar_repuesto.data');
Route::get('buscar_vehiculo/data', 'Contabilidad\CrearOCController@buscar_vehiculo')->name('buscar_vehiculo.data');
Route::get('buscar_otroproducto/data', 'Contabilidad\CrearOCController@buscar_otroproducto')->name('buscar_otroproducto.data');
Route::get('empresa_local/data', 'Contabilidad\CrearOCController@empresa_local')->name('empresa_local.data');
Route::get('actualizaEmpresaLocal/data', 'Contabilidad\CrearOCController@empresa_local')->name('actualizaEmpresaLocal.data');
// Route::get('/seguimientoOC', 'Contabilidad\MostrarOCController@index')->name('contabilidad.mostrarOC');
Route::get('/seguimientoOC', 'Contabilidad\MostrarOCController@index')->name('contabilidad.seguimientoOC');
Route::get('mostrar_sucursal/data', 'Contabilidad\MostrarOCController@mostrar_sucursal')->name('mostrar_sucursal.data');
Route::get('mostrar_proveedor/data', 'Contabilidad\MostrarOCController@mostrar_proveedor')->name('mostrar_proveedor.data');
// Datatables - ServerSide
Route::get('mostrarOCDT-data', 'Contabilidad\MostrarOCController@datatables')->name('mostrarOCDT.data');
// ********* Editar OC ***************
// Route::get('/validaOC', 'Contabilidad\MostrarOCController@editarOC')->name('contabilidad.editarOC');
Route::get('actualizar_proveedor.data', 'Contabilidad\ActualizarOCController@actualizar_proveedor')->name('actualizar_proveedor.data');
Route::get('actualizar_repuesto.data', 'Contabilidad\ActualizarOCController@actualizar_repuesto')->name('actualizar_repuesto.data');
Route::get('actualizar_vehiculo.data', 'Contabilidad\ActualizarOCController@actualizar_vehiculo')->name('actualizar_vehiculo.data');
Route::get('actualizar_producto.data', 'Contabilidad\ActualizarOCController@actualizar_producto')->name('actualizar_producto.data');

Route::get('/crearNotaIngreso', 'Contabilidad\CrearNotaIngresoController@index')->name('contabilidad.crearNotaIngreso');
Route::post('/storeNotaIngreso', 'Contabilidad\CrearNotaIngresoController@store')->name('contabilidad.crearNotaIngreso.store');
Route::get('/seguimientoNotasIngreso', 'Contabilidad\SeguimientoNotasIngresoController@index')->name('contabilidad.seguimientoNotasIngreso');
Route::get('/visualizarNI', 'Contabilidad\VisualizarNIController@index')->name('contabilidad.visualizarNI');
Route::post('/ingresarFacturaNI', 'Contabilidad\VisualizarNIController@ingresarFactura')->name('contabilidad.visualizarNI.ingresarFactura');
Route::get('/pagoProveedores', 'Contabilidad\PagoProveedoresController@index')->name('contabilidad.pagoProveedores');
Route::post('/pagoFacturas', 'Contabilidad\PagoProveedoresController@pagoFacturas')->name('contabilidad.pagoProveedores.pagoFactura');
Route::get('/bancos', 'Contabilidad\BancosController@index')->name('contabilidad.bancos');
Route::post('/bancosStore', 'Contabilidad\BancosController@store')->name('contabilidad.bancos.store');

Route::get('/detalleCuenta', function () {
   return view('contabilidadv2.detalleCuenta');
})->name('contabilidad.detalleCuenta');

Route::get('/cobroClientes', function () {
   return view('contabilidadv2.cobroClientes');
})->name('contabilidad.cobroClientes');

Route::get('/generarComprobante', 'Contabilidad\GenerarComprobanteController@index')->name('contabilidad.generarComprobante');
Route::post('/storeComprobante', 'Contabilidad\GenerarComprobanteController@store')->name('contabilidad.generarComprobante.store');
Route::get('historicoPagos', 'Contabilidad\HistoricoPagosController@index')->name('contabilidad.historicoPagos');

Route::get('/visualizarOC', 'Contabilidad\VisualizarOCController@index')->name('contabilidad.visualizarOC');
Route::get('/updateOC', 'Contabilidad\VisualizarOCController@update')->name('contabilidad.updateOC');
Route::post('/eliminarOC', 'Contabilidad\VisualizarOCController@eliminarOC')->name('contabilidad.visualizarOC.eliminarOC');
Route::get('/aprobarOC', 'Contabilidad\VisualizarOCController@cambiarEstado')->name('contabilidad.visualizarOC.aprobarOC');

Route::get('/ingresoFacturas', 'Contabilidad\CrearFacturasController@index')->name('contabilidad.ingresoFacturasInicial');

Route::get('/moduloFacturacion', 'Contabilidad\ModuloFacturasController@index')->name('contabilidad.facturacion')->middleware('auth');
Route::get('/moduloNotaCredito', 'Contabilidad\ModuloNotaCreditoController@index')->name('contabilidad.notaCredito');
Route::get('/seguimientoFacturacion', 'Facturacion\NotaCreditoDebitoController@index')->name('contabilidad.seguimientoFacturacion');
Route::post('/moduloFacturacionStore', 'Contabilidad\ModuloFacturasController@store')->name('contabilidad.facturacion.store');

Route::any('/hoja-inspeccion/listar', 'Ventas\HojaInspeccionController@listView')->name('hojaInspeccion.listView');
Route::get('/crearPDI', 'Ventas\HojaInspeccionController@createView')->name('hojaInspeccion.createView');
Route::any('/hoja-inspeccion/create', 'Ventas\HojaInspeccionController@store')->name('hojaInspeccion.store');
Route::get('/hoja-inspeccion/edit/{id}', 'Ventas\HojaInspeccionController@editView')->name('hojaInspeccion.editView');
Route::get('/hoja-inspeccion/change-state-to-dealer/{id}', 'Ventas\HojaInspeccionController@changeStateToDealer')->name('hojaInspeccion.changeStateToDealer');
Route::get('/hoja-inspeccion/change-state-to-completado/{id}', 'Ventas\HojaInspeccionController@changeStateToCompletado')->name('hojaInspeccion.changeStateToCompletado');
Route::put('/hoja-inspeccion', 'Ventas\HojaInspeccionController@edit')->name('hojaInspeccion.editAction');
// Route::get('/pdiList', 'HojaInspeccionController@listAllPdi')->name('otros.pdiList');

Route::get('/ingresoFacturasFinal', function () {
   return view('contabilidadv2.ingresoFacturasFinal');
})->name('contabilidad.ingresoFacturasFinal');

Route::get('/ingresoFacturas/DetalleOCs', 'Contabilidad\CrearFacturasController@relacionadasOCs')->name('contabilidad.relacionadasOCs');
Route::post('/verNotasDeIngreso', 'Contabilidad\CrearFacturasController@verNotasDeIngreso')->name('contabilidad.verNotasDeIngreso');
Route::post('/crearFactura', 'Contabilidad\CrearFacturasController@store')->name('contabilidad.crearFactura');

Route::get('/seguimientoServiciosTerceros', 'Administracion\SeguimientoServiciosTercerosController@index')->name('seguimientoServiciosTerceros');
Route::get('/visualizarServiciosTerceros', 'Administracion\VisualizarServicioTerceroController@index')->name('visualizarServicioTercero');
Route::post('/visualizarServiciosTercerosStore', 'Administracion\VisualizarServicioTerceroController@store')->name('visualizarServicioTercero.store');
Route::post('/ingresarFacturaOS', 'Administracion\VisualizarServicioTerceroController@ingresarFactura')->name('ordenServicio.ingresarFactura');

Route::post('/registrarVehiculo', 'CarroceriaPintura\RecepcionController@registrarVehiculo')->name('registrarVehiculo')->middleware('roles');
Route::post('/modificarVehiculo', 'CarroceriaPintura\RecepcionController@reasignarOTCotVehiculo')->name('modificarVehiculo');
Route::post('/modificarCliente', 'Administracion\ClienteController@reasignarOTCotCliente')->name('modificarCliente');

Route::post('descuentos/aprobar', 'Administracion\DescuentosController@aprobarDescuento')->name('descuentos.aprobar')->middleware('roles');
Route::post('descuentos/aprobarUni', 'Administracion\DescuentosController@aprobarDescuentoUni')->name('descuentos.aprobarUni')->middleware('roles');
Route::post('descuentos/rechazarUni', 'Administracion\DescuentosController@aprobarDescuentoUni')->name('descuentos.rechazarUni')->middleware('roles');
Route::post('descuentos/rechazar', 'Administracion\DescuentosController@rechazarDescuento')->name('descuentos.rechazar')->middleware('roles');
Route::post('descuentos/rechazarUni', 'Administracion\DescuentosController@rechazarDescuentoUni')->name('descuentos.rechazarUni')->middleware('roles');
Route::resource('descuentos', 'Administracion\DescuentosController')->middleware('roles');
Route::get('descuentosMeson', 'Administracion\DescuentosController@indexDescuentosMeson')->name('descuentos.meson')->middleware('roles');
Route::resource('tipoCambio', 'Administracion\TipoCambioController')->middleware('roles');

Route::get('consultas/historia', 'Consultas\ConsultasController@consultaHistoriaClinica')->name('consultas.historiaClinica')->middleware('roles');

Route::get('consultas/historia/export', 'Consultas\ExportController@historiaClinicaExcel')->name('consultas.historiaClinica.exportExcel')->middleware('roles');
Route::get('consultas/historia/exportPDF', 'Consultas\ExportController@historiaClinicaPDF')->name('consultas.historiaClinica.exportPDF')->middleware('roles');
Route::get('consultas/ots', 'Consultas\ConsultasController@consultaOrdenesTrabajo')->name('consultas.ordenesTrabajo')->middleware('roles');
Route::get('consultas/ots/export', 'Consultas\ExportController@ordenesTrabajoExcel')->name('consultas.ordenesTrabajo.exportExcel')->middleware('roles');
Route::get('consultas/cotizaciones', 'Consultas\ConsultasController@consultaCotizaciones')->name('consultas.cotizaciones')->middleware('roles');
Route::get('consultas/cotizaciones/export', 'Consultas\ExportController@cotizacionesExcel')->name('consultas.cotizaciones.exportExcel')->middleware('roles');
Route::get('consultas/repuestos', 'Consultas\ConsultasController@consultaRepuestos')->name('consultas.repuestos')->middleware('roles');
Route::get('consultas/repuestos/export', 'Consultas\ExportController@repuestosExcel')->name('consultas.repuestos.exportExcel')->middleware('roles');
Route::get('consultas/cotizacion-meson', 'Consultas\ConsultasController@consultaMeson')->name('consultas.meson')->middleware('roles');
Route::get('consultas/cotizacion-meson/export', 'Consultas\ExportController@cotizacionesMesonExcel')->name('consultas.cotizacionesMeson.exportExcel')->middleware('roles');

Route::get('reporteSeguimientoFacturacion', 'Reportes\ExportController@reporteSeguimientoFacturacion')->name('reporteSeguimientoFacturacion')->middleware('roles');

Route::get('reportes/citas', 'Reportes\ReportesController@reporteCitas')->name('reportes.citas')->middleware('roles');
Route::get('reportes/seguimientoGeneral', 'Reportes\ReportesController@seguimientoGeneral')->name('reportes.seguimientoGeneral')->middleware('roles');

Route::get('reportes/seguimientoVentasTaller', 'Reportes\ReportesController@seguimientoVentasTaller')->name('reportes.seguimientoVentasTaller')->middleware('roles');
Route::get('reportes/seguimientoVentasTaller/export', 'Reportes\ExportController@reporteVentasTaller')->name('reportes.seguimientoVentasTaller.export')->middleware('roles');

Route::get('reportes/seguimientoVentasRepuestos', 'Reportes\ReportesController@seguimientoVentasRepuestos')->name('reportes.seguimientoVentasRepuestos')->middleware('roles');
Route::get('reportes/seguimientoVentasRepuestos/export', 'Reportes\ExportController@reporteVentasRepuestos')->name('reportes.seguimientoVentasRepuestos.export')->middleware('roles');

Route::get('reportes/informaRepuestosObsoletos', 'Reportes\ReportesController@informaRepuestosObsoletos')->name('reportes.informaRepuestosObsoletos')->middleware('roles');
Route::get('reportes/informaRepuestosObsoletos/export', 'Reportes\ExportController@informaRepuestosObsoletos')->name('reportes.informaRepuestosObsoletos.export')->middleware('roles');

Route::get('reportes/kardex', 'Reportes\ReportesController@reporteKardex')->name('reportes.kardex')->middleware('roles');
Route::get('reportes/ots', 'Reportes\ReportesController@reporteOts')->name('reportes.ots')->middleware('roles');
Route::get('reportes/ventaRepuestos', 'Reportes\ReportesController@reporteVentaRepuestos')->name('reportes.ventaRepuestos')->middleware('roles');
Route::get('reportes/citas/export', 'Reportes\ExportController@citasExcel')->name('reportes.citas.export')->middleware('roles');
Route::get('reportes/movimientoRepuestos', 'Reportes\ReportesController@reporteMovimientoRepuestos')->name('reportes.movimientoRepuestos')->middleware('roles');
Route::get('reportes/movimientoRepuestos/export', 'Reportes\ExportController@movimientoRepuestosExcel')->name('reportes.movimientoRepuestos.export')->middleware('roles');
Route::get('reportes/productividad', 'Reportes\ReportesController@reporteProductividad')->name('reportes.productividad')->middleware('roles');
Route::get('reportes/productividad/export', 'Reportes\ExportController@productividadExcel')->name('reportes.productividad.export')->middleware('roles');
Route::get('reportes/reporteGeneral', 'Reportes\ReportesController@reporteGeneral')->name('reportes.reporteGeneral')->middleware('roles');
Route::get('reportes/reporteGeneral/export', 'Reportes\ExportController@reporteGeneralExcel')->name('reportes.reporteGeneral.export')->middleware('roles');
Route::get('reportes/ventas', 'Reportes\ReportesController@reporteVentas')->name('reportes.consulta.ventas')->middleware('roles');
Route::get('reportes/ventasMeson', 'Reportes\ReportesController@reporteVentasMeson')->name('reportes.consulta.ventasMeson')->middleware('roles');
Route::get('reportes/ventas/export', 'Reportes\ExportController@reporteVentasExcel')->name('reportes.ventas.export')->middleware('roles');
Route::get('reportes/ventasMeson/export', 'Reportes\ExportController@reporteVentasMesonExcel')->name('reportes.ventasMeson.export')->middleware('roles');

Route::get('reportes/generate/kardex', 'Reportes\ReportesController@generateKardexReport')->name('reportes.consulta.kardex2')->middleware('roles');
Route::get('reportes/generate/kardex2', 'Reportes\ReportesController@generateKardexReport2')->name('reportes.consulta.kardexV2')->middleware('roles');
Route::get('reportes/consulta/kardex', 'Reportes\ConsultaReportesController@consultaKardex')->name('reportes.consulta.kardex')->middleware('roles');
Route::get('reportes/consulta/ventaRepuestos', 'Reportes\ConsultaReportesController@consultaVentaRepuestos')->name('reportes.consulta.ventaRepuestos')->middleware('roles');

Route::get('reportes/consulta/ots', 'Reportes\ConsultaReportesController@consultaOts')->name('reportes.consulta.ots')->middleware('roles');

Route::get('reportes/consulta/cantidadots', 'Reportes\ConsultaReportesController@consultacantidadOts')->name('reportes.consulta.cantidadots')->middleware('roles');

Route::get('reportes/consulta/reporteCitas', 'Reportes\ConsultaReportesController@reporteCitas')->name('reportes.consulta.reporteCitas')->middleware('roles');

Route::get('reportes/consulta/stock', 'Reportes\ConsultaReportesController@consultaStock')->name('reportes.consulta.stock')->middleware('roles');

Route::get('reportes/consulta/reporteModelos', 'Reportes\ConsultaReportesController@reporteModelos')->name('reportes.consulta.reporteModelos')->middleware('roles');

Auth::routes();

Route::get('/home', 'MainMenu\MainMenuController@index')->middleware('roles');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/repuestos_stock/{codigo_repuesto}', 'APIsController@consultarStock');
#Route::put('/asignarDescuentoUnitario/{id}', 'APIsController@asignarDescuentoUnitario');
Route::get('/api/buscarSeguros/{id}', 'APIsController@buscarSeguros');

/* FACTURACIÓN */
Route::get('api/consultaInfoOT/{docRelacionado}', 'Contabilidad\ModuloFacturasController@consultaInfoOT');
Route::get('api/cargarPendientesFacturacion/{docCliente}/{incluirMeson?}', 'Contabilidad\ModuloFacturasController@cargarPendientesFacturacion');
Route::get('api/consultaInfoMeson/{docRelacionado}', 'Contabilidad\ModuloFacturasController@consultaInfoMeson');
Route::get('api/obtenerSerie/{venta}', 'Contabilidad\ModuloFacturasController@obtenerSerie');
Route::get('api/listarAnticipos', 'Contabilidad\ModuloFacturasController@listarAnticipos');
Route::post('api/apiFacturaStore', 'Contabilidad\ModuloFacturasController@apiFacturaStore');

/********** REPORTE COMPRAS*/
Route::get('reportes/compras', 'Reportes\ReporteComprasController@index')->name('reportes.compras');
Route::get('reportes/exportCompras', 'Reportes\ReporteComprasController@excel')->name('reportes.comprasExport');
Route::get('reportes/showCompras', 'Reportes\ReporteComprasController@show')->name('reportes.showResumenCompras');

Route::get('reportes/stock', 'Reportes\ReportesController@consultaStock')->name('reportes.stock')->middleware('roles');

/********** VEhiculos nuevos*/
Route::get('vehiculosNuevos/registrar', 'VehiculosNuevos\VehiculoNuevoController@register')->name('vehiculonuevo.register')->middleware('roles');
Route::get('vehiculosNuevos/consulta', 'VehiculosNuevos\VehiculoNuevoController@index')->name('vehiculonuevo.index')->middleware('roles');
Route::post('vehiculosNuevos/store', 'VehiculosNuevos\VehiculoNuevoController@store')->name('vehiculonuevo.store')->middleware('roles');
Route::get('vehiculosNuevos/consulta/{id}', 'VehiculosNuevos\VehiculoNuevoController@show')->name('vehiculonuevo.show')->middleware('roles');

Route::get('vehiculosNuevos/delete/{id}', 'VehiculosNuevos\VehiculoNuevoController@destroy')->name('vehiculonuevo.delete')->middleware('roles');
Route::get('/sugerenciasModeloComercial/{strModelo}', 'APIsController@buscarModeloComercialSugerencia');
Route::post('vehiculosNuevos/filter', 'VehiculosNuevos\VehiculoNuevoController@filter')->name('vehiculonuevo.filter')->middleware('roles');
Route::post('vehiculosNuevos/findModeloComercial', 'VehiculosNuevos\VehiculoNuevoController@findModeloComercial')->name('vehiculonuevo.findModeloComercial')->middleware('roles');

// ************** OTROS PRODUCTOS Y SERVICIOS - GIANCARLO MONTALVAN *********************
Route::resource('otros_productos', 'ProductosOtros\OtroProductoServicioController')->middleware('roles');
Route::get('otros_productos-data', 'ProductosOtros\OtroProductoServicioController@datatables')->name('otros_productos.data')->middleware('roles');
Route::post('otros_productos/update', 'ProductosOtros\OtroProductoServicioController@update')->name('otros_productos.update')->middleware('roles');
Route::get('otros_productos/destroy/{id}', 'ProductosOtros\OtroProductoServicioController@destroy')->middleware('roles');

// ************************************************************************************

Route::get("/get-all/{id}", 'Garantias\GarantiasController@getAll');
Route::get("/taller/{id}", 'Garantias\GarantiasController@taller');
Route::post("/profiles/modulo", 'Administracion\ProfilesController@modular');
// Route::get('r', function()
// {
//     header('Content-Type: application/excel');
//     header('Content-Disposition: attachment; filename="routes.csv"');

//     $routes = Route::getRoutes();
//     $fp = fopen('php://output', 'w');
//     fputcsv($fp, ['METHOD', 'URI', 'NAME', 'ACTION']);
//     foreach ($routes as $route) {
//         fputcsv($fp, [head($route->methods()) , $route->uri(), $route->getName(), $route->getActionName()]);
//     }
//     fclose($fp);
// });

Route::get('probarhojaConstancia', function() {
    return redirect()->route('hojaConstancia', [
        'seccion' => 'MESON',
        'documento' => 683
    ]);
});



Route::get('ingresoregular/{id}', 'Repuestos\IngresoRegularController@index')->name('ingresoregular.index')->middleware('roles');
Route::get('showIngresoregular/{id_nota_ingreso}', 'Repuestos\IngresoRegularController@show')->name('ingresoregular.show')->middleware('roles');
Route::post('ingresoregular/store', 'Repuestos\IngresoRegularController@store')->name('ingresoRegular.store')->middleware('roles');
Route::post('ingresoregular/update', 'Repuestos\IngresoRegularController@update')->name('ingresoRegular.update')->middleware('roles');

// VEHICULOS SEMINUEVOS
Route::get('crearOCVehiculoSeminuevo/index','VehiculoSeminuevo\OCVehiculoSeminuevoController@index')->name('vehiculo_seminuevo.crear_oc.index')->middleware('roles');
Route::get('crearOCVehiculoSeminuevo','VehiculoSeminuevo\OCVehiculoSeminuevoController@create')->name('vehiculo_seminuevo.crear_oc')->middleware('roles');
Route::post('OCVehiculoSeminuevo/store','VehiculoSeminuevo\OCVehiculoSeminuevoController@store')->name('vehiculo_seminuevo.store')->middleware('roles');
Route::get('/visualizarOCSeminuevo', 'VehiculoSeminuevo\OCVehiculoSeminuevoController@show')->name('vehiculo_seminuevo.show')->middleware('roles');
Route::get('/visualizarOCSeminuevo2', 'VehiculoSeminuevo\OCVehiculoSeminuevoController@show')->name('ingreso_vehiculo_seminuevo.show')->middleware('roles');
Route::get('ingresoVehiculo', 'Contabilidad\CrearNotaIngresoController@crearIngresoVehiculo')->name('ingreso_vehiculo_seminuevo.show')->middleware('roles');
Route::get('/buscarDataVehiculoNuevo/{vin}', 'VehiculoSeminuevo\OCVehiculoSeminuevoController@buscarDataVehiculoNuevo');
Route::get('/buscarDataVehiculoSeminuevo/{placa}', 'VehiculoSeminuevo\OCVehiculoSeminuevoController@buscarDataVehiculoSeminuevo');
Route::post('ingresoVehiculoNuevo', 'VehiculosNuevos\IngresoVehiculoNuevoController@store')->name('ingresoVehiculoNuevo');
Route::post('ingresoVehiculoSeminuevo', 'VehiculoSeminuevo\IngresoVehiculoSeminuevoController@store')->name('ingresoVehiculoSeminuevo');