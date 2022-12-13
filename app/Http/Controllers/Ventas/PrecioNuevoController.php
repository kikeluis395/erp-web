<?php

namespace App\Http\Controllers\Ventas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\MarcaAuto;
use App\Modelos\VehiculoNuevo;
use App\Modelos\Ventas\PrecioVehiculoNuevo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PrecioNuevoController extends Controller
{
    public function index(Request $request)
    {
        $marcas = MarcaAuto::all();

        $marca = $request->marca;
        $anho = $request->anho;

        $searching = false;
        $vehiculos = collect([]);
        if ($marca && $anho) {
            $searching = true;
            $vehiculos = VehiculoNuevo::where('habilitado', 1);

            if ($marca != 'all') {
                $vehiculos = $vehiculos->where('id_marca_auto', $marca);
            }

            $vehiculos = $vehiculos->orderBy('modelo', 'asc')
                ->orderBy('version', 'asc')
                ->get();
        }
        $precios = $this->map_precio($vehiculos);

        $data = [
            'marcas' => $marcas,
            'precios' => $precios,
            // 'tipos' => $this->tipos(),
            // 'precio_exists' => $precio_exists,
            // 'costo_exists' => $costo_exists
            'vehiculos' => $vehiculos,
            'searching' => $searching,
            'refreshable' => false
        ];
        return view('precios.preciosNuevos', $data);
    }

    public function store(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id_vehiculo_nuevo) {

            $existe = $request->input("existe_$id_vehiculo_nuevo");
            $id = $request->input("id_$id_vehiculo_nuevo");

            $precio_vehiculo = null;
            if ($existe === '1' && $id) {
                $precio_vehiculo = PrecioVehiculoNuevo::find($id);
                $precio_vehiculo->editor = Auth::user()->id_usuario;
                $precio_vehiculo->fecha_edicion = Carbon::now();
            } else {
                $precio_vehiculo = new PrecioVehiculoNuevo();
                $precio_vehiculo->id_vehiculo_nuevo = str_replace('V', '', $id_vehiculo_nuevo);
                $precio_vehiculo->id_local = Auth::user()->empleado->id_local;
                $precio_vehiculo->creador = Auth::user()->id_usuario;
                $precio_vehiculo->habilitado = 1;
            }

            $bono = $request->input("bono_$id_vehiculo_nuevo");
            $bono_adicional_1 = $request->input("bono_adicional_1_$id_vehiculo_nuevo");
            $bono_adicional_2 = $request->input("bono_adicional_2_$id_vehiculo_nuevo");
            $bono_cierre = $request->input("bono_cierre_$id_vehiculo_nuevo");
            $bono_retoma = $request->input("bono_retoma_$id_vehiculo_nuevo");
            $precio = $request->input("precio_$id_vehiculo_nuevo");

            $precio_vehiculo->bono = $bono;
            $precio_vehiculo->bono_adicional_1 = $bono_adicional_1;
            $precio_vehiculo->bono_adicional_2 = $bono_adicional_2;
            $precio_vehiculo->bono_cierre = $bono_cierre;
            $precio_vehiculo->bono_retoma = $bono_retoma;
            $precio_vehiculo->precio = $precio;
            $precio_vehiculo->save();
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

    public function map_precio($vehiculos)
    {
        $arr = [];
        foreach ($vehiculos as $vehiculo) {
            $precio = $vehiculo->precio;

            if ($precio) $arr["V$vehiculo->id_vehiculo_nuevo"] = ["existe" => true, 'precio' => $precio];
            else $arr["V$vehiculo->id_vehiculo_nuevo"] = ["existe" => false];
        }
        return $arr;
    }
}
