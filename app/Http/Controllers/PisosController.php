<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Http\Requests;
use App\Models\Pisos;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreatePisosRequest;
use App\Http\Requests\UpdatePisosRequest;
use App\Repositories\PisosRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Illuminate\Support\Facades\Auth;

use App\Models\Habitaciones;

class PisosController extends InfyOmBaseController
{
    /** @var  PisosRepository */
    private $pisosRepository;

    public function __construct(PisosRepository $pisosRepo)
    {
        $this->pisosRepository = $pisosRepo;
    }

    /**
     * Display a listing of the Pisos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pisosRepository->pushCriteria(new RequestCriteria($request));
        $pisos = $this->pisosRepository->all();

        return view('pisos.index')
            ->with('pisos', $pisos);
    }

    /**
     * Show the form for creating a new Pisos.
     *
     * @return Response
     */
    public function create()
    {
        return view('pisos.create');
    }

    /**
     * Store a newly created Pisos in storage.
     *
     * @param CreatePisosRequest $request
     *
     * @return Response
     */
    public function store(CreatePisosRequest $request)
    {
        $input = $request->all();

        $pisos = $this->pisosRepository->create($input);

        Flash::success('Pisos saved successfully.');

        return redirect(route('pisos.index'));
    }

    /**
     * Display the specified Pisos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pisos = $this->pisosRepository->findWithoutFail($id);

        if (empty($pisos)) {
            Flash::error('Pisos not found');

            return redirect(route('pisos.index'));
        }

        return view('pisos.show')->with('pisos', $pisos);
    }

    /**
     * Show the form for editing the specified Pisos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pisos = $this->pisosRepository->findWithoutFail($id);

        if (empty($pisos)) {
            Flash::error('Pisos not found');

            //return redirect(route('pisos.index'));
            return back();
        }

        return view('pisos.edit')->with('pisos', $pisos);
    }

    /**
     * Update the specified Pisos in storage.
     *
     * @param  int $id
     * @param UpdatePisosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePisosRequest $request)
    {
        $pisos = $this->pisosRepository->findWithoutFail($id);

        if (empty($pisos)) {
            Flash::error('Pisos not found');

            return redirect(route('pisos.index'));
        }

        $pisos = $this->pisosRepository->update($request->all(), $id);

        Flash::success('Pisos updated successfully.');

        //return redirect(route('pisos.index'));
        return back();
    }

    /**
     * Remove the specified Pisos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pisos = $this->pisosRepository->findWithoutFail($id);

        if (empty($pisos)) {
            Flash::error('Pisos not found');

            return redirect(route('pisos.index'));
        }

        $this->pisosRepository->delete($id);

        Flash::success('Pisos deleted successfully.');

        return redirect(route('pisos.index'));
    }

    public function piso($idPiso = null)
    {
        $piso = null;
        if (isset($idPiso)) {
            $piso = Pisos::find($idPiso);
        }
        return view('pisos.piso')->with('piso', $piso);
    }

    public function guarda_piso(Request $request, $idPiso = null){
        $idHotel = Auth::user()->hotel_id;
        //dd($idHotel);
        if(isset($idPiso)){
            $piso = Pisos::find($idPiso);
            $piso->nombre = $request->nombre;
            $piso->hotel_id = $idHotel;
            $piso->save();
        }else{
            $piso = new Pisos;
            $piso->nombre = $request->nombre;
            $piso->hotel_id = $idHotel;
            $piso->save();
        }
        Flash::success('Se ha registrado correctamente el piso!!!');

        return redirect()->back();
    }

    public function pisosHotel($idHotel)
    {
        /*$habitaciones = DB::table('habitaciones')
            ->where('hotel_id', $idHotel)
            ->leftJoin('pisos', 'habitaciones.piso_id', '=', 'pisos.id')
            ->select('habitaciones.id', 'pisos.nombre as piso', 'habitaciones.nombre as hab')
            ->get();*/
        $hotel = \App\Models\Hotel::find($idHotel);
        //$pisos = \App\Models\Hotel::find($idHotel)->rpisos;
        //dd($habitaciones);
        //\Debugbar::info($habitaciones);
        //dd($idHotel);
        $habitaciones = Habitaciones::all()->where('rpiso.hotel_id', $idHotel);


        return view('pisos.pisosHotel')->with(compact('habitaciones', 'hotel'));
    }

    /*public function muestraPisos($idHotel){
        /*$hotel = \App\Models\Hotel::find($idHotel);
        $pisos = \App\Models\Hotel::find($idHotel)->rpisos;
        //dd($hotel);
        \Debugbar::info($pisos);
        return view('pisos.muestraPisos')->with(compact('pisos', 'hotel'));
        return view('pisos.muestraPisos');
    }*/

    /*public function anyData(){
        return Datatables::of(Pisos::query())->make(true);
    }*/
}
