<?php

declare(strict_types=1);

namespace App\UsesCase\LabAccount;

use App\Services\LabAccountService;
use Illuminate\Support\Facades\Log;

final class CreateLabAccountUseCase
{
    private LabAccountService $labAccountService;

    public function __construct(LabAccountService $labAccountService)
    {
        $this->labAccountService = $labAccountService;
    }

    public function execute(String $labAccountName)
    {
        $response = $this->labAccountService->createLabAccount($labAccountName);

        if ($response) {
            Log::debug($response);
        }

        return $response;
    }
}
