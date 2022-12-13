<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalesSedder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
       DB::table('sucursales')->insert([
         'codigo'     => 'S0002',
         'nombre'     => 'LOS OLIVOS',
         'estado'     => '1',
         'creado_por' => '35',
         'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
         'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
      ]);
   }
}
