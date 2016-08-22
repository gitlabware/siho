<?php

namespace App\Repositories;

use App\Models\Categoria;
use InfyOm\Generator\Common\BaseRepository;

class CategoriaRepository extends BaseRepository
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
        return Categoria::class;
    }
}
