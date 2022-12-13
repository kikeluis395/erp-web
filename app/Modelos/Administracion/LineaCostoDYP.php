<?php

namespace App\Modelos\Administracion;

use Illuminate\Database\Eloquent\Model;

class LineaCostoDYP extends Model
{
    protected $table = "linea_costo_dyp";
    protected $fillable = [
        'anho',
        'mes',
        'valor_costo',
        'moneda',
        'habilitado',
        'id_costo_asociado_dyp',
        'fecha_registro',
    ];
    protected $primaryKey = 'id_linea_costo_dyp';

    public $timestamps = false;

    public function costo()
    {
        return $this->hasOne('App\Modelos\Administracion\CostoDYP', 'id_costo_asociado_dyp', 'id_costo_asociado_dyp');
    }
    public function listar()
    {
        return [
            'valor_costo_' . $this->anho . '_' . strtolower($this->mes) => $this->valor_costo,
            'moneda_' . $this->anho . '_' . strtolower($this->mes) => $this->moneda,
        ];
    }
}
