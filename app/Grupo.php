<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Grupo extends Model
{
    //
    /*public function registros(){
        return $this->hasMany('\App\Models\Registro','grupo_id');
    }*/
    public function getDeudasAttribute()
    {

        $deuda = DB::table('pagos')
            ->leftJoin('registros', 'pagos.registro_id', '=', 'registros.id')
            ->select(DB::raw('SUM(pagos.monto_total) as monto_total'))
            ->where('registros.grupo_id', '=', $this->id)
            ->whereIn('pagos.estado',['Deuda','Deuda Extra'])
            ->groupBy('registros.grupo_id')
            ->first();
        return $deuda->monto_total;

    }
}