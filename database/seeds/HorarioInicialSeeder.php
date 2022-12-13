<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorarioInicialSeeder extends Seeder
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
                "dom_in" => "07:00",
                "dom_out" => "16:30",
                "lun_in" => "07:00",
                "lun_out" => "16:30",
                "mar_in" => "07:00",
                "mar_out" => "16:30",
                "mie_in" => "07:00",
                "mie_out" => "16:30",
                "jue_in" => "07:00",
                "jue_out" => "16:30",
                "vie_in" => "07:00",
                "vie_out" => "16:30",
                "sab_in" => "07:00",
                "sab_out" => "16:30",
                "en_uso" => "1",
                "aplica_desde" => "2018-01-01",
                "aplica_hasta" => null,
                "intervalo_citas" => 30,
            ]
        ];

        foreach ($data as $record) {
            DB::table('horarios_trabajo')->insert($record);
        }
    }
}
