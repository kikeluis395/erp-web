<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TipoDanhoTemp extends Model
{
    public static $tipos_danho = ["EXPRESS","LEVE","MEDIO","FUERTE"];
    public static function tiposDanhoExcelValidation()
    {
        return "\"" . implode(",", self::$tipos_danho) . "\"";
    }

    protected $table = "tipo_danho_temp";

    protected $fillable =['id_marca_auto','id_cia_seguro','limite_inf_leve','limite_inf_medio','limite_inf_fuerte'];

    protected $primaryKey ="id_tipo_danho_temp";

    public $timestamps = false;
}
