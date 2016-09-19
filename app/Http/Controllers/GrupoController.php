<?php
namespace App\Http\Controllers;

use App\Grupo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro;
use App\Hospedante;
use App\Pago;


class GrupoController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(){
        $idHotel = Auth::user()->hotel_id;
        $grupos = Grupo::where('hotel_id',$idHotel)->get();
        return view('grupos.index')->with(compact('grupos'));
    }

    public function registrosgrupos($idGrupo){
        $grupo = Grupo::find($idGrupo);
        $registros = Registro::where('grupo_id',$idGrupo)->get();
        //$pagos = Pago::where('registro.grupo_id',$idGrupo)->get();

        $pagos = Pago::whereHas('registro', function ($query) use ($idGrupo){
            $query->where('grupo_id', $idGrupo);
        })->get();
        return view('grupos.registrosgrupos')->with(compact('grupo','registros','pagos'));
    }

    public function registrapagosg(Request $request){
        if(!empty($request->pagos)){
            //dd($request->pagos);
            $total = 0.00;
            $descripcion = '';
            foreach ($request->pagos as $idPago => $pago) {
                $pago = Pago::find($idPago);
                $pago->estado = 'Pagado';
                $pago->save();
                $total = $total + $pago->monto_total;
                $descripcion = $descripcion + $pago->registro->habitacione->nombre;
            }
            Flash::success('Se ha registro los pagos como pagado exitosamente!!');
        }else{
            Flash::error('No se ha marcado ningun pago!!');
        }
        return redirect()->back();

    }

}