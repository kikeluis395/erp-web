<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class HorarioTrabajo extends Model
{
    protected $table = "horarios_trabajo";
    protected $fillable = [
        'dom_in',
        'dom_out',
        'lun_in',
        'lun_out',
        'mar_in',
        'mar_out',
        'mie_in',
        'mie_out',
        'jue_in',
        'jue_out',
        'vie_in',
        'vie_out',
        'sab_in',
        'sab_out',
        'en_uso',
        'aplica_desde',
        'aplica_hasta',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_horario';
    public $timestamps = false;
}
