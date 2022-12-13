<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Administracion\UsuarioController;
use App\Modelos\FacturaCompra;
use App\Modelos\OrdenCompra;
use App\Modelos\Proveedor;
use App\Modelos\NotaIngreso;
use App\Modelos\Detraccion;
use Carbon\Carbon;
use Auth;

class CrearFacturasController extends Controller
{
    public function index(Request $request){
        $detracciones = Detraccion::all();
        return view('contabilidadv2.ingresoFacturasInicial',['detracciones'=>$detracciones]);
    }

    public function relacionadasOCs(Request $request)
    {
        $datos=session("data");
        //dd($datos["listaOrdenes"]);
        //Pasar notas de ingreso y campos para poder mostrar detalle
        return view('contabilidadv2.ingresoFacturasFinal',
        [
            "periodo" => $datos["periodo"],
            "nFactura" => $datos["nFactura"],
            "fechaEmision" => $datos["fechaEmision"],
            "fechaVencimiento" => $datos["fechaVencimiento"],
            "RUCProv" => $datos["RUCProv"],
            "nombreProv" => $datos["nombreProv"],
            "moneda" => $datos["moneda"],
            "glosa" => $datos["glosa"],
            "tipoMovimiento" => $datos["tipoMovimiento"],
            "formaPago" => $datos["formaPago"],
            "clasificacion" => $datos["clasificacion"],
            "modalidadServicio" => $datos["modalidadServicio"],
            "tipo_detraccion" => $datos["tipo_detraccion"],
            "detraccion" => $datos["detraccion"],
            "regimen" => $datos["regimen"],
            "baseImponible" => $datos["baseImponible"],
            "impuestos" => $datos["impuestos"],
            "inafecto" => $datos["inafecto"],
            "totalProvision" => $datos["totalProvision"],
            "listaNotas" => $datos["listaNotas"],
        ]);
    }

    public function verNotasDeIngreso(Request $request)
    {
        //Procesar request y obtener notas de ingreso, guardar como session (local storage)
        //session(["prueba"=>2,"prueba2"=>5]);
        $requests = $request->all();
        $OCRela = [];
        foreach ($requests as $key => $value) {
            $pos_input=strpos($key,"OC-");
            if($pos_input !== false){
                array_push($OCRela,$value);
            }
        }
        $lista = [];   
        $ListaOrden = OrdenCompra::whereIn('id_orden_compra',$OCRela)->get();
        foreach ($ListaOrden as $key => $orden){
            $listaNotas = $orden->listarNotasIngreso();
            foreach ($listaNotas as $key => $notaIng){
                $fecha=Carbon::parse($notaIng->fecha_registro)->format("d/m/Y H:i");
                array_push($lista,(object) [
                    'idNota' =>$notaIng->id_nota_ingreso,
                    'fecha'=>$fecha,
                    'monto'=>$notaIng->getCostoTotal(),
                    'proveedor'=>$notaIng->obtenerNombreProveedorRelacionado(),
                    'nOrden'=>$orden->id_orden_compra,                
                    ]);
            }
        }
        $datosPasar = [
            "periodo" => $request->periodo,
            "nFactura" => $request->nFactura,
            "fechaEmision" => $request->fechaEmision,
            "fechaVencimiento" => $request->fechaVencimiento,
            "RUCProv" => $request->RUCProv,
            "nombreProv" => $request->nombreProv,
            "moneda" => $request->moneda,
            "glosa" => $request->glosa,
            "tipoMovimiento" => $request->tipoMovimiento,
            "formaPago" => $request->formaPago,
            "clasificacion" => $request->clasificacion,
            "modalidadServicio" => $request->modalidadServicio,
            "tipo_detraccion"=>$request->tipo_detraccion,
            "detraccion" => $request->detraccion,
            "regimen" => $request->regimen,
            "baseImponible" => $request->baseImponible,
            "impuestos" => $request->impuestos,
            "inafecto" => $request->inafecto,
            "totalProvision" => $request->totalProvision,
            "listaNotas" => $lista,
        ];
        session(["data"=>$datosPasar]);
        
        //dd($orden);
        return redirect()->route('contabilidad.relacionadasOCs');
    }

    public function store(Request $request){
        $datos=session("data");

        $factura = new FacturaCompra();
        $factura->periodo = $datos["periodo"];
        $factura->nro_factura = $datos["nFactura"];
        $factura->fecha_emision = Carbon::createFromFormat('d/m/Y',$datos["fechaEmision"]);
        $factura->fecha_vencimiento = Carbon::createFromFormat('d/m/Y',$datos["fechaVencimiento"]);
        $factura->fecha_registro = Carbon::now();
        $factura->id_usuario_registro = Auth::user()->id_usuario;
        $factura->id_proveedor = Proveedor::where('num_doc',$datos["RUCProv"])->first()->id_proveedor;
        $factura->moneda = $datos["moneda"];
        $factura->glosa = $datos["glosa"];
        $factura->forma_pago = $datos["formaPago"];
        //$factura->clasificacion = $datos["clasificacion"]; falta
        //$factura->valor_detraccion = $datos["modalidadServicio"]; falta
        $factura->regimen = $datos["regimen"];
        $factura->base_imponible = $datos["baseImponible"];
        $factura->impuestos = $datos["impuestos"];
        $factura->monto_inafecto = $datos["inafecto"];
        $factura->total = $datos["totalProvision"];
        //falta notas de ingreso
        if($datos["detraccion"]){
            $factura->valor_detraccion = $datos["detraccion"];
            $factura->id_detraccion = $datos["tipo_detraccion"];
            $factura->tiene_detraccion = 1;
        }
        else {
            $factura->valor_detraccion = null;
            $factura->id_detraccion = null;
            $factura->tiene_detraccion = 0;
        }
        

        
        $listaNotas = $datos["listaNotas"];
        $total = 0;
        $listaNotasBuscadas = [];
        foreach($listaNotas as $key => $nota){
            $notaId = $nota->idNota;
            $checkboxName = "checkbox_facturar_" . $notaId;
            if($request->input($checkboxName)){
                $notaIngreso = NotaIngreso::find($notaId);
                $total += $notaIngreso->getCostoTotal();
                array_push($listaNotasBuscadas,$notaIngreso);
            }
        }

        if($total != ($factura->base_imponible + $factura->monto_inafecto)){
            return redirect()->back()->with('error_msg',"Los montos de las notas seleccionadas tienen que concordar con el total de la factura (sin IGV)");            
        }
        //Aqui ya se sabe que el monto de la factura y el monto de las notas de ingreso ya son iguales (Validacion)

        $factura->save();
        $idFactura = $factura->id_factura_compra;

        foreach($listaNotasBuscadas as $notaIngreso){
            $notaIngreso->id_factura = $notaId;
            $notaIngreso->save();
        }

        session()->forget("data");

        return redirect()->route('contabilidad.ingresoFacturasInicial');     
        //return redirect()->back();
    }

    //Crear post de fin de factura y borrar variables de sesion session()->forget(["prueba","prueba2"])
}