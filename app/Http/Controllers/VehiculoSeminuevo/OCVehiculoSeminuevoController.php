<?php

namespace App\Http\Controllers\VehiculoSeminuevo;

use App\Http\Controllers\Controller;
use App\Modelos\Cliente;
use App\Modelos\Empleado;
use App\Modelos\LineaOrdenCompra;
use App\Modelos\LocalEmpresa;
use App\Modelos\MarcaAuto;
use App\Modelos\MarcaAutoSeminuevo;
use App\Modelos\OrdenCompra;
use App\Modelos\Parametro;
use App\Modelos\Ubigeo;
use App\Modelos\VehiculoNuevo;
use App\Modelos\VehiculoSeminuevo;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OCVehiculoSemiNuevoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        $listaMotivosOC = Parametro::where('valor2', 'MOTIVO OC SEMINUEVO')->get();
        $listaAlmacen = Parametro::where('valor3', 'VEHICULO SEMINUEVO')->first();
        $listaDocumentos = Parametro::where('valor2', 'TIPO DOCUMENTO')->get();
        $localEmpresa = LocalEmpresa::first();
        $departamentos = Ubigeo::departamentos();
        $marcas_seminuevos = MarcaAutoSeminuevo::get();

        return view('vehiculoSeminuevo/ordenCompraSeminuevo', [
            'oc_nueva' => $id,
            'marcas_seminuevos' => $marcas_seminuevos,
            'listaDocumentos' => $listaDocumentos,
            'listaAlmacenes' => $listaAlmacen,
            'listaDocumentos' => $listaDocumentos,
            'listaMotivosOC' => $listaMotivosOC,
            'empresa' => $localEmpresa->nombre_empresa,
            'sucursal' => $localEmpresa->nombre_local,
            'almacen' => $listaAlmacen->valor1,
            'documento_oc' => 'OC-2021-',
            'fecha_emision' => CARBON::now(),
            'moneda' => '',
            'estado' => '',
            'usuario_creador' => '',
            'motivo' => '',
            'detalle_motivo' => '',
            'tipo_documento_transfiriente' => '',
            'documento_transfiriente' => '',
            'nombre_transfiriente' => '',
            'apellido_paterno_transfiriente' => '',
            'apellido_materno_transfiriente' => '',
            'representante_legal' => '',
            'documento_representante_legal' => '',
            'nombres_representante_legal' => '',
            'apellido_paterno_representante_legal' => '',
            'apellido_materno_representante_legal' => '',
            'direccion' => '',
            'departamento' => '',
            'ciudad' => '',
            'distrito' => '',
            'contacto' => '',
            'email' => '',
            'telefono' => '',
            // datos del vehiculo

            'placa' => '',
            'vin' => '',
            'motor' => '',
            'anho_fabricacion' => '',
            'anho_modelo' => '',
            'marca' => '',
            'modelo' => '',
            'version' => '',
            'kilometraje' => '',
            'color' => '',
            'combustible' => '',
            'cilindrada' => '',
            'transmision' => '',
            'traccion' => '',
            'nombres' => '',
            'observaciones' => '',
            'precio' => '',

            'edited' => true,
            'id_oc' => null,
            'estadoN'=> '',

            'listaDepartamentos' => $departamentos,
            'listaProvincias' => [],
            'listaDistritos' => [],

        ]);
    }

    public function create()
    {
        $listaMotivosOC = Parametro::where('valor2', 'MOTIVO OC SEMINUEVO')->get();
        $listaAlmacen = Parametro::where('valor3', 'VEHICULO SEMINUEVO')->first();
        $listaDocumentos = Parametro::where('valor2', 'TIPO DOCUMENTO')->get();
        $localEmpresa = LocalEmpresa::first();
        $departamentos = Ubigeo::departamentos();
        $marcas_seminuevos = MarcaAutoSeminuevo::get();

        return view('vehiculoSeminuevo/ordenCompraSeminuevo', [
            'oc_nueva' => null,
            'marcas_seminuevos' => $marcas_seminuevos,
            'listaDocumentos' => $listaDocumentos,
            'listaAlmacenes' => $listaAlmacen,
            'listaDocumentos' => $listaDocumentos,
            'listaMotivosOC' => $listaMotivosOC,
            'empresa' => $localEmpresa->nombre_empresa,
            'sucursal' => $localEmpresa->nombre_local,
            'almacen' => $listaAlmacen->valor1,
            'documento_oc' => 'OC-2021-',
            'fecha_emision' => CARBON::now()->format('d/m/Y'),
            'moneda' => '',
            'estado' => '',
            'usuario_creador' => Auth::user()->empleado->nombreCompleto(),
            'motivo' => '',
            'detalle_motivo' => '',
            'tipo_documento_transfiriente' => '',
            'documento_transfiriente' => '',
            'nombre_transfiriente' => '',
            'apellido_paterno_transfiriente' => '',
            'apellido_materno_transfiriente' => '',
            'representante_legal' => '',
            'documento_representante_legal' => '',
            'nombres_representante_legal' => '',
            'apellido_paterno_representante_legal' => '',
            'apellido_materno_representante_legal' => '',
            'direccion' => '',
            'departamento' => '',
            'ciudad' => '',
            'distrito' => '',
            'contacto' => '',
            'email' => '',
            'telefono' => '',
            'nombres' => '',
            // datos del vehiculo

            'placa' => '',
            'vin' => '',
            'motor' => '',
            'anho_fabricacion' => '',
            'anho_modelo' => '',
            'marca' => '',
            'modelo' => '',
            'version' => '',
            'kilometraje' => '',
            'color' => '',
            'combustible' => '',
            'cilindrada' => '',
            'transmision' => '',
            'traccion' => '',

            'observaciones' => '',

            'edited' => false,
            'id_oc' => null,
            'precio' => '',

            'listaDepartamentos' => $departamentos,
            'listaProvincias' => [],
            'listaDistritos' => [],

        ]);
    }

    public function show(Request $request)
    {
        $listaMotivosOC = Parametro::where('valor2', 'MOTIVO OC SEMINUEVO')->get();
        $listaAlmacen = Parametro::where('valor3', 'VEHICULO SEMINUEVO')->first();
        $listaDocumentos = Parametro::where('valor2', 'TIPO DOCUMENTO')->get();
        $localEmpresa = LocalEmpresa::first();
        $departamentos = Ubigeo::departamentos();
        $marcas_seminuevos = MarcaAutoSeminuevo::get();

        $departamentos = Ubigeo::departamentos();

        $id_orden_compra = $request->input("id_orden_compra");
        $ordenC = OrdenCompra::find($id_orden_compra);

        return view('vehiculoSeminuevo/ordenCompraSeminuevo', [
            'oc_nueva' => null,
            'marcas_seminuevos' => $marcas_seminuevos,
            'listaDocumentos' => $listaDocumentos,
            'listaAlmacenes' => $listaAlmacen,
            'listaMotivosOC' => $listaMotivosOC,
            'empresa' => $localEmpresa->nombre_empresa,
            'sucursal' => $localEmpresa->nombre_local,
            'almacen' => $listaAlmacen->valor1,
            'documento_oc' => 'OC-2021-' . $id_orden_compra,
            'fecha_emision' => $ordenC->fecha_registro,
            'moneda' => $ordenC->tipo_moneda,
            'estado' => $ordenC->estado->valor1,
            'usuario_creador' => $ordenC->getNombreCompletoUsuarioRegistro(),
            'motivo' => $ordenC->motivo->valor1,
            'detalle_motivo' => $ordenC->detalle_motivo,
            'tipo_documento_transfiriente' => '',
            'documento_transfiriente' => '',
            'nombre_transfiriente' => '',
            'apellido_paterno_transfiriente' => '',
            'apellido_materno_transfiriente' => '',
            'representante_legal' => '',
            'documento_representante_legal' => '',
            'nombres_representante_legal' => '',
            'apellido_paterno_representante_legal' => '',
            'apellido_materno_representante_legal' => '',
            'direccion' => $ordenC->clienteProveedor->direccion,
            'departamento' => $ordenC->clienteProveedor->getDepartamentoText(),
            'ciudad' => $ordenC->clienteProveedor->getProvinciaText(),
            'distrito' => $ordenC->clienteProveedor->getDistritoText(),
            'contacto' => '',
            'email' => $ordenC->clienteProveedor->email,
            'telefono' => $ordenC->clienteProveedor->celular,
            // datos del vehiculo

            'placa' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->placa,
            'vin' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->vin,
            'motor' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->motor,
            'anho_fabricacion' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->anho_fabricacion,
            'anho_modelo' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->anho_modelo,
            'marca' => '',
            'modelo' => '',
            'version' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->version,
            'kilometraje' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->kilometraje,
            'color' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->color,
            'combustible' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->combustible,
            'cilindrada' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->cilindrada,
            'transmision' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->transmision,
            'traccion' => $ordenC->lineasCompra->first()->vehiculoSeminuevo->traccion,
            'nombres' => '',
            'observaciones' => $ordenC->observaciones,
            'precio' => $ordenC->lineasCompra->first()->total,

            'edited' => true,
            'id_oc' => $id_orden_compra,
            'estadoN'=> $ordenC->estado->valor1,
            'listaDepartamentos' => $departamentos,
            'listaProvincias' => [],
            'listaDistritos' => [],

        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $almacen = Parametro::where('valor3', 'VEHICULO SEMINUEVO')->first();
        $estado_stock = Parametro::where('valor3', 'VEHICULO SEMINUEVO')->where('valor2', 'ESTADO STOCK')->first();
        $estado_vehiculo = Parametro::where('valor2', 'ESTADO VEHICULO')->first();
        $tipo_stock = Parametro::where('valor3', 'RETOMA')->first();

        $vehiculoSeminuevo = new VehiculoSemiNuevo();
        $vehiculoSeminuevo->placa = $request->placa;
        $vehiculoSeminuevo->vin = $request->vin;
        $vehiculoSeminuevo->motor = $request->motor;
        $vehiculoSeminuevo->anho_fabricacion = $request->anho_fabricacion;
        $vehiculoSeminuevo->anho_modelo = $request->anho_modelo;
        $vehiculoSeminuevo->id_modelo_auto_seminuevo = $request->modelo_seminuevoIn;
        $vehiculoSeminuevo->version = $request->version;
        $vehiculoSeminuevo->kilometraje = $request->kilometraje;
        $vehiculoSeminuevo->color = $request->color;
        $vehiculoSeminuevo->combustible = $request->combustible;
        $vehiculoSeminuevo->cilindrada = $request->cilindrada;
        $vehiculoSeminuevo->transmision = $request->transmision;
        $vehiculoSeminuevo->traccion = $request->traccion;
        $vehiculoSeminuevo->id_estado_stock = $estado_stock->id;
        $vehiculoSeminuevo->id_estado_vehiculo = $estado_vehiculo->id;
        $vehiculoSeminuevo->id_tipo_stock = $tipo_stock->id;
        $vehiculoSeminuevo->id_almacen = $almacen->id;
        $vehiculoSeminuevo->id_usuario_registro = Auth::user()->id_usuario;
        $vehiculoSeminuevo->id_usuario_modifico = Auth::user()->id_usuario;
        $vehiculoSeminuevo->id_local = 1;
        $vehiculoSeminuevo->save();

        // dd($vehiculoSeminuevo);

        $cliente_proveedor = Cliente::find($request->documento_transfiriente);
        if ($cliente_proveedor == null) {
            $cliente_proveedor = new Cliente();
        }
        $tipo_doc = $request->selectTipoDoc;
        $cliente_proveedor->tipo_doc = $tipo_doc;

        $cliente_proveedor->num_doc = $request->documento_transfiriente;
        if ($tipo_doc == "DNI") {
            $cliente_proveedor->tipo_cliente = "NATURAL";
            $cliente_proveedor->nombres = $request->nombres;
        } else {
            $cliente_proveedor->tipo_cliente = "EMPRESA";
            $cliente_proveedor->nombres = $request->razon_social;
        }

        $cliente_proveedor->email = $request->email;
        $cliente_proveedor->direccion = $request->direccion;
        $cliente_proveedor->celular = $request->celular;

        $apellido_pat = $request->apellido_mat;
        $apellido_mat = $request->apellido_mat;

        $cliente_proveedor->documento_rep_legal = $request->documento_representante_legal;
        $cliente_proveedor->nombre_rep_legal = $request->nombres_representante_legal;
        $cliente_proveedor->apellido_pat_rep_legal = $request->apellido_paterno_representante_legal;
        $cliente_proveedor->apellido_mat_rep_legal = $request->apellido_materno_representante_legal;
        $ubigeo = ($request->departamento) . ($request->provincia) . ($request->distrito);
        $cliente_proveedor->cod_ubigeo = $ubigeo;
        $cliente_proveedor->save();

        $ordenCompra = new OrdenCompra();
        $estado = Parametro::where('valor1', 'PENDIENTE')->first();
        $listaAlmacen = Parametro::where('valor3', 'VEHICULO SEMINUEVO')->first();

        $ordenCompra->tipo = 'VEHICULOS SEMINUEVOS';
        $ordenCompra->id_estado = $estado->id;
        $ordenCompra->id_motivo = $request->select_motivo;
        $ordenCompra->id_almacen = $almacen->id;
        $ordenCompra->id_local_empresa = 1;
        $ordenCompra->tipo_moneda = $request->moneda;
        $ordenCompra->condicion_pago = 'CONTADO';
        $ordenCompra->observaciones = $request->observaciones;
        $ordenCompra->detalle_motivo = $request->detalle_motivo;
        $ordenCompra->fecha_registro = Carbon::now();
        $ordenCompra->id_usuario_registro = Auth::user()->id_usuario;
        $ordenCompra->es_aprobado = 0;
        $ordenCompra->doc_cliente_proveedor = $cliente_proveedor->num_doc;
        $ordenCompra->save();

        $lineaOC = new LineaOrdenCompra();
        $lineaOC->id_vehiculo_seminuevo = $vehiculoSeminuevo->id_vehiculo_seminuevo;
        $lineaOC->id_orden_compra = $ordenCompra->id_orden_compra;
        $lineaOC->cantidad = 1;
        $lineaOC->precio = $request->precio;
        $lineaOC->estado_stock = null;
        $lineaOC->descuento = 0;
        $lineaOC->sub_total = $request->precio;
        $lineaOC->impuesto = 0;
        $lineaOC->total = $request->precio;
        $lineaOC->save();
        return redirect()->back()->with('success', 'Orden de Compra Generada N°: '.$ordenCompra->id_orden_compra);

        // return $this->index($ordenCompra->id_orden_compra);
        $css = "<link rel='stylesheet'href='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css' />";
        $css = $css . "

       <script src='https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js'></script>
       <script type='text/javascript'>
       Swal.fire({
        text: 'Orden de Compra Generada N°: ' +" . $ordenCompra->id_orden_compra . ",
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        showCancelButton: false,
        // cancelButtonText: 'No, Cancelar',
        customClass: {
            confirmButton: 'btn btn-success  mr-3',
        },
        buttonsStyling: false,
        }).then((result) => {
        if (result.value) {
            toastr['success']('Registro actualizado correctamente');
            var loc = window.location;
            window.location = loc.protocol + '/seguimientoOC';
        }
    });
       </script>

       <div id='alert'></div>



       ";

    }

    public function destroy($id)
    {
        $vehiculo = VehiculoNuevo::find($id);
        $listaVehiculosNuevos = VehiculoNuevo::all();
        $marcasVehiculo = MarcaAuto::all();
        $empleados = Empleado::whereHas('usuario', function ($q2) {$q2->where('id_rol', 1);})->orderBy('primer_apellido')->get();
        $vehiculo = VehiculoNuevo::find($id);
        if ($vehiculo != null) {
            $vehiculo->delete();
        }

        return view('vehiculosnuevos/consultaVehiculosNuevos', [
            'listaVehiculosNuevos' => $listaVehiculosNuevos,
            'listaMarcas' => $marcasVehiculo,
            'listaAsesores' => $empleados,
        ]);
    }

    public function buscarDataVehiculoNuevo($vin)
    {
        $vehiculo = LineaOrdenCompra::where('vin', $vin)->first();
        $linea_nota_ingreso = $vehiculo->lineasNotaIngreso->first();

        $data = [
            'oc' => $vehiculo->id_orden_compra,
            'vin' => $vin,
            'tipo_stock' => $vehiculo->vehiculoNuevoInstancia->tipoStock->valor1,
            'marca' => $vehiculo->vehiculoNuevo->marcaAuto->nombre_marca,
            'modelo_comercial' => $vehiculo->vehiculoNuevo->modelo_comercial,
            'motor' => $vehiculo->numero_motor,
            'anho_modelo' => $vehiculo->vehiculoNuevoInstancia->anio,
            'color' => $vehiculo->color,
            'kilometraje' => 0,
            'ubicacion' => $linea_nota_ingreso != null ? $linea_nota_ingreso->guia_remision : '-',
            'guia_remision' => $linea_nota_ingreso != null ? $linea_nota_ingreso->notaIngreso->guia_remision : '-',
            'documento' => $linea_nota_ingreso != null ? $linea_nota_ingreso->notaIngreso->id_nota_ingreso : '-',
            'fecha_recepcion' => $linea_nota_ingreso != null ? $linea_nota_ingreso->notaIngreso->fecha_recepcion : '-',
            'observaciones' => $linea_nota_ingreso != null ? $linea_nota_ingreso->notaIngreso->observaciones : '-'];
        return $data;
    }

    public function buscarDataVehiculoSeminuevo($placa)
    {
        $vehiculo = VehiculoSeminuevo::where('placa', $placa)->first();

        $linea_nota_ingreso = $vehiculo->lineaOrdenCompra->lineasNotaIngreso->first();
//dd($vehiculo);

        $data = [
            'oc' => $vehiculo->lineaOrdenCompra->id_orden_compra,
            'vin' => $vehiculo->vin,
            'tipo_stock' => $vehiculo->tipoStock->valor1,
            'marca' => $vehiculo->modeloAutoseminuevo->marca->nombre,
            'placa' => $placa,
            'modelo' => $vehiculo->modeloAutoseminuevo->nombre,
            'version' => $vehiculo->version,
            'motor' => $vehiculo->motor,
            'anho_modelo' => $vehiculo->anho_modelo,
            'anho_fabricacion' => $vehiculo->anho_fabricacion,
            'color' => $vehiculo->color,
            'kilometraje' => $vehiculo->kilometraje,
            'ubicacion' => $vehiculo->ubicacion != null ? $vehiculo->ubicacion->valor1 : '-',
            'documento' => $linea_nota_ingreso != null ? $linea_nota_ingreso->notaIngreso->id_nota_ingreso : '-',
            'fecha_recepcion' => $linea_nota_ingreso != null ? $linea_nota_ingreso->notaIngreso->fecha_registro : '-',
            'observaciones' => $linea_nota_ingreso != null ? $linea_nota_ingreso->notaIngreso->observaciones : '-'];
        return $data;
    }

}
