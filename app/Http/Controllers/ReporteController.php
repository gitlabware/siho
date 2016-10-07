<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Caja;
use App\Pago;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Flujo;
use App\Models\Registro;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use TCPDF;
use App\Hospedante;
use Illuminate\Support\Facades\Auth;


class ReporteController extends Controller
{
    public function reporte_pagos(Request $request)
    {
        $datos = array();
        $salidas = array();
        //SI ES POST HARA LA CONSULTA
        if ($request->method() == "POST") {
            $f_ini = $this->conv_fecha($request->fecha_ini);
            $f_fin = $this->conv_fecha($request->fecha_fin);


            $datos = Flujo::whereHas('caja', function ($query) use ($request) {
                if (!empty($request->hotel_id)) {
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
                ->orderBy('created_at', 'desc')
                ->get();

            $salidas = Flujo::whereHas('caja', function ($query) use ($request) {
                if (!empty($request->hotel_id)) {
                    $query->where('hotel_id', '=', $request->hotel_id);
                }
                return $query;
            })
                ->where(function ($query) use ($request) {
                    $f_ini = $this->conv_fecha($request->fecha_ini);
                    $f_fin = $this->conv_fecha($request->fecha_fin);
                    $query->where(DB::raw('DATE(created_at)'), '>=', $f_ini);
                    $query->where(DB::raw('DATE(created_at)'), '<=', $f_fin);
                    $query->where('salida', '<>', 0);
                    return $query;
                })
                ->orderBy('created_at', 'desc')
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

        $cajas = Caja::where(function ($query) use ($request) {
            if (!empty($request->hotel_id)) {
                $query->where('hotel_id', '=', $request->hotel_id);
            }
        })->get();

        return view('reportes.reporte_pagos')->with(compact('datos', 'hoteles', 'fecha_ini', 'fecha_fin', 'hotel_id', 'salidas', 'cajas'));
    }

    public function conv_fecha($fecha)
    {
        $arrayf = explode("/", $fecha);
        return $arrayf[2] . "-" . $arrayf[1] . "-" . $arrayf[0];
    }

    public function pasajeros_reporte(Request $request)
    {

        $nmeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $permanentes = array();
        $ingresos = array();
        $salidas = array();
        $datos_f = array();
        $hotel = array();
        if ($request->method() == "POST" && !empty($request->fecha_ini) && !empty($request->fecha_fin)) {
            //dd($request->tipo_r);

            $dfecha_inicial = explode("/", $request->fecha_ini);
            $dfecha_final = explode("/", $request->fecha_fin);

            $hotel = Hotel::find($request->hotel_id);

            $datos_f['dia_ini'] = $dfecha_inicial[0];
            $datos_f['dia_fin'] = $dfecha_final[0];
            $datos_f['mes'] = $nmeses[intval($dfecha_inicial[1]) - 1];
            $datos_f['ano'] = substr($dfecha_inicial[2], 2);
            $permanentes = Hospedante::where('estado', 'Ocupando')
                ->whereHas('registro', function ($query) use ($request) {
                    $query->whereHas('habitacione', function ($query) use ($request) {
                        $query->whereHas('rpiso', function ($query) use ($request) {
                            $query->where('hotel_id', $request->hotel_id);
                        });
                    });
                })
                ->where(function ($query) use ($request) {
                    $f_ini = $this->conv_fecha($request->fecha_ini);
                    $query->where(DB::raw('DATE(fecha_ingreso)'), '<', $f_ini);
                    return $query;
                })->get();
            $ingresos = Hospedante::where('estado', 'Ocupando')
                ->whereHas('registro', function ($query) use ($request) {
                    $query->whereHas('habitacione', function ($query) use ($request) {
                        $query->whereHas('rpiso', function ($query) use ($request) {
                            $query->where('hotel_id', $request->hotel_id);
                        });
                    });
                })
                ->where(function ($query) use ($request) {
                    $f_ini = $this->conv_fecha($request->fecha_ini);
                    $f_fin = $this->conv_fecha($request->fecha_fin);
                    $query->where(DB::raw('DATE(fecha_ingreso)'), '>=', $f_ini);
                    $query->where(DB::raw('DATE(fecha_ingreso)'), '<=', $f_fin);
                    return $query;
                })->get();
            $salidas = Hospedante::where('estado', 'Salida')
                ->whereHas('registro', function ($query) use ($request) {
                    $query->whereHas('habitacione', function ($query) use ($request) {
                        $query->whereHas('rpiso', function ($query) use ($request) {
                            $query->where('hotel_id', $request->hotel_id);
                        });
                    });
                })
                ->where(function ($query) use ($request) {
                    $f_ini = $this->conv_fecha($request->fecha_ini);
                    $f_fin = $this->conv_fecha($request->fecha_fin);
                    $query->where(DB::raw('DATE(fecha_salida)'), '>=', $f_ini);
                    $query->where(DB::raw('DATE(fecha_salida)'), '<=', $f_fin);
                    return $query;
                })->get();
            if ($request->tipo_r == 'pdf') {
                $pageLayout = array(216, 321); //  or array($height, $width)
                $pdf = new TCPDF('P', 'mm', $pageLayout, true, 'UTF-8', false);
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetHeaderMargin(0);
                $pdf->SetFooterMargin(0);
                $pdf->SetAutoPageBreak(FALSE, 0);
                $pdf->AddPage();

                $pdf->SetFillColor(255, 255, 255);
                $h_cel = 4.5;
                $y_pag = 74;
                $contador_r = 0;

                $pdf->SetFont('', '', 10);
                $pdf->Text(25, 42, $hotel->nombre);
                $pdf->Text(130, 42, $hotel->direccion);
                $pdf->Text(35, 52, $hotel->telefonos);
                $pdf->Text(100, 52, $datos_f['dia_ini']);
                $pdf->Text(135, 52, $datos_f['dia_fin']);
                $pdf->Text(160, 52, $datos_f['mes']);
                $pdf->Text(200, 52, $datos_f['ano']);
                $pdf->Text(60, 304, Auth::user()->name);
                //------------------------------ PERMANENTES --------------------------------
                $pdf->SetFont('', '', 15);
                $contador_r++;
                $pdf->SetFont('', 'B', 15);
                $pdf->MultiCell(74, $h_cel, "PERMANENTES", 0, 'C', 1, 1, 30, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                $y_pag = $y_pag + $h_cel;
                $pdf->SetFont('', '', 15);
                foreach ($permanentes as $per) {
                    $contador_r++;
                    if ($contador_r == 46) {
                        $pdf->AddPage();
                        $pdf->SetFont('', '', 10);
                        $pdf->Text(25, 42, $hotel->nombre);
                        $pdf->Text(130, 42, $hotel->direccion);
                        $pdf->Text(35, 52, $hotel->telefonos);
                        $pdf->Text(100, 52, $datos_f['dia_ini']);
                        $pdf->Text(135, 52, $datos_f['dia_fin']);
                        $pdf->Text(160, 52, $datos_f['mes']);
                        $pdf->Text(200, 52, $datos_f['ano']);
                        $pdf->Text(60, 304, Auth::user()->name);
                        $pdf->SetFont('', '', 15);
                        $y_pag = 74;
                    }

                    $pdf->MultiCell(6, $h_cel, $per->dia_ingreso, 0, 'C', 1, 1, 12, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(6, $h_cel, $per->mes_ingreso, 0, 'C', 1, 1, 18, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(6, $h_cel, $per->ano_ingreso, 0, 'C', 1, 1, 24, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(74, $h_cel, $per->cliente->nombre, 0, 'Lc', 1, 1, 30, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(10.5, $h_cel, $per->registro->habitacione->nombre, 0, 'C', 1, 1, 104, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(21.5, $h_cel, $per->cliente->nacionalidad, 0, 'C', 1, 1, 114.5, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(21, $h_cel, $per->cliente->procedencia, 0, 'C', 1, 1, 136, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(16, $h_cel, $per->cliente->profesion, 0, 'C', 1, 1, 157, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(8.5, $h_cel, $per->cliente->edad2, 0, 'C', 1, 1, 173, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(26, $h_cel, $per->cliente->identidad, 0, 'C', 1, 1, 181.5, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $y_pag = $y_pag + $h_cel;
                }

                //---------------------------------------------------------------------------
                //------------------------------ SALIDAS --------------------------------
                $pdf->SetFont('', '', 15);
                $contador_r++;
                if ($contador_r == 46) {
                    $pdf->AddPage();
                    $pdf->SetFont('', '', 10);
                    $pdf->Text(25, 42, $hotel->nombre);
                    $pdf->Text(130, 42, $hotel->direccion);
                    $pdf->Text(35, 52, $hotel->telefonos);
                    $pdf->Text(100, 52, $datos_f['dia_ini']);
                    $pdf->Text(135, 52, $datos_f['dia_fin']);
                    $pdf->Text(160, 52, $datos_f['mes']);
                    $pdf->Text(200, 52, $datos_f['ano']);
                    $pdf->Text(60, 304, Auth::user()->name);
                    $pdf->SetFont('', '', 15);
                    $y_pag = 74;
                }
                $pdf->SetFont('', 'B', 15);
                $pdf->MultiCell(74, $h_cel, "SALIDAS", 0, 'C', 1, 1, 30, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                $y_pag = $y_pag + $h_cel;
                $pdf->SetFont('', '', 15);
                foreach ($salidas as $per) {
                    $contador_r++;
                    if ($contador_r == 46) {
                        $pdf->AddPage();
                        $pdf->SetFont('', '', 10);
                        $pdf->Text(25, 42, $hotel->nombre);
                        $pdf->Text(130, 42, $hotel->direccion);
                        $pdf->Text(35, 52, $hotel->telefonos);
                        $pdf->Text(100, 52, $datos_f['dia_ini']);
                        $pdf->Text(135, 52, $datos_f['dia_fin']);
                        $pdf->Text(160, 52, $datos_f['mes']);
                        $pdf->Text(200, 52, $datos_f['ano']);
                        $pdf->Text(60, 304, Auth::user()->name);
                        $pdf->SetFont('', '', 15);
                        $y_pag = 74;
                    }

                    $pdf->MultiCell(6, $h_cel, $per->dia_ingreso, 0, 'C', 1, 1, 12, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(6, $h_cel, $per->mes_ingreso, 0, 'C', 1, 1, 18, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(6, $h_cel, $per->ano_ingreso, 0, 'C', 1, 1, 24, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(74, $h_cel, $per->cliente->nombre, 0, 'Lc', 1, 1, 30, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(10.5, $h_cel, $per->registro->habitacione->nombre, 0, 'C', 1, 1, 104, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(21.5, $h_cel, $per->cliente->nacionalidad, 0, 'C', 1, 1, 114.5, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(21, $h_cel, $per->cliente->procedencia, 0, 'C', 1, 1, 136, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(16, $h_cel, $per->cliente->profesion, 0, 'C', 1, 1, 157, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(8.5, $h_cel, $per->cliente->edad2, 0, 'C', 1, 1, 173, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(26, $h_cel, $per->cliente->identidad, 0, 'C', 1, 1, 181.5, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $y_pag = $y_pag + $h_cel;
                }

                //---------------------------------------------------------------------------
                //------------------------------ INGRESOS --------------------------------
                $pdf->SetFont('', '', 15);
                $contador_r++;
                if ($contador_r == 46) {
                    $pdf->AddPage();
                    $pdf->SetFont('', '', 10);
                    $pdf->Text(25, 42, $hotel->nombre);
                    $pdf->Text(130, 42, $hotel->direccion);
                    $pdf->Text(35, 52, $hotel->telefonos);
                    $pdf->Text(100, 52, $datos_f['dia_ini']);
                    $pdf->Text(135, 52, $datos_f['dia_fin']);
                    $pdf->Text(160, 52, $datos_f['mes']);
                    $pdf->Text(200, 52, $datos_f['ano']);
                    $pdf->Text(60, 304, Auth::user()->name);
                    $pdf->SetFont('', '', 15);
                    $y_pag = 74;
                }
                $pdf->SetFont('', 'B', 15);
                $pdf->MultiCell(74, $h_cel, "INGRESOS", 0, 'C', 1, 1, 30, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                $y_pag = $y_pag + $h_cel;
                $pdf->SetFont('', '', 15);
                foreach ($ingresos as $per) {
                    $contador_r++;
                    if ($contador_r == 46) {
                        $pdf->AddPage();
                        $pdf->SetFont('', '', 10);
                        $pdf->Text(25, 42, $hotel->nombre);
                        $pdf->Text(130, 42, $hotel->direccion);
                        $pdf->Text(35, 52, $hotel->telefonos);
                        $pdf->Text(100, 52, $datos_f['dia_ini']);
                        $pdf->Text(135, 52, $datos_f['dia_fin']);
                        $pdf->Text(160, 52, $datos_f['mes']);
                        $pdf->Text(200, 52, $datos_f['ano']);
                        $pdf->Text(60, 304, Auth::user()->name);
                        $pdf->SetFont('', '', 15);
                        $y_pag = 74;
                    }

                    $pdf->MultiCell(6, $h_cel, $per->dia_ingreso, 0, 'C', 1, 1, 12, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(6, $h_cel, $per->mes_ingreso, 0, 'C', 1, 1, 18, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(6, $h_cel, $per->ano_ingreso, 0, 'C', 1, 1, 24, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(74, $h_cel, $per->cliente->nombre, 0, 'Lc', 1, 1, 30, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(10.5, $h_cel, $per->registro->habitacione->nombre, 0, 'C', 1, 1, 104, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(21.5, $h_cel, $per->cliente->nacionalidad, 0, 'C', 1, 1, 114.5, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(21, $h_cel, $per->cliente->procedencia, 0, 'C', 1, 1, 136, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(16, $h_cel, $per->cliente->profesion, 0, 'C', 1, 1, 157, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(8.5, $h_cel, $per->cliente->edad2, 0, 'C', 1, 1, 173, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $pdf->MultiCell(26, $h_cel, $per->cliente->identidad, 0, 'C', 1, 1, 181.5, $y_pag, true, 0, false, true, $h_cel, 'M', true);
                    $y_pag = $y_pag + $h_cel;
                }

                //---------------------------------------------------------------------------


                $filename = date('dmYHsi') . '.pdf';
                $pdf->output($filename, 'D');
                return Response::download($filename);
            }
        }

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
        //-------------------------------------------------

        $hoteles = Hotel::lists('nombre', 'id')->all();
        return view('reportes.pasajeros_reporte')->with(compact('fecha_ini', 'fecha_fin', 'permanentes', 'ingresos', 'salidas', 'datos_f', 'hoteles', 'hotel'));
        //dd("dsadsa");
    }

    //Reporte de pagos de registros
    public function repo_pago_regis(Request $request)
    {
        //REVISA LAS FECHA PARA PONER DEFAULT FECHA HOY
        //-------------------------------------------------
        $pagos = array();
        $hoteles = Hotel::lists('nombre', 'id')->all();
        if ($request->method() == "POST" && !empty($request->fecha_ini) && !empty($request->fecha_fin)) {
            //dd($request->all());
            $f_ini = $this->conv_fecha($request->fecha_ini);
            $f_fin = $this->conv_fecha($request->fecha_fin);
            $pagos = Pago::where(DB::raw('DATE(fecha)'), '>=', $f_ini)
                ->where(DB::raw('DATE(fecha)'), '<=', $f_fin)
                ->where(function ($query) use ($request) {
                    if (!empty($request->estado)) {
                        $query->where('estado', $request->estado);
                    }
                })
                ->whereHas('registro', function ($query) use ($request) {
                    $query->whereHas('habitacione', function ($query) use ($request) {
                        $query->whereHas('rpiso', function ($query) use ($request) {
                            if (!empty($request->hotel_id)) {
                                $query->where('hotel_id', $request->hotel_id);
                            }
                        });
                    });
                })->get();
            //dd($pagos);
        }
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

        $hotel_id = '';
        if (!empty($request->hotel_id)) {
            $hotel_id = $request->hotel_id;
        }
        $estado = '';
        if (!empty($request->estado)) {
            $estado = $request->estado;
        }
        return view('reportes.repo_pago_regis')->with(compact('fecha_ini', 'fecha_fin', 'hoteles', 'pagos', 'hotel_id', 'estado'));
    }

    public function reporte_registros(Request $request)
    {

        $registros = array();

        if ($request->method() == "POST" && !empty($request->fecha_ini) && !empty($request->fecha_fin)) {
            //dd($request->all());
            $f_ini = $this->conv_fecha($request->fecha_ini);
            $f_fin = $this->conv_fecha($request->fecha_fin);

            $registros = Registro::whereHas('habitacione', function ($query) use ($request) {
                $query->whereHas('rpiso', function ($query) use ($request) {
                    if (!empty($request->hotel_id)) {
                        $query->where('hotel_id', $request->hotel_id);
                    }
                });
            })
                ->where(DB::raw('DATE(created_at)'), '>=', $f_ini)
                ->where(DB::raw('DATE(created_at)'), '<=', $f_fin)
                ->where(function ($query) use ($request) {
                    if (!empty($request->estado)) {
                        $query->where('estado', $request->estado);
                    }
                })->get();
            //dd($registros);
        }


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
        $hotel_id = '';
        if (!empty($request->hotel_id)) {
            $hotel_id = $request->hotel_id;
        }
        $estado = '';
        if (!empty($request->estado)) {
            $estado = $request->estado;
        }
        $hoteles = Hotel::lists('nombre', 'id')->all();
        return view('reportes.reporte_registros')->with(compact('fecha_ini', 'fecha_fin', 'hoteles', 'hotel_id', 'estado', 'registros'));
    }


}