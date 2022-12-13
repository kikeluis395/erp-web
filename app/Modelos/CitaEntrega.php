<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CitaEntrega extends Model
{
    protected $table = "cita_entrega";
    protected $fillable = ['fecha_cita', 'fecha_registro', 'placa_vehiculo', 'doc_cliente', 'asistio', 'dni_empleado'];
    protected $primaryKey = 'id_cita_entrega';

    public $timestamps = false;

    public function vehiculo()
    {
        return $this->belongsTo('App\Modelos\Vehiculo', 'placa_vehiculo', 'placa');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Modelos\Cliente', 'doc_cliente', 'num_doc');
    }

    public function empleado()
    {
        return $this->belongsTo('App\Modelos\Empleado', 'dni_empleado', 'dni');
    }

    public function usuario()
    {
        return $this->hasOne('App\Modelos\Usuario', 'id_usuario', 'id_usuario');
    }

    public function hojaTrabajo()
    {
        return $this->belongsTo('App\Modelos\HojaTrabajo', 'id_hoja_trabajo');
    }

    public function modeloTable()
    {
        return $this->belongsTo('App\Modelos\Modelo', 'modelo');
    }

    public function getEstado()
    {
        if (!$this->habilitado) {
            return "CANCELADO";
        }
        $estado = $this->estadoAsistencia();
        if ($estado == "asistio") {
            return "ASISTIÓ";
        } elseif ($estado == "no-asistio") {
            return "NO ASISTIÓ";
        } elseif ($estado == "reservado") {
            return "RESERVADO";
        }
    }

    public function getServicio()
    {
        return $this->detalle_servicio;
    }

    public function getFechaProgramada()
    {
        $fecha = $this->fecha_cita ? Carbon::parse($this->fecha_cita)->format('d/m/Y') : '';
        return $fecha;
    }

    public function getHoraProgramada()
    {

        $hora = $this->fecha_cita ? Carbon::parse($this->fecha_cita)->format('H:i') : '';
        return $hora;
    }

    public function getFechaLlegada()
    {
        if (!is_null($this->id_hoja_trabajo)) {
            $hojaTrabajo = HojaTrabajo::find($this->id_hoja_trabajo);
            if (!is_null($hojaTrabajo)) {
                return $hojaTrabajo->fecha_recepcion;
            }
        }
        return "-";
    }
    public function getFechaParseLlegada()
    {
        $fecha = $this->getFechaLlegada();
        if ($fecha != '-') return Carbon::parse($fecha)->format('d/m/Y');
        return $fecha;
    }

    public function getNombreCliente()
    {
        if (!is_null($this->id_hoja_trabajo)) {
            return $this->hojaTrabajo->getNombreCliente();
        } elseif (!is_null($hojaTrabajo = HojaTrabajo::where('placa_auto', $this->placa_vehiculo)->first())) {
            return $hojaTrabajo->getNombreCliente();
        } elseif (!is_null($this->contacto)) {
            return $this->contacto;
        }
        return "-";
    }

    public function getModelo()
    {
        $modelo = $this->modeloTable ? $this->modeloTable->nombre_modelo : ($this->modelo ? $this->modelo : '-');

        return $modelo;
    }
    public function estadoAsistencia()
    {
        $fechaCita = new Carbon($this->fecha_cita);
        $justFecha = $fechaCita->format('Y-m-d');
        $justFecha .= "23:59:59";
        $expected = new Carbon($justFecha);
        $hours = $expected->diffInHours($fechaCita);

        $fechaCita->addHours($hours);
        $puntoComparacion = Carbon::now();
        if ($this->asistio) {
            return 'asistio';
        } elseif ($fechaCita < $puntoComparacion) {
            return 'no-asistio';
        } elseif ($fechaCita >= $puntoComparacion) {
            return 'reservado';
        }
        // $puntoComparacion = Carbon::now();
        // if ($this->asistio) {
        //     return 'asistio';
        // } elseif ($fechaCita < $puntoComparacion) {
        //     return 'no-asistio';
        // } elseif ($fechaCita >= $puntoComparacion) {
        //     return 'reservado';
        // }
    }

    public function getUsuarioEmisor()
    {
        $usuario = $this->usuario;
        if ($usuario) return strtoupper($usuario->username);
        return '-';
    }

    public function hasModelos()
    {
        $id_marca = $this->id_marca_auto;

        if (!is_null($id_marca)) {
            $modelos_disponibles = Modelo::where('id_marca_auto', $id_marca)->get();
            if (count($modelos_disponibles) > 0) return true;
        }
        return false;
    }
}
