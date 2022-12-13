<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class EmailTrackingController extends Controller
{
    public function show()
    {
        $fechaIngreso = null;
        $horaIngreso = null;
        $esParticular = 0;
        $fechaAprobacionSeguro = null;
        $horaAprobacionSeguro = null;
        $fechaAprobacionCliente = null;
        $horaAprobacionCliente = null;
        $fechaInicioReparacion = null;
        $horaInicioReparacion = null;
        $fechaVehiculoListo = null;
        $horaVehiculoListo = null;
        $fechaEntregaVehiculo = null;
        $horaEntregaVehiculo = null;

        if($_GET && array_key_exists('ingdt',$_GET)){
            $fechaIngreso = $_GET['ingdt'];
            if(array_key_exists('inghr',$_GET)){
                $horaIngreso = $_GET['inghr'];
            }

            
            if(array_key_exists('ispart',$_GET)){
                $esParticular = $_GET['ispart'];

                if(( !$esParticular && array_key_exists('apsegdt',$_GET) ) || $esParticular){
                    if(!$esParticular){
                        $fechaAprobacionSeguro = $_GET['apsegdt'];
                        if(array_key_exists('apseghr',$_GET)){
                            $horaAprobacionSeguro = $_GET['apseghr'];
                        }
                    }
    
                    if(array_key_exists('apclidt',$_GET)){
                        $fechaAprobacionCliente = $_GET['apclidt'];
                        if(array_key_exists('apclihr',$_GET)){
                            $horaAprobacionCliente = $_GET['apclihr'];
                        }
    
                        if(array_key_exists('inrepdt',$_GET)){
                            $fechaInicioReparacion = $_GET['inrepdt'];
                            if(array_key_exists('inrephr',$_GET)){
                                $horaInicioReparacion = $_GET['inrephr'];
                            }
    
                            if(array_key_exists('velisdt',$_GET)){
                                $fechaVehiculoListo = $_GET['velisdt'];
                                if(array_key_exists('velishr',$_GET)){
                                    $horaVehiculoListo = $_GET['velishr'];
                                }
        
                                if(array_key_exists('envehdt',$_GET)){
                                    $fechaEntregaVehiculo = $_GET['envehdt'];
                                    if(array_key_exists('envehhr',$_GET)){
                                        $horaEntregaVehiculo = $_GET['envehhr'];
                                    }
                                }
                            }
                        }
                    }
                }
            }

            
        }
        
        // $fechaIngresoCompleta = "20/01/20 a las 12:35 am";
        // $fechaAprobacionSeguroCompleta = "29/01/20 a las 05:30 pm";
        // $fechaAprobacionClienteCompleta = "29/01/20 a las 06:30 pm";
        // $fechaInicioReparacionCompleta = "30/01/20 a las 10:00 am";
        // $fechaVehiculoListoCompleta = "00/00/00";
        // $fechaEntregaVehiculo = "02/02/20 a las 10:00 am";

        // $fechaIngreso = '20/01/20';
        // $horaIngreso = '12:35 am';
        // $esParticular = false;
        // $fechaAprobacionSeguro = '29/01/20';
        // $horaAprobacionSeguro = '05:30 pm';
        // $fechaAprobacionCliente = '29/01/20';
        // $horaAprobacionCliente = '06:30 pm';
        // $fechaInicioOperativo = '30/01/20';
        // $horaInicioOperativo = '10:00 am';
        // $fechaVehiculoListo = '00/00/00';
        // $fechaEntrega = '02/02/20';
        // $horaEntrega = '10:00 am';

        return view('emails.emailTrackingWeb', ['fecIngreso'        => ($fechaIngreso) , 
                                                'horaIngreso'       => ($horaIngreso) ,
                                                'esParticular'      => ($esParticular),
                                                'fecAprSeguro'      => ($fechaAprobacionSeguro),
                                                'horaAprSeguro'     => ($horaAprobacionSeguro),
                                                'fecAprCliente'     => ($fechaAprobacionCliente),
                                                'horaAprCliente'    => ($horaAprobacionCliente),
                                                'fecIniRep'         => ($fechaInicioReparacion),
                                                'horaIniRep'        => ($horaInicioReparacion),
                                                'fecVehListo'       => ($fechaVehiculoListo),
                                                'fecEntrega'        => ($fechaEntregaVehiculo),
                                                'horaEntrega'       => ($horaEntregaVehiculo),
                                                'showLink'          => (false)]);
    }
}