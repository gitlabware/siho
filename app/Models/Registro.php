<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * @SWG\Definition(
 *      definition="Registro",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="cliente_id",
 *          description="cliente_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="habitacione_id",
 *          description="habitacione_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="estado",
 *          description="estado",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="observacion",
 *          description="observacion",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="precio",
 *          description="precio",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="monto_total",
 *          description="monto_total",
 *          type="number",
 *          format="float"
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
class Registro extends Model
{
    use SoftDeletes;

    public $table = 'registros';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'cliente_id',
        'habitacione_id',
        'estado',
        'fecha_ingreso',
        'fecha_salida',
        'observacion',
        'precio',
        'monto_total',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'cliente_id' => 'integer',
        'habitacione_id' => 'integer',
        'estado' => 'string',
        'observacion' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function cliente()
    {
        return $this->belongsTo('\App\Models\Clientes');
    }


    public function getFechaIngresoAttribute($value)
    {
        $fecha = Carbon::parse($value);
        return $fecha->format('d/m/Y');
    }

    public function getFechaSalidaAttribute($value)
    {
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            $fecha = Carbon::parse($value);
            return $fecha->format('d/m/Y');
        } else {
            return null;
        }
    }

}
