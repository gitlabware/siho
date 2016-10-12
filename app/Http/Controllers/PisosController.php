<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use DB;
use Log;
use App\Http\Requests;
use App\Models\Pisos;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreatePisosRequest;
use App\Http\Requests\UpdatePisosRequest;
use App\Repositories\PrecioshabitacionesRepository;
use App\Repositories\PisosRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Precioshabitaciones;
use Illuminate\Support\Facades\Auth;

use App\Models\Habitaciones;

class PisosController extends InfyOmBaseController
{
    /** @var  PisosRepository */
    private $pisosRepository;
    private $precioshabitacionesRepository;

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

        return redirect()->back();
    }

    public function piso($idHotel, $idPiso = null)
    {
        $piso = null;
        if (isset($idPiso)) {
            $piso = Pisos::find($idPiso);
        }
        return view('pisos.piso')->with(compact('piso', 'idHotel'));
    }

    public function guarda_piso(Request $request, $idPiso = null)
    {

        //$idHotel = Auth::user()->hotel_id;
        //dd($idHotel);
        if (isset($idPiso)) {
            $piso = Pisos::find($idPiso);
            $piso->nombre = $request->nombre;
            $piso->hotel_id = $request->hotel_id;
            $piso->save();
        } else {
            $piso = new Pisos;
            $piso->nombre = $request->nombre;
            $piso->hotel_id = $request->hotel_id;
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
        //$habitaciones = Habitaciones::all()->where('rpiso.hotel_id', $idHotel);
        $habitaciones = Habitaciones::whereHas('rpiso', function ($query) use ($idHotel) {
            $query->where('hotel_id', $idHotel);
        })->get();


        return view('pisos.pisosHotel')->with(compact('habitaciones', 'hotel'));
    }

    public function pisos($idHotel)
    {
        $hotel = Hotel::find($idHotel);
        $pisos = Pisos::where('hotel_id', $idHotel)->get();
        return view('pisos.pisos')->with(compact('pisos', 'hotel'));
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


    public function opcioneshab(Request $request)
    {
        //dd($request->all());
        $habitaciones = array();
        $precios = array();
        if (isset($request->habitaciones)) {
            $habitaciones = $request->habitaciones;
            $l_habitaciones = array();
            foreach ($habitaciones as $idHabitacion => $habitacion) {
                $l_habitaciones[$idHabitacion] = $idHabitacion;
                $habitaciones[$idHabitacion] = Habitaciones::find($idHabitacion);
            }
            $nume_habi2 = count($l_habitaciones);
            $precios = Precioshabitaciones::where(function ($query) use ($l_habitaciones) {
                $nume_habi = count($l_habitaciones);
                if ($nume_habi == 1) {
                    $query->where('habitacione_id', current($l_habitaciones));
                } else {
                    $query->whereIn('habitacione_id', $l_habitaciones);
                }
            })->groupBy('precio')->havingRaw('COUNT(precio) = ' . $nume_habi2)->get();
            //dd($precios[0]->precio);
        }
        return view('pisos.opcioneshab')->with(compact('habitaciones', 'precios'));
    }

    public function guarda_precio_h(Request $request)
    {
        //dd($request->all());
        if(!empty($request->habitaciones)){
            foreach ($request->habitaciones as $idHabitacion => $habitacione) {
                $precio = new Precioshabitaciones;
                $precio->precio = $request->precio;
                $precio->habitacione_id = $idHabitacion;
                $precio->save();
            }
            Flash::success('Se ha registrado los precios a las habitaciones!!');
        }else{
            Flash::error('No ha seleccionado habitaciones!!');
        }


        return redirect()->back();
    }

    public function elimina_precio_h(Request $request,PrecioshabitacionesRepository $precioshabitacionesRepo)
    {
        $this->precioshabitacionesRepository = $precioshabitacionesRepo;
        //dd($request->all());
        foreach ($request->habitaciones as $idHabitacion => $habitacione) {
            $precio = Precioshabitaciones::where('precio', $request->precio)->where('habitacione_id', $idHabitacion)->first();
            //dd($precio->id);
            $precioshabitaciones = $this->precioshabitacionesRepository->findWithoutFail($precio->id);
            $this->precioshabitacionesRepository->delete($precio->id);
            //$precio->delete();
            // Precioshabitaciones::destroy($precio->id);
        }
        Flash::success('Se ha registrado los precios a las habitaciones!!');
        return redirect()->back();
    }
}
