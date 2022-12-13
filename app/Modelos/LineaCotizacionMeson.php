<?php

namespace App\Modelos;

use Carbon\Carbon;
use App\Modelos\DescuentoMeson;
use App\Modelos\Internos\LineaTransaccionMonetaria;
use DateTime;
use App\Modelos\MovimientoRepuesto;
use App\Modelos\ComprobanteVenta;

class LineaCotizacionMeson extends LineaTransaccionMonetaria
{
    //
    protected $table = "linea_cotizacion_meson";
    protected $fillable = [];
    protected $primaryKey = 'id_linea_cotizacion_meson';

    public $timestamps = false;

    public function cotizacionMeson()
    {
        return $this->belongsTo('App\Modelos\CotizacionMeson', 'id_cotizacion_meson');
    }

    public function movimientoSalida()
    {
        return $this->belongsTo('App\Modelos\MovimientoRepuesto', 'id_movimiento_salida');
    }

    public function movimientoSalidaVirtual()
    {
        return $this->belongsTo('App\Modelos\MovimientoRepuesto', 'id_movimiento_salida_virtual');
    }

    public function repuesto()
    {
        return $this->belongsTo('App\Modelos\Repuesto', 'id_repuesto');
    }

    public function getCodigoRepuesto()
    {
        return $this->repuesto->codigo_repuesto;
    }

    public function getUbicacionRepuesto()
    {
        return $this->repuesto->ubicacion;
    }

    public function getDescripcionRepuesto()
    {
        return $this->repuesto->descripcion;
    }

    public function getNombreCategoria()
    {
        return $this->repuesto->getNombreCategoria();
    }

    public function getCantidadRepuesto()
    {
        return $this->cantidad;
    }

    public function getUnidadesRepuesto()
    {
        return $this->repuesto->unidad_medida;
    }

    public function getDescuentoMarca()
    {
        $in = $this->descuento_marca;
        if (!is_null($in)) return $in;
        return "0";
    }


    public function getDisponibilidadRepuestoText()
    {
        if ($this->es_entregado) {
            return 'ENTREGADO';
        } elseif ($this->es_atendido) {
            //Si está dentro de este bloque es porque la cotización ya fue vendida y además se reservó el stock
            return 'RESERVADO';
        }
        $idLocal = $this->cotizacionMeson->getIdLocal();
        $cantidad = $this->getCantidadRepuesto();
        $stockVirtual = $this->repuesto->getStockVirtual($idLocal);

        if ($cantidad <= $stockVirtual) //No se reservó el stock pero puede hacerlo
            return "EN STOCK ($stockVirtual)";
        elseif ($this->es_importado == 1) //No hay stock y se seleccionó en importación
            return 'EN IMPORTACIÓN';
        elseif ($this->es_importado === 0) //No hay stock y se seleccionó en tránsito
            return 'EN TRÁNSITO';
        else                           //No hay stock y la linea fue creada antes de los cambios actuales, se asume en tránsito 
            return 'SIN STOCK';
    }

    public function getDisponibilidadFacturacion()
    {

        $idLocal = $this->cotizacionMeson->getIdLocal();
        $cantidad = $this->getCantidadRepuesto();
        $stockVirtual = $this->repuesto->getStockVirtual($idLocal);
        
        if($cantidad <= $stockVirtual) //No se reservó el stock pero puede hacerlo
            return "EN STOCK ($stockVirtual)";
        elseif($this->es_importado==1) //No hay stock y se seleccionó en importación
            return 'EN IMPORTACIÓN';
        elseif($this->es_importado === 0) //No hay stock y se seleccionó en tránsito
            return 'EN TRÁNSITO';
        else                           //No hay stock y la linea fue creada antes de los cambios actuales, se asume en tránsito 
            return 'SIN STOCK';
        
    }

    public function getDisponibilidadNotaVenta()
    {
        $disponibilidad = $this->getDisponibilidadRepuestoText();
        if (in_array($disponibilidad, ['EN IMPORTACIÓN'])) {
            return 'EN IMPORTACIÓN';
        } elseif (in_array($disponibilidad, ['EN TRÁNSITO', 'SIN STOCK'])) {
            return 'EN TRÁNSITO';
        } elseif (in_array($disponibilidad, ['RESERVADO'])) {
            return 'EN STOCK';
        } else {
            return 'EN STOCK';
        }
    }

    public function hayStock()
    {
        $idLocal = $this->cotizacionMeson->getIdLocal();
        //tomar la decision de cambiarlo o seguir con esta linea
        $stockComparacion = $this->es_importado === null ? $this->repuesto->getStock($idLocal) : $this->repuesto->getStockVirtual($idLocal);
        if ($this->cantidad <= $stockComparacion) {
            return true;
        }
        return false;
    }

    public function getFechaPedidoFormat()
    {
        return $this->fecha_pedido ? Carbon::parse($this->fecha_pedido)->format('d/m/Y') : '';
    }

    public function getFechaPromesaFormat()
    {
        return $this->fecha_promesa ? Carbon::parse($this->fecha_promesa)->format('d/m/Y') : '';
    }

    public function getMoneda()
    {
        return $this->cotizacionMeson->getMoneda();
    }
    public function getItemTransaccion()
    {
        return $this->repuesto;
    }
    public function getTasaDescuento()
    {
        $descuento = $this->cotizacionMeson->descuentos()->where('es_aprobado', 1)->orderBy('fecha_registro', 'desc')->first();
        if (!$descuento) return 0;
        $tasaDescuento = $this->repuesto->esLubricante() ? $descuento->porcentaje_solicitado_lubricantes / 100 : $descuento->porcentaje_solicitado_rptos / 100;
        return $tasaDescuento;
    }
    public function getTipoCambio()
    {
        return $this->cotizacionMeson->getTipoCambio();
    }

    public function getFechaRegistroCarbon()
    {
        if ($this->fecha_registro != null) $fecha = Carbon::parse($this->fecha_registro);
        else $fecha = $this->cotizacionMeson->getFechaRegistroCarbon();
        return $fecha;
    }

    public function getMontoUnitario(Carbon $fechaConsulta, $considerarIGV)
    {
        //Parametros solo usados si no es mayoreo
        if ($this->es_mayoreo) {
            //Mayoreo siempre incluye igv
            $tasaIGV = config('app.tasa_igv');
           
            $monto = $this->getItemTransaccion() ? $this->getItemTransaccion()->getPrecioMayoreo($this->getFechaRegistroCarbon()) : 0;
            $monedaInicial = $this->getItemTransaccion() ? $this->getItemTransaccion()->getMonedaAuxiliar() : $this->getMoneda();
            $monedaObjetivo = $this->getMoneda();
            
            if ($monedaInicial != $monedaObjetivo) {
                $cambio = $this->getTipoCambio();
                if($monedaObjetivo == "DOLARES"){
                    $monto =  $monto / $cambio;
                }else{
                    
                    $monto = $monto * $cambio;
                    
                }
                
            
            }
            $monto = $considerarIGV ? $monto : $monto / (1 + $tasaIGV);
            return $monto;
        } else {
            return parent::getMontoUnitario($fechaConsulta, $considerarIGV);
        }
    }

    public function esGrupo()
    {
        return $this->es_grupo ? true : false;
    }

    //Obtiene la cantidad de unidades minimos del itemNecesidadRepuestos
    public function getCantidad()
    {
        $cantidad = $this->getCantidadGrupo();
        if ($this->esGrupo()) $cantidad = $cantidad * $this->getItemTransaccion()->getCantidadUnidadesGrupo();
        return $cantidad;
    }

    //Obtiene la cantidad de grupos del itemNecesidadRepuestos
    public function getCantidadGrupo()
    {
        return $this->cantidad;
    }

    public function getMontoUnitarioGrupo(Carbon $fechaConsulta, $considerarIGV)
    {
        $montoUnidadMinima = $this->getMontoUnitario($fechaConsulta, $considerarIGV);
        $monto = $montoUnidadMinima * $this->getItemTransaccion()->getCantidadUnidadesGrupo();
        return $monto;
    }

    public function getDescuentoUnitarioGrupo(Carbon $fechaConsulta, $considerarIGV)
    {
        $descuentoUnitarioUnidadMinima = parent::getDescuentoUnitario($fechaConsulta, $considerarIGV);
        $descuento = $descuentoUnitarioUnidadMinima * $this->getItemTransaccion()->getCantidadUnidadesGrupo();
        return $descuento;
    }

    public function getTotalDiscountOnlyBrand()
    {
        $dsct_marca = $this->descuento_marca / 100;

        return $dsct_marca;
    }

    public function getTotalDiscount()
    {

        $category = $this->getNombreCategoria();

        if ($category == "LUBRICANTES") {

            $dscto_global = $this->cotizacionMeson->getDescuentoLubricantes() != null ? $this->cotizacionMeson->getDescuentoLubricantes() : 0;
        } else {
            $dscto_global = $this->cotizacionMeson->getDescuentoRptos() != null ? $this->cotizacionMeson->getDescuentoRptos() : 0;
        }


        $dsct_marca = $this->descuento_marca / 100;
        $dsct_unitario = $this->descuento_unitario / 100;
        $total = ($dsct_marca + $dsct_unitario) - ($dsct_marca * $dsct_unitario);
        if ($total == 0 && $dscto_global > 0) {
            return $dscto_global;
        }
        return $total * 100;
    }

    public function getTotalDiscountToBeApproved()
    {

        $category = $this->getNombreCategoria();

        if ($category == "LUBRICANTES") {

            $dscto_global = $this->cotizacionMeson->getDescuentoLubricantes() != null ? $this->cotizacionMeson->getDescuentoLubricantes() : 0;
        } else {
            $dscto_global = $this->cotizacionMeson->getDescuentoRptos() != null ? $this->cotizacionMeson->getDescuentoRptos() : 0;
        }


        $dsct_marca = $this->descuento_marca / 100;
        $dsct_unitario = $this->descuento_unitario_dealer_por_aprobar / 100;
        $total = ($dsct_marca + $dsct_unitario) - ($dsct_marca * $dsct_unitario);
        if ($total == 0 && $dscto_global > 0) {
            return $dscto_global;
        }
        return $total * 100;
    }


    public function getPriceWithDiscount()
    {
        $dsct_total = (100 - $this->getTotalDiscount()) / 100;
        $monto = $this->getMontoUnitarioGrupo($this->getFechaRegistroCarbon(), true);

        return $monto * $dsct_total;
    }

    public function getPriceWithOnlyBrandDiscount()
    {
        $dsct_total = $this->getTotalDiscountOnlyBrand();
        $monto = $this->getMontoUnitarioGrupo($this->getFechaRegistroCarbon(), true);

        return $monto * $dsct_total;
    }

    public function getPriceValueWithOnlyBrandDiscount()
    {
        $dsct_total = 1 - $this->getTotalDiscountOnlyBrand();
        $monto = $this->getMontoUnitarioGrupo($this->getFechaRegistroCarbon(), true);

        return $monto * $dsct_total;
    }

    public function getPriceWithDiscountToBeApproved()
    {
        $dsct_total = (100 - $this->getTotalDiscountToBeApproved()) / 100;
        $monto = $this->getMontoUnitarioGrupo($this->getFechaRegistroCarbon(), true);

        return $monto * $dsct_total;
    }

    public function getUnitPrice()
    {
        return $this->getMontoUnitarioGrupo($this->getFechaRegistroCarbon(), true);
    }

    public function getTotalWithDiscount()
    {
        return round(($this->getMontoUnitarioGrupo($this->getFechaRegistroCarbon(), true) - $this->getApplicableDiscount()) * $this->cantidad, 2);
    }

    public function getTotalWithOutDiscount(){
        return round(($this->getMontoUnitarioGrupo($this->getFechaRegistroCarbon(),true))*$this->cantidad,2);
    }
    //return in money 
    public function getApplicableDiscount()
    {

        $monto = $this->getMontoUnitarioGrupo($this->getFechaRegistroCarbon(), true);
        $category = $this->getNombreCategoria();

        if ($category == "LUBRICANTES") {

            $dscto_global = $this->cotizacionMeson->getDescuentoLubricantes() != null ? $this->cotizacionMeson->getDescuentoLubricantes() : 0;
        } else {
            $dscto_global = $this->cotizacionMeson->getDescuentoRptos() != null ? $this->cotizacionMeson->getDescuentoRptos() : 0;
        }

        if ($this->descuento_unitario_aprobado == 1 && $this->descuento_marca_aprobado == 1) {
            $dsct_total = $this->getTotalDiscount() / 100;


            return $monto * $dsct_total;
        } else if ($this->descuento_unitario_aprobado == 1) {
            $dsct_unitario = $this->descuento_unitario / 100;
            return $monto * $dsct_unitario;
        } else if ($this->descuento_marca_aprobado == 1) {
            $dsct_marca = $this->descuento_marca / 100;
            return $monto * $dsct_marca;
        } else if ($dscto_global > 0) {
            return $monto * $dscto_global / 100;
        } else {
            return 0;
        }
    }

    public function unitPercentageMarginGainDealer()
    {
        if ($this->margen == null) {
            $marginDealerExpected = $this->repuesto->margen / 100;
        } else {
            $marginDealerExpected = $this->margen / 100;
        }


        $dsct_unitario = $this->descuento_unitario;
        if ($dsct_unitario == 100) {
            $dsct_unitario = 0;
        }
        return round(1 - (1 - $marginDealerExpected) / (1 - ($dsct_unitario / 100)), 2) * 100;
    }

    public function unitMarginGainDealer()
    {
        $monto = $this->getMontoUnitarioGrupo($this->getFechaRegistroCarbon(), true);
        $priceWithBrandDiscount = (100 - $this->descuento_marca) / 100 * $monto;
        $percentageDealer = $this->unitPercentageMarginGainDealer() / 100;
        return round($priceWithBrandDiscount * $percentageDealer, 2);
    }

    public function getClassPerSpareType()
    {
        if ($this->repuesto->esLubricante()) {
            return "form-control descuento-lubricante";
        } else {
            return "form-control descuento-repuesto";
        }
    }

    public function movimientoRepuesto()
    {
        return $this->morphOne(MovimientoRepuesto::class, 'fuente');
    }

    public function fuente()
    {
        return 'MESON';
    }

    public function idFuente()
    {
        if($this->cotizacionMeson->ventasMeson->first() == null){
            return 'Anulada por NC';
        }
        return $this->cotizacionMeson->ventasMeson->first()->id_venta_meson;
    }

    public function nroFactura()
    {
        if($this->cotizacionMeson->ventasMeson->first()==null){
            return 'Anulada por NC';
        }
        return $this->cotizacionMeson->ventasMeson->first()->nro_factura;
    }

    public function motivo()
    {
        return 'EGRESO';
    }

    public function usuarioNombre()
    {
        return $this->cotizacionMeson->getNombrevendedor();
    }



    public function getVentaConDscto($considerarIGV = false)
    {
        #Obtengo la moneda para validar si usamos el tipo de cambio o no
        $moneda = $this->cotizacionMeson->moneda;

        #Obtengo el tipo de cambio
        $tipo_cambio = $this->cotizacionMeson->tipo_cambio;

        #cantidad facturada
        $cantidad = $this->cantidad;

        #Obtenemos el precio de la tabla precio_repuestos, en caso de no tenerlo, obtenemos el pvp de la tabla repuestos
        $pvp = $cantidad * ($this->repuesto->getPrecio($this->getFechaRegistroCarbon()) ? $this->repuesto->getPrecio($this->getFechaRegistroCarbon())->monto : $this->repuesto->getPrecioAuxiliar());

        #Después de obtener el precio le sacamos el IGV en caso se requiera
        $pvp = $considerarIGV ? $pvp : $pvp / 1.18;

        #Obtenemos el costo_no_igv para el descuento de marca
        $costo_no_igv = $cantidad * ($this->repuesto->costo_no_igv ?? 0);

        #Obtenemos el porcentaje para el descuento de marca
        $descuento_marca_porc = $this->descuento_marca >= 0 ? $this->descuento_marca : 0;

        #Obtenemos el porcentaje para el descuento de dealer
        $descuento_dealer_porc = $this->descuento_unitario >= 0 ? $this->descuento_unitario : ($this->repuesto->esLubricante() ? $this->cotizacionMeson->getDescuentoLubricantes() : $this->cotizacionMeson->getDescuentoRptos());

        #calculamos los descuento respectivos
        $descuento_marca = $costo_no_igv * ($descuento_marca_porc / 100);
        $descuento_dealer = $pvp * (1 - ($descuento_marca_porc / 100)) * ($descuento_dealer_porc / 100);
        $descuento_total = $descuento_marca + $descuento_dealer;

        $venta_con_dscto = $pvp - $descuento_total;

        return $moneda == 'SOLES' ? $venta_con_dscto * $tipo_cambio : $venta_con_dscto;
    }

    public function daysWithoutMovement(){
        $ultimoMovimiento = MovimientoRepuesto::where('id_repuesto', $this->id_repuesto)->where('tipo_movimiento','!=','EGRESO VIRTUAL')->orderBy('fecha_movimiento', 'desc')->first();
        $date = Carbon::now()->format('Y-m-d H:i:s');
        $date= new DateTime($date);
        
        $diasSinMovimiento = $ultimoMovimiento!= null ?$date->diff(new DateTime($ultimoMovimiento->fecha_movimiento))->days: '-';
        return $diasSinMovimiento;
    }
}
