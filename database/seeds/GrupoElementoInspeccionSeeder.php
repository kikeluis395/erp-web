<?php

use App\Modelos\Ventas\GrupoElementoInspeccion;
use Illuminate\Database\Seeder;

class GrupoElementoInspeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataToInsert = [
            ['id' => 1, 'nombre' => 'PREPARACION PDI'],
            ['id' => 2, 'nombre' => 'DEBAJO DEL COFRE: Motor apagado'],
            ['id' => 3, 'nombre' => 'EXTERIOR'],
            ['id' => 4, 'nombre' => 'DEBAJO DEL VEHICULO'],
            ['id' => 5, 'nombre' => 'INTERIOR: Motor apagado'],
            ['id' => 6, 'nombre' => 'INTERIOR: Motor encendido'],
            ['id' => 7, 'nombre' => 'DEBAJO DEL COFRE DE MOTOR: Motor encendido'],
            ['id' => 8, 'nombre' => 'PREPARACION FINAL'],
        ];

        GrupoElementoInspeccion::insert($dataToInsert);
    }
}
