<?php

namespace App\Http\Controllers\Facturacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\RecepcionOT;

class RepuestosPendientesController extends Controller
{
    public function index()
    {
        $registros = [];

        $ots = RecepcionOT::whereHas('comprobanteVenta', function ($q) {
            $q->orderBy('fecha_registro', 'desc');
        })->orWhereHas('comprobanteAnticipo', function ($q2) {
            $q2->orderBy('fecha_registro', 'desc');
        })->get();

        foreach ($ots as $ot) {

            $en_importacion = 0;
            $en_transito = 0;
            $en_custodia = 0;
            $entregados = 0;

            $estado_repuestos = 'ENTREGADO';
            $estado_repuestos_color = 'bg-success';

            $itemNecesidadRepuestos = count($ot->hojaTrabajo->necesidadesRepuestos) ? $ot->hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos()->whereNotNull('id_repuesto')->get() : [];

            foreach ($itemNecesidadRepuestos as $item) {
                $estado = $item->getDisponibilidad();
                if (in_array($estado, ['EN IMPORTACIÓN', 'EN TRÁNSITO'])) {
                    $estado_repuestos = 'PENDIENTE';
                    $estado_repuestos_color = 'bg-danger';

                    if ($estado == 'EN IMPORTACIÓN') $en_importacion++;
                    else if ($estado == 'EN TRÁNSITO') $en_transito++;                    
                } else {
                    $entregados++;
                }
            }

            $fecha_registro = '-';

            if ($ot->comprobanteAnticipo != null) {
                $fecha_registro = $ot->comprobanteAnticipo->fecha_registro->format('d/m/Y');
            }

            if ($ot->comprobanteVenta != null) {
                $fecha_registro = $ot->comprobanteVenta->fecha_registro->format('d/m/Y');
            }
              
            $registros[] = (object) [
                'fecha_registro' => $fecha_registro,
                'seccion' => $ot->seccion(),
                'doc_referencia' => $ot->getLinkDetalleHTML(),
                'status_cliente' => '',
                'responsable' => $ot->hojaTrabajo->empleado->nombreCompleto(),
                'estado_repuestos' => $estado_repuestos,
                'estado_repuestos_color' => $estado_repuestos_color,
                'en_transito' => $en_transito,
                'en_importacion' => $en_importacion,
                'en_custodia' => $en_custodia,
                'entregados' => $entregados
            ];
        }

        return view('repuestosPendientes', [
            'registros' => $registros
        ]);
    }
}
