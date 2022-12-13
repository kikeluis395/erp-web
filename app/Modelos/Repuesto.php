<?php

namespace App\Modelos;

use App\Modelos\Internos\ItemTransaccionMonetaria;
use Carbon\Carbon;

class Repuesto extends ItemTransaccionMonetaria
{
    protected $table = 'repuesto';
    protected $primaryKey='id_repuesto';
    protected $fillable = ['codigo_repuesto', 'descripcion', 'ubicacion','pvp','id_categoria_repuesto','id_unidad_grupo','cantidad_unidades_grupo'];

    public function categoriaRepuesto()
    {
        return $this->belongsTo('App\Modelos\CategoriaRepuesto','id_categoria_repuesto');
    }

    public function unidadGrupo()
    {
        return $this->belongsTo('App\Modelos\UnidadMedida','id_unidad_grupo');
    }

    public function marca()
    {
        return $this->belongsTo('App\Modelos\MarcaAuto','id_marca');
    }

    public function unidadMedida()
    {
        return $this->belongsTo('App\Modelos\UnidadMedida','id_unidad_medida');
    }

    public function itemsNecesidadRepuestos()
    {
        return $this->hasMany('App\Modelos\ItemNecesidadRepuestos','id_repuesto');
    }

    public function preciosRepuesto()
    {
        return $this->hasMany('App\Modelos\PrecioRepuesto','id_repuesto');
    }

    public function preciosRepuestoMayoreo()
    {
        return $this->hasMany('App\Modelos\PrecioRepuestoMayoreo','id_repuesto');
    }
    
    public function getNroParte()
    {
        return $this->codigo_repuesto;
    }

    public function getNombreCategoria()
    {
        return $this->categoriaRepuesto->nombre_categoria;
    }

    public function movimientosRepuesto()
    {
        return $this->hasMany('App\Modelos\MovimientoRepuesto', 'id_repuesto');
    }

    public function esLubricante()
    {
        return $this->getNombreCategoria()=='LUBRICANTES';
    }

    public function repuestoAplicaModeloTecnico(){
        return $this->hasMany('App\Modelos\RepuestoAplicaModeloTecnico', 'id_repuesto');
    }
    
    public function getStock($idLocal)
    {
        $ultimoMovimiento = MovimientoRepuesto::getMovimientosBaseQuery()
             ->where('r.codigo_repuesto', $this->codigo_repuesto)
             ->where('le.id_local', $idLocal)
             ->orderBy('fecha_movimiento','desc')->first();

        return $ultimoMovimiento ? $ultimoMovimiento->saldo : 0;
    }

    public function getStockVirtual($idLocal)
    {
        $ultimoMovimiento = MovimientoRepuesto::getMovimientosBaseQuery()
             ->where('r.codigo_repuesto', $this->codigo_repuesto)
             ->where('le.id_local', $idLocal)
             ->orderBy('fecha_movimiento','desc')->first();

        return $ultimoMovimiento ? $ultimoMovimiento->saldo_virtual : 0;
    }

    public function getResumenStockLocales()
    {
        return MovimientoRepuesto::getUltimosMovimientosBaseQuery()->where('mr.id_repuesto', $this->id_repuesto)->get();
    }

    public function getPrecio(Carbon $fechaConsulta){
        $precio=$this->preciosRepuesto()->where('fecha_inicio_aplicacion','<=',$fechaConsulta)->orderBy('fecha_inicio_aplicacion', 'desc')->first();
        
        return $precio;
    }

    public function getPrecioMayoreo(Carbon $fechaConsulta){
        $precio=$this->preciosRepuestoMayoreo()->where('fecha_inicio_aplicacion','<=',$fechaConsulta)->orderBy('fecha_inicio_aplicacion', 'desc')->first();
        if($precio != null){
            return $precio->monto;
        }else{
            return $this->pvp_mayoreo;
        }
        
    }

    public function getCantidadUnidadesGrupo(){
        // return $this->cantidad_unidades_grupo? $this->cantidad_unidades_grupo : 1;
        return 1;
    }
    
    public function getPrecioAuxiliar(){
        return $this->pvp;
    }

    public function getMonedaAuxiliar(){
        return $this->moneda_pvp;
    }

    public function getNombreUnidadGrupo(){
        return $this->unidadGrupo ? $this->unidadGrupo->nombre_unidad : $this->unidadMedida->nombre_unidad;
    }

    public function getNombreUnidadMinima(){
        return $this->unidadMedida->nombre_unidad;
    }

    public function getAbreviaUnidadGrupo(){
        return $this->unidadGrupo ? $this->unidadGrupo->abreviacion : $this->unidadMedida->abreviacion;
    }

    public function getAbreviaUnidadMinima(){
        return $this->unidadMedida->abreviacion;
    }
}
