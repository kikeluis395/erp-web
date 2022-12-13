<?php

namespace App\Http\Controllers\Reportes;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class ExportReporteOtsController implements WithTitle,FromView, ShouldAutoSize, WithEvents
{
    private $resultados = [];

    public function __construct($resultados)
    {
        $this->resultados = $resultados;
    }

    /*public function styles(Worksheet $sheet)
    {
        // $styleArray = [
        //     'borders' => [
        //         'outline' => [
        //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
        //             'color' => ['argb' => 'FFFF0000'],
        //         ],
        //     ],
        // ];

        // $styleArray = [
        //     'font' => [
        //         'bold' => true,
        //         'size'=>9,
        //     ],
        //     'alignment' => [
        //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        //         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        //     ],
        //     'borders' => [
        //         'allBorders' => [
        //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //         ],
        //     ],
        //     'fill' => [
        //         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        //     ],
        // ];

        //$sheet->getParent()->getDefaultStyle()->getBorders()->allBorders()->borderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        /*return [
            // Style the first row as bold text.
            //1    => ['font' => ['bold' => true]],

            // Styling an entire column.
            '1:20'  => [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ],
        ];*/

    /*}*/

    public function view(): View
    {
        $resultados = $this->resultados;

        return view('reportes.reporteOts', ["resultados" => $resultados]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'DETALLE';
    }

    public function registerEvents(): array
    {
        $data = $this->resultados;
        return [
            AfterSheet::class => function(AfterSheet $event) use($data) {
                $sheet = $event->sheet;

                //calculo de columnas (ya no es necesario por la funcion getHighestRow/getHighestColumn)
                // $numColumnas = 0;
                // foreach ($sheet->getRowIterator() as $row) {
                //     $cellIterator = $row->getCellIterator();
                //     $cellIterator->setIterateOnlyExistingCells(TRUE);
                //     foreach ($cellIterator as $cell) {
                //         $numColumnas++;
                //     }
                //     break; //se itera solo la primera vez
                // }

                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $celdaFinal = "$highestColumn$highestRow";

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

                
                //ajustes para todo el archivo
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
                $numFilas = count($data) + 1;
                $sheet->getStyle("A1:$celdaFinal")->applyFromArray($styleArray);

                $sheet->freezePane('A2');
                $sheet->setSelectedCell('A1');
            },
        ];
    }
}