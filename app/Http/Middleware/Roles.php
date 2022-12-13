<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Roles
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $usuario = Auth::user();
        if (!$usuario) return redirect()->route('login');

        // if ($usuario->id_rol==2) {
        //     //asesor de servicios
        //     if(in_array($request->route()->uri, ['recepcion','citas','entrega'])){
        //         return $next($request);
        //     }
        //     return redirect()->route('recepcion.index');
        // }
        // elseif ($usuario->id_rol==3) {
        //     //asesor_dyp
        //     if(in_array($request->route()->uri, ['valuacion','citas'])){
        //         return $next($request);
        //     }
        //     return redirect()->route('valuacion.index');
        // }
        // elseif ($usuario->id_rol==4) {
        //     //supervisor
        //     if(in_array($request->route()->uri, ['valuacion','reparacion','citas'])){
        //         return $next($request);
        //     }
        //     return redirect()->route('valuacion.index');
        // }
        // elseif ($usuario->id_rol==5) {
        //     //asesor de repuestos
        //     if(in_array($request->route()->uri, ['repuestos','detalle_repuestos','citas'])){
        //         return $next($request);
        //     }
        //     return redirect()->route('repuestos.index');
        // }
        // elseif ($usuario->id_rol==7) {
        //     //tecnico
        //     if(in_array($request->route()->uri, ['tecnicos'])){
        //         return $next($request);
        //     }
        //     return redirect()->route('tecnicos.index');
        // }

        return $next($request);
    }
}
