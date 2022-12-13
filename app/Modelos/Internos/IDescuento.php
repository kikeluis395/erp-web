<?php

namespace App\Modelos\Internos;

interface IDescuento
{
    public function getFuenteDescuento();
    public function getLocal();
    public function getIDFuenteDescuento();
    public function getIDClienteDescuento();
    public function getAsesorSolicitante();
    public function getFechaSolicitud();
    public function getPrecioSinDescuento($moneda);
    public function getPrecioConDescuento($moneda);
    public function getIdDescuento();
}
