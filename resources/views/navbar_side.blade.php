<style>
    .sb-nav-link-icon {
        width: 25px;
        text-align: center;
    }

</style>

<nav class="sb-sidenav accordion sb-sidenav-dark"
     id="sidenavAccordion"
     style="background-color: #081f2d!important">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Módulos del Sistema</div>
            @if (Auth::user()->tienePermiso('modulo_carroceriaPintura'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseCarroceriaPintura"
                   aria-expanded="false"
                   aria-controls="collapseCarroceriaPintura">
                    <div class="sb-nav-link-icon"><i class="fas fa-car"></i></div>
                    Carrocería y Pintura
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseCarroceriaPintura"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (Auth::user()->tienePermiso('submodulo_crearOTByP'))
                                <a class="nav-link"
                                   modulo="submodulo_crearOTByP"
                                   href="{{ route('dyp.registrarOT') }}">Crear OT</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_segAprobacionByP'))
                                <a class="nav-link"
                                   modulo="submodulo_segAprobacionByP"
                                   href="{{ route('valuacion.index') }}">Seg. Aprobación</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_segReparacionByP'))
                                <a class="nav-link"
                                   modulo="submodulo_segReparacionByP"
                                   href="{{ route('reparacion.index') }}">Seg. Reparación</a>
                            @endif

                            @if (Auth::user()->tienePermiso('submodulo_segOTsByP'))
                                <a class="nav-link"
                                   modulo="submodulo_segOTsByP"
                                   href="{{ route('recepcion.index') }}">Seg. OTs</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_crearCotizacionByP'))
                                <a class="nav-link"
                                   modulo="submodulo_crearCotizacionByP"
                                   href="{{ route('dyp.registrarCotizacion') }}">Crear Cotización</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_segCotizacionByP'))
                                <a class="nav-link"
                                   modulo="submodulo_segCotizacionByP"
                                   href="{{ route('cotizaciones.index') }}">Seg. Cotización</a>
                            @endif

                        </nav>
                    </div>
                </div>
            @endif


            @if (Auth::user()->tienePermiso('modulo_mecanica'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseMecanica"
                   aria-expanded="false"
                   aria-controls="collapseMecanica">
                    <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                    Mecánica
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseMecanica"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (Auth::user()->tienePermiso('submodulo_crearOTMec'))
                                <a class="nav-link"
                                   modulo="submodulo_crearOTMec"
                                   href="{{ route('mecanica.registrarOT') }}">Crear OT</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_segReparacionMec'))
                                <a class="nav-link"
                                   modulo="submodulo_segReparacionMec"
                                   href="{{ route('mecanica.reparacion.index') }}">Seg. Reparación</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_segOTsMec'))
                                <a class="nav-link"
                                   modulo="submodulo_segOTsMec"
                                   href="{{ route('mecanica.recepcion.index') }}">Seg. OTs</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_crearCotizacionMec'))
                                <a class="nav-link"
                                   modulo="submodulo_crearCotizacionMec"
                                   href="{{ route('mecanica.registrarCotizacion') }}">Crear Cotización</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_segCotizacionMec'))
                                <a class="nav-link"
                                   modulo="submodulo_segCotizacionMec"
                                   href="{{ route('mecanica.cotizaciones.index') }}">Seg. Cotizaciones</a>
                            @endif

                        </nav>
                    </div>
                </div>
            @endif


            <a class="nav-link collapsed"
               href="#"
               data-toggle="collapse"
               data-target="#collapseOtrosProductos"
               aria-expanded="false"
               aria-controls="collapseOtrosProductos">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Otros Productos
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div>
                <div class="collapse"
                     id="collapseOtrosProductos"
                     aria-labelledby="headingOne"
                     data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        {{-- @if (Auth::user()->tienePermiso('submodulo_crearOTMec')) --}}
                        <a class="nav-link"
                           href="{{ route('otros_productos.index') }}">Listar</a>
                        {{-- @endif --}}
                    </nav>
                </div>
            </div>

            @if (Auth::user()->tienePermiso('modulo_tecnicos'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseTecnicos"
                   aria-expanded="false"
                   aria-controls="collapseTecnicos">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-md"></i></div>
                    Técnicos
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseTecnicos"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (Auth::user()->tienePermiso('submodulo_tecnicosMEC'))
                                <a class="nav-link"
                                   modulo="submodulo_tecnicosMEC"
                                   href="{{ route('mecanica.tecnicos.index') }}">Técnicos MEC</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_tecnicosByP'))
                                <a class="nav-link"
                                   modulo="submodulo_tecnicosByP"
                                   href="{{ route('tecnicos.index') }}">Técnicos B&P</a>
                            @endif

                        </nav>
                    </div>
                </div>
            @endif

            @if (Auth::user()->tienePermiso('modulo_repuestos'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseRepuestosTaller"
                   aria-expanded="false"
                   aria-controls="collapseRepuestos">
                    <div class="sb-nav-link-icon"><i class="fas fa-hammer"></i></div>
                    Repuestos Taller
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseRepuestosTaller"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">

                            @if (Auth::user()->tienePermiso('submodulo_solicitudesTallerOts'))
                                <a class="nav-link"
                                   modulo="submodulo_solicitudesTallerOts"
                                   href="{{ route('repuestosOT') }}">Solicitudes OT</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_solicitudesTallerCotizaciones'))
                                <a class="nav-link"
                                   modulo="submodulo_solicitudesTallerCotizaciones"
                                   href="{{ route('repuestosCot') }}">Solicitudes Cotizaciones</a>
                            @endif

                        </nav>
                    </div>
                </div>
            @endif

            @if (Auth::user()->tienePermiso('modulo_repuestos'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseRepuestosMeson"
                   aria-expanded="false"
                   aria-controls="collapseRepuestos">
                    <div class="sb-nav-link-icon"><i class="fas fa-hammer"></i></div>
                    Repuestos Mesón
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseRepuestosMeson"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (Auth::user()->tienePermiso('submodulo_crearCotizacionRepuestos'))
                                <a class="nav-link"
                                   modulo="submodulo_crearCotizacionRepuestos"
                                   href="{{ route('meson.create') }}">Crear Cotización</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_segCotizacionRepuestos'))
                                <a class="nav-link"
                                   modulo="submodulo_segCotizacionRepuestos"
                                   href="{{ route('meson.index') }}">Seg. Cotización</a>
                            @endif


                        </nav>
                    </div>
                </div>
            @endif

            @if (Auth::user()->tienePermiso('modulo_ventas'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseVentas"
                   aria-expanded="false"
                   aria-controls="collapseLogistica">
                    <div class="sb-nav-link-icon"><i class="fas fa-dollar-sign"></i></div>
                    Ventas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseVentas"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (Auth::user()->tienePermiso('submodulo_crearPDI'))
                                <a class="nav-link"
                                   modulo="submodulo_crearPDI"
                                   href="{{ route('hojaInspeccion.createView') }}">Crear PDI</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_seguimientoPDI'))
                                <a class="nav-link"
                                   modulo="submodulo_seguimientoPDI"
                                   href="{{ route('hojaInspeccion.listView') }}">Seguimiento PDI</a>
                            @endif

                            {{-- @if (Auth::user()->tienePermiso('submodulo_seguimientoPDI')) --}}
                            <a class="nav-link"
                               href="{{ route('precios_nuevo.index') }}">Precios Vehiculos Nuevos</a>
                            {{-- @endif --}}
                            {{-- @if (Auth::user()->tienePermiso('submodulo_seguimientoPDI')) --}}
                            <a class="nav-link"
                               href="{{ route('precios_seminuevo.index') }}">Precios Vehiculos Seminuevos</a>
                            {{-- @endif --}}
                        </nav>
                    </div>
                </div>
            @endif

            @if (Auth::user()->tienePermiso('modulo_logistica'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseLogistica"
                   aria-expanded="false"
                   aria-controls="collapseLogistica">
                    <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                    Logística
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseLogistica"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{route('ingreso_vehiculo_seminuevo.show')}}">Ingreso de vehiculos</a>
                            @if (Auth::user()->tienePermiso('submodulo_seguimientoOS'))
                                <a class="nav-link"
                                   modulo="submodulo_seguimientoOS"
                                   href="{{ route('seguimientoServiciosTerceros') }}">Órdenes de Servicio</a>
                            @endif

                            @if (Auth::user()->tienePermiso('submodulo_seguimientoOC'))
                                <a class="nav-link"
                                   modulo="submodulo_seguimientoOC"
                                   href="{{ route('contabilidad.seguimientoOC') }}">Órdenes de Compra</a>
                            @endif

                            @if (Auth::user()->tienePermiso('submodulo_seguimientoNotasIngreso'))
                                <a class="nav-link"
                                   modulo="submodulo_seguimientoNotasIngreso"
                                   href="{{ route('contabilidad.seguimientoNotasIngreso') }}">Notas de Ingreso</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_maestroRepuestos'))
                                <a class="nav-link"
                                   modulo="submodulo_maestroRepuestos"
                                   href="{{ route('administracion.admrepuesto.create') }}">Maestro de Repuestos</a>
                            @endif

                            {{-- @if (Auth::user()->tienePermiso('submodulo_maestroRepuestos')) --}}
                            <a class="nav-link"
                               href="{{ route('vehiculonuevo.index') }}">Maestro de Vehiculos Nuevos</a>
                            {{-- @endif --}}

                            @if (Auth::user()->tienePermiso('submodulo_maestroServiciosTerceros'))
                                <a class="nav-link"
                                   modulo="submodulo_maestroServiciosTerceros"
                                   href="{{ route('administracion.serviciosTerceros.index') }}">Maestro de Servicios
                                    Terceros</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_gestionProveedores'))
                                <a class="nav-link"
                                   modulo="submodulo_gestionProveedores"
                                   href="{{ route('contabilidad.proveedores.index') }}">Gestión de Proveedores</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_consultaRepuestos'))
                                <a class="nav-link"
                                   modulo="submodulo_consultaRepuestos"
                                   href="{{ route('consultas.repuestos') }}">Consulta de Repuestos</a>
                            @endif
                            <a class="nav-link"
                               href="{{ route('reingresoRepuestos.index') }}">Movimiento de Almacén</a>

                        </nav>
                    </div>
                </div>
            @endif


            @if (Auth::user()->tienePermiso('modulo_facturacion'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseFacturacion"
                   aria-expanded="false"
                   aria-controls="collapseFacturacion">
                    <div class="sb-nav-link-icon"><i class="fas fa-money-bill-alt"></i></div>
                    Facturación
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseFacturacion"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">

                            @if (Auth::user()->tienePermiso('submodulo_entrega'))
                                <a class="nav-link"
                                   modulo="submodulo_entrega"
                                   href="{{ route('entrega.index') }}">Entrega</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_facturacion'))
                                <a class="nav-link"
                                   modulo="submodulo_facturacion"
                                   href="{{ route('contabilidad.facturacion') }}">Facturación</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_notasCredito'))
                                <a class="nav-link"
                                   modulo="submodulo_notasCredito"
                                   href="{{ route('contabilidad.notaCredito') }}">Notas de Credito</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_seguimientoFacturacion'))
                                <a class="nav-link"
                                   modulo="submodulo_seguimientoFacturacion"
                                   href="{{ route('contabilidad.seguimientoFacturacion') }}">Seguimiento
                                    Facturación</a>
                            @endif

                        </nav>
                    </div>
                </div>
            @endif

            @if (Auth::user()->tienePermiso('modulo_garantias'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseGarantias"
                   aria-expanded="false"
                   aria-controls="collapseGarantias">
                    <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div>
                    Garantías
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseGarantias"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (Auth::user()->tienePermiso('submodulo_seguimientoGarantias'))
                                <a class="nav-link"
                                   modulo="submodulo_seguimientoGarantias"
                                   href="{{ route('garantia.index') }}">Seguimiento Garantías</a>
                            @endif
                        </nav>
                    </div>
                </div>
            @endif


            @if (Auth::user()->tienePermiso('modulo_crm'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseCRM"
                   aria-expanded="false"
                   aria-controls="collapseCRM">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    CRM
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseCRM"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (Auth::user()->tienePermiso('submodulo_tableroCitas'))
                                <a class="nav-link"
                                   modulo="submodulo_tableroCitas"
                                   href="{{ route('crm.citas.index') }}">Tablero de Citas</a>
                            @endif
                            @if (false)<a class="nav-link"
                                   href="{{ route('crm.seguimientoProactivo') }}">Próximo Servicio</a>@endif
                        </nav>
                    </div>
                </div>
            @endif



            @if (Auth::user()->tienePermiso('modulo_contabilidad'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseContabilidad"
                   aria-expanded="false"
                   aria-controls="collapseContabilidad">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Contabilidad
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseContabilidad"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (Auth::user()->tienePermiso('submodulo_gestionCompras'))
                                <a class="nav-link"
                                   modulo="submodulo_gestionCompras"
                                   href="{{ route('contabilidad.compras.index') }}">Gestión de Compras</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_seguimientoNotasIngreso'))
                                <a class="nav-link"
                                   modulo="submodulo_seguimientoNotasIngreso"
                                   href="{{ route('contabilidad.seguimientoNotasIngreso') }}">Seguimiento Notas
                                    Ingreso</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_ingresoFactura'))
                                <a class="nav-link"
                                   modulo="submodulo_ingresoFactura"
                                   href="{{ route('contabilidad.ingresoFacturasInicial') }}">Ingreso de Facturas</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_pagoProveedores'))
                                <a class="nav-link"
                                   modulo="submodulo_pagoProveedores"
                                   href="{{ route('contabilidad.pagoProveedores') }}">Pago a Proveedores</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_bancos'))
                                <a class="nav-link"
                                   modulo="submodulo_bancos"
                                   href="{{ route('contabilidad.bancos') }}">Bancos</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_cobroClientes'))
                                <a class="nav-link"
                                   modulo="submodulo_cobroClientes"
                                   href="{{ route('contabilidad.cobroClientes') }}">Cobro a Clientes</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_generarComprobante'))
                                <a class="nav-link"
                                   modulo="submodulo_generarComprobante"
                                   href="{{ route('contabilidad.generarComprobante') }}">Generar Comprobante</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_historicoPagos'))
                                <a class="nav-link"
                                   modulo="submodulo_historicoPagos"
                                   href="{{ route('contabilidad.historicoPagos') }}">Histórico de Pagos</a>
                            @endif
                        </nav>
                    </div>
                </div>
            @endif

            @if (Auth::user()->tienePermiso('modulo_consultas'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseConsultas"
                   aria-expanded="false"
                   aria-controls="collapseConsultas">
                    <div class="sb-nav-link-icon"><i class="fas fa-search"></i></div>
                    Consultas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseConsultas"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (Auth::user()->tienePermiso('submodulo_consultaOTs'))
                                <a class="nav-link"
                                   modulo="submodulo_consultaOTs"
                                   href="{{ route('consultas.ordenesTrabajo') }}">Consulta OTS</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_consultaCotizaciones'))
                                <a class="nav-link"
                                   modulo="submodulo_consultaCotizaciones"
                                   href="{{ route('consultas.cotizaciones') }}">Consulta Cot. Taller</a>
                            @endif

                            @if (Auth::user()->tienePermiso('submodulo_consultaMeson'))
                                <a class="nav-link"
                                   modulo="submodulo_consultaMeson"
                                   href="{{ route('consultas.meson') }}">Consulta Mesón</a>
                            @endif

                            @if (Auth::user()->tienePermiso('submodulo_historiaClinica'))
                                <a class="nav-link"
                                   modulo="submodulo_historiaClinica"
                                   href="{{ route('consultas.historiaClinica') }}">Historia Clínica</a>
                            @endif

                        </nav>
                    </div>
                </div>
            @endif


            @if (Auth::user()->tienePermiso('modulo_reportes'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseReportes"
                   aria-expanded="false"
                   aria-controls="collapseReportes">
                    <div class="sb-nav-link-icon"><i class="far fa-chart-bar"></i></div>
                    Reportes
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseReportes"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">                            

                            @if (Auth::user()->tienePermiso('submodulo_reporteStock'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteStock"
                                   href="{{ route('reportes.consulta.stock') }}">Reporte de Stock</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteRepuestosObsoletos'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteRepuestosObsoletos"
                                   href="{{ route('reportes.informaRepuestosObsoletos') }}">Informe Repuestos
                                    Obsoletos</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteSeguimientoVentasRepuestos'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteSeguimientoVentasRepuestos"
                                   href="{{ route('reportes.seguimientoVentasRepuestos') }}">Seguimiento Ventas
                                    Repuestos</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteSeguimientoVentasTaller'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteSeguimientoVentasTaller"
                                   href="{{ route('reportes.seguimientoVentasTaller') }}">Seguimiento Ventas
                                    Taller</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteSeguimientoGeneral'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteSeguimientoGeneral"
                                   href="{{ route('reportes.seguimientoGeneral') }}">Seguimiento General</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteSeguimientoOT'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteSeguimientoOT"
                                   href="{{ route('reportes.consulta.cantidadots') }}">Reporte Seguimiento OT's</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteDetalleVentasMeson'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteDetalleVentasMeson"
                                   href="{{ route('reportes.consulta.ventasMeson') }}">Detalle Ventas Mesón</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteDetalleVentasMECBYP'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteDetalleVentasMECBYP"
                                   href="{{ route('reportes.consulta.ventas') }}">Detalle Ventas MEC-BYP</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteSeguimientoCitas'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteSeguimientoCitas"
                                   href="{{ route('reportes.consulta.reporteCitas') }}">Reporte Seguimiento de
                                    Citas</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteKardex'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteKardex"
                                   href="{{ route('reportes.consulta.kardex') }}">Kardex</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteCompras'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteCompras"
                                   href="{{ route('reportes.compras') }}">Reporte de Compras</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_reporteSeguimientoModelo'))
                                <a class="nav-link"
                                   modulo="submodulo_reporteSeguimientoModelo"
                                   href="{{ route('reportes.consulta.reporteModelos') }}">Reporte Seguimiento
                                    Modelo</a>
                            @endif

                        </nav>
                    </div>
                </div>
            @endif


            @if (Auth::user()->tienePermiso('modulo_administracion'))
                <a class="nav-link collapsed"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapseAdministracion"
                   aria-expanded="false"
                   aria-controls="collapseAdministracion">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                    Administración
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div>
                    <div class="collapse"
                         id="collapseAdministracion"
                         aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">

                            @if (Auth::user()->tienePermiso('submodulo_descuentos'))
                                <a class="nav-link"
                                   modulo="submodulo_descuentos"
                                   href="{{ route('descuentos.index') }}">Descuentos Taller</a>
                                <a class="nav-link"
                                   modulo="submodulo_descuentos"
                                   href="{{ route('descuentos.meson') }}">Descuentos Mesón</a>
                            @endif

                            @if (Auth::user()->tienePermiso('submodulo_bypMO'))
                                <a class="nav-link"
                                   modulo="submodulo_bypMO"
                                   href="{{ route('carroceria_mo.index') }}">BYP - Mano de Obra</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_mecMO'))
                                <a class="nav-link"
                                   modulo="submodulo_mecMO"
                                   href="{{ route('mecanica_mo.index') }}">MEC - Mano de Obra</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_pdiMO'))
                            <a class="nav-link"
                               href="{{ route('pdi_mo.index') }}">PDI - Mano de Obra</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_perfiles'))
                                <a class="nav-link"
                                   modulo="submodulo_perfiles"
                                   href="{{ route('perfiles.index') }}">Usuarios y Perfiles</a>
                            @endif
                            @if (Auth::user()->tienePermiso('submodulo_configuracionDealer'))
                                <a class="nav-link"
                                   modulo="submodulo_configuracionDealer"
                                   href="{{ route('dealer_config.index') }}">Generalidades del dealer</a>
                            @endif


                            @if (Auth::user()->tienePermiso('submodulo_tipoCambio'))
                                <a class="nav-link"
                                   modulo="submodulo_tipoCambio"
                                   href="{{ route('tipoCambio.index') }}">Tipo de Cambio</a>

                            @endif
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Usted inició sesión como:</div>
        {{ Auth::user()->empleado->nombreCompleto() }}
    </div>
</nav>

