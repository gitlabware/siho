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
        $this->cajaRepository->pushCriteria(new RequestCriteria($request));
        $cajas = $this->cajaRepository->all();

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
     * @param  int              $id
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



    public function flujos($idCaja){
        //dd($this->get_total($idCaja)->total);
        $caja = $this->cajaRepository->findWithoutFail($idCaja);
        //dd($caja->nombre);
        $flujos = Flujo::all();
        //dd($flujos);
        return view('cajas.flujos')->with(compact('caja','flujos'));
    }

    public function ingreso($idCaja){
        return view('cajas.ingreso')->with(compact('idCaja'));
    }

    public function guarda_ingreso(Request $request){


        $flujo = new Flujo;
        $flujo->detalle = $request->ingreso;
        $flujo->ingreso = $request->ingreso;
        $flujo->observacion = $request->observacion;
        $flujo->salida = $request->salida;
        $flujo->caja_id = $request->caja_id;
        $flujo->user_id = $request->user_id;
        $flujo->save();

        Flash::success('El ingreso se ha registrado correctamente!!');

        return redirect(route('cajas.index'));

    }

    public function get_total($idCaja = null){
        $cajas = Caja::find($idCaja);
        return $cajas;
    }



}
