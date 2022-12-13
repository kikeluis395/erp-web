<?php

namespace App\Modelos;

use Carbon\Carbon;
use App\Modelos\TipoCambio;
use App\Modelos\Internos\LineaTransaccionMonetaria;
use DateTime;
use App\Modelos\MovimientoRepuesto;


class ItemNecesidadRepuestos extends LineaTransaccionMonetaria
{
    protected $table = "item_necesidad_repuestos";

    protected $fillable =['numero_parte', 'id_repuesto','descripcion_item_necesidad_repuestos','cantidad','fecha_pedido','fecha_promesa','es_importado','id_estado_repuesto','entregado','fecha_entrega','id_necesidad_repuestos','es_grupo'];
    
    protected $primaryKey ="id_item_necesidad_repuestos";

    public $timestamps=false;

    public function necesidadRepuestos()
    {
    	return $this->belongsTo('App\Modelos\NecesidadRepuestos','id_necesidad_repuestos');
    }

    public function estadoRepuesto()
    {
    	return $this->belongsTo('App\Modelos\EstadoRepuesto','id_estado_repuesto');
    }

    public function repuesto()
    {
        return $this->belongsTo('App\Modelos\Repuesto','id_repuesto');
    }

    public function movimientoSalida()
    {
        return $this->belongsTo('App\Modelos\MovimientoRepuesto','id_movimiento_salida');
    }

    public function movimientoSalidaVirtual()
    {
        return $this->belongsTo('App\Modelos\MovimientoRepuesto','id_movimiento_salida_virtual');
    }

    public function getIdLocal()
    {
        return $this->necesidadRepuestos->getIdLocal();
    }

    public function getDisponibilidad()
    {
        if($this->id_repuesto === null) return '-';
        if($this->entregado == 1) return 'ENTREGADO';

        $idLocal = $this->getIdLocal();
        // si se registro como disponible, se tomara en cuenta el stock fisico.
        // si se considero como no disponible en el registro, se comparara con el stock virtual.
        $stockComparacion = $this->es_importado === null ? $this->repuesto->getStock($idLocal) : $this->repuesto->getStockVirtual($idLocal);
        if($this->getCantidadAprobada() <= $stockComparacion)
            return 'EN STOCK';
        elseif($this->es_importado==1) 
            return 'EN IMPORTACIÓN';
        elseif($this->es_importado === 0)
            return 'EN TRÁNSITO';
        else   
            return 'SIN STOCK';
    }

    public function getCodigoRepuesto()
    {
        return $this->repuesto->codigo_repuesto;
    }

    public function getDisponibilidadRepuestoText()
    {
        if($this->id_repuesto === null) return '-';
        if($this->entregado == 1) return 'ENTREGADO';

        $idLocal = $this->getIdLocal();
        // si se registro como disponible, se tomara en cuenta el stock fisico.
        // si se considero como no disponible en el registro, se comparara con el stock virtual.
        $stockComparacion = $this->es_importado === null ? $this->repuesto->getStock($idLocal) : $this->repuesto->getStockVirtual($idLocal);
        if($this->getCantidadAprobada() <= $stockComparacion)
            return "EN STOCK ($stockComparacion)";
        elseif($this->es_importado==1) 
            return 'EN IMPORTACIÓN';
        elseif($this->es_importado === 0)
            return 'EN TRÁNSITO';
    }

    public function hayStock(){
        $idLocal = $this->getIdLocal();
        //tomar la decision de cambiarlo o seguir con esta linea
        $stockComparacion = $this->es_importado === null ? $this->repuesto->getStock($idLocal) : $this->repuesto->getStockVirtual($idLocal);
        if($this->cantidad_aprobada <= $stockComparacion){
            return true;
        }
        return false;
    }

    public function getDescripcionItemNecesidadRepuestos()
    {
        return $this->descripcion_item_necesidad_repuestos;
    }

    public function getDescripcionItemNecesidadRepuestosTexto()
    {
        return $this->getDescripcionItemNecesidadRepuestos() ? $this->getDescripcionItemNecesidadRepuestos() : '-';
    }

    public function getDescripcionRepuestoAprobado()
    {
        return $this->id_repuesto ? $this->repuesto->descripcion : null;
    }

    public function getUbicacionRepuestoAprobado()
    {
        return $this->id_repuesto ? $this->repuesto->ubicacion : null;
    }

    public function getDescripcionRepuestoAprobadoTexto()
    {
        return ($descripcionAprobado = $this->getDescripcionRepuestoAprobado()) ? $descripcionAprobado : '-';
    }

    public function getDescripcionRepuesto()
    {
        return ($descripcionAprobado = $this->getDescripcionRepuestoAprobado()) ? $descripcionAprobado : $this->getDescripcionItemNecesidadRepuestos();
    }

    public function getDescripcionRepuestoTexto()
    {
        return ($descripcionRepuesto = $this->getDescripcionRepuesto()) ? $descripcionRepuesto : '-';
    }

    public function getRepuestoNroParte()
    {
        return $this->id_repuesto ? $this->repuesto->getNroParte() : null;
    }

    public function getRepuestoNroParteTexto()
    {
        return $this->id_repuesto ? $this->repuesto->getNroParte() : '-';
    }

    public function getFechaPedidoCarbon()
    {
        return $this->fecha_pedido ? Carbon::parse($this->fecha_pedido)->format('d/m/Y') : null;
    }

    public function getFechaPedidoTexto()
    {
        return ($fecha = $this->getFechaPedidoCarbon()) ? $fecha : '-';
    }

    public function getFechaPromesaCarbon()
    {
        return $this->fecha_promesa ? Carbon::parse($this->fecha_promesa)->format('d/m/Y') : null;
    }

    public function getFechaPromesaTexto()
    {
        return ($fecha = $this->getFechaPromesaCarbon()) ? $fecha : '-';
    }

    public function idCotizacion(){
        return$this->necesidadRepuestos->hojaTrabajo->id_cotizacion;
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

    public function esPedible()
    {
        $hojaTrabajo = $this->necesidadRepuestos->hojaTrabajo;

        if($hojaTrabajo->id_cotizacion)
            return false;
        elseif(in_array($hojaTrabajo->tipo_trabajo,['PREVENTIVO','CORRECTIVO']))
            return true;
        else{
            $estadoActual = $hojaTrabajo->recepcionOT->estadoActual()[0]->nombre_estado_reparacion_interno;
            if( in_array($estadoActual, ['espera_asignacion','espera_reparacion','paralizado','espera_control_calidad','vehiculo_listo']) ||
                strpos($estadoActual,"reparacion_") === 0 || strpos($estadoActual,"hotline") !== false )
                return true;
            else
                return false;
        }
    }

    public function getDeletedTransactions(){
        $id=  $this->id_item_necesidad_repuestos;
        $sql = "SELECT * FROM track_deleted_transactions
                where origen = 'ItemNecesidadRepuestos' AND id_contenedor_origen = $id";
        $results = DB::select( DB::raw($sql) );
        return $results;
    }

    public function LineaReingresoRepuestos() {
        return $this->belongsTo('App\Modelos\LineaReingresoRepuestos', 'id_necesidad_repuestos', 'id_necesidad_repuestos');
    }

    public function getCantidadSolicitada()
    {
        return $this->cantidad_solicitada;
    }

    public function getCantidadSolicitadaTexto()
    {
        return $this->getCantidadSolicitada() ? $this->getCantidadSolicitada() : '-';
    }

    public function getCantidadAprobada()
    {
        return $this->cantidad_aprobada;
    }

    public function getCantidadAprobadaTexto()
    {
        $unidad = $this->repuesto->unidad_medida;
        return $this->getCantidadAprobada() ? $this->getCantidadAprobada() . " $unidad" : '-';
    }

    public function getCantidadRepuestos()
    {
        return $this->getCantidadAprobada() ? $this->getCantidadAprobada() : $this->getCantidadSolicitada();
    }

    public function getCantidadRepuestosTexto()
    {
        return $this->getCantidadAprobada() ? $this->getCantidadAprobadaTexto() : $this->getCantidadSolicitadaTexto();
    }

    public function esLubricante()
    {
        return $this->repuesto ? $this->repuesto->esLubricante() : null;
    }

    public function getMoneda(){
        return $this->necesidadRepuestos->hojaTrabajo->moneda;
    }
    public function getItemTransaccion(){
        return $this->repuesto;
    }
    public function getTasaDescuento(){
        $descuento = $this->necesidadRepuestos->hojaTrabajo->descuentos()->where('es_aprobado',1)->orderBy('fecha_registro','desc')->first();

        $tasaDescuento = 0;
        if($descuento){
            $tasaDescuento = $this->esLubricante() ? $descuento->porcentaje_aplicado_lubricantes/100 : $descuento->porcentaje_aplicado_rptos/100;
        }
        return $tasaDescuento;
    }
    public function getTipoCambio(){
        return $this->necesidadRepuestos->hojaTrabajo->tipo_cambio ? $this->necesidadRepuestos->hojaTrabajo->tipo_cambio : TipoCambio::getTipoCambioCobroActual();
    }
    public function getFechaRegistroCarbon(){
        if($this->fecha_registro != null) $fecha = Carbon::parse($this->fecha_registro);
        else $fecha = Carbon::parse($this->necesidadRepuestos->hojaTrabajo->fecha_registro);
        return $fecha;
    }

    public function esGrupo(){
        return $this->es_grupo ? true: false;
    }

    //Obtiene la cantidad de unidades minimos del itemNecesidadRepuestos
    public function getCantidad(){
        $cantidad = $this->getCantidadAprobada() ? $this->getCantidadAprobada() : $this->getCantidadSolicitada();
        if($this->esGrupo()) $cantidad = $cantidad * $this->getItemTransaccion()->getCantidadUnidadesGrupo();
        return $cantidad;
    }

    //Obtiene la cantidad de grupos del itemNecesidadRepuestos
    public function getCantidadGrupo(){
        $cantidad = $this->getCantidadAprobada() ? $this->getCantidadAprobada() : $this->getCantidadSolicitada();
        return $cantidad;
    }

    public function egresoVirtualStockDisponible($cantidadAprobada, $stockDisponible){
        // se actualiza el stock para solamente importar la cantidad que falta
        $this->cantidad_aprobada = $cantidadAprobada - $stockDisponible;
                    
        // se crea un nuevo movimiento con el stock disponible
        $newItemNecesidad = new ItemNecesidadRepuestos();
        $newItemNecesidad->cantidad_solicitada = $stockDisponible;
        $newItemNecesidad->cantidad_aprobada = $stockDisponible;
        $newItemNecesidad->id_repuesto = $this->repuesto->id_repuesto;
        $newItemNecesidad->margen = $this->repuesto->margen;
        $newItemNecesidad->id_necesidad_repuestos = $this->id_necesidad_repuestos;
        $newItemNecesidad->entregado = 0;
        $newItemNecesidad->fecha_registro = Carbon::now();
        $newItemNecesidad->save();

        // se reserva todo el stock disponible sin entregarlo todavia
        $response = MovimientoRepuesto::generarEgresoVirtual($this->id_repuesto, $this->getIdLocal(), $stockDisponible,  "App\Modelos\ItemNecesidadRepuestos", $newItemNecesidad->id_item_necesidad_repuestos);
        if($response){
            $newItemNecesidad->id_movimiento_salida_virtual = $response;
            $newItemNecesidad->save();
        }
    }

    public function generarMovimientosPaseAOT(){
        //Cambiar nombre de función a ActualizarPostPaseAOT
        if(!is_null($this->id_repuesto)){
            $stockDisponible = $this->repuesto->getStockVirtual($this->getIdLocal());
            $cantidadAprobada = $this->getCantidadAprobada();
            if($stockDisponible >= $cantidadAprobada){
                //Se setea en null el campo de es_importado ya que 
                $this->es_importado = null;
                $response = MovimientoRepuesto::generarEgresoVirtual($this->id_repuesto, $this->getIdLocal(), $this->cantidad_aprobada, "App\Modelos\ItemNecesidadRepuestos", $this->id_item_necesidad_repuestos);
                if($response){
                    $this->id_movimiento_salida_virtual = $response;
                    $this->save();
                }
            }else{
                if($stockDisponible > 0){
                    $this->egresoVirtualStockDisponible($cantidadAprobada, $stockDisponible);
                }
                
            }
        }
        $this->save();
    }

    public function realizarEntrega($fechaEntregaRepuesto, $recepcionOT){
        //$fechaEntregaRepuesto = Carbon::now()->format('d/m/Y');
        if($fechaEntregaRepuesto){
            $primeraEntrega = $this->entregado == 0;
            $this->entregado = 1;
            $this->fecha_entrega = Carbon::createFromFormat('d/m/Y', $fechaEntregaRepuesto);
            $this->fecha_registro_entrega = Carbon::now();
            $this->save();

            // registro del movimiento fisico (aqui POR AHORA)
            if($primeraEntrega){
                //registro del movimiento virtual en caso se trate de una importacion
                if(in_array($this->es_importado, [0,1], true)){
                    $response = MovimientoRepuesto::generarEgresoVirtual($this->id_repuesto, $this->getIdLocal(), $this->getCantidadAprobada(), "App\Modelos\ItemNecesidadRepuestos", $this->id_item_necesidad_repuestos);
                    if($response){
                        $this->id_movimiento_salida_virtual = $response;
                        $this->save();
                    }
                }
                $response = MovimientoRepuesto::generarEgresoFisico($this->id_repuesto, $this->getIdLocal(), $this->getCantidadAprobada(), "App\Modelos\ItemNecesidadRepuestos", $this->id_item_necesidad_repuestos);
                if($response){
                    $this->id_movimiento_salida = $response;
                    $this->save();
                }
            }

            //EL REPUESTO SI O SI ES IMPORTADO (YA NO CUMPLE ESTO) NOTA 27/10/2020: REVISAR
            // Nota 07/11/2020 => Esto se debe a que posiblemente solo se podrían entregar repuestos en importacion
            if($this->es_importado){
                //se verifica si todos los repuestos dejaron de ser importados para que deje de ser hotline.
                //Si todos tienen su estado como entregado. Si ninguno tiene entregado en 0
                $necesidadesRptos = $recepcionOT->necesidadesRepuestos()->get()->all();
                $countImportados = 0;
                foreach ($necesidadesRptos as $key => $necesidadRepuestos) {
                    $countImportados += $necesidadRepuestos->itemsNecesidadRepuestos()->where('es_importado',1)->where('entregado',0)->count();
                }
                if($countImportados == 0){
                    $recepcionOT->revertirHotline();
                }
            }
        }
        else{
            $this->entregado = 0;
            $this->save();
        }
    }

    public function movimientoRepuesto(){
        return $this->morphOne(MovimientoRepuesto::class,'fuente'); 
    }

    public function fuente(){
        return 'OT';
    }

    public function idFuente(){
        if( $this->idRecepcionOT() == null){
            return 'Anulada por NC/ND';
        }
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

    public function daysWithoutMovement(){
        $ultimoMovimiento = MovimientoRepuesto::where('id_repuesto', $this->id_repuesto)->where('tipo_movimiento','!=','EGRESO VIRTUAL')->orderBy('fecha_movimiento', 'desc')->first();
        $date = Carbon::now()->format('Y-m-d H:i:s');
        $date= new DateTime($date);
        
        $diasSinMovimiento = $ultimoMovimiento!= null ?$date->diff(new DateTime($ultimoMovimiento->fecha_movimiento))->days: '-';
        return $diasSinMovimiento;
    }

    
}
