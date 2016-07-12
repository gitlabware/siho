<?php

namespace App\Repositories;

use App\Models\Estudiantes;
use InfyOm\Generator\Common\BaseRepository;

class EstudiantesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Estudiantes::class;
    }
}
