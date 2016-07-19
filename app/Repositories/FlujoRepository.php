<?php

namespace App\Repositories;

use App\Models\Flujo;
use InfyOm\Generator\Common\BaseRepository;

class FlujoRepository extends BaseRepository
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
        return Flujo::class;
    }
}
