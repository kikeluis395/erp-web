<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class CriterioDanho extends Model
{
    protected $table = "criterio_danho";
    protected $fillable = [
        'codigo',
        'valor',
        'editable',
        'habilitado',
        'before',
        'id_usuario',
        'fecha_registro',
        'fecha_edicion',
    ];
    protected $primaryKey = 'id_criterio';

    public $timestamps = false;

    public function usuario()
    {
        return $this->hasOne('App\Modelos\Usuario', 'id_usuario', 'id_usuario');
    }
}
