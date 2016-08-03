<?php

namespace App\Http\Controllers;

use App\Models\Habitaciones;
use DB;
use App\Http\Requests;
use App\Http\Requests\CreateHabitacionesRequest;
use App\Http\Requests\UpdateHabitacionesRequest;
use App\Models\Hotel;
use App\Repositories\HabitacionesRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\Pisos;

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

    public function nuevaHabitacion($idHotel){
        $habitacion = \App\Models\Habitaciones::find($idHotel);
        $habitacionPiso = $habitacion->piso_id;
        $piso = \App\Models\Pisos::find($habitacionPiso);
        $idHotel = $piso->hotel_id;
        $pisosHotel = DB::table('pisos')
            ->where('hotel_id', $idHotel)
            ->select('id', 'nombre')
            ->get();
        return view('habitaciones.create')
            ->with(compact('pisosHotel'));
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
        $idPiso = \App\Models\Pisos::find($request->input('piso_id'));
        $idHotel = $idPiso->hotel_id;
        $habitaciones = $this->habitacionesRepository->create($input);

        Flash::success('Habitaciones saved successfully.');

        //return redirect(route('habitaciones.index'));
        return redirect()->action('PisosController@pisosHotel', [$idHotel]);
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
        //dd($habitaciones);
        $habitacion = \App\Models\Habitaciones::find($id);
        $habitacionPiso = $habitacion->piso_id;
        $piso = \App\Models\Pisos::find($habitacionPiso);
        $idHotel = $piso->hotel_id;
        $pisosHotel = DB::table('pisos')
            ->where('hotel_id', $idHotel)
            ->select('id', 'nombre')
            ->get();
        //\Debugbar::info($pisosHotel);

        //\Debugbar::info($piso);

        if (empty($habitaciones)) {
            Flash::error('Habitaciones not found');

            return redirect(route('habitaciones.index'));

        }
        return view('habitaciones.edit')->with(compact('habitaciones', 'pisosHotel'));
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
        $habitacion = \App\Models\Habitaciones::find($id);
        $habitacionPiso = $habitacion->piso_id;
        $piso = \App\Models\Pisos::find($habitacionPiso);
        $idHotel = $piso->hotel_id;

        if (empty($habitaciones)) {
            Flash::error('Habitaciones not found');

            return redirect(route('habitaciones.index'));
        }

        $habitaciones = $this->habitacionesRepository->update($request->all(), $id);

        Flash::success('Habitaciones updated successfully.');

        //return redirect(route('pisosHotel', [$idHotel]));
        return redirect()->action('PisosController@pisosHotel', [$idHotel]);
        //return back()->withInput();
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

    public function vhabitaciones()
    {
        $idHotel = Auth::user()->hotel_id;
        $hotel = Hotel::find($idHotel);
        //dd($idHotel);
        $pisos = Pisos::all()->where('hotel_id',$idHotel);

        return view('habitaciones.vhabitaciones')->with(compact('pisos','hotel'));
        //dd($pisos[0]->habitaciones[0]->nombre);
    }

    public function informacion_habitacion($idHabitacion){
        $habitacion = Habitaciones::find($idHabitacion);
        return view('habitaciones.informacion_habitacion')->with(compact('habitacion'));
    }
}
