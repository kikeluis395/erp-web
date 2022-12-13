<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class MovimientoRepuesto extends Model
{
    protected $table="movimiento_repuesto";
    protected $fillable=['id_repuesto', 'tipo_movimiento', 'cantidad_movimiento', 'fecha_movimiento', 'id_local_empresa','saldo','fuente_type','fuente_id','costo', 'costo_promedio_ingreso','saldo_dolares'];
    protected $primaryKey='id_movimiento_repuesto';

    public $timestamps = false;

    public function repuesto()
    {
    	return $this->belongsTo('App\Modelos\Repuesto','id_repuesto');
    }
    public function x(){
        return $this->fecha_movimiento;
    }

    public function localEmpresa()
    {
    	return $this->belongsTo('App\Modelos\LocalEmpresa','id_local_empresa','id_local');
    }

    public static function getMovimientosBaseQuery()
    {
        $movimientosBaseQuery = DB::table('movimiento_repuesto as mr')
        ->join('repuesto as r', 'mr.id_repuesto', 'r.id_repuesto')
        ->join('local_empresa as le', 'le.id_local', 'mr.id_local_empresa')
        // ->groupBy('r.codigo_repuesto', 'r.descripcion', 'r.ubicacion','le.id_local', 'le.nombre_local')
        ->select('r.codigo_repuesto', 
                'r.ubicacion',
                'r.descripcion' ,
                'le.id_local',
                'le.nombre_local', 
                'mr.fecha_movimiento', 
                DB::raw("CASE WHEN tipo_movimiento='INGRESO' THEN cantidad_movimiento ELSE NULL END as entrada"),
                DB::raw("CASE WHEN tipo_movimiento='EGRESO' THEN cantidad_movimiento ELSE NULL END as salida"),
                DB::raw("(SELECT SUM(CASE WHEN tipo_movimiento='INGRESO' THEN cantidad_movimiento 
                                          WHEN tipo_movimiento='EGRESO' THEN -cantidad_movimiento
                                          ELSE 0 END)
                         FROM movimiento_repuesto
                         WHERE fecha_movimiento <= mr.fecha_movimiento and id_repuesto = mr.id_repuesto and id_local_empresa = mr.id_local_empresa) as saldo"),
                DB::raw("(SELECT SUM(CASE WHEN tipo_movimiento='INGRESO' THEN cantidad_movimiento 
                                        WHEN tipo_movimiento='EGRESO VIRTUAL' THEN -cantidad_movimiento
                                        ELSE 0 END)
                        FROM movimiento_repuesto
                        WHERE fecha_movimiento <= mr.fecha_movimiento and id_repuesto = mr.id_repuesto and id_local_empresa = mr.id_local_empresa) as saldo_virtual")
                        );
        return $movimientosBaseQuery;
    }

    public static function getUltimosMovimientosBaseQuery()
    {
        $ultMovimientosQuery = DB::table('movimiento_repuesto as mr')->select('id_repuesto','id_local_empresa',DB::raw("max(fecha_movimiento) as ultima_fecha"))->groupBy(['id_repuesto','id_local_empresa']);
        $query = self::getMovimientosBaseQuery()
                        ->joinSub($ultMovimientosQuery,'ultimos_movimientos', function ($join){
                            $join->on('ultimos_movimientos.ultima_fecha','mr.fecha_movimiento')
                                 ->on('ultimos_movimientos.id_repuesto', 'mr.id_repuesto')
                                 ->on('ultimos_movimientos.id_local_empresa','mr.id_local_empresa');
                        })
                        ->orderBy('fecha_movimiento','asc'); //teoria: mientras mas antiguos tengan sus movimientos, mas probable de que te acepten el repuesto
        return $query;
    }

    private static function generarMovimiento($idRepuesto, $idLocal, $cantidad, $tipoMovimiento,  $tipo_fuente, $fuente_id)
    {
        $miSaldoFisico = self::miSaldoFisico($idRepuesto);
        $miSaldoDolares = self::miSaldoDolares($idRepuesto);
        $puedeGenerar = false;
        $val = self::getCosto($idRepuesto);

        if(in_array($tipoMovimiento, ['EGRESO', 'EGRESO VIRTUAL'])){
            $ultimosSaldos = self::getUltimosMovimientosBaseQuery()->where('mr.id_repuesto', $idRepuesto)->where('mr.id_local_empresa', $idLocal)->first();
            
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
        
        //dd($val);
        // return $val;
        if($puedeGenerar){
            try{
                
                $movimiento = MovimientoRepuesto::create([
                    'id_repuesto' => $idRepuesto,
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
            return $movimiento->id_movimiento_repuesto;
            }
             catch(\Exception $e){
               return $e;
             }
           
            
            
        }
        else{
            return false;
        }
    }

    public static function generarEgresoVirtual($idRepuesto, $idLocal, $cantidad, $tipo_fuente, $fuente_id)
    {
        return self::generarMovimiento($idRepuesto, $idLocal, $cantidad,'EGRESO VIRTUAL', $tipo_fuente, $fuente_id);
    }

    public static function generarEgresoFisico($idRepuesto, $idLocal, $cantidad, $tipo_fuente, $fuente_id)
    {
       
        return self::generarMovimiento($idRepuesto, $idLocal, $cantidad,'EGRESO', $tipo_fuente, $fuente_id);
    }

    private static function getCosto($id_repuesto){
        //return 88;
        
        $listLastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->orderBy('fecha_movimiento','desc')->where('tipo_movimiento',"!=",'EGRESO VIRTUAL')->get();
        
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

    
    private static function miSaldoFisico($id_repuesto){
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->where('tipo_movimiento',"!=",'EGRESO VIRTUAL')->orderBy('fecha_movimiento','desc')->first();
        if($lastMovimiento == null){
            return 0;
        }
        return $lastMovimiento->saldo;
    }

    private static function miSaldoDolares($id_repuesto){
        $lastMovimiento = MovimientoRepuesto::where('id_repuesto', $id_repuesto)->where('tipo_movimiento',"!=",'EGRESO VIRTUAL')->orderBy('fecha_movimiento','desc')->first();
        if($lastMovimiento == null){
            return 0;
        }
        return $lastMovimiento->saldo_dolares;
    }


    public function fuente(){
        return $this->morphTo();
    }
}
