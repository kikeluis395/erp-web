<?php

use App\Modelos\Parametro;
use Illuminate\Database\Seeder;

class ServicioTercerosSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $parametro         = new Parametro();
      $parametro->codigo = '000001';
      $parametro->valor1 = 'ACTIVO';
      $parametro->valor2 = 'ESTADO SERVICIO TERCERO';
      $parametro->valor3 = '';
      $parametro->estado = '1';
      $parametro->save();

      $parametro         = new Parametro();
      $parametro->codigo = '000002';
      $parametro->valor1 = 'INACTIVO';
      $parametro->valor2 = 'ESTADO SERVICIO TERCERO';
      $parametro->valor3 = '';
      $parametro->estado = '1';
      $parametro->save();
   }
}
