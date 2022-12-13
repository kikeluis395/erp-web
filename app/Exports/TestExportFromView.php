<?php

namespace App\Exports;

use App\Modelos\RecepcionOT;
use App\Modelos\TipoDanhoTemp;
use Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

//use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TestExportFromView implements FromView, /*ShouldAutoSize,*/ WithEvents
{
    private static $hoja1 = "Bitácora";
    private static $hoja2 = "Análisis";
    private static $rangoTipoDanho = null;
    private static $rangoEstado = null;
    private static $rangoFechaIngreso = null;
    private static $colorHeaderDiasLaborales = '548235';
    private static $colorHeaderDiasCalendario = 'BF8F00';
    private static $colorHeaderRecepcion ='FC4A57';
    private static $colorHeaderValuacion ='44546A';
    private static $filaInicialContenido = 3;
    private static $fechaInicio = null;
    private static $fechaFin = null;
    private static $listaRecepciones = null;

    public function __construct($fechaInicio,$fechaFin){
        self::$rangoTipoDanho = self::$hoja1 . "!C:C";
        self::$rangoEstado = self::$hoja1 . "!A:A";
        self::$rangoFechaIngreso = self::$hoja1 . "!G:G";

        self::$fechaInicio = $fechaInicio;
        self::$fechaFin = $fechaFin;

        $id_rol_usuario= Auth::user()->id_rol;

        $preLista = new RecepcionOT();
        if(self::$fechaInicio){
            $fechaInicio = self::$fechaInicio;
            $preLista = $preLista->where(function ($query) use($fechaInicio){
                return $query->doesntHave('valuaciones.entregas')
                       ->orWhereHas('valuaciones.entregas', function ($query) use($fechaInicio){
                            $query->where('fecha_entrega','>=',"$fechaInicio");
                        });
            });
        }
        if(self::$fechaFin){
            $fechaFin = self::$fechaFin;
            $preLista = $preLista->where(function ($query) use($fechaFin){
                return $query->doesntHave('valuaciones.entregas')
                       ->orWhereHas('valuaciones.entregas', function ($query) use($fechaFin){
                            $query->where('fecha_entrega','<=',"$fechaFin");
                        });
            });
        }
        if(in_array($id_rol_usuario,[2,3,4,5,7])){
            $id_local = Auth::user()->empleado()->first()->id_local;
            $preLista = $preLista->whereHas('hojaTrabajo.empleado.local', function ($query) use($id_local) {
                $query->where('id_local',$id_local);
            });
        }
        self::$listaRecepciones = $preLista->get();
    }

    public static function anchosSegundaFila($hoja)
    {
        $hoja->getColumnDimension('A')->setWidth(24);
        $hoja->getColumnDimension('B')->setWidth(14);
        $hoja->getColumnDimension('C')->setWidth(15);
        $hoja->getColumnDimension('D')->setWidth(12);
        $hoja->getColumnDimension('E')->setWidth(10);
        $hoja->getColumnDimension('F')->setWidth(10);
        $hoja->getColumnDimension('G')->setWidth(12);
        $hoja->getColumnDimension('H')->setWidth(15);
        $hoja->getColumnDimension('I')->setWidth(10);
        $hoja->getColumnDimension('J')->setWidth(12);
        $hoja->getColumnDimension('K')->setWidth(13);
        $hoja->getColumnDimension('L')->setWidth(13);
        $hoja->getColumnDimension('M')->setWidth(26);
        $hoja->getColumnDimension('N')->setWidth(15);
        $hoja->getColumnDimension('O')->setWidth(14);
        $hoja->getColumnDimension('P')->setWidth(13);
        $hoja->getColumnDimension('Q')->setWidth(15);
        $hoja->getColumnDimension('R')->setWidth(17);
        $hoja->getColumnDimension('S')->setWidth(17);
        $hoja->getColumnDimension('T')->setWidth(14);
        $hoja->getColumnDimension('U')->setWidth(15);
        $hoja->getColumnDimension('V')->setWidth(15);
        $hoja->getColumnDimension('W')->setWidth(14);
        $hoja->getColumnDimension('X')->setWidth(12);
        $hoja->getColumnDimension('Y')->setWidth(12);
        $hoja->getColumnDimension('Z')->setWidth(12);
        $hoja->getColumnDimension('AA')->setWidth(20);
        $hoja->getColumnDimension('AB')->setWidth(20);
        $hoja->getColumnDimension('AC')->setWidth(20);
        $hoja->getColumnDimension('AD')->setWidth(20);
        $hoja->getColumnDimension('AE')->setWidth(20);
        $hoja->getColumnDimension('AF')->setWidth(20);
        $hoja->getColumnDimension('AG')->setWidth(16);
        $hoja->getColumnDimension('AH')->setWidth(15);
        $hoja->getColumnDimension('AI')->setWidth(15);
        $hoja->getColumnDimension('AJ')->setWidth(24);
        $hoja->getColumnDimension('AK')->setWidth(15);
        $hoja->getColumnDimension('AL')->setWidth(24);
        $hoja->getColumnDimension('AM')->setWidth(14);
        $hoja->getColumnDimension('AN')->setWidth(14);
        $hoja->getColumnDimension('AO')->setWidth(19);

        $hoja->getColumnDimension('AQ')->setWidth(10);
        $hoja->getColumnDimension('AR')->setWidth(10);
        $hoja->getColumnDimension('AS')->setWidth(10);
        $hoja->getColumnDimension('AT')->setWidth(10);
        $hoja->getColumnDimension('AU')->setWidth(10);
        $hoja->getColumnDimension('AV')->setWidth(10);
        $hoja->getColumnDimension('AW')->setWidth(10);
        $hoja->getColumnDimension('AX')->setWidth(10);
        $hoja->getColumnDimension('AY')->setWidth(10);
        $hoja->getColumnDimension('AZ')->setWidth(10);
        $hoja->getColumnDimension('BA')->setWidth(10);
        $hoja->getColumnDimension('BB')->setWidth(10);
        $hoja->getColumnDimension('BC')->setWidth(10);
        $hoja->getColumnDimension('BD')->setWidth(10);
        $hoja->getColumnDimension('BE')->setWidth(10);
        $hoja->getColumnDimension('BF')->setWidth(12);

        $hoja->getStyle('A2:BF2')->getAlignment()->setWrapText(true);
    }

    public static function estilosSegundaFila($hoja)
    {
        self::anchosSegundaFila($hoja);

        $styleArray = [
            'font' => [
                'bold' => true,
                'size'=>9,
            ],
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
        $cellRange = 'A2:AO2';
        $hoja->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
        $hoja->setAutoFilter($cellRange);

        $styleArray = [
            'font' => [
                'bold' => true,
                'size'=>8,
            ],
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
        $cellRange = 'AQ2:BF2';
        $hoja->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);


        //Header Generales
        $cellRange = 'A2:B2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('C00000');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'C2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('595959');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'D2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('C00000');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'E2:F2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('D9D9D9');

        $cellRange = 'G2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('73F93D');

        $cellRange = 'H2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('A6A6A6');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'I2:N2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('D9D9D9');

        $cellRange = 'O2:R2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('73F93D');

        $cellRange = 'S2:U2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('FF0000');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'V2:W2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('595959');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'X2:AA2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('D9D9D9');

        $cellRange = 'AB2:AC2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('73F93D');

        $cellRange = 'AD2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('FFFF00');

        $cellRange = 'AE2:AG2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('73F93D');

        $cellRange = 'AH2:AI2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('C65911');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'AJ2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('595959');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'AK2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('C65911');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'AL2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('595959');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'AM2:AO2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('73F93D');


        $cellRange = 'AQ2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('996633');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'AR2:AT2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('E2EFDA');

        $cellRange = 'AU2:AV2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('FF0000');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'AW2:AX2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('E2EFDA');


        $cellRange = 'AY2:BA2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('FFF2CC');

        $cellRange = 'BB2:BC2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('FF0000');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');

        $cellRange = 'BD2:BE2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('FFF2CC');

        $cellRange = 'BF2';
        $hoja->getStyle($cellRange)->getFill()->getStartColor()->setARGB('A6A6A6');
        $hoja->getStyle($cellRange)->getFont()->getColor()->setARGB('F3F3F3');
    }

    public static function seccionDiasLaborales($hoja,$cant)
    {
        $columnaIni = 44;
        $filaIni = self::$filaInicialContenido;
        for ($i=0; $i < $cant; $i++) { 
            $fila = $filaIni + $i;

            /*Tiempo de estancia */
            $columna = $columnaIni;
            
            $celdaEstado = $hoja->getCellByColumnAndRow(1,$fila)->getCoordinate();
            $celdaFechaEntrega = $hoja->getCellByColumnAndRow(41,$fila)->getCoordinate();
            $celdaFechaIngreso = $hoja->getCellByColumnAndRow(7,$fila)->getCoordinate();
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"),IF($celdaFechaEntrega - $celdaFechaIngreso = 0,0, NETWORKDAYS($celdaFechaIngreso,$celdaFechaEntrega)-1 + INT( ($celdaFechaEntrega - $celdaFechaIngreso + WEEKDAY($celdaFechaIngreso-7) )/7 )/2 ),\"-\")");

            /*Tiempo de termino operativo */
            $columna++;
            $celdaControlCalidad = $hoja->getCellByColumnAndRow(39,$fila)->getCoordinate();
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"),IF($celdaControlCalidad - $celdaFechaIngreso = 0,0, NETWORKDAYS($celdaFechaIngreso,$celdaControlCalidad)-1 + INT( ($celdaControlCalidad - $celdaFechaIngreso + WEEKDAY($celdaFechaIngreso-7) )/7 )/2 ),\"-\")");
            
            /*Tiempo de reparacion */
            $columna++;
            $celdaInicioOperativo = $hoja->getCellByColumnAndRow(33,$fila)->getCoordinate();
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"),IF($celdaControlCalidad - $celdaInicioOperativo = 0,0, NETWORKDAYS($celdaInicioOperativo,$celdaControlCalidad)-1 + INT( ($celdaControlCalidad - $celdaInicioOperativo + WEEKDAY($celdaInicioOperativo-7) )/7 )/2 ),\"-\")");

            /*Espera de asignacion */
            $columna++;
            $celdaAprobacionCliente = $hoja->getCellByColumnAndRow(18,$fila)->getCoordinate();
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"),IF($celdaInicioOperativo - $celdaAprobacionCliente = 0,0, NETWORKDAYS($celdaAprobacionCliente,$celdaInicioOperativo)-1 + INT( ($celdaInicioOperativo - $celdaAprobacionCliente + WEEKDAY($celdaAprobacionCliente-7) )/7 )/2 ),\"-\")");

            /*Espera de ampliación */
            $columna++;
            $celdaAprobacionClienteAmp = $hoja->getCellByColumnAndRow(21,$fila)->getCoordinate();
            $celdaInicioValuacionAmp = $hoja->getCellByColumnAndRow(19,$fila)->getCoordinate();
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IFERROR(IF(($celdaEstado=\"ENTREGADO\"),IF($celdaAprobacionClienteAmp - $celdaInicioValuacionAmp = 0,0, NETWORKDAYS($celdaInicioValuacionAmp,$celdaAprobacionClienteAmp)-1 + INT( ($celdaAprobacionClienteAmp - $celdaInicioValuacionAmp + WEEKDAY($celdaInicioValuacionAmp-7) )/7 )/2 ),\"-\"),0)");

            /*Tiempo de aprobación */
            $columna++;
            $celdaInicioValuacion = $hoja->getCellByColumnAndRow(16,$fila)->getCoordinate();
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"),IF($celdaAprobacionCliente - $celdaInicioValuacion = 0,0, NETWORKDAYS($celdaInicioValuacion,$celdaAprobacionCliente)-1 + INT( ($celdaAprobacionCliente - $celdaInicioValuacion + WEEKDAY($celdaInicioValuacion-7) )/7 )/2 ),\"-\")");

            /*Tiempo de valuación */
            $columna++;
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"),IF($celdaInicioValuacion - $celdaFechaIngreso = 0,0, NETWORKDAYS($celdaFechaIngreso,$celdaInicioValuacion)-1 + INT( ($celdaInicioValuacion - $celdaFechaIngreso + WEEKDAY($celdaFechaIngreso-7) )/7 )/2 ),\"-\")");



            /*Tiempo de estancia */
            $columna++;
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"), $celdaFechaEntrega - $celdaFechaIngreso ,\"-\")");

            /*Tiempo de termino operativo */
            $columna++;
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"), $celdaControlCalidad - $celdaFechaIngreso ,\"-\")");

            /*Tiempo de reparacion */
            $columna++;
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"), $celdaControlCalidad - $celdaInicioOperativo ,\"-\")");

            /*Espera de asignacion */
            $columna++;
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"), $celdaInicioOperativo - $celdaAprobacionCliente ,\"-\")");

            /*Espera de ampliación */
            $columna++;
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IFERROR(IF(($celdaEstado=\"ENTREGADO\"), $celdaAprobacionClienteAmp - $celdaInicioValuacionAmp ,\"-\"),0)");

            /*Tiempo de aprobación */
            $columna++;
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"), $celdaAprobacionCliente - $celdaInicioValuacion ,\"-\")");

            /*Tiempo de valuación */
            $columna++;
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"), $celdaInicioValuacion - $celdaFechaIngreso ,\"-\")");

            $columna++;
            $celdaFechaPromesaEntrega = $hoja->getCellByColumnAndRow(34,$fila)->getCoordinate();
            $hoja->getCellByColumnAndRow($columna,$fila)->setValue("=IF(($celdaEstado=\"ENTREGADO\"), IF($celdaFechaEntrega>$celdaFechaPromesaEntrega,\"NO\",\"SI\") ,\"-\")");
        }
    }

    public static function estilosContenidoBitacora($hoja,$cant)
    {
        $filaIni = self::$filaInicialContenido;
        $filaFin = $filaIni + $cant - 1;

        $rangoColumna = function($columnaIniStr,$columnaFinStr=null) use($filaIni,$filaFin)
        {
            if(!$columnaFinStr)
                return "$columnaIniStr"."$filaIni:$columnaIniStr"."$filaFin";
            else
                return "$columnaIniStr"."$filaIni:$columnaFinStr"."$filaFin";
        };

        $tipoFill = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;

        $cellRange = $rangoColumna('B','C');
        $hoja->getStyle($cellRange)->getFill()->setFillType($tipoFill)->getStartColor()->setARGB('FCE4D6');

        $cellRange = $rangoColumna('D');
        $hoja->getStyle($cellRange)->getFill()->setFillType($tipoFill)->getStartColor()->setARGB('FFF2CC');

        $cellRange = $rangoColumna('G');
        $hoja->getStyle($cellRange)->getFill()->setFillType($tipoFill)->getStartColor()->setARGB('F2F2F2');

        $cellRange = $rangoColumna('O','U');
        $hoja->getStyle($cellRange)->getFill()->setFillType($tipoFill)->getStartColor()->setARGB('F2F2F2');

        $cellRange = $rangoColumna('AB','AC');
        $hoja->getStyle($cellRange)->getFill()->setFillType($tipoFill)->getStartColor()->setARGB('F2F2F2');

        $cellRange = $rangoColumna('AE','AI');
        $hoja->getStyle($cellRange)->getFill()->setFillType($tipoFill)->getStartColor()->setARGB('F2F2F2');

        $cellRange = $rangoColumna('AK');
        $hoja->getStyle($cellRange)->getFill()->setFillType($tipoFill)->getStartColor()->setARGB('F2F2F2');

        $cellRange = $rangoColumna('AM','AO');
        $hoja->getStyle($cellRange)->getFill()->setFillType($tipoFill)->getStartColor()->setARGB('F2F2F2');

        $cellRange = $rangoColumna('AQ','BF');
        $hoja->getStyle($cellRange)->getFill()->setFillType($tipoFill)->getStartColor()->setARGB('FCE4D6');

        $styleArray = [
            'font' => [
                'size'=>10,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $cellRange = $rangoColumna('A','AO');
        $hoja->getStyle($cellRange)->applyFromArray($styleArray);

        $cellRange = $rangoColumna('AQ','BF');
        $hoja->getStyle($cellRange)->applyFromArray($styleArray);
    }

    public static function seccionAnalisis($hoja)
    {   
        $filaInicial=2;
        $columnaInicial=2;
        $nombreHojaBitacora = self::$hoja1;
        $rangoTipoDanho = self::$rangoTipoDanho;
        $rangoEstado = self::$rangoEstado;
        $rangoFechaIngreso = self::$rangoFechaIngreso;

        $fila=$filaInicial;
        $columna=$columnaInicial;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("INDICADORES DE LA BITÁCORA");
        $styleArray = [
            'font' => [
                'italic' => true,
                'bold' => true,
                'underline' => true,
                'size'=>14,
            ],
        ];
        $celda->getStyle()->applyFromArray($styleArray);


        $fila+=2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("1. Análisis de Tiempo de Estancia");
        $styleSubtitulo = [
            'font' => [
                'bold' => true,
                'size'=>11,
                'color' => ['rgb' => 'FF0000']
            ],
        ];
        $celda->getStyle()->applyFromArray($styleSubtitulo);

        $fila+=2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("1.1. PROMEDIO (Todos los tipos de daño)");
        $styleArray = [
            'font' => [
                'size'=>10,
            ],
        ];
        $celda->getStyle()->applyFromArray($styleArray);


        $columna+=5;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("2. Por TIPO DE DAÑO:");
        $celda->getStyle()->applyFromArray($styleArray);

        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        
        $validacion = $celda->getDataValidation();
        $validacion->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
        $validacion->setShowDropDown(true);
        $validacion->setFormula1(TipoDanhoTemp::tiposDanhoExcelValidation());
        $celda->setValue(TipoDanhoTemp::$tipos_danho[0]);
        $celdaTipoDanhoStr = $celda->getCoordinate();
        $styleArray = [
            'font' => [
                'size'=>11,
                'bold'=>true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'F2F2F2',
                ],
            ],
        ];
        $celda->getStyle()->applyFromArray($styleArray);

        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("Total Casos:");
        $colAux = $columna;
        
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("=COUNTIF($rangoTipoDanho,$celdaTipoDanhoStr)");
        $styleArray = [
            'font' => [
                'size'=>11,
                'bold'=>true,
                'color' => ['rgb' => 'FF0000']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFFF00',
                ],
            ],
        ];
        $celda->getStyle()->applyFromArray($styleArray);
        
        $columna = $colAux;
        $fila++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("Entregados:");

        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("=COUNTIFS($rangoTipoDanho,$celdaTipoDanhoStr,$rangoEstado,\"ENTREGADO\")");
        $styleArray = [
            'font' => [
                'size'=>11,
                'bold'=>true,
                'color' => ['rgb' => 'FF0000']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'F2F2F2',
                ],
            ],
        ];
        $celda->getStyle()->applyFromArray($styleArray);


        $styleArray = [
            'font' => [
                'size'=>11,
                'bold'=>true,
                'underline'=>true,
            ],
        ];
        $fila+=1;
        $columna=$columnaInicial;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("Días Laborales");
        $celda->getStyle()->applyFromArray($styleArray);
        $columna+=2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("Días Calendario");
        $celda->getStyle()->applyFromArray($styleArray);

        $columna+=3;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("Días Laborales");
        $celda->getStyle()->applyFromArray($styleArray);
        $columna+=2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("Días Calendario");
        $celda->getStyle()->applyFromArray($styleArray);

        $fila++;
        $columna=$columnaInicial;

        $rotulo ="T.P de Estancia";
        $funcionPromedio = function($rango){
            return "IFERROR(AVERAGE($rango),\"\")";
        };
        $funcionPromedioTipoDanho = function($rango) use($rangoTipoDanho,$celdaTipoDanhoStr){
            return "IFERROR(AVERAGEIF($rangoTipoDanho,$celdaTipoDanhoStr,$rango),\"\")";
        };

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEstanciaLaborales1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AR:AR";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");
        $celdaValorEstanciaLaborales1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEstanciaCalendario1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AY:AY";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");
        $celdaValorEstanciaCalendario1 = $celda->getCoordinate();

        $columna += 2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEstanciaLaborales2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AR:AR";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");
        $celdaValorEstanciaLaborales2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEstanciaCalendario2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AY:AY";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");
        $celdaValorEstanciaCalendario2 = $celda->getCoordinate();



        $fila++;
        $columna = $columnaInicial;


        $rotulo ="T.P de Término Operativo";

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AS:AS";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AZ:AZ";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");

        $columna += 2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AS:AS";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AZ:AZ";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");

        $fila++;
        $columna = $columnaInicial;


        $rotulo ="T.P. Reparación";

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaReparacionLaborales1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AT:AT";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaReparacionCalendario1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!BA:BA";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");

        $columna += 2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaReparacionLaborales2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AT:AT";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaReparacionCalendario2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!BA:BA";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");

        $fila++;
        $columna = $columnaInicial;


        $rotulo ="Espera de Asignación";

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEsperaAsignacionLaborales1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AU:AU";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEsperaAsignacionCalendario1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!BB:BB";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");

        $columna += 2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEsperaAsignacionLaborales2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AU:AU";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEsperaAsignacionCalendario2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!BB:BB";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");


        $fila++;
        $columna = $columnaInicial;


        $rotulo ="T.P. Aprobación";

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaAprobacionLaborales1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AV:AV";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaAprobacionCalendario1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!BC:BC";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");

        $columna += 2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaAprobacionLaborales2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AV:AV";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaAprobacionCalendario2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!BC:BC";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");

        
        $fila++;
        $columna = $columnaInicial;


        $rotulo ="T.P. Valuación";

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaValuacionLaborales1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AW:AW";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaValuacionCalendario1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!BD:BD";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");

        $columna += 2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaValuacionLaborales2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AW:AW";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaValuacionCalendario2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!BD:BD";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");


        $fila++;
        $columna = $columnaInicial;
        

        $rotulo ="Espera Ampliación";

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEsperaAmpliacionLaborales1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AX:AX";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");
        $celdaValorEsperaAmpliacionLaborales1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEsperaAmpliacionCalendario1 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!BE:BE";
        $formula = $funcionPromedio($rango);
        $celda->setValue("=$formula");
        $celdaValorEsperaAmpliacionCalendario1 = $celda->getCoordinate();


        $columna += 2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEsperaAmpliacionLaborales2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!AX:AX";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");
        $celdaValorEsperaAmpliacionLaborales2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($rotulo);
        $celdaEsperaAmpliacionCalendario2 = $celda->getCoordinate();
        $columna++;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $rango="$nombreHojaBitacora!BE:BE";
        $formula = $funcionPromedioTipoDanho($rango);
        $celda->setValue("=$formula");
        $celdaValorEsperaAmpliacionCalendario2 = $celda->getCoordinate();

        $styleArrayVerde = [
            'font' => [
                'size'=>8,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'C6E0B4',
                ],
            ],
        ];

        $styleArrayAmarillo = [
            'font' => [
                'size'=>8,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFE699',
                ],
            ],
        ];

        $styleArrayRojo = [
            'font' => [
                'size'=>8,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FF0000',
                ],
            ],
        ];

        $styleArrayGris = [
            'font' => [
                'size'=>11,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'F2F2F2',
                ],
            ],
        ];

        $cellRange = "$celdaEstanciaLaborales1:$celdaReparacionLaborales1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayVerde);
        $cellRange = "$celdaEsperaAsignacionLaborales1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayRojo);
        $cellRange = "$celdaAprobacionLaborales1:$celdaValuacionLaborales1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayVerde);
        $cellRange = "$celdaEsperaAmpliacionLaborales1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayRojo);

        $cellRange = "$celdaValorEstanciaLaborales1:$celdaValorEsperaAmpliacionLaborales1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayGris);

        $cellRange = "$celdaEstanciaCalendario1:$celdaReparacionCalendario1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayAmarillo);
        $cellRange = "$celdaEsperaAsignacionCalendario1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayRojo);
        $cellRange = "$celdaAprobacionCalendario1:$celdaValuacionCalendario1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayAmarillo);
        $cellRange = "$celdaEsperaAmpliacionCalendario1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayRojo);

        $cellRange = "$celdaValorEstanciaCalendario1:$celdaValorEsperaAmpliacionCalendario1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayGris);


        $styleArrayBordes = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        
        $cellRange = "$celdaEstanciaLaborales1:$celdaValorEsperaAmpliacionCalendario1";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayBordes);

        $cellRange = "$celdaEstanciaLaborales2:$celdaReparacionLaborales2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayVerde);
        $cellRange = "$celdaEsperaAsignacionLaborales2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayRojo);
        $cellRange = "$celdaAprobacionLaborales2:$celdaValuacionLaborales2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayVerde);
        $cellRange = "$celdaEsperaAmpliacionLaborales2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayRojo);

        $cellRange = "$celdaValorEstanciaLaborales2:$celdaValorEsperaAmpliacionLaborales2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayGris);

        $cellRange = "$celdaEstanciaCalendario2:$celdaReparacionCalendario2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayAmarillo);
        $cellRange = "$celdaEsperaAsignacionCalendario2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayRojo);
        $cellRange = "$celdaAprobacionCalendario2:$celdaValuacionCalendario2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayAmarillo);
        $cellRange = "$celdaEsperaAmpliacionCalendario2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayRojo);

        $cellRange = "$celdaValorEstanciaCalendario2:$celdaValorEsperaAmpliacionCalendario2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayGris);

        $cellRange = "$celdaEstanciaLaborales2:$celdaValorEsperaAmpliacionCalendario2";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayBordes);





        /*Evaluación de Performance*/
        $query = DB::select("CALL PROC_REPORTE_PERFORMANCE()");
        $fila+=3;
        $columna = $columnaInicial;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("2. Evaluación de Performance");
        $celda->getStyle()->applyFromArray($styleSubtitulo);
        $fila++;
        $columna = $columnaInicial;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("Cumplimiento de F.P.E");
        $celdaCumplimientoFPE = $celda->getCoordinate();
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($query[0]->cumplimiento)->getStyle()->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);

        $columna+=2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("TOTAL CASOS:");
        $celdaTotalCasos = $celda->getCoordinate();
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("=COUNTA($rangoFechaIngreso)");
        $celdaTotalStr = $celda->getCoordinate();

        $fila++;
        $columna = $columnaInicial;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("% Ampliaciones");
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($query[0]->porc_ampliaciones)->getStyle()->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);

        $columna+=2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("ENTREGADOS:");
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("=COUNTIF($rangoEstado,\"ENTREGADO\") + COUNTIF($rangoEstado,\"ENTREGADO-HL\")");
        $celdaEntregadosStr = $celda->getCoordinate();

        $fila++;
        $columna = $columnaInicial;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("% Vehículo con estado HL");
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($query[0]->porc_hotline)->getStyle()->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);

        $columna+=2;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("EN OPERACIÓN:");
        $celdaEnOperacion = $celda->getCoordinate();
        

        $styleResumenPerformance = [
            'font' => [
                'size'=>10,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
        ];
        $cellRange = "$celdaTotalCasos:$celdaEnOperacion";
        $hoja->getStyle($cellRange)->applyFromArray($styleResumenPerformance);

        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("=$celdaTotalStr - $celdaEntregadosStr");

        $fila++;
        $columna = $columnaInicial;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("% Vehículo con MECColision");
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($query[0]->porc_mec_colision)->getStyle()->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);
        $fila++;
        $columna = $columnaInicial;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("Pérdidas Totales");
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($query[0]->perdidas_totales);
        $fila++;
        $columna = $columnaInicial;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("HorasMEC Facturadas");
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($query[0]->horas_mec);
        $fila++;
        $columna = $columnaInicial;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("HorasCAR Facturadas");
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($query[0]->horas_carr);
        $fila++;
        $columna = $columnaInicial;

        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue("Paños Facturados");
        $celdaPanhosFacturados = $celda->getCoordinate();
        $columna++;
        $celda = $hoja->getCellByColumnAndRow($columna,$fila);
        $celda->setValue($query[0]->panhos);
        $celdaValorPanhosFacturados = $celda->getCoordinate();
        $fila++;
        $columna = $columnaInicial;


        $styleArrayGris2 = [
            'font' => [
                'size'=>8,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'F2F2F2',
                ],
            ],
        ];
        $cellRange = "$celdaCumplimientoFPE:$celdaPanhosFacturados";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayGris2);

        $cellRange = "$celdaCumplimientoFPE:$celdaValorPanhosFacturados";
        $hoja->getStyle($cellRange)->applyFromArray($styleArrayBordes);


        $styleArray = [
            'font' => [
                'name'=> 'Arial',
            ],
        ];
        $hoja->getStyle( $hoja->calculateWorksheetDimension() )->applyFromArray($styleArray); 
        $hoja->setShowGridlines(false);

        $hoja->getColumnDimension('A')->setWidth(3);
        $hoja->getColumnDimension('B')->setWidth(27);
        $hoja->getColumnDimension('C')->setWidth(10);
        $hoja->getColumnDimension('D')->setWidth(17);
        $hoja->getColumnDimension('E')->setWidth(10);
        $hoja->getColumnDimension('F')->setWidth(7);
        $hoja->getColumnDimension('G')->setWidth(20);
        $hoja->getColumnDimension('H')->setWidth(13);
        $hoja->getColumnDimension('I')->setWidth(18);
        $hoja->getColumnDimension('J')->setWidth(14);

        $hoja->getRowDimension('2')->setRowHeight(19);
        $hoja->getRowDimension('4')->setRowHeight(15);
        $hoja->getRowDimension('5')->setRowHeight(9);
        $hoja->getRowDimension('6')->setRowHeight(15);
        $hoja->getRowDimension('7')->setRowHeight(12);
        $hoja->getRowDimension('8')->setRowHeight(15);
        $hoja->getRowDimension('18')->setRowHeight(15);
        $hoja->setSelectedCell('B2');
    }

    public function view(): View
    {
        return view('exportReporte', [
            'recepciones' => self::$listaRecepciones
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cant = self::$listaRecepciones->count();
                $colorHeaderTop1 = self::$colorHeaderRecepcion;
                $colorHeaderTop2 = self::$colorHeaderValuacion;
                $colorHeaderDiasLaborales = self::$colorHeaderDiasLaborales;
                $colorHeaderDiasCalendario = self::$colorHeaderDiasCalendario;
                $diaInicio = date('d/m/y',strtotime(self::$fechaInicio));
                $diaFin = date('d/m/y',strtotime(self::$fechaFin));

                $event->sheet->setTitle(self::$hoja1);
                $styleArray = [
                    'font' => [
                        'bold' => true,
                        'color' => [ 'rgb' => 'FFFFFF' ],
                        'size'=>22,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $event->sheet->getSheetView()->setZoomScale(85);
                $event->sheet->freezePane('H3');
                
                $event->sheet->getColumnDimension('B')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('C')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('D')->setOutlineLevel(1);

                $cellRange = 'E1:AO1';
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);

                $styleArray = [
                    'font' => [
                        'bold' => true,
                        'color' => [ 'rgb' => 'FFFFFF' ],
                        'size'=>11,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];
                $cellRange = 'AR1:BE1';
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);

                $event->sheet->getDelegate()->getCell('A1')->setValue("Del $diaInicio hasta el $diaFin");
                $event->sheet->getDelegate()->getStyle('B1')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);;
                //Header Recepcion
                $cellRange = 'E1:O1';
                $event->sheet->getDelegate()->getStyle($cellRange)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB($colorHeaderTop1)
                ;
                $event->sheet->mergeCells($cellRange);

                $event->sheet->getColumnDimension('H')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('I')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('J')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('K')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('L')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('M')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('N')->setOutlineLevel(1);

                //Header Valuacion y aprobacion
                $cellRange = 'P1:Z1';
                $event->sheet->getDelegate()->getStyle($cellRange)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB($colorHeaderTop2)
                ;
                $event->sheet->mergeCells($cellRange);

                //Header Repuestos
                $cellRange = 'AA1:AF1';
                $event->sheet->getDelegate()->getStyle($cellRange)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB($colorHeaderTop1)
                ;
                $event->sheet->mergeCells($cellRange);

                $event->sheet->getColumnDimension('V')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('W')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('X')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('Y')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('Z')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('AA')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('AB')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('AC')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('AD')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('AE')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('AF')->setOutlineLevel(1);

                //Header Reparacion
                $cellRange = 'AG1:AL1';
                $event->sheet->getDelegate()->getStyle($cellRange)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB($colorHeaderTop2)
                ;
                $event->sheet->mergeCells($cellRange);

                $event->sheet->getColumnDimension('AH')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('AI')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('AJ')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('AK')->setOutlineLevel(1);
                $event->sheet->getColumnDimension('AL')->setOutlineLevel(1);

                //Header C.C
                $cellRange = 'AM1:AN1';
                $event->sheet->getDelegate()->getStyle($cellRange)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB($colorHeaderTop1)
                ;
                $event->sheet->mergeCells($cellRange);

                //Header Entrega
                $cellRange = 'AO1';
                $event->sheet->getDelegate()->getStyle($cellRange)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB($colorHeaderTop2)
                ;

                //Header Días Laborales
                $cellRange = 'AR1:AX1';
                $event->sheet->getDelegate()->getStyle($cellRange)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB($colorHeaderDiasLaborales)
                ;
                $event->sheet->mergeCells($cellRange);

                //Header Días Calendario
                $cellRange = 'AY1:BE1';
                $event->sheet->getDelegate()->getStyle($cellRange)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB($colorHeaderDiasCalendario)
                ;
                $event->sheet->mergeCells($cellRange);

                $event->sheet->getDelegate()->getColumnDimension('AN')->setVisible(false);

                //Segunda fila
                self::estilosSegundaFila($event->sheet);

                /*Días laborales */
                self::seccionDiasLaborales($event->sheet,$cant);
                self::estilosContenidoBitacora($event->sheet,$cant);

                $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($event->sheet->getParent(), self::$hoja2);
                //Se crea una nueva hoja "Análisis"
                $event->sheet->getParent()->addSheet($myWorkSheet);
                $hojaAnalisis = $event->sheet->getParent()->getSheet(1);
                self::seccionAnalisis($hojaAnalisis);
            },
        ];
    }
}
