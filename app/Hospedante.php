<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Hospedante extends Model
{
    //
    public function cliente(){
        return $this->belongsTo('\App\Models\Clientes','cliente_id');
    }
    public function registro(){
        return $this->belongsTo('\App\Models\Registro','registro_id');
    }

    public function getDiaIngresoAttribute()
    {
        $value = $this->fecha_ingreso;
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            $fecha = Carbon::parse($value);
            return $fecha->format('d');
        } else {
            return null;
        }
    }
    public function getMesIngresoAttribute()
    {
        $value = $this->fecha_ingreso;
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            $fecha = Carbon::parse($value);
            return $fecha->format('m');
        } else {
            return null;
        }
    }
    public function getAnoIngresoAttribute()
    {
        $value = $this->fecha_ingreso;
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            $fecha = Carbon::parse($value);
            return $fecha->format('y');
        } else {
            return null;
        }
    }
}