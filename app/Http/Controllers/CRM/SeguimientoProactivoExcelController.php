<?php

namespace App\Http\Controllers\CRM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SeguimientoProactivoExcelController implements FromView, ShouldAutoSize
{
    private $talleres = [];

    public function __construct()
    {
        //$this->talleres = $listaTalleres;
    }

    public function view(): View
    {
        //$talleres = $this->talleres;

        return view('crm.seguimientoProactivoExcel'/*, ["listaTalleres" => $talleres]*/);
    }
}
