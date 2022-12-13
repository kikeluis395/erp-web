<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Modelos\LineaOrdenCompra;
use App\Modelos\NotaIngreso;
use App\Modelos\Proveedor;
use App\Modelos\TipoCambio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('reportes.consultaReporteCompras', ['resultados' => null]);
    }

    public function show(Request $request)
    {
        $moneda = $request->moneda;
        $year = $request->ano;

        $resultados = $this->getResumenReport($moneda, $year);
        return view('reportes.consultaReporteCompras', ['resultados' => $resultados, 'year' => substr($year,-2), 'current' => $moneda]);
    }

    public function excel()
    {

        $resultados = $this->getReportDetail();
        $nombreArchivo = "REPORTE_COMPRAS.xlsx";
        return Excel::download(new ExportReporteComprasController($resultados), $nombreArchivo);

    }

    private function getResumenReport($moneda, $year)
    {

        if ($moneda == "DOLARES") {
            $text_current = "$ ";
        } else {
            $text_current = "S/. ";
        }

        $resultados = (array) $this->getReportDetail();

        $proveedores = Proveedor::all();
        $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $resumen = [];
        $total_jan = 0;
        $total_feb = 0;
        $total_mar = 0;
        $total_apr = 0;
        $total_may = 0;
        $total_jun = 0;
        $total_jul = 0;
        $total_aug = 0;
        $total_sep = 0;
        $total_oct = 0;
        $total_nov = 0;
        $total_dec = 0;

        foreach ($proveedores as $key => $proveedor) {
            $ruc_proveedor = $proveedor->num_doc;
            $nombre_proveedor = $proveedor->nombre_proveedor;
            $result_per_month_and_provider = [];
            $acumulated_purchases_per_year_dolar = 0;

            foreach ($months as $month) {

                $accumulated_purchases_per_month_dolar = 0;

                $year_month = $year . '-' . $month;
               
                foreach ($resultados as $row) {

                    $date = Carbon::createFromFormat('d/m/Y', $row['fecha'])->format('Y-m');
                    if ($row['ruc_proveedor'] == $ruc_proveedor && $date == $year_month) {
                        if ($moneda == "DOLARES") {
                            $accumulated_purchases_per_month_dolar += $row['costo_dolar'];
                        } else {
                            $accumulated_purchases_per_month_dolar += $row['costo_sol'];
                        }

                        unset($resultados[$key]);
                    }

                }
                $acumulated_purchases_per_year_dolar += $accumulated_purchases_per_month_dolar;

                $tmp = ['year_month' => $year_month,
                    'accumulated_purchases_per_month_dolar' => $accumulated_purchases_per_month_dolar,

                ];

                array_push($result_per_month_and_provider, $tmp);

                //calculando total del mes
                switch ($month) {
                    case '01':
                        $total_jan += $accumulated_purchases_per_month_dolar;
                        break;
                    case '02':
                        $total_feb += $accumulated_purchases_per_month_dolar;
                        break;
                    case '03':
                        $total_mar += $accumulated_purchases_per_month_dolar;
                        break;
                    case '04':
                        $total_apr += $accumulated_purchases_per_month_dolar;
                        break;
                    case '05':
                        $total_may += $accumulated_purchases_per_month_dolar;
                        break;
                    case '06':
                        $total_jun += $accumulated_purchases_per_month_dolar;
                        break;
                    case '07':
                        $total_jul += $accumulated_purchases_per_month_dolar;
                        break;
                    case '08':
                        $total_aug += $accumulated_purchases_per_month_dolar;
                        break;
                    case '09':
                        $total_sep += $accumulated_purchases_per_month_dolar;
                        break;
                    case '10':
                        $total_oct += $accumulated_purchases_per_month_dolar;
                        break;
                    case '11':
                        $total_nov += $accumulated_purchases_per_month_dolar;
                        break;
                    case '12':
                        $total_dec += $accumulated_purchases_per_month_dolar;
                        break;
                }
            }

            //FORMATTING OUTPUT
            if ($acumulated_purchases_per_year_dolar > 0) {
                $row_resumen = [
                    'ruc_proveedor' => $ruc_proveedor,
                    'nombre_proveedor' => $nombre_proveedor,
                    '01' => $result_per_month_and_provider[0]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[0]['accumulated_purchases_per_month_dolar']) : '-',
                    '02' => $result_per_month_and_provider[1]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[1]['accumulated_purchases_per_month_dolar']) : '-',
                    '03' => $result_per_month_and_provider[2]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[2]['accumulated_purchases_per_month_dolar']) : '-',
                    '04' => $result_per_month_and_provider[3]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[3]['accumulated_purchases_per_month_dolar']) : '-',
                    '05' => $result_per_month_and_provider[4]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[4]['accumulated_purchases_per_month_dolar']) : '-',
                    '06' => $result_per_month_and_provider[5]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[5]['accumulated_purchases_per_month_dolar']) : '-',
                    '07' => $result_per_month_and_provider[6]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[6]['accumulated_purchases_per_month_dolar']) : '-',
                    '08' => $result_per_month_and_provider[7]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[7]['accumulated_purchases_per_month_dolar']) : '-',
                    '09' => $result_per_month_and_provider[8]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[8]['accumulated_purchases_per_month_dolar']) : '-',
                    '10' => $result_per_month_and_provider[9]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[9]['accumulated_purchases_per_month_dolar']) : '-',
                    '11' => $result_per_month_and_provider[10]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[10]['accumulated_purchases_per_month_dolar']) : '-',
                    '12' => $result_per_month_and_provider[11]['accumulated_purchases_per_month_dolar'] > 0 ? $text_current . round($result_per_month_and_provider[11]['accumulated_purchases_per_month_dolar']) : '-',
                    'total' => $acumulated_purchases_per_year_dolar,
                ];
                array_push($resumen, $row_resumen);
            }
           

        }
        $total=[
            'ruc_proveedor' => 'TOTAL',
            'nombre_proveedor' => '',
            '01' => $text_current. round($total_jan),
            '02' => $text_current. round($total_feb),
            '03' => $text_current. round($total_mar),
            '04' => $text_current. round($total_apr),
            '05' => $text_current. round($total_may),
            '06' => $text_current. round($total_jun),
            '07' => $text_current. round($total_jul),
            '08' => $text_current. round($total_aug),
            '09' => $text_current. round($total_sep),
            '10' => $text_current. round($total_oct),
            '11' => $text_current. round($total_nov),
            '12' => $text_current. round($total_dec),
            'total' => 1

        ];
        array_push($resumen, $total);
        return $resumen;

    }

    private function getReportDetail()
    {

        $listNotasIngresos = NotaIngreso::all();
        $resultados = [];
        foreach ($listNotasIngresos as $rowNotaIngreso) {
            $lineasNotaIngreso = $rowNotaIngreso->lineasNotaIngreso;

            foreach ($lineasNotaIngreso as $row) {
                $date_register = $row->notaIngreso->fecha_registro;

                $date = strtotime("+1 day", strtotime($date_register));
                $date = date("Y-m-d 00:00:00", $date);

                $cobro = TipoCambio::where('fecha_registro', '<', $date)->orderBy('fecha_registro', 'desc')->first();
                $cobro = $cobro->cobro;
                $current = $row->lineaOrdenCompra->ordenCompra->tipo_moneda;
                //dd($current);
                if ($current == "DOLARES") {
                    $costo_dolar = $row->lineaOrdenCompra->precio * $row->cantidad_ingresada;
                    $costo_sol = $costo_dolar * $cobro;
                } else {

                    $costo_sol = $row->lineaOrdenCompra->precio * $row->cantidad_ingresada;
                    $costo_dolar = $costo_sol / $cobro;
                }

                $resultado = [
                    'usuario' => $rowNotaIngreso->usuarioRegistro->empleado->nombreCompleto(),
                    'local' => $rowNotaIngreso->usuarioRegistro->empleado->local->nombre_local,
                    'fecha' => Carbon::createFromFormat('d/m/Y H:i', $rowNotaIngreso->getFechaRegistro())->format('d/m/Y'),
                    'ruc_proveedor' => $rowNotaIngreso->obtenerRUCProveedorRelacionado(),
                    'nombre' => $rowNotaIngreso->obtenerNombreProveedorRelacionado(),
                    'almacen' => 'Los Olivos',
                    'nota_ingreso' => $rowNotaIngreso->id_nota_ingreso,
                    'factura' => $rowNotaIngreso->obtenerFactura(),
                    'cod_producto' => $row->lineaOrdenCompra->getCodigoRepuesto(),
                    'categoria' => $row->lineaOrdenCompra->repuesto->getNombreCategoria(),
                    'marca' => $row->lineaOrdenCompra->repuesto->marca != null ? $row->lineaOrdenCompra->repuesto->marca->nombre_marca : '-',
                    'descripcion_producto' => $row->lineaOrdenCompra->getDescripcionRepuesto(),
                    'cantidad' => $row->cantidad_ingresada,
                    'costo_dolar' => round($costo_dolar, 2),
                    'tasa_cambio' => $cobro,
                    'costo_sol' => round($costo_sol, 2),
                ];
                array_push($resultados, $resultado);
            }
        }

        return $resultados;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
