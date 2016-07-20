<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Habitaciones;
use App\Models\Pisos;
use App\Http\Requests;
use App\Http\Requests\CreateHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Repositories\HotelRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class HotelController extends InfyOmBaseController
{
    /** @var  HotelRepository */
    private $hotelRepository;

    public function __construct(HotelRepository $hotelRepo)
    {
        $this->middleware('auth');
        $this->hotelRepository = $hotelRepo;
    }

    /**
     * Display a listing of the Hotel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->hotelRepository->pushCriteria(new RequestCriteria($request));
        $hotels = $this->hotelRepository->all();
        //$habitaciones = $this->hotelRepository->find(2)->habitaciones;
        //$habita = \App\Models\Hotel::find(2);
        //$ha = \App\Models\Hotel::find(2)->habitaciones;
        //$ha = $this->Hotel->all();
        //dd($ha);
        return view('hotels.index')
            ->with('hotels', $hotels);
    }

    /**
     * @return HotelRepository
     */
    public function muestraHabitaciones($idHotel)
    {
        //dd($idHotel);
        /*$ha = DB::table('habitaciones')
            ->leftJoin('hotels','hotels.id','=','habitaciones.hotel_id')
            ->select('hotels.nombre', 'habitaciones.piso')
            ->where('hotels.id',$idHotel)
            ->get();*/
        //dd($ha);
        //$habitaciones = \App\Models\Hotel::find($idHotel)->rhabitaciones;
        /*foreach ($habitaciones as $h){
            echo($h);
        }*/
        //dd($habitaciones);
        //return view('hotels.muestraHabitaciones', compact('habitaciones'));
    }

    /**
     * Show the form for creating a new Hotel.
     *
     * @return Response
     */
    public function create()
    {
        return view('hotels.create');
    }

    /**
     * Store a newly created Hotel in storage.
     *
     * @param CreateHotelRequest $request
     *
     * @return Response
     */
    public function store(CreateHotelRequest $request)
    {
        $input = $request->all();
        //dd($input);

        $pisos = $request->pisos;
        $habitaciones = $request->input('habitaciones');
        $camas = $request->camas;

        $hotel = $this->hotelRepository->create($input);

        if ($hotel) {
            $idHotel = $hotel->id;
            //echo 'hotel: '.$idHotel;
            //dd($idHotel);
            for ($i = 1; $i <= $pisos; $i++) {
                $p = new Pisos();
                $p->hotel_id = $idHotel;
                $p->nombre = 'Piso ' . $i;
                $p->save();
                $idPiso = $p->id;
                //echo 'Piso: ' . $idPiso;
                for ($c = 1; $c <= $habitaciones; $c++) {
                    echo 'Piso: ' . $i . 'Habitacion: ' . $c . 'camas por habitacion: ' . $camas . '<p>';
                    $h = new Habitaciones();
                    $h->piso_id = $idPiso;
                    //$h->hotel_id = $idHotel;
                    $h->camas = $camas;
                    $h->nombre = $i.'0'.$c;
                    $h->save();
                }
            }
            Flash::success('Se guardo correctamente.');
        } else {
            Flash::error('Error al guradar.');
        }

        /*Log::info($pisos);
        echo '<pre>';
        print_r($input);
        echo '</pre>';
        \Debugbar::info($input);
        echo $habitaciones;
        dd($pisos);

        \Debugbar::info($pisos);*/

        /*$hotel = $this->hotelRepository->create($input);1

        Flash::success('Hotel saved successfully.');*/

        return redirect(route('hotels.index'));
    }

    /**
     * Display the specified Hotel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $hotel = $this->hotelRepository->findWithoutFail($id);

        if (empty($hotel)) {
            Flash::error('Hotel not found');

            return redirect(route('hotels.index'));
        }

        return view('hotels.show')->with('hotel', $hotel);
    }

    /**
     * Show the form for editing the specified Hotel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hotel = $this->hotelRepository->findWithoutFail($id);

        if (empty($hotel)) {
            Flash::error('Hotel not found');

            return redirect(route('hotels.index'));
        }

        return view('hotels.edit')->with('hotel', $hotel);
    }

    /**
     * Update the specified Hotel in storage.
     *
     * @param  int $id
     * @param UpdateHotelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHotelRequest $request)
    {
        $hotel = $this->hotelRepository->findWithoutFail($id);

        if (empty($hotel)) {
            Flash::error('Hotel not found');

            return redirect(route('hotels.index'));
        }

        $hotel = $this->hotelRepository->update($request->all(), $id);

        Flash::success('Hotel updated successfully.');

        return redirect(route('hotels.index'));
    }

    /**
     * Remove the specified Hotel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $hotel = $this->hotelRepository->findWithoutFail($id);

        if (empty($hotel)) {
            Flash::error('Hotel not found');

            return redirect(route('hotels.index'));
        }

        $this->hotelRepository->delete($id);

        Flash::success('Hotel deleted successfully.');

        return redirect(route('hotels.index'));
    }

    public function pisos()
    {

    }
}
