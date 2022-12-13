<?php

namespace App\Modelos;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;


    protected $table = "usuario";

    private $permisos = null;
    /**
     * The attributes that are mass assignable.
     *id,name,email,pass,type
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'id_rol',
        'dni',
        'habilitado'
    ];
    protected $primaryKey = 'id_usuario';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function rol()
    {
        return $this->belongsTo('App\Modelos\Rol', 'id_rol');
    }

    public function empleado()
    {
        return $this->belongsTo('App\Modelos\Empleado', 'dni');
    }

    public function puedeEditarDetalleTrabajo()
    {
        // return in_array($this->id_rol, [1, 2, 3, 6, 8, 9]);
        return in_array($this->rol->nombre_interno, ['asesor_servicios', 'jefe_taller', 'administrador']);
        // return true;
    }

    public function ordenesCompraRegistrados()
    {
        return $this->hasMany('App\Modelos\OrdenCompra', 'id_usuario_registro');
    }

    public function ordenesCompraAprobados()
    {
        return $this->hasMany('App\Modelos\OrdenCompra', 'id_usuario_aprobador');
    }

    public function notasIngresoRegistrados()
    {
        return $this->hasMany('App\Modelos\NotaIngreso', 'id_usuario_registro', 'id_usuario');
    }
    //
    public function comprobante_anticipo()
    {
        return $this->hasMany('App\Modelos\ComprobanteAnticipo', 'id_usuario_registro', 'id_usuario');
    }
    public function comprobante_venta()
    {
        return $this->hasMany('App\Modelos\ComprobanteVenta', 'id_usuario_registro', 'id_usuario');
    }
    public function cotizacion_meson()
    {
        return $this->hasMany('App\Modelos\CotizacionMeson', 'id_usuario_registro', 'id_usuario');
    }
    public function criterio_danho()
    {
        return $this->hasMany('App\Modelos\Administracion\CriterioDanho', 'id_usuario');
    }
    public function devoluciones()
    {
        return $this->hasMany('App\Modelos\Devolucion', 'id_usuario');
    }
    public function factura_compra()
    {
        return $this->hasMany('App\Modelos\FacturaCompra', 'id_usuario_registro', 'id_usuario');
    }
    public function hoja_inspeccion_savar()
    {
        return $this->hasMany('App\Modelos\HojaInspeccion', 'id_usuario_savar', 'id_usuario');
    }
    public function hoja_inspeccion_dealer()
    {
        return $this->hasMany('App\Modelos\HojaInspeccion', 'id_usuario_dealer', 'id_usuario');
    }
    public function nota_credito_debito()
    {
        return $this->hasMany('App\Modelos\NotaCreditoDebito', 'id_usuario_registro', 'id_usuario');
    }
    public function orden_servicio()
    {
        return $this->hasMany('App\Modelos\OrdenServicio', 'id_usuario_registro', 'id_usuario');
    }
    public function parametros_creador()
    {
        return $this->hasMany('App\Modelos\Parametro', 'creado_por', 'id_usuario');
    }
    public function parametros_editor()
    {
        return $this->hasMany('App\Modelos\Parametro', 'editado_por', 'id_usuario');
    }
    public function reingreso_repuestos()
    {
        return $this->hasMany('App\Modelos\ReingresoRepuestos', 'usuario_registro', 'id_usuario');
    }
    public function servicio_tercero_creador()
    {
        return $this->hasMany('App\Modelos\ServicioTercero', 'creado_por', 'id_usuario');
    }
    public function servicio_tercero_editor()
    {
        return $this->hasMany('App\Modelos\ServicioTercero', 'editado_por', 'id_usuario');
    }
    public function servicio_tercero_solicitado()
    {
        return $this->hasMany('App\Modelos\ServicioTerceroSolicitado', 'id_usuario_registro', 'id_usuario');
    }
    public function track_deleted_transactions()
    {
        return $this->hasMany('App\Modelos\TrackDeletedTransactions', 'id_usuario_eliminador', 'id_usuario');
    }
    public function valuacion()
    {
        return $this->hasMany('App\Modelos\Valuacion', 'id_usuario_valuador', 'id_usuario');
    }
    public function vehiculo_nuevo_creador()
    {
        return $this->hasMany('App\Modelos\VehiculoNuevo', 'id_usuario_registro', 'id_usuario');
    }
    public function vehiculo_nuevo_editor()
    {
        return $this->hasMany('App\Modelos\VehiculoNuevo', 'id_usuario_modifico', 'id_usuario');
    }

    public function accesos_citas()
    {
        return $this->hasMany('App\Modelos\Administracion\AccesoCitas', 'id_usuario', 'id_usuario');
    }

    public function tienePermiso($nombreInterno)
    {
        if (is_null($this->permisos)) {
            $permisos_rol_principal = $this->rol->obtenerNombresInternosPermisos();

            $roles_adicionales = $this->roles_adicionales;
            $permisos_adicionales = [];
            if (!is_null($roles_adicionales)) {
                $roles_adicionales = json_decode($roles_adicionales);
                foreach ($roles_adicionales as $rol_adicional) {
                    $rol = Rol::find($rol_adicional);
                    if ($rol) $permisos_adicionales = array_merge($permisos_adicionales, $rol->obtenerNombresInternosPermisos());
                }
            }
            $this->permisos = array_unique(array_merge($permisos_adicionales, $permisos_rol_principal));
        }
        if (in_array($nombreInterno, $this->permisos)) {
            return true;
        }
        return false;
    }

    public function hasRelation()
    {
        $suposs = [
            $this->comprobante_anticipo,
            $this->comprobante_venta,
            $this->cotizacion_meson,
            $this->criterio_danho,
            $this->devoluciones,
            $this->factura_compra,
            $this->hoja_inspeccion_savar,
            $this->hoja_inspeccion_dealer,
            $this->nota_credito_debito,
            $this->ordenesCompraRegistrados,
            $this->ordenesCompraAprobados,
            $this->notasIngresoRegistrados,
            $this->orden_servicio,
            $this->parametros_creador,
            $this->parametros_editor,
            $this->reingreso_repuestos,
            $this->servicio_tercero_creador,
            $this->servicio_tercero_editor,
            $this->servicio_tercero_solicitado,
            $this->track_deleted_transactions,
            $this->valuacion,
            $this->vehiculo_nuevo_creador,
            $this->vehiculo_nuevo_editor
        ];

        $sum = 0;
        foreach ($suposs as $sec) {
            $sum += count($sec);
        }
        return $sum > 0;
        // return response()->json(['sum' => $sum]);
    }
    public function accesoCitas()
    {
        return in_array($this->rol->nombre_interno, ["administrador", "asistente_posventa"]);
    }
}
