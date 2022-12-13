<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ConsumoTaller extends Model
{
    protected $table = 'consumo_taller';
    public $timestamps = false;
    protected $fillable = ['usuario_solicitante','fecha_entrega','fecha_registro','id_usuario'];
    public $primaryKey = 'id_consumo_taller';

    public function usuario() {
        return $this->belongsTo('App\Modelos\Usuario', 'id_usuario');
    }

    public function lineaConsumoTaller() {
        return $this->hasMany('App\Modelos\LineaConsumoTaller', 'id_consumo_taller');
    }

    public function getNombreCompletoUsuarioRegistro() {
        return $this->usuario->empleado->primer_nombre . ' ' . $this->usuario->empleado->primer_apellido;
    }

    public function getCostoTotal()
    {
        $lineasConsumoTaller = $this->lineaConsumoTaller;
        $total = 0;
        foreach ($lineasConsumoTaller as $key => $lineaConsumoTaller) {
            $total += $lineaConsumoTaller->obtenerTotal();
        }
        return $total;
    }
}
