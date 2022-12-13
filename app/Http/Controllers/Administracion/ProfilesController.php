<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Administracion\RolPermiso;
use App\Modelos\Permiso;
use App\Modelos\Rol;
use App\Modelos\Usuario;
use App\Modelos\Empleado;
use App\Modelos\LocalEmpresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilesController extends Controller
{
    public function index()
    {
        $users = Usuario::orderBy('id_rol')->get();
        $users = $this->map_adicionales($users);

        $modulos_admin = Permiso::where('tipo', "modulo")->where('categoria', "ADMIN")->where('habilitado', 1)->get();
        $modulos_report = Permiso::where('tipo', "submodulo")->where('categoria', "REPORTE")->where('habilitado', 1)->get();
        $rols = Rol::orderBy('nombre_rol')->get();
        $admin = Rol::where('nombre_interno', 'administrador')->get()->first()->id_rol;
        $accesos = RolPermiso::with(['rol', 'permiso'])->get();

        $locales = LocalEmpresa::all();

        $just_areas = Rol::selectRaw('distinct area')->where('area', '!=', '')->get();
        $areas = [];
        foreach ($just_areas as $rol) array_push($areas, $rol->area);

        $mapeo = $this->generateMapeo($rols, $modulos_admin, $accesos);
        $reports = $this->generateMapeo($rols, $modulos_report, $accesos);
        $data = [
            'usuarios' => $users,
            'admin' => $admin,
            'rols' => $rols,
            'modulos_admin' => $modulos_admin,
            'modulos_report' => $modulos_report,
            'areas' => $areas,
            'accesos' => $accesos,
            'mapeo' => $mapeo,
            'reports' => $reports,
            'locales' => $locales,
            'refreshable' => false
        ];
        return view('administracion.perfiles', $data);
    }

    public function store(Request $request)
    {
        $dni = $request->dni;
        $name = $request->name;
        $apellido_pat = $request->apellido_pat;
        $apellido_mat = $request->apellido_mat;
        $telefono = $request->telefono;
        $email = $request->email;
        $username = $request->username;
        $id_local = $request->id_local;
        $password = $request->password;
        $id_rol = $request->id_rol;
        $roles_adicionales = $request->roles_adicionales;
        if ($roles_adicionales) $roles_adicionales = json_encode($roles_adicionales);
        else $roles_adicionales = json_encode([]);

        $dni_exists = Usuario::where('dni', $dni)->get()->first();
        if ($dni_exists) return response()->json(['success' => false, 'message' => 'Ya existe un usuario con el DNI ingresado'], 500);

        $username_exists = Usuario::where('username', $username)->get()->first();
        if ($username_exists) return response()->json(['success' => false, 'message' => 'Ya existe un usuario con username formulado'], 500);

        // $local = LocalEmpresa::all()->first();

        $empleado = new Empleado();
        $empleado->dni = $dni;
        $empleado->primer_nombre = $name;
        $empleado->primer_apellido = $apellido_pat;
        $empleado->segundo_apellido = $apellido_mat;
        $empleado->email = $email;
        $empleado->telefono_contacto = $telefono;
        $empleado->id_local = $id_local;
        $empleado->save();

        $user = new Usuario();
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->id_rol = $id_rol;
        $user->dni = $dni;
        $user->habilitado = 1;
        $user->roles_adicionales = $roles_adicionales;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // $dni = $request->dni;
        $id_empleado = $request->id_empleado;
        $id_usuario = $request->id_usuario;
        $name = $request->name;
        $apellido_pat = $request->apellido_pat;
        $apellido_mat = $request->apellido_mat;
        $telefono = $request->telefono;
        $email = $request->email;
        $id_local = $request->id_local;
        $password = $request->password;
        $habilitado = $request->habilitado;
        // $username = $request->username;
        $id_rol = $request->id_rol;
        $roles_adicionales = $request->roles_adicionales;
        if ($roles_adicionales) $roles_adicionales = json_encode(array_unique($roles_adicionales));
        else $roles_adicionales = json_encode([]);

        $empleado = Empleado::where('dni', $id_empleado)->get()->first();
        $usuario = Usuario::find($id_usuario);
        if ($empleado && $usuario) {
            // $empleado->dni = $dni;
            $empleado->primer_nombre = $name;
            $empleado->primer_apellido = $apellido_pat;
            $empleado->segundo_apellido = $apellido_mat;
            $empleado->email = $email;
            $empleado->telefono_contacto = $telefono;
            $empleado->id_local = $id_local;
            // $empleado->id_local = $local->id_local;
            $empleado->save();


            // $usuario->username = $username;
            if (!is_null($password) && trim((string)$password) != '') {
                $usuario->password = Hash::make($password);
            }
            $usuario->id_rol = $id_rol;
            $usuario->habilitado = $habilitado;
            // $usuario->dni = $dni;
            // $usuario->habilitado = 1;
            $usuario->roles_adicionales = $roles_adicionales;
            $usuario->save();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        if ($usuario) {
            $id_empleado = $usuario->dni;
            $empleado = Empleado::where('dni', $id_empleado)->get()->first();
            if ($empleado) {
                $usuario->delete();
                $empleado->delete();
                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false]);
    }

    public function generateMapeo($rols, $permisos, $accesos)
    {
        $arr = [];
        foreach ($rols as $rol) {
            $id_rol = $rol->id_rol;
            foreach ($permisos as $permiso) {
                $id_permiso = $permiso->id_permiso;
                $name = "R$id_rol" . "P$id_permiso";
                $arr[$name] = ["editar" => 0, "ver" => 0];
            }
        }
        foreach ($accesos as $acceso) {
            $id_rol = $acceso->id_rol;
            $id_permiso = $acceso->id_permiso;
            $name = "R$id_rol" . "P$id_permiso";
            $editar = $acceso->editar;
            $ver = $acceso->ver;
            $arr[$name] = ["editar" => $editar, "ver" => $ver];
        }
        return $arr;
    }

    public function store_mapeo(Request $request)
    {
        $arr = [];
        $data = $request->all();

        foreach (array_keys($data) as $rol_permiso) {
            $name = explode('_', $rol_permiso);
            $value = $data[$rol_permiso];

            $permisos = explode('_', $value);
            if (count($permisos) === 2 && count($name) === 2) {
                $ver = $permisos[0];
                $ver = str_replace('V', '', $ver);
                $ver = $ver === '1';

                $editar = $permisos[1];
                $editar = str_replace('E', '', $editar);
                $editar = $editar === '1';

                $eliminar = !$editar && !$ver;
                $manejar = $editar || $ver;

                $id_rol = $name[0];
                $id_permiso = $name[1];
                $editar = $editar ? 1 : 0;
                $ver = $ver ? 1 : 0;

                $modulo = Permiso::with('submodulos')->find($id_permiso);
                $submodulos = [];
                if ($modulo) {
                    if (is_null($modulo->modulo)) $submodulos = $modulo->submodulos;
                }


                $permiso = RolPermiso::where('id_rol', $id_rol)->where('id_permiso', $id_permiso)->get();
                $arr[$rol_permiso] = ['eliminar' => $eliminar, 'manejar' => $manejar, 'ver' => $ver, 'editar' => $editar, 'permiso' => $permiso];

                if (count($permiso) > 0) {
                    if ($eliminar) {
                        foreach ($permiso as $saved) {
                            $saved->delete();

                            if ($modulo) {
                                foreach ($submodulos as $submodulo) {
                                    $permiso = RolPermiso::where('id_rol', $id_rol)->where('id_permiso', $submodulo->id_permiso)->get();
                                    foreach ($permiso as $saved_submodule) $saved_submodule->delete();
                                }
                            }
                        }
                    } else if ($manejar) {

                        if (count($permiso) > 1) {
                            foreach ($permiso as $saved) $saved->delete();
                            $npermiso = new RolPermiso();
                        } else {
                            $npermiso = $permiso->first();
                        }
                        $npermiso->id_rol = $id_rol;
                        $npermiso->id_permiso = $id_permiso;
                        $npermiso->editar = $editar;
                        $npermiso->ver = $ver;
                        $npermiso->save();

                        if ($modulo && count($submodulos) > 0) {

                            foreach ($submodulos as $submodulo) {
                                $permisos_submodule = RolPermiso::where('id_rol', $id_rol)->where('id_permiso', $submodulo->id_permiso)->get();
                                foreach ($permisos_submodule as $saved) $saved->delete();
                            }

                            foreach ($submodulos as $submodulo) {
                                $npermiso = new RolPermiso();
                                $npermiso->id_rol = $id_rol;
                                $npermiso->id_permiso = $submodulo->id_permiso;
                                $npermiso->editar = $editar;
                                $npermiso->ver = $ver;
                                $npermiso->save();
                            }
                        }
                    }
                } else {
                    if ($manejar) {
                        $npermiso = new RolPermiso();
                        $npermiso->id_rol = $id_rol;
                        $npermiso->id_permiso = $id_permiso;
                        $npermiso->editar = $editar;
                        $npermiso->ver = $ver;
                        $npermiso->save();

                        foreach ($submodulos as $submodulo) {
                            $npermiso = new RolPermiso();
                            $npermiso->id_rol = $id_rol;
                            $npermiso->id_permiso = $submodulo->id_permiso;
                            $npermiso->editar = $editar;
                            $npermiso->ver = $ver;
                            $npermiso->save();
                        }
                    }
                }
            }
        }
        return response()->json(['success' => true, 'data' => $arr]);
    }

    public function store_report(Request $request)
    {
        $arr = [];
        $data = $request->all();

        $report_permiso = Permiso::where('nombre_interno', 'modulo_reportes')->get()->first();
        $conteo_rol = [];

        foreach (array_keys($data) as $rol_permiso) {
            $name = explode('_', $rol_permiso);
            $value = $data[$rol_permiso];

            $permisos = explode('_', $value);
            if (count($permisos) === 1 && count($name) === 2) {
                $ver = $permisos[0];
                $ver = str_replace('V', '', $ver);
                $ver = $ver === '1';

                $eliminar = !$ver;
                $manejar = $ver;

                $id_rol = $name[0];
                $id_permiso = $name[1];
                $ver = $ver ? 1 : 0;

                if ($manejar) {
                    if (in_array("R$id_rol", array_keys($conteo_rol))) $conteo_rol["R$id_rol"] += 1;
                    else $conteo_rol["R$id_rol"] = 1;
                } else {
                    if (trim($id_rol) != '' && !in_array("R$id_rol", array_keys($conteo_rol))) $conteo_rol["R$id_rol"] = 0;
                }

                $permiso = RolPermiso::where('id_rol', $id_rol)->where('id_permiso', $id_permiso)->get();
                // $arr[$rol_permiso] = ['eliminar' => $eliminar, 'manejar' => $manejar, 'ver' => $ver, 'permiso' => $permiso];

                if (count($permiso) > 0) {
                    if ($eliminar) {
                        foreach ($permiso as $saved) {
                            $saved->delete();
                        }
                    } else if ($manejar) {
                        foreach ($permiso as $saved) $saved->delete();

                        $npermiso = new RolPermiso();
                        $npermiso->id_rol = $id_rol;
                        $npermiso->id_permiso = $id_permiso;
                        $npermiso->editar = 0;
                        $npermiso->ver = $ver;
                        $npermiso->save();
                    }
                } else {
                    if ($manejar) {
                        $npermiso = new RolPermiso();
                        $npermiso->id_rol = $id_rol;
                        $npermiso->id_permiso = $id_permiso;
                        $npermiso->editar = 0;
                        $npermiso->ver = $ver;
                        $npermiso->save();
                    }
                }
            }
        }

        $arr['conteo'] = $conteo_rol;
        if ($report_permiso && count(array_keys($conteo_rol)) > 0) {
            foreach (array_keys($conteo_rol) as $conteo) {
                $rol = str_replace('R', '', $conteo);
                $value = $conteo_rol[$conteo];

                $permiso = RolPermiso::where('id_rol', $rol)->where('id_permiso', $report_permiso->id_permiso)->get();
                if ($permiso) {
                    foreach ($permiso as $saved) $saved->delete();
                }

                if ($value > 0) {
                    $npermiso = new RolPermiso();
                    $npermiso->id_rol = $rol;
                    $npermiso->id_permiso = $report_permiso->id_permiso;
                    $npermiso->editar = 0;
                    $npermiso->ver = 1;
                    $npermiso->save();
                }
            }
        }
        return response()->json(['success' => true, 'data' => $arr]);
    }

    public function map_adicionales($users)
    {
        $arr = [];
        foreach ($users as $user) {
            $roles_adicionales = $user->roles_adicionales;
            if (!is_null($roles_adicionales)) $roles_adicionales = json_decode($roles_adicionales);
            else $roles_adicionales = [];

            if (count($roles_adicionales) > 0) {
                $temp = [];
                foreach ($roles_adicionales as $rol_adicional) {
                    $rol = Rol::find($rol_adicional);
                    if ($rol) array_push($temp, $rol);
                    else array_push($temp, null);
                }
                $user->roles_adicionales = $temp;
            } else $user->roles_adicionales = [];
            array_push($arr, $user);
        }
        return $arr;
    }

    public function modular(Request $request)
    {
        // $names = $request->names;
        // $arr = [];
        // foreach ($names as $name) {
        //     $permiso = Permiso::where('descripcion', 'like', '%' . $name . '%')->get();
        //     if (count($permiso) > 0) array_push($arr, $permiso);
        // }
        // return $arr;
        $modulo = $request->modulo;
        $user = Usuario::find(Auth::user()->id_usuario);

        if ($user->tienePermiso($modulo)) {
            $id_rol = $user->rol->id_rol;
            $id_permiso = Permiso::where('nombre_interno', $modulo)->first()->id_permiso;
            $accesos = RolPermiso::where('id_rol', $id_rol)->where('id_permiso', $id_permiso)->first();
            return response()->json(['success' => true, 'permiso' => true, 'accesos' => $accesos]);
        }
        return response()->json(['success' => true, 'permiso' => false]);
    }
}
