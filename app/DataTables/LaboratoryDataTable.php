<?php

namespace App\DataTables;

use App\Models\Laboratory;
use App\Services\LaboratoryService;

/**
 * Class LaboratoryDataTable
 */
class LaboratoryDataTable
{
    private $laboratoryService;

    public function __construct(LaboratoryService $labService)
    {
        $this->laboratoryService = $labService;
    }
    /**
     * @return Laboratory
     */
    public function get()
    {
        /** @var Laboratory $query */
        //$query = Laboratory::query()->select('laboratories.*');

        return $this->laboratoryService->obtainLaboratories('');
    }
}
