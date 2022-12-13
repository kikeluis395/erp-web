<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Administracion\CostoMEC;
use App\Modelos\Administracion\LineaCostoMEC;
use App\Modelos\Administracion\PrecioMEC;
use App\Modelos\LocalEmpresa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MecanicaMOController extends Controller
{
    public function index()
    {
        $precio_exists = true;
        $precio = PrecioMEC::where('tipo', 'MO')->where('habilitado', 1)->first();
        if (!$precio) $precio_exists = false;

        $costo_exists = true;
        $costo = CostoMEC::where('habilitado', 1)->first();
        if (!$costo) $costo_exists = false;

        $data = [
            'precio' => $precio,
            'costo' => $costo,
            'precio_exists' => $precio_exists,
            'costo_exists' => $costo_exists
        ];
        return view('administracion.manoObraMEC', $data);
    }

    public function store(Request $request)
    {
        $modify_precio = $request->modify_precio;
        $modify_costo = $request->modify_costo;

        if ($modify_precio === 'true') {
            $actual_precio = PrecioMEC::where('tipo', 'MO')->where('habilitado', 1)->first();
            if ($actual_precio) {
                $actual_precio->habilitado = 0;
                $actual_precio->editor = Auth::user()->id_usuario;
                $actual_precio->fecha_edicion = Carbon::now();
                $actual_precio->save();
            }

            $id_local_empresa = Auth::user()->empleado->id_local;
            $tipo = 'MO';
            $incluye_igv = 1;
            $fecha_inicio_aplicacion = Carbon::now();
            $habilitado = 1;
            $precio_valor_venta = $request->precio_valor_venta;
            $moneda = $request->moneda_precio;

            $nuevo_precio = new PrecioMEC();
            $nuevo_precio->id_local_empresa = $id_local_empresa;
            $nuevo_precio->tipo = $tipo;
            $nuevo_precio->incluye_igv = $incluye_igv;
            $nuevo_precio->fecha_inicio_aplicacion = $fecha_inicio_aplicacion;
            $nuevo_precio->habilitado = $habilitado;
            $nuevo_precio->precio_valor_venta = $precio_valor_venta;
            $nuevo_precio->moneda = $moneda;
            $nuevo_precio->creador = Auth::user()->id_usuario;
            $nuevo_precio->save();
        }

        if ($modify_costo === 'true') {
            $actual_costo = CostoMEC::where('habilitado', 1)->first();
            if ($actual_costo) {
                $actual_costo->habilitado = 0;
                $actual_costo->editor = Auth::user()->id_usuario;
                $actual_costo->fecha_edicion = Carbon::now();
                $actual_costo->save();
            }

            $tipo_personal = $request->tipo_personal;
            $metodo_costo = $request->metodo_costo;
            $moneda = $request->moneda_costo;
            $valor_costo = $request->valor_costo;
            $habilitado = 1;

            $nuevo_costo = new CostoMEC();
            $nuevo_costo->tipo_personal = $tipo_personal;
            if ($tipo_personal === 'TERCERO') {
                $nuevo_costo->metodo_costo = $metodo_costo;
                $nuevo_costo->moneda = $moneda;
                $nuevo_costo->valor_costo = $valor_costo;
            }
            $nuevo_costo->habilitado = $habilitado;
            $nuevo_costo->id_local = Auth::user()->empleado->id_local;
            $nuevo_costo->creador = Auth::user()->id_usuario;
            $nuevo_costo->save();
        }

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function fill_blanks()
    {
        $map_months = ['M1' => 'ENE', 'M2' => 'FEB', 'M3' => 'MAR', 'M4' => 'ABR', 'M5' => 'MAY', 'M6' => 'JUN', 'M7' => 'JUL', 'M8' => 'AGO', 'M9' => 'SET', 'M10' => 'OCT', 'M11' => 'NOV', 'M12' => 'DIC'];
        // $now = Carbon::createFromFormat('Y-m-d', '2021-10-01');
        $now = Carbon::now();
        $actual_month = $now->month;

        $actual_costo = CostoMEC::where('habilitado', 1)->first();
        $id = $actual_costo->id_costo_asociado_mec;
        $fecha_registro = $actual_costo->fecha_registro;
        $fecha_registro = Carbon::parse($fecha_registro);

        $anho = $fecha_registro->year;
        $register_month = $fecha_registro->month;

        $months_ava = [];
        for ($i = $register_month; $i < $actual_month; $i++) {
            array_push($months_ava, $map_months["M$i"]);
        }

        $lineas_blanco = LineaCostoMEC::where('valor_costo', 0)
            ->where('id_costo_asociado_mec', $id)
            ->where('anho', $anho)
            ->where('mes', '!=', $map_months["M$actual_month"])
            ->whereIn('mes', $months_ava)
            ->get();

        $linea_llena = LineaCostoMEC::where('valor_costo', '!=', 0)
            ->where('id_costo_asociado_mec', $id)
            ->where('anho', $anho)
            ->whereIn('mes', $months_ava)
            ->orderBy('id_linea_costo_mec', 'asc')
            ->get()
            ->last();

        if ($linea_llena && count($lineas_blanco) > 0) {
            foreach ($lineas_blanco as $line) {
                $mes = strtoupper($line->mes);
                $valor_costo = (string) intval($line->valor_costo);
                if ($valor_costo === "0" && in_array($mes, $months_ava) && $mes != $actual_month) {
                    $line->valor_costo = $linea_llena->valor_costo;
                    $line->editor = Auth::user()->id_usuario;
                    $line->fecha_edicion = Carbon::now();
                    $line->save();
                }
            }
        }
    }
    public function store_lineas(Request $request)
    {
        $id_costo_asociado_mec = $request->id_costo_asociado_mec;
        $anho = $request->anho;

        $months = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SET', 'OCT', 'NOV', 'DIC'];

        if ($id_costo_asociado_mec) {
            $actual_costo = CostoMEC::find($id_costo_asociado_mec);
            $lines = $actual_costo->lineas;

            $updates = 0;
            if (count($lines) > 0) {
                foreach ($lines as $line) {
                    if ((string)$line->anho === (string)$anho) {
                        $mes = strtolower($line->mes);

                        $valor_costo = $request->input("valor_costo_$anho" . "_" . $mes);
                        $moneda = $request->input("moneda_$anho" . "_" . $mes);

                        $line->valor_costo = $valor_costo;
                        $line->moneda = $moneda;
                        $line->editor = Auth::user()->id_usuario;
                        $line->fecha_edicion = Carbon::now();
                        $line->save();
                        $updates += 1;
                    }
                }
            }

            if ($updates === 0) {
                foreach ($months as $month) {
                    $mes = strtolower($month);
                    $valor_costo = $request->input("valor_costo_$anho" . "_" . $mes);
                    $moneda = $request->input("moneda_$anho" . "_" . $mes);

                    $line = new LineaCostoMEC();
                    $line->anho = $anho;
                    $line->mes = $mes;
                    $line->valor_costo = $valor_costo;
                    $line->moneda = $moneda;
                    $line->habilitado = 1;
                    $line->id_costo_asociado_mec = $id_costo_asociado_mec;
                    $line->id_local = Auth::user()->empleado->id_local;
                    $line->creador = Auth::user()->id_usuario;
                    $line->save();
                }
            } else {
                $this->fill_blanks();
            }
        } else {
            $nuevo_costo = new CostoMEC();
            $nuevo_costo->tipo_personal = 'PROPIO';
            $nuevo_costo->habilitado = 1;
            $nuevo_costo->id_local = Auth::user()->empleado->id_local;
            $nuevo_costo->creador = Auth::user()->id_usuario;
            $nuevo_costo->save();

            $id_costo_asociado_mec = $nuevo_costo->id_costo_asociado_mec;

            foreach ($months as $month) {
                $mes = strtolower($month);
                $valor_costo = $request->input("valor_costo_$anho" . "_" . $mes);
                $moneda = $request->input("moneda_$anho" . "_" . $mes);
                if (!$valor_costo) $valor_costo = 0;

                $line = new LineaCostoMEC();
                $line->anho = $anho;
                $line->mes = $mes;
                $line->valor_costo = $valor_costo;
                $line->moneda = $moneda;
                $line->habilitado = 1;
                $line->id_costo_asociado_mec = $id_costo_asociado_mec;
                $line->id_local = Auth::user()->empleado->id_local;
                $line->creador = Auth::user()->id_usuario;
                $line->save();
            }
        }

        return response()->json(['success' => true]);
    }
}
