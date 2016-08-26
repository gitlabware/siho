<?php

namespace App\Repositories;

use App\Models\Factura;
use InfyOm\Generator\Common\BaseRepository;

class FacturaRepository extends BaseRepository
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
        return Factura::class;
    }
}
