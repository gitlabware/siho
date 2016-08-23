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
use App\Parametro;
use App\Models\Factura;
use Illuminate\Support\Facades\Auth;
use App\Codigo7\Montoliteralcomponent;

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

    public function generar_factura(Request $request){
        //dd($request->flujo_id);
        $idFlujo = $request->flujo_id;
        $flujo = Flujo::find($idFlujo);

        $monto = $flujo->ingreso;
        $nuevocodigo = new CodigoControlV7();
        //$codigo_control = $nuevocodigo->generar(29040011007, 1503, 4189179011, "20070702", round(2500), "9rCB7Sv4X29d)5k7N%3ab89p-3(5[A");
        $nitci = $request->nit;
        $nombre_comprador = $request->cliente;
        $nombre_empresa = "HOTEL";

        //----------------------------------------------------------------------------------------------------------------------


        $fecha = date('Y-m-d');
        //$this->Parametrosfactura = new Parametrosfactura();
        //$this->Factura = new Factura();
        //$pfactura = $this->Parametrosfactura->find('first', array('order' => 'Parametrosfactura.id DESC'));
        $pfactura = Parametro::orderBy('id','desc')->first();
        //dd($pfactura);
        $numero = 1;
        if (!empty($pfactura->numero_ref)) {
            $numero = $pfactura->numero_ref;
        }

        $rcodigo = array();
        if (!empty($pfactura)) {
            if (!empty($pfactura->fechalimite)) {
                if ($pfactura->fechalimite >= $fecha && !empty($pfactura->numero_autorizacion) && !empty($pfactura->llave) && !empty($pfactura->nit)) {
                    $codigo_control = $nuevocodigo->generar($pfactura->numero_autorizacion, $numero, $nitci, str_replace("-", "", $fecha), round($monto), $pfactura->llave);
                    //dd($codigo_control);

                    if (!empty($codigo_control)) {
                        $monto2 = explode('.', $monto);
                        $montoliteral = new Montoliteralcomponent();
                        $totalliteral = $montoliteral->getMontoliteral($monto2[0]);
                        //dd($totalliteral);

                        $factura = new Factura;

                        $factura->nit = $nitci;
                        $factura->nit_p = $pfactura->nit;
                        $factura->importetotal = $monto;
                        $factura->montoliteral = $totalliteral;
                        $factura->fecha = $fecha;
                        $factura->codigo_control = $codigo_control;
                        $factura->numero = $numero;
                        $factura->cliente = $nombre_comprador;
                        $factura->autorizacion = $pfactura->numero_autorizacion;
                        $factura->fecha_limite = $pfactura->fechalimite;



                        if ($factura->save()) {
                            $idFactura = $factura->id;

                            $parametro = Parametro::find($pfactura->id);
                            $parametro->numero_ref = $numero + 1;
                            $parametro->save();

                            $rcodigo['factura_id'] = $idFactura;
                            $rcodigo['codigo'] = $codigo_control;
                            $rcodigo['numero_autorizacion'] = $pfactura->numero_autorizacion;
                            $rcodigo['nit'] = $pfactura->nit;
                            $rcodigo['numero'] = $numero;
                            $rcodigo['fechalimite'] = $pfactura->fechalimite;

                            $fechalimite = explode("-", $rcodigo['fechalimite']);
                            $nfechalimite = $fechalimite[2] . "/" . $fechalimite[1] . "/" . $fechalimite[0];
                            $rcodigo['qr'] = $pfactura->nit . "|" . $nombre_empresa . "|"
                                . $rcodigo['numero'] . "|" . $rcodigo['numero_autorizacion'] . "|" . date('d/m/Y') . "|" .
                                $monto . "|" . $codigo_control . "|" . $nfechalimite . "|" . $nitci . "|" . $nombre_comprador;

                            $factura = Factura::find($idFactura);
                            //dd($idFactura);
                            $factura->qr = $rcodigo['qr'];
                            $factura->save();

                        }
                    }
                }
            }
        }

        return redirect(route('factura',[$idFactura]));
        //dd($factura->numero);
    }

    public function factura($idFactura){
        $factura = Factura::find($idFactura);
        //dd($factura);
        $fecha = explode("-", $factura->fecha);
        $array['01'] = 'ENERO';
        $array['02'] = 'FEBRERO';
        $array['03'] = 'MARZO';
        $array['04'] = 'ABRIL';
        $array['05'] = 'MAYO';
        $array['06'] = 'JUNIO';
        $array['07'] = 'JULIO';
        $array['08'] = 'AGOSTO';
        $array['09'] = 'SEPTIEMBRE';
        $array['10'] = 'OCTUBRE';
        $array['11'] = 'NOVIEMBRE';
        $array['12'] = 'DICIEMBRE';
        $fecha = $fecha[2].' DE '.$array[$fecha[1]].' DE '.$fecha[0];
        //debug($fecha);exit;
        $monto_decimales = explode(".", $factura->importetotal);
        $monto_decimales = $monto_decimales[1].'/100';
        return view('facturas.factura')->with(compact('factura','fecha','monto_decimales'));
    }
}
