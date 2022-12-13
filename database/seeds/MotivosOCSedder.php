<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotivosOCSedder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {

      $requerimientos = [
         [
            'codigo'      => 'R0001',
            'valor1'      => 'REQUERIMIENTO PARA CONSUMO',
            'valor2'      => 'REQUERIMIENTO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'R0002',
            'valor1'      => 'REQUERIMIENTO PARA GARANTIAS',
            'valor2'      => 'REQUERIMIENTO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'R0003',
            'valor1'      => 'REQUERIMIENTO PARA MECÁNICA',
            'valor2'      => 'REQUERIMIENTO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'R0004',
            'valor1'      => 'REQUERIMIENTO PARA MESON',
            'valor2'      => 'REQUERIMIENTO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'R0005',
            'valor1'      => 'REQUERIMIENTO PARA PYP',
            'valor2'      => 'REQUERIMIENTO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'R0006',
            'valor1'      => 'REQUERIMIENTO PARA STOCK',
            'valor2'      => 'REQUERIMIENTO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'R0007',
            'valor1'      => 'REQUERIMIENTO PARA VENTAS',
            'valor2'      => 'REQUERIMIENTO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ]

      ];

      DB::table('parametros')->insert($requerimientos);

   }
}
