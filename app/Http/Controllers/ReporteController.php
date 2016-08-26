<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Flujo;
use App\Models\Registro;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class ReporteController extends Controller
{
    public function reporte_pagos(Request $request)
    {
        $datos = array();
        //SI ES POST HARA LA CONSULTA
        if ($request->method() == "POST") {
            $f_ini = $this->conv_fecha($request->fecha_ini);
            $f_fin = $this->conv_fecha($request->fecha_fin);


            $datos = Flujo::whereHas('caja',function ($query) use ($request) {
                if(!empty($request->hotel_id)){
                    $query->where('hotel_id', '=', $request->hotel_id);
                }
                return $query;
            })
                ->where(function ($query) use ($request) {
                    $f_ini = $this->conv_fecha($request->fecha_ini);
                    $f_fin = $this->conv_fecha($request->fecha_fin);
                    $query->where(DB::raw('DATE(created_at)'), '>=', $f_ini);
                    $query->where(DB::raw('DATE(created_at)'), '<=', $f_fin);
                    $query->where('ingreso', '<>', 0);
                    return $query;
                })
                ->orderBy('created_at','desc')
                ->get();
        }
        //----------------------------------------------------
        //REVISA LAS FECHA PARA PONER DEFAULT FECHA HOY
        if (empty($request->fecha_ini)) {
            $fecha_ini = date('d/m/Y');
        } else {
            $fecha_ini = $request->fecha_ini;
        }
        if (empty($request->fecha_fin)) {
            $fecha_fin = date('d/m/Y');
        } else {
            $fecha_fin = $request->fecha_fin;
        }
        if (empty($request->hotel_id)) {
            $hotel_id = '';
        } else {
            $hotel_id = $request->hotel_id;
        }
        //-------------------------------------------------
        //dd($fecha_ini);
        $hoteles = Hotel::lists('nombre', 'id')->all();

        return view('reportes.reporte_pagos')->with(compact('datos', 'hoteles', 'fecha_ini', 'fecha_fin','hotel_id'));
    }

    public function conv_fecha($fecha)
    {
        $arrayf = explode("/", $fecha);
        return $arrayf[2] . "-" . $arrayf[1] . "-" . $arrayf[0];
    }
}