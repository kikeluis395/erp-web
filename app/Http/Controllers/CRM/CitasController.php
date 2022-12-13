<?php

namespace App\Http\Controllers\CRM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Administracion\UsuarioController;
use App\Http\Controllers\CarroceriaPintura\RecepcionController;
use App\Modelos\Administracion\HorarioTrabajo;
use App\Modelos\CitaEntrega;
use App\Modelos\MarcaAuto;
use App\Modelos\Modelo;
use App\Modelos\Usuario;
use App\Modelos\Vehiculo;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->fecha) {
            $validacion = DateTime::createFromFormat('d/m/Y', $request->fecha);
            if ($validacion) {
                $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
            } else {
                $fecha = new Carbon();
            }
        } else {
            $fecha = new Carbon();
        }
        $fechaVista = $fecha->format('d/m/Y');

        $listaModelos = Modelo::all();
        $asesores = $this->asesores_acceso($fechaVista);

        return view('crm.citas', [
            'tablaCitas' => $this->show($fechaVista),
            'fechaSeleccionada' => $fechaVista,
            'listaAsesores' => $asesores,
            "listaModelos" => json_encode($listaModelos),

        ]);
    }

    public function asesores_acceso($fecha)
    {
        $limite_asiancas = '2021-07-31';
        $limite_asiancas = Carbon::createFromFormat('Y-m-d', $limite_asiancas);

        $asiancas_ver = false;
        if ($fecha) {
            $fecha = Carbon::createFromFormat('d/m/Y', $fecha);
            $asiancas_ver = $fecha->diffInDays($limite_asiancas, false) > 0;
        }

        $main = Usuario::with(['rol', 'accesos_citas'])
            ->whereHas('rol', function ($a) {
                $a->where('nombre_interno', 'asesor_servicios');
            })->whereHas('accesos_citas', function ($b) {
                $b->where('habilitado', 1);
            });
        if ($asiancas_ver) return $main->orWhereIn('username', ['asiancas'])->get();
        return $main->get();
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
    private function horario_cita($fecha)
    {
        $fecha_cita = Carbon::createFromFormat('Y-m-d', $fecha);
        $horario_indefinido = HorarioTrabajo::whereNull('aplica_hasta')->get()->first();
        $horarios_limitados = HorarioTrabajo::whereNotNull('aplica_hasta')
            ->whereDate('aplica_desde', '<', $fecha_cita->format('Y-m-d'))
            ->get();
        $horario_actualizable = $horario_indefinido;
        if (count($horarios_limitados) > 0) {
            foreach ($horarios_limitados as $horario_limitado) {
                $aplica_hasta = $horario_limitado->aplica_hasta;
                $aplica_hasta = Carbon::createFromFormat('Y-m-d', $aplica_hasta);
                $days = $fecha_cita->diffInDays($aplica_hasta, false);
                if ($days >= 0) {
                    $horario_actualizable = $horario_limitado;
                }
            }
        }
        return $horario_actualizable;
    }

    public function store(Request $request)
    {
        $cita = new CitaEntrega();
        $cita->fecha_cita = Carbon::createFromFormat('Y-m-d H:i', "$request->fecha $request->hora");
        $vehiculo = Vehiculo::find($request->placa);
        $cita->doc_cliente = $request->numDoc;
        $cita->placa_vehiculo = $request->placa;
        $cita->dni_empleado = $request->empleado;
        $cita->id_marca_auto = $request->empleado;
        $cita->tipo_servicio =  $request->tipo;
        $cita->contacto =  $request->contacto;
        $cita->telefono_contacto = $request->nroContacto;
        $cita->email_contacto = $request->correoContacto;

        $nombre_modelo = $request->nombre_modelo;
        $modelo = $request->modelo;
        if ($nombre_modelo != '') $fmodelo = $nombre_modelo;
        else {
            if ($vehiculo) {
                $id_marca = $vehiculo->id_marca_auto;
                $modelos_disponibles = Modelo::where('id_marca_auto', $id_marca)->get();
                if (count($modelos_disponibles) > 0) {
                    $modelo_guardado_byId = Modelo::find($vehiculo->modelo);
                    $modelo_guardado_byName = Modelo::where('nombre_modelo', $vehiculo->modelo)->get()->first();

                    if ($modelo_guardado_byId) $fmodelo = $modelo_guardado_byId->nombre_modelo;
                    else if ($modelo_guardado_byName) $fmodelo = $modelo_guardado_byName->nombre_modelo;
                    else $fmodelo = $vehiculo->modelo;
                } else $fmodelo = $vehiculo->modelo;
            } else {
                $model = Modelo::find($modelo);
                if ($model) $fmodelo = $model->nombre_modelo;
                else $fmodelo = null;
            }
        }
        $cita->id_marca_auto = $request->marca;
        $cita->modelo = $fmodelo;
        $cita->detalle_servicio = $request->detalleServicio;
        $cita->observaciones = $request->observaciones;
        $cita->id_usuario = Auth::user()->id_usuario;
        $cita->asistio = 0;
        $cita->save();

        // $horario_actualizable = $this->horario_cita($request->fecha);
        // $horario_actualizable->en_uso = 1;
        // $horario_actualizable->save();
        $this->update_horario();

        return redirect()->route('crm.citas.index', ["fecha" => $cita->fecha_cita->format('d/m/Y')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mapeo_horario($fecha, $horario)
    {
        $fecha_cita = Carbon::createFromFormat('Y-m-d', $fecha);
        $days = [
            'SUNDAY' => 'dom',
            'SATURDAY' => 'sab',
            'FRIDAY' => 'vie',
            'THURSDAY' => 'jue',
            'WEDNESDAY' => 'mie',
            'TUESDAY' => 'mar',
            'MONDAY' => 'lun'
        ];

        $prefix = $days[strtoupper($fecha_cita->format('l'))];
        $in = $prefix . "_in";
        $out = $prefix . "_out";

        $in = $horario->$in;
        $out = $horario->$out;
        $intervalo = $horario->intervalo_citas;

        $fechaInicio = new DateTime($in);
        $fechaFin = new DateTime($out);
        $fechaFin = $fechaFin->modify("+$intervalo minutes");

        $rangoFechas = new DatePeriod($fechaInicio, new DateInterval("PT" . $intervalo . "M"), $fechaFin);
        $rangos = [];
        foreach ($rangoFechas as $fecha) {
            array_push($rangos, $fecha->format("H:i"));
        }
        return $rangos;
        // return [
        //     $in,
        //     $out
        // ];
    }

    public function opciones_horario()
    {
        $arr = [];
        $horarios = HorarioTrabajo::all();
        $week = [];
        for ($i = 1; $i < 8; $i++) {
            $day = Carbon::now()->addDays($i);
            array_push($week, $day->format('Y-m-d'));
        }
        foreach ($horarios as $horario) {
            $res = [];
            foreach ($week as $weekday) {
                $dayname = strtoupper(Carbon::createFromFormat('Y-m-d', $weekday)->format("l"));
                $horas = $this->mapeo_horario($weekday, $horario);
                $res[$dayname] = $horas;
            }
            $res["CONFIG"] = $horario;
            $arr["H$horario->id_horario"] = $res;
        }
        return $arr;
    }

    public function show($id)
    {
        $fecha = Carbon::createFromFormat('d/m/Y', $id);

        $es_admin = Auth::user()->rol->nombre_interno === 'administrador';

        if (!$fecha) {
            abort(500);
        }
        $marcasVehiculo = MarcaAuto::all();

        $asesores = $this->asesores_acceso($fecha->format('d/m/Y'));

        if ($asesores->count() === 0) return view('crm.tablaCitas', ['zero' => true, 'admin' => $es_admin, "opciones" => []]);
        //Es 90, debido que se usa un 10% de la tabla de citas apra mostrar la hora
        $porcentajePorAsesor = 50 / $asesores->count();

        $horario_actualizable = $this->horario_cita($fecha->format('Y-m-d'));

        // $horas = [
        //     "07:00",
        //     "07:30",
        //     "08:00",
        //     "08:30",
        //     "09:00",
        //     "09:30",
        //     "10:00",
        //     "10:30",
        //     "11:00",
        //     "11:30",
        //     "12:00",
        //     "12:30",
        //     "13:00",
        //     "13:30",
        //     "14:00",
        //     "14:30",
        //     "15:00",
        //     "15:30",
        //     "16:00",
        //     "16:30"
        // ];
        $horas = $this->mapeo_horario($fecha->format('Y-m-d'), $horario_actualizable);

        $citas = CitaEntrega::where(DB::raw('date(fecha_cita)'), $fecha->format('Y-m-d'))->where('habilitado', 1)->get();

        foreach ($asesores as $key => $asesor) {
            $citasAsesor = $citas->where('dni_empleado', $asesor->empleado->dni);
            foreach ($horas as $key => $hora) {
                $citaFound = $citasAsesor->filter(function ($value, $key) use ($hora) {
                    $fecha = new Carbon($value->fecha_cita);
                    return $fecha->format('H:i') == $hora;
                })->first();

                if (!$citaFound) {
                    // SIN CITA
                    $asesor[$hora] = null;
                } else {
                    // HAY CITA, INTERNAMENTE SE MANEJARIAN LOS ESTADOS
                    $estado = $citaFound->estadoAsistencia();
                    $citaFound->estado = $estado;
                    $asesor[$hora] = $citaFound;
                }
            }
        }
        $listaModelos = Modelo::all();
        $opciones = $this->opciones_horario();


        return view('crm.tablaCitas', [
            "listaAsesores" => $asesores,
            "listaHoras" => $horas,
            "fecha" => $fecha->format('Y-m-d'),
            "fechaCarbon" => $fecha,
            "horas" => $horas,
            "porcentajePorAsesor" => $porcentajePorAsesor,
            "marcasVehiculo" => $marcasVehiculo,
            "listaModelos" => $listaModelos,
            "zero" => false,
            "admin" => $es_admin,
            "opciones" => $opciones,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request)
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

    public function seguimientoProactivo(Request $request)
    {
        if ($request->has('numPlaca') && strlen($request->numPlaca) == 6) {
            // obtain all data and then export
            $placa = $request->numPlaca;
            $seguimiento = $this->getDataSeguimientoProactivo($placa);

            if ($seguimiento) {
                if ($request->has('exportExcel') && "$request->exportExcel" == "1") {
                    $nombreArchivo = "SEGUIMIENTO_PROACTIVO_XXXXXX_XXXXXXXX.xlsx";
                    return Excel(new SeguimientoProactivoExcelController(), $nombreArchivo);
                } else {
                    return view('crm.seguimientoProactivo', ['dataSeguimiento' => $seguimiento]);
                }
            } else {
                return view('crm.seguimientoProactivo', ['dataSeguimiento' => null]);
            }
        } else {
            return view('crm.seguimientoProactivo');
        }
    }

    public function reprogramacionCita(Request $request)
    {
        if (!DateTime::createFromFormat('d/m/Y', $request->fechaReprogramacion)) {
            return redirect()->back()->with('errorFechas', 'El formato de las fechas ingresadas es incorrecto');
        }
        $fechaCompletaHoy = Carbon::now();
        $fechaHoy = Carbon::parse($fechaCompletaHoy)->format('d/m/Y');
        $horasHoy = Carbon::parse($fechaCompletaHoy)->format('H:i');

        $fechaReprogramacion = Carbon::createFromFormat('d/m/Y', $request->fechaReprogramacion);
        $horaReprogramacion = Carbon::createFromFormat('H:i', $request->horaReprogramacion);

        $limiteSuperiorInDay = '16:30';
        $limiteSuperiorInDay = Carbon::createFromFormat('H:i', $limiteSuperiorInDay);

        if ($fechaHoy === $fechaReprogramacion->format('d/m/Y')) {
            if ($limiteSuperiorInDay->diffInMinutes($horasHoy) < 0) {
                return redirect()->back()->with('citaFechaError', 'No se pueden reprogramar citas el dia de hoy debido a que se cerro el horario de salida.');
            }

            if ($horaReprogramacion->diffInMinutes($horasHoy, false) > 0) {
                return redirect()->back()->with('citaFechaError', 'No se puede reprogramar una cita antes de la hora actual.');
            }
        }

        if ($fechaReprogramacion->diffInDays($fechaCompletaHoy, false) > 0) {
            return redirect()->back()->with('citaFechaError', 'La reprogramación no se puede realizar debido que se ha ingresado una fecha anterior a la actual.');
        }
        $fecha = "$request->fechaReprogramacion $request->horaReprogramacion";
        $fecha = Carbon::createFromFormat('d/m/Y H:i', $fecha);
        $dniAsesor = $request->dniAsesor;
        $fechaComparacion = Carbon::parse($fecha)->format('Y-m-d H:i');
        $citaExistente = CitaEntrega::where('fecha_cita', $fechaComparacion)->where('dni_empleado', $dniAsesor)->where('habilitado', 1)->first();

        if (!is_null($citaExistente)) {
            return redirect()->back()->with('citaExistente', 'La reprogramación no se puede realizar debido que ya existe una cita para la fecha ingresada');
        }
        $cita = CitaEntrega::find($request->idCita);

        $fechaIn = Carbon::createFromFormat('d/m/Y', $request->fechaReprogramacion)->format('Y-m-d');
        $fecha_old_cita = Carbon::parse($cita->fecha_cita);
        $fechaProc = $fecha_old_cita->format('Y-m-d');
        $citaFechaExists = CitaEntrega::whereDate('fecha_cita', $fechaIn)
            ->where('placa_vehiculo', $cita->placa_vehiculo)
            ->where('asistio', 0)
            ->where('habilitado', 1)
            ->orderBy('fecha_cita', 'desc')
            ->first();

        if (!is_null($citaFechaExists) && $fechaIn != $fechaProc) {
            return redirect()->back()->with('citaExistente', "La reprogramación no se puede realizar debido que ya existe una cita para el vehiculo con placa $cita->placa_vehiculo");
        }

        $cita->fecha_cita = $fecha;
        $fechaFormato = $fecha->format('d/m/Y');

        $cita->fecha_reprogramacion = Carbon::now();
        $cita->save();

        $this->update_horario();

        return redirect()->route('crm.citas.index', ["fecha" => $fechaFormato]);
    }

    public function update_horario()
    {
        $horario_indefinido = HorarioTrabajo::whereNull('aplica_hasta')->get()->first();
        if ($horario_indefinido) {
            $aplica_desde = $horario_indefinido->aplica_desde;
            $aplica_desde = Carbon::createFromFormat('Y-m-d', $aplica_desde);

            $citas_adelante = CitaEntrega::whereDate('fecha_cita', '>', $aplica_desde->subtract('day', 1)->format('Y-m-d'))->where('habilitado', 1)->get();
            if (count($citas_adelante) === 0) $horario_indefinido->en_uso = 0;
            else $horario_indefinido->en_uso = 1;

            $horario_indefinido->editor = Auth::user()->id_usuario;
            $horario_indefinido->fecha_edicion = Carbon::now();
            $horario_indefinido->save();
        }
    }

    public function cancelarCita(Request $request)
    {
        $cita = CitaEntrega::find($request->idCita);
        $cita->habilitado = 0;
        $cita->save();
        $fecha = Carbon::parse($cita->fecha_cita);
        $format = $fecha->format('Y-m-d');

        // $horario_actualizable = $this->horario_cita($format);
        // $citas_adelante = CitaEntrega::whereDate('fecha_cita', '>', $fecha->subtract('day', 1)->format('Y-m-d'))->where('habilitado', 1)->get();
        // if (count($citas_adelante) === 0) {
        //     if (is_null($horario_actualizable->aplica_hasta)) {
        //         $horario_actualizable->en_uso = 0;
        //         $horario_actualizable->save();
        //     }
        // }
        $this->update_horario();

        return redirect()->route('crm.citas.index', ["fecha" => $format]);
    }

    public function editarCita(Request $request)
    {
        $cita = CitaEntrega::find($request->idCita);

        $cita->tipo_servicio = $request->tipo;
        $cita->id_marca_auto = $request->marca;

        $vehiculo = Vehiculo::find($cita->placa_vehiculo);
        $nombre_modelo = $request->nombre_modelo;
        $modelo = $request->modelo;
        if ($nombre_modelo != '') $fmodelo = $nombre_modelo;
        else {
            if ($vehiculo) $fmodelo = $vehiculo->modelo;
            else {
                $model = Modelo::find($modelo);
                if ($model) $fmodelo = $model->nombre_modelo;
                else $fmodelo = null;
            }
        }

        $cita->modelo = $fmodelo;
        $cita->detalle_servicio = $request->detalle;
        $cita->observaciones = $request->observaciones;
        $cita->contacto = $request->contacto;
        $cita->telefono_contacto = $request->telefono;
        $cita->email_contacto = $request->correo;

        $cita->save();
        $fecha = Carbon::parse($cita->fecha_cita)->format('d/m/Y');
        return redirect()->route('crm.citas.index', ["fecha" => $fecha]);
    }

    public function buscarPlacaCita(Request $request)
    {
        $placa_vehiculo = $request->nroPlaca;
        $fechaIn = $request->fechaIn;
        if (is_null($fechaIn)) return null;

        $fechaIn = Carbon::createFromFormat('d/m/Y', $fechaIn)->format('Y-m-d');
        $citaExistente = CitaEntrega::with('empleado.usuario')
            ->whereDate('fecha_cita', $fechaIn)
            ->where('placa_vehiculo', $placa_vehiculo)
            ->where('asistio', 0)
            ->where('habilitado', 1)
            ->orderBy('fecha_cita', 'desc')
            ->first();
        $rpta = (new RecepcionController)->buscarRecepcionPlaca($placa_vehiculo);
        if (!is_null($rpta))
            $rpta['cita'] = $citaExistente;
        return $rpta;
    }
}
