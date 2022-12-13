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

class ExportReporteVentasTallerViewController implements WithTitle,FromView, ShouldAutoSize, WithEvents
{
    private $resultados = [];
    private $title = '';
    private $tipo = null;

    public function __construct($resultados, $title, $tipo = null)
    {
        $this->resultados = $resultados;
        $this->title = $title;
        $this->tipo = $tipo;
    }

    public function view(): View
    {
        $resultados = $this->resultados;

        if ($this->tipo == 'TALLER') {
            return view('reportes.reporteVentasTaller', ["resultados" => $resultados]);    
        }

        return view('reportes.reporteVentasHojaTaller', ["resultados" => $resultados]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    public function registerEvents(): array
    {
        $data = $this->resultados;
        return [
            AfterSheet::class => function(AfterSheet $event) use($data) {
                $sheet = $event->sheet;
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