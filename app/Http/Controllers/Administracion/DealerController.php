<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Administracion\AccesoCitas;
use App\Modelos\Administracion\HorarioTrabajo;
use App\Modelos\CitaEntrega;
use App\Modelos\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DealerController extends Controller
{
    public function index()
    {
        $asesores = Usuario::whereHas('rol', function ($query) {
            $query->where('nombre_interno', 'asesor_servicios');
        })->get();

        $accesos = AccesoCitas::all();
        $accesos = $this->mapear_accesos($accesos, $asesores);
        $last_fecha =  $this->last_fecha()->format('Y-m-d');

        $horario = HorarioTrabajo::whereNull('aplica_hasta')->get()->first();
        $horario = $this->mapear_horario($horario);

        $data = [
            "asesores" => $asesores,
            "accesos" => $accesos,
            "last_fecha" => $last_fecha,
            "horario" => $horario
        ];
        return view('administracion.configuracionDealer', $data);
    }

    public function store(Request $request)
    {
        //
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

    public function last_fecha()
    {
        $last_cita = CitaEntrega::orderBy('fecha_cita', 'asc')->where('habilitado', 1)->get()->last();
        $last_fecha_cita =  $last_cita->fecha_cita;
        $last_fecha_cita =  Carbon::parse($last_fecha_cita);
        return $last_fecha_cita;
    }

    public function store_horario(Request $request)
    {
        // $last_cita = CitaEntrega::orderBy('fecha_cita', 'asc')->get()->last();
        // $last_fecha_cita =  $last_cita->fecha_cita;
        // $last_fecha_cita =  Carbon::parse($last_fecha_cita);
        $last_fecha_cita =  $this->last_fecha();

        $horario_uso_zero = HorarioTrabajo::where('en_uso', 0)->get()->first();

        $lunes_viernes_in = $request->lunes_viernes_in;
        $lunes_viernes_in = Carbon::createFromFormat('H:i', $lunes_viernes_in)->format('H:i:s');

        $lunes_viernes_out = $request->lunes_viernes_out;
        $lunes_viernes_out = Carbon::createFromFormat('H:i', $lunes_viernes_out)->format('H:i:s');

        $sabado_in = $request->sabado_in;
        $sabado_in = Carbon::createFromFormat('H:i', $sabado_in)->format('H:i:s');

        $sabado_out = $request->sabado_out;
        $sabado_out = Carbon::createFromFormat('H:i', $sabado_out)->format('H:i:s');

        $domingo_in = $request->domingo_in;
        $domingo_in = Carbon::createFromFormat('H:i', $domingo_in)->format('H:i:s');

        $domingo_out = $request->domingo_out;
        $domingo_out = Carbon::createFromFormat('H:i', $domingo_out)->format('H:i:s');

        $intervalo_citas = $request->intervalo_citas;

        if ($horario_uso_zero) {
            $horario_uso_zero->dom_in = $domingo_in;
            $horario_uso_zero->dom_out = $domingo_out;
            $horario_uso_zero->lun_in = $lunes_viernes_in;
            $horario_uso_zero->lun_out = $lunes_viernes_out;
            $horario_uso_zero->mar_in = $lunes_viernes_in;
            $horario_uso_zero->mar_out = $lunes_viernes_out;
            $horario_uso_zero->mie_in = $lunes_viernes_in;
            $horario_uso_zero->mie_out = $lunes_viernes_out;
            $horario_uso_zero->jue_in = $lunes_viernes_in;
            $horario_uso_zero->jue_out = $lunes_viernes_out;
            $horario_uso_zero->vie_in = $lunes_viernes_in;
            $horario_uso_zero->vie_out = $lunes_viernes_out;
            $horario_uso_zero->sab_in = $sabado_in;
            $horario_uso_zero->sab_out = $sabado_out;
            $horario_uso_zero->intervalo_citas = $intervalo_citas;
            $horario_uso_zero->editor = Auth::user()->id_usuario;
            $horario_uso_zero->fecha_edicion = Carbon::now();
            $horario_uso_zero->save();
        } else {
            $last_horario = HorarioTrabajo::whereNull('aplica_hasta')->get()->first();
            if ($last_horario) {
                $last_horario->aplica_hasta = $last_fecha_cita->format('Y-m-d');
                $last_horario->editor = Auth::user()->id_usuario;
                $last_horario->fecha_edicion = Carbon::now();
                $last_horario->save();
            }
            $nuevo_horario = new HorarioTrabajo();
            $nuevo_horario->dom_in = $domingo_in;
            $nuevo_horario->dom_out = $domingo_out;
            $nuevo_horario->lun_in = $lunes_viernes_in;
            $nuevo_horario->lun_out = $lunes_viernes_out;
            $nuevo_horario->mar_in = $lunes_viernes_in;
            $nuevo_horario->mar_out = $lunes_viernes_out;
            $nuevo_horario->mie_in = $lunes_viernes_in;
            $nuevo_horario->mie_out = $lunes_viernes_out;
            $nuevo_horario->jue_in = $lunes_viernes_in;
            $nuevo_horario->jue_out = $lunes_viernes_out;
            $nuevo_horario->vie_in = $lunes_viernes_in;
            $nuevo_horario->vie_out = $lunes_viernes_out;
            $nuevo_horario->sab_in = $sabado_in;
            $nuevo_horario->sab_out = $sabado_out;
            $nuevo_horario->en_uso = 0;
            $nuevo_horario->aplica_desde = $last_fecha_cita->addDay()->format('Y-m-d');
            $nuevo_horario->intervalo_citas = $intervalo_citas;
            $nuevo_horario->creador = Auth::user()->id_usuario;
            $nuevo_horario->id_local = Auth::user()->empleado->id_local;

            $nuevo_horario->save();
        }
        return response()->json(['success' => true]);
    }
    private function mapear_horario($horario)
    {
        return [
            "id_horario" => $horario->id_horario,
            "H_LV_IN" => $horario->lun_in,
            "H_LV_OUT" => $horario->lun_out,
            "H_S_IN" => $horario->sab_in,
            "H_S_OUT" => $horario->sab_out,
            "H_D_IN" => $horario->dom_in,
            "H_D_OUT" => $horario->dom_out,
            "aplica_desde" => $horario->aplica_desde,
            "intervalo_citas" => $horario->intervalo_citas
        ];
    }

    private function mapear_accesos($accesos, $asesores)
    {
        $arr = [];

        foreach ($asesores as $asesor) {
            $arr["I$asesor->id_usuario"] = null;
        }

        foreach ($accesos as $acceso) {
            $arr["I$acceso->id_usuario"] = $acceso;
        }

        return $arr;
    }
    public function store_acceso_citas(Request $request)
    {
        $activos = $request->activos;
        $inactivos = $request->inactivos;

        if (!is_null($activos)) {
            foreach ($activos as $activo) {
                $acceso = AccesoCitas::where('id_usuario', $activo)->get()->first();
                if ($acceso) {
                    $acceso->habilitado = 1;
                    $acceso->fecha_edicion = Carbon::now();
                    $acceso->editor = Auth::user()->id_usuario;
                    $acceso->save();
                } else {
                    $acceso = new AccesoCitas();
                    $acceso->id_usuario = $activo;
                    $acceso->habilitado = 1;
                   
                    $acceso->id_local = Auth::user()->empleado->id_local;
                    $acceso->creador = Auth::user()->id_usuario;
                    $acceso->save();
                }
            }
        }

        if (!is_null($inactivos)) {
            foreach ($inactivos as $inactivo) {
                $acceso = AccesoCitas::where('id_usuario', $inactivo)->get()->first();
                if ($acceso) {
                    $acceso->habilitado = 0;
                    
                    $acceso->fecha_edicion = Carbon::now();
                    $acceso->editor = Auth::user()->id_usuario;
                    $acceso->save();
                }
            }
        }

        return response()->json(['success' => true]);
    }
}
