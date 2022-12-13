<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use App\User;
use App\Modelos\CitaEntrega;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Reportes\ReportesController;

use App\Exports\TestExportFromView;
use App\Modelos\Modelo;
use App\Modelos\ModeloTecnico;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth;
use DB;
use DateTime;

class ExportController extends Controller
{
    public function index()
    {
        $fechaInicio = null;
        $fechaFin = null;
        if ($_GET["fechaInicioReporte"])
            $fechaInicio = Carbon::createFromFormat('!d/m/Y', $_GET["fechaInicioReporte"]);

        if ($_GET["fechaFinReporte"])
            $fechaFin = Carbon::createFromFormat('!d/m/Y', $_GET["fechaFinReporte"]);

        if (Auth::user()->id_rol == 1) {
            $nombreArchivo = 'Bitácora_ADMINISTRADOR.xlsx';
        } else {
            $nombreLocal = Auth::user()->empleado()->first()->local()->first()->nombre_local;
            $nombreArchivo = 'Bitácora_' . $nombreLocal . '.xlsx';
        }
        return Excel::download(new TestExportFromView($fechaInicio, $fechaFin), $nombreArchivo);
    }

    public function getCitas(Request $request)
    {
        $fechaIni = $request->fechaIni ? Carbon::createFromFormat('!d/m/Y', $request->fechaIni)->format('Y-m-d') : "";
        $fechaFin = $request->fechaFin ? Carbon::createFromFormat('!d/m/Y', $request->fechaFin)->format('Y-m-d 23:59:59') : "";
        $idAsesor = $request->asesor == 'all' ? null : $request->asesor;
        $estado = $request->estado;

        $listaCitas = CitaEntrega::with(['vehiculo', 'cliente', 'empleado']);

        if ($fechaIni) {
            $listaCitas = $listaCitas->where('fecha_cita', '>=', $fechaIni);
        }

        if ($fechaFin) {
            $listaCitas = $listaCitas->where('fecha_cita', '<=', $fechaFin);
        }

        if ($idAsesor) {
            $listaCitas = $listaCitas->where('dni_empleado', $idAsesor);
        }


        if ($estado && $estado != 'all') {
            $puntoComparacion = Carbon::now();
            switch ($estado) {
                case 'asistio':
                    $listaCitas = $listaCitas->where('asistio', 1)->where('habilitado', 1);
                    break;
                case 'pendiente':
                    $listaCitas = $listaCitas->where('fecha_cita', '>=', $puntoComparacion)->where('habilitado', 1)->where('asistio', 0);
                    break;
                case 'no_asistio':
                    $listaCitas = $listaCitas->where('fecha_cita', '<', $puntoComparacion)->where('habilitado', 1)->where('asistio', 0);
                    break;
                case 'cancelado':
                    $listaCitas = $listaCitas->where('habilitado', 0);
                    break;
                default:
                    break;
            }
        }
        $listaCitas = $listaCitas->orderBy('fecha_cita', 'asc')->get();

        return $listaCitas;
    }

    public function citasExcel(Request $request)
    {
        if (!is_null($request->fechaIni) && !is_null($request->fechaFin) && (!DateTime::createFromFormat('d/m/Y', $request->fechaIni) || !DateTime::createFromFormat('d/m/Y', $request->fechaFin))) {
            return redirect()->route('crm.citas.index')->with('errorFechas', 'El formato de las fechas ingresadas es incorrecto');
        }
        $ini = Carbon::createFromFormat('d/m/Y', $request->fechaIni)->format('dmy');
        $fin = Carbon::createFromFormat('d/m/Y', $request->fechaFin)->format('dmy');
        $listaCitas = $this->getCitas($request);
        $nombreArchivo = "CITAS_$ini" . "_" . "$fin.xlsx";

        return Excel::download(new ExportCitasFromViewController($listaCitas), $nombreArchivo);
    }

    public function kardexExcel(Request $request)
    {

        $nombreArchivo = "REPORTE_KARDEX.xlsx";
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;
        $idRepuesto = null;
        if (!is_null($request->idRepuesto)) {
            $idRepuesto = $request->idRepuesto;
        }
        $resultados = ReportesController::getListSpare($idRepuesto, $fechaInicial, $fechaFinal);


        return Excel::download(new ExportReporteKardexController($resultados), $nombreArchivo);
        // return Excel::download(new ExportReporteKardexController($resultados), $nombreArchivo);
    }

    public function ventaRepuestosExcel(Request $request)
    {
        $nombreArchivo = "REPORTE_VENTA_REPUESTOS.xlsx";
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;
        $resultados = DB::select("select * from tmp_reporte_venta_repuestos where fecha_factura BETWEEN '$fechaInicial' and '$fechaFinal'");

        return Excel::download(new ExportReporteVentaRepuestosController($resultados), $nombreArchivo);
    }

    public function otsExcel(Request $request)
    {
        $nombreArchivo = "REPORTE_OTS.xlsx";
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;
        $resultados =  DB::select("select DISTINCT * from tmp_consultas_ots where fecha_apertura BETWEEN '$fechaInicial' and '$fechaFinal'");
        $resumenCantidades = DB::select("
            select SECCION, 
                    sum(case when tipo_ot='CORRECTIVO' then 1 else 0 end) CORRECTIVO,
                    sum(case when tipo_ot='PREVENTIVO' then 1 else 0 end) PREVENTIVO,
                    sum(case when tipo_ot='RECLAMO' then 1 else 0 end) RECLAMO,
                    sum(case when tipo_ot='GARANTIA' then 1 else 0 end) GARANTIA,
                    sum(case when tipo_ot='PDI' then 1 else 0 end) PDI,
                    sum(case when tipo_ot='SINIESTRO' then 1 else 0 end) SINIESTRO,
                    sum(case when tipo_ot='CORTESIA' then 1 else 0 end) CORTESIA,
                    sum(case when tipo_ot='ACCESORIOS' then 1 else 0 end) ACCESORIOS
            from tmp_consultas_ots
            where fecha_apertura BETWEEN '$fechaInicial' and '$fechaFinal'
            group by SECCION
        ");

        $resumenFacturacion = DB::select(
            "
            select SECCION, 
                    sum(case when tipo_ot='CORRECTIVO' then venta_total - dscto_total else 0 end) CORRECTIVO,
                    sum(case when tipo_ot='PREVENTIVO' then venta_total - dscto_total else 0 end) PREVENTIVO,
                    sum(case when tipo_ot='RECLAMO' then venta_total - dscto_total else 0 end) RECLAMO,
                    sum(case when tipo_ot='GARANTIA' then venta_total - dscto_total else 0 end) GARANTIA,
                    sum(case when tipo_ot='PDI' then venta_total - dscto_total else 0 end) PDI,
                    sum(case when tipo_ot='SINIESTRO' then venta_total - dscto_total else 0 end) SINIESTRO,
                    sum(case when tipo_ot='CORTESIA' then venta_total - dscto_total else 0 end) CORTESIA,
                    sum(case when tipo_ot='ACCESORIOS' then venta_total - dscto_total else 0 end) ACCESORIOS
            from tmp_consultas_ots
            where BINARY estado_ot= BINARY 'ENTREGADO' and fecha_apertura BETWEEN '$fechaInicial' and '$fechaFinal'
            group by SECCION"
        );

        return Excel::download(new ExportReporteOtsContainerController($resultados, $resumenCantidades, $resumenFacturacion), $nombreArchivo);
    }

    public function reporteGeneralExcel(Request $request)
    {
        $nombreArchivo = "REPORTE_GENERAL_XXXXXXXX.xlsx";
        return Excel::download(new ExportReporteGeneralFromViewController([]), $nombreArchivo);
    }

    public function productividadExcel(Request $request)
    {
        $nombreArchivo = "REPORTE_PRODUCTIVIDAD_XXXXXXXX.xlsx";
        return Excel::download(new ExportProductividadFromViewController(), $nombreArchivo);
    }

    public function movimientoRepuestosExcel(Request $request)
    {
        $nombreArchivo = "REPORTE_MOVIMIENTO_RPTOS_XXXXXXXX.xlsx";
        return Excel::download(new ExportMovimientoRepuestosFromViewController(), $nombreArchivo);
    }

    public function reporteVentasExcel(Request $request)
    {
        ini_set('memory_limit', '1024M');

        $fechaAperturaIni = $request->fechaAperturaIni ? Carbon::createFromFormat('!d/m/Y', $request->fechaAperturaIni) : false;
        $fechaAperturaFin = $request->fechaAperturaFin ? Carbon::createFromFormat('!d/m/Y', $request->fechaAperturaFin) : false;
        $fechaFacturaIni = $request->fechaFacturaIni ? Carbon::createFromFormat('!d/m/Y', $request->fechaFacturaIni) : false;
        $fechaFacturaFin = $request->fechaFacturaFin ? Carbon::createFromFormat('!d/m/Y', $request->fechaFacturaFin) : false;

        $fechaIniNombre = $fechaAperturaIni ? $fechaAperturaIni->format('Ymd') : $fechaFacturaIni->format('Ymd');
        $fechaFinNombre = $fechaAperturaFin ? $fechaAperturaFin->format('Ymd') : $fechaFacturaFin->format('Ymd');

        $fechaIni = $fechaAperturaIni ? $fechaAperturaIni->format('Y-m-d') : $fechaFacturaIni->format('Y-m-d');
        $fechaFin = $fechaAperturaFin ? $fechaAperturaFin->format('Y-m-d') : $fechaFacturaFin->format('Y-m-d');

        $nombreArchivo = "REPORTE_VENTAS_${fechaIniNombre}_${fechaFinNombre}.xlsx";

        if ($fechaAperturaIni && $fechaAperturaFin) {
            $resultadosTaller = DB::select("select * from tmp_reporte_ventas_taller_v2 where fecha_apertura_ot between '$fechaIni' and '$fechaFin'");
        } else {
            $resultadosTaller = DB::select("select * from tmp_reporte_ventas_taller_v2 where fecha_fact between '$fechaIni' and '$fechaFin'");
        }

        return Excel::download(new ExportReporteVentasContainerController($resultadosTaller), $nombreArchivo);
    }

    public function reporteVentasMesonExcel(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $fechaAperturaIni = $request->fechaAperturaIni ? Carbon::createFromFormat('!d/m/Y', $request->fechaAperturaIni) : false;
        $fechaAperturaFin = $request->fechaAperturaFin ? Carbon::createFromFormat('!d/m/Y', $request->fechaAperturaFin) : false;
        $fechaFacturaIni = $request->fechaFacturaIni ? Carbon::createFromFormat('!d/m/Y', $request->fechaFacturaIni) : false;
        $fechaFacturaFin = $request->fechaFacturaFin ? Carbon::createFromFormat('!d/m/Y', $request->fechaFacturaFin) : false;

        $fechaIniNombre = $fechaAperturaIni ? $fechaAperturaIni->format('Ymd') : $fechaFacturaIni->format('Ymd');
        $fechaFinNombre = $fechaAperturaFin ? $fechaAperturaFin->format('Ymd') : $fechaFacturaFin->format('Ymd');

        $fechaIni = $fechaAperturaIni ? $fechaAperturaIni->format('Y-m-d') : $fechaFacturaIni->format('Y-m-d');
        $fechaFin = $fechaAperturaFin ? $fechaAperturaFin->format('Y-m-d') : $fechaFacturaFin->format('Y-m-d');

        $nombreArchivo = "REPORTE_VENTAS_MESON_${fechaIniNombre}_${fechaFinNombre}.xlsx";
        if ($fechaAperturaIni && $fechaAperturaFin) {
            $resultadosMeson = DB::select("select * from tmp_reporte_ventas_meson_v2 where fecha_apertura between '$fechaIni' and '$fechaFin'");
        } else {
            $resultadosMeson = DB::select("select * from tmp_reporte_ventas_meson_v2 where fecha_factura between '$fechaIni' and '$fechaFin'");
        }

        return Excel::download(new ExportReporteVentasMesonContainerController($resultadosMeson), $nombreArchivo);
    }

    public function reporteSeguimientoFacturacion()
    {
        $request = request()->datos;
        $datos = \App\Http\Controllers\Facturacion\NotaCreditoDebitoController::obtenerComprobantes($request);

        return Excel::download(new ExportReporteSeguimientoFacturacionController($datos), 'REPORTE_SEGUIMIENTO_FACTURACION.xlsx');
    }

    public function reporteVentasTaller()
    {
        ini_set('memory_limit', '1024M');
        $anio = request()->anio;

        $nombreArchivo = "REPORTE_VENTAS_TALLER_{$anio}.xlsx";

        $resultadosTaller = DB::select("select * from tmp_reporte_ventas_taller_v2 where YEAR(fecha_fact) = {$anio}");

        $tipo = 'TALLER';

        return Excel::download(new ExportReporteVentasContainerController($resultadosTaller, $tipo), $nombreArchivo);
    }

    public function informaRepuestosObsoletos()
    {
        ini_set('memory_limit', '1024M');
        $anio = (int) request()->anio;
        $id_local = (int) request()->id_local;

        $nombreArchivo = "REPORTE_INFORMES_REPUESTOS_OBSOLETOS_{$anio}.xlsx";

        $resultados = DB::select("CALL sp_ObsolenciaExport(?, ?)", [$id_local, $anio]);

        return Excel::download(new ExportReporteInformesRepuestosObsoletosController($resultados), $nombreArchivo);
    }

    public function reporteVentasRepuestos()
    {
        ini_set('memory_limit', '1024M');
        $anio = (int) request()->anio;
        $id_local = (int) request()->id_local;

        $nombreArchivo = "REPORTE_VENTAS_RPTOS_{$anio}.xlsx";

        $resultadosTaller = DB::select("CALL sp_reporte_ventas_taller_rptos(?, ?)", [$id_local, $anio]);
        $resultadosMeson = DB::select("CALL sp_reporte_ventas_meson_por_anio(?, ?)", [$id_local, $anio]);

        $tipo1 = 'TALLER';
        $tipo2 = 'MESON';


        //XQ LA CONSULTA TRAE NUMBER EL MODELO Y SE DEBE DEVOLVER EL NOMBRE DEL MODELO NO UN NUMERO
        $resultadosTaller = $this->map_modelo($resultadosTaller);
        ////

        return Excel::download(new ExportReporteVentasContainerController($resultadosTaller, $tipo1, $resultadosMeson, $tipo2), $nombreArchivo);
    }

    public function stockExcel(Request $request)
    {
        $nombreArchivo = "REPORTE_STOCK.xlsx";

        $local_t = $request->local_ot;
        $mes = $request->mes;
        $anio = $request->anio;

        $resultados = DB::select("CALL sp_ConsultaStock(?, ?, ?)", [$local_t, $mes, $anio]);


        return Excel::download(new ExportReporteStockController($resultados), $nombreArchivo);
    }


    /////
    public function map_modelo($taller)
    {
        $arr = [];
        foreach ($taller as $key => $value) {
            if(is_numeric($value->modelo)){
                $modelo = ModeloTecnico::find($value->modelo);
                if ($modelo) $value->modelo = $modelo->nombre_modelo;
            }
            array_push($arr, $value);
        }
        return $arr;
    }
    ///////
}
