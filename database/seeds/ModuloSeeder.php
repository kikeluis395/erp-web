<?php

use App\Modelos\Permiso;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $nuevos_submodulos =  [
            [
                'descripcion' => 'Facturación',
                'nombre_interno' => 'submodulo_facturacion',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Notas de Credito',
                'nombre_interno' => 'submodulo_notasCredito',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Seguimiento Facturación',
                'nombre_interno' => 'submodulo_seguimientoFacturacion',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Consulta Mesón',
                'nombre_interno' => 'submodulo_consultaMeson',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Reporte Venta Repuestos',
                'nombre_interno' => 'submodulo_reporteVentaRepuestos',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Reporte OTS',
                'nombre_interno' => 'submodulo_reporteOTS',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Inventario',
                'nombre_interno' => 'submodulo_reporteInventario',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Reporte de Ventas',
                'nombre_interno' => 'submodulo_reporteVentas',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Reporte de Stock',
                'nombre_interno' => 'submodulo_reporteStock',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Informe Repuestos Obsoletos',
                'nombre_interno' => 'submodulo_reporteRepuestosObsoletos',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Seguimiento Ventas Repuestos',
                'nombre_interno' => 'submodulo_reporteSeguimientoVentasRepuestos',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Seguimiento Ventas Taller',
                'nombre_interno' => 'submodulo_reporteSeguimientoVentasTaller',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Seguimiento General',
                'nombre_interno' => 'submodulo_reporteSeguimientoGeneral',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Reporte Seguimiento OTS',
                'nombre_interno' => 'submodulo_reporteSeguimientoOT',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Detalle Ventas Mesón',
                'nombre_interno' => 'submodulo_reporteDetalleVentasMeson',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Detalle Ventas MEC-BYP',
                'nombre_interno' => 'submodulo_reporteDetalleVentasMECBYP',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Reporte Seguimiento de Citas',
                'nombre_interno' => 'submodulo_reporteSeguimientoCitas',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Kardex',
                'nombre_interno' => 'submodulo_reporteKardex',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Reporte de Compras',
                'nombre_interno' => 'submodulo_reporteCompras',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Reporte Seguimiento Modelo',
                'nombre_interno' => 'submodulo_reporteSeguimientoModelo',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Crear PDI',
                'nombre_interno' => 'submodulo_crearPDI',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Seguimiento PDI',
                'nombre_interno' => 'submodulo_seguimientoPDI',
                'habilitado' => '1',
                'tipo' => 'submodulo'
            ],
            [
                'descripcion' => 'Ventas',
                'nombre_interno' => 'modulo_ventas',
                'habilitado' => '1',
                'tipo' => 'modulo'
            ]
        ];

        foreach ($nuevos_submodulos as $submodule) DB::table('permiso')->insert($submodule);

    }
}
