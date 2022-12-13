<?php

namespace App\Http\Controllers\Ventas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;


class PdiController extends Controller
{
    public function index(Request $request){
        $fecha_emision = Carbon::now();

        $list_checks=[];
            for ($i = 1; $i <= 96; $i++) {
                $list_checks[$i] = false;
                
            }
        return view('otros.pdi', ['fecha_emision' => $fecha_emision,
                                    'list_checks' => $list_checks
        ]);
    }
}
