<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class MovimientoVehiculoNuevo extends Model
{
    protected $table="movimiento_vehiculo_nuevo";
    protected $fillable=['id_vehiculo_nuevo', 'tipo_movimiento', 'cantidad_movimiento', 'fecha_movimiento', 'id_local_empresa','saldo','fuente_type','fuente_id','costo', 'costo_promedio_ingreso','saldo_dolares'];
    protected $primaryKey='id_movimiento_vehiculo_nuevo';



    public function vehiculoNuevo()
    {
    	return $this->belongsTo('App\Modelos\VehiculoNuevo','id_vehiculo_nuevo');
    }

    public function localEmpresa()
    {
    	return $this->belongsTo('App\Modelos\LocalEmpresa','id_local_empresa','id_local');
    }

    private static function generarMovimiento($idVehiculoNuevo, $idLocal, $cantidad, $tipoMovimiento,  $tipo_fuente, $fuente_id)
    {
        $miSaldoFisico = self::miSaldoFisico($idVehiculoNuevo);
        $miSaldoDolares = self::miSaldoDolares($idVehiculoNuevo);
        $puedeGenerar = false;
        $val = self::getCosto($idVehiculoNuevo);

        if(in_array($tipoMovimiento, ['EGRESO', 'EGRESO VIRTUAL'])){
            $ultimosSaldos = self::getUltimosMovimientosBaseQuery()->where('mr.id_vehiculo_nuevo', $idVehiculoNuevo)->where('mr.id_local_empresa', $idLocal)->first();
            
            $saldo = null;
            if($tipoMovimiento=='EGRESO'){
                $miSaldoFisico = $miSaldoFisico-$cantidad;
                $miSaldoDolares = $miSaldoDolares-($cantidad*$val);
                $saldo = $ultimosSaldos ? $ultimosSaldos->saldo : 0;
            }
            elseif($tipoMovimiento=='EGRESO VIRTUAL'){
                $saldo = $ultimosSaldos ? $ultimosSaldos->saldo_virtual : 0;
            }

            if($cantidad <= $saldo){
                $puedeGenerar = true;
            }
           
        }
        elseif($tipoMovimiento=='INGRESO'){
            $puedeGenerar = true;
            $miSaldoFisico += $cantidad;
            $miSaldoDolares = $miSaldoDolares+($cantidad*$val);
        }
        
        if($puedeGenerar){
            try{
                
                $movimiento = MovimientoVehiculoNuevo::create([
                    'id_vehiculo_nuevo' => $idVehiculoNuevo,
                    'id_local_empresa' => $idLocal,
                    'cantidad_movimiento' => $cantidad,
                    'tipo_movimiento' => $tipoMovimiento,
                    'fecha_movimiento' => Carbon::now(),
                    'saldo' => $tipoMovimiento!="EGRESO VIRTUAL"? $miSaldoFisico:0,
                    'saldo_dolares' => $tipoMovimiento!="EGRESO VIRTUAL"? $miSaldoDolares:0,
                    'fuente_type' => $tipo_fuente,
                    'fuente_id' => $fuente_id,
                    'costo' => $val,
                    
                ]);
            return $movimiento->id_movimiento_vehiculo_nuevo;
            }
             catch(\Exception $e){
               return $e;
             }
           
            
            
        }
        else{
            return false;
        }
    }

    public static function generarEgresoVirtual($idVehiculoNuevo, $idLocal, $cantidad, $tipo_fuente, $fuente_id)
    {
        return self::generarMovimiento($idVehiculoNuevo, $idLocal, $cantidad,'EGRESO VIRTUAL', $tipo_fuente, $fuente_id);
    }

    public static function generarEgresoFisico($idVehiculoNuevo, $idLocal, $cantidad, $tipo_fuente, $fuente_id)
    {
       
        return self::generarMovimiento($idVehiculoNuevo, $idLocal, $cantidad,'EGRESO', $tipo_fuente, $fuente_id);
    }

    private static function getCosto($id_vehiculo_nuevo){
        //return 88;
        
        $listLastMovimiento = MovimientoVehiculoNuevo::where('id_vehiculo_nuevo', $id_vehiculo_nuevo)->orderBy('fecha_movimiento','desc')->where('tipo_movimiento',"!=",'EGRESO VIRTUAL')->get();
        
        $count = count($listLastMovimiento);
        if($count==0){
            return 0;
        }
        
        $lastMovimiento = $listLastMovimiento[0];
        if($lastMovimiento->tipo_movimiento =="EGRESO"){
            return $lastMovimiento->costo;
        }
        //ESTO SE EJECUTA CUANDO EL ULTIMO ES UN INGRESO
        else{
            //sI EL PENULTIMO ES UN EGRESO
            if($count>=2){
                $penultimo = $listLastMovimiento[1];
                if($penultimo->tipo_movimiento== "INGRESO"){
                    $costo = (($penultimo->saldo * $penultimo->costo_promedio_ingreso)+($lastMovimiento->cantidad_movimiento *$lastMovimiento->costo))/($lastMovimiento->saldo ?? 1);
                } else{
                $costo = (($penultimo->saldo * $penultimo->costo)+($lastMovimiento->cantidad_movimiento *$lastMovimiento->costo))/($lastMovimiento->saldo ?? 1);

                }          
                return round($costo,4);
            }else{
                return round($lastMovimiento->costo,4);
            }
           
        
        }
    }

    
    private static function miSaldoFisico($id_vehiculo_nuevo){
        $lastMovimiento = MovimientoVehiculoNuevo::where('id_vehiculo_nuevo', $id_vehiculo_nuevo)->where('tipo_movimiento',"!=",'EGRESO VIRTUAL')->orderBy('fecha_movimiento','desc')->first();
        if($lastMovimiento == null){
            return 0;
        }
        return $lastMovimiento->saldo;
    }

    private static function miSaldoDolares($id_vehiculo_nuevo){
        $lastMovimiento = MovimientoVehiculoNuevo::where('id_vehiculo_nuevo', $id_vehiculo_nuevo)->where('tipo_movimiento',"!=",'EGRESO VIRTUAL')->orderBy('fecha_movimiento','desc')->first();
        if($lastMovimiento == null){
            return 0;
        }
        return $lastMovimiento->saldo_dolares;
    }

    public function fuente(){
        return $this->morphTo();
    }
}
