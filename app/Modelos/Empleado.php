<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = "empleado";
    protected $fillable = ['dni', 'primer_nombre', 'primer_apellido', 'segundo_apellido', 'fecha_nacimiento', 'email', 'telefono_contacto', 'id_local'];
    protected $primaryKey = 'dni';

    public $timestamps = false;
    public $incrementing = false;

    public function usuario()
    {
        return $this->hasMany('App\Modelos\Usuario', 'dni');
    }

    public function recepciones()
    {
        return $this->hasMany('App\Modelos\HojaTrabajo', 'dni_empleado');
    }

    public function nombreCompleto()
    {
        return $this->primer_nombre . ' ' . $this->primer_apellido . ' ' . $this->segundo_apellido;
    }

    public function local()
    {
        return $this->belongsTo('App\Modelos\LocalEmpresa', 'id_local');
    }
}
