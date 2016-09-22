<?php

namespace App\Http\Controllers;

use App\Grupo;
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
use App\Adjunto;

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

    public function cliente($id = null)
    {
        $cliente = null;
        $adjuntos = array();
        if (!empty($id)) {
            $cliente = $this->clientesRepository->findWithoutFail($id);
            $adjuntos = Adjunto::where('cliente_id',$id)->whereNull('deleted_at')->get();
        }
        //dd($adjuntos[0]->nombre_original);
        return view('clientes.cliente')->with(compact('cliente','adjuntos'));
    }

    /**
     * Update the specified Clientes in storage.
     *
     * @param  int $id
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

    public function guarda_cliente(Request $request, $id = null)
    {

        /* foreach ($request->archivos as $archivo){
             //$archivo->getClientOriginalName();
         }*/
        //dd($request->all());
        //dd($request->archivos[1]['datos']->getClientOriginalName());
        //dd($request->archivos);
        //dd($request->archivos[1]['datos']->getClientOriginalExtension());
        //dd($request->archivos[1]['datos']->move('adjuntos', 'ClaseApache2.pdf'));
        //dd($request->file('archivos[1][datos]'));


        //$parametros = $request->all();
        //$parametros['idcliente'] = $id;
        $m_error = '';
        if (!empty($id)) {
            $idCliente = $id;

            if ($request->pasaporte != '') {
                $ver_ci = Clientes::where('id', '<>', $id)->where('pasaporte', $request->pasaporte)->get();
                if (isset($ver_ci[0])) {
                    $m_error = 'Error. El pasaporte del cliente ya fue registrado en el Sistema!!';
                }
            }
            if ($request->ci != '') {
                $ver_ci = Clientes::where('id', '<>', $id)->where('ci', $request->ci)->get();
                if (isset($ver_ci[0])) {
                    $m_error = 'Error. El C.I. del cliente ya fue registrado en el Sistema!!';
                }
            }
            $cliente = $this->clientesRepository->findWithoutFail($id);
            if ($m_error == '') {
                $cliente = $this->clientesRepository->update($request->all(), $id);
            }
        } else {
            if ($request->pasaporte != '') {
                $ver_ci = Clientes::where('pasaporte', $request->pasaporte)->get();
                if (isset($ver_ci[0])) {
                    $m_error = 'Error. El pasaporte del cliente ya fue registrado en el Sistema!!';
                }
            }
            if ($request->ci != '') {
                $ver_ci = Clientes::where('ci', $request->ci)->get();
                if (isset($ver_ci[0])) {
                    $m_error = 'Error. El C.I. del cliente ya fue registrado en el Sistema!!';
                }
            }
            if ($m_error == '') {
                $input = $request->all();
                $cliente = $this->clientesRepository->create($input);
                $idCliente = $cliente->id;
            }

        }
        //----------------- Carga de archivos adjuntos --------------
        if (isset($idCliente)) {
            foreach ($request->archivos as $archivo) {
                if (!empty($archivo['datos'])) {
                    $nombre_original = $archivo['datos']->getClientOriginalName();
                    $ext = $archivo['datos']->getClientOriginalExtension();
                    $nombre_uui = uniqid('', true);
                    if ($archivo['datos']->move('adjuntos', "$nombre_uui.$ext")) {
                        $adjunto = new Adjunto;
                        $adjunto->nombre = "$nombre_uui.$ext";
                        $adjunto->nombre_archivo = "$nombre_uui.$ext";
                        $adjunto->cliente_id = $idCliente;
                        $adjunto->nombre_original = $nombre_original;
                        $adjunto->save();
                    }
                }
            }
        }
        //-----------------------------------------------------

        return response()->json(['m_bueno' => 'Se ha registrado correctamente los datos del cliente!!', 'm_error' => $m_error]);
        //Flash::success('Se ha registrado los datos del cliente correctamente!!');
        //return redirect(route('clientes.index'));*/
    }

    public function elimina_adjunto($idAdjunto){
        $adjunto = Adjunto::find($idAdjunto);
        $adjunto->deleted_at = date('Y-m-d');
        $m_error = '';
        if(!$adjunto->save()){
            $m_error = 'Error. No se ha podido eliminar el archivo adjunto!!';
        }
        return response()->json(['m_bueno' => 'Se ha eliminado correctamente el adjunto!!', 'm_error' => $m_error]);
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

    public function asignahabitacion()
    {
        return view('clientes.asignahabitacion');
    }

    public function asignahabitacion2($tipo,$idCliGrupo)
    {

        /*$habitacion = Habitaciones::find(1);

        dd($habitacion->registro->cliente->nombre);*/
        if($tipo == 'Cliente'){
            $cliente = $this->clientesRepository->find($idCliGrupo);
        }else{
            $cliente = Grupo::find($idCliGrupo);
        }


        //dd($cliente);
        $idHotel = Auth::user()->hotel_id;
        //dd($idHotel);exit;
        $habitaciones = Habitaciones::all()->where('rpiso.hotel_id', $idHotel);
        //dd($habitaciones);

        return view('clientes.asignahabitacion2')->with(compact('habitaciones', 'cliente','tipo'));
    }

    public function getIndex()
    {
        return view('clientes.index');
    }

    public function anyData()
    {
        return Datatables::of(Clientes::query()->orderBy('id', 'desc'))->make(true);
    }


}
