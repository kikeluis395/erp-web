<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Administracion\PrecioPDI;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PreDeliveryInspectionMOController extends Controller
{
    public function index()
    {
        $precio = PrecioPDI::where('habilitado', 1)->get();
        $precio = $this->map_precios($precio);

        $data = [
            'precio' => $precio,
            'tipos' => $this->tipos(),
            // 'precio_exists' => $precio_exists,
            // 'costo_exists' => $costo_exists
        ];
        return view('administracion.manoObraPDI', $data);
    }

    public function store(Request $request)
    {
        $modify_precio = $request->modify_precio;
        $tipos = $this->tipos();

        if ($modify_precio === 'true') {
            foreach ($tipos as $tipo) {
                $valor_costo = $request->input("valor_costo_$tipo");
                $moneda = $request->input("moneda_$tipo");
                if ($valor_costo || $moneda) {
                    $precio = PrecioPDI::where('tipo', $tipo)->where('habilitado', 1)->first();
                    if ($precio) {
                        $precio->habilitado = 0;
                        $precio->fecha_edicion = Carbon::now();
                        $precio->editor = Auth::user()->id_usuario;
                        $precio->save();
                    }

                    $creador = Auth::user();
                    $id_local = $creador->empleado->id_local;
                    $habilitado = 1;

                    $nuevo_precio = new PrecioPDI();
                    $nuevo_precio->tipo = $tipo;
                    if ($valor_costo && $moneda) {
                        $nuevo_precio->valor_costo = $valor_costo;
                        $nuevo_precio->moneda = $moneda;
                    }
                    if ($valor_costo && !$moneda) {
                        $nuevo_precio->valor_costo = $valor_costo;
                        if ($precio) $nuevo_precio->moneda = $precio->moneda;
                        else $nuevo_precio->moneda = 'SOLES';
                    }
                    if (!$valor_costo && $moneda) {
                        if ($precio) $nuevo_precio->valor_costo = $precio->valor_costo;
                        else $nuevo_precio->valor_costo = 0;
                        $nuevo_precio->moneda = $moneda;
                    }
                    $nuevo_precio->creador = $creador->id_usuario;
                    $nuevo_precio->id_local = $id_local;
                    $nuevo_precio->habilitado = $habilitado;
                    $nuevo_precio->save();
                }

                // $es_precio = strpos($key, 'modify_precio_specific_') === 0;
                // if ($es_precio) {
                //     $unique = str_replace('modify_precio_specific_', '', $key);
                // }
            }
        }

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    private function tipos()
    {
        return ['MEC', 'CAR', 'PANHO', 'TYP'];
    }

    public function map_precios($precios)
    {
        $arr = [];
        $tipos = $this->tipos();
        foreach ($tipos as $tipo) {
            $arr[$tipo] = ['existe' => false];
        }
        foreach ($precios as $precio) {
            $tipo = $precio->tipo;
            $arr[$tipo]['existe'] = true;
            $arr[$tipo]['data'] = $precio;
        }
        return (object)$arr;
    }
}
