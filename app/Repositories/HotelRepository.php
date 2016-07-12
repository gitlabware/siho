<?php

namespace App\Repositories;

use App\Models\Hotel;
use InfyOm\Generator\Common\BaseRepository;

class HotelRepository extends BaseRepository
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
        return Hotel::class;
    }
}
