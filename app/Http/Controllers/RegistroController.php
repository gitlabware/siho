<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateRegistroRequest;
use App\Http\Requests\UpdateRegistroRequest;
use App\Repositories\RegistroRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Carbon\Carbon;

use App\Models\Precioshabitaciones;
use App\Models\Caja;
use App\Models\Flujo;
use App\Models\Clientes;
use App\Models\Habitaciones;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro;
use Illuminate\Support\Facades\DB;

class RegistroController extends InfyOmBaseController
{
    /** @var  RegistroRepository */
    private $registroRepository;

    public function __construct(RegistroRepository $registroRepo)
    {
        $this->registroRepository = $registroRepo;
    }

    /**
     * Display a listing of the Registro.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        $idHotel = Auth::user()->hotel_id;
        //dd($idHotel);
        //$this->registroRepository->pushCriteria(new RequestCriteria($request));
        //$registros = $this->registroRepository->findWhere(['habitacione_id','=',1])->all();

        $registros = Registro::all()->where('habitacione.rpiso.hotel_id', $idHotel);
        $registros = Registro::orderBy('id', 'desc')->get()->where('habitacione.rpiso.hotel_id', $idHotel);
        //dd($registros);
        return view('registros.index')
            ->with('registros', $registros);
    }

    /**
     * Show the form for creating a new Registro.
     *
     * @return Response
     */
    public function create()
    {
        return view('registros.create');
    }

    /**
     * Store a newly created Registro in storage.
     *
     * @param CreateRegistroRequest $request
     *
     * @return Response
     */
    public function store(CreateRegistroRequest $request)
    {
        $input = $request->all();

        $registro = $this->registroRepository->create($input);

        Flash::success('Registro saved successfully.');

        return redirect(route('registros.index'));
    }

    /**
     * Display the specified Registro.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $registro = $this->registroRepository->findWithoutFail($id);

        if (empty($registro)) {
            Flash::error('Registro not found');

            return redirect(route('registros.index'));
        }

        return view('registros.show')->with('registro', $registro);
    }

    /**
     * Show the form for editing the specified Registro.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $registro = $this->registroRepository->findWithoutFail($id);

        if (empty($registro)) {
            Flash::error('Registro not found');

            return redirect(route('registros.index'));
        }

        return view('registros.edit')->with('registro', $registro);
    }

    /**
     * Update the specified Registro in storage.
     *
     * @param  int $id
     * @param UpdateRegistroRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegistroRequest $request)
    {
        $registro = $this->registroRepository->findWithoutFail($id);

        if (empty($registro)) {
            Flash::error('Registro not found');

            return redirect(route('registros.index'));
        }

        $registro = $this->registroRepository->update($request->all(), $id);

        Flash::success('Registro updated successfully.');

        return redirect(route('registros.index'));
    }

    /**
     * Remove the specified Registro from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $registro = $this->registroRepository->findWithoutFail($id);
        //----------- Elimina el flujo de pago ---------------------
        if (!empty($registro->flujo_id)) {

            $flujo = Flujo::find($registro->flujo_id);
            $total = $this->get_total($flujo->caja_id);

            if ($flujo->ingreso != 0) {
                if ($total >= $flujo->ingreso) {
                    $this->set_total($flujo->caja_id, ($total - $flujo->ingreso));
                } else {
                    //dd($request->all());
                    Flash::error('No se ha podido eliminar el pago por que el total es solo ' . $total);
                    return redirect()->back();
                }
            } else {
                $this->set_total($flujo->caja_id, ($total + $flujo->salida));
            }
            $flujo->deleted_at = date('Y-m-d H:m:i');
            $flujo->observacion = 'Eliminado desde Registro';
            $flujo->save();

            $datos_reg['flujo_id'] = null;
        }
        //--------------------------------------------------------

        if (empty($registro)) {
            Flash::error('El registro no fue encontrado');
            return redirect(route('registros.index'));
        }

        if (!empty($registro->num_reg)) {
            //$registros = Registro::
            //$registros = Registro::
            $registros = Registro::where('num_reg', $registro->num_reg)->get()->all();
            foreach ($registros as $registro) {
                $this->registroRepository->delete($registro->id);
            }
        } else {
            $this->registroRepository->delete($registro->id);
        }


        Flash::success('Registro deleted successfully.');
        return redirect()->back();
        //return redirect(route('registros.index'));
    }

    public function nuevo($idCliente = null, $idHabitacion = null, $idRegistro = null)
    {
        //dd($idRegistro);
        //return view('registros.create');
        $idHotel = Auth::user()->hotel_id;

        if (isset($idRegistro)) {
            $registro = $this->registroRepository->findWithoutFail($idRegistro);
            $idCliente = $registro->cliente_id;
        }
        $registros = Habitaciones::find($idHabitacion)->registrosactivos;

        $precios = Precioshabitaciones::where('habitacione_id', $idHabitacion)->get()->lists('precio', 'precio')->all();
        //dd($precios);
        $cliente = Clientes::find($idCliente);
        $habitacion = Habitaciones::find($idHabitacion);
        $cajas = Caja::where('hotel_id', $idHotel)->get()->lists('nombre', 'id')->all();
        //dd($cajas);
        //dd($registro);
        return view('registros.nuevo')->with(compact('precios', 'habitacion', 'cliente', 'registro', 'cajas', 'registros'));
    }

    public function guarda_registro(Request $request, $idRegistro = null)
    {

        $datos_reg = $request->all();
        $direccionar = route('registros.index');
        //dd($datos_reg);
        if (isset($datos_reg['fecha_ingreso']) && !empty($datos_reg['fecha_ingreso'])) {
            $datos_reg['fecha_ingreso'] = Carbon::createFromFormat('d/m/Y', $datos_reg['fecha_ingreso'])->toDateTimeString();
        }
        if (isset($datos_reg['fecha_salida']) && !empty($datos_reg['fecha_salida'])) {
            $datos_reg['fecha_salida'] = Carbon::createFromFormat('d/m/Y', $datos_reg['fecha_salida'])->toDateTimeString();
        }
        //----------- Elimina el flujo de pago ---------------------
        if (isset($request->repago) && !empty($datos_reg['flujo_id'])) {

            $flujo = Flujo::find($datos_reg['flujo_id']);
            $total = $this->get_total($flujo->caja_id);

            if ($flujo->ingreso != 0) {
                if ($total >= $flujo->ingreso) {
                    $this->set_total($flujo->caja_id, ($total - $flujo->ingreso));
                } else {
                    //dd($request->all());
                    Flash::error('No se ha guardado porque no se ha podido eliminar el pago por que el total es solo ' . $total);
                    return redirect()->back();
                }
            } else {
                $this->set_total($flujo->caja_id, ($total + $flujo->salida));
            }
            $flujo->deleted_at = date('Y-m-d H:m:i');
            $flujo->observacion = 'Eliminado desde Registro';
            $flujo->save();

            $datos_reg['flujo_id'] = null;
        }
        //--------------------------------------------------------
        //----------- Crea el flujo de pago para el registro ---------
        if (isset($request->pagar) && empty($datos_reg['flujo_id'])) {


            $datos_reg['monto_total'];

            $flujo = new Flujo;
            $flujo->detalle = 'Pago de Registro';
            $flujo->ingreso = $datos_reg['monto_total'];
            $flujo->observacion = '';
            $flujo->salida = 0;
            $flujo->caja_id = $request->caja_id;
            $flujo->user_id = $request->user_id;
            $flujo->save();

            $total = $this->get_total($request->caja_id);
            $this->set_total($request->caja_id, ($total + $datos_reg['monto_total']));

            $datos_reg['flujo_id'] = $flujo->id;

            $direccionar = route('flujos', [$request->caja_id]);
        }
        //-------------------------------------------------------
        //----------- Guarda el registro -----------------------
        if (isset($request->ocupar)) {
            $datos_reg['estado'] = 'Ocupando';
        }
        if (isset($idRegistro)) {
            $registro = $this->registroRepository->findWithoutFail($idRegistro);
            $registro = $this->registroRepository->update($datos_reg, $idRegistro);
        } else {
            //$datos_reg['estado'] = 'Ocupando';
            $registro = $this->registroRepository->create($datos_reg);

        }
        //---------------------------------------------------------
        //Desocupa la habitacion liberando del registro
        if (isset($request->ocupado) && isset($idRegistro)) {
            $registro = $this->registroRepository->findWithoutFail($idRegistro);
            $datos_reg['estado'] = 'Desocupado';
            $registro = $this->registroRepository->update($datos_reg, $idRegistro);
        }
        Flash::success('El registro de habitacion se ha realizado correctamente!!');
        //return redirect()->back();
        return redirect($direccionar);
    }

    public function guarda_registros(Request $request, $num_reg = null)
    {
        $direccionar = route('registros.index');
        $habitaciones = $request->habitaciones;
        $datos_reg = $request->all();
        unset($datos_reg['habitaciones']);

        if (isset($datos_reg['fecha_ingreso']) && !empty($datos_reg['fecha_ingreso'])) {
            $datos_reg['fecha_ingreso'] = Carbon::createFromFormat('d/m/Y', $datos_reg['fecha_ingreso'])->toDateTimeString();
        }
        if (isset($datos_reg['fecha_salida']) && !empty($datos_reg['fecha_salida'])) {
            $datos_reg['fecha_salida'] = Carbon::createFromFormat('d/m/Y', $datos_reg['fecha_salida'])->toDateTimeString();
        }
        //----------- Elimina el flujo de pago ---------------------
        if (isset($request->repago) && !empty($datos_reg['flujo_id'])) {

            $flujo = Flujo::find($datos_reg['flujo_id']);
            $total = $this->get_total($flujo->caja_id);

            if ($flujo->ingreso != 0) {
                if ($total >= $flujo->ingreso) {
                    $this->set_total($flujo->caja_id, ($total - $flujo->ingreso));
                } else {
                    //dd($request->all());
                    Flash::error('No se ha guardado porque no se ha podido eliminar el pago por que el total es solo ' . $total);
                    return redirect()->back();
                }
            } else {
                $this->set_total($flujo->caja_id, ($total + $flujo->salida));
            }
            $flujo->deleted_at = date('Y-m-d H:m:i');
            $flujo->observacion = 'Eliminado desde Registro';
            $flujo->save();

            $datos_reg['flujo_id'] = null;
        }
        //--------------------------------------------------------
        //----------- Crea el flujo de pago para el registro ---------
        if (isset($request->pagar) && empty($datos_reg['flujo_id'])) {
            //$datos_reg['monto_total'];
            $flujo = new Flujo;
            $flujo->detalle = 'Pago de Registro';
            $flujo->ingreso = $datos_reg['monto_total'];
            $flujo->observacion = '';
            $flujo->salida = 0;
            $flujo->caja_id = $request->caja_id;
            $flujo->user_id = $request->user_id;
            $flujo->save();
            $total = $this->get_total($request->caja_id);
            $this->set_total($request->caja_id, ($total + $datos_reg['monto_total']));
            $datos_reg['flujo_id'] = $flujo->id;
            $direccionar = route('flujos', [$request->caja_id]);
        }
        //-------------------------------------------------------
        //----------- Guarda el registro -----------------------

        if (isset($request->ocupar)) {
            $datos_reg['estado'] = 'Ocupando';
        }

        if (isset($num_reg)) {
            foreach ($habitaciones as $idHabitacion => $habitacion) {
                //$datos_reg['habitacione_id'] = $idHabitacion;
                $datos_reg['precio'] = $habitacion['precio'];
                $datos_reg['monto_total'] = $habitacion['monto_total'];
                if (isset($habitacion['registro_id'])) {
                    $registro = $this->registroRepository->update($datos_reg, $habitacion['registro_id']);
                } else {
                    $datos_reg['num_reg'] = $num_reg;
                    $registro = $this->registroRepository->create($datos_reg);
                }
            }
        } else {


            $numero_reg = $this->get_num_reg();
            $datos_reg['num_reg'] = $numero_reg;
            foreach ($habitaciones as $idHabitacion => $habitacion) {
                $datos_reg['habitacione_id'] = $idHabitacion;
                $datos_reg['precio'] = $habitacion['precio'];
                $datos_reg['monto_total'] = $habitacion['monto_total'];
                $registro = $this->registroRepository->create($datos_reg);

            }
        }
        //---------------------------------------------------------
        //Desocupa la habitacion liberando del registro

        if (isset($request->ocupado) && isset($num_reg)) {

            $registros = Registro::all()->where('num_reg', $num_reg);
            foreach ($registros as $registro) {
                $registro->estado = 'Desocupado';
                $registro->save();
            }

            //$datos_reg['estado'] = 'Desocupado';
            //$registro = $this->registroRepository->update($datos_reg, $idRegistro);
        }
        //----------------------------------------------------------
        Flash::success('El registro de habitacion se ha realizado correctamente!!');
        //return redirect()->back();
        return redirect($direccionar);
    }

    public function nuevos(Request $request, $idCliente = null, $num_reg = null)
    {
        $habitaciones = $request->habitaciones;
        //dd($num_reg);

        $idHotel = Auth::user()->hotel_id;
        if (isset($num_reg)) {
            $registros = Registro::all()->where('num_reg', $num_reg);

            //dd($h_ocupado);
            $habitaciones2 = $habitaciones;
            $habitaciones = array();
            foreach ($registros as $registro) {
                $habitaciones[$registro->habitacione_id]['registro'] = $registro;
                $habitaciones[$registro->habitacione_id]['precios'] = Precioshabitaciones::where('habitacione_id', $registro->habitacione_id)->get()->lists('precio', 'precio')->all();
                $habitaciones[$registro->habitacione_id]['habitacion'] = Habitaciones::find($registro->habitacione_id);
            }

            if (isset($habitaciones2)) {
                foreach ($habitaciones2 as $idHabitacion => $habi) {
                    if (!isset($habitaciones[$idHabitacion])) {
                        $habitaciones[$idHabitacion]['precios'] = Precioshabitaciones::where('habitacione_id', $idHabitacion)->get()->lists('precio', 'precio')->all();
                        $habitaciones[$idHabitacion]['habitacion'] = Habitaciones::find($idHabitacion);
                    }
                }
            }


        } else {
            foreach ($habitaciones as $idHabitacion => $ha) {
                $habitaciones[$idHabitacion]['precios'] = Precioshabitaciones::where('habitacione_id', $idHabitacion)->get()->lists('precio', 'precio')->all();
                $habitaciones[$idHabitacion]['habitacion'] = Habitaciones::find($idHabitacion);
            }
        }

        $cliente = Clientes::find($idCliente);
        $cajas = Caja::where('hotel_id', $idHotel)->get()->lists('nombre', 'id')->all();
        return view('registros.nuevos')->with(compact('cliente', 'registro', 'cajas', 'habitaciones'));
    }

    public function get_total($idCaja)
    {
        $caja = Caja::find($idCaja);
        return $caja->total;
    }

    public function set_total($idCaja, $total = 0.00)
    {
        $caja = Caja::find($idCaja);
        $caja->total = $total;
        $caja->save();
        return true;
    }

    public function get_num_reg()
    {

        $registro = DB::table('registros')
            ->orderBy('num_reg', 'desc')
            ->first();
        if (isset($registro->num_reg)) {
            return $registro->num_reg + 1;
        } else {
            return 1;
        }
    }


    public function calendario()
    {
        $ano = date('Y');
        $mes = intval(date('m'));
        $idHotel = Auth::user()->hotel_id;
        $habitaciones = Habitaciones::all()->where('rpiso.hotel_id', $idHotel);
        $numero_dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        return view('registros.calendario')->with(compact('habitaciones', 'idhotel', 'numero_dias'));
    }

    public function registros_cliente($idCliente = null)
    {
        $idHotel = Auth::user()->hotel_id;
        $cliente = Clientes::find($idCliente);
        $registros = Registro::where('cliente_id', $idCliente)->where('flujo_id', 0)->get();
        $hregistros = Registro::where('cliente_id', $idCliente)->where('flujo_id', '<>', 0)->orderBy('created_at', 'desc')->get();
        $cajas = Caja::where('hotel_id', $idHotel)->get()->lists('nombre', 'id')->all();
        return view('registros.registros_cliente')->with(compact('cliente', 'registros', 'hregistros','cajas'));
    }

    public function registrar_pago(Request $request)
    {
        //dd($request->cliente_id);
        $idCliente = $request->cliente_id;
        $monto_total = $request->monto_total;
        $registros = Registro::where('cliente_id', $idCliente)->where('flujo_id', 0)->get();

        $flujo = new Flujo;
        $flujo->detalle = 'Pago de Registro';
        $flujo->ingreso = $monto_total;
        $flujo->observacion = '';
        $flujo->salida = 0;
        $flujo->caja_id = $request->caja_id;
        $flujo->user_id = $request->user_id;
        $flujo->save();
        $total = $this->get_total($request->caja_id);
        $this->set_total($request->caja_id, ($total + $monto_total));
        $idFlujo = $flujo->id;

        foreach ($registros as $registro) {
            $registro->flujo_id = $idFlujo;
            $registro->save();
        }
        $direccionar = route('flujos', [$request->caja_id]);
        Flash::success('El pago de los pendientes se ha registrado correctamente!!');
        //return redirect()->back();
        return redirect($direccionar);
    }


}

