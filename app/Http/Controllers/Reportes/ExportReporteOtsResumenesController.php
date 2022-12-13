<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportReporteOtsResumenesController implements WithTitle, FromView
{
    private $resumenCantidad = [];
    private $resumenFacturacion = [];

    public function __construct($resultadosCantidad, $resultadosFacturacion)
    {
        $this->resumenCantidad = $resultadosCantidad;
        $this->resumenFacturacion = $resultadosFacturacion;
    }

    public function view(): View
    {
        return view('reportes.reporteOts_resumen', ["resultadosCantidad" => $this->resumenCantidad,
                                                    "resultadosFacturacion" => $this->resumenFacturacion
                                                    ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'RESUMEN';
    }
}