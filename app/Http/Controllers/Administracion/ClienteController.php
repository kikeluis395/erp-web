<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Cliente;
use App\Modelos\RecepcionOT;
use App\Modelos\Cotizacion;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $ubigeo = ($request->departamento) . ($request->provincia) . ($request->distrito);
        $doc_cliente = Cliente::saveCliente(
            $request->cliente,
            $request->tipoID,
            $request->tipoCliente,
            $request->nombres,
            $request->apellidoPat,
            $request->apellidoMat,
            $request->sexo,
            $request->estadoCivil,
            $request->direccion,
            $request->telefono,
            $request->email,
            $ubigeo
        );
        return $doc_cliente;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente)
            return null;
        $response = [
            'nro_doc' => $cliente->getNumDocCliente(),
            'tipo_doc' => $cliente->getTipoDocCliente(),
            'tipo_cliente' => $cliente->getTipoCliente(),
            'nombres' => $cliente->getNombres(),
            'apellido_pat' => $cliente->getApellidoPat(),
            'apellido_mat' => $cliente->getApellidoMat(),
            'nombre_completo' => $cliente->getNombreCliente(),
            'sexo' => $cliente->getSexo(),
            'estado_civil' => $cliente->getEstadoCivil(),
            'direccion' => $cliente->getDireccionCliente(),
            'celular' => $cliente->getTelefonoCliente(),
            'email' => $cliente->getCorreoCliente(),
            'cod_departamento' => $cliente->getDepartamento(),
            'cod_provincia' => $cliente->getProvincia(),
            'cod_distrito' => $cliente->getDistrito(),
        ];
        return $response;
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

    public function reasignarOTCotCliente(Request $request)
    {
        if ($request->esOT) {
            if (isset($request->idOT)) {
                $ordenTrabajo = RecepcionOT::find($request->idOT);
                $doc_cliente = $this->store($request);
                $hojaTrabajo = $ordenTrabajo->hojaTrabajo;
                $hojaTrabajo->doc_cliente = $doc_cliente;
                $hojaTrabajo->save();
            } elseif (session('hojaTrabajo')) {
                $doc_cliente = $this->store($request);
                $hojaTrabajo = session('hojaTrabajo');
                $hojaTrabajo->doc_cliente = $doc_cliente;
                session(['hojaTrabajo' => $hojaTrabajo]);
            }
        } else if ($request->esCotizacion) {
            if (isset($request->idCotizacion)) {
                $cotizacion = Cotizacion::find($request->idCotizacion);
                $doc_cliente = $this->store($request);
                $hojaTrabajo = $cotizacion->hojaTrabajo;
                $hojaTrabajo->doc_cliente = $doc_cliente;
                $hojaTrabajo->save();
            } elseif (session('hojaTrabajo')) {
                $doc_cliente = $this->store($request);
                $hojaTrabajo = session('hojaTrabajo');
                $hojaTrabajo->doc_cliente = $doc_cliente;
                session(['hojaTrabajo' => $hojaTrabajo]);
            }
        }
    }
}
