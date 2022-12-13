<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\CiaSeguro;
use App\Modelos\MarcaAuto;
use App\Modelos\TipoDanhoTemp;
use DB;

class TipoDanhoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaSeguros = CiaSeguro::all();
        $listaAutos = MarcaAuto::all();

        $horas_min = DB::table('tipo_danho_horas_min')->get();
        $valor_tipo_danho = DB::table('tipo_danho_costos')->get();

        $horas_min_fin[] = $horas_min->where('tipo_danho','leve')->first();
        $horas_min_fin[] = $horas_min->where('tipo_danho','medio')->first();
        $horas_min_fin[] = $horas_min->where('tipo_danho','fuerte')->first();

        return view('tipoDanho',['listaSeguros' => $listaSeguros,
                                 'listaAutos'   => $listaAutos,
                                 'horasMin' => $horas_min_fin,
                                 'valoresTipoDanho'=> $valor_tipo_danho,
                                 'refreshable' => false]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $listaSeguros = CiaSeguro::all();
        $listaAutos = MarcaAuto::all();

        /*Express siempre empieza con 0 */
        $express_mo=0;
        $express_panhos=0;

        $leve_mo=$request->input("min-mo-leve");
        $leve_panhos=$request->input("min-panho-leve");

        $medio_mo=$request->input("min-mo-medio");
        $medio_panhos=$request->input("min-panho-medio");

        $fuerte_mo=$request->input("min-mo-fuerte");
        $fuerte_panhos=$request->input("min-panho-fuerte");

        DB::table('tipo_danho_horas_min')->truncate();
        DB::table('tipo_danho_horas_min')->insert([
            ['tipo_danho'=>'express','horas_min_mo'=>$express_mo,'horas_min_panhos'=>$express_panhos],
            ['tipo_danho'=>'leve','horas_min_mo'=>$leve_mo,'horas_min_panhos'=>$leve_panhos],
            ['tipo_danho'=>'medio','horas_min_mo'=>$medio_mo,'horas_min_panhos'=>$medio_panhos],
            ['tipo_danho'=>'fuerte','horas_min_mo'=>$fuerte_mo,'horas_min_panhos'=>$fuerte_panhos]
        ]);

        foreach ($listaSeguros as $key => $ciaSeguro) {
            foreach ($listaAutos as $key => $marcaAuto) {
                $idSeguro = $ciaSeguro->id_cia_seguro;
                $idMarca = $marcaAuto->getIdMarcaAuto();

                $hhCar = $request->input("hhCar-$idSeguro-$idMarca");
                $panhos = $request->input("panhos-$idSeguro-$idMarca");

                $tipoDanhoCosto = [ 'id_cia_seguro'=>$idSeguro,
                                    'id_marca_auto'=>$idMarca,
                                    'costo_hh_car'=>$hhCar,
                                    'costo_panho'=>$panhos];

                $arregloInsertTipoDanhoCosto[]= $tipoDanhoCosto;

                $limite_inf_leve = $leve_mo * $hhCar + $leve_panhos * $panhos;
                $limite_inf_medio = $medio_mo * $hhCar + $medio_panhos * $panhos;
                $limite_inf_fuerte = $fuerte_mo * $hhCar + $fuerte_panhos * $panhos;

                $tipoDanhoRecord = TipoDanhoTemp::firstOrNew(   ['id_cia_seguro'=>$idSeguro,'id_marca_auto'=>$idMarca],
                                                                ['limite_inf_leve'=>$limite_inf_leve,'limite_inf_medio'=>$limite_inf_medio,'limite_inf_fuerte'=>$limite_inf_fuerte]);
                $tipoDanhoRecord->limite_inf_leve = $limite_inf_leve;
                $tipoDanhoRecord->limite_inf_medio = $limite_inf_medio;
                $tipoDanhoRecord->limite_inf_fuerte = $limite_inf_fuerte;
                $arregloTiposDanho[] = $tipoDanhoRecord;
            }
        }

        DB::table('tipo_danho_costos')->truncate();
        DB::table('tipo_danho_costos')->insert($arregloInsertTipoDanhoCosto);

        foreach($arregloTiposDanho as $tipoDanho){
            $tipoDanho->save();
        }

        return redirect()->route('recepcion.index')->with('success','');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
