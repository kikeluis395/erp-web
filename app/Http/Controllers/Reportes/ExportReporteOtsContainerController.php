<?php

namespace App\Http\Controllers\Reportes;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportReporteOtsContainerController implements WithMultipleSheets
{
    use Exportable;
    
    private $resultados = [];
    private $resumenCantidades = [];
    private $resumenFacturacion = [];

    public function __construct($resultados,$resumenCantidades,$resumenFacturacion)
    {
        $this->resultados = $resultados;
        $this->resumenCantidades = $resumenCantidades;
        $this->resumenFacturacion = $resumenFacturacion;
    }

    public function sheets(): array
    {
        $sheets = [new ExportReporteOtsController($this->resultados), 
                   new ExportReporteOtsResumenesController($this->resumenCantidades, $this->resumenFacturacion)];
        return $sheets;
    }
}