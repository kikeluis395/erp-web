<?php

use App\Modelos\Permiso;
use Illuminate\Database\Seeder;

class MapeoModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $m1 = Permiso::where('nombre_interno', 'modulo_carroceriaPintura')->get()->first()->id_permiso;
        $m2 = Permiso::where('nombre_interno', 'modulo_mecanica')->get()->first()->id_permiso;
        $m3 = Permiso::where('nombre_interno', 'modulo_tecnicos')->get()->first()->id_permiso;
        $m4 = Permiso::where('nombre_interno', 'modulo_repuestos')->get()->first()->id_permiso;
        $m5 = Permiso::where('nombre_interno', 'modulo_logistica')->get()->first()->id_permiso;
        $m6 = Permiso::where('nombre_interno', 'modulo_facturacion')->get()->first()->id_permiso;
        $m7 = Permiso::where('nombre_interno', 'modulo_crm')->get()->first()->id_permiso;
        $m8 = Permiso::where('nombre_interno', 'modulo_garantias')->get()->first()->id_permiso;
        $m9 = Permiso::where('nombre_interno', 'modulo_contabilidad')->get()->first()->id_permiso;
        $m10 = Permiso::where('nombre_interno', 'modulo_consultas')->get()->first()->id_permiso;
        $m11 = Permiso::where('nombre_interno', 'modulo_reportes')->get()->first()->id_permiso;
        $m12 = Permiso::where('nombre_interno', 'modulo_administracion')->get()->first()->id_permiso;
        $m13 = Permiso::where('nombre_interno', 'modulo_ventas')->get()->first()->id_permiso;

        $modulo_carroceriaPintura = ['submodulo_crearOTByP', 'submodulo_segAprobacionByP', 'submodulo_segReparacionByP', 'submodulo_segOTsByP', 'submodulo_crearCotizacionByP', 'submodulo_segCotizacionByP'];
        $modulo_mecanica = ['submodulo_crearOTMec', 'submodulo_segReparacionMec', 'submodulo_segOTsMec', 'submodulo_crearCotizacionMec', 'submodulo_segCotizacionMec'];
        $modulo_tecnicos = ['submodulo_tecnicosMEC', 'submodulo_tecnicosByP'];
        $modulo_repuestos = ['submodulo_solicitudesTallerOts', 'submodulo_solicitudesTallerCotizaciones', 'submodulo_crearCotizacionRepuestos', 'submodulo_segCotizacionRepuestos'];
        $modulo_logistica = ['submodulo_seguimientoOS', 'submodulo_crearOC', 'submodulo_seguimientoOC', 'submodulo_crearNotaIngreso', 'submodulo_seguimientoNotasIngreso', 'submodulo_maestroRepuestos', 'submodulo_maestroServiciosTerceros', 'submodulo_gestionProveedores', 'submodulo_consultaRepuestos'];
        $modulo_facturacion = ['submodulo_entrega', 'submodulo_facturacion', 'submodulo_notasCredito', 'submodulo_seguimientoFacturacion'];
        $modulo_crm = ['submodulo_tableroCitas'];
        $modulo_garantias = ['submodulo_seguimientoGarantias'];
        $modulo_contabilidad = ['submodulo_gestionCompras', 'submodulo_seguimientoNotasIngreso', 'submodulo_ingresoFactura', 'submodulo_pagoProveedores', 'submodulo_bancos', 'submodulo_cobroClientes', 'submodulo_generarComprobante', 'submodulo_historicoPagos'];
        $modulo_consultas = ['submodulo_consultaOTs', 'submodulo_consultaCotizaciones', 'submodulo_historiaClinica', 'submodulo_consultaMeson'];
        $modulo_reportes = ['submodulo_reporteCitas', 'submodulo_movimientoRepuestos', 'submodulo_reporteProductividad', 'submodulo_reporteGeneral', 'submodulo_reporteVentaRepuestos', 'submodulo_reporteOTS', 'submodulo_reporteInventario', 'submodulo_reporteVentas', 'submodulo_reporteStock', 'submodulo_reporteRepuestosObsoletos', 'submodulo_reporteSeguimientoVentasRepuestos', 'submodulo_reporteSeguimientoVentasTaller', 'submodulo_reporteSeguimientoGeneral', 'submodulo_reporteSeguimientoOT', 'submodulo_reporteDetalleVentasMeson', 'submodulo_reporteDetalleVentasMECBYP', 'submodulo_reporteSeguimientoCitas', 'submodulo_reporteKardex', 'submodulo_reporteCompras', 'submodulo_reporteSeguimientoModelo'];
        $modulo_administracion = ['submodulo_descuentos', 'submodulo_bypMO', 'submodulo_mecMO', 'submodulo_perfiles', 'submodulo_configuracionDealer', 'submodulo_tipoCambio'];
        $modulo_ventas = ['submodulo_crearPDI', 'submodulo_seguimientoPDI',];


        $permisos = Permiso::all();
        foreach ($permisos as $permiso) {
            $nombre = $permiso->nombre_interno;
            $arrage = explode('_', $nombre);
            if (count($arrage) === 2) {
                $descripcion = $permiso->descripcion;
                $descripcion = str_replace('acceso a submódulo llamado ', '', $descripcion);
                $descripcion = str_replace('acceso a módulo ', '', $descripcion);
                $descripcion = str_replace('llamado ', '', $descripcion);

                $tipo = $arrage[0];

                if (in_array($nombre, $modulo_carroceriaPintura)) $modulo = $m1;
                else if (in_array($nombre, $modulo_mecanica)) $modulo = $m2;
                else if (in_array($nombre, $modulo_tecnicos)) $modulo = $m3;
                else if (in_array($nombre, $modulo_repuestos)) $modulo = $m4;
                else if (in_array($nombre, $modulo_logistica)) $modulo = $m5;
                else if (in_array($nombre, $modulo_facturacion)) $modulo = $m6;
                else if (in_array($nombre, $modulo_crm)) $modulo = $m7;
                else if (in_array($nombre, $modulo_garantias)) $modulo = $m8;
                else if (in_array($nombre, $modulo_contabilidad)) $modulo = $m9;
                else if (in_array($nombre, $modulo_consultas)) $modulo = $m10;
                else if (in_array($nombre, $modulo_reportes)) $modulo = $m11;
                else if (in_array($nombre, $modulo_administracion)) $modulo = $m12;
                else if (in_array($nombre, $modulo_ventas)) $modulo = $m13;
                else $modulo = null;
                
                if ($tipo === 'submodulo' && is_null($modulo)) $permiso->delete();
                else {
                    $categoria = 'ADMIN';
                    if ($modulo === $m11) $categoria = 'REPORTE';
                    $permiso->descripcion = $descripcion;
                    $permiso->tipo = $tipo;
                    $permiso->modulo = $modulo;
                    $permiso->categoria = $categoria;
                    $permiso->save();
                }
            }
        }
    }
}
