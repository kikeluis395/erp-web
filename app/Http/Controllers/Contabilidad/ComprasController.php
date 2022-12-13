<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Ubigeo;
use App\Modelos\OrdenCompra;
use App\Modelos\LineaOrdenCompra;
use App\Modelos\Proveedor;
use App\Modelos\Repuesto;
use Carbon\Carbon;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos = Ubigeo::departamentos();
        $proveedores = Proveedor::all();
        $compras = OrdenCompra::all();

        return view('contabilidad.compras',['listaDepartamentos'=> $departamentos,
                                            'listaProvincias'=> [],
                                            'listaDistritos'=> [],
                                            'listaProveedores'=>$proveedores,
                                            'listaCompras'=>$compras,
                                            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lineasCompra = [];
        $compra = new OrdenCompra();
        $compra->nro_orden_compra = $request->ordenCompra;
        $compra->nro_factura = $request->factura;
        // $compra->estado = $request->estadoRadio;
        $compra->id_proveedor = $request->proveedor;
        $compra->fecha_entrega = Carbon::createFromFormat('d/m/Y',$request->fechaEntrega);
        $compra->forma_pago = $request->formaPago;
        $compra->tipo_moneda = $request->tipoMoneda;
        $compra->tipo = $request->tipo;

        if($compra->tipo == 'REPUESTOS'){
            session(['registro_compra' => $compra]);
            return redirect()->route('contabilidad.detalleCompras');

            $compra->save();
            $requests = $request->all();
            foreach ($requests as $key => $value) {
                $pos_input=strpos($key,"codigoRepuesto-");
                if ($pos_input === 0) {
                    $numRequest = substr($key,$pos_input + strlen('codigoRepuesto-'));
                    $lineaCompra = new LineaOrdenCompra();
                    $lineaCompra->id_compra = $compra->id_compra;
                    $codigoRepuesto = $request->input('codigoRepuesto-' . $numRequest);
                    $lineaCompra->id_repuesto = Repuesto::where('codigo_repuesto', $codigoRepuesto)->first()->id_repuesto;
                    $lineaCompra->cantidad = $request->input('cantidadLineaCompra-' . $numRequest);
                    $lineaCompra->precio = $request->input('precioLineaCompra-' . $numRequest);
                    $lineaCompra->save();
                    array_push($lineasCompra,$lineaCompra);
                }
            }
            //dd([$compra, $lineasCompra]);
        }
        elseif($compra->tipo == 'SERVICIOS TERCEROS'){
            $compra->id_recepcion_ot=$request->nroOT;
            $compra->save();
        }
        
        return redirect()->route('contabilidad.compras.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Resv
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detalleCompras()
    {
        return view('contabilidad.registrarDetalleCompras');
    }

    public function storeDetalleCompras(Request $request)
    {
        $requests = $request->all();
        $compra = session('registro_compra');
        $compra->save();

        foreach ($requests as $key => $value) {
            $pos_input=strpos($key,"codigoRepuesto-");
            if ($pos_input === 0) {
                $numRequest = substr($key,$pos_input + strlen('codigoRepuesto-'));
                $lineaCompra = new LineaOrdenCompra();
                $lineaCompra->id_compra = $compra->id_compra;
                $codigoRepuesto = $request->input('codigoRepuesto-' . $numRequest);
                $lineaCompra->id_repuesto = Repuesto::where('codigo_repuesto', $codigoRepuesto)->first()->id_repuesto;
                $lineaCompra->cantidad = $request->input('cantidadLineaCompra-' . $numRequest);
                $lineaCompra->precio = $request->input('precioLineaCompra-' . $numRequest);
                $lineaCompra->save();
            }
        }

        session()->forget('registro_compra');

        return redirect()->route('contabilidad.compras.index');
    }
}
