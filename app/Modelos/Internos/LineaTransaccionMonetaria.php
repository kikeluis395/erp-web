<?php
namespace App\Modelos\Internos;

use App\Modelos\ItemNecesidadRepuestos;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

abstract class LineaTransaccionMonetaria extends Model
{
    //Funciones abstractas que se definen en cada hijo
    //
    //Obtiene la moneda de la linea (SOLES o DOLARES)
    abstract public function getMoneda();

    //Obtiene el itemTransaccion de la linea
    abstract public function getItemTransaccion();

    //Obtiene la cantidad de itemsTransacciones en la linea
    abstract public function getCantidad();

    //Obtiene la tasa de descuento de la linea
    abstract public function getTasaDescuento();

    //Obtiene el tipo de cambio (SOLES/DOLARES)
    abstract public function getTipoCambio();

    //Obtiene la fecha de registro de la linea en formato carbon, necesario en el grupoTransaccion
    abstract public function getFechaRegistroCarbon();
    
    //Funciones propias de la clase gracias a las definiciones abstractas
    //Las fechas consultas sirven para determinar el precio aplicado para esa fecha
    //
    //Funcion interna para cambiar la moneda del itemTransaccion a la de la moneda de la linea
    private function cambioMoneda(Carbon $fechaConsulta,$montoCambiar){
        $monedaObjetivo = $this->getMoneda();
        $precio = $this->getItemTransaccion() ? $this->getItemTransaccion()->getPrecio($fechaConsulta) : null;
        $monto=$montoCambiar;
        if(($precio && $precio->getMoneda()!=$monedaObjetivo) || ($this->getItemTransaccion() && $precio==null && $this->getItemTransaccion()->getMonedaAuxiliar()!=$monedaObjetivo)){
            $cambio=$this->getTipoCambio();
            $monto = $monedaObjetivo=="DOLARES" ? $monto/$cambio : $monto*$cambio;
        }
        return $monto;
    }

    //Funcion para obtener el monto unitario sin descuento el cual sera precio o valor dependiendo si se considara IGV
    public function getMontoUnitario(Carbon $fechaConsulta,$considerarIGV){
        if ($considerarIGV) 
            $monto = $this->getItemTransaccion() ? $this->getItemTransaccion()->getPrecioUnitario($fechaConsulta) : 0; 
        else 
            $monto = $this->getItemTransaccion() ? $this->getItemTransaccion()->getValorUnitario($fechaConsulta) : 0;
        $monto = $this->cambioMoneda($fechaConsulta,$monto);
        return $monto;
    }

    //Funcion para obtener el monto total sin descuento el cual sera precio o valor dependiendo si se considara IGV
    public function getMontoTotal(Carbon $fechaConsulta,$considerarIGV){
        $monto =$this->getMontoUnitario($fechaConsulta,$considerarIGV)*$this->getCantidad();
        return $monto;
    }

    //Funcion para obtener el IGV unitario
    public function getIGVUnitario(Carbon $fechaConsulta){
        $igv = $this->getItemTransaccion() ? $this->getItemTransaccion()->obtenerIGV($fechaConsulta) : 0;
        $igv = $this->cambioMoneda($fechaConsulta,$igv);
        return $igv;
    }

    //Funcion para obtener el IGV ttotal
    public function getIGVTotal(Carbon $fechaConsulta){
        return $this->getIGVUnitario($fechaConsulta)*$this->getCantidad();
    }

    //Funcion para obtener el descuento unitario
    public function getDescuentoUnitario(Carbon $fechaConsulta,$considerarIGV, $descuento_unitario_dealer = false){

        $descuento = $descuento_unitario_dealer >= 0 ? $descuento = $descuento_unitario_dealer / 100 : $this->getTasaDescuento();
        
        return $descuento*$this->getMontoUnitario($fechaConsulta,$considerarIGV);
    }

    
    public function getDescPorcentajeDealer($descuento_unitario_dealer = false){

        $descuento = $descuento_unitario_dealer >= 0 ? $descuento = $descuento_unitario_dealer / 100 : $this->getTasaDescuento();
        
        return $descuento;
    }

    //Funcion para obtener el descuento total
    public function getDescuentoTotal(Carbon $fechaConsulta,$considerarIGV, $descuento_unitario = false, $descuento_unitario_dealer = false){

        $descuento_adicional = 0;

        if($descuento_unitario && $descuento_unitario > 0) {
            $descuento_adicional = $this->getMontoVentaTotal($fechaConsulta, $considerarIGV, $descuento_unitario, true, $descuento_unitario_dealer);
        }

        return ($this->getCantidad()*$this->getDescuentoUnitario($fechaConsulta, $considerarIGV, $descuento_unitario_dealer)) + $descuento_adicional;
        
    }

    //Funcion para obtener el monto unitario de venta (monto considerando descuento) el cual sera precio o valor dependiendo si se considara IGV
    public function getMontoVentaUnitario(Carbon $fechaConsulta,$considerarIGV){
        return $this->getMontoUnitario($fechaConsulta,$considerarIGV)-$this->getDescuentoUnitario($fechaConsulta,$considerarIGV);
    }

    //Funcion para obtener el monto total de venta (monto considerando descuento) el cual sera precio o valor dependiendo si se considara IGV

    /* public function getMontoVentaTotal(Carbon $fechaConsulta, $considerarIGV, $id_item_necesidad_repuestos = false)
    {

        $descuento_adicional = 1;
        if ($id_item_necesidad_repuestos) {
            $descuento = ItemNecesidadRepuestos::findOrFail($id_item_necesidad_repuestos);
            $descuento = $descuento->descuento_unitario;
            if ($descuento) {
                $descuento_adicional = 1 - ($descuento / 100);
            }
        }
        return ($this->getMontoTotal($fechaConsulta, $considerarIGV) - $this->getDescuentoTotal($fechaConsulta, $considerarIGV)) * $descuento_adicional;
 */
    public function getMontoVentaTotal(Carbon $fechaConsulta, $considerarIGV, $descuento_unitario = false, $monto_descuento = false, $descuento_unitario_dealer = false)
    {

        $descuento_adicional = 1;
        if ($descuento_unitario && $descuento_unitario > 0) {
            if (!$monto_descuento) {
                $descuento_adicional = 1 - ($descuento_unitario / 100);
            } else if ($monto_descuento){
                $descuento_adicional = $descuento_unitario / 100;
            }
        }

        return ($this->getMontoTotal($fechaConsulta, $considerarIGV) - $this->getDescuentoTotal($fechaConsulta, $considerarIGV, false, $descuento_unitario_dealer)) * $descuento_adicional;
    
    }

    //Funcion para obtener el descuento por marca
    public function getDescuentoPorMarca(Carbon $fechaConsulta,$considerarIGV, $descuento_unitario = false){

        $descuento_adicional = 0;

        if($descuento_unitario && $descuento_unitario > 0) {
            $descuento_adicional = $descuento_unitario/100;
        }

        return $this->getMontoTotal($fechaConsulta, $considerarIGV) * $descuento_adicional;
        
    }

    //Funcion para obtener el monto con descuento por marca
    public function getMontoConDescPorMarca(Carbon $fechaConsulta,$considerarIGV, $descuento_unitario = false){

        $descuento_adicional = 1;

        if($descuento_unitario && $descuento_unitario > 0) {
            $descuento_adicional = 1 - $descuento_unitario/100;
        }

        return $this->getMontoTotal($fechaConsulta, $considerarIGV) * $descuento_adicional;
        
    }

    public function getMontoConDescMarcaDealer(Carbon $fechaConsulta,$considerarIGV, $descuento_unitario = false, $descuento_unitario_dealer = false) {

        $descuento_unitario = $descuento_unitario ? 1-($descuento_unitario/100) : 1;
        $descuento_unitario_dealer = $descuento_unitario_dealer >= 0 ? 1-($descuento_unitario_dealer/100) : 1;

        return $this->getMontoUnitario($fechaConsulta,$considerarIGV) * $descuento_unitario * $descuento_unitario_dealer;
    }

    public function getPorcentajeAproximado(Carbon $fechaConsulta,$considerarIGV, $descuento_unitario = false, $descuento_unitario_dealer = false) {

        $montoDesc = $this->getMontoConDescMarcaDealer($fechaConsulta,$considerarIGV, $descuento_unitario, $descuento_unitario_dealer);
        $montoUni = $this->getMontoUnitario($fechaConsulta,$considerarIGV) == 0 ? 1 : $this->getMontoUnitario($fechaConsulta,$considerarIGV);
        $porcentaje = (1 - ($montoDesc/$montoUni)) * 100;
        $porcentaje = number_format($porcentaje, 0);

        return "{$porcentaje}%";
    }

    public function getMargenDealer($descuento_unitario_dealer = false, $margen) {

        $margen_regular = ($margen ?? 25)/100;
        
        $margen_dealer = $this->getDescPorcentajeDealer($descuento_unitario_dealer);
        $margen_dealer = $margen_dealer == 1 ? 0 : $margen_dealer;
        $margen_final_dealer = 1 - ((1 - $margen_regular) / (1 - $margen_dealer));
        $margen_final_dealer = number_format($margen_final_dealer, 2) * 100;
        
        return "{$margen_final_dealer}%";

    }

}