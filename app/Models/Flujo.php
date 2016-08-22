<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Flujo",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="ingreso",
 *          description="ingreso",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="salida",
 *          description="salida",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="detalle",
 *          description="detalle",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="observacion",
 *          description="observacion",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="flujo_id",
 *          description="flujo_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
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
class Flujo extends Model
{
    use SoftDeletes;

    public $table = 'flujos';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'ingreso',
        'salida',
        'detalle',
        'observacion',
        'flujo_id',
        'user_id',
        'caja_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'detalle' => 'string',
        'observacion' => 'string',
        'flujo_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function caja(){
        return $this->belongsTo('\App\Models\Caja');
    }

    public function registros(){
        return $this->hasMany('App\Models\Registro','flujo_id');
    }
}


