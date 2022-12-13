<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportCitasFromViewController implements FromView, ShouldAutoSize
{
    private $citas = [];

    public function __construct($listaCitas)
    {
        $this->citas = $listaCitas;
    }

    public function view(): View
    {
        $citas = $this->citas;

        return view('reportes.citasExcel', ["listaCitas" => $citas]);
    }
}
