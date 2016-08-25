<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Pisos",
 *      required={nombre},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
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
class Pisos extends Model
{
    use SoftDeletes;

    public $table = 'pisos';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'hotel_id',
        'nombre',
        'estado',
        'observaciones'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
   /* protected $casts = [
        'nombre' => 'string',
        'estado' => 'string'
    ];*/

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required'
    ];

    public function habitaciones(){
        //return $this->hasMany('\App\Models\Habitaciones','foreign_key', 'hotel_id');
        return $this->hasMany('\App\Models\Habitaciones','piso_id');
    }
    public function hotel(){
        return $this->belongsTo('\App\Models\Hotel');
    }
}
