<?php

namespace App\Modelos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HojaInspeccion extends Model
{
    protected $table = "hoja_inspeccion";
    protected $fillable = ['id_recepcion_ot','','','fecha_registro'];
    protected $primaryKey='id_hoja_inspeccion';

    public $timestamps = false;

    public function recepcionOT()
    {
        return $this->belongsTo('App\Modelos\RecepcionOT','id_recepcion_ot');
    }

    public function lineasHojaInspeccion()
    {
        return $this->hasMany('App\Modelos\LineaHojaInspeccion','id_hoja_inspeccion');
    }

    public function lineasResultadoInspeccion()
    {
        return $this->hasMany('App\Modelos\LineaResultadoInspeccion','id_hoja_inspeccion');
    }

    private $elementos = [];

    public static function create(
        $id_usuario_savar,
        $modelo,
        $color,
        $ano_modelo,
        $vin,
        $destino
    ){
        $model = new self();
        $model->fecha_registro = Carbon::now();
        $model->id_recepcion_ot = null;
        $model->id_usuario_savar = $id_usuario_savar;
        $model->modelo = $modelo;
        $model->color = $color;
        $model->ano_modelo = $ano_modelo;
        $model->vin = $vin;
        $model->destino = $destino;
        return $model;
    }

    public function getId(){return $this->id_hoja_inspeccion;}

    public function addElemento($elemento_id, bool $isValidatedSavar = false, bool $isValidatedDealer = false){
        $linea = new LineaResultadoInspeccion();
        $linea->id_elemento_inspeccion = $elemento_id;
        $linea->es_savar = $isValidatedSavar ? 1 : 0;
        $linea->es_dealer = $isValidatedDealer ? 1 : 0;
        $this->elementos[$elemento_id] = $linea;
    }

    public function elementoIsAlreadyAdded($elemento_id): bool {
        return isset($this->elementos[$elemento_id]);
    }

    public function createAll(){
        DB::beginTransaction();
        try {
            $this->save();
            foreach($this->elementos as $elemento){
                $elemento->id_hoja_inspeccion = $this->getId();
                $elemento->save();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function getAll(){
        $this->elementosInspeccion = LineaResultadoInspeccion::select(
            'el.id_elemento_inspeccion',
            'el.nombre_elemento_inspeccion',
            'group.id as grupo_elemento_id',
            'group.nombre as grupo_elemento_nombre',
            DB::Raw("if(linea_resultado_inspeccion.es_savar=1,'true','false') as isValidatedSavar"),
            DB::Raw("if(linea_resultado_inspeccion.es_dealer=1,'true','false') as isValidatedDealer")
        )
            ->join('elemento_inspeccion as el', 'el.id_elemento_inspeccion', '=', 'linea_resultado_inspeccion.id_elemento_inspeccion')
            ->join('grupo_elemento_inspeccion as group','group.id', '=', 'el.grupo_elemento_id')
            ->where('linea_resultado_inspeccion.id_hoja_inspeccion', $this->getId())
            ->get()
            ->groupBy('grupo_elemento_id');
        
        foreach($this->elementosInspeccion as $groupOfElements){
            foreach($groupOfElements as $elemento){
                $elemento->isValidatedSavar = $elemento->isValidatedSavar == 'true';
                $elemento->isValidatedDealer = $elemento->isValidatedDealer == 'true';
            }
        }
        return $this;
    }
}
