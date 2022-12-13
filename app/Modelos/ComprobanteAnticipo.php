<?php

namespace App\Modelos;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ComprobanteAnticipo extends Model
{
    protected $table = "comprobante_anticipo";
    protected $fillable = ['id_comprobante_anticipo', 'tipo_comprobante', 'serie', 'nro_comprobante', 'nrodoc_cliente', 'nombre_cliente', 'direccion_cliente', 'fecha_emision', 'fecha_registro', 'formato_impresion', 'tasa_detraccion', 'id_detraccion', 'total_descuento', 'total_venta', 'monto_sujeto_igv', 'monto_inafecto', 'monto_exonerado', 'total_igv', 'url_pdf', 'sale_id', 'id_recepcion_ot', 'id_cotizacion_meson', 'tipo_operacion', 'tipo_venta', 'observaciones', 'condicion_pago', 'fecha_vencimiento', 'id_comprobante_venta', 'moneda', 'email', 'telefono', 'tipo_cambio'];
    protected $primaryKey = 'id_comprobante_anticipo';

    protected $dates = ['fecha_emision', 'fecha_vencimiento', 'fecha_registro'];

    public $timestamps = false;

    public function lineaComprobanteAnticipo() {
        return $this->hasOne('App\Modelos\LineaComprobanteAnticipo', 'id_comprobante_anticipo');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Modelos\Usuario', 'id_usuario_registro');
    }

    public function metodoPago() {
        return $this->belongsTo('App\Modelos\PagoMetodo', 'id_pago_metodo');
    }

    public function entidadFinanciera(){
        return $this->belongsTo('App\Modelos\Parametro', 'id_entidad_financiera');
    }

    public function tipoTarjeta(){
        return $this->belongsTo('App\Modelos\Parametro', 'id_tipo_tarjeta');
    }

    public function nroFactura()
    {
        $numFactura = $this->serie . '-' . $this->nro_comprobante;
        return $numFactura;
    }

    public function usuarioNombre()
    {
        return $this->usuario->empleado->nombreCompleto();
    }

    public function getLocal()
    {
        return 'Los Olivos';
    }

    public function recepcion() {
        return $this->belongsTo('App\Modelos\RecepcionOT', 'id_recepcion_ot');
    }

    public function cotizacionMeson() {
        return $this->belongsTo('App\Modelos\CotizacionMeson', 'id_cotizacion_meson');
    }

    public function getCentroCosto()
    {
        $serie = substr($this->serie,1);
        $serie = $serie;
        switch ($serie) {
            case '001':
                return '001 - Taller';
            case '002':
                return '002 - Ventas';
            case '003':
                return '003 - P&P';
            case '004':
                return '004 - Repuestos';
            case '005':
                return '005 - Ventas Plaza Norte';
        }

    }

    public function getEstado(){
        return $this->estado;
    }

    public function getLinkDetalleHTML()
    {
        $ruta = $this->url_pdf ?? false;
        $link = '-';
        if($ruta) {
            $numFactura = $this->serie . '-' . $this->nro_comprobante;
            $link = "<a class='id-link' href='$ruta' target='_blank'>$numFactura</a>";
        } 
        
        return $link;
    }

    public function getLinkNotaEntregaHTML()
    {
        $ruta = $this->url_entrega ?? false;
        $link = '-';
        if ($ruta) $link = "<a class='id-link' href='$ruta' target='_blank'>Descargue la Nota de entrega</a>";
        return $link;
    }

    public function getLinkConstanciaHTML()
    {
        $ruta = $this->url_constancia ?? false;        
        $link = '-';
        if ($ruta) $link = "<a class='id-link' href='$ruta' target='_blank'>Descargue la Constancia de entrega</a>";
        return $link;
    }

    public function docReferencia($es_link = true)
    {
        $link = 'otros';
        if($this->id_venta_meson!=null){
            $link = $this->ventasMeson ? $this->ventasMeson->getLinkDetalleHTML($es_link) : '-';
        }
     
        if($this->id_recepcion_ot!=null){
            $link = $this->recepcion ? $this->recepcion->getLinkDetalleHTML2($es_link) : '-';
        }
        
        return $link;
    }

    public function getFecha(){
        return Carbon::parse($this->fecha_emision)->format('d/m/Y');
    }
}
