<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreatePrecioshabitacionesRequest;
use App\Http\Requests\UpdatePrecioshabitacionesRequest;
use App\Repositories\PrecioshabitacionesRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PrecioshabitacionesController extends InfyOmBaseController
{
    /** @var  PrecioshabitacionesRepository */
    private $precioshabitacionesRepository;

    public function __construct(PrecioshabitacionesRepository $precioshabitacionesRepo)
    {
        $this->precioshabitacionesRepository = $precioshabitacionesRepo;
    }

    /**
     * Display a listing of the Precioshabitaciones.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->precioshabitacionesRepository->pushCriteria(new RequestCriteria($request));
        $precioshabitaciones = $this->precioshabitacionesRepository->all();

        return view('precioshabitaciones.index')
            ->with('precioshabitaciones', $precioshabitaciones);
    }

    /**
     * Show the form for creating a new Precioshabitaciones.
     *
     * @return Response
     */
    public function create()
    {
        return view('precioshabitaciones.create');
    }

    /**
     * Store a newly created Precioshabitaciones in storage.
     *
     * @param CreatePrecioshabitacionesRequest $request
     *
     * @return Response
     */
    public function store(CreatePrecioshabitacionesRequest $request)
    {
        $input = $request->all();

        $precioshabitaciones = $this->precioshabitacionesRepository->create($input);

        Flash::success('Precioshabitaciones saved successfully.');

        return redirect(route('precioshabitaciones.index'));
    }

    /**
     * Display the specified Precioshabitaciones.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $precioshabitaciones = $this->precioshabitacionesRepository->findWithoutFail($id);

        if (empty($precioshabitaciones)) {
            Flash::error('Precioshabitaciones not found');

            return redirect(route('precioshabitaciones.index'));
        }

        return view('precioshabitaciones.show')->with('precioshabitaciones', $precioshabitaciones);
    }

    /**
     * Show the form for editing the specified Precioshabitaciones.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $precioshabitaciones = $this->precioshabitacionesRepository->findWithoutFail($id);

        if (empty($precioshabitaciones)) {
            Flash::error('Precioshabitaciones not found');

            return redirect(route('precioshabitaciones.index'));
        }

        return view('precioshabitaciones.edit')->with('precioshabitaciones', $precioshabitaciones);
    }

    /**
     * Update the specified Precioshabitaciones in storage.
     *
     * @param  int              $id
     * @param UpdatePrecioshabitacionesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePrecioshabitacionesRequest $request)
    {
        $precioshabitaciones = $this->precioshabitacionesRepository->findWithoutFail($id);

        if (empty($precioshabitaciones)) {
            Flash::error('Precioshabitaciones not found');

            return redirect(route('precioshabitaciones.index'));
        }

        $precioshabitaciones = $this->precioshabitacionesRepository->update($request->all(), $id);

        Flash::success('Precioshabitaciones updated successfully.');

        return redirect(route('precioshabitaciones.index'));
    }

    /**
     * Remove the specified Precioshabitaciones from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $precioshabitaciones = $this->precioshabitacionesRepository->findWithoutFail($id);

        if (empty($precioshabitaciones)) {
            Flash::error('Precioshabitaciones not found');

            return redirect(route('precioshabitaciones.index'));
        }

        $this->precioshabitacionesRepository->delete($id);

        Flash::success('Precioshabitaciones deleted successfully.');

        return redirect(route('precioshabitaciones.index'));
    }

    public function ingresaPrecio($idHabitacion){
        //dd($idHabitacion);
        return view('precioshabitaciones.ingresaprecio');
    }
}
