<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Hospedante extends Model
{
    //
    public function cliente(){
        return $this->belongsTo('\App\Models\Clientes','cliente_id');
    }

}
