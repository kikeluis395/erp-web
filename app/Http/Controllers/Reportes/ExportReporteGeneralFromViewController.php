<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportReporteGeneralFromViewController implements FromView, ShouldAutoSize
{
    private $talleres = [];

    public function __construct($listaTalleres)
    {
        $this->talleres = $listaTalleres;
    }

    public function view(): View
    {
        $talleres = $this->talleres;

        return view('reportes.reporteGeneralTabla', ["listaTalleres" => $talleres]);
    }
}
