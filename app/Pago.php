<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pago extends Model
{
    public function getFecha2Attribute()
    {
        $value = $this->fecha;
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            $fecha = Carbon::parse($value);
            return $fecha->format('d/m/Y');
        } else {
            return null;
        }
    }
    public function getModificadoAttribute()
    {
        $value = $this->updated_at;
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            $fecha = Carbon::parse($value);
            return $fecha->format('d/m/Y');
        } else {
            return null;
        }
    }
    //
    public function registro(){
        //return $this->belongsTo('\App\Models\Pisos');
        return $this->belongsTo('\App\Models\Registro', 'registro_id');
    }
}
