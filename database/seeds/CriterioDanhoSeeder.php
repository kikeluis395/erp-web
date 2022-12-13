<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriterioDanhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["codigo" => "HMO_LEV_MIN", "valor" => 3, "editable" => 1, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "HMO_LEV_MAX", "valor" => 10, "editable" => 1, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "HMO_MED_MIN", "valor" => 10, "editable" => 0, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "HMO_MED_MAX", "valor" => 20, "editable" => 1, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "HMO_FUE_MIN", "valor" => 20, "editable" => 0, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "HMO_FUE_MAX", "valor" => 20, "editable" => 0, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => ">"],
            ["codigo" => "PAP_LEV_MIN", "valor" => 2, "editable" => 1, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "PAP_LEV_MAX", "valor" => 4, "editable" => 1, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "PAP_MED_MIN", "valor" => 4, "editable" => 0, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "PAP_MED_MAX", "valor" => 8, "editable" => 1, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "PAP_FUE_MIN", "valor" => 8, "editable" => 0, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "PAP_FUE_MAX", "valor" => 8, "editable" => 0, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => ">"],
            ["codigo" => "REP_LEV_MIN", "valor" => 0, "editable" => 0, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "REP_LEV_MAX", "valor" => 500, "editable" => 1, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "REP_MED_MIN", "valor" => 500, "editable" => 0, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "REP_MED_MAX", "valor" => 2000, "editable" => 1, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "REP_FUE_MIN", "valor" => 2000, "editable" => 0, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => null],
            ["codigo" => "REP_FUE_MAX", "valor" => 2000, "editable" => 0, "habilitado" => 1, "fecha_edicion" => new DateTime(), "id_usuario" => "1", "before" => ">"],
        ];
        foreach ($data as $record) {
            DB::table('criterio_danho')->insert($record);
        }
    }
}
