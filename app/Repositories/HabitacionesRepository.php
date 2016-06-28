<?php

namespace App\Repositories;

use App\Models\Habitaciones;
use InfyOm\Generator\Common\BaseRepository;

class HabitacionesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Habitaciones::class;
    }
}
