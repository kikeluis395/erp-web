@extends('mecanica.tableCanvas')
@section('titulo', 'Usuarios y Perfiles - Administración')

@section('pretable-content')
    <div style="background: white;padding: 10px">
        <h2 class="ml-3 mt-3 mb-0">Usuarios y Perfiles</h2>
    </div>
@endsection

@section('table-content')
    <script>
        var modulos_admin = {!! $modulos_admin !!};
        var roles = {!! $rols !!};
        var accesos = {!! $accesos !!};
        var areas = {!! json_encode($areas) !!};
    </script>
    <style>
        .title_section {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 10px 30px;
            min-width: 100%;
            border-radius: 7px 7px 0 0;
        }

        .content_section {
            border: solid;
            border-width: 1px;
            border-color: #0000004d;
            border-top-width: 0px;
            border-radius: 0px 0px 7px 7px;
            padding-top: 2rem;
            padding-bottom: 1rem;
            position: relative;
        }

        .table_content_section {
            overflow-x: hidden;
            /* border: solid;
                                                                                                                                                                                                                                                                                                                                                                                                                        border-width: 1px;
                                                                                                                                                                                                                                                                                                                                                                                                                        border-color: #0000004d; */
            /* border-top-width: 0px;
                                                                                                                                                                                                                                                                                                                                                                                                                        border-radius: 0px 0px 7px 7px; */

            position: relative;
        }


        .section_button button {
            padding: 10px 50px;
            /* border-radius: 10px; */
            text-transform: uppercase;
            font-size: 18px
        }

        .form_section {
            position: relative;
        }

        .table_section td {
            padding: 10px 55px;
        }

        label {
            height: fit-content;
            font-size: 1.2em !important
        }

        .form-group {
            height: fit-content;
        }

        .alert-danger {
            background-color: #f9f0f1;
        }

        .glose_inf {
            border-radius: 10px 10px 7px 7px;
            position: absolute;
            bottom: -15px;
            border-bottom-width: 0;
            border-left-width: 0;
            border-right-width: 0;
        }

        .glose_sup {
            border-radius: 7px 7px 10px 10px;
            position: absolute;
            top: 0px;
            border-top-width: 0;
            border-left-width: 0;
            border-right-width: 0;
        }

        .custom-control-label {
            padding-left: 2rem;
            padding-bottom: 0.1rem;
        }

        .custom-switch .custom-control-label::before {
            left: -2.25rem;
            height: 1.5rem;
            width: 3rem;
            pointer-events: all;
            border-radius: 1.5rem;
        }

        .custom-switch .custom-control-label::after {
            top: calc(0.25rem + 2px);
            left: calc(-2.25rem + 2px);
            width: calc(1.5rem - 4px);
            height: calc(1.5rem - 4px);
            background-color: #adb5bd;
            border-radius: 1.5rem;
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-transform 0.15s ease-in-out;
            transition: transform 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: transform 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-transform 0.15s ease-in-out;
        }

        @media (prefers-reduced-motion: reduce) {
            .custom-switch .custom-control-label::after {
                transition: none;
            }
        }

        .custom-switch .custom-control-input:checked~.custom-control-label::after {
            background-color: #fff;
            -webkit-transform: translateX(1.5rem);
            transform: translateX(1.5rem);
        }

        .first_column {
            font-weight: bold;
            padding: 4px 35px !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.068)
        }

        tbody td {
            padding: 4px 8px
        }

        th,
        td {
            border-right: 1px solid rgba(0, 0, 0, 0.068)
        }


        .danho_table th,
        .danho_table td {
            border-bottom: 1px solid rgba(0, 0, 0, 0.068)
        }

        .long {
            padding: 4px 15px
        }

        .table_content_section thead tr th:first-child {
            border-left-width: 0px;
            border-radius: 7px 0px 0px 0px;
        }

        .table_content_section thead tr th:last-child {
            border-right-width: 0px;
            border-radius: 0px 7px 0px 0px;
        }

        .table_content_section tbody tr td:first-child {
            border-left: 1px solid rgba(0, 0, 0, 0.068);
        }

        .table_content_section tbody tr td:last-child {
            border-left: 1px solid rgba(0, 0, 0, 0.068);
        }

        .table_content_section tbody tr:last-child td {
            border-bottom: 1px solid rgba(0, 0, 0, 0.068);
        }

        .table_content_section tbody tr:last-child td:first-child {
            border-radius: 0px 0px 0px 7px;
        }

        #myTab>li>a {
            padding: 12px 40px;
            color: #000;
            text-transform: uppercase;
            font-size: 16px;
            border-bottom-width: 0px;
            border-radius: 14px 14px 0px 0px;
            font-weight: bold;
        }

        #myTab>li>a.active,
        #myTab>li>a:hover {
            border-radius: 14px 14px 0px 0px;
            background-color: #435d7d83;
            border-color: #435d7d;
            color: #fff;
        }

        .nav-tabs {
            border-bottom-width: 0px !important
        }

        .unsigned_user {
            color: red
        }

        .button-rol {
            height: 35px;
            width: 35px;
            margin: 2px;
            place-content: center;
            place-items: center;
            display: flex;
        }

        .button-rol i {
            font-size: 14px !important
        }

        label {
            font-size: .8em !important;
        }

        .check_ab {
            /* position: absolute; */
            /* opacity: 0; */
        }

        #users a {
            font-weight: bold;
            color: #566787;
            text-decoration: none !important;
            outline: none !important;
        }

        #users a:hover {
            color: #2196F3;
        }

    </style>
    <div class="mx-3"
         style="background: white;padding: 15px;overflow-y:auto;">

        @php
            if (!isset(request()->tab)) {
                request()->tab = 'users';
            }
        @endphp
        <ul class="nav nav-tabs"
            id="myTab"
            role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ isset(request()->tab) && request()->tab === 'users' ? 'active' : '' }}"
                   data-toggle="tab"
                   data-tab="users"
                   href="#users"
                   role="tab"
                   aria-controls="users"
                   aria-selected="true">Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ isset(request()->tab) && request()->tab === 'modules' ? 'active' : '' }}"
                   data-toggle="tab"
                   data-tab="modules"
                   href="#modules"
                   role="tab"
                   aria-controls="modules"
                   aria-selected="false">Modulos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ isset(request()->tab) && request()->tab === 'reports' ? 'active' : '' }}"
                   data-toggle="tab"
                   data-tab="reports"
                   href="#reports"
                   role="tab"
                   aria-controls="reports"
                   aria-selected="false">Reportes</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade {{ isset(request()->tab) && request()->tab === 'users' ? 'show active' : '' }}"
                 id="users"
                 role="tabpanel">

                <div style="position: absolute; top:70px; right:40px">
                    @include('modals.crearUsuario')
                </div>

                <div>
                    <div class="table-responsive">

                        <div class="table-cont-single table_content_section">

                            <table class="table text-center table-striped table-sm tableTerceros">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>

                                        <th scope="col">ACTIVO</th>
                                        <th scope="col">DNI</th>
                                        <th scope="col">NOMBRES</th>
                                        <th scope="col">APELLIDO PAT</th>
                                        <th scope="col">APELLIDO MAT</th>
                                        {{-- <th scope="col">TELEFONO</th>
                                        <th scope="col">CORREO</th> --}}
                                        <th scope="col">USUARIO</th>
                                        <th scope="col">ROL</th>
                                        <th scope="col">DETALLE</th>
                                        <th scope="col">ELIMINAR</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($usuarios as $usuario)

                                        <tr>
                                            <td scope="row">{{ $loop->iteration }}</td>

                                            <td>
                                                @if ($usuario->habilitado === 1)
                                                    <span class="badge badge-success">ACTIVO</span>
                                                @else
                                                    <span class="badge badge-danger">INACTIVO</span>
                                                @endif
                                            </td>
                                            <td>{{ $usuario->dni }}</td>
                                            <td>{{ $usuario->empleado->primer_nombre }}</td>
                                            <td>{{ $usuario->empleado->primer_apellido }}</td>
                                            <td>{{ $usuario->empleado->segundo_apellido }}</td>
                                            {{-- <td>{{ $usuario->empleado->telefono_contacto }}</td>
                                            <td>{{ $usuario->empleado->email }}</td> --}}
                                            <td>{{ $usuario->username }}</td>
                                            @php
                                                $class = '';
                                                $rol = $usuario->rol->nombre_rol;
                                                $rol_interno = $usuario->rol->nombre_interno;
                                                if ($rol_interno === 'unsigned') {
                                                    $rol = 'NO ASIGNADO';
                                                    $class = 'unsigned_user';
                                                }
                                            @endphp
                                            <td class="{{ $class }}">{{ $rol }}</td>
                                            <td>
                                                @include('modals.detalleUsuario')
                                            </td>
                                            <td>
                                                @if (!$usuario->hasRelation() && $admin != $usuario->id_rol)
                                                    <form method="DELETE"
                                                          id="deleteUSER-{{ $usuario->id_usuario }}"
                                                          action="{{ route('perfiles.destroy', ['perfile' => $usuario->id_usuario]) }}">

                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-warning">
                                                            <i class="fas fa-trash icono-btn-tabla"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @php
                if (isset(request()->area)) {
                    $tab_area = request()->area;
                } else {
                    if (count($areas) > 0) {
                        $tab_area = $areas[0];
                    } else {
                        $tab_area = '';
                    }
                }
            @endphp

            <div class="tab-pane fade {{ isset(request()->tab) && request()->tab === 'modules' ? 'show active' : '' }}"
                 id="modules"
                 role="tabpanel">

                <div style="position: absolute; top:70px; right:40px">
                    <select class="form-control w-100 area_rol"
                            data-container-tabs="areas_tabs">
                        @foreach ($areas as $area)
                            <option value="{{ $area }}"
                                    {{ $tab_area === $area ? 'selected' : '' }}>{{ $area }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="none"
                     id="areas_tabs">
                    @foreach ($areas as $area)
                        <a class="none"
                           data-toggle="tab"
                           href="#areas_tabs_{{ \Helper::sinVocals($area) }}"
                           role="tab"
                           aria-controls="{{ \Helper::sinVocals($area) }}"
                           aria-selected="false"></a>
                    @endforeach
                </div>


                <form id="formModulosRoles"
                      method="POST"
                      action="{{ route('perfiles.accesos') }}"
                      class="form_section">

                    @csrf

                    <div class="tab-content">
                        @foreach ($areas as $area)
                            <div class="tab-pane fade {{ $tab_area === $area ? 'show active' : '' }}"
                                 id="areas_tabs_{{ \Helper::sinVocals($area) }}"
                                 role="tabpanel">

                                <div>
                                    <div class="table-responsive">

                                        <div class="table-cont-single table_content_section">

                                            <table class="table text-center table-striped table-sm tableTerceros">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">MODULO</th>
                                                        @foreach ($rols as $rol)
                                                            @if ($rol->area === $area)
                                                                <th style="font-weight: bold; text-align:center; font-size:11px"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="{{ $rol->nombre_rol }}">
                                                                    {{ $rol->nombre_rol }}
                                                                </th>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($modulos_admin as $modulo)
                                                        @if ($modulo->nombre_interno != 'modulo_reportes')
                                                            <tr>
                                                                <td align="center"
                                                                    style="font-weight: bold">{{ $modulo->descripcion }}
                                                                </td>
                                                                @foreach ($rols as $rol)
                                                                    @if ($rol->area === $area)
                                                                        @php
                                                                            $name = 'R' . $rol->id_rol . 'P' . $modulo->id_permiso;
                                                                            $valor = $mapeo[$name];
                                                                            $ver = $valor['ver'] === 1;
                                                                            $editar = $valor['editar'] === 1;
                                                                            
                                                                            $rm_admin = $modulo->nombre_interno === 'modulo_administracion' && $rol->nombre_interno === 'administrador' && ($ver || $editar);
                                                                        @endphp
                                                                        <td align="center">

                                                                            @if (!$rm_admin)
                                                                                <div class="btn-group"
                                                                                     role="group">

                                                                                    <label class="btn {{ $ver ? 'btn-primary' : 'btn-outline-primary' }} rounded-circle button-rol btn-admin"
                                                                                           for="ver-{{ $name }}"
                                                                                           id="label-ver-{{ $name }}">
                                                                                        <i class="fas fa-eye mx-0"></i>
                                                                                    </label>

                                                                                    <label class="btn {{ $editar ? 'btn-primary' : 'btn-outline-primary' }} rounded-circle button-rol btn-admin"
                                                                                           for="editar-{{ $name }}"
                                                                                           id="label-editar-{{ $name }}">
                                                                                        <i class="fas fa-edit mx-0"></i>
                                                                                    </label>
                                                                                </div>
                                                                            @endif

                                                                        </td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="row w-100 justify-content-end mt-3">
                        <div class="section_button">
                            <button type="submit"
                                    form="formModulosRoles"
                                    class="btn btn-primary rounded-pill">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade {{ isset(request()->tab) && request()->tab === 'reports' ? 'show active' : '' }}"
                 id="reports"
                 role="tabpanel">

                <div style="position: absolute; top:70px; right:40px">
                    <select class="form-control w-100 area_rol"
                            data-container-tabs="area_reports">
                        @foreach ($areas as $area)
                            <option value="{{ $area }}"
                                    {{ $tab_area === $area ? 'selected' : '' }}>{{ $area }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="none"
                     id="area_reports">
                    @foreach ($areas as $area)
                        <a class="none"
                           data-toggle="tab"
                           href="#area_reports_{{ \Helper::sinVocals($area) }}"
                           role="tab"
                           aria-controls="{{ \Helper::sinVocals($area) }}"
                           aria-selected="false"></a>
                    @endforeach
                </div>


                <form id="formSubmodulosReportes"
                      method="POST"
                      action="{{ route('perfiles.reportes') }}"
                      class="form_section">

                    @csrf

                    <div class="tab-content">
                        @foreach ($areas as $area)
                            <div class="tab-pane fade {{ $tab_area === $area ? 'show active' : '' }}"
                                 id="area_reports_{{ \Helper::sinVocals($area) }}"
                                 role="tabpanel">

                                <div>
                                    <div class="table-responsive">

                                        <div class="table-cont-single table_content_section">

                                            <table class="table text-center table-striped table-sm tableTerceros">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">MODULO</th>
                                                        @foreach ($rols as $rol)
                                                            @if ($rol->area === $area)
                                                                <th style="font-weight: bold; text-align:center; font-size:11px"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="{{ $rol->nombre_rol }}">
                                                                    {{ $rol->nombre_rol }}
                                                                </th>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($modulos_report as $modulo)
                                                        <tr>
                                                            <td align="center"
                                                                style="font-weight: bold">{{ $modulo->descripcion }}</td>
                                                            @foreach ($rols as $rol)
                                                                @if ($rol->area === $area)
                                                                    @php
                                                                        $name = 'R' . $rol->id_rol . 'P' . $modulo->id_permiso;
                                                                        $valor = $reports[$name];
                                                                        $ver = $valor['ver'] === 1;
                                                                        $editar = $valor['editar'] === 1;
                                                                        
                                                                        //    $rm_admin = $modulo->nombre_interno === 'modulo_administracion' && $rol->nombre_rol === 'ADMINISTRADOR' && ($ver || $editar);
                                                                        
                                                                    @endphp
                                                                    <td align="center">

                                                                        <div class="btn-group"
                                                                             role="group">

                                                                            <label class="btn {{ $ver ? 'btn-primary' : 'btn-outline-primary' }} rounded-circle button-rol btn-report"
                                                                                   for="ver-{{ $name }}"
                                                                                   id="label-ver-{{ $name }}">
                                                                                <i class="fas fa-eye mx-0"></i>
                                                                            </label>


                                                                        </div>

                                                                    </td>
                                                                @endif
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="row w-100 justify-content-end mt-3">
                        <div class="section_button">
                            <button type="submit"
                                    form="formSubmodulosReportes"
                                    class="btn btn-primary rounded-pill">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



    </div>
@endsection


@section('extra-scripts')
    @parent
    <script src="{{ asset('js/perfiles.js') }}"></script>
    <script src="{{ asset('js/switch.js') }}"></script>
@endsection
