<?php

namespace App\Modelos\Ventas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PrecioVehiculoSeminuevo extends Model
{
    protected $table = 'precio_vehiculo_seminuevo';
    protected $fillable = [
        'id_vehiculo_seminuevo',
        'precio',
        'creador',
        'editor',
        'id_local',
        'habilitado',
        'fecha_edicion',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_precio_vehiculo_seminuevo';
    public $timestamps = false;

    public function usuario_creador()
    {
        return $this->hasOne('App\Modelos\Usuario', 'id_usuario', 'creador');
    }
    public function usuario_editor()
    {
        return $this->hasOne('App\Modelos\Usuario', 'id_usuario', 'editor');
    }
    public function vehiculo()
    {
        return $this->hasOne('App\Modelos\VehiculoSeminuevo', 'id_vehiculo_seminuevo', 'id_vehiculo_seminuevo');
    }

    public function prior_fecha()
    {
        $fecha_edicion = $this->fecha_edicion;
        $fecha_registro = $this->fecha_registro;
        if ($fecha_edicion) return Carbon::parse($fecha_edicion)->format('d/m/Y');
        if ($fecha_registro) return Carbon::parse($fecha_registro)->format('d/m/Y');
        return '';
    }
    public function prior_usuario()
    {
        $editor = $this->usuario_editor;
        $creador = $this->usuario_creador;
        if ($editor) return $editor->empleado->nombreCompleto();
        if ($creador) return $creador->empleado->nombreCompleto();
        return '';
    }
}
