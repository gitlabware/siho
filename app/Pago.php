<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    //
    public function registro(){
        //return $this->belongsTo('\App\Models\Pisos');
        return $this->belongsTo('\App\Models\Registro', 'registro_id');
    }
}
