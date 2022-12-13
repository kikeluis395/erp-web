<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CRM\CitasController;
use App\Modelos\Administracion\CostoDYP;
use App\Modelos\Administracion\CriterioDanho;
use App\Modelos\Administracion\HorarioTrabajo;
use App\Modelos\Administracion\LineaCostoDYP;
use App\Modelos\Administracion\PrecioDYP;
use App\Modelos\Administracion\RolPermiso;
use App\Modelos\CiaSeguro;
use App\Modelos\CitaEntrega;
use App\Modelos\LocalEmpresa;
use App\Modelos\MarcaAuto;
use App\Modelos\Modelo;
use App\Modelos\Permiso;
use App\Modelos\RecepcionOT;
use App\Modelos\Rol;
use App\Modelos\TipoCambio;
use App\Modelos\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CarroceriaMOController extends Controller
{
    public function index()
    {
        $seguros = CiaSeguro::all();
        $marcas = MarcaAuto::all();

        $precio_exists = true;
        $precio = PrecioDYP::where('habilitado', 1)->get();
        if (count($precio) === 0) $precio_exists = false;
        else $precio = $this->mapear_precios($precio, $seguros, $marcas);

        $costo_exists = true;
        $costo = CostoDYP::where('habilitado', 1)->first();
        if (!$costo) $costo_exists = false;

        $data = [
            "seguros" => $seguros,
            "marcas" => $marcas,
            "danhos" => $this->criteriosDanho(),
            'precio' => $precio,
            'costo' => $costo,
            'precio_exists' => $precio_exists,
            'costo_exists' => $costo_exists
        ];
        return view('administracion.manoObraBYP', $data);
    }

    public function store(Request $request)
    {

        $modify_precio = $request->modify_precio;
        $modify_costo = $request->modify_costo;
        $modify_criterio = $request->modify_criterio;

        if ($modify_precio === 'true') {

            $updates_precio = 0;

            foreach ($request->all() as $key => $value) {

                $es_precio = strpos($key, 'modify_precio_specific_') === 0;
                if ($es_precio) {
                    $unique = str_replace('modify_precio_specific_', '', $key);

                    $elements = explode('_', $unique);
                    $tipo = $elements[0];
                    $codes = explode(':', $elements[1]);
                    $id_cia_seguro = $codes[0];
                    $id_marca_auto = $codes[1];

                    $id_local = Auth::user()->empleado->id_local;

                    $actual_precio = PrecioDYP::where('id_cia_seguro', $id_cia_seguro)
                        ->where('id_marca_auto', $id_marca_auto)
                        ->where('tipo', $tipo)
                        ->where('habilitado', 1)->first();

                    if ($actual_precio) {
                        $actual_precio->habilitado = 0;
                        $actual_precio->editor = Auth::user()->id_usuario;
                        $actual_precio->fecha_edicion = Carbon::now();
                        $actual_precio->save();
                    }

                    $insert = explode('_', $value);

                    $incluye_igv = 0;
                    $fecha_inicio_aplicacion = Carbon::now();
                    $habilitado = 1;
                    $precio_valor_venta = $insert[0];
                    $moneda = $insert[1];

                    $nuevo_precio = new PrecioDYP();
                    $nuevo_precio->id_local = $id_local;
                    $nuevo_precio->tipo = $tipo;
                    $nuevo_precio->incluye_igv = $incluye_igv;
                    $nuevo_precio->fecha_inicio_aplicacion = $fecha_inicio_aplicacion;
                    $nuevo_precio->habilitado = $habilitado;
                    $nuevo_precio->precio_valor_venta = $precio_valor_venta;
                    $nuevo_precio->moneda = $moneda;
                    $nuevo_precio->id_cia_seguro = $id_cia_seguro;
                    $nuevo_precio->id_marca_auto = $id_marca_auto;
                    $nuevo_precio->creador = Auth::user()->id_usuario;

                    $nuevo_precio->save();

                    $updates_precio += 1;
                }
            }
        }

        if ($modify_costo === 'true') {
            $actual_costo = CostoDYP::where('habilitado', 1)->first();
            if ($actual_costo) {
                $actual_costo->habilitado = 0;
                $actual_costo->editor = Auth::user()->id_usuario;
                $actual_costo->fecha_edicion = Carbon::now();
                $actual_costo->save();
            }

            $tipo_personal = $request->tipo_personal;
            $valor_costo_hh = $request->valor_costo_hh;
            $valor_costo_panhos = $request->valor_costo_panhos;
            $metodo_costo_hh = $request->metodo_costo;
            $metodo_costo_panhos = $request->metodo_costo;
            $moneda_hh = $request->moneda_hh;
            $moneda_panhos = $request->moneda_panhos;
            $habilitado = 1;

            $nuevo_costo = new CostoDYP();
            $nuevo_costo->tipo_personal = $tipo_personal;
            if ($tipo_personal === 'TERCERO') {
                $nuevo_costo->valor_costo_hh = $valor_costo_hh;
                $nuevo_costo->valor_costo_panhos = $valor_costo_panhos;
                $nuevo_costo->metodo_costo_hh = $metodo_costo_hh;
                $nuevo_costo->metodo_costo_panhos = $metodo_costo_panhos;
                $nuevo_costo->moneda_hh = $moneda_hh;
                $nuevo_costo->moneda_panhos = $moneda_panhos;
            }
            $nuevo_costo->habilitado = $habilitado;
            $nuevo_costo->id_local = Auth::user()->empleado->id_local;
            $nuevo_costo->creador = Auth::user()->id_usuario;

            $nuevo_costo->save();
        }

        if ($modify_criterio === 'true') {

            foreach ($request->all() as $key => $value) {

                $es_criterio = strpos($key, 'modify_criterio_specific_') === 0;
                if ($es_criterio) {
                    $unique = str_replace('modify_criterio_specific_', '', $key);
                    $criterio = CriterioDanho::find($unique);
                    if ($criterio) {
                        $criterio->valor = $value;
                        $criterio->id_editor = Auth::user()->id_usuario;
                        $criterio->id_local = Auth::user()->empleado->id_local;
                        $criterio->fecha_edicion = Carbon::now();
                        $criterio->save();
                    }
                }
            }
        }

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        // $usuario = Usuario::find('49');
        // $principal = $usuario->rol->obtenerNombresInternosPermisos();

        // $roles_adicionales = $usuario->roles_adicionales;
        // $permisos_adicionales = [];
        // if (!is_null($roles_adicionales)) {

        //     $roles_adicionales = json_decode($roles_adicionales);

        //     foreach ($roles_adicionales as $rol_adicional) {
        //         $rol = Rol::find($rol_adicional);
        //         if ($rol) $permisos_adicionales = array_merge($permisos_adicionales, $rol->obtenerNombresInternosPermisos());

        //     }
        // }
        // // return $permisos_adicionales;
        // return array_unique(array_merge($permisos_adicionales, $principal));


        // if (Modelo::where('nombre_modelo', 'B10 ALMERA')->get()->first()) return 'A';
        // else return 'B';
        // $roles = Rol::selectRaw('distinct area')->where('area', '!=', '')->get();
        // $areas = [];
        // foreach ($roles as $rol) {
        //     array_push($areas, $rol->area);
        // }
        // return $areas;
        // return RolPermiso::with(['rol', 'permiso'])->get();

        // return Rol::with('accesos.permiso')->where('nombre_rol', 'ADMINISTRADOR')->get();
        // return Permiso::with('submodulos')->find(50);

        // return route('meson.show', '55');
        // return CitaEntrega::orderBy('fecha_cita', 'asc')->get()->last();

        // return Usuario::with(['rol', 'accesos_citas'])
        //     ->whereHas('rol', function ($a) {
        //         $a->where('nombre_interno', 'asesor_servicios');
        //     })->whereHas('accesos_citas', function ($b) {
        //         $b->where('habilitado', 1);
        //     })->get();

        // return (new DealerController)->last_fecha()->format('Y-m-d');
        // $fecha = '2021-07-20';
        // $fecha = '2021-08-17';

        // $fecha = '2021-08-28';
        // $fecha_cita = Carbon::createFromFormat('Y-m-d', $fecha);
        // $horario_indefinido = HorarioTrabajo::whereNull('aplica_hasta')->get()->first();
        // $horarios_limitados = HorarioTrabajo::whereNotNull('aplica_hasta')
        //     ->whereDate('aplica_desde', '<', $fecha_cita->format('Y-m-d'))
        //     ->get();
        // $horario_actualizable = $horario_indefinido;
        // if (count($horarios_limitados) > 0) {
        //     foreach ($horarios_limitados as $horario_limitado) {
        //         $aplica_hasta = $horario_limitado->aplica_hasta;
        //         $aplica_hasta = Carbon::createFromFormat('Y-m-d', $aplica_hasta);
        //         $days = $fecha_cita->diffInDays($aplica_hasta, false);
        //         if ($days >= 0) {
        //             $horario_actualizable = $horario_limitado;
        //         }
        //     }
        // }

        // return (new CitasController)->mapeo_horario($fecha_cita->format('Y-m-d'), $horario_actualizable);

        // return RecepcionOT::with("hojaTrabajo.vehiculo.marcaAuto")->find("1208");

        // // $now = Carbon::now();
        // return $map_months["M$now->month"];

        // $map_months = ['M1' => 'ENE', 'M2' => 'FEB', 'M3' => 'MAR', 'M4' => 'ABR', 'M5' => 'MAY', 'M6' => 'JUN', 'M7' => 'JUL', 'M8' => 'AGO', 'M9' => 'SET', 'M10' => 'OCT', 'M11' => 'NOV', 'M12' => 'DIC'];
        // $now = Carbon::createFromFormat('Y-m-d', '2021-10-01');
        // // $now = Carbon::now();
        // $actual_month = $now->month;


        // $actual_costo = CostoDYP::where('habilitado', 1)->first();
        // $id = $actual_costo->id_costo_asociado_dyp;
        // $fecha_registro = $actual_costo->fecha_registro;
        // $fecha_registro = Carbon::parse($fecha_registro);

        // $anho = $fecha_registro->year;
        // $register_month = $fecha_registro->month;

        // $months_ava = [];
        // for ($i = $register_month; $i < $actual_month; $i++) {
        //     array_push($months_ava, $map_months["M$i"]);
        // }

        // $lineas_blanco = LineaCostoDYP::where('valor_costo', 0)
        //     ->where('id_costo_asociado_dyp', $id)
        //     ->where('anho', $anho)
        //     ->where('mes', '!=', $map_months["M$actual_month"])
        //     ->whereIn('mes', $months_ava)
        //     ->get();

        // $linea_llena = LineaCostoDYP::where('valor_costo', '!=', 0)
        //     ->where('id_costo_asociado_dyp', $id)
        //     ->where('anho', $anho)
        //     ->whereIn('mes', $months_ava)
        //     ->orderBy('id_linea_costo_dyp', 'asc')
        //     ->get()
        //     ->last();

        // if ($linea_llena && count($lineas_blanco) > 0) {
        //     foreach ($lineas_blanco as $line) {
        //         $mes = strtoupper($line->mes);
        //         $valor_costo = (string) intval($line->valor_costo);
        //         if ($valor_costo === "0" && in_array($mes, $months_ava) && $mes != $actual_month) {
        //             $line->valor_costo = $linea_llena->valor_costo;
        //             $line->save();
        //         }
        //     }
        // }


        // if (count($lines) > 0) {
        //     foreach ($lines as $line) {
        //         if ((string)$line->anho === (string)$anho) {
        //             $mes = strtoupper($line->mes);
        //             $valor_costo = (string) intval($line->valor_costo);
        //             if ($valor_costo === "0" && in_array($mes, $months_ava) && $mes != $actual_month) {
        //                 $line->valor_costo = $last_valor;
        //                 $line->save();
        //             }
        //         }
        //     }
        // }
        // $ot = RecepcionOT::with("hojaTrabajo.vehiculo.marcaAuto")->find("1208");
        // $hojaTrabajo = $ot->hojaTrabajo;

        // $tipoTrabajo = "HH";

        // $es_ot = $hojaTrabajo->id_recepcion_ot != null;
        // $es_coti = $hojaTrabajo->id_cotizacion != null;

        // $element = null;
        // if ($es_ot) $element = $hojaTrabajo->recepcionOT;
        // else if ($es_coti) $element = $hojaTrabajo->cotizacion;
        // $price = null;
        // if ($es_ot || $es_coti) $price = $element->precio_dyp;
        // if ($price) $price = (array)json_decode($price);

        // if ($price && $tipoTrabajo) return $price[$tipoTrabajo];

        // $fecha = Carbon::parse('2021-03-01 16:46:26');
        // return RecepcionOT::where('fecha_inicio_aplicacion', '<', $fecha)->orderBy('fecha_inicio_aplicacion', 'asc')->last();
        // return response()->json(['success' => true]);
        // $struct = [
        //     "EXPRESS" => [
        //         "MIN" => 0,
        //         "MAX" => 0
        //     ],
        //     "LEVE" => [
        //         "MIN" => 0,
        //         "MAX" => 0
        //     ],
        //     "MEDIO" => [
        //         "MIN" => 0,
        //         "MAX" => 0
        //     ],
        //     "FUERTE" => [
        //         "MIN" => 0,
        //         "MAX" => 0
        //     ],
        // ];

        // $criterios = CriterioDanho::where('habilitado', 1)->get();
        // $temp = [];
        // foreach ($criterios as $criterio) {
        //     $temp[$criterio->codigo] = $criterio->valor;
        // }
        // $criterios = $temp;



        // $translate = ["EXP" => "EXPRESS", "LEV" => "LEVE", "MED" => "MEDIO", "FUE" => "FUERTE"];
        // $eval = ["LEV", "MED", "FUE"];
        // $secciones = ["HMO", "PAP", "REP"];

        // $ots = [1615, 1531, 1564, 483, 488, 497];
        // $arr = [];
        // $tasaIGV = config('app.tasa_igv');

        // $particular = CiaSeguro::where('nombre_cia_seguro', 'PARTICULAR')->first();

        // foreach ($ots as $ot) {

        //     $rec = RecepcionOT::find($ot);
        //     if ($rec) {

        //         $hojaTrabajo = $rec->hojaTrabajo;

        //         if ($hojaTrabajo->tipo_trabajo === 'DYP') {

        //             $divisa = $hojaTrabajo->moneda;
        //             $moneda = $divisa == "SOLES" ? "PEN" : "USD";
        //             $price = $rec->precio_dyp;

        //             if (is_null($hojaTrabajo->tipo_cambio)) $tipoCambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
        //             else $tipoCambio = $hojaTrabajo->tipo_cambio;

        //             $factorCambio = ($divisa == 'DOLARES' ? 1 / $tipoCambio : $tipoCambio);

        //             $HMO = null;
        //             $PAP = null;

        //             if ($price) {
        //                 $price = (array)json_decode($price);
        //                 $hh =  $price["HH"];
        //                 $panhos =  $price["PANHOS"];
        //                 $hh = PrecioDYP::find($hh);
        //                 $panhos = PrecioDYP::find($panhos);

        //                 if ($hh) {
        //                     $HMO = $hh->precio_valor_venta;
        //                     $HMO = ($hh->incluye_igv ? $HMO : $HMO * (1 + $tasaIGV));
        //                     if ($hh->moneda != $divisa) $HMO = $HMO * $factorCambio;
        //                 }
        //                 if ($panhos) {
        //                     $PAP = $panhos->precio_valor_venta;
        //                     $PAP = ($panhos->incluye_igv ? $PAP : $PAP * (1 + $tasaIGV));
        //                     if ($panhos->moneda != $divisa) $PAP = $PAP * $factorCambio;
        //                 }
        //             }

        //             $terceros = $hojaTrabajo->serviciosTerceros;
        //             $repuestos = $hojaTrabajo->necesidadesRepuestos;

        //             $totalRepuestos = 0;
        //             $totalServiciosTerceros = 0;

        //             if (count($repuestos) > 0) {
        //                 $necesidad = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
        //                 $aprobados = $necesidad->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
        //                 if ($aprobados->count() > 0) {

        //                     foreach ($aprobados as $aprobado) {
        //                         $totalRepuestos += $aprobado->getMontoTotal($aprobado->getFechaRegistroCarbon(), true);
        //                         #return $aprobado->getDescuentoTotal($aprobado->getFechaRegistroCarbon(),true, $aprobado->descuento_unitario, $aprobado->descuento_unitario_dealer);
        //                         // $totalRepuestosDescuento += $aprobado->getDescuentoTotal($aprobado->getFechaRegistroCarbon(), true, $aprobado->descuento_unitario, $aprobado->descuento_unitario_dealer ?? -1);
        //                         // $totalDescuentoMarca += $aprobado->getDescuentoTotal($aprobado->getFechaRegistroCarbon(), true, $aprobado->descuento_unitario, 0);
        //                     }
        //                 }
        //             }

        //             foreach ($terceros as $key => $servicioTercero) {
        //                 $totalServiciosTerceros += $servicioTercero->getSubTotal($moneda);
        //                 // $totalServiciosTercerosDescuento += $servicioTercero->getDescuento($monedaCalculos);
        //             }

        //             $aplica_repuestos = $totalServiciosTerceros + $totalRepuestos > 0;
        //             $criterios_ot = [];

        //             $totalExpressMax = 0;
        //             foreach ($secciones as $seccion) {
        //                 if ($seccion != 'REP') $totalExpressMax += $criterios["$seccion" . "_LEV_MIN"] * $$seccion;
        //                 if ($aplica_repuestos && $seccion === 'REP') $totalExpressMax += $criterios["$seccion" . "_LEV_MIN"];
        //             }
        //             $criterios_ot[$translate["EXP"]] = ["MIN" => 0, "MAX" => $totalExpressMax];

        //             foreach ($eval as $ev) {
        //                 $min = 0;
        //                 $max = 0;
        //                 foreach ($secciones as $seccion) {
        //                     if ($seccion != 'REP') {
        //                         $min += $criterios["$seccion" . "_$ev" . "_MIN"] * $$seccion;
        //                         $max += $criterios["$seccion" . "_$ev" . "_MAX"] * $$seccion;
        //                     }
        //                     if ($aplica_repuestos && $seccion === 'REP') {
        //                         $min += $criterios["$seccion" . "_$ev" . "_MIN"];
        //                         $max += $criterios["$seccion" . "_$ev" . "_MAX"];
        //                     }
        //                 }
        //                 $criterios_ot[$translate[$ev]] = ["MIN" => $min, "MAX" => $max];
        //             }

        //             $res_detalles = [
        //                 "moneda" => $moneda,
        //                 // "repuestos" => $totalRepuestos,
        //                 // "terceros" => $totalServiciosTerceros,
        //                 "criterios" => $criterios_ot,
        //                 "REP" => $totalRepuestos + $totalServiciosTerceros
        //                 // "MO" => [
        //                 //     "totales" => [],
        //                 //     "detalles" => []
        //                 // ]
        //             ];


        //             // if ($hojaTrabajo->tipo_trabajo === 'DYP') {
        //             $detalles = $hojaTrabajo->detallesTrabajo;

        //             $idSeguro = $rec->id_cia_seguro;
        //             $idMarca = $hojaTrabajo->vehiculo->id_marca_auto;

        //             $totales = ["HH" => 0, "PANHOS" => 0];

        //             foreach ($detalles as $detalle) {
        //                 $precio = $detalle->getPrecioVentaFinal($moneda);
        //                 $id = $detalle->id_detalle_trabajo;
        //                 $cantidad = $detalle->valor_trabajo_estimado;
        //                 $tipo = $detalle->precio_dyp->tipo;

        //                 $totales[$tipo] += $precio;
        //                 // array_push($res_detalles["MO"]["detalles"], [
        //                 //     "ID" => $id,
        //                 //     // "tipo" => $tipo,
        //                 //     // "cantidad" => $cantidad,
        //                 //     "precio" => $precio
        //                 // ]);
        //             }
        //             $replaced = ["HMO" => $totales["HH"], "PAP" => $totales["PANHOS"]];
        //             $res_detalles = array_merge($res_detalles, $replaced);

        //             $ot_budget = 0;
        //             foreach ($secciones as $seccion) {
        //                 $ot_budget += $res_detalles[$seccion];
        //             }
        //             // $ot_budget = floatval(number_format($ot_budget, 2));
        //             $ot_budget = round($ot_budget, 2);

        //             $tipo_danho = '';
        //             foreach ($criterios_ot as $key => $value) {
        //                 $min_in = $value['MIN'];
        //                 $max_in = $value['MAX'];
        //                 if ($ot_budget > $min_in && $ot_budget < $max_in) {
        //                     $tipo_danho = $key;
        //                 }
        //             }
        //             if ($tipo_danho === $translate["EXP"]) {
        //                 if ($idSeguro != $particular->id_cia_seguro || $res_detalles["REP"] > 0) {
        //                     $tipo_danho = $translate["LEV"];
        //                 }
        //             }
        //             $res_detalles["TOTAL"] = $ot_budget;
        //             $res_detalles["TIPO"] = $tipo_danho;
        //             $arr["OT_$ot"] = $res_detalles;
        //         }
        //     }
        // }

        // return $arr;
        // $ots = [1615, 1531, 1564, 483, 488, 497];
        // return $this->danho_inOT(1382, true);

        return (new CitasController)->opciones_horario();
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

        $actual_costo = CostoDYP::where('habilitado', 1)->first();
        $id = $actual_costo->id_costo_asociado_dyp;
        $fecha_registro = $actual_costo->fecha_registro;
        $fecha_registro = Carbon::parse($fecha_registro);

        $anho = $fecha_registro->year;
        $register_month = $fecha_registro->month;

        $months_ava = [];
        for ($i = $register_month; $i < $actual_month; $i++) {
            array_push($months_ava, $map_months["M$i"]);
        }

        $lineas_blanco = LineaCostoDYP::where('valor_costo', 0)
            ->where('id_costo_asociado_dyp', $id)
            ->where('anho', $anho)
            ->where('mes', '!=', $map_months["M$actual_month"])
            ->whereIn('mes', $months_ava)
            ->get();

        $linea_llena = LineaCostoDYP::where('valor_costo', '!=', 0)
            ->where('id_costo_asociado_dyp', $id)
            ->where('anho', $anho)
            ->whereIn('mes', $months_ava)
            ->orderBy('id_linea_costo_dyp', 'asc')
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

        $id_costo_asociado_dyp = $request->id_costo_asociado_dyp;
        $anho = $request->anho;

        $months = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SET', 'OCT', 'NOV', 'DIC'];

        if ($id_costo_asociado_dyp) {
            $actual_costo = CostoDYP::find($id_costo_asociado_dyp);
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

                    $line = new LineaCostoDYP();
                    $line->anho = $anho;
                    $line->mes = $mes;
                    $line->valor_costo = $valor_costo;
                    $line->moneda = $moneda;
                    $line->habilitado = 1;
                    $line->id_costo_asociado_dyp = $id_costo_asociado_dyp;
                    $line->id_local = Auth::user()->empleado->id_local;
                    $line->creador = Auth::user()->id_usuario;

                    $line->save();
                }
            } else {
                $this->fill_blanks();
            }
        } else {
            $nuevo_costo = new CostoDYP();
            $nuevo_costo->tipo_personal = 'PROPIO';
            $nuevo_costo->habilitado = 1;
            $nuevo_costo->save();

            $id_costo_asociado_dyp = $nuevo_costo->id_costo_asociado_dyp;

            foreach ($months as $month) {
                $mes = strtolower($month);
                $valor_costo = $request->input("valor_costo_$anho" . "_" . $mes);
                $moneda = $request->input("moneda_$anho" . "_" . $mes);
                if (!$valor_costo) $valor_costo = 0;

                $line = new LineaCostoDYP();
                $line->anho = $anho;
                $line->mes = $mes;
                $line->valor_costo = $valor_costo;
                $line->moneda = $moneda;
                $line->habilitado = 1;
                $line->id_costo_asociado_dyp = $id_costo_asociado_dyp;
                $line->id_local = Auth::user()->empleado->id_local;
                $line->creador = Auth::user()->id_usuario;
                $line->save();
            }
        }

        return response()->json(['success' => true]);
    }
    public function mapear_precios($precios, $seguros, $marcas)
    {
        $arr = [];
        $tipos = ["HH", "PANHOS"];

        foreach ($seguros as $seguro) {
            $cia = $seguro->id_cia_seguro;
            foreach ($marcas as $marca) {
                $marca = $marca->id_marca_auto;
                foreach ($tipos as $tipo) {
                    $arr["precio_valor_venta_" . $tipo . "_" . $cia . ':' . $marca] = 0;
                    $arr["moneda_" . $tipo . "_" . $cia . ':' . $marca] = 'SOLES';
                }
            }
        }
        foreach ($precios as $precio) {
            $cia = $precio->id_cia_seguro;
            $marca = $precio->id_marca_auto;
            $unique = $cia . ':' . $marca;
            $tipo = $precio->tipo;

            $precio_valor_venta = $precio->precio_valor_venta;
            $moneda = $precio->moneda;

            $arr["precio_valor_venta_" . $tipo . "_" . $unique] = $precio_valor_venta;
            $arr["moneda_" . $tipo . "_" . $unique] = $moneda;
        }
        return $arr;
    }

    private $sections = ["HMO", "PAP", "REP"];
    private $danhos = ["LEV", "MED", "FUE"];
    private $limits = ["MIN", "MAX"];

    public function criteriosDanho()
    {
        $criterios = CriterioDanho::where('habilitado', 1)->get();
        $criterios_exists = true;

        $temp = [];
        $sections = $this->sections;
        $danhos = $this->danhos;
        $limits = $this->limits;

        foreach ($sections as $section) {
            $temp_limits = [];
            $temp_danhos = [];
            foreach ($limits as $limit) $temp_limits[$limit] = ["valor" => 0, "bef" => ""];
            foreach ($danhos as $danho) $temp_danhos[$danho] = $temp_limits;
            foreach ($sections as $section) $temp[$section] = $temp_danhos;
        }

        if (count($criterios) > 0) {
            foreach ($criterios as $criterio) {
                $code = $criterio->codigo;

                $code_splote = explode("_", $code);
                if (count($code_splote) === 3) {
                    $section_val = $code_splote[0];
                    $danhos_val = $code_splote[1];
                    $limits_val = $code_splote[2];
                    if (in_array($section_val, $sections) && in_array($danhos_val, $danhos) && in_array($limits_val, $limits)) {
                        $temp[$section_val][$danhos_val][$limits_val] = $criterio;
                    }
                }
            }
        }
        if (count($criterios) === 0) $criterios_exists = false;
        return (object)[
            "criterios" => $temp,
            "secciones" => $sections,
            "tipos" => $danhos,
            "limites" => $limits,
            "criterios_exists" => $criterios_exists
        ];
    }

    public function criterios_map()
    {
        $criterios = CriterioDanho::where('habilitado', 1)->get();
        $arr = [];
        foreach ($criterios as $criterio) {
            $arr[$criterio->codigo] = $criterio->valor;
        }
        return $arr;
    }

    public function danho_inOT($ot, $withDetails = false, $instance = null)
    {
        $criterios = $this->criterios_map();

        $translate = ["EXP" => "EXPRESS", "LEV" => "LEVE", "MED" => "MEDIO", "FUE" => "FUERTE"];
        $eval = $this->danhos;
        $secciones = $this->sections;

        $tasaIGV = config('app.tasa_igv');

        $particular = CiaSeguro::where('nombre_cia_seguro', 'PARTICULAR')->first();

        $rec = null;
        if($instance) $rec = $instance;
        else $rec = RecepcionOT::find($ot);

        if ($rec) {

            $hojaTrabajo = $rec->hojaTrabajo;

            if ($hojaTrabajo->tipo_trabajo === 'DYP') {

                $divisa = $hojaTrabajo->moneda;
                $moneda = $divisa == "SOLES" ? "PEN" : "USD";
                $price = $rec->precio_dyp;

                if (is_null($hojaTrabajo->tipo_cambio)) $tipoCambio = TipoCambio::orderBy('fecha_registro', 'desc')->first()->cobro;
                else $tipoCambio = $hojaTrabajo->tipo_cambio;

                $factorCambio = ($divisa == 'DOLARES' ? 1 / $tipoCambio : $tipoCambio);

                $HMO = null;
                $PAP = null;

                if ($price) {
                    $price = (array)json_decode($price);
                    $hh =  $price["HH"];
                    $panhos =  $price["PANHOS"];
                    $hh = PrecioDYP::find($hh);
                    $panhos = PrecioDYP::find($panhos);

                    if ($hh) {
                        $HMO = $hh->precio_valor_venta;
                        $HMO = ($hh->incluye_igv ? $HMO : $HMO * (1 + $tasaIGV));
                        if ($hh->moneda != $divisa) $HMO = $HMO * $factorCambio;
                    }
                    if ($panhos) {
                        $PAP = $panhos->precio_valor_venta;
                        $PAP = ($panhos->incluye_igv ? $PAP : $PAP * (1 + $tasaIGV));
                        if ($panhos->moneda != $divisa) $PAP = $PAP * $factorCambio;
                    }
                }

                $terceros = $hojaTrabajo->serviciosTerceros;
                $repuestos = $hojaTrabajo->necesidadesRepuestos;

                $totalRepuestos = 0;
                $totalServiciosTerceros = 0;

                if (count($repuestos) > 0) {
                    $necesidad = $hojaTrabajo->necesidadesRepuestos()->orderBy('fecha_registro', 'desc')->first();
                    $aprobados = $necesidad->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get();
                    if ($aprobados->count() > 0) {

                        foreach ($aprobados as $aprobado) {
                            $totalRepuestos += $aprobado->getMontoTotal($aprobado->getFechaRegistroCarbon(), true);
                            #return $aprobado->getDescuentoTotal($aprobado->getFechaRegistroCarbon(),true, $aprobado->descuento_unitario, $aprobado->descuento_unitario_dealer);
                            // $totalRepuestosDescuento += $aprobado->getDescuentoTotal($aprobado->getFechaRegistroCarbon(), true, $aprobado->descuento_unitario, $aprobado->descuento_unitario_dealer ?? -1);
                            // $totalDescuentoMarca += $aprobado->getDescuentoTotal($aprobado->getFechaRegistroCarbon(), true, $aprobado->descuento_unitario, 0);
                        }
                    }
                }

                foreach ($terceros as $key => $servicioTercero) {
                    $totalServiciosTerceros += $servicioTercero->getSubTotal($moneda);
                    // $totalServiciosTercerosDescuento += $servicioTercero->getDescuento($monedaCalculos);
                }

                $aplica_repuestos = $totalServiciosTerceros + $totalRepuestos > 0;
                $criterios_ot = [];

                $totalExpressMax = 0;
                foreach ($secciones as $seccion) {
                    if ($seccion != 'REP') $totalExpressMax += $criterios["$seccion" . "_LEV_MIN"] * $$seccion;
                    if ($aplica_repuestos && $seccion === 'REP') $totalExpressMax += $criterios["$seccion" . "_LEV_MIN"];
                }
                $criterios_ot[$translate["EXP"]] = ["MIN" => 0, "MAX" => $totalExpressMax];

                foreach ($eval as $ev) {
                    $min = 0;
                    $max = 0;
                    foreach ($secciones as $seccion) {
                        if ($seccion != 'REP') {
                            $min += $criterios["$seccion" . "_$ev" . "_MIN"] * $$seccion;
                            $max += $criterios["$seccion" . "_$ev" . "_MAX"] * $$seccion;
                        }
                        if ($aplica_repuestos && $seccion === 'REP') {
                            $min += $criterios["$seccion" . "_$ev" . "_MIN"];
                            $max += $criterios["$seccion" . "_$ev" . "_MAX"];
                        }
                    }
                    $criterios_ot[$translate[$ev]] = ["MIN" => $min, "MAX" => $max];
                }

                $res_detalles = [
                    "OT"=>$rec->id_recepcion_ot,
                    "moneda" => $moneda,
                    // "repuestos" => $totalRepuestos,
                    // "terceros" => $totalServiciosTerceros,
                    "criterios" => $criterios_ot,
                    "REP" => $totalRepuestos + $totalServiciosTerceros
                    // "MO" => [
                    //     "totales" => [],
                    //     "detalles" => []
                    // ]
                ];


                // if ($hojaTrabajo->tipo_trabajo === 'DYP') {
                $detalles = $hojaTrabajo->detallesTrabajo;

                $idSeguro = $rec->id_cia_seguro;
                $idMarca = $hojaTrabajo->vehiculo->id_marca_auto;

                $totales = ["HH" => 0, "PANHOS" => 0];

                foreach ($detalles as $detalle) {
                    $precio = $detalle->getPrecioVentaFinal($moneda);
                    $id = $detalle->id_detalle_trabajo;
                    $cantidad = $detalle->valor_trabajo_estimado;
                    $tipo = $detalle->precio_dyp->tipo;

                    $totales[$tipo] += $precio;
                    // array_push($res_detalles["MO"]["detalles"], [
                    //     "ID" => $id,
                    //     // "tipo" => $tipo,
                    //     // "cantidad" => $cantidad,
                    //     "precio" => $precio
                    // ]);
                }
                $replaced = ["HMO" => $totales["HH"], "PAP" => $totales["PANHOS"]];
                $res_detalles = array_merge($res_detalles, $replaced);

                $ot_budget = 0;
                foreach ($secciones as $seccion) {
                    $ot_budget += $res_detalles[$seccion];
                }
                // $ot_budget = floatval(number_format($ot_budget, 2));
                $ot_budget = round($ot_budget, 2);

                $tipo_danho = '';
                foreach ($criterios_ot as $key => $value) {
                    $min_in = $value['MIN'];
                    $max_in = $value['MAX'];
                    if ($ot_budget > $min_in && $ot_budget < $max_in) {
                        $tipo_danho = $key;
                    }
                }
                if ($tipo_danho === $translate["EXP"]) {
                    if ($idSeguro != $particular->id_cia_seguro || $res_detalles["REP"] > 0) {
                        $tipo_danho = $translate["LEV"];
                    }
                }
                $res_detalles["TOTAL"] = $ot_budget;
                $res_detalles["TIPO"] = $tipo_danho;

                if($withDetails) return $res_detalles;
                return $tipo_danho;
            }
        }

        return '-';
    }
}
