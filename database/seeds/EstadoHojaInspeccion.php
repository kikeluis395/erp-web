<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoHojaInspeccion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("estado_hoja_inspeccion")->insert([
            ['id' => 1, 'nombre' => 'Inspección savar'],
            ['id' => 2, 'nombre' => 'Inspección Dealer'],
            ['id' => 3, 'nombre' => 'Completado'],
        ]);
    }
}
