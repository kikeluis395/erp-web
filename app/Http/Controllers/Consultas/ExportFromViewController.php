<?php

namespace App\Http\Controllers\Consultas;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportFromViewController implements FromView, ShouldAutoSize
{
    private $placa = "";

    public function __construct($placa)
    {
        $this->placa = $placa;
    }

    public function view(): View
    {
        $placa = $this->placa;
        $detallesTrabajo = (new ConsultasController)->getHistoriaClinicaDetallesTrabajo($placa);

        return view('consultas.historiaClinicaExport', ["detallesTrabajo" => $detallesTrabajo]);
    }
}
