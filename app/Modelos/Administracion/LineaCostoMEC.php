<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class LineaCostoMEC extends Model
{
    protected $table = "linea_costo_mec";
    protected $fillable = [
        'anho',
        'mes',
        'valor_costo',
        'moneda',
        'habilitado',
        'id_costo_asociado_mec',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_linea_costo_mec';

    public $timestamps = false;

    public function costo()
    {
        return $this->hasOne('App\Modelos\Administracion\CostoMEC', 'id_costo_asociado_mec', 'id_costo_asociado_mec');
    }

    public function listar()
    {
        return [
            'valor_costo_' . $this->anho . '_' . strtolower($this->mes) => $this->valor_costo,
            'moneda_' . $this->anho . '_' . strtolower($this->mes) => $this->moneda,
        ];
    }
}
