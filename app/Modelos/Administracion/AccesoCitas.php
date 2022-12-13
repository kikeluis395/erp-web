<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class AccesoCitas extends Model
{
    protected $table = "acceso_citas";
    protected $fillable = [
        'id_usuario',
        'habilitado',
        'fecha_edicion',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_acceso';
    public $timestamps = false;

    public function usuario()
    {
        return $this->hasOne('App\Modelos\Usuario', 'id_usuario', 'id_usuario');
    }
}
