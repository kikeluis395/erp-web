<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Descuento;
use App\Modelos\DescuentoMeson;
use App\Modelos\LineaCotizacionMeson;
use App\Modelos\CotizacionMeson;
use App\Modelos\ItemNecesidadRepuestos;
use App\Modelos\RecepcionOT;
use App\Modelos\NecesidadRepuestos;
use App\Modelos\HojaTrabajo;
use Auth;
use DB;
use Carbon\Carbon;

class DescuentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $descuentos = Descuento::whereNull('es_aprobado')->has('hojaTrabajo.recepcionOT')
        //              ->doesntHave('hojaTrabajo.recepcionOT.otCerrada')
        //              ->doesntHave('hojaTrabajo.recepcionOT.entregas')
        //              ->get();
     
        $subquery = Descuento::select('id_hoja_trabajo',DB::raw("max(fecha_registro) as fecha_registro"))->groupBy('id_hoja_trabajo');
        $descuentos = Descuento::joinSub($subquery, 'd',function($query){
            $query->on('descuento.id_hoja_trabajo','d.id_hoja_trabajo')->on('descuento.fecha_registro','d.fecha_registro');
        })->whereNull('es_aprobado')
        ->has('hojaTrabajo.recepcionOT')        
        ->doesntHave('hojaTrabajo.recepcionOT.otCerrada')
        ->doesntHave('hojaTrabajo.recepcionOT.entregas')
        ->whereHas('hojaTrabajo', function($q1) {
            $q1->whereNotNull('id_recepcion_ot');
        })
        ->orWhereHas('hojaTrabajo.necesidadesRepuestos.itemsNecesidadRepuestos', function($q) {
            $q->where('descuento_unitario_dealer_aprobado', '=', 2);
        })
        ->get();

        #return $descuentos->first()->hojaTrabajo->necesidadesRepuestos->first()->itemsNecesidadRepuestos;
        /* $subquery2 = DescuentoMeson::select('id_cotizacion_meson',DB::raw("max(fecha_registro) as fecha_registro"))->groupBy('id_cotizacion_meson');
        $descuentosMeson = DescuentoMeson::joinSub($subquery2, 'd',function($query){
            $query->on('descuento_meson.id_cotizacion_meson','d.id_cotizacion_meson')->on('descuento_meson.fecha_registro','d.fecha_registro');
        })->whereNull('es_aprobado')
        ->doesntHave('cotizacionMeson.ventasMeson')
        ->get(); */
      
        $listaDescuentos = $descuentos->sortBy('fecha_registro');

        // return $listaDescuentos;

        /* $descuentosUnitariosPorDealer = RecepcionOT::whereHas('hojaTrabajo.necesidadesRepuestos.itemsNecesidadRepuestos', function($q) {
            $q->where('descuento_unitario_dealer_aprobado', '=', 2);
        })->get(); */
        
        return view('administracion.descuentos', ['listaDescuentos' => $listaDescuentos/* ,
                                                  'descuentosUnitariosPorDealer' => $descuentosUnitariosPorDealer */]);
    }

    public function indexDescuentosMeson()
    {
        $cotizacionMeson = CotizacionMeson::whereHas('lineasCotizacionMeson' , function ($query)  {
            $query->whereNull('descuento_unitario_aprobado')->where('descuento_unitario_dealer_por_aprobar','>=',0)->orWhere('descuento_marca','>',0)->whereNull('descuento_marca_aprobado');
        })->get();

        $cotizacionMeson2 = CotizacionMeson::whereHas('lineasCotizacionMeson' , function ($query)  {
            $query->whereNull('descuento_marca_aprobado')->whereNotNull('descuento_marca')->where('descuento_marca','>',0);
        })->get();

        

        //$cotizacionMeson = $cotizacionMeson->concat($cotizacionMeson2)->distinct();
        $details= LineaCotizacionMeson::whereNull('descuento_unitario_aprobado')->whereNotNull('descuento_unitario_dealer_por_aprobar')->where('descuento_unitario_dealer_por_aprobar','>',0)->orWhereNull('descuento_marca_aprobado')->where('descuento_marca','>',0)->get();      
        //dd($details);
        return view('administracion.descuentosMeson', ['listaDetalleDescuentos' => $details,
                                                    'listaDescuentos' => $cotizacionMeson
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
        
        $idHojaTrabajo = $request->idHojaTrabajo;
        $descuentoExistente = Descuento::where('id_hoja_trabajo', $idHojaTrabajo)->orderBy('fecha_registro','desc')->first();
        if($descuentoExistente){
            $reemplazoMO = ($descuentoExistente->porcentaje_aplicado_mo !== null && ($request->porcentajeSolicitadoMO !== null && $request->porcentajeSolicitadoMO !== ''));
            $reemplazoLubricantes = ($descuentoExistente->porcentaje_aplicado_lubricantes !== null && ($request->porcentajeSolicitadoLubricantes !== null && $request->porcentajeSolicitadoLubricantes !== ''));
            $reemplazoRptos = ($descuentoExistente->porcentaje_aplicado_rptos !== null && ($request->porcentajeSolicitadoRptos !== null && $request->porcentajeSolicitadoRptos !== ''));
            $reemplazoST = ($descuentoExistente->porcentaje_aplicado_servicios_terceros !== null && ($request->porcentajeSolicitadoST !== null && $request->porcentajeSolicitadoST !== ''));
            // dd($reemplazoMO,$reemplazoLubricantes,$reemplazoRptos);
            if($reemplazoMO || $reemplazoLubricantes || $reemplazoRptos || $reemplazoST){
                // en caso ya exista un campo lleno, se creara otra linea de repuestos
                $descuento = new Descuento();
                $descuento->id_hoja_trabajo = $idHojaTrabajo;
            }
            else{
                $descuento = $descuentoExistente;
            }
        }
        else{
            $descuento = new Descuento();
            $descuento->id_hoja_trabajo = $idHojaTrabajo;
        }

        

        if($request->porcentajeSolicitadoMO !== null && $request->porcentajeSolicitadoMO !== '')
            $descuento->porcentaje_aplicado_mo = $request->porcentajeSolicitadoMO;

        // if($request->porcentajeSolicitadoLubricantes !== null && $request->porcentajeSolicitadoLubricantes !== '')
        //     $descuento->porcentaje_aplicado_lubricantes = $request->porcentajeSolicitadoLubricantes;

        // if($request->porcentajeSolicitadoRptos !== null && $request->porcentajeSolicitadoRptos !== '')
        //     $descuento->porcentaje_aplicado_rptos = $request->porcentajeSolicitadoRptos;
        
        if($request->porcentajeSolicitadoST !== null && $request->porcentajeSolicitadoST !== '')
        $descuento->porcentaje_aplicado_servicios_terceros = $request->porcentajeSolicitadoST;

        $descuento->dni_solicitante = Auth::user()->dni;
        if(!$descuento->hojaTrabajo->recepcionOT){
            // Aprobacion automatica para cotizaciones
            $descuento->dni_aprobador = $descuento->dni_solicitante;
            $descuento->es_aprobado=1;
        }
        $descuento->save();

        //Se crea descuentos unitarios en Item necesidad repuestos
        $necesidadRepuestos = NecesidadRepuestos::where('id_hoja_trabajo',$idHojaTrabajo)->first();
        if($necesidadRepuestos!=null){
            $items = $necesidadRepuestos->itemsNecesidadRepuestos;
        }else{
            $items = [];
        }
        

        $xd = HojaTrabajo::find($idHojaTrabajo);
        $es_cotizacion = false;
        if($xd->id_cotizacion !=null){
            $es_cotizacion = true;
        }
        
        foreach($items as $row){
            $id = $row->id_item_necesidad_repuestos;
            $item_in_request= "dscto-dealer-".$id;
            $request_discount = $request->input($item_in_request);
            
            
            if($es_cotizacion){
                $item_necesidad_repuesto = ItemNecesidadRepuestos::find($id);
                if($item_necesidad_repuesto->repuesto!=null){
                        //Si es lubricante y su descuento unitario es null tomo el descuento general
                    if($item_necesidad_repuesto->repuesto->esLubricante() && $request_discount ==null){
                        $item_necesidad_repuesto->descuento_unitario_dealer=  $request->input('porcentajeSolicitadoLubricantes');
                    }
                    //Si no es lubricante y su descuento unitario es null tomo el descuento general
                    else if(!$item_necesidad_repuesto->repuesto->esLubricante() && $request_discount ==null){
                        $item_necesidad_repuesto->descuento_unitario_dealer=  $request->input('porcentajeSolicitadoRptos');
                    }else{
                        $item_necesidad_repuesto->descuento_unitario_dealer= $request_discount;
                    }                    
                    $item_necesidad_repuesto->descuento_unitario_dealer_aprobado = 1;
                }
            }else{
                $item_necesidad_repuesto = ItemNecesidadRepuestos::find($id);
                
                //dd($item_necesidad_repuesto);
                //Si es lubricante y su descuento unitario es null tomo el descuento general
                //dd($request->input('porcentajeSolicitadoRptos'));
                 if($item_necesidad_repuesto->repuesto->esLubricante() && $request_discount ==null){
                    $item_necesidad_repuesto->descuento_unitario_dealer_por_aprobar=  $request->input('porcentajeSolicitadoLubricantes');
                }
                //Si no es lubricante y su descuento unitario es null tomo el descuento general
                else if(!$item_necesidad_repuesto->repuesto->esLubricante() && $request_discount ==null){            
                    $item_necesidad_repuesto->descuento_unitario_dealer_por_aprobar=  $request->input('porcentajeSolicitadoRptos');
                }else{               
                    $item_necesidad_repuesto->descuento_unitario_dealer_por_aprobar= $request_discount;
                }               
                $item_necesidad_repuesto->descuento_unitario_dealer_aprobado = 2;
            }
            

            $item_necesidad_repuesto->save();
            
        }
        // $x ='<script language="javascript">alert("message successfully sent")</script>';
        // // return $x;
        return back();
        // return redirect()->back()->with('success', 'Descuentos solicitados');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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

    public function aprobarDescuento(Request $request)
    {
        $date_now = Carbon::now();
        DB::beginTransaction();
        if($request->id_descuento){
            $descuento = Descuento::find($request->id_descuento);
            $descuento->es_aprobado = 1;
            $descuento->dni_aprobador = Auth::user()->dni;
            $descuento->save();
        }

        if (isset($request->id)) {
            ItemNecesidadRepuestos::where('descuento_unitario_dealer_aprobado', 2)
            ->where('id_necesidad_repuestos', $request->id)
            ->update([
                'descuento_unitario_dealer' => DB::raw('descuento_unitario_dealer_por_aprobar'),
                'descuento_unitario_dealer_por_aprobar' => null,
                'descuento_unitario_dealer_aprobado' => 1,
                'fecha_registro_aprobacion_rechazo_descuento' => $date_now
            ]);
        }
        
        DB::commit();
        return redirect()->route('descuentos.index');
    }

    public function aprobarDescuentoUni(Request $request)
    {
        $date_now = Carbon::now();
        ItemNecesidadRepuestos::where('descuento_unitario_dealer_aprobado', 2)
        ->where('id_necesidad_repuestos', $request->id)
        ->update([
            'descuento_unitario_dealer' => DB::raw('descuento_unitario_dealer_por_aprobar'),
            'descuento_unitario_dealer_por_aprobar' => null,
            'descuento_unitario_dealer_aprobado' => 1,
            'fecha_registro_aprobacion_rechazo_descuento' => $date_now,
        ]);

        return redirect()->route('descuentos.index');
    }

    public function rechazarDescuento(Request $request)
    {
        DB::beginTransaction();
        $date_now = Carbon::now();
        if($request->id_descuento){
            $descuento = Descuento::find($request->id_descuento);
            $descuento->es_aprobado = 0;
            $descuento->dni_aprobador = Auth::user()->dni;
            $descuento->save();
        }
        if(isset($request->id)) {
            ItemNecesidadRepuestos::where('descuento_unitario_dealer_aprobado', 2)
            ->where('id_necesidad_repuestos', $request->id)
            ->update([
                'descuento_unitario_dealer_por_aprobar' => null,
                'descuento_unitario_dealer_aprobado' => 0,
                'fecha_registro_aprobacion_rechazo_descuento' => $date_now,
            ]);
    
        }
        
        DB::commit();
        return redirect()->route('descuentos.index');
    }

    public function rechazarDescuentoUni(Request $request)
    {
        $date_now = Carbon::now();
        ItemNecesidadRepuestos::where('descuento_unitario_dealer_aprobado', 2)
        ->where('id_necesidad_repuestos', $request->id)
        ->update([
            'descuento_unitario_dealer_por_aprobar' => null,
            'descuento_unitario_dealer_aprobado' => 0,
            'fecha_registro_aprobacion_rechazo_descuento' => $date_now,
        ]);


        return redirect()->route('descuentos.index');
    }
}
