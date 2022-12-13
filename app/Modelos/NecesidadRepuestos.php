<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class NecesidadRepuestos extends Model
{
    protected $table = "necesidad_repuestos";

    protected $fillable =['id_hoja_trabajo'];

    protected $primaryKey ="id_necesidad_repuestos";

    public $timestamps=false;

    public function hojaTrabajo()
    {
    	return $this->belongsTo('App\Modelos\HojaTrabajo','id_hoja_trabajo');
    }

    public function estadoRepuesto()
    {
    	return $this->belongsTo('App\Modelos\EstadoRepuesto','id_necesidad_repuestos');
    }

    public function itemsNecesidadRepuestos()
    {
    	return $this->hasMany('App\Modelos\ItemNecesidadRepuestos','id_necesidad_repuestos');
    }

    public function getNoEntregados()
    {
        $cantItems = $this->itemsNecesidadRepuestos()->where('entregado',0)->count();
        return $cantItems;
    }

    public function getEntregados()
    {
        $cantItems = $this->itemsNecesidadRepuestos()->where('entregado',1)->count();
        return $cantItems;
    }

    public function getSinCodigo()
    {
        $cantItems = $this->itemsNecesidadRepuestos()->where('id_repuesto',null)->count();
        return $cantItems;
    }

    public function getImportados()
    {
        $cantItems = $this->itemsNecesidadRepuestos()->where('es_importado',1)->count();
        return $cantItems;
    }
    public function getEnTransito()
    {
        $cantItems = $this->itemsNecesidadRepuestos()->where('es_importado',0)->where('entregado',0)->count();
        return $cantItems;
    }

    public function setIdHojaTrabajo($idHojaTrabajo)
    {
        $this->id_hoja_trabajo=$idHojaTrabajo;
    }

    public function getNecesidadRepuestosIdHojaTrabajo()
    {
        return $this->id_hoja_trabajo;
    }

    public function getIdLocal()
    {
        return $this->hojaTrabajo->empleado->id_local;
    }

    public function getEstadoNecesidad()
    {
        $cantItems = $this->itemsNecesidadRepuestos()->count();
        $cantItemsAtendidos = $this->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->count();
        $cantItemsEntregados = $this->itemsNecesidadRepuestos()->where('entregado',1)->count();

        if ($cantItems-$cantItemsAtendidos > 0 ) { //Siempre que haya POR LO MENOS 1 REPUESTO “SIN CODIFICAR”, tiene dicho estado
            return 'SIN ATENDER';
        }
        elseif($cantItemsEntregados == $cantItems) {
            return 'ENTREGADO';
        }
        elseif (($cantItemsAtendidos == $cantItems)&&($cantItemsAtendidos -$cantItemsEntregados)>0) {//Cuando se hayan codificado TODOS LOS REPUESTOS y por lo menos haya 1 REPUESTO SIN ENTREGAR
            return 'EN SOLICITUD';
        }
        else {
            return '*';
        }
    }

    public function esImprimible()
    {
        $itemsEntregados = $this->itemsNecesidadRepuestos ? $this->itemsNecesidadRepuestos->where('id_repuesto',null) : collect([]);

        // foreach($items as $itemNecesidadRepuesto){
        //     // se considera que el repuesto registrado debe estar marcado como EN IMPORTACION para que no sea considerado
        //     // como no imprimible. Si el repuesto está como EN TRASITO sin entregar entonces no sera imprimible
        //     if( !$itemNecesidadRepuesto->id_repuesto || (!$itemNecesidadRepuesto->entregado && !$itemNecesidadRepuesto->es_importacion) )
        //         return false;
        // }

        return $itemsEntregados->count() > 0 ? true : false;
    }

    public function getNumItemsStock()
    {
        $items = $this->itemsNecesidadRepuestos;
        $total = 0;
        foreach($items as $itemNecesidadRepuesto){
            $total += $itemNecesidadRepuesto->getDisponibilidad() == 'EN STOCK' ? 1 : 0;
        }

        return $total;
    }

    public function getNumItemsTransito()
    {
        $items = $this->itemsNecesidadRepuestos;
        $total = 0;
        foreach($items as $itemNecesidadRepuesto){
            $total += $itemNecesidadRepuesto->getDisponibilidad() == 'EN TRÁNSITO' ? 1 : 0;
        }

        return $total;
    }

    public function getNumItemsImportacion()
    {
        $items = $this->itemsNecesidadRepuestos;
        $total = 0;
        foreach($items as $itemNecesidadRepuesto){
            $total += $itemNecesidadRepuesto->getDisponibilidad() == 'EN IMPORTACIÓN' ? 1 : 0;
        }

        return $total;
    }

    public function getNumItemsEntregados()
    {
        return $this->itemsNecesidadRepuestos()->where('entregado',1)->count();
    }

    public function getNumItemsSinCodigo()
    {
        return $this->itemsNecesidadRepuestos()->whereNull('id_repuesto')->count();
    }

    public function estadoParaUnaCotizacion()
    {
        if($this->getNumItemsSinCodigo()>0){
            return "SIN CODIFICAR";
        }else{
            return "CODIFICADOS";
        }
    }
}
