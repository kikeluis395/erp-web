<?php
namespace App\Modelos\Internos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

abstract class GrupoTransaccionMonetaria extends Model
{
    //Funciones abstractas que se definen en cada hijo
    //
    //Obtiene la moneda del grupo (SOLES o DOLARES)
    abstract public function getMoneda();

    //Obtiene el tipo de cambio (SOLES/DOLARES)
    abstract public function getTipoCambio();

    //Obtiene las lineasTransaccion del grupo
    abstract public function getLineasTransaccion();
    
    //Funciones propias de la clase gracias a las definiciones abstractas
    //
    //Funcion para obtener el monto total, considerando o no descuento, el cual sera precio o valor dependiendo si se considara IGV
    public function getMontoTotal($considerarIGV,$considerarDescuento){
        $monto = 0;
        $lineasTransaccion = $this->getLineasTransaccion();
        foreach($lineasTransaccion as $key => $lineaTransaccion){
            #if ($considerarDescuento) $monto += $lineaTransaccion->getMontoVentaTotal($lineaTransaccion->getFechaRegistroCarbon(),$considerarIGV, $lineaTransaccion->descuento_marca, true, $lineaTransaccion->descuento_unitario ?? -1);
            if ($considerarDescuento) $monto += $lineaTransaccion->getVentaConDscto();
            else $monto += $lineaTransaccion->getMontoTotal($lineaTransaccion->getFechaRegistroCarbon(),$considerarIGV);
        }
        return $monto;
    }

    public function getCostoUnitarioTotal($moneda, $tipo_cambio) {#sin IGV
        $costoTotal = 0;
        $lineasTransaccion = $this->getLineasTransaccion();
        foreach ($lineasTransaccion as $lineaTransaccion) {
            $costoTotal += $lineaTransaccion->movimientoSalida->cantidad_movimiento * $lineaTransaccion->movimientoSalida->costo;
        }

        return $moneda == 'SOLES' ? $tipo_cambio * $costoTotal : $costoTotal;
    }

    //Funcion para obtener el descuento total
    public function getDescuentoTotal($considerarIGV){
        $descuento = 0;
        $lineasTransaccion = $this->getLineasTransaccion();
        foreach($lineasTransaccion as $key => $lineaTransaccion){
            $descuento += $lineaTransaccion->getDescuentoTotal($lineaTransaccion->getFechaRegistroCarbon(),$considerarIGV);
        }
        return $descuento;
    }    

    //Funcion para obtener el IGV ttotal
    public function getIGVTotal(){
        $igv = 0;
        $lineasTransaccion = $this->getLineasTransaccion();
        foreach($lineasTransaccion as $key => $lineaTransaccion){
            $igv += $lineaTransaccion->getIGVTotal($lineaTransaccion->getFechaRegistroCarbon());
        }
        return $igv;
    }
}