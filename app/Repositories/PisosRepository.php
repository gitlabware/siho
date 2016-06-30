<?php

namespace App\Repositories;

use App\Models\Pisos;
use InfyOm\Generator\Common\BaseRepository;

class PisosRepository extends BaseRepository
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
        return Pisos::class;
    }
}
