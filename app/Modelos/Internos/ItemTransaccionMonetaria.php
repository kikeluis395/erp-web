<?php
namespace App\Modelos\Internos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

abstract class ItemTransaccionMonetaria extends Model
{
    //Funciones abstractas que se definen en cada hijo
    //
    //Obtiene el objeto precio relacionado al itemTransaccion
    abstract public function getPrecio(Carbon $fechaConsulta);
    //Funcion en caso no tenga un precio establecido en la fecha consultada
    abstract public function getPrecioAuxiliar();
    //Funcion en caso no tenga un precio establecido en la fecha consultada se usara esta moneda para el cambio
    abstract public function getMonedaAuxiliar();
    //Funciones propias de la clase gracias a las definiciones abstractas
    //Las fechas consultas sirven para determinar el precio aplicado para esa fecha
    //
    //Pendiente optimizacion: Las 3 funciones de abajo poner en estilo de los otros objetos transaccion con incluye igv una funcion
    //
    //Funcion interna para procesar el monto si es precio se considera igv y si es valor no se considera igv
    private function procesarMonto($fechaConsulta,$considerarIGV){
        $tasaIGV=config('app.tasa_igv');
        $precio=$this->getPrecio($fechaConsulta);
        $monto=$precio ? $precio->getMonto() : $this->getPrecioAuxiliar();
        $incluyeIGV = $precio ? $precio->getIncluyeIGV() : true;
        if($considerarIGV){
            $monto = $incluyeIGV? $monto : $monto*(1+$tasaIGV);
        }
        else $monto = $incluyeIGV? $monto/(1+$tasaIGV) : $monto;
        return $monto;
    }

    //Funcion para obtener el precio unitario del itemTransaccion
    public function getPrecioUnitario(Carbon $fechaConsulta){
        $precio= $this->procesarMonto($fechaConsulta,true);
        return $precio;
    }
    
    //Funcion para obtener el valor unitario del itemTransaccion
    public function getValorUnitario(Carbon $fechaConsulta){
        
        $valor= $this->procesarMonto($fechaConsulta,false);
        return $valor;
    }

    //Funcion para obtener el igv del itemTransaccion
    public function obtenerIGV(Carbon $fechaConsulta){
        $tasaIGV=config('app.tasa_igv');
        $precio=$this->getPrecio($fechaConsulta);
        $monto=$precio ? $precio->getMonto() : $this->getPrecioAuxiliar();
        $incluyeIGV = $precio ? $precio->getIncluyeIGV() : true;
        $igv = $incluyeIGV? $monto - $monto/(1+$tasaIGV) : $monto*$tasaIGV;
        return $igv;
    }   
}