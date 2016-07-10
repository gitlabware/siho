<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateHabitacionesRequest;
use App\Http\Requests\UpdateHabitacionesRequest;
use App\Repositories\HabitacionesRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class HabitacionesController extends InfyOmBaseController
{
    /** @var  HabitacionesRepository */
    private $habitacionesRepository;

    public function __construct(HabitacionesRepository $habitacionesRepo)
    {
        $this->habitacionesRepository = $habitacionesRepo;
    }

    /**
     * Display a listing of the Habitaciones.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->habitacionesRepository->pushCriteria(new RequestCriteria($request));
        $habitaciones = $this->habitacionesRepository->all();

        return view('habitaciones.index')
            ->with('habitaciones', $habitaciones);
    }

    /**
     * Show the form for creating a new Habitaciones.
     *
     * @return Response
     */
    public function create()
    {
        return view('habitaciones.create');
    }

    /**
     * Store a newly created Habitaciones in storage.
     *
     * @param CreateHabitacionesRequest $request
     *
     * @return Response
     */
    public function store(CreateHabitacionesRequest $request)
    {
        $input = $request->all();

        $habitaciones = $this->habitacionesRepository->create($input);

        Flash::success('Habitaciones saved successfully.');

        return redirect(route('habitaciones.index'));
    }

    /**
     * Display the specified Habitaciones.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $habitaciones = $this->habitacionesRepository->findWithoutFail($id);

        if (empty($habitaciones)) {
            Flash::error('Habitaciones not found');

            return redirect(route('habitaciones.index'));
        }

        return view('habitaciones.show')->with('habitaciones', $habitaciones);
    }

    /**
     * Show the form for editing the specified Habitaciones.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $habitaciones = $this->habitacionesRepository->findWithoutFail($id);

        if (empty($habitaciones)) {
            Flash::error('Habitaciones not found');

            return redirect(route('habitaciones.index'));
        }

        return view('habitaciones.edit')->with('habitaciones', $habitaciones);
    }

    /**
     * Update the specified Habitaciones in storage.
     *
     * @param  int              $id
     * @param UpdateHabitacionesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHabitacionesRequest $request)
    {
        $habitaciones = $this->habitacionesRepository->findWithoutFail($id);

        if (empty($habitaciones)) {
            Flash::error('Habitaciones not found');

            return redirect(route('habitaciones.index'));
        }

        $habitaciones = $this->habitacionesRepository->update($request->all(), $id);

        Flash::success('Habitaciones updated successfully.');

        return redirect(route('habitaciones.index'));
    }

    /**
     * Remove the specified Habitaciones from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $habitaciones = $this->habitacionesRepository->findWithoutFail($id);

        if (empty($habitaciones)) {
            Flash::error('Habitaciones not found');

            return redirect(route('habitaciones.index'));
        }

        $this->habitacionesRepository->delete($id);

        Flash::success('Habitaciones deleted successfully.');

        return redirect(route('habitaciones.index'));
    }

    public function listado($idHotel)
    {
        $habitaciones = \App\Models\Habitaciones::find('');
    }
}
