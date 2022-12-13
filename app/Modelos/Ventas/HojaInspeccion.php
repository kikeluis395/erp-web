<?php

namespace App\Modelos\Ventas;

use App\Modelos\Ventas\EstadoHojaInspeccion;
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

    public static function getTableName(): string {
        return "hoja_inspeccion";
    }

    public static function getIdName(): string {
        return "id_hoja_inspeccion";
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
        $model->estado_id = EstadoHojaInspeccion::inspeccionSavar()->getId();
        return $model;
    }

    public function updateData(
        $id_recepcion_ot,
        $modelo,
        $color,
        $ano_modelo,
        $vin,
        $destino,
        $id_usuario_savar,
        $id_usuario_dealer
    ){
        $this->id_recepcion_ot = $id_recepcion_ot;
        $this->modelo = $modelo;
        $this->color = $color;
        $this->ano_modelo = $ano_modelo;
        $this->vin = $vin;
        $this->destino = $destino;

        $estado = EstadoHojaInspeccion::fromId($this->estado_id);
        if(EstadoHojaInspeccion::isSavar($estado->getNombre()))
        {
            $this->id_usuario_savar = $id_usuario_savar;
            //fechas de actualizacion
        }else if(EstadoHojaInspeccion::isDealer($estado->getNombre())){
            $this->id_usuario_dealer = $id_usuario_dealer;
            //fechas de actualizacion
        }
    }

    public function getId(){return $this->id_hoja_inspeccion;}

    public function addElemento($elemento_id, bool $isValidatedSavar = false, bool $isValidatedDealer = false){
        $linea = new LineaResultadoInspeccion();
        $linea->id_elemento_inspeccion = $elemento_id;
        $linea->es_savar = $isValidatedSavar ? 1 : 0;
        $linea->es_dealer = $isValidatedDealer ? 1 : 0;
        $this->elementos[$elemento_id] = $linea;
    }

    public function updateElemento($elemento_id, bool $isValidatedSavar = false, bool $isValidatedDealer = false)
    {
        $estado = EstadoHojaInspeccion::fromId($this->estado_id);
        if(EstadoHojaInspeccion::isSavar($estado->getNombre())){
            $this->elementos[$elemento_id]->es_savar = $isValidatedSavar ? 1 : 0;
        }else if(EstadoHojaInspeccion::isDealer($estado->getNombre())){
            $this->elementos[$elemento_id]->es_dealer = $isValidatedDealer ? 1 : 0;
        }
    }

    public function elementoIsAlreadyAdded($elemento_id): bool {
        return isset($this->elementos[$elemento_id]);
    }

    public function changeStateToDealer(){
        $this->estado_id = EstadoHojaInspeccion::inspeccionDealer()->getId();
    }

    public function changeStateToCompletado(){
        $this->estado_id = EstadoHojaInspeccion::completado()->getId();
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

    public function updateAll(){
        DB::beginTransaction();
        try {
            $this->save();
            foreach($this->elementos as $elemento){
                $linea = LineaResultadoInspeccion::where('id_hoja_inspeccion', $this->getId())
                    ->where('id_elemento_inspeccion', $elemento->id_elemento_inspeccion)
                    ->first();

                $linea->es_savar = $elemento->es_savar;
                $linea->es_dealer = $elemento->es_dealer;
                $linea->save();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function loadAllIndex()
    {
        $lineasHojaInspeccion = LineaResultadoInspeccion::where('id_hoja_inspeccion', $this->getId())->get();
        foreach($lineasHojaInspeccion as $linea){
            $this->addElemento(
                $linea->id_elemento_inspeccion,
                $linea->es_savar === 1,
                $linea->es_dealer === 1
            );
        }
    }

    public function loadAll(){
        $this->estado = EstadoHojaInspeccion::find($this->estado_id)->getNombre();
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

    public static function getAll(?callable $queryFilters = null){
        $query = HojaInspeccion::select(
                'id_hoja_inspeccion',
                'fecha_registro',
                'id_recepcion_ot',
                'id_usuario_savar',
                'id_usuario_dealer',
                'modelo',
                'color',
                'ano_modelo',
                'vin',
                'destino',
                'estado.nombre as estado',
            )
            ->join('estado_hoja_inspeccion as estado', 'estado.id', '=', HojaInspeccion::getTableName().".estado_id");

        if($queryFilters !== null){
            $queryFilters($query);
        }
        $listaElementosInspeccion = $query->get();

        return $listaElementosInspeccion;
    }
}
