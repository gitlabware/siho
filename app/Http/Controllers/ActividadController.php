<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateActividadRequest;
use App\Http\Requests\UpdateActividadRequest;
use App\Models\Clientes;
use App\Repositories\ActividadRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;

class ActividadController extends InfyOmBaseController
{
    /** @var  ActividadRepository */
    private $actividadRepository;

    public function __construct(ActividadRepository $actividadRepo)
    {
        $this->actividadRepository = $actividadRepo;
    }

    /**
     * Display a listing of the Actividad.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->actividadRepository->pushCriteria(new RequestCriteria($request));
        //$actividads = $this->actividadRepository->all();
        $idHotel = Auth::user()->hotel_id;
        $actividads = Actividad::where('hotel_id',$idHotel)->orderBy('id','desc')->get();
        //dd($actividads);
        return view('actividads.index')
            ->with('actividads', $actividads);
    }

    /**
     * Show the form for creating a new Actividad.
     *
     * @return Response
     */
    public function create()
    {
        return view('actividads.create');
    }

    /**
     * Store a newly created Actividad in storage.
     *
     * @param CreateActividadRequest $request
     *
     * @return Response
     */
    public function store(CreateActividadRequest $request)
    {
        $input = $request->all();

        $actividad = $this->actividadRepository->create($input);

        Flash::success('Actividad saved successfully.');

        return redirect(route('actividads.index'));
    }

    /**
     * Display the specified Actividad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $actividad = $this->actividadRepository->findWithoutFail($id);

        if (empty($actividad)) {
            Flash::error('Actividad not found');

            return redirect(route('actividads.index'));
        }

        return view('actividads.show')->with('actividad', $actividad);
    }

    /**
     * Show the form for editing the specified Actividad.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $actividad = $this->actividadRepository->findWithoutFail($id);

        if (empty($actividad)) {
            Flash::error('Actividad not found');

            return redirect(route('actividads.index'));
        }

        return view('actividads.edit')->with('actividad', $actividad);
    }

    public function actividad($idCliente,$idActividad = null){
        //dd("dsadsa");
        $cliente = Clientes::find($idCliente);
        if(!empty($idActividad)){

            $actividad = $this->actividadRepository->findWithoutFail($idActividad);
            //dd($actividad);
            return view('actividads.actividad')->with(compact('actividad','cliente'));
        }else{

            return view('actividads.actividad')->with('cliente', $cliente);
        }

    }

    public function guarda_actividad(Request $request,$idActividad = null){
        if (!empty($idActividad)) {
            $actividad = $this->actividadRepository->findWithoutFail($idActividad);
            $actividad = $this->actividadRepository->update($request->all(), $idActividad);
        }else{
            $input = $request->all();
            $actividad = $this->actividadRepository->create($input);
        }

        Flash::success('Se ha registrado correctamente los datos de la actividad');
        return redirect()->back();
        //return redirect(route('actividads.index'));
    }

    /**
     * Update the specified Actividad in storage.
     *
     * @param  int              $id
     * @param UpdateActividadRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateActividadRequest $request)
    {
        $actividad = $this->actividadRepository->findWithoutFail($id);

        if (empty($actividad)) {
            Flash::error('Actividad not found');

            return redirect(route('actividads.index'));
        }

        $actividad = $this->actividadRepository->update($request->all(), $id);

        Flash::success('Actividad updated successfully.');

        return redirect(route('actividads.index'));
    }

    /**
     * Remove the specified Actividad from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $actividad = $this->actividadRepository->findWithoutFail($id);

        if (empty($actividad)) {
            Flash::error('Actividad not found');

            return redirect(route('actividads.index'));
        }

        $this->actividadRepository->delete($id);

        Flash::success('Actividad deleted successfully.');

        return redirect(route('actividads.index'));
    }
}
