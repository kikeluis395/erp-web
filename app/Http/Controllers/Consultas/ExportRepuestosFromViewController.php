<?php

namespace App\Http\Controllers\Consultas;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportRepuestosFromViewController implements FromView, ShouldAutoSize
{
    private $repuestos = [];

    public function __construct($listaRepuestos)
    {
        $this->repuestos = $listaRepuestos;
    }

    public function view(): View
    {
        $repuestos = $this->repuestos;

        return view('consultas.repuestosExport', ["listaRepuestos" => $repuestos]);
    }
}
