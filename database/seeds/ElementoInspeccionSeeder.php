<?php

use App\Modelos\ElementoInspeccion;
use Illuminate\Database\Seeder;

class ElementoInspeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataToInsert = [
            ['nombre_elemento_inspeccion' => 'Desconectar el fusible', 'grupo_elemento_id' => 1],
            ['nombre_elemento_inspeccion' => 'Activar la BCM (Computadora del vehiculo)', 'grupo_elemento_id' => 1],

            ['nombre_elemento_inspeccion' => 'Revisar nivel de refrigerante', 'grupo_elemento_id' => 2],
            ['nombre_elemento_inspeccion' => 'Revisar tensión de la banda impulsora', 'grupo_elemento_id' => 2],
            ['nombre_elemento_inspeccion' => 'Revisar nivel del aceite de motor', 'grupo_elemento_id' => 2],
            ['nombre_elemento_inspeccion' => 'Revisar condición de la bateria', 'grupo_elemento_id' => 2],
            ['nombre_elemento_inspeccion' => 'Revisar nivel liquido de frenos y embrague', 'grupo_elemento_id' => 2],
            ['nombre_elemento_inspeccion' => 'Revisar nivel de aceite de la dirección hidráulica', 'grupo_elemento_id' => 2],
            ['nombre_elemento_inspeccion' => 'Revisar nivel de liquido de limpiaparabrisas', 'grupo_elemento_id' => 2],
            ['nombre_elemento_inspeccion' => 'Revisar que no exista fuga de liquidos', 'grupo_elemento_id' => 2],

            ['nombre_elemento_inspeccion' => 'Instalacion de gata y herramientas', 'grupo_elemento_id' => 3],
            ['nombre_elemento_inspeccion' => 'Revision de presión de llanta de repuesto', 'grupo_elemento_id' => 3],
            ['nombre_elemento_inspeccion' => 'Colocar tapa de remolque dentro de vehiculo', 'grupo_elemento_id' => 3],
            ['nombre_elemento_inspeccion' => 'Colocar copa de aros dentro del vehiculo', 'grupo_elemento_id' => 3],
            ['nombre_elemento_inspeccion' => 'Ajustar tuercas de llantas', 'grupo_elemento_id' => 3],
            ['nombre_elemento_inspeccion' => 'Revisar presión de llantas', 'grupo_elemento_id' => 3],
            ['nombre_elemento_inspeccion' => 'Revisar operación del cofre de motor', 'grupo_elemento_id' => 3],
            ['nombre_elemento_inspeccion' => 'Revisar operación de la tapa de combustible', 'grupo_elemento_id' => 3],
            ['nombre_elemento_inspeccion' => 'Revisar operacion de cerraduras y seguros de puerta', 'grupo_elemento_id' => 3],
            ['nombre_elemento_inspeccion' => 'Revisar operación de cajuela / puerta trasera', 'grupo_elemento_id' => 3],
            ['nombre_elemento_inspeccion' => 'Revisar operación del mecanismo de seguro de niños', 'grupo_elemento_id' => 3],

            ['nombre_elemento_inspeccion' => 'Revisar daños y defectos de llantas', 'grupo_elemento_id' => 4],
            ['nombre_elemento_inspeccion' => 'Revisar fugas de liquido', 'grupo_elemento_id' => 4],
            ['nombre_elemento_inspeccion' => 'Apretar tornillos / tuercas de suspensión y tren motriz', 'grupo_elemento_id' => 4],
            ['nombre_elemento_inspeccion' => 'Revisar tubo de escape', 'grupo_elemento_id' => 4],
            ['nombre_elemento_inspeccion' => 'Revisar daños de la carroceria', 'grupo_elemento_id' => 4],

            ['nombre_elemento_inspeccion' => 'Revisar operación del asiento', 'grupo_elemento_id' => 5],
            ['nombre_elemento_inspeccion' => 'Revisar operación del cinturon de seguridad de asientos', 'grupo_elemento_id' => 5],
            ['nombre_elemento_inspeccion' => 'Revisar operación del timón', 'grupo_elemento_id' => 5],
            ['nombre_elemento_inspeccion' => 'Revisar operación de la tapa de guantera, consola y encendero (si aplica)', 'grupo_elemento_id' => 5],
            ['nombre_elemento_inspeccion' => 'Revisar operación del swtich de bloqueo de puertas', 'grupo_elemento_id' => 5],
            ['nombre_elemento_inspeccion' => 'Ajustar hora', 'grupo_elemento_id' => 5],
            ['nombre_elemento_inspeccion' => 'Verificar sistema de audio (radio, CD y USB)', 'grupo_elemento_id' => 5],
            ['nombre_elemento_inspeccion' => 'Verificar funcionamiento del sistema de navegacion (si aplica)', 'grupo_elemento_id' => 5],
            ['nombre_elemento_inspeccion' => 'Revisar operaciones de espejos retrovisores', 'grupo_elemento_id' => 5],
            ['nombre_elemento_inspeccion' => 'Revisar operación de sujetador de lentes de sol', 'grupo_elemento_id' => 5],

            ['nombre_elemento_inspeccion' => 'Revisar luces de emergencia', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Encender el motor y detectar ruidos', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Verificar el arranque de motor c/todas las llaves', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar el tablero de instrumento', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar luces interiores', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar luces delanteras', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar luces posteriores', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar bocina (cláxon)', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar limpiaparabrisas y lavaparabrisas', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar operación de controles de timón', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar operación del aire acondicionado y calefacción', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar desempañador de cristal posterior', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar operación de sunroof (si aplica)', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar operación de las ventanillas', 'grupo_elemento_id' => 6],
            ['nombre_elemento_inspeccion' => 'Revisar cámara y sensores', 'grupo_elemento_id' => 6],

            ['nombre_elemento_inspeccion' => 'Condición de marcha minima', 'grupo_elemento_id' => 7],
            ['nombre_elemento_inspeccion' => 'Nivel de aceite en T/A', 'grupo_elemento_id' => 7],
            ['nombre_elemento_inspeccion' => 'Fuga de gas refrigerante del aire acondicionado', 'grupo_elemento_id' => 7],

            ['nombre_elemento_inspeccion' => 'Revisar carroceria e imperfecciones de pintura', 'grupo_elemento_id' => 8],
            ['nombre_elemento_inspeccion' => 'Verificar ajuste y alineacion de carroceria', 'grupo_elemento_id' => 8],
            ['nombre_elemento_inspeccion' => 'Verificación de molduras, emblemas y etiquetas (si aplica)', 'grupo_elemento_id' => 8],
            ['nombre_elemento_inspeccion' => 'Verificar documentos pertinentes de la guantera', 'grupo_elemento_id' => 8],
        ];
        ElementoInspeccion::insert($dataToInsert);
    }
}
