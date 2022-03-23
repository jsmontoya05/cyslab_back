<?php

namespace App\Repositories;

use App\Models\Laboratory;
use App\Repositories\BaseRepository;

/**
 * Class LaboratoryRepository
 * @package App\Repositories
 * @version March 26, 2021, 4:30 pm UTC
*/

class LaboratoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Laboratory::class;
    }
}
