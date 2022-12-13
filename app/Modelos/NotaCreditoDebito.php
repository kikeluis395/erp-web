<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class NotaCreditoDebito extends Model
{
    protected $table = "nota_credito_debito";

    protected $primaryKey = "id_nota_credito_debito";

    protected $dates = ['fecha_emision', 'fecha_vencimiento'];

    public function usuario()
    {
        return $this->belongsTo('App\Modelos\Usuario', 'id_usuario_registro');
    }

    public function getLinkDetalleHTML()
    {
        $ruc = '20606257261';
        $tipo = '07';
        if($this->tipo_documento == 'ND'){
            $tipo = '08';
        }
        $ruta = "https://app.sibi.pe/pdf/vouchers/".$ruc.'/'.$tipo.'/' . $this->id_sibi_credit_notes;
        $documento = $this->tipo_documento . ' ' . $this->serie . '-' . $this->num_doc;
        return "<a class='id-link' href='$ruta' target='_blank'>$documento</a>";
    }

    public function movimientoRepuesto()
    {
        return $this->morphMany(MovimientoRepuesto::class, 'fuente');
    }

    public function comprobanteVenta()
    {
        return $this->belongsTo('App\Modelos\ComprobanteVenta','id_comprobante_venta');
    }

    public function comprobanteAnticipo()
    {
        return $this->belongsTo('App\Modelos\ComprobanteAnticipo','id_comprobante_anticipo');
    }

    public function fuente()
    {
        return 'NOTA CREDITO';
    }

    public function idFuente()
    {
        return $this->doc_referencia;
    }

    public function nroFactura()
    {
        $numFactura = $this->tipo_documento.' '.$this->serie . '-' . $this->num_doc;
        return $numFactura;
    }

    public function motivo()
    {
        return 'INGRESO';
    }

    public function usuarioNombre()
    {
        return $this->usuario->empleado->nombreCompleto();
    }

    public function getLocal()
    {
        return 'Los Olivos';
    }

    public function getCentroCosto()
    {
        $serie = $this->serie;
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

    public function getNombreCliente(){
        if($this->id_comprobante_venta!=null){
            return $this->comprobanteVenta->nombre_cliente;
        }
        if($this->id_comprobante_anticipo!=null){
            return $this->comprobanteAnticipo->nombre_cliente;
        }
        return '';
        
    }

    public function getDocCliente(){
        if($this->id_comprobante_venta!=null){
            return $this->comprobanteVenta->numdoc_cliente;
        }
        if($this->id_comprobante_anticipo!=null){
            return $this->comprobanteAnticipo->numdoc_cliente;
        }
        return '';
        
    }

    public function getFecha(){
        return Carbon::parse($this->created_at)->format('d/m/Y');
    }

}
