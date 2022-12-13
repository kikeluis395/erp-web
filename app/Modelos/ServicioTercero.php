<?php

namespace App\Modelos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ServicioTercero extends Model
{
    protected $table = "servicio_tercero";
    protected $fillable = ['codigo_servicio_tercero', 'descripcion', 'pvp', 'estado', 'f_creacion', 'f_edicion', 'creado_por', 'editado_por'];
    protected $primaryKey = 'id_servicio_tercero';

    public $timestamps = false;

    public function serviciosTercerosSolicitados()
    {
        return $this->hasMany('App\Modelos\ServicioTerceroSolicitado', 'id_servicio_tercero');
    }

    public function usuario()
    {
        return $this->hasOne('App\Modelos\Usuario', 'id_usuario', 'creado_por');
    }

    public function editor()
    {
        return $this->hasOne('App\Modelos\Usuario', 'id_usuario', 'editado_por');
    }

    public function marcasQueAplican()
    {
        return $this->hasMany(MarcaServicioTercero::class, 'servicio_tercero_id', 'id_servicio_tercero');
    }

    public function estados()
    {
        return Parametro::where(['valor2' => 'ESTADO SERVICIO TERCERO', 'estado' => '1'])->get();
    }


    public function getFechaCreacion()
    {
        $cre = $this->f_creacion;
        $edi = $this->f_edicion;
        if (is_null($cre)) {
            if (is_null($edi)) return '-';
            return Carbon::parse($edi)->format('Y-m-d');
        }
        return Carbon::parse($cre)->format('Y-m-d');
    }
    public function creador()
    {
        $user = $this->usuario;
        $supl = $this->editor;
        if (is_null($user)) {
            if (is_null($supl)) return '-';
            return strtoupper($supl->username);
        }
        return strtoupper($user->username);
    }
}
