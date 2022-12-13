<?php

use App\Modelos\Modelo;
use App\Modelos\Vehiculo;
use Illuminate\Database\Seeder;

class VehiculosPlacasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehiculos = Vehiculo::all();
        foreach ($vehiculos as $vehiculo) {
            $modelo = $vehiculo->modelo;
            $marca = $vehiculo->id_marca_auto;
            $tecnico = $vehiculo->id_modelo_tecnico;

            $put_text_id = ($tecnico === 58 && $marca === 1) || $marca === 2;

            if (!is_numeric($modelo)) {
                $modelo_find = Modelo::where('nombre_modelo', $modelo)->first();
                if ($modelo_find) {
                    $id = $modelo_find->id_modelo;
                    if ($marca === 1) {
                        $vehiculo->modelo = $id;
                        $vehiculo->save();
                    }
                }
            } else {
                $modelo_find = Modelo::find($modelo);
                if ($put_text_id && $modelo_find) {
                    $vehiculo->modelo = $modelo_find->nombre_modelo;
                    $vehiculo->save();
                }
            }
        }
    }
}
