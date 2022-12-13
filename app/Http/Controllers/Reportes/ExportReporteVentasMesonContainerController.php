<?php

namespace App\Http\Controllers\Reportes;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportReporteVentasMesonContainerController implements WithMultipleSheets
{
    use Exportable;

    private $resultadosMeson = [];

    public function __construct($resultadosMeson)
    {
        $this->resultadosMeson = $resultadosMeson;
    }

    public function sheets(): array
    {
        $sheets = [
            new ExportReporteVentasMesonViewController($this->resultadosMeson)
        ];
        return $sheets;
    }
}