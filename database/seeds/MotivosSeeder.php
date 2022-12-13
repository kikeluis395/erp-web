<?php

use App\Modelos\Parametro;
use Illuminate\Database\Seeder;

class MotivosSeeder extends Seeder
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
      $parametro->valor1 = 'REQUERIMIENTO PARA CONSUMO';
      $parametro->valor2 = 'REQUERIMIENTO';
      $parametro->valor3 = '';
      $parametro->estado = '1';
      $parametro->save();

      $parametro         = new Parametro();
      $parametro->codigo = '000002';
      $parametro->valor1 = 'REQUERIMIENTO PARA GARANTIAS';
      $parametro->valor2 = 'REQUERIMIENTO';
      $parametro->valor3 = '';
      $parametro->estado = '1';
      $parametro->save();

      $parametro         = new Parametro();
      $parametro->codigo = '000003';
      $parametro->valor1 = 'REQUERIMIENTO PARA MECÁNICA';
      $parametro->valor2 = 'REQUERIMIENTO';
      $parametro->valor3 = '';
      $parametro->estado = '1';
      $parametro->save();

      $parametro         = new Parametro();
      $parametro->codigo = '000004';
      $parametro->valor1 = 'REQUERIMIENTO PARA MESON';
      $parametro->valor2 = 'REQUERIMIENTO';
      $parametro->valor3 = '';
      $parametro->estado = '1';
      $parametro->save();

      $parametro         = new Parametro();
      $parametro->codigo = '000005';
      $parametro->valor1 = 'REQUERIMIENTO PYP';
      $parametro->valor2 = 'REQUERIMIENTO';
      $parametro->valor3 = '';
      $parametro->estado = '1';
      $parametro->save();

      $parametro         = new Parametro();
      $parametro->codigo = '000006';
      $parametro->valor1 = 'REQUERIMIENTO PARA STOCK';
      $parametro->valor2 = 'REQUERIMIENTO';
      $parametro->valor3 = '';
      $parametro->estado = '1';
      $parametro->save();

      $parametro         = new Parametro();
      $parametro->codigo = '000007';
      $parametro->valor1 = 'REQUERIMIENTO PARA VENTAS';
      $parametro->valor2 = 'REQUERIMIENTO';
      $parametro->valor3 = '';
      $parametro->estado = '1';
      $parametro->save();

   }
}
