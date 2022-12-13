<?php

namespace App\Http\Controllers\Reportes;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportReporteVentasContainerController implements WithMultipleSheets
{
    use Exportable;

    private $resultadosTaller = [];
    private $resultadosMeson = [];
    private $tipo = null;
    private $tipoMeson = false;

    public function __construct($resultadosTaller, $tipo = null, $resultadosMeson = [], $tipoMeson = false)
    {
        $this->resultadosTaller = $resultadosTaller;
        $this->resultadosMeson = $resultadosMeson;
        $this->tipo = $tipo;
        $this->tipoMeson = $tipoMeson;
    }

    public function sheets(): array
    {
        $listTaller = collect($this->resultadosTaller);
        $sheets = [
            new ExportReporteVentasTallerViewController($listTaller->where('seccion', 'DYP'), 'TALLER - B&P', $this->tipo),
            new ExportReporteVentasTallerViewController($listTaller->where('seccion', 'MEC'), 'TALLER - MEC', $this->tipo)                    
        ];

        if ($this->tipoMeson) {
            $sheets[] = new ExportReporteVentasMesonViewController($this->resultadosMeson, $this->tipoMeson);
        }

        return $sheets;
    }
}
