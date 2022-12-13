<?php

namespace App\Modelos\Ventas;

use Illuminate\Database\Eloquent\Model;

class LineaHojaInspeccion extends Model
{
    protected $table = "linea_resultado_inspeccion";
    protected $fillable = ['id_hoja_inspeccion','id_elemento_inspeccion','resultado'];
    protected $primaryKey='id_linea_resultado_inspeccion';
    public $timestamps = false;

    public function isValidatedSavar(): bool {
        return $this->es_savar == 0;
    }

    public function isValidatedDealer(){
        return $this->es_dealer == 0;
    }
}
