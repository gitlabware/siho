<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Requests\CreateCajaRequest;
use App\Http\Requests\UpdateCajaRequest;
use App\Models\Caja;
use App\Models\Flujo;
use App\Repositories\CajaRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Auth;

class CajaController extends InfyOmBaseController
{
    /** @var  CajaRepository */
    private $cajaRepository;

    public function __construct(CajaRepository $cajaRepo)
    {
        $this->cajaRepository = $cajaRepo;
    }

    /**
     * Display a listing of the Caja.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $idHotel = Auth::user()->hotel_id;
        //$this->cajaRepository->pushCriteria(new RequestCriteria($request));

        $cajas = Caja::all()->where('hotel_id', $idHotel);
        //$cajas = $this->cajaRepository->all();

        return view('cajas.index')
            ->with('cajas', $cajas);
    }

    /**
     * Show the form for creating a new Caja.
     *
     * @return Response
     */
    public function create()
    {
        return view('cajas.create');
    }

    /**
     * Store a newly created Caja in storage.
     *
     * @param CreateCajaRequest $request
     *
     * @return Response
     */
    public function store(CreateCajaRequest $request)
    {
        $input = $request->all();

        $caja = $this->cajaRepository->create($input);

        Flash::success('Caja saved successfully.');

        return redirect(route('cajas.index'));
    }

    /**
     * Display the specified Caja.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $caja = $this->cajaRepository->findWithoutFail($id);

        if (empty($caja)) {
            Flash::error('Caja not found');

            return redirect(route('cajas.index'));
        }

        return view('cajas.show')->with('caja', $caja);
    }

    /**
     * Show the form for editing the specified Caja.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $caja = $this->cajaRepository->findWithoutFail($id);

        if (empty($caja)) {
            Flash::error('Caja not found');

            return redirect(route('cajas.index'));
        }

        return view('cajas.edit')->with('caja', $caja);
    }

    /**
     * Update the specified Caja in storage.
     *
     * @param  int $id
     * @param UpdateCajaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCajaRequest $request)
    {
        $caja = $this->cajaRepository->findWithoutFail($id);

        if (empty($caja)) {
            Flash::error('Caja not found');

            return redirect(route('cajas.index'));
        }

        $caja = $this->cajaRepository->update($request->all(), $id);

        Flash::success('Caja updated successfully.');

        return redirect(route('cajas.index'));
    }

    /**
     * Remove the specified Caja from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $caja = $this->cajaRepository->findWithoutFail($id);

        if (empty($caja)) {
            Flash::error('Caja not found');

            return redirect(route('cajas.index'));
        }

        $this->cajaRepository->delete($id);

        Flash::success('Caja deleted successfully.');

        return redirect(route('cajas.index'));
    }


    public function flujos($idCaja)
    {
        //dd($this->get_total($idCaja)->total);
        $caja = $this->cajaRepository->findWithoutFail($idCaja);
        //dd($caja->nombre);
        $flujos = Flujo::all()->where('caja_id',$idCaja);
        //dd($flujos);
        return view('cajas.flujos')->with(compact('caja', 'flujos'));
    }

    public function ingreso($idCaja)
    {
        return view('cajas.ingreso')->with(compact('idCaja'));
    }

    public function egreso($idCaja)
    {
        return view('cajas.egreso')->with(compact('idCaja'));
    }

    public function eliminaflujo($idFlujo)
    {
        $flujo = Flujo::find($idFlujo);
        return view('cajas.eliminaflujo')->with(compact('idFlujo', 'flujo'));
    }

    public function guarda_ingreso(Request $request)
    {

        $flujo = new Flujo;
        $flujo->detalle = $request->detalle;
        $flujo->ingreso = $request->ingreso;
        $flujo->observacion = $request->observacion;
        $flujo->salida = $request->salida;
        $flujo->caja_id = $request->caja_id;
        $flujo->user_id = $request->user_id;
        $flujo->save();

        $total = $this->get_total($request->caja_id);
        $this->set_total($request->caja_id, ($total + $request->ingreso));

        Flash::success('El ingreso se ha registrado correctamente!!');
        return redirect()->back();

    }

    public function guarda_egreso(Request $request)
    {

        $total = $this->get_total($request->caja_id);

        if ($total >= $request->salida) {
            $flujo = new Flujo;
            $flujo->detalle = $request->detalle;
            $flujo->ingreso = $request->ingreso;
            $flujo->observacion = $request->observacion;
            $flujo->salida = $request->salida;
            $flujo->caja_id = $request->caja_id;
            $flujo->user_id = $request->user_id;
            $flujo->save();


            $this->set_total($request->caja_id, ($total - $request->salida));
            Flash::success('El ingreso se ha registrado correctamente!!');
        } else {
            Flash::error('No se pudo registral el egreso por q solo hay ' . $total . ' en caja!!');
        }

        return redirect()->back();

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

    public function eliminar_flujo(Request $request, $idFlujo)
    {
        //dd($request);
        $flujo = Flujo::find($idFlujo);
        $total = $this->get_total($flujo->caja_id);
        if($flujo->ingreso != 0){
            if($total >= $flujo->ingreso){
                $this->set_total($flujo->caja_id,($total-$flujo->ingreso));
            }else{
                Flash::error('No se ha podido eliminar el flujo por que el total es solo '.$total);
                return redirect()->back();
            }
        }else{
            $this->set_total($flujo->caja_id,($total+$flujo->salida));
        }
        $flujo->deleted_at = date('Y-m-d H:m:i');
        $flujo->observacion = $request->observacion;
        $flujo->save();
        Flash::success('Se ha eliminado correctamente el flujo!!');
        return redirect()->back();
    }


}
