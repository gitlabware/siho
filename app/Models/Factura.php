<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Factura",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="codigo_control",
 *          description="codigo_control",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="cliente",
 *          description="cliente",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="nit",
 *          description="nit",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="nit_p",
 *          description="nit_p",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="importetotal",
 *          description="importetotal",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="fecha",
 *          description="fecha",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="fecha_limite",
 *          description="fecha_limite",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="numero",
 *          description="numero",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="autorizacion",
 *          description="autorizacion",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="qr",
 *          description="qr",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="montoliteral",
 *          description="montoliteral",
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
class Factura extends Model
{
    use SoftDeletes;

    public $table = 'facturas';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'codigo_control',
        'cliente',
        'nit',
        'nit_p',
        'importetotal',
        'fecha',
        'fecha_limite',
        'numero',
        'autorizacion',
        'qr',
        'montoliteral',
        'created'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'codigo_control' => 'string',
        'cliente' => 'string',
        'nit' => 'string',
        'nit_p' => 'string',
        'fecha' => 'date',
        'fecha_limite' => 'date',
        'numero' => 'integer',
        'autorizacion' => 'integer',
        'qr' => 'string',
        'montoliteral' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}
