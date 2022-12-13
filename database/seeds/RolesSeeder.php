<?php

use App\Modelos\Administracion\RolPermiso;
use App\Modelos\Permiso;
use App\Modelos\Rol;
use App\Modelos\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //UNSIGNED
        $id_temp = DB::table('rol')->insertGetId(['nombre_rol' => 'UNSIGNED', 'area' => '', 'nombre_interno' => 'unsigned']);
        $users = Usuario::all();
        foreach ($users as $user) {
            $user->id_rol = $id_temp;
            $user->save();
        }
        //DELETE OLD ROLES
        $roles = Rol::where('nombre_rol', '!=', 'UNSIGNED')->get();
        foreach ($roles as $rol) $rol->delete();

        //PUT NEW ROLES
        $data = [
            ['nombre_rol' => 'ASESOR DE SERVICIOS', 'area' => 'POSVENTA', 'nombre_interno' => 'asesor_servicios'],
            ['nombre_rol' => 'ASESOR DE REPUESTOS', 'area' => 'POSVENTA', 'nombre_interno' => 'asesor_repuestos'],
            ['nombre_rol' => 'JEFE DE TALLER', 'area' => 'POSVENTA', 'nombre_interno' => 'jefe_taller'],
            ['nombre_rol' => 'GERENTE DE POSVENTA', 'area' => 'POSVENTA', 'nombre_interno' => 'gerente_posventa'],
            ['nombre_rol' => 'JEFE DE REPUESTOS', 'area' => 'POSVENTA', 'nombre_interno' => 'jefe_repuestos'],
            ['nombre_rol' => 'CALL CENTER', 'area' => 'POSVENTA', 'nombre_interno' => 'call_center'],
            ['nombre_rol' => 'TECNICO MECÁNICO', 'area' => 'POSVENTA', 'nombre_interno' => 'tecnico_mecanico'],
            ['nombre_rol' => 'TECNICO CARROCERO', 'area' => 'POSVENTA', 'nombre_interno' => 'tecnico_carrocero'],
            ['nombre_rol' => 'ASISTENTE POSVENTA', 'area' => 'POSVENTA', 'nombre_interno' => 'asistente_posventa'],
            ['nombre_rol' => 'ASESOR DE VENTAS', 'area' => 'VENTAS', 'nombre_interno' => 'asesor_ventas'],
            ['nombre_rol' => 'ASESOR DE ACCESORIOS', 'area' => 'VENTAS', 'nombre_interno' => 'asesor_accesorios'],
            ['nombre_rol' => 'PDI', 'area' => 'VENTAS', 'nombre_interno' => 'pdi'],
            ['nombre_rol' => 'ASESOR DE ENTREGAS', 'area' => 'VENTAS', 'nombre_interno' => 'asesor_entregas'],
            ['nombre_rol' => 'JEFE DE VENTAS', 'area' => 'VENTAS', 'nombre_interno' => 'jefe_ventas'],
            ['nombre_rol' => 'GERENTE DE VENTAS', 'area' => 'VENTAS', 'nombre_interno' => 'gerente_ventas'],
            ['nombre_rol' => 'CAJA', 'area' => 'ADMINISTRACIÓN', 'nombre_interno' => 'caja'],
            ['nombre_rol' => 'CONTABILIDAD', 'area' => 'ADMINISTRACIÓN', 'nombre_interno' => 'contabilidad'],
            ['nombre_rol' => 'FINANZAS', 'area' => 'ADMINISTRACIÓN', 'nombre_interno' => 'finanzas'],
            ['nombre_rol' => 'RRHH', 'area' => 'ADMINISTRACIÓN', 'nombre_interno' => 'rrhh'],
            ['nombre_rol' => 'JEFE DE CONTABILIDAD', 'area' => 'ADMINISTRACIÓN', 'nombre_interno' => 'jefe_contabilidad'],
            ['nombre_rol' => 'ADMINISTRADOR', 'area' => 'ADMINISTRACIÓN', 'nombre_interno' => 'administrador'],
        ];
        foreach ($data as $record) DB::table('rol')->insert($record);

        $asesor_servicio =  Rol::where('nombre_interno', '=', 'asesor_servicios')->get()->first()->id_rol;
        $asesor_repuestos =  Rol::where('nombre_interno', '=', 'asesor_repuestos')->get()->first()->id_rol;
        $jefe_taller =  Rol::where('nombre_interno', '=', 'jefe_taller')->get()->first()->id_rol;
        $jefe_repuestos =  Rol::where('nombre_interno', '=', 'jefe_repuestos')->get()->first()->id_rol;
        $asistente_postventa =  Rol::where('nombre_interno', '=', 'asistente_posventa')->get()->first()->id_rol;
        $caja =  Rol::where('nombre_interno', '=', 'caja')->get()->first()->id_rol;
        $administrador =  Rol::where('nombre_interno', '=', 'administrador')->get()->first()->id_rol;

        $asesores_serv = ['jnapuri', 'rlopez', 'ryepez', 'wrios'];
        $asesores_repu = ['spacheco', 'cgomez'];
        $jefes_taller = ['rsaravia', 'jlopez', 'jyarleque'];
        $jefes_repu = ['jvalladares'];
        $asistentes = ['ecaceres'];
        $cajeros = ['pchavez'];
        $admin = ['admin', 'storrejon', 'webadmin'];

        foreach ($users as $user) {
            $username = $user->username;
            if (in_array($username, $asesores_serv)) $user->id_rol = $asesor_servicio;
            else if (in_array($username, $asesores_repu)) $user->id_rol = $asesor_repuestos;
            else if (in_array($username, $jefes_taller)) $user->id_rol = $jefe_taller;
            else if (in_array($username, $jefes_repu)) $user->id_rol = $jefe_repuestos;
            else if (in_array($username, $asistentes)) $user->id_rol = $asistente_postventa;
            else if (in_array($username, $cajeros)) $user->id_rol = $caja;
            else if (in_array($username, $admin)) $user->id_rol = $administrador;
            else $user->habilitado = 0;
            $user->save();
        }

        DB::delete("DELETE FROM rol_permiso");
        $permisos = Permiso::all();
        foreach ($permisos as $permiso) {
            $rol_permiso = new RolPermiso();
            $rol_permiso->id_permiso = $permiso->id_permiso;
            $rol_permiso->id_rol = $administrador;
            $rol_permiso->editar = 1;
            $rol_permiso->ver = 0;
            $rol_permiso->save();
        }
    }
}
