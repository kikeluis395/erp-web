<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $estados = [
         [
            'codigo'      => 'E0001',
            'valor1'      => 'PENDIENTE',
            'valor2'      => 'ESTADO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'E0002',
            'valor1'      => 'APROBADO',
            'valor2'      => 'ESTADO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'E0003',
            'valor1'      => 'RECHAZADO',
            'valor2'      => 'ESTADO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'E0004',
            'valor1'      => 'ANULADO',
            'valor2'      => 'ESTADO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'E0004',
            'valor1'      => 'ATENDIDO',
            'valor2'      => 'ESTADO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'E0005',
            'valor1'      => 'ATENDIDO PARCIAL',
            'valor2'      => 'ESTADO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ],
         [
            'codigo'      => 'E0006',
            'valor1'      => 'COMPLETO',
            'valor2'      => 'ESTADO',
            'valor3'      => '',
            'estado'      => '1',
            'creado_por'  => '35',
            'editado_por' => '35',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
         ]

      ];

      DB::table('parametros')->insert($estados);
   }
}
