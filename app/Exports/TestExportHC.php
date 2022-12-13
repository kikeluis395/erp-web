<?php

namespace App\Exports;

use App\Modelos\RecepcionOT;
use App\Modelos\HojaTrabajo;
use Maatwebsite\Excel\Concerns\FromCollection;

class TestExportHC implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return HojaTrabajo::with('detallesTrabajo')->get();
    }
}
