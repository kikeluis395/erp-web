<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Usuario;
use Hash;

class UsuarioController extends Controller
{
    public function listAsesoresServicio()
    {
        $usuarios = Usuario::with('rol')->whereHas('rol', function ($query) {
            // $query->where('nombre_rol', 'Asesor de Servicio');
            $query->where('nombre_interno', 'asesor_servicios');
        })->orWhereIn('id_rol', [8, 9, 14])->orWhereIn('username', ['asiancas'])->get();

        return $usuarios;
    }
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
        //
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

    public function showCambiarPassword()
    {
        return view('administracion.cambiarPassword', ['refreshable' => false]);
    }

    public function cambiarPassword(Request $request)
    {
        $password1 = $request->password;
        $password2 = $request->passwordConfirm;
        $user = auth()->user();
        if (($password1) && ($password1 == $password2)) {
            $user->password = Hash::make($password1);
            $user->save();
            return redirect()->to('/');
        } else {
            return redirect()->route('resetPassword')->with('errorConfirm', true);
        }
    }

    public function buscarPorRol($rol)
    {
        return Usuario::with('rol')->whereHas('rol', function ($query) use ($rol) {
            $query->where('nombre_rol', $rol);
        })->get();
    }
}
