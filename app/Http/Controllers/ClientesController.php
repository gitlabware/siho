<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateClientesRequest;
use App\Http\Requests\UpdateClientesRequest;
use App\Repositories\ClientesRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Clientes;

use Yajra\Datatables\Datatables;

use App\Models\Habitaciones;

class ClientesController extends InfyOmBaseController
{
    /** @var  ClientesRepository */
    private $clientesRepository;

    public function __construct(ClientesRepository $clientesRepo)
    {
        $this->clientesRepository = $clientesRepo;
    }

    /**
     * Display a listing of the Clientes.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->clientesRepository->pushCriteria(new RequestCriteria($request));
        //$clientes = $this->clientesRepository->all();
        /*$clientes = Clientes::query();
        dd($clientes);*/
        return view('clientes.index');
           // ->with('clientes', $clientes);
    }

    /**
     * Show the form for creating a new Clientes.
     *
     * @return Response
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created Clientes in storage.
     *
     * @param CreateClientesRequest $request
     *
     * @return Response
     */
    public function store(CreateClientesRequest $request)
    {
        $input = $request->all();

        $clientes = $this->clientesRepository->create($input);

        Flash::success('Clientes saved successfully.');

        return redirect(route('clientes.index'));
    }

    /**
     * Display the specified Clientes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $clientes = $this->clientesRepository->findWithoutFail($id);

        if (empty($clientes)) {
            Flash::error('Clientes not found');

            return redirect(route('clientes.index'));
        }

        return view('clientes.show')->with('clientes', $clientes);
    }

    /**
     * Show the form for editing the specified Clientes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $clientes = $this->clientesRepository->findWithoutFail($id);

        if (empty($clientes)) {
            Flash::error('Clientes not found');

            return redirect(route('clientes.index'));
        }

        return view('clientes.edit')->with('clientes', $clientes);
    }

    /**
     * Update the specified Clientes in storage.
     *
     * @param  int              $id
     * @param UpdateClientesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClientesRequest $request)
    {
        $clientes = $this->clientesRepository->findWithoutFail($id);

        if (empty($clientes)) {
            Flash::error('Clientes not found');

            return redirect(route('clientes.index'));
        }

        $clientes = $this->clientesRepository->update($request->all(), $id);

        Flash::success('Clientes updated successfully.');

        return redirect(route('clientes.index'));
    }

    /**
     * Remove the specified Clientes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $clientes = $this->clientesRepository->findWithoutFail($id);

        if (empty($clientes)) {
            Flash::error('Clientes not found');

            return redirect(route('clientes.index'));
        }

        $this->clientesRepository->delete($id);

        Flash::success('Clientes deleted successfully.');

        return redirect(route('clientes.index'));
    }

    public function asignahabitacion(){
        return view('clientes.asignahabitacion');
    }
    public function asignahabitacion2($idCliente,$num_reg = null){

        /*$habitacion = Habitaciones::find(1);

        dd($habitacion->registro->cliente->nombre);*/

        $cliente = $this->clientesRepository->find($idCliente);
        //dd($cliente);
        $idHotel = Auth::user()->hotel_id;
        //dd($idHotel);exit;
        $habitaciones = Habitaciones::all()->where('rpiso.hotel_id',$idHotel);
        //dd($habitaciones);

        return view('clientes.asignahabitacion2')->with(compact('habitaciones','cliente','num_reg'));
    }

    public function getIndex(){
        return view('clientes.index');
    }

    public function anyData(){
        return Datatables::of(Clientes::query())->make(true);
    }

}
