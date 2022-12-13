<?php

namespace App\Helper;

use Carbon\Carbon;

class Helper
{
    public static function obtenerUnidadMoneda($moneda)
    {
        return $moneda == "SOLES" ? "S/" : "$";
    }

    public static function obtenerUnidadMonedaCambiar($moneda)
    {
        return $moneda == "SOLES" ? "S/" : "$";
    }

    public static function obtenerUnidadMonedaCalculo($moneda)
    {
        return $moneda == "SOLES" ? "PEN" : "USD";
    }

    public static function mensajeIncluyeIGV()
    {
        return "*Los montos incluyen IGV";
    }

    public static function mensajeNoIncluyeIGV()
    {
        return "*Los montos no incluyen IGV";
    }

    public static function generarNroComprobante($nro)
    {
        $comprobante = 1000000;

        $nro_comprobante = $comprobante + (int) $nro;

        return substr($nro_comprobante, 1);
    }

    public static function motivosIn()
    {
        $motivos = [
            ["value" => 'COMPRAS', "show" => 'INGRESO DE REPUESTOS'],
            ["value" => 'TALLER', "show" => 'RE-INGRESO DE TALLER'],
            # [ "value" => 'TRANSFERENCIA', "show" => 'INGRESO POR TRANSFERENCIA' ],
            // ["value" => 'CONSUMIBLES', "show" => 'INGRESO ALMACÉN CONSUMIBLES'],
            // ["value" => 'ACTIVOS', "show" => 'INGRESO ALMACÉN ACTIVOS'],
        ];

        return json_encode($motivos);
    }

    public static function motivosOut()
    {
        $motivos = [
            ["value" => 'DEVOLUCION', "show" => 'DEVOLUCIÓN A PROVEEDOR'],
            ["value" => 'CTALLER', "show" => 'CONSUMO DE TALLER'],
            # [ "value" => 'STRANSFERENCIA', "show" => 'SALIDA POR TRANSFERENCIA' ],
        ];

        return json_encode($motivos);
    }

    public static function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array())
    {

        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);

        // Incremento en 1 dia
        $diainc = 24 * 60 * 60;

        // Arreglo de dias habiles, inicianlizacion

        #$diashabiles = array();
        $diashabiles = 0;

        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
            // Si no es un dia feriado entonces es habil
            if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                #array_push($diashabiles, date('Y-m-d', $midia));

                if (!in_array(date('N', $midia), array(6, 7))) { // DOC: http://www.php.net/manual/es/function.date.php
                    $diashabiles += 1;
                } else if (in_array(date('N', $midia), array(6))) {
                    $diashabiles += 0.5;
                }
            }
        }

        return $diashabiles;
    }

    public static function getDayForDiasHabiles($anio_filtro, $anio_actual, $mes, $mes_actual, $dia_actual)
    {
        $dias_mes = 0;

        if ($anio_filtro < $anio_actual) {
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio_filtro);
        } else if ($anio_filtro > $anio_actual) {
            $dias_mes = 0;
        } else {
            if ($mes == $mes_actual) {
                $dias_mes = $dia_actual;
            } else if ($mes > $mes_actual) {
                $dias_mes = 0;
            } else {
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio_filtro);
            }
        }

        return $dias_mes;
    }

    public static function getNameMonth($number)
    {
        $months = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];

        $monthName = $months[$number];

        return $monthName;
    }

    public static function getFullNameMonth($number)
    {
        $months = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        $monthName = $months[$number];

        return $monthName;
    }

    public static function getFeriados($year, $month)
    {
        $feriados = [
            1 => ["$year-01-01"],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
            6 => [],
            7 => ["$year-07-28", "$year-07-29"],
            8 => [],
            9 => [],
            10 => [],
            11 => [],
            12 => ["$year-12-08", "$year-12-25"],
        ];

        return $feriados[$month];
    }
    public static function cutString($len, $word)
    {
        $long = strlen($word);
        $final = substr($word, 0, $len);
        if ($long > $len) return $final . '...';
        return $final;
    }

    public static function sinVocals($word)
    {
        $word = strtoupper($word);

        $vocals = ["Á" => "a", "É" => "e", "Í" => "i", "Ó" => "o", "Ú" => "u"];
        foreach (array_keys($vocals) as $vocal) {
            $word = str_replace($vocal, $vocals[$vocal], $word);
        }
        return strtolower($word);
    }

    public static function randomChar($len = 10)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $len);
    }

    public static function evalZero($number)
    {
        if ((int)$number === 0) return '';
        return $number;
    }
}
