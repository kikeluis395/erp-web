<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSubmodulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'descripcion' => 'Garantías',
                'nombre_interno' => 'modulo_garantias',
                'habilitado' => '1'
            ],
            [
                'descripcion' => 'Seguimiento Garantías',
                'nombre_interno' => 'submodulo_seguimientoGarantias',
                'habilitado' => '1'
            ],
            [
                'descripcion' => 'BYP - Mano de Obra',
                'nombre_interno' => 'submodulo_bypMO',
                'habilitado' => '1'
            ],
            [
                'descripcion' => 'MEC - Mano de Obra',
                'nombre_interno' => 'submodulo_mecMO',
                'habilitado' => '1'
            ],
            [
                'descripcion' => 'Usuarios y Perfiles',
                'nombre_interno' => 'submodulo_perfiles',
                'habilitado' => '1'
            ],
            [
                'descripcion' => 'Generalidades del dealer',
                'nombre_interno' => 'submodulo_configuracionDealer',
                'habilitado' => '1'
            ],
        ];
        foreach ($data as $submodule) {
            DB::table('permiso')->insert($submodule);
        }


        // $estados = [
        //     [
        //         "nombre_estado_reparacion_interno" => "garantia_cerrado",
        //         "nombre_estado_reparacion_filtro" => "GARANTÍA CERRADA",
        //         "nombre_estado_reparacion" => "GARANTÍA CERRADA"
        //     ],
        //     [
        //         "nombre_estado_reparacion_interno" => "garantia_facturada",
        //         "nombre_estado_reparacion_filtro" => "GARANTÍA FACTURADA",
        //         "nombre_estado_reparacion" => "GARANTÍA FACTURADA"
        //     ],
        // ];

        // foreach ($estados as $estado) {
        //     DB::table('estado_reparacion')->insert($estado);
        // }

        // $rolpermiso = [
        //     ["id_rol" => "1", "id_permiso" => "61"],
        //     ["id_rol" => "1", "id_permiso" => "62"],
        //     ["id_rol" => "1", "id_permiso" => "63"],
        //     ["id_rol" => "1", "id_permiso" => "64"],
        //     ["id_rol" => "1", "id_permiso" => "65"],
        //     ["id_rol" => "1", "id_permiso" => "66"],
        // ];

        // foreach ($rolpermiso as $asign) {
        //     DB::table('rol_permiso')->insert($asign);
        // }
    }
}
