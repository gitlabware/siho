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

use App\Models\Precioshabitaciones;
use App\Models\Clientes;
use App\Models\Habitaciones;

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
    public function index(Request $request)
    {
        $this->registroRepository->pushCriteria(new RequestCriteria($request));
        $registros = $this->registroRepository->all();

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

    public function nuevo($idCliente,$idHabitacion)
    {
        //dd($idHabitacion);
        //return view('registros.create');

        $precios = Precioshabitaciones::where('habitacione_id' , $idHabitacion)->get()->lists('precio','precio')->all();
        //dd($precios);
        $cliente = Clientes::find($idCliente);

        $habitacion = Habitaciones::find($idHabitacion);

        return view('registros.nuevo')->with(compact('precios','habitacion','cliente'));


    }

    public function guarda_registro(Request $request){
        //dd($request->all());
        $input = $request->all();
        $input['estado'] = 'Ocupando';
        $registro = $this->registroRepository->create($input);

        $habitacion = Habitaciones::find($request->habitacione_id);
        $habitacion->registro_id = $registro->id;

        $habitacion->save();

        Flash::success('El registro de habitacion se ha realizado correctamente!!');
        return redirect(route('registros.index'));

    }


}

