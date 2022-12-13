<?php

use App\Modelos\VehiculoSeminuevo;
use Faker\Generator as Faker;

$factory->define(VehiculoSeminuevo::class, function (Faker $faker) {
    return [
        'placa'=>$faker->numerify("######"),
        'vin'=>strtoupper($faker->lexify('?????????????????')),
        'id_almacen'=>1,
        'id_local'=>'1',
        'id_modelo_auto_seminuevo'=>'1',
        'motor'=>strtoupper($faker->lexify('?????????????????')),
        'anho_fabricacion'=>$faker->numberBetween(1999, 2021),
        'anho_modelo'=>$faker->numberBetween(1999, 2021),
        'version'=>$faker->sentence(1),
        'kilometraje'=>$faker->numberBetween(1000, 10000),
        'color'=>$faker->colorName,
        'combustible'=>$faker->randomElement(["GASOLINA","PETROLEO"]),
        'cilindrada'=>$faker->numberBetween(0, 10),
        'transmision'=>$faker->randomElement(["MECANICA","AUTOMATICA"]),
        'traccion'=>$faker->numberBetween(0, 10),
    ];
});
