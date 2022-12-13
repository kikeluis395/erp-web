<?php

namespace App\Http\Controllers\Ventas;

use App\Modelos\ElementoInspeccion;
use App\Modelos\Ventas\GrupoElementoInspeccion;
use App\Modelos\Usuario;
use App\Modelos\Ventas\HojaInspeccion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class HojaInspeccionController
{
    public function listView(Request $request)
    {
        $listaElementosInspeccion = HojaInspeccion::getAll(function ($query) use ($request){
            if($request->nroCOT !== null){
                $query->where(HojaInspeccion::getTableName().'.id_recepcion_ot', $request->nroCOT);
            }
            if($request->nroNV !== null){
                $query->where(HojaInspeccion::getTableName().'.color', $request->nroNV);
            }
            if($request->nroNV !== null){
                $query->where(HojaInspeccion::getTableName().'.color', $request->nroNV);
            }
            if($request->modelo !== null){
                $query->where(HojaInspeccion::getTableName().'.modelo', $request->modelo);
            }
            if($request->fechaInicioSolicitud !== null){
                $fecha = Carbon::createFromFormat('!d/m/Y',$request->fechaInicioSolicitud);
                $query->where(HojaInspeccion::getTableName().'.fecha_registro', '>=',$fecha->format("Y-m-d"));
            }
            if($request->fechaFinSolicitud !== null){
                $fecha = Carbon::createFromFormat('!d/m/Y',$request->fechaFinSolicitud);
                $query->where(HojaInspeccion::getTableName().'.fecha_registro', '<=',$fecha->format("Y-m-d"));
            }
        });
        return view('ventas.hojasInspeccion.listado', ['listHojasInspeccion' => $listaElementosInspeccion,
            'refreshable' => false]);
    }

    public function createView()
    {
        $elementosGroupedByGroup = ElementoInspeccion::join('grupo_elemento_inspeccion','id', '=', 'elemento_inspeccion.grupo_elemento_id')
                ->get()->groupBy('grupo_elemento_id');

        $gruposElemento = GrupoElementoInspeccion::get()->groupBy('id');

        $usuarioSavar = Auth::user();
        
        return view('ventas.hojasInspeccion.crear', [
            'elementosGroupedByGroup' => $elementosGroupedByGroup,
            'gruposElemento' => $gruposElemento,
            'usuarioSavar' => $usuarioSavar
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'id_recepcion_ot' => ['nullable', 'exists:hoja_trabajo,id_hoja_trabajo'],
            'modelo' => ['required'],
            'ano_modelo' => ['required', 'date_format:Y' ,'before_or_equal:'.Carbon::now()->format('Y')],
            'vin' => ['required'],
            'color' => ['required'],
        ], [
            'id_recepcion_ot.exists' => 'OT no es valida',
            'modelo.required' => 'modelo el requerido',
            'ano_modelo.required' => 'año de modelo el requerido',
            'ano_modelo.date_format' => 'año de modelo no es valido',
            'ano_modelo.before_or_equal' => 'año de modelo deve ser menor o igual al año actual',
            'vin.required' => 'vin es requerido',
            'color.required' => 'color es requerido',
        ]);

        if($validator->passes()){
            $usuario_savar_id = Auth::user()->id_usuario;
            $hojaInspeccion = HojaInspeccion::create(
                $usuario_savar_id,
                $request->modelo,
                $request->color,
                $request->ano_modelo,
                $request->vin,
                $request->destino
            );
            if(is_array($request->elementosInspeccion)){
                foreach($request->elementosInspeccion as $elemento_id => $elemento){
                    $hojaInspeccion->addElemento(
                        $elemento_id,
                        isset($elemento['savar']),
                        isset($elemento['dealer'])
                    );
                }
            }
            $elementos = ElementoInspeccion::get();
            foreach($elementos as $elemento){
                $notExists = !$hojaInspeccion->elementoIsAlreadyAdded($elemento->id_elemento_inspeccion);
                if($notExists){
                    $hojaInspeccion->addElemento($elemento->id_elemento_inspeccion);
                }
            }
            
            $hojaInspeccion->createAll();
    
            session([
                'message' => "message test"
            ]);
            
            return response()->json(['passes' => true, 'errors' => []]);
        }
        return response()->json(['passes' => false, 'errors' => $validator->errors()]);
    }

    public function editView($id) {
        $hojaInspeccion = HojaInspeccion::find($id);
        $hojaInspeccion->loadAll();

        $gruposElemento = GrupoElementoInspeccion::get()->groupBy('id');
        $usuarioSavar = Usuario::where('id_usuario', $hojaInspeccion->id_usuario_savar)->first();
        $usuarioDealer = Usuario::where('id_usuario', $hojaInspeccion->id_usuario_dealer)->first();

        return view('ventas.hojasInspeccion.editar', [
            'hojaInspeccion' => $hojaInspeccion,
            'gruposElemento' => $gruposElemento,
            'usuarioSavar' => $usuarioSavar,
            'usuarioDealer' => $usuarioDealer
        ]);
        return response()->json($hojaInspeccion);
    }

    public function changeStateToDealer($id){
        $inspeccion = HojaInspeccion::findOrFail($id);
        $inspeccion->changeStateToDealer();
        $inspeccion->save();
        return redirect()->route('hojaInspeccion.listView');
    }

    public function changeStateToCompletado($id){
        $inspeccion = HojaInspeccion::findOrFail($id);
        $inspeccion->changeStateToCompletado();
        $inspeccion->save();
        return redirect()->route('hojaInspeccion.listView');
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_hoja_inspeccion' => ['required', "exists:".HojaInspeccion::getTableName().",".HojaInspeccion::getIdName()],
            'id_recepcion_ot' => ['nullable', 'exists:hoja_trabajo,id_hoja_trabajo'],
            'modelo' => ['required'],
            'ano_modelo' => ['required', 'date_format:Y' ,'before_or_equal:'.Carbon::now()->format('Y')],
            'vin' => ['required'],
            'color' => ['required'],
        ], [
            'id_recepcion_ot.exists' => 'OT no es valida',
            'modelo.required' => 'modelo el requerido',
            'ano_modelo.required' => 'año de modelo el requerido',
            'ano_modelo.date_format' => 'año de modelo no es valido',
            'ano_modelo.before_or_equal' => 'año de modelo deve ser menor o igual al año actual',
            'vin.required' => 'vin es requerido',
            'color.required' => 'color es requerido',
        ]);

        $hojaInspeccion = HojaInspeccion::find($request->id_hoja_inspeccion);
        if($validator->passes())
        {
            $usuario_id = Auth::user()->id_usuario;
            $hojaInspeccion->loadAllIndex();
            $hojaInspeccion->updateData(
                $request->id_recepcion_ot,
                $request->modelo,
                $request->color,
                $request->ano_modelo,
                $request->vin,
                $request->destino,
                $usuario_id,
                $usuario_id
            );

            $elementos = ElementoInspeccion::get();
            foreach($elementos as $elemento){
                $hojaInspeccion->updateElemento($elemento->id_elemento_inspeccion, false, false);
            }

            if(is_array($request->elementosInspeccion))
            {
                foreach($request->elementosInspeccion as $elemento_id => $elemento) {
                    $hojaInspeccion->updateElemento(
                        $elemento_id,
                        isset($elemento['savar']),
                        isset($elemento['dealer'])
                    );
                }
            }
            $hojaInspeccion->updateAll();

            return response()->json([
                'passes' => true,
                'errors' => []
            ]);
        }
        if($validator->errors()->has('id')){
            return response()->json([], 404);
        }
        return response()->json([
            'passes' => false,
            'errors' => $validator->errors(),
            'hojaInspeccion' => $hojaInspeccion
        ]);
    }
}
