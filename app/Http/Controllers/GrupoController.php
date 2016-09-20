<?php
namespace App\Http\Controllers;

use App\Grupo;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro;
use App\Hospedante;
use App\Pago;
use App\Models\Flujo;
use App\Models\Caja;
use Flash;
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
        $idHotel = Auth::user()->hotel_id;
        $grupo = Grupo::find($idGrupo);
        $registros = Registro::where('grupo_id',$idGrupo)->get();
        //$pagos = Pago::where('registro.grupo_id',$idGrupo)->get();

        $pagos_pendientes = Pago::where('estado', 'Deuda')->whereHas('registro', function ($query) use ($idGrupo){
            $query->where('grupo_id', $idGrupo);
        })->get();
        $pagos_recibidos = Pago::where('estado', 'Pagado')->whereHas('registro', function ($query) use ($idGrupo){
            $query->where('grupo_id', $idGrupo);
        })->get();

        $cajas = Caja::where('hotel_id', $idHotel)->get()->lists('nombre', 'id')->all();
        return view('grupos.registrosgrupos')->with(compact('grupo','registros','pagos_pendientes','cajas','pagos_recibidos'));
    }

    public function registrapagosg(Request $request){
        if(!empty($request->pagos)){
            //dd($request->pagos);
            $grupo = Grupo::find($request->grupo_id);

            $total = 0.00;
            $descripcion = '';
            foreach ($request->pagos as $idPago => $pago) {
                $pago = Pago::find($idPago);
                $pago->estado = 'Pagado';
                $pago->save();
                $total = $total + $pago->monto_total;
                $descripcion = $descripcion.'<tr><td> Habitacion: '.$pago->registro->habitacione->nombre.' ('.$pago->registro->habitacione->categoria->nombre.') por fecha '.$pago->fecha.'</td><td>'.$pago->monto_total.' Bs. </td></tr>';
            }
            $descripcion = $descripcion.'<tr><td><b>TOTAL:</b></td><td><b>'.$total.' Bs.</b></td></tr>';
            $descripcion = '<table class="table table-bordered"'.$descripcion.'</table>';

            $flujo = new Flujo;
            $flujo->detalle = 'Pago de Registro '.$grupo->nombre;
            $flujo->descripcion = $descripcion;
            $flujo->ingreso = $total;
            $flujo->observacion = '';
            $flujo->salida = 0;
            $flujo->caja_id = $request->caja_id;
            $flujo->user_id = $request->user_id;
            $flujo->save();
            $total_c = $this->get_total($request->caja_id);
            $this->set_total($request->caja_id, ($total_c + $total));
            $idFlujo = $flujo->id;

            foreach ($request->pagos as $idPago => $pago) {
                $pago = Pago::find($idPago);
                $pago->flujo_id = $idFlujo;
                $pago->save();
            }
            Flash::success('Se ha registro los pagos como pagado exitosamente!!');
            return redirect(route('flujos',[$request->caja_id]));
        }else{
            Flash::error('No se ha marcado ningun pago!!');
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

    public function marcasalida($idRegistro){
        $registro = Registro::find($idRegistro);
        $registro->estado = 'Salida';
        $registro->save();
        $hospedantes = Hospedante::where('registro_id',$idRegistro)->where('estado','Ocupando')->get();
        foreach ($hospedantes as $hospedante) {
            $hospedante->estado = 'Salida';
            $hospedante->save();
        }
        Flash::success('Se ha registrado la salida del registro correctamente!!');
        return redirect()->back();
    }

    public function cancelaregistro($idRegistro){
        $registro = Registro::find($idRegistro);
        $registro->estado = 'Cancelado';
        $registro->save();
        $hospedantes = Hospedante::where('registro_id',$idRegistro)->where('estado','Ocupando')->get();
        foreach ($hospedantes as $hospedante) {
            $hospedante->estado = 'Cancelado';
            $hospedante->save();
        }

        $pagos = Pago::where('estado','Deuda')->where('registro_id',$idRegistro)->get();
        foreach ($pagos as $pago){
            $pago->estado = 'Cancelado';
            $pago->save();
        }
        Flash::success('Se ha cancelado el registro satisfactoriamente!!');
        return redirect()->back();
    }

    public function generadeudasgrupos(){
        //dd(date('H:i'));
        $fecha_actual = date('Y-m-d');
        if(date('H') < 12){
            $fecha_actual = date('Y-m-d', strtotime($fecha_actual . ' -1 day'));
        }

        //dd($this->createDateRangeArray('2016-09-08','2016-09-19'));
        $idHotel = Auth::user()->hotel_id;
        //$registros = Registro::where();
        $registros = Registro::where('estado','Ocupando')->whereHas('habitacione', function ($query) use ($idHotel){
            $query->whereHas('rpiso', function ($query) use ($idHotel){
                $query->where('hotel_id',$idHotel);
            });
        })->get();
        foreach ($registros as $registro){

            dd($registro->fecha_ingreso3);
            $fechas = $this->createDateRangeArray($registro->fecha_ingreso3,$fecha_actual);

        }
        dd($registros);
    }


    function createDateRangeArray($strDateFrom,$strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.

        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange=array();

        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

        if ($iDateTo>=$iDateFrom)
        {
            array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            }
        }
        return $aryRange;
    }

}