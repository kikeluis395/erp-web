<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ItemNecesidadRepuestosDeleted extends Model
{
    protected $table = "item_necesidad_repuestos_deleted";

    protected $fillable =['id_item_necesidad_repuestos','numero_parte', 'id_repuesto','descripcion_item_necesidad_repuestos','cantidad','fecha_pedido','fecha_promesa','es_importado','id_estado_repuesto','entregado','fecha_entrega','id_necesidad_repuestos','es_grupo'];
    
    protected $primaryKey ="id_item_necesidad_repuestos_deleted";

    public $timestamps=false;

    public function repuesto()
    {
        return $this->belongsTo('App\Modelos\Repuesto','id_repuesto');
    }

    public function getCodigoRepuesto()
    {
        return $this->repuesto->codigo_repuesto;
    }

    public function getDescripcionRepuestoTexto()
    {
        return ($descripcionRepuesto = $this->getDescripcionRepuesto()) ? $descripcionRepuesto : '-';
    }

    public function movimientoSalida()
    {
        return $this->belongsTo('App\Modelos\MovimientoRepuesto','id_movimiento_salida');
    }

    public function necesidadRepuestos()
    {
    	return $this->belongsTo('App\Modelos\NecesidadRepuestos','id_necesidad_repuestos');
    }

    public function idRecepcionOT(){
        return$this->necesidadRepuestos->hojaTrabajo->id_recepcion_ot;
    }

    public function getDocumentoGenerado(){
        if( $this->necesidadRepuestos->hojaTrabajo->recepcionOT->ultEntrega()!=null){
            return $this->necesidadRepuestos->hojaTrabajo->recepcionOT->ultEntrega()->nro_factura;
        }else{
            return '-';
        }
        
    }

    public function getDescripcionRepuesto()
    {
        return ($descripcionAprobado = $this->getDescripcionRepuestoAprobado()) ? $descripcionAprobado : $this->getDescripcionItemNecesidadRepuestos();
    }

    public function getDescripcionRepuestoAprobado()
    {
        return $this->id_repuesto ? $this->repuesto->descripcion : null;
    }
    
    public function getUbicacionRepuestoAprobado()
    {
        return $this->id_repuesto ? $this->repuesto->ubicacion : null;
    }

    public function movimientoRepuesto(){
        return $this->morphOne(MovimientoRepuesto::class,'fuente'); 
    }

    public function fuente(){
        return 'OT';
    }

    public function idFuente(){
        return $this->idRecepcionOT();
    }

    public function nroFactura(){
        return $this->getDocumentoGenerado();
    }

    public function motivo(){
        return 'EGRESO';
    }

    public function usuarioNombre(){
        return $this->necesidadRepuestos->hojaTrabajo->empleado->nombreCompleto();
    }
    
    public function getRepuestoNroParte()
    {
        return $this->id_repuesto ? $this->repuesto->getNroParte() : null;
    }

    
}
