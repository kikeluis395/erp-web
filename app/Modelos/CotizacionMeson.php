<?php

namespace App\Modelos;

use App\Modelos\Internos\GrupoTransaccionMonetaria;
use App\Modelos\LineaCotizacionMeson;
use App\Modelos\VentaMeson;
use Carbon\Carbon;
use DB;

class CotizacionMeson extends GrupoTransaccionMonetaria
{
    //
    protected $table = "cotizacion_meson";
    protected $dates = ["fecha_registro"];

    protected $fillable = ['doc_cliente', 'nombre_cliente', 'observaciones', 'moneda', 'telefono_contacto', 'email_contacto', 'id_usuario_registro', 'fecha_registro', 'es_cerrada', 'razon_cierre', 'fecha_cierre'];

    protected $primaryKey = 'id_cotizacion_meson';
    private $arrDisponibilidades = null;
    public $timestamps = false;
    public static $detalleCotRouteKey = 'id_cotizacion_meson';

    public function lineasCotizacionMeson()
    {
        return $this->hasMany('App\Modelos\LineaCotizacionMeson', 'id_cotizacion_meson');
    }

    public function comprobanteVenta()
    {
        return $this->hasOne('App\Modelos\ComprobanteVenta', 'id_cotizacion_meson');
    }

    public function ventasMeson()
    {
        return $this->hasMany('App\Modelos\VentaMeson', 'id_cotizacion_meson');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Modelos\Cliente', 'doc_cliente');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo('App\Modelos\Usuario', 'id_usuario_registro');
    }

    public function local()
    {
        return $this->belongsTo('App\Modelos\LocalEmpresa', 'id_local');
    }

    public function descuentos()
    {
        return $this->hasMany('App\Modelos\DescuentoMeson', 'id_cotizacion_meson');
    }

    public function ubigeo()
    {
        return $this->belongsTo('App\Modelos\Ubigeo', 'cod_ubigeo');
    }

    public function getNumDoc()
    {
        return $this->doc_cliente;
    }

    public function getDepartamento()
    {
        if ($this->ubigeo) {
            return $this->ubigeo->departamento;
        }
        return null;
    }

    public function getProvincia()
    {
        if ($this->ubigeo) {
            return $this->ubigeo->provincia;
        }
        return null;
    }
    public function getDistrito()
    {
        if ($this->ubigeo) {
            return $this->ubigeo->distrito;
        }
        return null;
    }

    public function getDescuentoRptos()
    {
        $dsct = $this->descuentos()->where('es_aprobado', 1)->orderBy('fecha_registro', 'desc')->first();
        if ($dsct) {
            return $dsct->porcentaje_solicitado_rptos;
        }
        return null;
    }
    public function getDescuentoLubricantes()
    {
        $dsct = $this->descuentos()->where('es_aprobado', 1)->orderBy('fecha_registro', 'desc')->first();
        if ($dsct) {
            return $dsct->porcentaje_solicitado_lubricantes;
        }
        return null;
    }




    public function getNombreCliente()
    {
        // return $this->cliente->getNombreCompleto();
        return $this->nombre_cliente;
    }

    public function getCorreoCliente()
    {
        return $this->email_contacto;
    }

    public function getTelefonoCliente()
    {
        return $this->telefono_contacto;
    }

    public function getIdLocal()
    {
        return $this->usuarioRegistro->empleado->id_local;
    }
    public function getLocal()
    {
        return $this->usuarioRegistro->empleado->local->nombre_local;
    }

    public function getNombrevendedor()
    {
        $name = $this->usuarioRegistro->empleado->primer_nombre . ' ' . $this->usuarioRegistro->empleado->primer_apellido;
        return $name;
    }

    public function getFechaCreacionText()
    {
        return Carbon::parse($this->fecha_registro)->format('d/m/Y');
    }

    public function getFechaRegistroCarbon()
    {
        return Carbon::parse($this->fecha_registro);
    }

    public function esVendido()
    {
        return $this->ventasMeson->count() > 0;
    }

    public function getIdVentaMeson()
    {
        $venta = $this->ventasMeson->first();
        if (!is_null($venta)) {
            return $venta->id_venta_meson;
        }

        return null;
    }
    public function getNumeroFactura()
    {
        $venta = $this->ventasMeson->first();
        if (!is_null($venta)) {
            return $venta->nro_factura;
        }

        return null;
    }

    public function esMayoreo()
    {
        $count_mayoreo = $this->lineasCotizacionMeson->where('es_mayoreo', 1)->count();
        if ($count_mayoreo >= 1) {
            return "SI";
        }
        return "NO";
    }

    public function getFechaVentaCotizacion()
    {
        $venta = $this->ventasMeson->first();
        if (!is_null($venta)) {
            return Carbon::parse($venta->fecha_registro)->format('d/m/Y');
        }
        return null;
    }
    public function getDeletedTransactions()
    {
        $id =  $this->id_cotizacion_meson;
        $sql = "SELECT * FROM track_deleted_transactions
                where origen = 'LineaCotizacionMeson' AND id_contenedor_origen = $id";
        $results = DB::select(DB::raw($sql));
        return $results;
    }

    public function consultaEstado()
    {
        if (!$this->esVendido()) {
            if ($this->es_cerrada === 1) return 'CERRADA';
            return 'PENDIENTE';
        }

        $esFacturado = false;
        $venta = $this->ventasMeson->first();
        if ($venta) {
            if (!is_null($venta->fecha_venta) && !is_null($venta->nro_factura)) {
                $esFacturado = true;
            }
        }

        if ($esFacturado) {
            return "FACTURADO";
        }
        return 'LIQUIDADO';
    }

    public function getEstado()
    {
        if (!$this->esVendido()) {
            if ($this->es_cerrada === 1) return 'CERRADA';
            return 'PENDIENTE';
        } else {
            return 'LIQUIDADO';
        }

        $esVendido = false;
        $esFacturado = false;
        $venta = $this->ventasMeson->first();
        if (!is_null($venta ? $venta->fecha_venta : $venta) && !is_null($venta ? $venta->nro_factura : $venta)) {
            $esFacturado = true;
        } else {
            $esVendido = true;
        }
        foreach ($this->lineasCotizacionMeson as $lineaCotizacion) {
            if ($lineaCotizacion->es_atendido === 0) {
                if ($esFacturado) {
                    return 'FACTURADO - RP';
                } else {
                    return 'LIQUIDADO - RP';
                }
            }
        }
        if ($esFacturado) {
            return "FACTURADO";
        }
        return 'LIQUIDADO';
    }

    public function getCodeMoneda()
    {
        return $this->moneda == 'DOLARES' ? 'USD' : 'PEN';
    }

    public function getLinkDetalleCotizacion()
    {
        $ruta = route('meson.show', ['id_cotizacion_meson' => $this->id_cotizacion_meson]);
        return "<a class='id-link' href='$ruta' target='_blank'>$this->id_cotizacion_meson</a>";
    }

    public function getLinkDetalleCotizacion2()
    {
        $nota_venta = VentaMeson::where('id_cotizacion_meson', $this->id_cotizacion_meson)->first();
        if ($nota_venta != null) {
            $id = $nota_venta->id_venta_meson;
        } else {
            $id = "-";
        }
        $ruta = route('meson.show', ['id_cotizacion_meson' => $this->id_cotizacion_meson]);
        return "<a class='id-link' href='$ruta' target='_blank'>NV $id</a>";
    }

    public function getLinkDetalleHTML()
    {

        $dic = ['id_cotizacion_meson' => $this->id_cotizacion_meson];
        $ruta = route('meson.show', $dic);
        return "<a class='id-link' href='$ruta' target='_blank'>$this->id_cotizacion_meson</a>";
    }


    public function getLinkNotaVentaHTML()
    {

        $x = $this->getIdVentaMeson();
        $dic = ['idCotizacionMeson' => $this->id_cotizacion_meson];
        $ruta = route('meson.imprimirNotaVenta', $dic);
        return "<a class='id-link' href='$ruta' target='_blank'>$this->id_cotizacion_meson</a>";
    }

    public function contarRepuestosAsociados()
    {
        if (isset($this->arrDisponibilidades)) {
            return $this->arrDisponibilidades;
        }
        $contadorEnStock = 0;
        $contadorEnTransito = 0;
        $contadorEnImportacion = 0;
        $contadorAsignados = 0;
        foreach ($this->lineasCotizacionMeson as $lineaCotizacion) {
            $disponibilidad = $lineaCotizacion->getDisponibilidadRepuestoText();
            if ($disponibilidad == "EN IMPORTACIÓN") {
                $contadorEnImportacion++;
            } elseif ($disponibilidad == "EN TRÁNSITO" || $disponibilidad == "SIN STOCK") {
                $contadorEnTransito++;
            } elseif ($disponibilidad == "ENTREGADO") {
                $contadorAsignados++;
            } else {
                $contadorEnStock++;
            }
        }
        $this->arrDisponibilidades = array(
            'contadorEnStock' => $contadorEnStock,
            'contadorEnTransito' => $contadorEnTransito,
            'contadorEnImportacion' => $contadorEnImportacion,
            'contadorAsignados' => $contadorAsignados
        );
        return $this->arrDisponibilidades;
    }

    public function claseEstado()
    {
        $estado = $this->getEstado();
        if ($estado) {
            switch ($estado) {
                case "PENDIENTE":
                    return 'estado estado-pendiente';
                    break;
                case "FACTURADO - RP":
                    return 'estado estado-facturado';
                    break;
                case "LIQUIDADO - RP":
                    return 'estado estado-vendidoRP';
                    break;
                case "LIQUIDADO":
                    return 'estado estado-vendido';
                    break;
            }
        } else return ' ';
    }

    public function getMoneda()
    {
        return $this->moneda;
    }
    public function getTipoCambio()
    {
        return $this->tipo_cambio ? $this->tipo_cambio : TipoCambio::getTipoCambioCobroActual();
    }
    public function getLineasTransaccion()
    {
        return $this->lineasCotizacionMeson;
    }

    public function getValorCotizacion()
    {
        $lineasCotizacionMeson = $this->lineasCotizacionMeson;
        $valorTotal = 0;
        foreach ($lineasCotizacionMeson  as $row) {
            $valorTotal += ($row->getMontoUnitarioGrupo($row->getFechaRegistroCarbon(), true) * $row->cantidad);
        }
        return $valorTotal;
    }

    public function getValorCotizacionWithBrandDiscount()
    {
        $lineasCotizacionMeson = $this->lineasCotizacionMeson;
        if ($lineasCotizacionMeson == null) {
            return 1;
        }

        $valorTotal = 0;
        foreach ($lineasCotizacionMeson  as $row) {
            $amountWithBrandDiscount = $row->getMontoUnitarioGrupo($row->getFechaRegistroCarbon(), true) * (100 - $row->descuento_marca) / 100;
            $valorTotal += $amountWithBrandDiscount;
        }
        return $valorTotal;
    }

    public function getValueDiscountedQuote()
    {
        $lineasCotizacionMeson = $this->lineasCotizacionMeson;
        $valorTotal = 0;
        foreach ($lineasCotizacionMeson  as $row) {
            $valorTotal += $row->getPriceWithDiscount();
        }

        return $valorTotal;
    }

    public function getValueDiscountedQuote2()
    {
        $lineasCotizacionMeson = $this->lineasCotizacionMeson;
        $valorTotal = 0;
        foreach ($lineasCotizacionMeson  as $row) {
            $valorTotal += $row->getPriceWithDiscount() * $row->cantidad;
        }

        return $valorTotal;
    }

    public function getValueOnlyBrandDiscount()
    {
        $lineasCotizacionMeson = $this->lineasCotizacionMeson;
        $valorTotal = 0;
        foreach ($lineasCotizacionMeson  as $row) {
            if ($row->descuento_marca_aprobado == 1) {
                $valorTotal += $row->getPriceWithOnlyBrandDiscount() * $row->cantidad;
            }
        }

        return $valorTotal;
    }

    public function getValueOnlyBrandDiscountToBeApproved()
    {
        $lineasCotizacionMeson = $this->lineasCotizacionMeson;
        $valorTotal = 0;
        foreach ($lineasCotizacionMeson  as $row) {

            $valorTotal += $row->getPriceWithOnlyBrandDiscount() * $row->cantidad;
        }

        return $valorTotal;
    }



    public function getValueDiscountedQuoteToBeApproved()
    {
        $lineasCotizacionMeson = $this->lineasCotizacionMeson;
        $valorTotal = 0;
        foreach ($lineasCotizacionMeson  as $row) {
            $valorTotal += $row->getPriceWithDiscountToBeApproved() * $row->cantidad;
        }

        return $valorTotal;
    }

    public function getValueDiscountedQuote2Approved()
    {
        $lineasCotizacionMeson = $this->lineasCotizacionMeson;
        $valorTotal = 0;

        $dsctoRptos = $this->getDescuentoRptos();
        $dsctoLubricantes = $this->getDescuentoLubricantes();

        foreach ($lineasCotizacionMeson  as $row) {

            $category = $row->getNombreCategoria();

            if ($row->descuento_unitario_aprobado == 1) {

                $valorTotal += $row->getPriceWithDiscount() * $row->cantidad;
            } elseif (($row->descuento_unitario_aprobado == 0 || $row->descuento_unitario_aprobado == null) && $row->descuento_marca_aprobado == 1) {

                $valorTotal += $row->getPriceValueWithOnlyBrandDiscount() * $row->cantidad;
            } elseif ($category == "LUBRICANTES" && $row->descuento_unitario_aprobado == 0 && $dsctoLubricantes > 0) {
                $valorTotal += $row->getPriceWithDiscount() * $row->cantidad;
            } elseif ($category != "LUBRICANTES" && $row->descuento_unitario_aprobado == 0 && $dsctoRptos > 0) {
                $valorTotal += $row->getPriceWithDiscount() * $row->cantidad;
            } else {

                $valorTotal += $row->getUnitPrice() * $row->cantidad;
            }
        }

        return $valorTotal;
    }


    public function getTotalPercentajeDiscountApplied()
    {
        $totalPrice = $this->getValorCotizacion(); //Monto en soles o dolares de la cotizacion
        $totalPriceWithDiscount = $this->getValueDiscountedQuote(); //Monto en soles o dolares del monto aplicado con descuento

        $totalDiscount = ($totalPrice - $totalPriceWithDiscount);

        $percentageDiscountAccumulated = $totalDiscount / $totalPrice * 100;
        return round($percentageDiscountAccumulated, 2);
    }

    public function getItemsThatRequireDiscount()
    {
        $id = $this->id_cotizacion_meson;

        $lineasCotizacionMeson = LineaCotizacionMeson::where('id_cotizacion_meson', $id)
            ->whereNull('descuento_unitario_aprobado')->whereNotNull('descuento_unitario_dealer_por_aprobar')->where('descuento_unitario_dealer_por_aprobar', '>', 0)
            ->orWhereNull('descuento_marca_aprobado')->whereNotNull('descuento_marca')->where('descuento_marca', '>', 0)->get();
        return $lineasCotizacionMeson;
        $valorTotal = 0;
        foreach ($lineasCotizacionMeson  as $row) {
            $valorTotal += $row->getMontoUnitarioGrupo($row->getFechaRegistroCarbon(), true);
        }
        return $valorTotal;
    }

    public function getMarginTotalDealer()
    {
        $id = $this->id_cotizacion_meson;

        $lineasCotizacionMeson = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->get();

        $valorTotal = 0;
        foreach ($lineasCotizacionMeson  as $row) {
            $valorTotal += $row->unitMarginGainDealer();
        }
        return $valorTotal;
    }

    public function getDiscountRequestStatus()
    {

        $id = $this->id_cotizacion_meson;

        $quantityItemsThatRequiredDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->whereNull('descuento_unitario_aprobado')->whereNotNull('descuento_unitario_dealer_por_aprobar')->where('descuento_unitario_dealer_por_aprobar', '>', 0)->count();
        $quantityItemsWithApprovedDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->where('descuento_unitario_aprobado', 1)->whereNotNull('descuento_unitario')->where('descuento_unitario', '>', 0)->count();
        $quantityItemsWithDisapprovedDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->where('descuento_unitario_aprobado', 0)->whereNotNull('descuento_unitario')->where('descuento_unitario', '>', 0)->count();

        $quantityItemsThatRequiredBrandDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->whereNull('descuento_marca_aprobado')->whereNotNull('descuento_marca')->where('descuento_marca', '>', 0)->count();
        $quantityItemsWithApprovedBrandDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->where('descuento_marca_aprobado', 1)->whereNotNull('descuento_marca')->where('descuento_marca', '>', 0)->count();
        $quantityItemsWithDisapprovedBrandDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->where('descuento_marca_aprobado', 0)->whereNotNull('descuento_marca')->where('descuento_marca', '>', 0)->count();


        if (($quantityItemsThatRequiredDiscount) > 0) {
            return 'SOLICITUD DE DESCUENTO EN PROCESO';
        } else if (($quantityItemsWithApprovedDiscount) > 0) {
            return 'SOLICITUD DE DESCUENTO APROBADA';
        } else if (($quantityItemsWithDisapprovedDiscount + $quantityItemsWithDisapprovedBrandDiscount) > 0) {
            return 'SOLICITUD DE DESCUENTOS RECHAZADA';
        } else {
            //No se ha solicitado descuento
            return null;
        }
    }
    public function isVisibleMessageDiscountRequest()
    {
        $id = $this->id_cotizacion_meson;
        $last_cotizacion = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->orderBy('fecha_registro_aprobacion_rechazo_descuento', 'desc')->first();
        if ($last_cotizacion == null) {
            return false;
        }

        $today = Carbon::now();
        $last_time = Carbon::parse($last_cotizacion->fecha_registro_aprobacion_rechazo_descuento);
        if ($today->diffInHours($last_time) > 1) {
            return false;
        } else {
            return true;
        }
    }
    public function getColorAlertDiscountRequestStatus()
    {

        $id = $this->id_cotizacion_meson;

        $quantityItemsThatRequiredDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->whereNull('descuento_unitario_aprobado')->whereNotNull('descuento_unitario_dealer_por_aprobar')->where('descuento_unitario_dealer_por_aprobar', '>', 0)->count();
        $quantityItemsWithApprovedDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->where('descuento_unitario_aprobado', 1)->whereNotNull('descuento_unitario')->where('descuento_unitario', '>', 0)->count();
        $quantityItemsWithDisapprovedDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->where('descuento_unitario_aprobado', 0)->whereNotNull('descuento_unitario')->where('descuento_unitario', '>', 0)->count();

        $quantityItemsThatRequiredBrandDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->whereNull('descuento_marca_aprobado')->whereNotNull('descuento_marca')->where('descuento_marca', '>', 0)->count();
        $quantityItemsWithApprovedBrandDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->where('descuento_marca_aprobado', 1)->whereNotNull('descuento_marca')->where('descuento_marca', '>', 0)->count();
        $quantityItemsWithDisapprovedBrandDiscount = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->where('descuento_marca_aprobado', 0)->whereNotNull('descuento_marca')->where('descuento_marca', '>', 0)->count();


        if (($quantityItemsThatRequiredDiscount + $quantityItemsThatRequiredBrandDiscount) > 0) {
            return "alert alert-warning";
        } else if (($quantityItemsWithApprovedDiscount + $quantityItemsWithApprovedBrandDiscount) > 0) {
            return "alert alert-success";
        } else if (($quantityItemsWithDisapprovedDiscount + $quantityItemsWithDisapprovedBrandDiscount) > 0) {
            return 'alert alert-danger';
        } else {
            //No se ha solicitado descuento
            return null;
        }
    }

    public function gotBrandDiscountLast()
    {
        $id = $this->id_cotizacion_meson;
        $lineas = LineaCotizacionMeson::where('id_cotizacion_meson', $id)->get();

        foreach ($lineas as $row) {
            if ($row->descuento_marca != null) {
                return true;
            }
        }
        return false;
    }
}
