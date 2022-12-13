<?php

namespace App\Http\Controllers\Facturacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rebate;

class RebatesController extends Controller
{
    public function index() {
        $rebates = Rebate::all();
        
        return view('rebates', [
            'rebates' => $rebates
        ]);
    }
}
