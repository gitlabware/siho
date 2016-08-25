<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Habitaciones",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="hotel_id",
 *          description="hotel_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="piso",
 *          description="piso",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="nombre",
 *          description="nombre",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="estado",
 *          description="estado",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="observaciones",
 *          description="observaciones",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Habitaciones extends Model
{
    use SoftDeletes;

    public $table = 'habitaciones';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'piso_id',
        'camas',
        'piso',
        'nombre',
        'estado',
        'observaciones',
        'categoria_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        //'piso_id' => 'integer',
        'nombre' => 'string',
        'estado' => 'string',
        'observaciones' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];


    public function rpiso(){
        //return $this->belongsTo('\App\Models\Pisos');
        return $this->belongsTo('\App\Models\Pisos', 'piso_id');
    }
    public function categoria(){
        //return $this->belongsTo('\App\Models\Pisos');
        return $this->belongsTo('\App\Models\Categoria', 'categoria_id');
    }

    /*public function registro(){
        return $this->belongsTo('\App\Models\Registro');
    }*/
    public function rprecios(){
        return $this->hasMany('\App\Models\Precioshabitaciones','habitacione_id');
    }

    /*public function registros(){
        return $this->hasMany('\App\Models\Registro','habitacione_id');
    }*/

    public function registrosactivos(){
        return $this->hasMany('\App\Models\Registro','habitacione_id')->whereIn('estado', ['Ocupando','Reservado']);

    }
    public function GetEstaocupadoAttribute(){
        $estadoo = $this->hasMany('\App\Models\Registro','habitacione_id')->where('estado', 'Ocupando')->first();
        if(isset($estadoo)){
            return true;
        }else{
            return false;
        }
    }
    public function GetEstareservadoAttribute(){
        $estadoo = $this->hasMany('\App\Models\Registro','habitacione_id')->where('estado', 'Reservado')->first();
        if(isset($estadoo)){
            return true;
        }else{
            return false;
        }
    }

}
