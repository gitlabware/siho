<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateFacturaRequest;
use App\Http\Requests\UpdateFacturaRequest;
use App\Repositories\FacturaRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Codigo7\CodigoControlV7;
use App\Models\Flujo;

class FacturaController extends InfyOmBaseController
{
    /** @var  FacturaRepository */
    private $facturaRepository;

    public function __construct(FacturaRepository $facturaRepo)
    {
        $this->facturaRepository = $facturaRepo;
    }

    /**
     * Display a listing of the Factura.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->facturaRepository->pushCriteria(new RequestCriteria($request));
        $facturas = $this->facturaRepository->all();

        return view('facturas.index')
            ->with('facturas', $facturas);
    }

    /**
     * Show the form for creating a new Factura.
     *
     * @return Response
     */
    public function create()
    {
        return view('facturas.create');
    }

    /**
     * Store a newly created Factura in storage.
     *
     * @param CreateFacturaRequest $request
     *
     * @return Response
     */
    public function store(CreateFacturaRequest $request)
    {
        $input = $request->all();

        $factura = $this->facturaRepository->create($input);

        Flash::success('Factura saved successfully.');

        return redirect(route('facturas.index'));
    }

    /**
     * Display the specified Factura.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $factura = $this->facturaRepository->findWithoutFail($id);

        if (empty($factura)) {
            Flash::error('Factura not found');

            return redirect(route('facturas.index'));
        }

        return view('facturas.show')->with('factura', $factura);
    }

    /**
     * Show the form for editing the specified Factura.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $factura = $this->facturaRepository->findWithoutFail($id);

        if (empty($factura)) {
            Flash::error('Factura not found');

            return redirect(route('facturas.index'));
        }

        return view('facturas.edit')->with('factura', $factura);
    }

    /**
     * Update the specified Factura in storage.
     *
     * @param  int              $id
     * @param UpdateFacturaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFacturaRequest $request)
    {
        $factura = $this->facturaRepository->findWithoutFail($id);

        if (empty($factura)) {
            Flash::error('Factura not found');

            return redirect(route('facturas.index'));
        }

        $factura = $this->facturaRepository->update($request->all(), $id);

        Flash::success('Factura updated successfully.');

        return redirect(route('facturas.index'));
    }

    /**
     * Remove the specified Factura from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $factura = $this->facturaRepository->findWithoutFail($id);

        if (empty($factura)) {
            Flash::error('Factura not found');

            return redirect(route('facturas.index'));
        }

        $this->facturaRepository->delete($id);

        Flash::success('Factura deleted successfully.');

        return redirect(route('facturas.index'));
    }

    public function facturar($idFlujo){

        //$nuevocodigo = new CodigoControlV7();
        //$codigo_control = $nuevocodigo->generar(29040011007, 1503, 4189179011, "20070702", round(2500), "9rCB7Sv4X29d)5k7N%3ab89p-3(5[A");
        $flujo = Flujo::find($idFlujo);
        //dd($flujo->registros[0]->cliente->nombre);
        $cliente = "";
        $nit_ci = "";
        if(isset($flujo->registros[0]) && isset($flujo->registros[0]->cliente->nombre)){
            $cliente = $flujo->registros[0]->cliente->nombre;
        }
        if(isset($flujo->registros[0]) && isset($flujo->registros[0]->cliente->ci)){
            $nit_ci = $flujo->registros[0]->cliente->ci;
        }
        return view('facturas.facturar')->with(compact('flujo','cliente','nit_ci'));
        
    }
}
