<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportReporteStockController implements WithTitle,FromView, ShouldAutoSize, WithEvents
{
    private $resultados = [];

    public function __construct($resultados)
    {
        $this->resultados = $resultados;
    }

    public function title(): string
    {
        return 'STOCK';
    }

    public function view(): View
    {
        $resultados = $this->resultados;

        return view('reportes.reporteStock', ["resultados" => $resultados]);
    }

    public function registerEvents(): array
    {
        $data = $this->resultados;
        return [
            AfterSheet::class => function(AfterSheet $event) use($data) {
                $sheet = $event->sheet;

                //ajustes para todas las celdas
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $celdaFinal = "$highestColumn$highestRow";
                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    ],
                ];

                #$sheet->getParent()->getDefaultStyle()->applyFromArray($styleArray);
                $sheet->getStyle("A1:$celdaFinal")->applyFromArray($styleArray);

                //ajustes para la primera fila(rotulos)
                $styleArray = [
                    'font' => [
                        'bold' => true,
                        'size'=>10,
                        'color' => ['rgb' => 'FFFFFF']
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'C00000',
                        ],
                    ],
                ];
                $sheet->getStyle("A1:${highestColumn}1")->applyFromArray($styleArray);


                //ajustes dependiendo del motivo de movimiento
                // foreach ($sheet->getRowIterator() as $row) {
                //     $cellIterator = $row->getCellIterator();
                //     $cellIterator->setIterateOnlyExistingCells(TRUE);
                //     foreach ($cellIterator as $cell) {
                //         $numColumnas++;
                //     }
                //     break; //se itera solo la primera vez
                // }

                // se asume que el motivo esta en la columna 7 (G) del excel (considerando a la primera columna como 1)
                $numFilas = count($data) + 1; //en este caso 1 es el offset por la linea de rotulos
                for($fila=1; $fila<$numFilas; ++$fila){
                    $cell = $sheet->getCellByColumnAndRow(8,$fila);
                    $celdaCodigoRep = $sheet->getCell("A$fila");
                    $valorCodigo = $celdaCodigoRep->getValue();
                    //$valorMotivo = $cell->getValue();
                    /*if(in_array($valorMotivo, ['S.I','TOTAL'])){
                        $sheet->getStyle("A$fila:${highestColumn}$fila")->getFont()->setBold(true);

                        if($valorMotivo == 'S.I')
                            $sheet->getCell("B$fila")->setValue('SALDO INICIAL');
                        else{
                            $celdaCodigoRep = $sheet->getCell("A$fila");
                            $valorCodigo = $celdaCodigoRep->getValue();
                            $celdaCodigoRep->setValue("Total $valorCodigo");
                            $sheet->getCell("B$fila")->setValue('');
                        }
                    }*/

                }

                $sheet->freezePane('A2');
                $sheet->setSelectedCell('A1');
            },
        ];
    }
}
