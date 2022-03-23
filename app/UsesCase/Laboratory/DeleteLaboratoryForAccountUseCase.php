<?php

declare(strict_types=1);

namespace App\UsesCase\Laboratory;

use App\Services\LaboratoryService;
use Illuminate\Support\Facades\Log;

final class DeleteLaboratoryForAccountUseCase
{
    private LaboratoryService $laboratoryService;

    public function __construct(LaboratoryService $laboratoryService)
    {
        $this->laboratoryService = $laboratoryService;
    }

    public function execute(String $labAccountName,$data)
    {
        $response = $this->laboratoryService->deleteLaboratory($labAccountName,$data);
        return $response;
    }
}
