<?php

namespace App\Repositories;

use App\Models\Registro;
use InfyOm\Generator\Common\BaseRepository;

class RegistroRepository extends BaseRepository
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
        return Registro::class;
    }
}
