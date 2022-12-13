<?php

namespace App\Http\Controllers\Ventas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\VehiculoSeminuevo;
use Illuminate\Support\Facades\Auth;

class PrecioSeminuevoController extends Controller
{
    public function index()
    {
        $vehiculos = VehiculoSeminuevo::whereNull('deleted_at')->get();
        $precios = $this->map_precio($vehiculos);
        $data = [
            // 'precio' => $precio,
            // 'tipos' => $this->tipos(),
            // 'precio_exists' => $precio_exists,
            // 'costo_exists' => $costo_exists,
            'precios' => $precios,
            'vehiculos' => $vehiculos,
        ];
        return view('precios.preciosSeminuevos', $data);
    }

    public function store(Request $request)
    {
        // $ids = $request->ids;
        // foreach ($ids as $id_vehiculo_nuevo) {

        //     $existe = $request->input("existe_$id_vehiculo_nuevo");
        //     $id = $request->input("id_$id_vehiculo_nuevo");

        //     $precio_vehiculo = null;
        //     if ($existe === '1' && $id) {
        //         $precio_vehiculo = PrecioVehiculoNuevo::find($id);
        //         $precio_vehiculo->editor = Auth::user()->id_usuario;
        //         $precio_vehiculo->fecha_edicion = Carbon::now();
        //     } else {
        //         $precio_vehiculo = new PrecioVehiculoNuevo();
        //         $precio_vehiculo->id_vehiculo_nuevo = str_replace('V', '', $id_vehiculo_nuevo);
        //         $precio_vehiculo->id_local = Auth::user()->empleado->id_local;
        //         $precio_vehiculo->creador = Auth::user()->id_usuario;
        //         $precio_vehiculo->habilitado = 1;
        //     }

        //     $precio = $request->input("precio_$id_vehiculo_nuevo");
        //     $precio_vehiculo->precio = $precio;
        //     $precio_vehiculo->save();
        // }

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        // Schema::create('precio_vehiculo_seminuevo', function (Blueprint $table) {
        //     $table->unsignedInteger('id_precio_vehiculo_seminuevo')->autoIncrement();
        //     $table->unsignedBigInteger('id_vehiculo_seminuevo')->nullable(false);
        //     $table->double('precio', 10, 2)->nullable();

        //     $table->unsignedInteger('creador')->nullable(false);
        //     $table->unsignedInteger('editor')->nullable();
        //     $table->unsignedInteger('id_local')->nullable(false);
        //     $table->boolean('habilitado')->nullable(false);
        //     $table->dateTime('fecha_edicion')->nullable();
        //     $table->dateTime('fecha_registro')->useCurrent();

        //     $table->foreign('id_vehiculo_seminuevo')->references('id_vehiculo_seminuevo')->on('vehiculo_seminuevo');
        //     $table->foreign('creador')->references('id_usuario')->on('usuario');
        //     $table->foreign('editor')->references('id_usuario')->on('usuario');
        //     $table->foreign('id_local')->references('id_local')->on('local_empresa');
        // });
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

            if ($precio) $arr["V$vehiculo->id_vehiculo_seminuevo"] = ["existe" => true, 'precio' => $precio];
            else $arr["V$vehiculo->id_vehiculo_seminuevo"] = ["existe" => false];
        }
        return $arr;
    }
}
