<?php

namespace App\Exports;

use App\Modelos\RecepcionOT;
use Maatwebsite\Excel\Concerns\FromCollection;

class TestExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RecepcionOT::all();
    }
}
