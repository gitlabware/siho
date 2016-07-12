<?php

namespace App\Repositories;

use App\Models\Precioshabitaciones;
use InfyOm\Generator\Common\BaseRepository;

class PrecioshabitacionesRepository extends BaseRepository
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
        return Precioshabitaciones::class;
    }
}
