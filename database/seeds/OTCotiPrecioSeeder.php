<?php

use App\Modelos\Cotizacion;
use App\Modelos\DetalleTrabajo;
use App\Modelos\RecepcionOT;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OTCotiPrecioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $mec = DB::table('precio_mo_mec')
            ->where('tipo', 'MO')
            ->orderBy('fecha_registro', 'asc')
            ->first()->id_precio_mo_mec;

        $detalles = DetalleTrabajo::all();
        foreach ($detalles as $detalle) {
            $hojaTrabajo = $detalle->hojaTrabajo;
            $tipo_trabajo = $hojaTrabajo->tipo_trabajo;

            if ($tipo_trabajo === "DYP") {
                $idSeguro = ($hojaTrabajo->id_recepcion_ot ? $hojaTrabajo->recepcionOT->id_cia_seguro : $hojaTrabajo->cotizacion->id_cia_seguro);
                $idMarca = $hojaTrabajo->vehiculo->id_marca_auto;

                if (in_array($detalle->operacionTrabajo->tipo_trabajo, ["PANHOS PINTURA", "GLOBAL-PANHOS"])) {
                    $tipoTrabajo = 'PANHOS';
                } else {
                    $tipoTrabajo = 'HH';
                }
                $dyp = DB::table('precio_mo_dyp')
                    ->where('id_marca_auto', $idMarca)
                    ->where('id_cia_seguro', $idSeguro)
                    ->where('tipo', $tipoTrabajo)
                    ->orderBy('fecha_registro', 'asc')
                    ->first()->id_precio_mo_dyp;

                $detalle->id_precio_mo_dyp = $dyp;
                $detalle->save();
            } else {
                $detalle->id_precio_mo_mec = $mec;
                $detalle->save();
            }
        }

        $ots = RecepcionOT::all();
        foreach ($ots as $ot) {
            $hojaTrabajo = $ot->hojaTrabajo;
            
            if ($hojaTrabajo) {
                $tipo_trabajo = $hojaTrabajo->tipo_trabajo;

                if ($tipo_trabajo === "DYP") {
                    $idSeguro = ($hojaTrabajo->id_recepcion_ot ? $hojaTrabajo->recepcionOT->id_cia_seguro : $hojaTrabajo->cotizacion->id_cia_seguro);
                    $idMarca = $hojaTrabajo->vehiculo->id_marca_auto;
                   
                    $panhos = DB::table('precio_mo_dyp')
                        ->where('id_marca_auto', $idMarca)
                        ->where('id_cia_seguro', $idSeguro)
                        ->where('tipo', 'PANHOS')
                        ->orderBy('fecha_registro', 'asc')
                        ->first()->id_precio_mo_dyp;

                    $hh = DB::table('precio_mo_dyp')
                        ->where('id_marca_auto', $idMarca)
                        ->where('id_cia_seguro', $idSeguro)
                        ->where('tipo', 'HH')
                        ->orderBy('fecha_registro', 'asc')
                        ->first()->id_precio_mo_dyp;

                    $ot->precio_dyp = json_encode(["PANHOS" => $panhos, "HH" => $hh]);
                    $ot->save();
                } else {
                    $ot->precio_mec = $mec;
                    $ot->save();
                }
            }
        }
        
        $cotis = Cotizacion::all();
        foreach ($cotis as $coti) {
            $hojaTrabajo = $coti->hojaTrabajo;
            
            if ($hojaTrabajo) {
                $tipo_trabajo = $hojaTrabajo->tipo_trabajo;

                if ($tipo_trabajo === "DYP") {
                    $idSeguro = ($hojaTrabajo->id_recepcion_ot ? $hojaTrabajo->recepcionOT->id_cia_seguro : $hojaTrabajo->cotizacion->id_cia_seguro);
                    $idMarca = $hojaTrabajo->vehiculo->id_marca_auto;
                   
                    $panhos = DB::table('precio_mo_dyp')
                        ->where('id_marca_auto', $idMarca)
                        ->where('id_cia_seguro', $idSeguro)
                        ->where('tipo', 'PANHOS')
                        ->orderBy('fecha_registro', 'asc')
                        ->first()->id_precio_mo_dyp;

                    $hh = DB::table('precio_mo_dyp')
                        ->where('id_marca_auto', $idMarca)
                        ->where('id_cia_seguro', $idSeguro)
                        ->where('tipo', 'HH')
                        ->orderBy('fecha_registro', 'asc')
                        ->first()->id_precio_mo_dyp;

                    $coti->precio_dyp = json_encode(["PANHOS" => $panhos, "HH" => $hh]);
                    $coti->save();
                } else {
                    $coti->precio_mec = $mec;
                    $coti->save();
                }
            }
        }
    }
}
