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
use App\Models\Clientes;
use App\Models\Habitaciones;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro;

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

        //$this->registroRepository->pushCriteria(new RequestCriteria($request));
        //$registros = $this->registroRepository->findWhere(['habitacione_id','=',1])->all();

        $registros = Registro::all()->where('habitacione.rpiso.hotel.id',$idHotel);
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
     * @param  int              $id
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

        if (empty($registro)) {
            Flash::error('Registro not found');

            return redirect(route('registros.index'));
        }

        $this->registroRepository->delete($id);

        Flash::success('Registro deleted successfully.');

        return redirect(route('registros.index'));
    }

    public function nuevo($idCliente = null,$idHabitacion = null,$idRegistro = null)
    {
        //dd($idRegistro);
        //return view('registros.create');
        $ocupado = false;
        if(isset($idRegistro)){
            $registro = $this->registroRepository->findWithoutFail($idRegistro);

            $idCliente = $registro->cliente_id;

            $h_ocupado = Habitaciones::where('registro_id','=',$idRegistro)->first();
            if(isset($h_ocupado->registro_id)){
                $ocupado = true;
            }
        }
        //dd($idHabitacion);
        $precios = Precioshabitaciones::where('habitacione_id' , $idHabitacion)->get()->lists('precio','precio')->all();
        //dd($precios);
        $cliente = Clientes::find($idCliente);
        $habitacion = Habitaciones::find($idHabitacion);


        return view('registros.nuevo')->with(compact('precios','habitacion','cliente','registro','ocupado'));
    }

    public function guarda_registro(Request $request,$idRegistro = null){
        //dd($request->ocupado);
        $datos_reg = $request->all();
        if(isset($datos_reg['fecha_ingreso']) && !empty($datos_reg['fecha_ingreso'])){
            $datos_reg['fecha_ingreso'] = Carbon::createFromFormat('d/m/Y',$datos_reg['fecha_ingreso'])->toDateTimeString();
        }
        if(isset($datos_reg['fecha_salida']) && !empty($datos_reg['fecha_salida'])){
            $datos_reg['fecha_salida'] = Carbon::createFromFormat('d/m/Y',$datos_reg['fecha_salida'])->toDateTimeString();
        }
        if(isset($idRegistro)){
            $registro = $this->registroRepository->findWithoutFail($idRegistro);
            $registro = $this->registroRepository->update($datos_reg, $idRegistro);
        }else{
            $datos_reg['estado'] = 'Ocupando';
            $registro = $this->registroRepository->create($datos_reg);
            $habitacion = Habitaciones::find($request->habitacione_id);
            $habitacion->registro_id = $registro->id;
            $habitacion->save();
        }
        //Desocupa la habitacion liberando del registro
        if(isset($request->ocupado) && isset($idRegistro)){
            $habitacion = Habitaciones::where('registro_id',$idRegistro)->first();
            $habitacion->registro_id = null;
            $habitacion->save();

            $registro = $this->registroRepository->findWithoutFail($idRegistro);
            $datos_reg['estado'] = 'Desocupado';
            $registro = $this->registroRepository->update($datos_reg, $idRegistro);
        }
        Flash::success('El registro de habitacion se ha realizado correctamente!!');
        //return redirect()->back();
        return redirect(route('registros.index'));
    }

}

