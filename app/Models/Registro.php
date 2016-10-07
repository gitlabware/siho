<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use DB;

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
        'user_id',
        'grupo_id',
        'equipaje',
        'fech_ini_reserva',
        'fech_fin_reserva'
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

    public function getFechaIngreso2Attribute()
    {
        $value = $this->fecha_ingreso;

        //dd($this->habitacione_id);
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            //dd($value);
            $fecha = Carbon::parse($value);
            return $fecha->format('d/m/Y H:m:i');
        } else {
            return null;
        }
    }
    public function getFechaIngreso3Attribute()
    {
        $value = $this->fecha_ingreso;

        //dd($this->habitacione_id);
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            //dd($value);
            $fecha = Carbon::parse($value);
            return $fecha->format('Y-m-d');
        } else {
            return null;
        }
    }

    /*public function getFechaIngresoAttribute($value)
    {
        //dd($this->habitacione_id);
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            $fecha = Carbon::parse($value);
            return $fecha->format('d/m/Y H:m:i');
        } else {
            return null;
        }
    }*/

    public function getFechaSalidaAttribute($value)
    {
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            $fecha = Carbon::parse($value);
            return $fecha->format('d/m/Y H:m:i');
        } else {
            return null;
        }
    }

    public function getFechIniReserva2Attribute()
    {
        $value = $this->fech_ini_reserva;
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            $fecha = Carbon::parse($value);
            return $fecha->format('d/m/Y H:m:i');
        } else {
            return null;
        }
    }
    public function getFechFinReserva2Attribute()
    {
        $value = $this->fech_fin_reserva;
        if (!empty($value) && "0000-00-00 00:00:00" != $value) {
            $fecha = Carbon::parse($value);
            return $fecha->format('d/m/Y H:m:i');
        } else {
            return null;
        }
    }
    public function habitacione(){
        return $this->belongsTo('\App\Models\Habitaciones');
    }
    public function user(){
        return $this->belongsTo('\App\User');
    }


    public function hospedantes(){
        return $this->hasMany('\App\Hospedante','registro_id');
    }

    public function pagos(){
        return $this->hasMany('\App\Pago','registro_id');
    }

    public function grupo(){
        return $this->belongsTo('\App\Grupo','grupo_id');
    }

    public function getDeudasAttribute()
    {
        $deuda = DB::table('pagos')
            ->leftJoin('registros', 'pagos.registro_id', '=', 'registros.id')
            ->select(DB::raw('SUM(pagos.monto_total) as monto_total'))
            ->where('registros.id', '=', $this->id)
            ->whereIn('pagos.estado',['Deuda','Deuda Extra'])
            ->groupBy('registros.grupo_id')
            ->first();
        if(isset($deuda)){
            return $deuda->monto_total;
        }else{
            return 0.00;
        }
    }
}
