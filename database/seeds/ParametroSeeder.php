<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParametroSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {

      // ***************  Seeder para los Almacenes *****************
      DB::table('parametros')->insert([
         'codigo'      => '000001',
         'valor1'      => 'ALMACÉN DE CONSUMIBLES',
         'valor2'      => 'ALMACEN',
         'valor3'      => '',
         'estado'      => '1',
         'f_creacion'  => Carbon::now()->format('Y-m-d H:i:s'),
         'f_edicion'  => Carbon::now()->format('Y-m-d H:i:s'),
         'creado_por'  => '35',
         'editado_por' => '35'
      ]);

      DB::table('parametros')->insert([
         'codigo'      => '000002',
         'valor1'      => 'ALMACÉN DE ACTIVOS',
         'valor2'      => 'ALMACEN',
         'valor3'      => '',
         'estado'      => '1',
         'f_creacion'  => Carbon::now()->format('Y-m-d H:i:s'),
         'f_edicion'  => Carbon::now()->format('Y-m-d H:i:s'),
         'creado_por'  => '35',
         'editado_por' => '35'
      ]);

      DB::table('parametros')->insert([
         'codigo'      => '000003',
         'valor1'      => 'ALMACÉN DE HERRAMIENTAS',
         'valor2'      => 'ALMACEN',
         'valor3'      => '',
         'estado'      => '1',
         'f_creacion'  => Carbon::now()->format('Y-m-d H:i:s'),
         'f_edicion'  => Carbon::now()->format('Y-m-d H:i:s'),
         'creado_por'  => '35',
         'editado_por' => '35'
      ]);

      DB::table('parametros')->insert([
         'codigo'      => '000004',
         'valor1'      => 'ALMACEN DE SERVICIOS TERCEROS',
         'valor2'      => 'ALMACEN',
         'valor3'      => '',
         'estado'      => '1',
         'f_creacion'  => Carbon::now()->format('Y-m-d H:i:s'),
         'f_edicion'  => Carbon::now()->format('Y-m-d H:i:s'),
         'creado_por'  => '35',
         'editado_por' => '35'
      ]);

   }

}
