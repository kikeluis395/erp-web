<?php

use App\Modelos\Permiso;
use Illuminate\Database\Seeder;

class RolesInternoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reporteCitas = Permiso::where('nombre_interno', 'submodulo_reporteCitas')->get()->first();
        if ($reporteCitas) {
            $reporteCitas->descripcion = 'Resumen de Citas';
            $reporteCitas->save();
        }
        
    }
}
