<?php

namespace App\Repositories;

use App\Models\Actividad;
use InfyOm\Generator\Common\BaseRepository;

class ActividadRepository extends BaseRepository
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
        return Actividad::class;
    }
}
