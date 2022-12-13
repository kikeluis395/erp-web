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

class ExportReporteVentaRepuestosController implements WithTitle,FromView, ShouldAutoSize, WithEvents
{
    private $resultados = [];

    public function __construct($resultados)
    {
        $this->resultados = $resultados;
    }

    public function title(): string
    {
        return 'VENTA REPUESTOS';
    }

    public function view(): View
    {
        $resultados = $this->resultados;

        return view('reportes.reporteVentaRepuestos', ["resultados" => $resultados]);
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