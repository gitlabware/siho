<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Clientes",
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
 *          property="nacionalidad",
 *          description="nacionalidad",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="edad",
 *          description="edad",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="procedencia",
 *          description="procedencia",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="profesion",
 *          description="profesion",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="pasaporte",
 *          description="pasaporte",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="ci",
 *          description="ci",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="celular",
 *          description="celular",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="referencia",
 *          description="referencia",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="estado",
 *          description="estado",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="direccion",
 *          description="direccion",
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
class Clientes extends Model
{
    use SoftDeletes;

    public $table = 'clientes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'nombre',
        'nacionalidad',
        'edad',
        'procedencia',
        'profesion',
        'pasaporte',
        'ci',
        'celular',
        'referencia',
        'estado',
        'direccion',
        'observaciones',
        'deleted_at',
        'ruser_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre' => 'string',
        'nacionalidad' => 'string',
        'edad' => 'date',
        'procedencia' => 'string',
        'profesion' => 'string',
        'pasaporte' => 'string',
        'ci' => 'string',
        'celular' => 'string',
        'referencia' => 'string',
        'estado' => 'string',
        'direccion' => 'string',
        'observaciones' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required'
    ];
}
