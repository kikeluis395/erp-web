<?php

use Illuminate\Database\Seeder;

class ModelosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modelo')->insert([
            'nombre_modelo' => 'B10 ALMERA', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'B13 SENTRA', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'B16 SENTRA', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'B17 SENTRA', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'B18 SENTRA', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'C11 TIIDA', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'D22 FRONTIER', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'D23 NP300', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'D40 NAVARA', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'E25 URVAN', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'E26 URVAN', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'F15 JUKE', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'J10 QASHQAI', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'J11 QASHQAI', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'K13 MARCH', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'L32 ALTIMA', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'N17 VERSA', 
            'id_marca_auto' => 1     
        ]);DB::table('modelo')->insert([
            'nombre_modelo' => 'N18 VERSA', 
            'id_marca_auto' => 1     
        ]);DB::table('modelo')->insert([
            'nombre_modelo' => 'P15 KICKS', 
            'id_marca_auto' => 1     
        ]);DB::table('modelo')->insert([
            'nombre_modelo' => 'R51 PATHFINDER', 
            'id_marca_auto' => 1     
        ]);DB::table('modelo')->insert([
            'nombre_modelo' => 'R52 PATHFINDER', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'T30 X-TRAIL', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'T31 X-TRAIL', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'T32 X-TRAIL', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'Y62 PATROL', 
            'id_marca_auto' => 1     
        ]);
        DB::table('modelo')->insert([
            'nombre_modelo' => 'Z51 MURANO', 
            'id_marca_auto' => 1     
        ]);

    }
}
