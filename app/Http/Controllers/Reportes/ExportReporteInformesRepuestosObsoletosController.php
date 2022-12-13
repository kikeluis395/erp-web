<?php

namespace App\Http\Controllers\Reportes;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportReporteInformesRepuestosObsoletosController implements WithMultipleSheets
{
    use Exportable;

    private $resultados = [];

    public function __construct($resultados)
    {
        $this->resultados = $resultados;
    }

    public function sheets(): array
    {
        $lista = collect($this->resultados);
        $sheets = [
            new ExportReporteInformesRepuestosObsoletosViewController($lista, 'REPUESTOS')                
        ];

        return $sheets;
    }
}
