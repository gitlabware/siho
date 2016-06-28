<?php

namespace App\Repositories;

use App\Models\Clientes;
use InfyOm\Generator\Common\BaseRepository;

class ClientesRepository extends BaseRepository
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
        return Clientes::class;
    }
}
