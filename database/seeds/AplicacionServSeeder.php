<?php

use App\Modelos\ServicioTercero;
use Illuminate\Database\Seeder;

class AplicacionServSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servs = ServicioTercero::all();
        foreach ($servs as $servicio) {
            $servicio->marcas = json_encode(["M1" => "1", "M2" => "1"]);
            $servicio->save();
        }
    }
}
