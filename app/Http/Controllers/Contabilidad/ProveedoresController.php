<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Ubigeo;
use App\Modelos\Proveedor;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departamentos = Ubigeo::departamentos();
        $nroDoc = $request->nroDoc;

        if ($request->all() ==[]) {
            //esto se da en caso que no se presione el botón Buscar del filtro
            $proveedores = Proveedor::all();
        }
        else {
            $proveedores = new Proveedor();

            if($nroDoc)
                $proveedores = $proveedores->where('num_doc', 'LIKE', "$nroDoc%");

            $proveedores = $proveedores->get();
        }

        return view('contabilidad.proveedores',['listaDepartamentos'=> $departamentos,
                                                'listaProvincias'=> [],
                                                'listaDistritos'=> [],
                                                'listaProveedores' => $proveedores,
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
        //
        $proveedor = new Proveedor();
        $proveedor->num_doc = $request->nroDocumento;
        $proveedor->nombre_proveedor = $request->nombre;
        // $proveedor->giro = $request->giro;
        // $proveedor->tipo_proveedor = $request->tipoProveedor;
        // $proveedor->email = $request->email;
        $proveedor->direccion = $request->direccion;
        $proveedor->cod_ubigeo = ($request->departamento).($request->provincia).($request->distrito);
        // $proveedor->activo = $request->activoRadio;
        // $proveedor->domiciliado = $request->domiciliadoRadio;
        $proveedor->contacto = $request->contacto;
        $proveedor->telf_contacto = $request->telefonoContacto;
        $proveedor->email_contacto = $request->emailContacto;
        $proveedor->save();

        return redirect()->route('contabilidad.proveedores.index');
    }

    public function editarProveedor(Request $request)
    {
        
        $proveedor = Proveedor::find($request->idProveedor);
        $proveedor->num_doc = $request->nroDocumento;
        $proveedor->nombre_proveedor = $request->nombre;
        // $proveedor->giro = $request->giro;
        // $proveedor->tipo_proveedor = $request->tipoProveedor;
        // $proveedor->email = $request->email;
        $proveedor->direccion = $request->direccion;
        $proveedor->cod_ubigeo = ($request->departamento).($request->provincia).($request->distrito);
        // $proveedor->activo = $request->activoRadio;
        // $proveedor->domiciliado = $request->domiciliadoRadio;
        $proveedor->contacto = $request->contacto;
        $proveedor->telf_contacto = $request->telefonoContacto;
        $proveedor->email_contacto = $request->emailContacto;
        $proveedor->save();

        return redirect()->route('contabilidad.proveedores.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
}
