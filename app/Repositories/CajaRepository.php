<?php

namespace App\Repositories;

use App\Models\Caja;
use InfyOm\Generator\Common\BaseRepository;

class CajaRepository extends BaseRepository
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
        return Caja::class;
    }
}
